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
        public $vatpercentage;
        private $table = 'tbl_shop_products_extended';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'productId') {
                $value = intval($value);
            }
            if ($property === 'price' || $property === 'vatpercentage') {
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
            if (isset($data['vatpercentage']) && !Validate_data_helper::validateFloat($data['vatpercentage'])) return false;

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
                            $this->table. '.vatpercentage AS productVat',

                            'tbl_shop_products.id AS productId',                            
                            'tbl_shop_products.stock',
                            'tbl_shop_products.recommendedQuantity',
                            'tbl_shop_products.active AS productActive',
                            'tbl_shop_products.showImage',
                            'tbl_shop_products.dateTimeFrom AS dateTimeFrom',
                            'tbl_shop_products.dateTimeTo AS dateTimeTo',
                            
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

            $this->load->model('shopprinters_model');
            $this->load->helper('utility_helper');

            $productIds = [];
            $return = [];
            foreach ($products as $prodcut) {
                if (!in_array($prodcut['productId'], $productIds)) {
                    $prodcut['printers'] = $this->shopprinters_model->fetchtProductPrinters(intval($prodcut['productId']));
                    if ($prodcut['printers']) {
                        $prodcut['printers'] = Utility_helper::resetArrayByKeyMultiple($prodcut['printers'], 'printerId');
                    }

                    array_push($return, $prodcut);
                    array_push($productIds, $prodcut['productId']);
                }
            }
            $return = Utility_helper::resetArrayByKeyMultiple($return, 'name');
            ksort($return);
            return $return;
        }



        public function getUserProductsDetailsPublic(int $spotId): ?array
        {
            $date = date('Y-m-d H:i:s');
            $query =
                "SELECT
                    `tbl_shop_products_extended`.`id` as `productExtendedId`,
                    `tbl_shop_products_extended`.`name`,
                    `tbl_shop_products_extended`.`shortDescription`,
                    `tbl_shop_products_extended`.`longDescription`,
                    FORMAT(tbl_shop_products_extended.price, 2) AS price,
                    `tbl_shop_products_extended`.`image`,
                    `tbl_shop_products_extended`.`options`,
                    `tbl_shop_products_extended`.`addons`,
                    `tbl_shop_products`.`id` AS `productId`,
                    `tbl_shop_products`.`stock`,
                    `tbl_shop_products`.`recommendedQuantity`,
                    `tbl_shop_products`.`active` AS `productActive`,
                    `tbl_shop_products`.`showImage`,
                    `tbl_shop_products`.`dateTimeFrom`,
                    `tbl_shop_products`.`dateTimeTo`,
                    `tbl_shop_categories`.`category`,
                    `tbl_shop_categories`.`id` AS `categoryId`,
                    `tbl_shop_categories`.`active` AS `categoryActive`
                FROM
                    `tbl_shop_products_extended`
                    INNER JOIN `tbl_shop_products` ON `tbl_shop_products_extended`.`productId` = `tbl_shop_products`.`id`
                    INNER JOIN `tbl_shop_categories` ON `tbl_shop_products`.`categoryId` = `tbl_shop_categories`.`id`
                    INNER JOIN `tbl_shop_product_printers` ON `tbl_shop_product_printers`.`productId` = `tbl_shop_products`.`id`
                    INNER JOIN `tbl_shop_spots` ON `tbl_shop_product_printers`.`printerId` = `tbl_shop_spots`.`printerId`
                    INNER JOIN `tbl_shop_printers` ON `tbl_shop_printers`.`id` = `tbl_shop_spots`.`printerId`
                WHERE
                    `tbl_shop_categories`.`active` = '1'
                    AND `tbl_shop_products`.`active` = '1'
                    AND `tbl_shop_spots`.`active` = '1'
                    AND `tbl_shop_printers`.`active` = '1'
                    AND `tbl_shop_spots`.`id` = '{$spotId}'
                    AND
                    (
                        (`tbl_shop_products`.`dateTimeFrom` < '{$date}' AND `tbl_shop_products`.`dateTimeTo` > '{$date}' )
                        OR
                        (`tbl_shop_products`.`dateTimeFrom` IS NULL AND `tbl_shop_products`.`dateTimeTO` IS NULL)
                    )

                ORDER BY `tbl_shop_products_extended`.`id` DESC";
                $result = $this->db->query($query);
                $result = $result->result_array();
                return $result ? $result : null;
            // return  $this->read(
            //             [
            //                 $this->table. '.id as productExtendedId',
            //                 $this->table. '.name',
            //                 $this->table. '.shortDescription',
            //                 $this->table. '.longDescription',
            //                 'FORMAT(' . $this->table . '.price,2) AS price',
            //                 $this->table. '.image',
            //                 $this->table. '.options',
            //                 $this->table. '.addons',

            //                 'tbl_shop_products.id AS productId',                            
            //                 'tbl_shop_products.stock',
            //                 'tbl_shop_products.recommendedQuantity',
            //                 'tbl_shop_products.active AS productActive',
            //                 'tbl_shop_products.showImage',

            //                 'tbl_shop_categories.category',
            //                 'tbl_shop_categories.id AS categoryId',
            //                 'tbl_shop_categories.active AS categoryActive',

            //             ],
            //             $where,
            //             [
            //                 ['tbl_shop_products', $this->table.'.productId = tbl_shop_products.id', 'INNER'],
            //                 ['tbl_shop_categories', 'tbl_shop_products.categoryId = tbl_shop_categories.id', 'INNER'],
            //                 ['tbl_shop_product_printers', 'tbl_shop_product_printers.productId = tbl_shop_products.id', 'INNER'],
            //                 ['tbl_shop_spots', 'tbl_shop_product_printers.printerId = tbl_shop_spots.printerId', 'INNER'],
            //                 ['tbl_shop_printers', 'tbl_shop_printers.id = tbl_shop_spots.printerId', 'INNER']
            //             ],
            //             'order_by',
            //             [$this->table. '.id', 'DESC']
            //         );
        }

        public function getUserLastProductsDetailsPublic(int $spotId, string $sortBy = 'name'): ?array
        {
            $products = $this->getUserProductsDetailsPublic($spotId);
            if (is_null($products)) return null;

            $this->load->model('shopprinters_model');
            $this->load->helper('utility_helper');

            $productIds = [];
            $return = [];
            foreach ($products as $prodcut) {
                if (!in_array($prodcut['productId'], $productIds)) {
                    $prodcut['printers'] = $this->shopprinters_model->fetchtProductPrinters(intval($prodcut['productId']));
                    if ($prodcut['printers']) {
                        $prodcut['printers'] = Utility_helper::resetArrayByKeyMultiple($prodcut['printers'], 'printerId');
                    }

                    array_push($return, $prodcut);
                    array_push($productIds, $prodcut['productId']);
                }
            }
            $return = Utility_helper::resetArrayByKeyMultiple($return, $sortBy);
            ksort($return);
            return $return;
        }
    }
