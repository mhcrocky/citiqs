<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopvisitorreservtaion_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $visitorId;
        public $checkStatus;
        public $created;
        private $table = 'tbl_shop_visitor_reservations';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'visitorId') {
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
            if (isset($data['visitorId']) && isset($data['checkStatus']) && isset($data['created'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['visitorId']) && !Validate_data_helper::validateInteger($data['visitorId'])) return false;
            if (isset($data['checkStatus']) && !($data['checkStatus'] === '1' || $data['checkStatus'] === '0')) return false;            
            if (isset($data['created']) && !Validate_data_helper::validateDate($data['created'])) return false;

            return true;
        }

        public function checkId(): bool
        {
            $count = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    'id=' => $this->id
                ]
            ]);
            return $count ? true : false;
        }
    }
