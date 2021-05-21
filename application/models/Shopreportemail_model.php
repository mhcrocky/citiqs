<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopreportemail_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $reportId;
        public $email;
        

        private $table = 'tbl_shop_reports_emails';

        protected function getThisTable(): string
        {
            return $this->table;
        }

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'reportId') {
                $value = intval($value);
            }
            return;
        }

        public function insertValidate(array $data): bool
        {
            if (isset($data['reportId']) && isset($data['email'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->config('custom');

            if (!count($data)) return false;

            if (isset($data['reportId']) && !Validate_data_helper::validateInteger($data['reportId'])) return false;
            if (isset($data['email']) && !Validate_data_helper::validateEmail($data['email'])) return false;

            return true;
        }

        public function saveEmails(array $emails): bool
        {
            $this->deleteEmails();
            foreach ($emails as $email) {
                $email = trim($email);
                if (!$this->setproperty('email', $email)->create()) {
                    $this->deleteEmails();
                    return false;
                }
            }

            return true;
        }

        private function deleteEmails(): bool
        {
            $where = [
                $this->table . '.reportId' => $this->reportId
            ];

            return $this->customDelete($where);
        }
    }
