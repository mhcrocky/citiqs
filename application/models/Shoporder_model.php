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
        public $transactionId;
        public $sendSmsDriver;

        private $table = 'tbl_shop_orders';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateInteger($value)) return;

            if ($property === 'id' || $property === 'buyerId') {
                $value = intval($value);
            }
            if ($property === 'amount' || $property === 'serviceFee') {
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
            if (isset($data['transactionId']) && !Validate_data_helper::validateString($data['transactionId'])) return false;
            if (isset($data['sendSmsDriver']) && !($data['sendSmsDriver'] === '1' || $data['sendSmsDriver'] === '0')) return false;

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

        public function fetchOrderDetails(array $where): ?array
        {
            $this->load->config('custom');
            $concatSeparator = $this->config->item('concatSeparator');
            $concatGroupSeparator = $this->config->item('contactGroupSeparator');
            $filter = [
                'what' => [
                    $this->table . '.id AS orderId',
                    $this->table . '.amount AS orderAmount',
                    $this->table . '.paid AS orderPaidStatus',
                    $this->table . '.orderStatus AS orderStatus',
                    $this->table . '.sendSms AS sendSms',
                    $this->table . '.sendSmsDriver AS sendSmsDriver',
                    $this->table . '.created AS orderCreated',
                    $this->table . '.updated AS orderUpdated',
                    'buyer.id AS buyerId',
                    'buyer.email AS buyerEmail',
                    'buyer.username AS buyerUserName',
                    'buyer.mobile AS buyerMobile',
                    'vendor.id AS vendorId',
                    'vendor.email AS vendorEmail',
                    'vendor.username AS vendorUserName',
                    'tbl_shop_spots.id AS spotId',
                    'tbl_shop_spots.spotName AS spotName',
                    'tbl_shop_spots.printerId AS spotPrinterId',
                    'tbl_shop_printers.printer AS spotPrinter',
                    'tblOrderedProducts.orderedProductDetails',
                    'tblOrderedProducts.productPrinterDetails'
                ],
                'where' => $where,
                'joins' => [
                    [
                        '(
                            SELECT
                                tbl_shop_order_extended.orderId,
                                GROUP_CONCAT(
                                    tbl_shop_products_extended.productId,
                                    \'' .  $concatSeparator . '\', tbl_shop_products_extended.name,
                                    \'' .  $concatSeparator . '\', tbl_shop_products_extended.price,
                                    \'' .  $concatSeparator . '\', tbl_shop_order_extended.quantity
                                    SEPARATOR "'. $concatGroupSeparator . '"
                                ) AS orderedProductDetails,
                                GROUP_CONCAT(
                                    tbl_shop_printers.printer,
                                    \'' .  $concatSeparator . '\', tbl_shop_product_printers.productId,
                                    \'' .  $concatSeparator . '\', tbl_shop_printers.id
                                    SEPARATOR "'. $concatGroupSeparator . '"
                                ) AS productPrinterDetails
                            FROM
                                tbl_shop_order_extended
                            INNER JOIN
                                tbl_shop_products_extended ON tbl_shop_products_extended.id = tbl_shop_order_extended.productsExtendedId
                            LEFT JOIN
                                tbl_shop_product_printers ON tbl_shop_product_printers.productId = tbl_shop_products_extended.productId
                            LEFT JOIN
                                tbl_shop_printers ON tbl_shop_printers.id = tbl_shop_product_printers.printerId
                            GROUP BY tbl_shop_order_extended.orderId
                            ORDER BY tbl_shop_products_extended.name ASC
                        ) tblOrderedProducts',
                        'tblOrderedProducts.orderId = ' . $this->table.'.id',
                        'LEFT'
                    ],
                    ['tbl_shop_order_extended', 'tbl_shop_order_extended.orderId = ' . $this->table . '.id ', 'INNER'],
                    ['tbl_shop_products_extended', 'tbl_shop_products_extended.id = tbl_shop_order_extended.productsExtendedId', 'INNER'],
                    ['tbl_shop_products', 'tbl_shop_products.id = tbl_shop_products_extended.productId', 'INNER'],
                    ['tbl_shop_categories', 'tbl_shop_categories.id = tbl_shop_products.categoryId  ', 'INNER'],
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
                    ['tbl_shop_spots', 'tbl_shop_spots.id =' . $this->table . '.spotId', 'INNER'],
                    ['tbl_shop_printers', 'tbl_shop_printers.id = tbl_shop_spots.printerId', 'INNER'],

                ],
                'conditions' => [
                    'group_by' => [$this->table . '.id'],
                    'order_by' => [$this->table . '.updated DESC']
                ]
            ];
            return $this->readImproved($filter);
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
                    'buyer.mobile AS buyerMobile',

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

        public function fetchOrdersForPrint(string $macNumber): ?array
        {
            $this->load->config('custom');
            $concatSeparator = $this->config->item('concatSeparator');
            $concatGroupSeparator = $this->config->item('contactGroupSeparator');

            $query =
            '
                (
                    SELECT
                        tbl_shop_orders.id AS orderId,
                        tbl_shop_orders.spotId,
                        tbl_shop_spots.spotName,
                        GROUP_CONCAT(tbl_shop_order_extended.id) AS orderExtendedIds,
                        tbl_shop_printers.id AS printerId,
                        tbl_shop_printers.printer AS printer,
                        tbl_user.username AS buyerUserName,
                        tbl_user.email AS buyerEmail,
                        tbl_user.mobile AS buyerMobile,
                        productData.products,
                        vendorOne.logo AS vendorLogo,
                        vendorOne.id as vendorId,
                        vendorOne.username as vendorName,
                        vendorOne.address as vendorAddress,
                        vendorOne.zipcode as vendorZipcode,
                        vendorOne.city as vendorCity,
                        vendorOne.vat_number as vendorVAT,
                        vendorOne.country as vendorCountry
                        
                    FROM
                        tbl_shop_orders
                    INNER JOIN
                        tbl_shop_spots ON tbl_shop_spots.id = tbl_shop_orders.spotId
                    INNER JOIN
                        tbl_user ON tbl_user.id = tbl_shop_orders.buyerId
                    INNER JOIN
                        (
                            SELECT
                                tbl_shop_order_extended.orderId,
                                GROUP_CONCAT(
                                    tbl_shop_products_extended.name,    
                                    \'' .  $concatSeparator . '\', tbl_shop_products_extended.price,
                                    \'' .  $concatSeparator . '\', tbl_shop_order_extended.quantity,
                                    \'' .  $concatSeparator . '\', tbl_shop_categories.category,
                                    \'' .  $concatSeparator . '\', tbl_shop_categories.id,
                                    \'' .  $concatSeparator . '\', IF (LENGTH(tbl_shop_products_extended.shortDescription) > 0, tbl_shop_products_extended.shortDescription, ""), 
                                    \'' .  $concatSeparator . '\', IF (LENGTH(tbl_shop_products_extended.longDescription) > 0, tbl_shop_products_extended.longDescription, ""),
                                    \'' .  $concatSeparator . '\', tbl_shop_products_extended.vatpercentage
                                    SEPARATOR "' . $this->config->item('contactGroupSeparator') . '"
                                ) AS products
                            FROM
                                tbl_shop_products_extended
                            INNER JOIN
                            tbl_shop_order_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
                        LEFT JOIN
                            tbl_shop_products ON tbl_shop_products_extended.productId = tbl_shop_products.id
                        LEFT JOIN
                            tbl_shop_categories ON tbl_shop_products.categoryId = tbl_shop_categories.id
                        LEFT JOIN
                            tbl_shop_product_printers ON tbl_shop_product_printers.productId = tbl_shop_products.id
                        LEFT JOIN
                            tbl_shop_printers ON tbl_shop_printers.id = tbl_shop_product_printers.printerId
                        WHERE
                            tbl_shop_product_printers.printerId = (SELECT tbl_shop_printers.id WHERE tbl_shop_printers.macNumber = "' . $macNumber . '")
                        GROUP BY
                            tbl_shop_order_extended.orderId
                    ) productData ON productData.orderId = tbl_shop_orders.id
                    INNER JOIN
                        tbl_shop_order_extended ON tbl_shop_order_extended.orderId = tbl_shop_orders.id
                    INNER JOIN
                        tbl_shop_products_extended ON tbl_shop_products_extended.id = tbl_shop_order_extended.productsExtendedId
                    INNER JOIN
                        tbl_shop_product_printers ON tbl_shop_product_printers.productId = tbl_shop_products_extended.productId
                    INNER JOIN
                        tbl_shop_printers ON tbl_shop_printers.id = tbl_shop_product_printers.printerId
                    INNER JOIN
                        (
                            SELECT
                                tbl_user.*
                            FROM
                                tbl_user
                            WHERE tbl_user.roleid = ' . $this->config->item('owner') . '
                        ) vendorOne ON vendorOne.id = tbl_shop_printers.userId
                    WHERE
                        tbl_shop_orders.paid = "1"
                        AND tbl_shop_order_extended.printed = "0"
                        AND tbl_shop_order_extended.printed = "0"
                        AND tbl_shop_printers.macNumber = "' . $macNumber . '"
                    GROUP BY
                        orderId
                )

                UNION ALL

                (
                    SELECT
                        tbl_shop_orders.id AS orderId,
                        tbl_shop_orders.spotId,
                        tbl_shop_spots.spotName,
                        GROUP_CONCAT(tbl_shop_order_extended.id) AS orderExtendedIds,
                        tbl_shop_printers.id AS printerId,
                        tbl_shop_printers.printer AS printer,
                        tbl_user.username AS buyerUserName,
                        tbl_user.email AS buyerEmail,
                        tbl_user.mobile AS buyerMobile,
                        productData.products,
                        vendorOne.logo AS vendorLogo,
                        vendorOne.id as vendorId,
                        vendorOne.username as vendorName,
                        vendorOne.address as vendorAddress,
                        vendorOne.zipcode as vendorZipcode,
                        vendorOne.city as vendorCity,
                        vendorOne.vat_number as vendorVAT,
                        vendorOne.country as vendorCountry
                    FROM 
                        tbl_shop_orders
                    INNER JOIN
                        tbl_shop_spots ON tbl_shop_spots.id = tbl_shop_orders.spotId
                    INNER JOIN
                        tbl_user ON tbl_user.id = tbl_shop_orders.buyerId
                    INNER JOIN
                        tbl_shop_order_extended ON tbl_shop_order_extended.orderId = tbl_shop_orders.id
                    INNER JOIN
                        tbl_shop_printers  ON tbl_shop_printers.id  = tbl_shop_spots.printerId  
                    INNER JOIN
                        (
                            SELECT
                                tbl_shop_order_extended.orderId,
                                GROUP_CONCAT(
                                    tbl_shop_products_extended.name,    
                                    \'' .  $concatSeparator . '\', tbl_shop_products_extended.price,
                                    \'' .  $concatSeparator . '\', tbl_shop_order_extended.quantity,
                                    \'' .  $concatSeparator . '\', tbl_shop_categories.category,
                                    \'' .  $concatSeparator . '\', tbl_shop_categories.id,
                                    \'' .  $concatSeparator . '\', IF (LENGTH(tbl_shop_products_extended.shortDescription) > 0, tbl_shop_products_extended.shortDescription, ""), 
                                    \'' .  $concatSeparator . '\', IF (LENGTH(tbl_shop_products_extended.longDescription) > 0, tbl_shop_products_extended.longDescription, ""),
                                    \'' .  $concatSeparator . '\', tbl_shop_products_extended.vatpercentage
                                    SEPARATOR "'. $this->config->item('contactGroupSeparator') . '"
                                ) AS products
                            FROM
                                tbl_shop_products_extended
                            INNER JOIN
                                tbl_shop_order_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
                            LEFT JOIN
                                tbl_shop_products ON tbl_shop_products_extended.productId = tbl_shop_products.id
                            LEFT JOIN
                                tbl_shop_categories ON tbl_shop_products.categoryId = tbl_shop_categories.id
                            LEFT JOIN
                                tbl_shop_orders ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
                            LEFT JOIN
                                tbl_shop_spots ON tbl_shop_spots.id = tbl_shop_orders.spotId
                            WHERE
                                tbl_shop_order_extended.id not in 
                                    (
                                        SELECT
                                            tbl_shop_order_extended.id
                                        FROM
                                            tbl_shop_order_extended
                                        INNER JOIN
                                            tbl_shop_products_extended ON tbl_shop_products_extended.id = tbl_shop_order_extended.productsExtendedId
                                        INNER JOIN	
                                            tbl_shop_products ON tbl_shop_products.id = tbl_shop_products_extended.productId
                                        INNER JOIN
                                            tbl_shop_product_printers ON tbl_shop_product_printers.productId = tbl_shop_products.id
                                        INNER JOIN
                                            tbl_shop_printers ON tbl_shop_printers.id = tbl_shop_product_printers.printerId
                                        WHERE 
                                            tbl_shop_printers.macNumber != "' . $macNumber . '"
                                    )
                                GROUP BY  tbl_shop_order_extended.orderId
                        ) productData ON productData.orderId = tbl_shop_orders.id 
                    INNER JOIN
                        (
                            SELECT
                                tbl_user.*
                            FROM
                                tbl_user
                            WHERE tbl_user.roleid = ' . $this->config->item('owner') . '
                        ) vendorOne ON vendorOne.id = tbl_shop_printers.userId
                    WHERE
                        tbl_shop_orders.paid = "1"
                        AND tbl_shop_order_extended.printed = "0"
                        AND tbl_shop_printers.macNumber = "' . $macNumber . '"
                        AND tbl_shop_order_extended.id not in
                            (
                                SELECT
                                    tbl_shop_order_extended.id
                                FROM
                                    `tbl_shop_order_extended`
                                INNER JOIN
                                    tbl_shop_products_extended ON tbl_shop_products_extended.id = tbl_shop_order_extended.productsExtendedId
                                INNER JOIN	
                                    tbl_shop_products ON tbl_shop_products.id = tbl_shop_products_extended.productId
                                INNER JOIN
                                    tbl_shop_product_printers ON tbl_shop_product_printers.productId = tbl_shop_products.id
                                INNER JOIN
                                    tbl_shop_printers ON tbl_shop_printers.id = tbl_shop_product_printers.printerId
                                WHERE 
                                    tbl_shop_printers.macNumber != "' . $macNumber . '"
                            )
                    GROUP BY
                        orderId
                )

                LIMIT 1;
            ';
            $result = $this->db->query($query);
            $result = $result->result_array();

            return $result ? $result : null;
        }

        /**
         * updatePrintedStatus
         * 
         * Update printer status to 1 for all printed orders for all users
         *
         * @return void
         */
        public function updatePrintedStatus(): void
        {
            $query  = 'UPDATE ' . $this->table . ' ';
            $query .= 'set ' . $this->table . '.printStatus = "1" ';
            $query .= 'WHERE ' . $this->table . '.id NOT IN ';
            $query .= '(SELECT tbl_shop_order_extended.orderId FROM tbl_shop_order_extended WHERE tbl_shop_order_extended.printed = "0" GROUP BY tbl_shop_order_extended.orderId)';

            $this->db->query($query);
        }

        public function updatePaidStatus(array $what): void
        {
            $update = $this
                        ->db
                            ->where('transactionId', $this->transactionId)
                            ->update($this->table, $what);
            if (!$update) {
                $this->load->helper('utility_helper');
                $file = FCPATH . 'application/tiqs_logs/messages.txt';
                $message = 'Order with transactionId "tbl_shop_orders.' . $$this->transactionId . '" not updated';
                Utility_helper::logMessage($file, $message);
            }
        }

        public function setOrderIdFromTransactionId(): Shoporder_model
        {
            $result =
                $this->
                    readImproved([
                        'what' => ['id'],
                        'where' => ['transactionId=' => $this->transactionId]
                    ]);

            $this->id = reset($result)['id'];
            $this->id = intval($this->id);
            return $this;
        }

        public function ordersToSendSmsToDriver(): ?array
        {
            $this->load->config('custom');
            return $this->readImproved([
                'what'  => [
                    'tbl_shop_orders.id as orderId',
                    'tbl_shop_orders.updated AS orderUpdate',
                    'tbl_shop_orders.spotId AS spotId',
                    'tbl_user.username AS vendorName',
                    'tbl_shop_categories.driverNumber AS driverNumber',
                    'tbl_shop_categories.delayTime as delayTime',
                    'tbl_shop_categories.category AS categoryName',
                    'tbl_shop_spots.spotName AS spotName'
                ],
                'where' => [
                    // 'tbl_shop_orders.orderStatus=' => $this->config->item('orderDone'),
                    // automatically sending means that the order should also be set to done automatically.
                    // because 8 minutes is the preparation time and otherwise it is cold.

                    $this->table . '.printStatus' => '1',
                    $this->table . '.sendSmsDriver' => '0',
                    'tbl_shop_categories.sendSms' => '1'
                ],
                'joins' => [
                    ['tbl_shop_order_extended', 'tbl_shop_order_extended.orderId = tbl_shop_orders.id', 'LEFT'],
                    ['tbl_shop_products_extended', 'tbl_shop_products_extended.id = tbl_shop_order_extended.productsExtendedId', 'LEFT'],
                    ['tbl_shop_products', 'tbl_shop_products_extended.productId  = tbl_shop_products.id', 'LEFT'],
                    ['tbl_shop_categories', 'tbl_shop_categories.id = tbl_shop_products.categoryId', 'LEFT'],
                    ['tbl_user', 'tbl_user.id = tbl_shop_categories.userId', 'LEFT'],
                    ['tbl_shop_vendors', 'tbl_shop_vendors.vendorId = tbl_user.id', 'LEFT'],
                    ['tbl_shop_spots', 'tbl_shop_spots.id = tbl_shop_orders.spotId', 'LEFT']
                ],
                'conditions' => [
                    'GROUP_BY' => ['tbl_shop_orders.id']
                ]
            ]);
        }

        private function prepareProductDetails(
            string $productDetails,
            ?string $printerDetails,
            string $groupSeparator,
            string $concatSeparator,
            string $spotPrinter,
            string $selectedPrinter
        ): ?array
        {   
            if (!is_null($printerDetails)) {
                $printerDetails = $this->preparePrinterDetails($printerDetails, $groupSeparator, $concatSeparator);
            }

            $productDetails =  explode($groupSeparator, $productDetails);
            $productDetails = array_map(function($data) use($concatSeparator, $printerDetails, $spotPrinter, $selectedPrinter) {
                $data = explode($concatSeparator, $data);
                $printerData = isset($printerDetails[$data[0]]) ? reset($printerDetails[$data[0]]) : null;
                if (!$selectedPrinter) {
                    return [
                        'productId' => $data[0],
                        'productName' => $data[1],
                        'productPrice' => $data[2],
                        'productQuantity' => $data[3],
                        'productPrinter' => $printerData,
                    ];
                } else {
                    if (
                        (!$printerData && $spotPrinter === $selectedPrinter)
                        || ($printerData && $selectedPrinter == $printerData[2])
                    ) {
                        return [
                            'productId' => $data[0],
                            'productName' => $data[1],
                            'productPrice' => $data[2],
                            'productQuantity' => $data[3],
                            'productPrinter' => $printerData,
                        ];
                    }
                }
            }, $productDetails);
            return $productDetails;
        }

        private function preparePrinterDetails(string $printerDetails, string $groupSeparator, string $concatSeparator): array
        {
            $printerDetails =  explode($groupSeparator, $printerDetails);
            $printerDetails = array_map(function($data) use($concatSeparator) {                
                return explode($concatSeparator, $data);
            }, $printerDetails);

            $this->load->helper('utility_helper');
            $printerDetails = Utility_helper::resetArrayByKeyMultiple($printerDetails, '1');
            return $printerDetails;
        }

        public function fetchOrderDetailsJquery(array $where, $selectedPrinter): ?array
        {
            $result = $this->fetchOrderDetails($where);
            if (is_null($result)) return null;

            $this->load->config('custom');
            $this->load->helper('jquerydatatable_helper');

            $concatSeparator = $this->config->item('concatSeparator');
            $concatGroupSeparator = $this->config->item('contactGroupSeparator');
            $return = [];

            foreach ($result as $index => $details) {
                if ($details['orderedProductDetails']) {
                    $fineDetails = $this->prepareProductDetails(
                                        $details['orderedProductDetails'],
                                        $details['productPrinterDetails'],
                                        $concatGroupSeparator, 
                                        $concatSeparator,
                                        $details['spotPrinterId'],
                                        $selectedPrinter
                                    );

                    if ($fineDetails[0]) {
                        $result[$index]['orderedProductDetails'] = $fineDetails;
                        $result[$index]['orderedProductDetails']['spotPrinter'] = $result[$index]['spotPrinter'];
                        unset($result[$index]['productPrinterDetails']);
                        array_push($return, $result[$index]);
                    }
                }
            }

            $columns = array(
                array( 'db' => 'orderId',               'dt' => 0),
                array( 'db' => 'orderedProductDetails', 'dt' => 1),
                array( 'db' => 'orderAmount',           'dt' => 2),
                array( 'db' => 'spotName',              'dt' => 3),
                array( 'db' => 'orderStatus',           'dt' => 4),
                array( 'db' => 'orderUpdated',          'dt' => 5),
                array( 'db' => 'buyerUserName',         'dt' => 6),
                array( 'db' => 'buyerEmail',            'dt' => 7),
                array( 'db' => 'buyerMobile',           'dt' => 8),
                array( 'db' => 'sendSms',               'dt' => 9),
                array( 'db' => 'buyerId',               'dt' => 10),
            );

            return Jquerydatatable_helper::data_output($columns, $return);
        }

    }
