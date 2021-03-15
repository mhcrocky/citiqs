<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shoparea_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $area;

        private $table = 'tbl_shop_areas';

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
            if (isset($data['vendorId']) && isset($data['area'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['area']) && !Validate_data_helper::validateString($data['area'])) return false;
            return true;
        }

    }
