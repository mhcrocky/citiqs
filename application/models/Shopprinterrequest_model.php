<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopprinterrequest_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $printerId;
        public $conected;
        public $orderId;
        public $printerEcho;
        public $smsSent;
        private $table = 'tbl_shop_printer_requests';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'printerId' || $property === 'orderId') {
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

        public function insertPrinterRequest(string $macNumber): bool
        {
            $query  = 'INSERT INTO ' . $this->table . ' (printerId) ';
            $query .= 'SELECT id FROM tbl_shop_printers WHERE macNumber = "' . $macNumber . '";';
            $this->db->query($query);

            $this->id = $this->db->insert_id();
            return  $this->id ? true : false;
        }

        public function insertValidate(array $data): bool
        {
            if (isset($data['printerId']) && isset($data['conected'])) {
                return $this->updateValidate($data);
            }
            return false;;

        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['printerId']) && !Validate_data_helper::validateInteger($data['printerId'])) return false;
            if (isset($data['conected']) && !Validate_data_helper::validateDate($data['conected'])) return false;
            if (isset($data['orderId']) && !Validate_data_helper::validateInteger($data['orderId'])) return false;
            if (isset($data['printerEcho']) && !Validate_data_helper::validateDate($data['printerEcho'])) return false;
            if (isset($data['smsSent']) && !($data['smsSent'] === '0' || $data['smsSent'] === '1')) return false;
            return true;
        }

        public function checkIsPrinterConnected(): bool
        {
            $where = [
                $this->table . '.printerId = ' => $this->printerId,
                $this->table . '.conected >= ' => $this->conected,
            ];

            if ($this->smsSent) {
                $where[$this->table . '.smsSent'] = $this->smsSent;
            }

            $connected = $this->readImproved([
                'what'  => ['id'],
                'where' => $where,
                'conditions' => [
                    'LIMIT'=> ['1']
                ]
            ]);
            return !is_null($connected);
        }

        private function getPrinters(): ?array
        {
            $day = date('D', strtotime(date('Y-m-d H:i:s')));
            $time = date('H:i:s');

            $printers = $this->readImproved([
                'what' => [
                    'DISTINCT(' . $this->table . '.printerId) printerId',
                    'tbl_shop_printers.contactPhone contactPhone',
                    'tbl_shop_printers.printer printer',
                ],
                'where' => [
                    'tbl_shop_printers.active' => '1',
                    'tbl_shop_printers.contactPhone !=' => NULL,
                    'tbl_shop_vendor_times.day' => $day,
                    'tbl_shop_vendor_times.timeFrom<=' => $time,
                    'tbl_shop_vendor_times.timeTo>' => $time,
                    'tbl_shop_spots.active' => '1',
                    'tbl_shop_spot_times.day' => $day,
                    'tbl_shop_spot_times.timeFrom<=' => $time,
                    'tbl_shop_spot_times.timeTo>' => $time,
                ],
                'joins' => [
                    ['tbl_shop_printers', 'tbl_shop_printers.id = ' . $this->table . '.printerId', 'INNER'],
                    ['tbl_user', 'tbl_user.id = tbl_shop_printers.userId', 'INNER'],
                    ['tbl_shop_vendor_times', 'tbl_shop_vendor_times.vendorId = tbl_user.id', 'INNER'],
                    ['tbl_shop_spots', 'tbl_shop_spots.printerId = tbl_shop_printers.id', 'INNER'],
                    ['tbl_shop_spot_times', 'tbl_shop_spot_times.spotId = tbl_shop_spots.id', 'INNER']
                ]
            ]);

            if (is_null($printers)) return null;

            return $printers;
        }

        public function sendSmsAlert(): void
        {
            $printers = $this->getPrinters();

            if (is_null($printers)) return;

            $this->load->helper('curl_helper');

            foreach ($printers as $printer) {
                $connected = $this
                                ->setProperty('printerId', $printer['printerId'])
                                ->setProperty('conected', date('Y-m-d H:i:s', strtotime('-5 minutes')))
                                ->checkIsPrinterConnected();

                if (!$connected) {
                	// something to correct here
                    // $this->sentSms($printer);
                }
            }
        }

        private function sentSms(array $printer): void
        {
            $message = 'Printer "' . $printer['printer'] . '" with id "' . $printer['printerId'] . '" is not connected';
            if (Curl_helper::sendSmsNew($printer['contactPhone'], $message)) {
                $insert = [
                    'printerId' => $printer['printerId'],
                    'conected' => date('Y-m-d H:i:s'),
                    'smsSent' => '1',
                ];
                $this->shopprinterrequest_model->setObjectFromArray($insert)->create();
            }
        }
    }
