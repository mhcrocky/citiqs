<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopprodutctype_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $type;
        public $active;
        public $isMain;
        public $additionalNumber;
        public $isBoolean;

        private $table = 'tbl_shop_products_types';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'vendorId' || $property === 'additionalNumber') {
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
            if (isset($data['type']) && isset($data['vendorId'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['type']) && !Validate_data_helper::validateString($data['type'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;
            if (isset($data['isMain']) && !($data['isMain'] === '1' || $data['isMain'] === '0')) return false;
            if (isset($data['additionalNumber']) && !Validate_data_helper::validateInteger($data['additionalNumber'])) return false;
            if (isset($data['isBoolean']) && !($data['isBoolean'] === '1' || $data['isBoolean'] === '0')) return false;

            return true;
        }

        public function fetchProductTypes(int $userId, array $what = []): ?array
        {
            if ($what) {
                $what = $what;
            } else {
                $what = [
                    $this->table . '.id',
                    $this->table . '.type AS productType',
                    $this->table . '.active AS active',
                    $this->table . '.isMain AS isMain',
                    $this->table . '.additionalNumber AS additionalNumber',
                    $this->table . '.isBoolean AS isBoolean',
                ];
            }
            $where = [$this->table . '.vendorId=' => $userId];
            $filter = [
                'what' => $what,
                'where' => $where,
                'conditions' => [
                    'order_by' => [$this->table . '.type ASC']
                ]
            ];
                    
            return $this->readImproved($filter);
        }

        public function checkTypeName(array $where): bool
        {
            $filter = [
                'what' =>     [
                    $this->table . '.id',
                ],
                'where' => $where,
                'conditions' => [
                    'limit' => [1]
                ]
            ];

            return $this->readImproved($filter) ? true : false;
        }

        public function checkMain(int $vendorId, int $typeId = 0): bool
        {
            $where = [
                'vendorId=' => $vendorId,
                'isMain=' => '1',
            ];
            if ($typeId) {
                $where['id!='] = $typeId;
            }

            $filter = [
                'what' =>     [
                    $this->table . '.id',
                ],
                'where' => $where,
                'conditions' => [
                    'limit' => [1]
                ]
            ];

            return $this->readImproved($filter) ? true : false;
        }


        public function manageMainTypeId(): ?int
        {
            $id = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId,
                    $this->table . '.isMain' => '1'
                ]
            ]);

            if (is_null($id)) {
                $insert = [
                    'vendorId' => $this->vendorId,
                    'type' => $this->config->item('main_type'),
                    'active' => '1',
                    'isMain' => '1'
                ];
                return $this->setObjectFromArray($insert)->create() ? $this->id : null;
            }

            $id = reset($id);
            $id = intval($id['id']);
            return $id;
        }

        public function getApiSideDishesTypeId(): int
        {
            $id = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.vendorId' => $this->vendorId,
                    $this->table . '.isMain' => '0',
                    $this->table . '.type' => $this->config->item('api_side_dishes_product_type'),
                ]
            ]);

            if (is_null($id)) {
                $insert = [
                    'vendorId' => $this->vendorId,
                    'type' => $this->config->item('api_side_dishes_product_type'),
                    'active' => '1',
                    'isMain' => '0'
                ];
                return $this->setObjectFromArray($insert)->create() ? $this->id : null;
            }

            $id = reset($id);
            $id = intval($id['id']);
            return $id;
        }

        public function insertInitialTypes(string $type, bool $isMain): ?int
        {

            $this->type = $type;
            $this->active = '1';
            $this->isMain = $isMain ? '1' : '0';
            $this->additionalNumber = 1;

            return $this->create() ? $this->id : null;
    
        }
    }

