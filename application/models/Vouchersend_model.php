<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    


    Class Vouchersend_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $name;
        public $email;
        public $send;
        public $datecreated;
        public $voucherId;

        private $table = 'tbl_vouchersend';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'send' || $property === 'voucherId') {
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
            if (isset($data['name']) && isset($data['email']) && isset($data['voucherId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['name']) && !Validate_data_helper::validateString($data['name'])) return false;
            if (isset($data['email']) && !Validate_data_helper::validateString($data['email'])) return false;
            if (isset($data['send']) && !Validate_data_helper::validateInteger($data['send'])) return false;
            if (isset($data['voucherId']) && !Validate_data_helper::validateInteger($data['voucherId'])) return false;
            return true;
        }

        
        
    }
