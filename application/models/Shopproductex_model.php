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
        public $showInPublic;
        public $archived;
        public $deliveryPrice;
        public $deliveryVatpercentage;
        public $pickupPrice;
        public $pickupVatpercentage;

        private $table = 'tbl_shop_products_extended';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

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
                && isset($data['shortDescription'])
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
            #if (isset($data['longDescription']) && !Validate_data_helper::validateString($data['longDescription'])) return false;
            if (isset($data['price']) && !Validate_data_helper::validateFloat($data['price'])) return false;
            if (isset($data['image']) && !Validate_data_helper::validateString($data['image'])) return false;
            if (isset($data['vatpercentage']) && !Validate_data_helper::validateFloat($data['vatpercentage'])) return false;
            if (isset($data['productTypeId']) && !Validate_data_helper::validateInteger($data['productTypeId'])) return false;
            if (isset($data['updateCycle']) && !Validate_data_helper::validateInteger($data['updateCycle'])) return false;
            if (isset($data['showInPublic']) && !($data['showInPublic'] === '1' || $data['showInPublic'] === '0')) return false;
            if (isset($data['archived']) && !($data['archived'] === '1' || $data['archived'] === '0')) return false;
            if (isset($data['deliveryPrice']) && !Validate_data_helper::validateFloat($data['deliveryPrice'])) return false;
            if (isset($data['deliveryVatpercentage']) && !Validate_data_helper::validateFloat($data['deliveryVatpercentage'])) return false;
            if (isset($data['pickupPrice']) && !Validate_data_helper::validateFloat($data['pickupPrice'])) return false;
            if (isset($data['pickupVatpercentage']) && !Validate_data_helper::validateFloat($data['pickupVatpercentage'])) return false;


            return true;
        }

        public function getUserProducts(int $userId, int $limit, int $offset, $whereIn = [], string $active = ''): ?array
        {
            $where = [
                'tbl_shop_categories.userId=' => $userId,
                'tbl_shop_categories.archived' => '0',
                'tbl_shop_products.archived' => '0',
            ];

            if ($active === '1' || $active === '0') {
                $where['tbl_shop_products.active'] = $active;
            }

            $filter = [
                'where' => $where,
                'whereIn' => $whereIn,
                'conditions' => [
                    'GROUP_BY' => [$this->table. '.productId'],
                    'LIMIT' => [$limit, $offset],
                ]
            ];
            $resetBy = 'productId';
            return $this->filterProducts($userId, $filter, $resetBy, false);
          
        }

        public function getUserProductsNew(int $userId): ?array
        {
            $where = [
                'tbl_shop_categories.userId=' => $userId,
                'tbl_shop_categories.archived' => '0',
                'tbl_shop_products.archived' => '0',
            ];
            $filter = [
                'where' => $where,
                'conditions' => [
                    'GROUP_BY' => [$this->table. '.productId'],
                ]
            ];
            $resetBy = 'productId';
            return $this->filterProducts($userId, $filter, $resetBy, false);
        }

        public function getAllUserProducts(int $userId): ?array
        {

            // $this->db->select("tbl_shop_products.id,tbl_shop_products_extended.name,category,orderNo");
            // $this->db->from('tbl_shop_products');
            // $this->db->join($this->table, $this->table.'.productId = tbl_shop_products.id', 'left');
            // $this->db->join('tbl_shop_categories', 'tbl_shop_products.categoryId = tbl_shop_categories.id', 'left');
            // $this->db->join('tbl_shop_product_printers', 'tbl_shop_products.id = tbl_shop_product_printers.productId', 'left');
            // $this->db->where('userId', $userId);
            // $this->db->group_by($this->table. '.productId');
            // $this->db->order_by('orderNo');
            // $query = $this->db->get();
            // $results = $query->result_array();
            // $products = [];
            // foreach($results as $key => $result){
            //     $result['position'] = $key + 1;
            //     $products[] = $result;
            // }
            // return $products;

            $query =
                'SELECT '
                        . $this->table . '.id, '
                        . $this->table . '.name, '
                        . $this->table . '.productId,
                        tbl_shop_categories.category category, 
                        tbl_shop_products.orderNo
                    FROM '
                        . $this->table . ' 
                    INNER JOIN
                        tbl_shop_products ON tbl_shop_products.id = ' . $this->table . '.productId
                    INNER JOIN
                        tbl_shop_categories ON tbl_shop_categories.id = tbl_shop_products.categoryId
                    LEFT JOIN
                        tbl_shop_products_types ON tbl_shop_products_types.id = ' . $this->table . '.productTypeId
                    WHERE
                        tbl_shop_categories.userId = ' . $userId .'
                        AND tbl_shop_categories.archived = "0"
                        AND tbl_shop_products.archived = "0"
                        AND tbl_shop_products_types.vendorId = ' . $userId .'
                        AND tbl_shop_products_types.isMain = "1"
                    ORDER BY ' . $this->table . '.id DESC;';

            $result = $this->db->query($query);
            $result = $result->result_array();
            $ids = [];
            $products = [];
            foreach ($result as $data) {
                if (!in_array($data['productId'], $ids)) {
                    array_push($products, $data);
                }
                array_push($ids, $data['productId']);
            }
            return $products;
          
        }

        public function getProductCategories(int $userId): ?array
        {
            $this->db->select("category");
            $this->db->from('tbl_shop_products');
            $this->db->join($this->table, $this->table.'.productId = tbl_shop_products.id', 'left');
            $this->db->join('tbl_shop_categories', 'tbl_shop_products.categoryId = tbl_shop_categories.id', 'left');
            $this->db->join('tbl_shop_product_printers', 'tbl_shop_products.id = tbl_shop_product_printers.productId', 'left');
            $this->db->where('userId', $userId);
            $this->db->group_by('category');
            $query = $this->db->get();
            return $query->result_array();
          
        }

        public function updateProductOrderNo($productId,$orderNo)
        {
            $this->db->set('orderNo', $orderNo);
            $this->db->where('id', $productId);
            $this->db->update('tbl_shop_products');
        }

        public function getUserProductsPublic(int $userId): ?array
        {
            $this->load->config('custom');

            $date = date('Y-m-d H:i:s', time());;

            $filter = [
                'where' => [
                        'tbl_shop_categories.userId=' => $userId,
                        'tbl_shop_categories.active=' => '1',
                        'tbl_shop_products.dateTimeFrom<=' => $date,
                        'tbl_shop_products.dateTimeTo>' => $date,
                    ],
                'conditions' => [
                        'GROUP_BY' => [$this->table. '.productId'],
                        'ORDER_BY' => ['tbl_shop_categories.sortNumber ASC, tbl_shop_products.orderNo ASC'],
                    ]
            ];
            
            $resetBy = 'category';
            return $this->filterProducts($userId, $filter, $resetBy, true);
        }

        private function filterProducts(int $userId, array $filter, string $resetBy, bool $onlyActiveProductSpot, string $typeCondition = ''): ?array
        {
            $this->load->config('custom');
            $concatSeparator = $this->config->item('concatSeparator');
            $concatGroupSeparator = $this->config->item('contactGroupSeparator');

            $filter['what'] = [
                $this->table . '.productId',
                'GROUP_CONCAT(
                        tblShopProductDetails.productDetails
                        SEPARATOR "'. $concatGroupSeparator . '"
                ) AS productDetails',
                'tbl_shop_products.stock',
                'tbl_shop_products.recommendedQuantity',
                'tbl_shop_products.active AS productActive',
                'tbl_shop_products.productImage AS productImage',
                'tbl_shop_products.dateTimeFrom AS dateTimeFrom',
                'tbl_shop_products.dateTimeTo AS dateTimeTo',
                'tbl_shop_products.orderNo AS orderNo',
                'tbl_shop_products.onlyOne AS onlyOne',
                'tbl_shop_products.addRemark AS addRemark',
                'tbl_shop_products.allergies AS allergies',
                'tbl_shop_products.preparationTime AS preparationTime',
                'tbl_shop_categories.category',
                'tbl_shop_categories.id AS categoryId',
                'tbl_shop_categories.active AS categoryActive',
                'tbl_shop_categories.sortNumber AS sortNumber',
                'GROUP_CONCAT(
                    CONCAT(
                        tbl_shop_printers.id,
                        \'' .  $concatSeparator . '\', tbl_shop_printers.printer,
                        \'' .  $concatSeparator . '\', tbl_shop_printers.active
                    )
                ) AS printers',                    
                'tblShopProductTimes.productTimes',
                'tblShopAddons.addons AS addons'
                
            ];
                
            $filter['joins'] =  [
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
                                \'' .  $concatSeparator . '\', tbl_shop_product_times.day,
                                \'' .  $concatSeparator . '\', tbl_shop_product_times.timeFrom,
                                \'' .  $concatSeparator . '\', tbl_shop_product_times.timeTo
                                SEPARATOR "'. $concatGroupSeparator . '"
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
                                \'' .  $concatSeparator . '\',' . $this->table. '.name,
                                \'' .  $concatSeparator . '\',' . $this->table. '.shortDescription,
                                \'' .  $concatSeparator . '\',' . 'FORMAT(' . $this->table . '.price,2),
                                \'' .  $concatSeparator . '\',' . $this->table. '.vatpercentage,
                                \'' .  $concatSeparator . '\',' . $this->table. '.productTypeId,
                                \'' .  $concatSeparator . '\', tbl_shop_products_types.type,
                                \'' .  $concatSeparator . '\', tbl_shop_products_types.isMain,
                                \'' .  $concatSeparator . '\',' . $this->table. '.updateCycle,
                                \'' .  $concatSeparator . '\',' . $this->table. '.showInPublic,
                                \'' .  $concatSeparator . '\',' . $this->table . '.productId,
                                \'' .  $concatSeparator . '\', tbl_shop_categories.category,
                                \'' .  $concatSeparator . '\', tbl_shop_products.active,
                                \'' .  $concatSeparator . '\', IF(CHAR_LENGTH(' . $this->table . '.longDescription) > 0, ' . $this->table . '.longDescription, ""),
                                \'' .  $concatSeparator . '\',' . 'FORMAT(' . $this->table . '.deliveryPrice, 2),
                                \'' .  $concatSeparator . '\',' . $this->table. '.deliveryVatpercentage,
                                \'' .  $concatSeparator . '\',' . 'FORMAT(' . $this->table . '.pickupPrice, 2),
                                \'' .  $concatSeparator . '\',' . $this->table. '.pickupVatpercentage
                                ORDER BY ' . $this->table. '.id DESC
                                SEPARATOR "'. $concatGroupSeparator . '"                                    
                            ) AS productDetails
                        FROM
                            ' . $this->table . '
                        INNER JOIN
                            tbl_shop_products_types ON ' . $this->table . '.productTypeId = tbl_shop_products_types.id
                        INNER JOIN
                            tbl_shop_products ON tbl_shop_products.id = ' . $this->table . '.productId
                        INNER JOIN
                            tbl_shop_categories ON tbl_shop_categories.id = tbl_shop_products.categoryId
                        ' . $typeCondition . ' AND tbl_shop_categories.userId = ' . $userId . ' AND ' . $this->table . '.archived = "0"
                        GROUP BY ' . $this->table. '.productId
                        ORDER BY ' . $this->table. '.updateCycle
                        
                    ) tblShopProductDetails',
                    'tblShopProductDetails.productTypeId = tbl_shop_products_types.id AND tblShopProductDetails.name = ' . $this->table . '.name',
                    'INNER'
                ],
                [
                        '(
                            SELECT 
                                tbl_shop_products_addons.productId,
                                GROUP_CONCAT(
                                    tbl_shop_products_addons.productId,
                                    \'' .  $concatSeparator . '\', tbl_shop_products_addons.addonProductId,
                                    \'' .  $concatSeparator . '\', tbl_shop_products_addons.productExtendedId,
                                    \'' .  $concatSeparator . '\', tbl_shop_products_addons.quantity
                                    SEPARATOR "' . $concatGroupSeparator . '"                                    
                                ) AS addons
                            FROM
                                tbl_shop_products_addons
                            INNER JOIN
                                tbl_shop_products ON tbl_shop_products_addons.productId = tbl_shop_products.id

                            GROUP BY tbl_shop_products_addons.productId
                            
                        ) tblShopAddons',
                        'tblShopAddons.productId = tbl_shop_products.id',
                        'LEFT'
                    ]
            ];
                

            $products = $this->readImproved($filter);
            #var_dump($products);

            if (is_null($products)) return null;

            $this->load->helper('utility_helper');

            foreach ($products as $key => $product) {
                $products[$key]['productDetails'] = $this->prepareProductDetails($product['productDetails'], $concatGroupSeparator,  $concatSeparator);
                $products[$key]['productSpots'] = $this->getProductSpots(intval($products[$key]['productId']), $onlyActiveProductSpot);

                if ($products[$key]['productTimes']) {
                    $products[$key]['productTimes'] = $this->prepareProductTimes($product['productTimes'], $concatGroupSeparator,  $concatSeparator);
                }
                if ($products[$key]['addons']) {
                    $products[$key]['addons'] =  $this->prepareAddons($product['addons'], $concatGroupSeparator, $concatSeparator);
                }
            }

            $products = Utility_helper::resetArrayByKeyMultiple($products, $resetBy);
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

        public function checkProductNameNew(int $userId, string $name, int $id = 0): bool
        {
            $names = $this->getProductsNames($userId);
            foreach ($names as $data) {                
                if (
                    ($id && intval($data['productId']) !== $id && $data['name'] === $name)
                    || (!$id && $data['name'] === $name)
                ) return true;   
            }
            return false;
        }

        private function prepareProductTimes(string $productTimes, string $separator, string $concatSeparator): array
        {
            $productTimes =  explode($separator, $productTimes);
            $productTimes = array_map(function($data) use($concatSeparator) {
                return explode($concatSeparator, $data);
            }, $productTimes);
            $productTimes = Utility_helper::resetArrayByKeyMultiple($productTimes, '1');

            return $productTimes;
        }

        private function prepareProductDetails(string $productDetails, string $separator, string $concatSeparator): array
        {
            $productDetails =  explode($separator, $productDetails);
            $productDetails = array_map(function($data) use($concatSeparator) {
                return explode($concatSeparator, $data);
            }, $productDetails);

            $return = [];

            foreach($productDetails as $index => $details) {
                if ($index > 0 && $productDetails[$index][8] !== $productDetails[$index - 1][8]) break;

                $collect = [
                    'productExtendedId'     => $details[0],
                    'name'                  => $details[1],
                    'shortDescription'      => $details[2],
                    'price'                 => $details[3],
                    'vatpercentage'         => $details[4],
                    'productTypeId'         => $details[5],
                    'productType'           => $details[6],
                    'productTypeIsMain'     => $details[7],
                    'productUpdateCycle'    => $details[8],
                    'showInPublic'          => $details[9],
                    'productId'             => $details[10],
                    'category'              => $details[11],
                    'activeStatus'          => $details[12],
                    'longDescription'       => $details[13],
                    'deliveryPrice'         => $details[14],
                    'deliveryVatpercentage' => $details[15],
                    'pickupPrice'           => $details[16],
                    'pickupVatpercentage'   => $details[17],
                ];
                array_push($return, $collect);
            }

            return $return;
        }

        public function getProductName(): string
        {
            $query = 'SELECT name FROM ' . $this->table . '  WHERE productId = ' . $this->productId . ' ORDER BY id DESC LIMIT 1;';
            $result = $this->db->query($query);
            return $result->result_array()[0]['name'];
        }

        private function prepareAddons(string $addons, string $separator, string $concatSeparator): array
        {
            $addons = explode($separator, $addons);
            $addons = array_map(function($data) use($concatSeparator) {
                return explode($concatSeparator, $data);
            }, $addons);
            return $addons;
        }

        private function getProductSpots(int $productId, bool $onlyActiveProductSpot): ?array
        {
            $this->load->model('shopspotproduct_model');
            
            return  $this
                        ->shopspotproduct_model
                            ->setProperty('productId', $productId)
                            ->getProductSpots($onlyActiveProductSpot);
        }

        public function getProductsNames(int $userId, string $active = ''): array
        {
            $active = ($active === '1' || $active === '0') ? 'AND tbl_shop_products.active="' . $active . '"' : '';
            $query = 

                'SELECT '
                    . $this->table . '.id, '
                    . $this->table . '.name, '
                    . $this->table . '.productId
                FROM '
                    . $this->table . ' 
                INNER JOIN
                    tbl_shop_products ON tbl_shop_products.id = ' . $this->table . '.productId
                INNER JOIN
                    tbl_shop_categories ON tbl_shop_categories.id = tbl_shop_products.categoryId
                WHERE
                    tbl_shop_categories.userId = ' . $userId .'
                    AND tbl_shop_categories.archived = "0"
                    AND tbl_shop_products.archived = "0"
                    ' . $active. '
                ORDER BY ' . $this->table . '.id DESC;';
            $result = $this->db->query($query);
            $result = $result->result_array();
            $ids = [];
            $names = [];
            foreach ($result as $data) {
                if (!in_array($data['productId'], $ids)) {
                    array_push($names, $data);
                }
                array_push($ids, $data['productId']);
            }
            return $names;
        }

        public function getProdctesByMainType(int $userId, bool $main = false): ?array
        {
            $this->load->config('custom');

            $filter = [
                'where' => [
                    'tbl_shop_categories.userId=' => $userId
                ],
                'conditions' => [
                    'GROUP_BY' => [$this->table. '.productId'],
                ]
            ];
            $resetBy = 'productId';
            $typeCondition = $main ? ' WHERE tbl_shop_products_types.isMain = "1" ' : ' WHERE tbl_shop_products_types.isMain = "0" ';

            return $this->filterProducts($userId, $filter, $resetBy, false, $typeCondition);
        }

        public function fetchSpotProducts(int $userId, array $spot): ?array
        {
            $this->load->config('custom');
            $concatSeparator = $this->config->item('concatSeparator');
            $concatGroupSeparator = $this->config->item('contactGroupSeparator');

            $spotId = $spot['spotId'];
            $spotTypeId = intval($spot['spotTypeId']);
            $date = date('Y-m-d H:i:s', time());
            $day = date('D');
            $hours = date('H:i:s');

            $filter = [
                'what' => [
                    $this->table . '.productId',
                    'GROUP_CONCAT(
                            tblShopProductDetails.productDetails
                            SEPARATOR "'. $concatGroupSeparator . '"
                    ) AS productDetails',
                    'tbl_shop_products.productImage AS productImage',
                    'tbl_shop_products.onlyOne AS onlyOne',
                    'tbl_shop_products.addRemark AS addRemark',
                    'tbl_shop_products.allergies AS allergies',
                    'tbl_shop_products.preparationTime AS preparationTime',
                    'tbl_shop_categories.category',
                    'tbl_shop_categories.id AS categoryId',
                    'tbl_shop_categories.private AS privateCategory',
                    'tblShopAddons.addons AS addons'
                ],
                'where' => [
                    'tbl_shop_categories.userId=' => $userId,
                    'tbl_shop_categories.active=' => '1',
                    'tbl_shop_categories.archived=' => '0',
                    'tbl_shop_categories.isApi=' => '0',
                    'tbl_shop_products.dateTimeFrom<=' => $date,
                    'tbl_shop_products.dateTimeTo>' => $date,
                    'tbl_shop_products.active=' => '1',
                    'tbl_shop_products.archived=' => '0',
                    'tbl_shop_spot_products.spotId=' =>  $spotId,
                    'tbl_shop_spot_products.showInPublic=' => "1",
                    'tbl_shop_product_times.day=' => $day,
                    'tbl_shop_product_times.timeFrom<=' => $hours,
                    'tbl_shop_product_times.timeTo>' => $hours,
                    'tbl_shop_categories.openTime<=' => $hours,
                    'tbl_shop_categories.closedTime>' => $hours,
                ],
                'joins' =>  [
                    ['tbl_shop_products', $this->table.'.productId = tbl_shop_products.id', 'LEFT'],
                    ['tbl_shop_categories', 'tbl_shop_products.categoryId = tbl_shop_categories.id', 'LEFT'],
                    ['tbl_shop_product_times', 'tbl_shop_product_times.productId = tbl_shop_products.id'],
                    [
                        '(
                            SELECT '
                                // . $this->table . '.id,'
                                . $this->table . '.productTypeId,'
                                . $this->table . '.name,
                                tbl_shop_products_types.isMain,
                                GROUP_CONCAT('
                                    . $this->table. '.id,
                                    \'' .  $concatSeparator . '\',' . $this->table. '.name,
                                    \'' .  $concatSeparator . '\',' . $this->table. '.shortDescription,
                                    \'' .  $concatSeparator . '\',' . $this->prepareSpotTypePriceCondition($spotTypeId) . ',
                                    \'' .  $concatSeparator . '\',' . $this->prepareSpotTypeVatCondition($spotTypeId) . ',
                                    \'' .  $concatSeparator . '\',' . $this->table. '.productTypeId,
                                    \'' .  $concatSeparator . '\', tbl_shop_products_types.type,
                                    \'' .  $concatSeparator . '\', tbl_shop_products_types.isMain,
                                    \'' .  $concatSeparator . '\',' . $this->table. '.updateCycle,
                                    \'' .  $concatSeparator . '\',' . $this->table. '.showInPublic,
                                    \'' .  $concatSeparator . '\',' . $this->table . '.productId,
                                    \'' .  $concatSeparator . '\', tbl_shop_categories.category,
                                    \'' .  $concatSeparator . '\', tbl_shop_products.active,
                                    \'' .  $concatSeparator . '\', IF(CHAR_LENGTH(' . $this->table . '.longDescription) > 0, ' . $this->table . '.longDescription, ""),
                                    \'' .  $concatSeparator . '\', tbl_shop_products.addRemark,
                                    \'' .  $concatSeparator . '\', IF(CHAR_LENGTH(tbl_shop_products.allergies) > 0, tbl_shop_products.allergies, ""),
                                    \'' .  $concatSeparator . '\', IF(CHAR_LENGTH(tbl_shop_products.productImage) > 0, tbl_shop_products.productImage, ""),
                                    \'' .  $concatSeparator . '\', tbl_shop_products_types.isBoolean,
                                    \'' .  $concatSeparator . '\', tbl_shop_products_types.additionalNumber
                                    ORDER BY ' . $this->table. '.id DESC
                                    SEPARATOR "'. $concatGroupSeparator . '"
                                ) AS productDetails
                            FROM
                                ' . $this->table . '
                            INNER JOIN
                                tbl_shop_products_types ON ' . $this->table . '.productTypeId = tbl_shop_products_types.id
                            INNER JOIN
                                tbl_shop_products ON tbl_shop_products.id = ' . $this->table . '.productId
                            INNER JOIN
                                tbl_shop_categories ON tbl_shop_categories.id = tbl_shop_products.categoryId
                            WHERE
                                tbl_shop_categories.userId = ' . $userId . '
                                AND tbl_shop_categories.archived = "0"
                                AND ' . $this->table . '.archived = "0"
                            GROUP BY ' . $this->table. '.productId
                            ORDER BY ' . $this->table. '.productTypeId DESC
                        ) tblShopProductDetails',
                        'tblShopProductDetails.name = ' . $this->table . '.name',
                        'INNER'
                    ],
                    [
                        '(
                            SELECT
                                tbl_shop_products_addons.productId,
                                GROUP_CONCAT(
                                    tbl_shop_products_addons.productExtendedId,
                                    \'' .  $concatSeparator . '\', tbl_shop_products_addons.quantity
                                    SEPARATOR "' . $concatGroupSeparator . '"
                                ) AS addons
                            FROM
                                tbl_shop_products_addons
                            INNER JOIN
                                tbl_shop_products ON tbl_shop_products_addons.productId = tbl_shop_products.id
                            GROUP BY tbl_shop_products_addons.productId
                        ) tblShopAddons',
                        'tblShopAddons.productId = tbl_shop_products.id',
                        'LEFT'
                    ],
                    ['tbl_shop_spot_products', 'tbl_shop_spot_products.productId = tbl_shop_products.id ','INNER']
                ],
                'conditions' => [
                    'GROUP_BY' => [$this->table. '.productId'],
                    'ORDER_BY' => ['tbl_shop_categories.sortNumber ASC, tbl_shop_products.orderNo ASC'],
                ]
            ];

            return $this->readImproved($filter);
        }

        public function getMainProductsOnBuyerSide(int $userId, array $spot): ?array
        {
            $products = $this->fetchSpotProducts($userId, $spot);
            if (is_null($products)) return null;

            $this->load->helper('utility_helper');
            $this->load->config('custom');
            $concatSeparator = $this->config->item('concatSeparator');
            $concatGroupSeparator = $this->config->item('contactGroupSeparator');

            $addons = [];
            foreach ($products as $key => $product) {
                $products[$key]['productDetails'] = $this->prepareBuyerProductDetails($product['productDetails'], $concatGroupSeparator,  $concatSeparator, $addons);                
                if (empty($products[$key]['productDetails'])) {
                    unset($products[$key]);
                    continue;
                }
                if ($products[$key]['addons']) {
                    $products[$key]['addons'] =  $this->prepareAddons($product['addons'], $concatGroupSeparator, $concatSeparator);
                    $products[$key]['addons'] = Utility_helper::resetArrayByKeyMultiple($products[$key]['addons'], '0');
                }
            }

            $return = [
                'main' => Utility_helper::resetArrayByKeyMultiple($products, 'category'),
                'addons' => Utility_helper::resetArrayByKeyMultiple($addons, 'productExtendedId'),
            ];

            return $return;
        }

        private function prepareBuyerProductDetails(string $productDetails, string $separator, string $concatSeparator, array &$addons ): array
        {
            $productDetails =  explode($separator, $productDetails);
            $productDetails = array_map(function($data) use($concatSeparator) {
                return explode($concatSeparator, $data);
            }, $productDetails);

            $return = [];

            foreach($productDetails as $index => $details) {
                // checking the updte cycle
                if ($index > 0 && $productDetails[$index][8] !== $productDetails[$index - 1][8]) break;
                if ($details[9] === '0') continue;

                $collect = [
                    'productExtendedId'     => $details[0],
                    'name'                  => $details[1],
                    'shortDescription'      => $details[2],
                    'price'                 => $details[3],
                    'vatpercentage'         => $details[4],
                    'productTypeId'         => $details[5],
                    'productType'           => $details[6],
                    'productTypeIsMain'     => $details[7],
                    'productUpdateCycle'    => $details[8],
                    'showInPublic'          => $details[9],
                    'productId'             => $details[10],
                    'category'              => $details[11],
                    'activeStatus'          => $details[12],
                    'longDescription'       => $details[13],
                    'addRemark'             => $details[14],
                    'allergies'             => $details[15],
                    'productImage'          => $details[16],
                    'isBoolean'             => $details[17],
                    'additionalNumber'      => $details[18]
                ];
                if ($collect['productTypeIsMain'] === '0') {
                    array_push($addons, $collect);
                    continue;
                }
                array_push($return, $collect);
            }

            return $return;
        }

        public function getLastUpdateData(): array
        {
            return $this->readImproved([
                'what'  => ['*'],
                'where' => [
                    'id=' => $this->id
                ],
                'conditions' => [
                    'GROUP_BY' => ['LIMIT 1'],
                    'ORDER_BY' => [$this->table. '.id DESC'],
                ]
            ]);
        }

        private function prepareSpotTypePriceCondition(int $spotTypeId): string
        {
            $this->load->config('custom');
            $localType = $this->config->item('local');
            $deliveryType = $this->config->item('deliveryType');
            $pickupType = $this->config->item('pickupType');

            if ($spotTypeId === $localType) {
                $price = 'FORMAT(' . $this->table . '.price , 2)';
            } elseif ($spotTypeId === $deliveryType) {
                $price = 'FORMAT(' . $this->table . '.deliveryPrice , 2)';
            } elseif ($spotTypeId === $pickupType) {
                $price = 'FORMAT(' . $this->table . '.pickupPrice , 2)';
            }

            return $price;

        }

        private function prepareSpotTypeVatCondition(int $spotTypeId): string
        {
            $this->load->config('custom');
            $localType = $this->config->item('local');
            $deliveryType = $this->config->item('deliveryType');
            $pickupType = $this->config->item('pickupType');

            if ($spotTypeId === $localType) {
                $vat = $this->table. '.vatpercentage';
            } elseif ($spotTypeId === $deliveryType) {
                $vat = $this->table. '.deliveryVatpercentage';
            } elseif ($spotTypeId === $pickupType) {
                $vat = $this->table. '.pickupVatpercentage';
            }

            return $vat;
        }

        public function checkProductAndExtendedIds(int $productId, array $extendedIds): bool
        {
            $check = $this->readImproved([
                'what' => [$this->table . '.id'],
                'where' => [
                    $this->table . '.productId' => $productId,
                ],
                'whereIn' => [
                    'column' => $this->table . '.id',
                    'array' => $extendedIds
                ]
            ]);

            return empty($check) ? false : true;
        }

        public function isLastUpdate(int $productUpdateCycle): bool
        {
            $max = $this->readImproved([
                'what' => ['max(updateCycle) AS max'],
                'where' => [
                    'productId' => $this->productId,
                ]
            ]);
            $max = reset($max)['max'];
            $max = intval($max);
            return $max === $productUpdateCycle ? true : false;
        }

        public function manageApiProduct(array $product, array $apiData, int $serviceTypeId)
        {
            $this->load->config('custom');

            $productExtended = $this->readImproved([
                'what' => [$this->table . '.*'],
                'where' => [
                    $this->table . '.name' => $product['name'],
                    'tbl_shop_categories.id' => $apiData['categoryId']
                ],
                'joins' => [
                    ['tbl_shop_products', 'ON tbl_shop_products.id = ' . $this->table . '.productId' , 'INNER'],
                    ['tbl_shop_categories', 'ON tbl_shop_categories.id = tbl_shop_products.categoryId' , 'INNER']
                ],
                'conditions' => [
                    'ORDER_BY' => [$this->table . '.id DESC'],
                    'LIMIT' => ['1'],
                ]
            ]);

            // insert prodcut and product extended
            if (is_null($productExtended)) {
                $this->load->model('shopproduct_model');
                $insertProduct = [
                    'categoryId' =>  $apiData['categoryId'],
                    'active' => '1',
                    'addRemark' => '1'
                ];

                if (!$this->shopproduct_model->setObjectFromArray($insertProduct)->create()) return null;

                $insertProductEx = [
                    'productId' => $this->shopproduct_model->id,
                    'name' => $product['name'],
                    'price' => 0,
                    'shortDescription' => $product['name'],
                    'updateCycle' => '1'
                ];

                $insertProductEx['productTypeId'] = isset($product['sideDishes']) ? $apiData['mainProductTypeId'] : $apiData['sideDishesProductTypeId'];

                if ($serviceTypeId === $this->config->item('deliveryType')) {
                    $insertProductEx['deliveryPrice'] = floatval($product['price']);
                }

                if ($serviceTypeId === $this->config->item('pickupType')) {
                    $insertProductEx['pickupPrice'] = floatval($product['price']);
                }

                return $this->setObjectFromArray($insertProductEx)->create() ? $this->id : null;
            }
            // product already inserted, check is price changed
            $productExtended = reset($productExtended);
            if (
                ($serviceTypeId === $this->config->item('deliveryType') && floatval($productExtended['deliveryPrice']) === floatval($product['price']))
                || ($serviceTypeId === $this->config->item('pickupType') && floatval($productExtended['pickupPrice']) === floatval($product['price']))
            ) {
                // price is same, return id
                return intval($productExtended['id']);
            }

            if ($serviceTypeId === $this->config->item('deliveryType')) {
                $productExtended['deliveryPrice'] = floatval($product['price']);
            }
            if ($serviceTypeId === $this->config->item('pickupType')) {
                $productExtended['pickupPrice'] = floatval($product['price']);
            }
            $productExtended['updateCycle']++;
            return $this->setObjectFromArray($productExtended)->create() ? $this->id : null;
        }

        public function insertInitialProductExtended(string $name): bool
        {
            $this->name = $name;
            $this->shortDescription = $name;

            $this->showInPublic = '1';
            $this->archived = '0';
            
            $this->price = 10;
            $this->vatpercentage = 21;
            
            $this->deliveryPrice = 10;
            $this->deliveryVatpercentage = 21;

            $this->pickupPrice = 10;
            $this->pickupVatpercentage = 21;

            $this->updateCycle = 1;

            return $this->create();
        }
    }
