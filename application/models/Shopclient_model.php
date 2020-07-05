<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopclient_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $clientId;
        public $serviceFeePercent;
        public $serviceFeeAmount;
        public $paynlServiceId;

        private $table = 'tbl_shop_clients';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'clientId') {
                $value = intval($value);
            }
            if ($property === 'serviceFeePercent' || $property === 'serviceFeeAmount') {
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
            if (isset($data['clientId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['clientId']) && !Validate_data_helper::validateInteger($data['clientId'])) return false;
            if (isset($data['serviceFeePercent']) && !Validate_data_helper::validateFloat($data['serviceFeePercent'])) return false;
            if (isset($data['serviceFeeAmount']) && !Validate_data_helper::validateFloat($data['serviceFeeAmount'])) return false;
            if (isset($data['paynlServiceId']) && !Validate_data_helper::validateString($data['paynlServiceId'])) return false;

            
            return true;
        }

    }
