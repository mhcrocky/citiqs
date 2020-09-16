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
        public $productImage;
        public $dateTimeFrom;
        public $dateTimeTo;
        public $orderNo;
        public $onlyOne;
        public $addRemark;
        public $allergies;

        private $table = 'tbl_shop_products';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateInteger($value)) return;

            if (
                $property === 'id'
                || $property === 'categoryId'
                || $property === 'stock'
                || $property === 'recommendedQuantity'
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
                isset($data['categoryId'])
                // && isset($data['recommendedQuantity']) 
                && isset($data['active'])
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
            if (isset($data['dateTimeFrom']) && !Validate_data_helper::validateDate($data['dateTimeFrom'])) return false;
            if (isset($data['dateTimeTo']) && !Validate_data_helper::validateDate($data['dateTimeTo'])) return false;
            if (isset($data['orderNo']) && !Validate_data_helper::validateInteger($data['orderNo'])) return false;
            if (isset($data['productImage']) && !Validate_data_helper::validateString($data['productImage'])) return false;
            if (isset($data['onlyOne']) && !($data['onlyOne'] === '1' || $data['onlyOne'] === '0')) return false;
            if (isset($data['addRemark']) && !($data['addRemark'] === '1' || $data['addRemark'] === '0')) return false;
            if (isset($data['allergies']) && !Validate_data_helper::validateString($data['allergies'])) return false;

            return true;
        }

        public function getUserProducts(int $userId): ?array
        {
            return
                $this->read(
                    [
                        $this->table. '.id AS productId',
                    ],
                    ['tbl_shop_categories.userId=' => $userId],
                    [
                        ['tbl_shop_categories', $this->table.'.categoryId = tbl_shop_categories.id', 'LEFT'],
                    ]
                );
        }

        public function uploadImage(): bool
        {
            $this->load->config('custom');
            $this->load->helper('uploadfile_helper');

            $this->productImage = $this->id . '_' . strval(time()) . '.' . Uploadfile_helper::getFileExtension($_FILES['productImage']['name']);
            $constraints = [
                'allowed_types'=> 'jpg|png|jpeg'
            ];
            $sizeConstraints = [
                'maxWidth' => 200,
                'maxHeight' => 200,
            ];
            $_FILES['productImage']['name'] = $this->productImage;
            if (Uploadfile_helper::uploadFiles($this->config->item('uploadProductImageFolder'), $constraints, true, $sizeConstraints)) {
                return $this->update();
            }
            return false;
        }

    }
