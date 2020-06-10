<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopprinters_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $userId;
        public $printer;
        public $macNumber;
        public $active;

        private $table = 'tbl_shop_printers';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'userId') {
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
            if (isset($data['userId']) && isset($data['printer']) && isset($data['macNumber'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['userId']) && !Validate_data_helper::validateInteger($data['userId'])) return false;
            if (isset($data['printer']) && !Validate_data_helper::validateString($data['printer'])) return false;
            if (isset($data['macNumber']) && !Validate_data_helper::validateString($data['macNumber'])) return false;
            if (isset($data['active']) && !($data['active'] === '1' || $data['active'] === '0')) return false;

            return true;
        }
        public function fetchtProductPrinters(int $productId): ?array
        {
            return $this->read(
                [
                    $this->table . '.id AS printerId',
                    $this->table . '.printer AS printer',
                    $this->table . '.active AS printerActive',
                ],
                ['tbl_shop_product_printers.productId=' => $productId],
                [
                    ['tbl_shop_product_printers', $this->table .'.id = tbl_shop_product_printers.printerId' ,'INNER']
                ]
            );
        }

        public function fetchOrdersForPrint(): ?array
        {
            return $this->read(
                [
                    $this->table . '.id AS printerId',
                    $this->table . '.printer AS printer',
                    $this->table . '.active AS printerActive',

                    'tbl_shop_products.id AS productId',

                    'tbl_shop_products_extended.id AS productExtendedId',
                    'tbl_shop_products_extended.name AS productName',
                    'tbl_shop_products_extended.price AS productUnitPrice',
                    'tbl_shop_products_extended.shortDescription AS productShortDescription',

                    'tbl_shop_order_extended.id AS orderExtendedId',
                    'tbl_shop_order_extended.quantity AS orderExtendedQuantity',

                    'tbl_shop_orders.id AS orderId',
                    'tbl_shop_orders.amount AS orderAmount',

                    'tbl_user.username AS buyerUsername',
                    'tbl_user.email AS buyerEmail',
                    'CONCAT("0031", TRIM(LEADING "0" FROM tbl_user.mobile)) AS buyerMobile'
                ],
                [
                    $this->table . '.macNumber=' => $this->macNumber,
                    $this->table . '.active=' => '1',
                    'tbl_shop_orders.printStatus =' => '0',
                    'tbl_shop_orders.paid =' => '1',
                ],
                [
                    ['tbl_shop_product_printers', $this->table .'.id = tbl_shop_product_printers.printerId' ,'INNER'],
                    ['tbl_shop_products', 'tbl_shop_product_printers.productId = tbl_shop_products.id' ,'INNER'],
                    ['tbl_shop_products_extended', 'tbl_shop_products.id = tbl_shop_products_extended.productId' ,'INNER'],
                    ['tbl_shop_order_extended', 'tbl_shop_products_extended.id = tbl_shop_order_extended.productsExtendedId' ,'INNER'],
                    ['tbl_shop_orders', 'tbl_shop_order_extended.orderId = tbl_shop_orders.id' ,'INNER'],
                    ['tbl_user', 'tbl_shop_orders.buyerId = tbl_user.id' ,'INNER']
                ]
            );
        }
    }
