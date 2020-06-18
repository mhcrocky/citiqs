<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shoporder_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $buyerId;
        public $amount;
        public $serviceFee;
        public $paid;
        public $created;
        public $updated;
        public $orderStatus;
        public $sendSms;
        public $printStatus;
        public $spotId;

        private $table = 'tbl_shop_orders';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'buyerId') {
                $value = intval($value);
            }
            if ($property === 'amount') {
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
                isset($data['buyerId'])
                && isset($data['amount'])
                && isset($data['serviceFee'])
                && isset($data['paid'])
                && isset($data['spotId'])
            ) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            if (isset($data['buyerId']) && !Validate_data_helper::validateInteger($data['buyerId'])) return false;
            if (isset($data['amount']) && !Validate_data_helper::validateFloat($data['amount'])) return false;
            if (isset($data['serviceFee']) && !Validate_data_helper::validateFloat($data['serviceFee'])) return false;            
            if (isset($data['paid']) && !($data['paid'] === '1' || $data['paid'] === '0')) return false;
            if (isset($data['created']) && !Validate_data_helper::validateDate($data['created'])) return false;
            if (isset($data['updated']) && !Validate_data_helper::validateDate($data['updated'])) return false;
            if (isset($data['orderStatus']) && !Validate_data_helper::validateString($data['orderStatus'])) return false;
            if (isset($data['sendSms']) && !($data['sendSms'] === '1' || $data['sendSms'] === '0')) return false;
            if (isset($data['printStatus']) && !($data['printStatus'] === '1' || $data['printStatus'] === '0')) return false;
            if (isset($data['spotId']) && !Validate_data_helper::validateInteger($data['spotId'])) return false;
            return true;
        }

        public function fetchOne(): ?array
        {
            return $this->read(
                [
                    $this->table . '.id AS orderId',
                    $this->table . '.amount AS orderAmount',
                    $this->table . '.paid AS orderPaidStatus',
                    $this->table . '.serviceFee AS serviceFee',
                    'buyer.id AS buyerId',
                    'buyer.email AS buyerEmail',
                    'buyer.username AS buyerUserName',
                    'vendor.id AS vendorId',
                    'vendor.email AS vendorEmail',
                    'vendor.username AS vendorUserName',
                    'tbl_shop_spots.id AS spotId',
                    'tbl_shop_spots.spotName AS spotName'
                ],
                [
                    $this->table . '.id=' => $this->id
                ],
                [
                    ['tbl_shop_order_extended', $this->table . '.id = tbl_shop_order_extended.orderId', 'INNER'],
                    ['tbl_shop_products_extended', 'tbl_shop_order_extended.productsExtendedId  = tbl_shop_products_extended.id', 'INNER'],
                    ['tbl_shop_products', 'tbl_shop_products_extended.productId  = tbl_shop_products.id', 'INNER'],
                    ['tbl_shop_categories', 'tbl_shop_products.categoryId  = tbl_shop_categories.id', 'INNER'],
                    [
                        '(SELECT * FROM tbl_user WHERE roleid = '. $this->config->item('owner') .') vendor',
                        'vendor.id  = tbl_shop_categories.userId',
                        'INNER'
                    ],
                    [
                        '(SELECT * FROM tbl_user WHERE roleid = ' . $this->config->item('buyer') . ' OR roleid = ' . $this->config->item('owner') . ') buyer',
                        'buyer.id  = ' .  $this->table  . '.buyerId',
                        'INNER'
                    ],
                    ['tbl_shop_spots', $this->table . '.spotId = tbl_shop_spots.id', 'INNER']
                ],
                'limit',
                ['1']
            );


        }

        public function fetchOrderDetails(int $userId, string $paidStatus): ?array
        {
            return $this->read(
                [
                    $this->table . '.id AS orderId',
                    $this->table . '.amount AS orderAmount',
                    $this->table . '.paid AS orderPaidStatus',
                    $this->table . '.orderStatus AS orderStatus',
                    $this->table . '.sendSms AS sendSms',

                    'tbl_shop_categories.category AS category',
                    'buyer.id AS buyerId',
                    'buyer.email AS buyerEmail',
                    'buyer.username AS buyerUserName',
                    'CONCAT("0031", TRIM(LEADING "0" FROM buyer.mobile)) AS buyerMobile',
                    'buyer.mobile AS buyerRawMobile',
                    'vendor.id AS vendorId',
                    'vendor.email AS vendorEmail',
                    'vendor.username AS vendorUserName',
                    'tbl_shop_order_extended.quantity AS productQuantity',
                    'tbl_shop_products_extended.name AS productName',
                    'tbl_shop_spots.id AS spotId',
                    'tbl_shop_spots.spotName AS spotName'
                ],
                [
                    'vendor.id' => $userId,
                    $this->table . '.paid=' => $paidStatus
                ],
                [
                    ['tbl_shop_order_extended', $this->table . '.id = tbl_shop_order_extended.orderId', 'INNER'],
                    ['tbl_shop_products_extended', 'tbl_shop_order_extended.productsExtendedId  = tbl_shop_products_extended.id', 'INNER'],
                    ['tbl_shop_products', 'tbl_shop_products_extended.productId  = tbl_shop_products.id', 'INNER'],
                    ['tbl_shop_categories', 'tbl_shop_products.categoryId  = tbl_shop_categories.id', 'INNER'],
                    [
                        '(SELECT * FROM tbl_user WHERE roleid = '. $this->config->item('owner') .') vendor',
                        'vendor.id  = tbl_shop_categories.userId',
                        'INNER'
                    ],
                    [
                        '(SELECT * FROM tbl_user WHERE roleid = ' . $this->config->item('buyer') . ' OR roleid = ' . $this->config->item('owner') . ') buyer',
                        'buyer.id  = ' .  $this->table  . '.buyerId',
                        'INNER'
                    ],
                    ['tbl_shop_spots', $this->table . '.spotId = tbl_shop_spots.id', 'INNER']
                ],
                'order_by',
                [$this->table . '.updated ASC']
            );
        }

        public function fetchReportDetails(int $userId, string $from = '', string $to = ''): ?array
        {
            $where = [
                'vendor.id' => $userId
            ];

            if ($from && $to) {
                $where[$this->table .'.created>='] = $from;
                $where[$this->table .'.created<'] = $to;
            }

            return $this->read(
                [
                    $this->table . '.id AS orderId',
                    $this->table . '.amount AS orderAmount',
                    $this->table . '.paid AS orderPaidStatus',
                    $this->table . '.orderStatus AS orderStatus',
                    $this->table . '.sendSms AS sendSms',
                    $this->table . '.created AS createdAt',

                    // category
                    'tbl_shop_categories.id AS categoryId',
                    'tbl_shop_categories.category AS category',

                    //buyer
                    'buyer.id AS buyerId',
                    'buyer.email AS buyerEmail',
                    'buyer.username AS buyerUserName',
                    'CONCAT("0031", TRIM(LEADING "0" FROM buyer.mobile)) AS buyerMobile',
                    'buyer.mobile AS buyerRawMobile',

                    //vendor
                    'vendor.id AS vendorId',
                    'vendor.email AS vendorEmail',
                    'vendor.username AS vendorUserName',

                    // order extende
                    'tbl_shop_order_extended.quantity AS productQuantity',


                    // product
                    'tbl_shop_products.id AS productId',

                    // product extened
                    'tbl_shop_products_extended.name AS productName',
                    'tbl_shop_products_extended.id AS productEtendedId',
                    'tbl_shop_products_extended.price AS productPrice',
                    'tbl_shop_products_extended.vatpercentage AS productVat',

                    // spots
                    'tbl_shop_spots.id AS spotId',
                    'tbl_shop_spots.spotName AS spotName'
                ],
                $where,
                [
                    ['tbl_shop_order_extended', $this->table . '.id = tbl_shop_order_extended.orderId', 'INNER'],
                    ['tbl_shop_products_extended', 'tbl_shop_order_extended.productsExtendedId  = tbl_shop_products_extended.id', 'INNER'],
                    ['tbl_shop_products', 'tbl_shop_products_extended.productId  = tbl_shop_products.id', 'INNER'],
                    ['tbl_shop_categories', 'tbl_shop_products.categoryId  = tbl_shop_categories.id', 'INNER'],
                    [
                        '(SELECT * FROM tbl_user WHERE roleid = '. $this->config->item('owner') .') vendor',
                        'vendor.id  = tbl_shop_categories.userId',
                        'INNER'
                    ],
                    [
                        '(SELECT * FROM tbl_user WHERE roleid = ' . $this->config->item('buyer') . ' OR roleid = ' . $this->config->item('owner') . ') buyer',
                        'buyer.id  = ' .  $this->table  . '.buyerId',
                        'INNER'
                    ],
                    ['tbl_shop_spots', $this->table . '.spotId = tbl_shop_spots.id', 'INNER']
                ],
                'order_by',
                [$this->table . '.updated ASC']
            );
        }
    }
