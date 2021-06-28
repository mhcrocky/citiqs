<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Campaignlist_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {

        public $id;
        public $listId;
        public $campaignId;

        private $table = 'tbl_campaigns_lists';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'listId' || $property === 'campaignId') {
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
            if (isset($data['listId']) && isset($data['campaignId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->helper('validate_data_helper');
            if (!count($data)) return false;
            if (isset($data['listId']) && !Validate_data_helper::validateInteger($data['listId'])) return false;
            if (isset($data['campaignId']) && !Validate_data_helper::validateInteger($data['campaignId'])) return false;

            return true;
        }

        /**
         * checkIsExists
         *
         * This method checks is already inserted row with this listId and campaignId
         *
         * @see AbstractCrud_model::readImproved
         * @return boolean
         */
        private function checkIsExists(): bool
        {
            $id = $this->readImproved([
                'what' => [$this->table. '.id'],
                'where' => [
                    $this->table. '.listId' => $this->listId,
                    $this->table. '.campaignId' => $this->campaignId,
                ]
            ]);

            return !is_null($id);
        }

        /**
         * insertCampaignList
         *
         * Method inserts new campaign list for vendor.
         * $data = [
         *      'listId' => $listId,            // mandatory
         *      'campaignId' => $campaignId     // mandatory
         * ]
         *
         * @see Emaillist_model::checkIsExists
         * @see AbstractSet_model::setObjectFromArray
         * @see AbstractCrud_model::create
         * @access public
         * @param array $data
         * @return boolean
         */
        public function insertCampaignList(array $data): bool
        {
            $this->setObjectFromArray($data);

            return $this->checkIsExists() ? false : $this->create();
        }


        /**
         * deleteCampaign
         *
         * Method deletes campaignId.
         * $this->campaignId MUST be set. See $this->setProperty($key, $value), it is defined in application/abstract/AbstractSet_model.php
         *
         * @see AbstractCrud_model::customDelete
         * @return boolean
         */
        public function deleteCampaign(): bool
        {
            $where = [
                $this->table . '.campaignId' => $this->campaignId
            ];

            return $this->customDelete($where);
        }

        /**
         * deleteListFromCampaign
         *
         * Method delets list
         * $this->id MUST be set. See $this->setObjectId($id)), it is defined in application/abstract/AbstractSet_model.php
         *
         * @see AbstractCrud_model::delete
         * @return boolean
         */
        public function deleteListFromCampaign(): bool
        {
            return $this->delete();
        }

        /**
         * getCampaignLists
         *
         * Method returns campaign's lists.
         * $this->campaignId MUST be set. See $this->setProperty($key, $value), it is defined in application/abstract/AbstractSet_model.php
         *
         * @param array $where
         * @see AbstractCrud_model::readImproved
         * @return array|null
         */
        public function getCampaignLists(array $where = []): ?array
        {
            $where[$this->table . '.campaignId'] = $this->campaignId;
            return $this->readImproved([
                'what' => [
                     $this->table . '.id',
                    'tbl_campaigns.id AS campaignId',
                    'tbl_campaigns.campaign AS campaignName',
                    'tbl_campaigns.description AS campaignDescription',
                    'tbl_campaigns.active AS campaignActive',
                    'tbl_lists.id AS listId',
                    'tbl_lists.list AS list',
                    'tbl_lists.active AS listActive',
                ],
                'where' => $where,
                'joins' => [
                    ['tbl_campaigns', 'tbl_campaigns.id = ' . $this->table . '.campaignId', 'INNER'],
                    ['tbl_lists', 'tbl_lists.id = ' . $this->table . '.listId', 'INNER'],
                ]
            ]);
        }
    }
