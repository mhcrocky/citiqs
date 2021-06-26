<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');


    Class Campaign_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {

        public $id;
        public $vendorId;
        public $templateId;
        public $campaign;
        public $description;
        public $active;

        private $table = 'tbl_campaigns';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'vendorId' || $property === 'templateId') {
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
            if (isset($data['vendorId']) && isset($data['templateId']) && isset($data['campaign'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->helper('validate_data_helper');
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['templateId']) && !Validate_data_helper::validateInteger($data['templateId'])) return false;
            if (isset($data['campaign']) && !Validate_data_helper::validateString($data['campaign'])) return false;
            if (isset($data['description']) && !Validate_data_helper::validateStringImproved($data['description'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;

            return true;
        }


        /**
         * checkIsExists
         *
         * This method checks is campaign with set value already exists for vendor with venodrId
         * @see AbstractCrud_model::readImproved
         * @return boolean
         */
        private function checkIsExists(): bool
        {
            $where = [
                $this->table. '.vendorId' => $this->vendorId,
                $this->table. '.campaign' => $this->campaign,
            ];

            if (!is_null($this->id)) {
                $where[$this->table. '.id  !='] = $this->id;
            }

            $id = $this->readImproved([
                'what' => [$this->table. '.id'],
                'where' => $where
            ]);

            return !is_null($id);
        }

        /**
         * isVendorCampaign
         *
         * Method checks is this campaign belong to this vendor
         *
         * @see AbstractCrud_model::readImproved
         * @return boolean
         */
        private function isVendorCampaign(): bool
        {
            $id = $this->readImproved([
                'what' => [$this->table. '.id'],
                'where' => [
                    $this->table. '.vendorId' => $this->vendorId,
                    $this->table. '.id' => $this->id,
                ]
            ]);

            return !is_null($id);
        }

        /**
         * insertCampaign
         *
         * Method inserts new campaign for vendor.
         * $data = [
         *      'vendorId' => $vendorId,        // mandatory
         *      'campaign' => $campaign         // mandatory
         *      'templateId' => $templateId     // mandatory
         *      'description' => $description   // not mandatory
         *      'active' => $campaign           // not mandatory
         * ]
         *
         * @see Campaign_model::checkIsExists
         * @see AbstractSet_model::setObjectFromArray
         * @see AbstractCrud_model::create
         * @access public
         * @param array $data
         * @return boolean
         */
        public function insertCampaign(array $data): bool
        {
            $this->setObjectFromArray($data);
            return $this->checkIsExists() ? false : $this->create();
        }


        /**
         * updateCampaign
         *
         * Method updates campaign
         *
         * $data = [
         *      'vendorId' => $vendorId,        // mandatory
         *      'campaign' => $campaign         // not mandatory
         *      'templateId' => $templateId     // not mandatory
         *      'description' => $description   // not mandatory
         *      'active' => $campaign           // not mandatory
         * ]
         *
         * $this->id MUST be set. See $this->setObjectId($id)), it is defined in application/abstract/AbstractSet_model.php
         *
         * @see Campaign_model::checkIsExists
         * @see AbstractSet_model::setObjectFromArray
         * @see AbstractCrud_model::update
         * @param integer $id
         * @param array $data
         * @return boolean
         */
        public function updateCampaign(array $data): bool
        {
            $this->setObjectFromArray($data);
            return ($this->checkIsExists() || !$this->isVendorCampaign()) ? false : $this->update();
        }

        /**
         * fetchCampaigns
         *
         * Method fetches vendor's campaigns.
         * $this->vendorId MUST be set. See $this->setProperty($key, $value), it is defined in application/abstract/AbstractSet_model.php
         *
         * @see AbstractCrud_model::readImproved
         * @return array|null
         */
        public function fetchCampaigns(): ?array
        {
            return $this->readImproved([
                'what' => [$this->table . '.*'],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId
                ]
            ]);
        }
    }
