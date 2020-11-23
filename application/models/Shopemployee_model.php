<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopemployee_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $employeeId;
        public $inOutEmployee;
        public $inOutDateTime;
        public $processed;
        private $in = 'in';
        private $out = 'out';

        private $table = 'tbl_employee_inout';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'employeeId') {
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
            if (isset($data['employeeId']) && isset($data['inOutEmployee']) && isset($data['inOutDateTime'])  && isset($data['processed'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['employeeId']) && !Validate_data_helper::validateInteger($data['employeeId'])) return false;
            if (isset($data['inOutEmployee']) && !($data['inOutEmployee'] === $this->in || $data['inOutEmployee'] === $this->out)) return false;
            if (isset($data['inOutDateTime']) && !Validate_data_helper::validateDate($data['inOutDateTime'])) return false;
            if (isset($data['processed']) && !($data['processed'] === '1' || $data['processed'] === '0')) return false;
            return true;
        }

    }
