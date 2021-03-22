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
        public $created;
        public $updated;
        public $orderId;

        private $table = 'tbl_shop_pos_orders';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'spotId' || $property === 'sessionId' || $property === 'orderId') {
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
            if (isset($data['orderId']) && !Validate_data_helper::validateInteger($data['orderId'])) return false;

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
                    $this->table . '.created AS created',
                    'IF(' . $this->table . '.updated, ' . $this->table . '.updated,' . $this->table . '.created) AS lastChange',
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
                $this->updated = date('Y-m-d H:i:s');
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
            if (is_null($result)) return $this;
            $result = reset($result);
            $this->id = intval($result['id']);
            return $this;
        }

        public function fetchVendorPosOrders(int $vendorId): ?array
        {
            $orders = $this->readImproved([
                    'what' => [
                        $this->table . '.id AS posOrderId',
                        $this->table . '.spotId AS spotId',
                        $this->table . '.sessionId AS posSessionId',
                        $this->table . '.saveName AS saveName',
                        $this->table . '.created AS created',
                        'IF(' . $this->table . '.updated, ' . $this->table . '.updated,' . $this->table . '.created) AS lastChange',
                        'tbl_shop_sessions.randomKey AS randomKey',
                        'tbl_shop_spots.spotName AS spotName'
                    ],
                    'where' => [
                        'tbl_shop_printers.userId' =>  $vendorId,
                    ],
                    'joins' => [
                        ['tbl_shop_sessions', $this->table . '.sessionId = tbl_shop_sessions.id', 'INNER'],
                        ['tbl_shop_spots', $this->table . '.spotId = tbl_shop_spots.id', 'INNER'],
                        ['tbl_shop_printers', 'tbl_shop_printers.id = tbl_shop_spots.printerId', 'INNER'],
                    ],
                    'conditions' => [
                        'ORDER_BY' => [$this->table . '.saveName', 'ASC']
                    ]
            ]);

            if (is_null($orders)) return null;

            $this->load->helper('utility_helper');

            return Utility_helper::resetArrayByKeyMultiple($orders, 'spotName');
        }

        public function deleteOrder(): bool
        {
            $where = [
                $this->table . '.orderId' => $this->orderId
            ];

            return $this->customDelete($where);
        }

    }
