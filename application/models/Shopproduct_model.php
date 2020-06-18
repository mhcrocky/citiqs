<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopproduct_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $categoryId;
        public $stock;
        public $recommendedQuantity;
        public $active;
        public $showImage;
        public $vatpercentage; // 1) WE ADD PROPERTY NAME, NAME IS THE SAME LIKE COLUM NAME IN TABLE
        public $dateTimeFrom;
        public $dateTimeTo;
        private $table = 'tbl_shop_products';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'categoryId' || $property === 'stock' || $property === 'recommendedQuantity') {
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
            if (
                isset($data['categoryId']) 
                // && isset($data['stock']) 
                // && isset($data['recommendedQuantity']) 
                && isset($data['active'])
                && isset($data['vatpercentage']) // 2) IF THIS FILED IS MANDATORY CHECK IS IT SEND
            ) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['categoryId']) && !Validate_data_helper::validateInteger($data['categoryId'])) return false;
            if (isset($data['stock']) && !Validate_data_helper::validateInteger($data['stock'])) return false;
            if (isset($data['recommendedQuantity']) && !Validate_data_helper::validateInteger($data['recommendedQuantity'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;
            if (isset($data['showImage']) && !($data['showImage'] === '1' || $data['showImage'] === '0')) return false;
            if (isset($data['vatpercentage']) && !Validate_data_helper::validateFloat($data['vatpercentage'])) return false; // 3) VALIDATE PROPERTY TYPE
            if (isset($data['dateTimeFrom']) && !Validate_data_helper::validateDate($data['dateTimeFrom'])) return false;
            if (isset($data['dateTimeTo']) && !Validate_data_helper::validateDate($data['dateTimeTo'])) return false;
            return true;
        }

    }
