<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopproductex_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $productId;
        public $name;
        public $shortDescription;
        public $longDescription;
        public $price;
        public $image;
        public $options;
        public $addons;

        private $table = 'tbl_shop_products_extended';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'productId') {
                $value = intval($value);
            }
            if ($property === 'price') {
                $value = floatval($value);
            }
            return;
        }

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function insertValidate(array $data): bool
        {
            if (isset($data['productId']) && isset($data['name']) && isset($data['price'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['productId']) && !Validate_data_helper::validateInteger($data['productId'])) return false;
            if (isset($data['name']) && !Validate_data_helper::validateString($data['name'])) return false;
            if (isset($data['shortDescription']) && !Validate_data_helper::validateString($data['shortDescription'])) return false;
            if (isset($data['longDescription']) && !Validate_data_helper::validateString($data['longDescription'])) return false;
            if (isset($data['price']) && !Validate_data_helper::validateFloat($data['price'])) return false;
            if (isset($data['image']) && !Validate_data_helper::validateString($data['image'])) return false;
            if (isset($data['options']) && !Validate_data_helper::validateString($data['options'])) return false;
            if (isset($data['addons']) && !Validate_data_helper::validateString($data['addons'])) return false;

            return true;
        }

        public function getUserProductsDetails(array $where): ?array
        {
            
            return  $this->read(
                        [
                            $this->table. '.id as productExtendedId',
                            $this->table. '.name',
                            $this->table. '.shortDescription',
                            $this->table. '.longDescription',
                            'FORMAT(' . $this->table . '.price,2) AS price',
                            $this->table. '.image',
                            $this->table. '.options',
                            $this->table. '.addons',

                            'tbl_shop_products.id AS productId',                            
                            'tbl_shop_products.stock',
                            'tbl_shop_products.recommendedQuantity',
                            'tbl_shop_products.active AS productActive',
                            'tbl_shop_products.showImage',

                            'tbl_shop_categories.category',
                            'tbl_shop_categories.id AS categoryId',
                            'tbl_shop_categories.active AS categoryActive',

                        ],
                        $where,
                        [
                            ['tbl_shop_products', $this->table.'.productId = tbl_shop_products.id', 'INNER'],
                            ['tbl_shop_categories', 'tbl_shop_products.categoryId = tbl_shop_categories.id', 'INNER'],
                        ],
                        'order_by',
                        [$this->table. '.id', 'DESC']
                    );
        }

        public function getUserLastProductsDetails(array $where): ?array
        {
            $products = $this->getUserProductsDetails($where);

            if (is_null($products)) return null;

            $productIds = [];
            $return = [];
            foreach ($products as $prodcut) {
                if (!in_array($prodcut['productId'], $productIds)) {
                    array_push($return, $prodcut);
                    array_push($productIds, $prodcut['productId']);
                }
            }
            $return = Utility_helper::resetArrayByKeyMultiple($return, 'name');
            ksort($return);
            return $return;
        }
    }
