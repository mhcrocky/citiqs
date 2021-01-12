<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    Class Shopspotproduct_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $spotId;
        public $productId;
        public $showInPublic;
        private $table = 'tbl_shop_spot_products';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'spotId' || $property === 'productId') {
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
            if (isset($data['spotId']) && isset($data['productId']) && isset($data['active'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['spotId']) && !Validate_data_helper::validateInteger($data['spotId'])) return false;
            if (isset($data['productId']) && !Validate_data_helper::validateInteger($data['productId'])) return false;
            if (isset($data['showInPublic']) && !($data['showInPublic'] === '1' || $data['showInPublic'] === '0')) return false;

            return true;
        }

        public function insertSpotAndProducts(object $spot, object $product, int $userId): ?int
        {
            $spots = $spot->fetchUserSpots($userId);
            $products = $product->getUserProducts($userId);
            $insertData = [];

            if (is_null($spots) || is_null($products)) return null;

            foreach($spots as $spot) {
                $spotId = intval($spot['spotId']);
                foreach($products as $product) {
                    $productId = intval($product['productId']);
                    if (!$this->checkIsExists($spotId, $productId)) {
                        $insert = [
                            'spotId' => $spotId,
                            'productId' => $productId,
                        ];
                        array_push($insertData, $insert);
                    }
                }
            }

            return $this->multipleCreate($insertData);
        }

        public function checkIsExists(int $spotId, int $productId): bool
        {
            $count = $this->read(
                ['id'],
                [
                    $this->table.'.spotId=' => $spotId, 
                    $this->table.'.productId=' => $productId
                ],
                [],
                'LIMIT',
                ['1']
            );
            return is_null($count) ? false : true;

        }

        public function insertProductSpots(object $spot, int $productId, int $userId): ?int
        {
            $spots = $spot->fetchUserSpots($userId);
            $insertData = [];
            foreach($spots as $spot) {
                $spotId = intval($spot['spotId']);
                if (!$this->checkIsExists($spotId, $productId)) {
                    $insert = [
                        'spotId' => $spotId,
                        'productId' => $productId,
                    ];
                    array_push($insertData, $insert);
                }
            }
            if ($insertData) {
                return $this->multipleCreate($insertData);
            }
            return null;
        }


        public function insertSpotProducts(object $product, int $spotId, int $userId): ?int
        {
            $products = $product->getUserProducts($userId);
            $insertData = [];
            if (!$products) return null;

            foreach($products as $product) {
                $productId = intval($product['productId']);
                if (!$this->checkIsExists($spotId, $productId)) {
                    $insert = [
                        'spotId' => $spotId,
                        'productId' => $productId,
                    ];
                    array_push($insertData, $insert);
                }
            }

            if ($insertData) {
                return $this->multipleCreate($insertData);
            }
            return null;
        }

        public function getProductSpots(bool $onlyActive): ?array
        {
            $where = [
                $this->table . '.productId=' => $this->productId,
                'tbl_shop_spots.archived=' => '0',
                'tbl_shop_spots.isApi=' => '0',
            ];

            if ($onlyActive) {
                $where[$this->table . '.showInPublic='] = '1';
            }
            
            $productSpots = $this->readImproved([
                                'what' => [
                                    $this->table . '.id AS productSpotId',
                                    $this->table . '.showInPublic AS showInPublic',
                                    $this->table . '.spotId AS spotId',
                                    $this->table . '.productId AS productId',
                                    'tbl_shop_spots.spotName AS spotName',
                                ],
                                'where' => $where,
                                'joins' => [
                                    ['tbl_shop_spots', 'ON tbl_shop_spots.id = ' . $this->table . '.spotId', 'INNER']
                                ],
                                'codnitions' => [
                                    'order_by' =>  'tbl_shop_spots.spotName.spotId ASC'
                                ]
                            ]);
            if (is_null($productSpots)) return null;

            $this->load->helper('utility_helper');
            return Utility_helper::resetArrayByKeyMultiple($productSpots, 'spotId');
        }

        public function deleteProductSpots(): bool
        {
            $query = 'DELETE FROM ' . $this->table . ' WHERE productId = ' . $this->productId . ';';
            return $this->db->query($query);
        }

    }
