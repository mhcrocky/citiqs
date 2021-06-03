<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopprinters_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {

        public $id;
        public $userId;
        public $printer;
        public $macNumber;
        public $active;
        public $numberOfCopies;
        public $masterMac;
        public $archived;
        public $isFod;
        public $isFodHardLock;
        public $printReports;
        public $printReceipts;
        public $isApi;
        public $contactPhone;
        public $sendSmsToBuyer;
        public $messageToBuyer;


        private $table = 'tbl_shop_printers';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'userId' || $property === 'numberOfCopies') {
                $value = intval($value);
            }
            if ($property === 'price') {
                $value = floatval($value);
            }
            return;
        }

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function insertValidate(array $data): bool
        {
            if (isset($data['userId']) && isset($data['printer']) && isset($data['macNumber'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['userId']) && !Validate_data_helper::validateInteger($data['userId'])) return false;
            if (isset($data['printer']) && !Validate_data_helper::validateString($data['printer'])) return false;
            if (isset($data['macNumber']) && !Validate_data_helper::validateString($data['macNumber'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;
            if (isset($data['numberOfCopies']) 
                && (!Validate_data_helper::validateInteger($data['numberOfCopies']) || intval($data['numberOfCopies']) < 1)
            ) return false;
            if (isset($data['masterMac']) && !Validate_data_helper::validateStringImproved($data['masterMac'])) return false;
            if (isset($data['archived']) && !($data['archived'] === '1' || $data['archived'] === '0')) return false;
            if (isset($data['isFod']) && !($data['isFod'] === '1' || $data['isFod'] === '0')) return false;
            if (isset($data['isFodHardLock']) && !($data['isFodHardLock'] === '1' || $data['isFodHardLock'] === '0')) return false;
            if (isset($data['printReports']) && !($data['printReports'] === '1' || $data['printReports'] === '0')) return false;
            if (isset($data['printReceipts']) && !($data['printReceipts'] === '1' || $data['printReceipts'] === '0')) return false;
            if (isset($data['isApi']) && !($data['isApi'] === '1' || $data['isApi'] === '0')) return false;
            if (isset($data['contactPhone']) && !Validate_data_helper::validateStringImproved($data['contactPhone'])) return false;
            if (isset($data['sendSmsToBuyer']) && !($data['sendSmsToBuyer'] === '1' || $data['sendSmsToBuyer'] === '0')) return false;
            if (isset($data['messageToBuyer']) && !Validate_data_helper::validateStringImproved($data['messageToBuyer'])) return false;

            return true;
        }

        public function fetchtProductPrinters(int $productId): ?array
        {
            return $this->read(
                [
                    $this->table . '.id AS printerId',
                    $this->table . '.printer AS printer',
                    $this->table . '.active AS printerActive',
                    $this->table . '.isFod AS isFod',
                    $this->table . '.isFodHardLock AS isFodHardLock'
                ],
                [
                    'tbl_shop_product_printers.productId=' => $productId,
                    $this->table . '.archived' => "0",
                    $this->table . '.isApi' => "0",
                ],
                [
                    ['tbl_shop_product_printers', $this->table .'.id = tbl_shop_product_printers.printerId' ,'INNER']
                ]
            );
        }

        public function checkPrinterName(array $where): bool
        {
            $filter = [
                'what'  => ['id'],
                'where' => $where,
            ];
            return $this->readImproved($filter) ? true : false;
        }

        public function fetchPrinters(): ?array
        {
            $this->userId = $this->db->escape($this->userId);
            $query =
            '
                SELECT
                    tbl_shop_printers.*,
                    masters.printer as master
                FROM
                    tbl_shop_printers
                LEFT JOIN
                    (SELECT tbl_shop_printers.id, tbl_shop_printers.printer, tbl_shop_printers.masterMac, tbl_shop_printers.macNumber FROM tbl_shop_printers) masters ON masters.macNumber = tbl_shop_printers.masterMac
                WHERE
                    tbl_shop_printers.userId = ' . $this->userId . '
                    AND tbl_shop_printers.archived = "0"
                    AND tbl_shop_printers.isApi = "0"
                ORDER BY tbl_shop_printers.printer ASC;
            ';

            $result = $this->db->query($query);
            $result = $result->result_array();
            return $result ? $result : null;
        }

        /**
         * printMacNumber
         *
         * Returns masterMac if printer is slave status else return printer mac number
         * @return void
         */
        public function printMacNumber(): string
        {
            $masterMac = $this->readImproved([
                'what' => ['masterMac'],
                'where' => [
                    'macNumber' => $this->macNumber
                ]
            ]);

            // second condition is if user sets master mac number to 0
            return (empty($masterMac) || empty($masterMac[0]['masterMac'])) ? $this->macNumber : $masterMac[0]['masterMac'];
        }


        public function updateIsFod(array $where, string $newStatus): bool
        {
            if (!($newStatus === '1' || $newStatus === '0')) return false;
            $whereCond = [];

            foreach ($where as $key => $value) {
                $key = $this->table . '.' . $key;
                $whereCond[$key] = $value;
            }

            return $this->setProperty('isFod', $newStatus)->customUpdate($whereCond);
        }

        public function fetchUserIdFromMac(): ?int
        {
            $userId = $this->readImproved([
                'what' => ['userId'],
                'where' => [
                    'macNumber' => $this->macNumber
                ],
                'conditions' => [
                    'ORDER_BY' => [$this->table . '.id ASC'],
                    'LIMIT' => ['1']
                ]
            ]);

            if (is_null($userId)) return false;

            $userId = intval($userId[0]['userId']);

            return $userId;
        }

        public function checkPrinterReportes(): bool
        {
            $reportPrinters = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.userId' => $this->userId,
                    $this->table . '.printReports' => '1',
                ]
            ]);

            return $reportPrinters ? true : false;
        }

        public function getApiPrinterId(): ?int
        {
            $id = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.userId' => $this->userId,
                    $this->table . '.isApi' => '1',
                    $this->table . '.printer' => $this->config->item('api_printer'),
                ]
            ]);

            if (is_null($id)) {
                $insert = [
                    'userId' => $this->userId,
                    'active' => '1',
                    'printer' => $this->config->item('api_printer'),
                    'macNumber' => ('MAC NOT SET ' . $this->config->item('api_printer')),
                    'isApi' => '1'
                ];
                return $this->setObjectFromArray($insert)->create() ? $this->id : null;
            }

            $id = reset($id);
            $id = intval($id['id']);
            return $id;
        }

        public function checkIsPrinterActive(): bool
        {
            $active = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.active' => '1',
                    $this->table . '.macNumber' => $this->macNumber,
                ]
            ]);

            return !is_null($active);
        }

        public function checkIsPrintReports(): bool
        {
            $printReports = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.printReports' => '1',
                    $this->table . '.macNumber' => $this->macNumber,
                ]
            ]);

            return !is_null($printReports);
        }

        public function checkIsPrintReceipts(): bool
        {
            $printReports = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.printReceipts' => '1',
                    $this->table . '.macNumber' => $this->macNumber,
                ]
            ]);

            return !is_null($printReports);
        }

        public function insertInitialPrinter(): bool
        {
            $this->printer = 'Initial printer';
            $this->active = '1';

            return $this->create();
        }

        public function setPrinterIdFromMacNumber(string $macNumber): Shopprinters_model
        {
            $id = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.macNumber' => $macNumber,
                ]
            ]);

            if (!is_null($id)) {
                $this->id = intval(reset($id)['id']);
            }

            return $this;
        }

        
    }
