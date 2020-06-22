<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    Class Shopspotproducts_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $spotId;
        public $productId;
        public $active;
        private $table = 'tbl_shop_spot_products';

        protected function setValueType(string $property,  &$value): void
        {
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
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;

            return true;
        }

        public function insertSpotAndProducts(object $spot, object $product, int $userId): ?int
        {
            $spots = $spot->fetchUserSpots($userId);
            $products = $product->getUserProducts($userId);
            $insertData = [];
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

            if ($insertData) {
                return $this->multipleCreate($insertData);
            }
            return null;
            
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


        public function updateUproductSpots($productSpots, $productId): bool
        {
            $allProductSpots = $this->read(['*'], ['productId=' => $productId]);
            foreach($allProductSpots as $data) {
                $update = [];
                $update['active'] = in_array($data['id'], $productSpots) ? '1' : '0';
                $update = $this
                            ->setObjectId(intval($data['id']))
                            ->setObjectFromArray($update)
                            ->update();
                if (!$update) return false;
            }
            return true;
        }
    }
