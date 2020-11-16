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
        public $addonProductId;
        public $quantity;
        private $table = 'tbl_shop_products_addons';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if (
                $property === 'id'
                || $property === 'productId'
                || $property === 'productExtendedId'
                || $property === 'addonProductId'
                || $property === 'quantity'
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
                && isset($data['addonProductId']) 
                
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
            if (isset($data['addonProductId']) && !Validate_data_helper::validateInteger($data['addonProductId'])) return false;
            if (isset($data['quantity']) && !Validate_data_helper::validateInteger($data['quantity'])) return false;

            return true;
        }

        public function deleteProductAddons(): bool
        {

            $query = 'DELETE FROM ' . $this->table . ' WHERE productId = ' . $this->productId . ';';
            return $this->db->query($query);
        }

        public function updateProductExtendedId(int $oldExtendedId, int $newExtendedId): void
        {
            $query = 'UPDATE ' . $this->table . ' SET productExtendedId = ' . $newExtendedId . ' WHERE productExtendedId = ' . $oldExtendedId . ';';
            $this->db->query($query);
        }

        public function deleteAddon(): bool
        {

            $query = 'DELETE FROM ' . $this->table . ' WHERE addonProductId = ' . $this->addonProductId . ';';
            return $this->db->query($query);
        }
    }
