<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopposlogin_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $employeeId;
        public $login;
        public $logout;

        private $table = 'tbl_shop_pos_login';

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
            if (isset($data['employeeId']) && isset($data['login'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['employeeId']) && !Validate_data_helper::validateInteger($data['employeeId'])) return false;
            if (isset($data['login']) && !Validate_data_helper::validateDate($data['login'])) return false;
            if (isset($data['logout']) && !Validate_data_helper::validateDate($data['logout'])) return false;

            return true;
        }

        public function login(int $employeeId): bool
        {
            $insert = [
                'employeeId' => $employeeId,
                'login' => date('Y-m-d H:i:s')
            ];

            return $this->setObjectFromArray($insert)->create();
        }

        public function logout(): bool
        {
            $update = [
                'logout' => date('Y-m-d H:i:s')
            ];

            return $this->setObjectFromArray($update)->update();
        }
    }
