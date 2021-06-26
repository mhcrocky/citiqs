<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Emaillist_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {

        public $id;
        public $listId;
        public $emailId;

        private $table = 'tbl_emails_lists';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'listId' || $property === 'emailId') {
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
            if (isset($data['listId']) && isset($data['emailId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->helper('validate_data_helper');
            if (!count($data)) return false;
            if (isset($data['listId']) && !Validate_data_helper::validateInteger($data['listId'])) return false;
            if (isset($data['emailId']) && !Validate_data_helper::validateInteger($data['emailId'])) return false;

            return true;
        }

        /**
         * checkIsExists
         *
         * This method checks is already inserted row with this listId and emailId
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
                    $this->table. '.emailId' => $this->emailId,
                ]
            ]);

            return !is_null($id);
        }

        /**
         * insertEmailList
         *
         * Method inserts new email list for vendor.
         * $data = [
         *      'listId' => $listId,    // mandatory
         *      'emailId' => $emailId   // mandatory
         * ]
         *
         * @see Emaillist_model::checkIsExists
         * @see AbstractSet_model::setObjectFromArray
         * @see AbstractCrud_model::create
         * @access public
         * @param array $data
         * @return boolean
         */
        public function insertEmailList(array $data): bool
        {
            $this->setObjectFromArray($data);

            return $this->checkIsExists() ? false : $this->create();
        }


        /**
         * deleteList
         *
         * Method deletes list.
         * $this->listId MUST be set. See $this->setProperty($key, $value), it is defined in application/abstract/AbstractSet_model.php
         *
         * @see AbstractCrud_model::customDelete
         * @return boolean
         */
        public function deleteList(): bool
        {
            $where = [
                $this->table . '.listId' => $this->listId
            ];

            return $this->customDelete($where);
        }

        /**
         * deleteEmailFromList
         *
         * Method delets list
         * $this->id MUST be set. See $this->setObjectId($id)), it is defined in application/abstract/AbstractSet_model.php
         *
         * @see AbstractCrud_model::delete
         * @return boolean
         */
        public function deleteEmailFromList(): bool
        {
            return $this->delete();
        }

        /**
         * getListEmails
         *
         * Method returns emails on list.
         * $this->listId MUST be set. See $this->setProperty($key, $value), it is defined in application/abstract/AbstractSet_model.php
         * Argument $what is array with properties to fetch. It is not mandatory, by default is empty array
         *
         * @param array $what not mandatory, default is []
         * @see AbstractCrud_model::readImproved
         * @return array|null
         */
        public function getListEmails(array $what = []): ?array
        {
            if (empty($what)) {
                $what = [
                    'tbl_customer_emails.id AS customerEmailId',
                    'tbl_customer_emails.email AS customerEmail',
                    'tbl_customer_emails.name AS customerName',
                    'tbl_customer_emails.active AS customerActive',
                    'tbl_lists.id AS listId',
                    'tbl_lists.list AS list',
                    'tbl_lists.active AS listActive',
                ];
            }

            return $this->readImproved([
                'what' => $what,
                'where' => [
                    $this->table . '.listId' => $this->listId
                ],
                'joins' => [
                    ['tbl_customer_emails', 'tbl_customer_emails.id = ' . $this->table . '.emailId', 'INNER'],
                    ['tbl_lists', 'tbl_lists.id = ' . $this->table . '.listId', 'INNER'],
                ]
            ]);
        }


        /**
         * getActiveListEmails
         *
         * Method returns active emails on list.
         * $this->listId MUST be set. See $this->setProperty($key, $value), it is defined in application/abstract/AbstractSet_model.php
         * Argument $what is array with properties to fetch. It is not mandatory, by default is empty array
         *
         * @param array $what not mandatory, default is []
         * @see AbstractCrud_model::readImproved
         * @return array|null
         */
        public function getActiveListEmails(array $what = []): ?array
        {
            if (empty($what)) {
                $what = [
                    'tbl_customer_emails.id AS customerEmailId',
                    'tbl_customer_emails.email AS customerEmail',
                    'tbl_customer_emails.name AS customerName',
                    'tbl_lists.id AS listId',
                    'tbl_lists.list AS list',
                    'tbl_lists.active AS listActive',
                ];
            }

            return $this->readImproved([
                'what' => $what,
                'where' => [
                    $this->table . '.listId' => $this->listId,
                    'tbl_customer_emails.active' => '1'
                ],
                'joins' => [
                    ['tbl_customer_emails', 'tbl_customer_emails.id = ' . $this->table . '.emailId', 'INNER'],
                    ['tbl_lists', 'tbl_lists.id = ' . $this->table . '.listId', 'INNER'],
                ]
            ]);
        }
    }
