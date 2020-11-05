<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shophealth_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $reservationId;
        public $question1;
        public $question2;
        public $question3;
        public $question4;
        public $question5;
        public $question6;
        public $pass;

        private $table = 'tbl_shop_health_check';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'vendorId' || $property === 'reservationId') {
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
            if (
                isset($data['vendorId'])
                && isset($data['reservationId'])
                && isset($data['pass'])
            ) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {

            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['reservationId']) && !Validate_data_helper::validateInteger($data['reservationId'])) return false;
            if (isset($data['question1']) && !($data['question1'] === '1' || $data['question1'] === '0')) return false;
            if (isset($data['question2']) && !($data['question2'] === '1' || $data['question2'] === '0')) return false;
            if (isset($data['question3']) && !($data['question3'] === '1' || $data['question3'] === '0')) return false;
            if (isset($data['question4']) && !($data['question4'] === '1' || $data['question4'] === '0')) return false;
            if (isset($data['question5']) && !($data['question5'] === '1' || $data['question5'] === '0')) return false;
            if (isset($data['question6']) && !($data['question6'] === '1' || $data['question6'] === '0')) return false;
            if (isset($data['pass']) && !($data['pass'] === '1' || $data['pass'] === '0')) return false;
            return true;
        }

    }
