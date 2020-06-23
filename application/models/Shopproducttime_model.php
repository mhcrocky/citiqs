<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    Class Shopproducttime_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $productId;
        public $day;
        public $timeFrom;
        public $timeTo;
        private $table = 'tbl_shop_product_times';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'productId') {
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
            if (isset($data['productId']) && isset($data['day']) && isset($data['timeFrom']) && isset($data['timeTo'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['productId']) && !Validate_data_helper::validateInteger($data['productId'])) return false;
            if (isset($data['day']) && !(
                    $data['day'] === 'monday'
                    || $data['day'] === 'tuesday'
                    || $data['day'] === 'wednesday'
                    || $data['day'] === 'thursday'
                    || $data['day'] === 'friday'
                    || $data['day'] === 'saturday'
                    || $data['day'] === 'sunday'
                )) return false;
            return true;
        }

        public function deleteProductTimes(): void
        {
            $this->db->delete($this->table, array('productId' => $this->productId));
        }
    }
