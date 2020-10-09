<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shoporderex_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $orderId;
        public $productsExtendedId;
        public $quantity;
        public $printed;
        public $remark;
        public $mainPrductOrderIndex;
        public $subMainPrductOrderIndex;

        private $table = 'tbl_shop_order_extended';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateInteger($value)) return;

            if ($property === 'id' || $property === 'orderId' || $property === 'productsExtendedId') {
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
            if (isset($data['orderId']) && isset($data['productsExtendedId']) && isset($data['quantity'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['orderId']) && !Validate_data_helper::validateInteger($data['orderId'])) return false;
            if (isset($data['productsExtendedId']) && !Validate_data_helper::validateInteger($data['productsExtendedId'])) return false;
            if (isset($data['quantity']) && !Validate_data_helper::validateInteger($data['quantity'])) return false;
            if (isset($data['printed']) && !($data['printed'] === '1' || $data['printed'] === '0' || $data['printed'] === '2')) return false;
            if (isset($data['remark']) && !Validate_data_helper::validateString($data['remark'])) return false;
            if (isset($data['mainPrductOrderIndex']) && !Validate_data_helper::validateInteger($data['mainPrductOrderIndex'])) return false;
            if (isset($data['subMainPrductOrderIndex']) && !Validate_data_helper::validateInteger($data['subMainPrductOrderIndex'])) return false;
            
            return true;
        }

        public function deleteOrderDetails(): bool
        {
            $where = ['orderId=' => $this->orderId];
            return $this->db->delete($this->getThisTable(), $where);
        }

        public function updateTwoToZero()
        {
            $date = date('Y-m-d H:i:s', strtotime('-2 minutes'));
            $query  = 'UPDATE tbl_shop_order_extended set printed = "0" ';
            $query .= 'WHERE printed = "2" AND orderId IN (SELECT id FROM tbl_shop_orders WHERE created > "' . $date . '");';
            $this->db->query($query);
        }
    }
