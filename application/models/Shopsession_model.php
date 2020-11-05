<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopsession_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $randomKey;
        public $orderData;

        private $table = 'tbl_shop_sessions';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id') {
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
            if (isset($data['randomKey']) && isset($data['orderData'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['randomKey']) && !Validate_data_helper::validateString($data['randomKey'])) return false;
            if (isset($data['orderData']) && !Validate_data_helper::validateString($data['orderData'])) return false;

            return true;
        }

        public function insertSessionData(array $orderData): Shopsession_model
        {
            $this->setRandomKey();
            $this->setOrderData($orderData);

            if ($this->create()) {
                return $this;
            } else {
                return $this->insertSessionData($orderData);
            }
        }

        private function setRandomKey(): Shopsession_model
        {
            $this->load->helper('utility_helper');
            $this->randomKey = Utility_helper::shuffleBigStringRandom(256);
            return $this;
        }

        private function setOrderData(array $orderData): Shopsession_model
        {
            $this->load->helper('jwt_helper');
            $this->orderData = Jwt_helper::encode($orderData);
            return $this;
        }

        public function getArrayOrderDetails(): array
        {
            $this->load->helper('jwt_helper');
            $orderData = $this->readImproved([
                'what' => ['orderData'],
                'where' => [
                    $this->table . '.randomKey' => $this->randomKey
                ]
            ]);

            if (is_null($orderData)) return [];

            $orderData = Jwt_helper::decode($orderData[0]['orderData']);
            $orderData = json_decode(json_encode($orderData), true);

            $orderData['vendorId'] = intval($orderData['vendorId']);
            $orderData['spotId'] = intval($orderData['spotId']);

            return $orderData;
        }

        public function updateSessionData(array $post): Shopsession_model
        {
            $this->setIdFromRandomKey();
            $this->setOrderData($post);
            if (!$this->id || !$this->update()) {
                $this->id = null;
                $this->randomKey = null;
            }
            return $this;
        }
        
        private function setIdFromRandomKey(): Shopsession_model
        {
            $id = $this->readImproved([
                'what' => ['id'],
                'where' => [
                    $this->table . '.randomKey' => $this->randomKey
                ]
            ]);

            if($id) {
                $this->id = $id[0]['id'];
            }
            
            return $this;

            
        }
    }
