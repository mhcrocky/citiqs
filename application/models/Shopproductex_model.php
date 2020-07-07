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
        public $productTypeId;
        public $name;
        public $shortDescription;
        public $longDescription;
        public $price;
        public $image;
        public $vatpercentage;
        public $updateCycle;
        private $table = 'tbl_shop_products_extended';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'productId' || $property === 'updateCycle') {
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
            if (
                isset($data['productId'])
                && isset($data['name'])
                && isset($data['price'])
                && isset($data['productTypeId'])
                && isset($data['updateCycle'])
            ) {
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
            if (isset($data['vatpercentage']) && !Validate_data_helper::validateFloat($data['vatpercentage'])) return false;
            if (isset($data['productTypeId']) && !Validate_data_helper::validateInteger($data['productTypeId'])) return false;
            if (isset($data['updateCycle']) && !Validate_data_helper::validateInteger($data['updateCycle'])) return false;

            return true;
        }

        public function getUserProductsDetailsPublic(int $spotId, int $userId): ?array
        {
            $time = time();
            $date = date('Y-m-d H:i:s', $time);
            $day = date('D', time());
            $hours = date('H:i:s', $time);

            $query =
                "SELECT
                    `tbl_shop_products_extended`.`id` as `productExtendedId`,
                    `tbl_shop_products_extended`.`name`,
                    `tbl_shop_products_extended`.`shortDescription`,
                    `tbl_shop_products_extended`.`longDescription`,
                    FORMAT(tbl_shop_products_extended.price, 2) AS price,
                    `tbl_shop_products_extended`.`image`,
                    `tbl_shop_products`.`id` AS `productId`,
                    `tbl_shop_products`.`stock`,
                    `tbl_shop_products`.`recommendedQuantity`,
                    `tbl_shop_products`.`active` AS `productActive`,
                    `tbl_shop_products`.`showImage`,
                    `tbl_shop_products`.`dateTimeFrom`,
                    `tbl_shop_products`.`dateTimeTo`,
                    `tbl_shop_categories`.`category`,
                    `tbl_shop_categories`.`id` AS `categoryId`,
                    `tbl_shop_categories`.`active` AS `categoryActive`,
                    `tbl_shop_products_types`.`id` AS `productTypeId`,
                    `tbl_shop_products_types`.`type` AS `productType`
                FROM
                    `tbl_shop_products_extended`
                    INNER JOIN `tbl_shop_products` ON `tbl_shop_products_extended`.`productId` = `tbl_shop_products`.`id`
                    INNER JOIN `tbl_shop_categories` ON `tbl_shop_products`.`categoryId` = `tbl_shop_categories`.`id`
                    INNER JOIN
                        (
                            SELECT
                                tbl_shop_product_times.productId
                            FROM
                                tbl_shop_product_times
                            WHERE
                                tbl_shop_product_times.day = '{$day}'
                                AND
                                tbl_shop_product_times.timeFrom <= '{$hours}'
                                AND
                                tbl_shop_product_times.timeTo > '{$hours}'
                        ) productTimes ON productTimes.productId = tbl_shop_products.id
                    -- INNER JOIN `tbl_shop_products_types` ON `tbl_shop_products_types`.`id` = `tbl_shop_products`.`productTypeId`
                WHERE
                    `tbl_shop_categories`.`active` = '1'
                    AND `tbl_shop_categories`.`userId` = '{$userId}'
                    AND `tbl_shop_products`.`active` = '1'


                    AND
                    (
                        (`tbl_shop_products`.`dateTimeFrom` <= '{$date}' AND `tbl_shop_products`.`dateTimeTo` > '{$date}' )
                        OR
                        (`tbl_shop_products`.`dateTimeFrom` IS NULL AND `tbl_shop_products`.`dateTimeTO` IS NULL)
                    )

                ORDER BY `tbl_shop_products_extended`.`id` DESC";
                $result = $this->db->query($query);
                $result = $result->result_array();
                return $result ? $result : null;
        }

        public function getUserLastProductsDetailsPublic(int $spotId, int $userId, string $sortBy = 'name'): ?array
        {
            $products = $this->getUserProductsDetailsPublic($spotId, $userId);
            if (is_null($products)) return null;

            $this->load->model('shopprinters_model');
            $this->load->helper('utility_helper');

            $productIds = [];
            $return = [];
            foreach ($products as $prodcut) {
                if (!in_array($prodcut['productId'], $productIds)) {
                    // $prodcut['printers'] = $this->shopprinters_model->fetchtProductPrinters(intval($prodcut['productId']));
                    // if ($prodcut['printers']) {
                    //     $prodcut['printers'] = Utility_helper::resetArrayByKeyMultiple($prodcut['printers'], 'printerId');
                    // }
                    array_push($return, $prodcut);
                    array_push($productIds, $prodcut['productId']);
                }
            }
            $return = Utility_helper::resetArrayByKeyMultiple($return, $sortBy);
            ksort($return);
            return $return;
        }


        public function getUserProducts(int $userId): ?array
        {
            $this->load->config('custom');

            $filter = [
                'what' => [
                    $this->table . '.productId',
                    'GROUP_CONCAT(
                            tblShopProductDetails.productDetails
                            SEPARATOR "'. $this->config->item('contactGroupSeparator') . '"
                    ) AS productDetails',
                    'tbl_shop_products.stock',
                    'tbl_shop_products.recommendedQuantity',
                    'tbl_shop_products.showImage',
                    'tbl_shop_products.dateTimeFrom AS dateTimeFrom',
                    'tbl_shop_products.dateTimeTo AS dateTimeTo',
                    'tbl_shop_categories.category',
                    'tbl_shop_categories.id AS categoryId',
                    'tbl_shop_categories.active AS categoryActive',
                    'GROUP_CONCAT(
                        CONCAT(
                            tbl_shop_printers.id,
                            \'|\', tbl_shop_printers.printer,
                            \'|\', tbl_shop_printers.active
                        )
                    ) AS printers',
                    'tblShopProductTimes.productTimes',
                ],
                'where' => [
                    'tbl_shop_categories.userId=' => $userId
                ],
                'joins' =>  [
                    ['tbl_shop_products', $this->table.'.productId = tbl_shop_products.id', 'LEFT'],
                    ['tbl_shop_categories', 'tbl_shop_products.categoryId = tbl_shop_categories.id', 'LEFT'],
                    ['tbl_shop_product_printers', 'tbl_shop_products.id = tbl_shop_product_printers.productId', 'LEFT'],
                    ['tbl_shop_printers', 'tbl_shop_product_printers.printerId = tbl_shop_printers.id', 'LEFT'],
                    [
                        '(
                            SELECT
                                tbl_shop_product_times.productId,
                                GROUP_CONCAT(
                                    tbl_shop_product_times.productId,
                                    \'|\', tbl_shop_product_times.day,
                                    \'|\', tbl_shop_product_times.timeFrom,
                                    \'|\', tbl_shop_product_times.timeTo
                                    SEPARATOR "'. $this->config->item('contactGroupSeparator') . '"
                                ) AS productTimes                                
                            FROM
                                tbl_shop_product_times
                            GROUP BY tbl_shop_product_times.productId
                            ORDER BY tbl_shop_product_times.timeFrom ASC
                        ) tblShopProductTimes',                    
                        'tblShopProductTimes.productId = ' . $this->table.'.productId',
                        'LEFT'
                    ],
                    ['tbl_shop_products_types', 'tbl_shop_products_types.id = ' . $this->table . '.productTypeId','INNER'],
                    [
                        '(
                            SELECT '
                                // . $this->table . '.id,'
                                . $this->table . '.productTypeId,'
                                . $this->table . '.name,
                                GROUP_CONCAT('
                                    . $this->table. '.id,
                                    \'|\',' . $this->table. '.name,
                                    \'|\',' . $this->table. '.shortDescription,
                                    \'|\',' . 'FORMAT(' . $this->table . '.price,2),
                                    \'|\',' . $this->table. '.vatpercentage,
                                    \'|\',' . $this->table. '.productTypeId,
                                    \'|\', tbl_shop_products_types.type,
                                    \'|\', tbl_shop_products_types.isMain,
                                    \'|\',' . $this->table. '.updateCycle
                                    
                                    SEPARATOR "'. $this->config->item('contactGroupSeparator') . '"
                                ) AS productDetails
                            FROM
                                ' . $this->table . '
                            INNER JOIN
                                tbl_shop_products_types ON ' . $this->table . '.productTypeId = tbl_shop_products_types.id

                            GROUP BY ' . $this->table. '.productId
                            
                        ) tblShopProductDetails',                    
                        'tblShopProductDetails.productTypeId = tbl_shop_products_types.id AND tblShopProductDetails.name = ' . $this->table . '.name',
                        'INNER'
                    ]
                ],
                'conditions' => [
                    'GROUP_BY' => [$this->table. '.productId'],
                    'ORDER_BY' => [$this->table. '.id DESC'],
                ]
            ];

            $products = $this->readImproved($filter);

            if (is_null($products)) return null;

            $this->load->helper('utility_helper');

            foreach ($products as $key => $product) {
                $products[$key]['productTimes'] = $this->prepareProductTimes($product['productTimes'], $this->config->item('contactGroupSeparator'));
                $products[$key]['productDetails'] = $this->prepareProductDetails($product['productDetails'], $this->config->item('contactGroupSeparator'));
            }
            
            $products = Utility_helper::resetArrayByKeyMultiple($products, 'productId');
            return $products;
        }

        public function checkProductName(array $where): bool
        {
            $count = $this->readImproved(
                [
                    'what'  => [$this->table . '.id'],
                    'where' => $where,
                    'joins' => [
                        ['tbl_shop_products', $this->table.'.productId = tbl_shop_products.id', 'LEFT'],
                        ['tbl_shop_categories', 'tbl_shop_products.categoryId = tbl_shop_categories.id', 'LEFT'],
                    ],
                    'conditions' => [
                        'LIMIT' => ['1'],
                    ]

                ]
            );

            return $count ? true : false;
        }

        private function prepareProductTimes(string $productTimes, string $separator): array
        {
            $productTimes =  explode($separator, $productTimes);
            $productTimes = array_map(function($data) {
                return explode('|', $data);
            }, $productTimes);
            $productTimes = Utility_helper::resetArrayByKeyMultiple($productTimes, '1');

            return $productTimes;
        }

        private function prepareProductDetails(string $productDetails, string $separator): array
        {
            $productDetails =  explode($separator, $productDetails);
            $productDetails = array_map(function($data) {
                return explode('|', $data);
            }, $productDetails);

            $cycle = 0;
            $return = [];
            $productExtendedIds = []; //TIQS TO DO CHECK WHY WE GET DOUBLE DATA

            foreach($productDetails as $index => $details) {
                $detailsCycle = intval($details[8]);
                if ($cycle < $detailsCycle) {
                    $cycle = $detailsCycle;
                }
                if (!in_array($details[0], $productExtendedIds)) {
                    $collect = [
                        'prodcutExtendedId'     => $details[0],
                        'productName'           => $details[1],
                        'shortDescription'      => $details[2],
                        'price'                 => $details[3],
                        'vatpercentage'         => $details[4],
                        'productTypeId'         => $details[5],
                        'productType'           => $details[6],
                        'productTypeIsMain'     => $details[7],
                        'productUpdateCycle'    => $details[8]
                    ];
                    array_push($return, $collect);
                    array_push($productExtendedIds, $details[0]);

                }
            }
            $return = Utility_helper::resetArrayByKeyMultiple($return, 'productUpdateCycle')[$cycle];
            return $return;
        }
    }
