<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Customeremailsent_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {

        public $id;
        public $emailId;
        public $emailSent;
        public $campaign;

        private $table = 'tbl_customer_emails_sent';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'emailId') {
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
            if (isset($data['emailId']) && isset($data['emailSent'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;

            if (isset($data['emailId']) && !Validate_data_helper::validateInteger($data['emailId'])) return false;
            if (isset($data['campaign']) && !Validate_data_helper::validateStringImproved($data['campaign'])) return false;            
            if (isset($data['emailSent']) && !($data['emailSent'] === '1' || $data['emailSent'] === '0')) return false;

            return true;
        }

        public function getCampaign(int $vendorId, string $campaign): ?array
        {
            return $this->readImproved([
                'what' => [
                    $this->table . '.id AS sentEmailId',
                    $this->table . '.emailSent AS emailSent',
                    $this->table . '.campaign AS emailCampaign',
                    'tbl_customer_emails.id AS emailId',
                    'tbl_customer_emails.email AS customerEmail',
                ],
                'where' => [
                    $this->table . '.campaign' => $campaign,
                    'tbl_customer_emails.vendorId' => $vendorId,
                ],
                'joins' => [
                    ['tbl_customer_emails', 'tbl_customer_emails.id = ' . $this->table . '.emailId', 'INNER']
                ]
            ]);
        }
    }
