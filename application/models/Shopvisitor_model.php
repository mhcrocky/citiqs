<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopvisitor_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $firstName;
        public $lastName;
        public $mobile;
        public $email;
        public $created;
        public $tableDescription;
        private $table = 'tbl_shop_visitors';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'vendorId') {
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
                && isset($data['firstName'])
                && isset($data['lastName'])
                && isset($data['mobile'])
                && isset($data['email'])
                && isset($data['created'])
                && isset($data['tableDescription'])
            ) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {

            if (!count($data)) return false;
            if (!Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (!Validate_data_helper::validateString($data['firstName'])) return false;
            if (!Validate_data_helper::validateString($data['lastName'])) return false;
            if (!Validate_data_helper::validateString($data['mobile'])) return false;
            if (!Validate_data_helper::validateEmail($data['email'])) return false;
            if (!Validate_data_helper::validateDate($data['created'])) return false;
            if (!Validate_data_helper::validateString($data['tableDescription'])) return false;
            return true;
        }

        public function setIdFromEmail(): Shopvisitor_model
        {
            
            if ($this->email) {
                
                $id = $this->readImproved([
                    'what' => ['id'],
                    'where' => [
                        'email' => $this->email
                    ]
                ]);
                if ($id) {
                    $this->id = intval(reset($id)['id']);    
                }
            }
            return $this;
        }

    }
