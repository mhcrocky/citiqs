<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopareaspot_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $areaId;
        public $spotId;

        private $table = 'tbl_shop_areas_spots';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'areaId' || $property === 'spotId') {
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
            if (isset($data['areaId']) && isset($data['spotId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['areaId']) && !Validate_data_helper::validateInteger($data['areaId'])) return false;
            if (isset($data['spotId']) && !Validate_data_helper::validateInteger($data['spotId'])) return false;
            return true;
        }

    }
