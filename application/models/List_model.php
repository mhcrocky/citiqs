<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class List_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {

        public $id;
        public $vendorId;
        public $list;
        public $active;

        private $table = 'tbl_lists';

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
            if (isset($data['vendorId']) && isset($data['list'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->helper('validate_data_helper');
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['list']) && !Validate_data_helper::validateStringImproved($data['list'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;
            return true;
        }

        private function mapProperties(array $data): List_model
        {
            foreach ($data as $key => $value) {
                $this->setValueType($key, $value);
                $this->{$key} = $value;
            }

            return $this;
        }

        private function checkIsListExists(): bool
        {
            $where = [
                $this->table . '.vendorId' => $this->vendorId,
                $this->table . '.list' => $this->list,
            ];

            if ($this->id) {
                $where[$this->table . '.id !='] = $this->id;
            }

            $id = $this->readImproved([
                'what' => ['id'],
                'where' => $where
            ]);

            return !is_null($id);
        }

        /**
         * insertList
         *
         * Method inserts new list for vendor.
         * $data = [
         *      'vendorId => $vendorIdValue,
         *      'list => listValue
         * ]
         *
         * @access public
         * @see List_model::mapProperties
         * @see List_model::checkIsListExists
         * @param array $data
         * @return boolean
         */
        public function insertList(array $data): bool
        {
            // first we check is list with name already exists for this vendor
            if ($this->mapProperties($data)->checkIsListExists()) return false;

            return $this->setObjectFromArray($data)->create();
        }


        /**
         * updateList
         *
         * Method updates list
         *
         * $data = [
         *      'vendorId => $vendorIdValue,    //mandatory field
         *      'list => listValue              //mandatory field
         * ]
         * $id row id in tbl_lists
         *
         * @see List_model::mapProperties
         * @see List_model::checkIsListExists
         * @param integer $id
         * @param array $data
         * @return boolean
         */
        public function updateList(int $id, array $data): bool
        {
            return ($this->setObjectId($id)->mapProperties($data)->checkIsListExists()) ? false : $this->update();
        }


        /**
         * getVendorLists
         *
         * Method fetches all vendor lists 
         * $this->vendorId must be set
         *
         * @return array|null
         */
        public function fetchVendorLists(): ?array
        {
            return $this->readImproved([
                'what' => [$this->table . '.*'],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId
                ]
            ]);
        }       

    }
