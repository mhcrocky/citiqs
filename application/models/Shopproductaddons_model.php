<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopproductaddons_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $productId;
        public $productExtendedId;
        private $table = 'tbl_shop_products_addons';

        protected function setValueType(string $property,  &$value): void
        {
            if (
                $property === 'id'
                || $property === 'productId'
                || $property === 'productExtendedId'
            ) {
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
                isset($data['productExtendedId'])
                && isset($data['productExtendedId']) 
            ) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['productId']) && !Validate_data_helper::validateInteger($data['productId'])) return false;
            if (isset($data['productExtendedId']) && !Validate_data_helper::validateInteger($data['productExtendedId'])) return false;
            return true;
        }

        public function deleteProductAddons(): bool
        {

            $query = 'DELETE FROM ' . $this->table . ' WHERE productId = ' . $this->productId . ';';
            return $this->db->query($query);
        }
    }
