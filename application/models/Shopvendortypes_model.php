<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopvendortypes_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $typeId;
        public $active;

        private $table = 'tbl_shop_vendor_types';

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
            if (isset($data['vendorId']) && isset($data['typeId']) && isset($data['active'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['typeId']) && !Validate_data_helper::validateInteger($data['typeId'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;

            return true;
        }

        public function updateVendorTypes(array $selectedTypes = []): bool
        {
            $vendorTypes = $this->selectVendorTypes();
            foreach ($vendorTypes as $type) {
                $this->id = intval($type['id']);
                $this->active = (isset($selectedTypes[$type['id']])) ? '1' : '0';
                if (!$this->update()) return false;
            }
            return true;
        }

        private function selectVendorTypes(): array
        {
            $query = 'SELECT id FROM ' . $this->table . ' WHERE vendorId = ' . $this->vendorId . ';';
            $result = $this->db->query($query);
            return $result->result_array();
        }

        public function fetchActiveVendorTypes(): array
        {
            $query = 'SELECT typeId FROM ' . $this->table . ' WHERE vendorId = ' . $this->vendorId . ' AND active = "1";';
            $result = $this->db->query($query);
            $result = $result->result_array();
            $typeIds = [];

            foreach ($result as $type) {
                array_push($typeIds, intval($type['typeId']));
            }

            return  $typeIds;
        }

    }
