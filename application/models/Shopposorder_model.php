<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopposorder_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $spotId;
        public $sessionId;
        public $saveName;
        private $table = 'tbl_shop_pos_orders';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'spotId' || $property === 'sessionId') {
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
            if (isset($data['spotId']) && isset($data['sessionId']) && isset($data['saveName'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['spotId']) && !Validate_data_helper::validateInteger($data['spotId'])) return false;
            if (isset($data['sessionId']) && !Validate_data_helper::validateInteger($data['sessionId'])) return false;
            if (isset($data['saveName']) && !Validate_data_helper::validateString($data['saveName'])) return false;
            return true;
        }

        public function fetchSpotPosOrders(): ?array
        {
            return $this->read(
                [
                    $this->table . '.id AS posOrderId',
                    $this->table . '.spotId AS spotId',
                    $this->table . '.sessionId AS posSessionId',
                    $this->table . '.saveName AS saveName',
                    'tbl_shop_sessions.randomKey AS randomKey',
                ],
                [
                    $this->table . '.spotId' =>  $this->spotId,
                ],
                [
                    ['tbl_shop_sessions', $this->table . '.sessionId = tbl_shop_sessions.id', 'INNER']
                ],
                'order_by',
                [$this->table . '.saveName', 'ASC']
            );
        }

        public function managePosOrder(): bool
        {

            if ($this->sessionId && !$this->create()) {
                $this->setIdFromSessionId();
                return $this->update();
            }
            return true;
        }

        public function setIdFromSessionId(): Shopposorder_model
        {
            $result =  $this->read(
                [
                    $this->table . '.id'
                ],
                [
                    $this->table . '.sessionId' =>  $this->sessionId,
                ]
            );
            $result = reset($result);
            $this->id = intval($result['id']);
            return $this;
        }
    

    }
