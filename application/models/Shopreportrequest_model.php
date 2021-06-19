<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopreportrequest_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $userId;
        public $report;
        public $printed;
        public $dateTimeFrom;
        public $dateTimeTo;
        public $created;
        public $updated;

        private $table = 'tbl_shop_report_requests';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'userId') {
                $value = intval($value);
            }
            return;
        }

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function insertValidate(array $data): bool
        {
            if (isset($data['userId']) && isset($data['report']) && isset($data['printed']) && isset($data['dateTimeFrom']) && isset($data['dateTimeTo'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->config('custom');

            if (!count($data)) return false;
            if (isset($data['userId']) && !Validate_data_helper::validateInteger($data['userId'])) return false;
            if (
                isset($data['report'])
                && !($data['report'] === $this->config->item('x_report') || $data['report'] === $this->config->item('z_report'))
            ) return false;
            if (isset($data['printed']) && !($data['printed'] === '1' || $data['printed'] === '0')) return false;
            if (isset($data['dateTimeFrom']) && !Validate_data_helper::validateDate($data['dateTimeFrom'])) return false;
            if (isset($data['dateTimeTo']) && !Validate_data_helper::validateDate($data['dateTimeTo'])) return false;
            return true;

        }

        public function checkRequests(string $printerMac): ?array
        {
            $data = $this->readImproved([
                'what' => [
                    $this->table . '.id',
                    $this->table . '.userId AS vendorid',
                    $this->table . '.report',
                    $this->table . '.dateTimeFrom AS datetimefrom', 
                    $this->table . '.dateTimeTo AS datetimeto',
                ],
                'where' => [
                    'tbl_shop_printers.macNumber' => $printerMac,
                    'tbl_shop_printers.printReports' => '1',
                    $this->table . '.printed =' => '0',
                ],
                'joins' => [
                    ['tbl_shop_printers', 'tbl_shop_printers.userId = ' . $this->table . '.userId', 'INNER']
                ],
                'conditions' => [
                    'ORDER_BY' => [$this->table . '.id ASC'],
                    'LIMIT' => ['1']
                ]
            ]);
            
            return is_null($data) ? null : reset($data);
        }

    }
