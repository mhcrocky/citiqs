<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

	Class Shopvendorfod_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
	{

		public $id;
        public $vendorId;
        public $lastNumber;

        private $table = 'tbl_vendor_fodnumber';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'vendorId' || $property === 'lastNumber') {
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
            if (isset($data['vendorId']) && isset($data['lastNumber'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['lastNumber']) && !Validate_data_helper::validateInteger($data['lastNumber'])) return false;

            return true;
        }

        public function isFodVendor(int $venodrId): bool
        {
            $result = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table. '.vendorId' => $venodrId,
                    $this->table. '.lastNumber>' => 0,
                ]
            ]);
            return !is_null($result);
        }

        // TO DO UPDATE AFTER GET FLAG IS VENDOR
        public function isBBVendor(int $venodrId): bool
        {
            $result = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table. '.vendorId' => $venodrId
                ]
            ]);
            return !is_null($result);
        }

    }
