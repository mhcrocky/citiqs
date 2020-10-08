<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shopimport_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $vendorId;
        public $imported;

        private $table = 'tbl_shop_imported';

        private $connection;
        
        private $dbUserName;
        private $dbPassword;
        private $dbName;

        private $vendor;
        private $categoryId;
        private $printerId;
        private $spotId;
        private $mainProductTypeId;

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateInteger($value)) return;

            if ($property === 'id' || $property === 'vendorId') {
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
            if ( isset($data['vendorId']) && isset($data['imported']) ) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;
            
            if (isset($data['vendorId']) && !Validate_data_helper::validateInteger($data['vendorId'])) return false;
            if (isset($data['imported']) && !($data['imported'] === '1' || $data['imported'] === '0')) return false;

            return true;
        }

        public function setDatabaseCredantations(array $data): Shopimport_model
        {
            $this->dbUserName = $data['username'];
            $this->dbPassword = $data['password'];
            $this->dbName = $data['database'];

            return $this;
        }

        public function setConnection(): Shopimport_model
        {
            $shopDatabase = array(
                'dsn'	=> '',
                'hostname' => 'localhost',
                'username' => $this->dbUserName,
                'password' => $this->dbPassword,
                'database' => $this->dbName,
                'dbdriver' => 'mysqli',
                'dbprefix' => '',
                'pconnect' => FALSE,
                'db_debug' => (ENVIRONMENT !== 'production'),
                'cache_on' => FALSE,
                'cachedir' => '',
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
                'swap_pre' => '',
                'encrypt' => FALSE,
                'compress' => FALSE,
                'stricton' => FALSE,
                'failover' => array(),
                'save_queries' => TRUE
            );

            $this->connection = $this->load->database($shopDatabase, true);
            return $this;
        }

        public function import(): bool
        {

            if ($this->isImported()) {
                die('Vendor data already imported');
            };

            $this->setObjectFromArray(['vendorId' => $this->vendorId, 'imported' => '1'])->create();

            if (!$this->vendor || !$this->mainProductTypeId || !$this->categoryId || !$this->printerId || !$this->spotId ) {
                die('Required values are not set!');
            }

            $shopOrders = $this->fetchOrders();

            $allOrders = [];
            $allExtendedOrders = [];
            foreach ($shopOrders as $shopOrder) {
                
                // insert client
                $this->manageClient($shopOrder);
                if (!$this->user_model->id) return false;

                // insert product and product extended
                $products = unserialize($shopOrder['orderProduct']);                
                $alfredOrderExtendedId = [];
                $money = 0;

                foreach($products as $product) {
                    $productExtendedId = $this->getProductExtendedId($product);
                    $alfredOrderExtendedId[$productExtendedId] = [
                        'quantity' =>  $product['product_quantity']
                    ];
                    $money = $money + floatval($product['product_info']['price']) * intval($product['product_quantity']);
                }

                // insert order
                $dateTime = date('Y-m-d H:i:s', intval($shopOrder['orderTimestamp']));
                $serviceFee = $money * $this->vendor['serviceFeePercent'] / 100;
                if ($serviceFee > $this->vendor['serviceFeeAmount']) {
                    $serviceFee = $this->vendor['serviceFeeAmount'];
                }
                $serviceFee = number_format($serviceFee, 2, '.', ',');

                $alfredOrder = [
                    'buyerId'       => $this->user_model->id,
                    'amount'        => $money,
                    'serviceFee'    => $serviceFee,
                    'paid'          => '1',
                    'created'       => $dateTime,
                    'updated'       => $dateTime,
                    'orderStatus'   => 'finished',
                    'sendSms'       => '1',
                    'printStatus'   => '1',
                    'spotId'        => $this->spotId,
                    'transactionId' => $shopOrder['orderTransactionId'],
                    'old_order'     => $shopOrder['orderNumber'],
                ];

                $this->load->model('shoporder_model');
                $this->shoporder_model->setObjectFromArray($alfredOrder)->create();
                if (!$this->shoporder_model->id) return false;
    
                // insert order extended
                $this->load->model('shoporderex_model');

                // insert order details
                foreach ($alfredOrderExtendedId as $id => $details) {
                    $details['productsExtendedId'] = intval($id);
                    $details['orderId'] = $this->shoporder_model->id;
                    if (!$this->shoporderex_model->setObjectFromArray($details)->create()) {
                        $this->shoporderex_model->orderId = $details['orderId'];
                        $this->shoporderex_model->deleteOrderDetails();
                        $this->shoporder_model->delete();
                        return false;
                    }
                }
            }
            return true;
        }

        public function setMainProductTypeId(): Shopimport_model
        {
            $query  = 'SELECT tbl_shop_products_types.id FROM tbl_shop_products_types ';
            $query .= 'WHERE tbl_shop_products_types.vendorId = ' . $this->vendorId . ' AND isMain = "1";';

            $result = $this->db->query($query);
            $result = $result->result_array();

            $this->mainProductTypeId =  empty($result) ? 0 : intval(reset($result)['id']);

            return $this;
        }

        public function setVendorCategoryId(): Shopimport_model
        {
            $this->load->model('shopcategory_model');

            $insert = [
                'category' => 'IMPORTED CATEGORY',
                'userId' => $this->vendorId,
                'archived' => '1',
                'active' => '0',
            ];

            $this->shopcategory_model->setObjectFromArray($insert)->create();
            $this->categoryId =  $this->shopcategory_model->id;

            return $this;
        }

        public function setVendorPrinterId(): Shopimport_model
        {
            $this->load->model('shopprinters_model');

            $printerMac = 'IMPORTED PRINTER ' . $this->vendorId;
            $insert = [
                'printer' => 'IMPORTED PRINTER',
                'userId' => $this->vendorId,
                'macNumber' => $printerMac,
                'archived' => '1',
                'active' => '0',
            ];

            $this->shopprinters_model->setObjectFromArray($insert)->create();
            $this->printerId =  $this->shopprinters_model->id;

            return $this;
        }

        public function setVendorSpotId(): Shopimport_model
        {
            $this->load->model('shopspot_model');
            $this->load->config('custom');

            $insert = [
                'printerId' => $this->printerId,
                'spotName' => 'IMPORT SPOT',
                'active' => '0',
                'spotTypeId' => $this->config->item('local'),
                'archived' => '1',
            ];

            $this->shopspot_model->setObjectFromArray($insert)->create();
            $this->spotId =  $this->shopspot_model->id;

            return $this;
        }

        private function fetchOrders(): array
        {
            $query = 
                "SELECT
                    orders.order_id AS orderNumber,
                    orders.products as orderProduct,
                    orders.date AS orderTimestamp,
                    orders.transactionid AS orderTransactionId,
                    orders.spot_id AS orderSpotId,
                    orders_clients.first_name AS clientFirtsName,
                    orders_clients.last_name AS clientLastName,
                    orders_clients.email AS clientEmail,
                    orders_clients.phone AS clientPhone
                FROM
                    orders
                INNER JOIN
                    orders_clients ON orders.id = orders_clients.for_id
                WHERE 
                    orders.processed = 1 AND orders.confirmed = 1;";

            $result = $this->connection->query($query);
            return $result->result_array();
        }

        private function manageClient(array $data)
        {
            $user = [
                'email' => $data['clientEmail'],
                'country' => '',
                'mobile' => $data['clientPhone'],
                'roleid' => '6',
                'usershorturl' => 'tiqs_shop_service',
                'salesagent' => '6'
            ];
            
            if (is_null($data['clientFirtsName']) && is_null($data['clientLastName'])) {
                $user['username'] = 'Anonymous';
            } else {
                $user['username'] = strval($data['clientFirtsName']) . ' ' . strval($data['clientLastName']);
            }

            $this->load->model('user_model');            
            $this->user_model->manageAndSetBuyer($user);
        }

        public function setShopVendor(): Shopimport_model
        {
            $this->load->model('shopvendor_model');
            $this->vendor = $this->shopvendor_model->setProperty('vendorId', $this->vendorId)->getVendorData();

            return $this;
        }



        private function getProductExtendedId(array $product) 
        {
            $oldProductName = 'old_' . $product['product_info']['title'];
            $query = 

            'SELECT
	            tbl_shop_products_extended.*
            FROM
	            tbl_shop_categories
            LEFT JOIN
	            tbl_shop_products ON tbl_shop_products.categoryId = tbl_shop_categories.id
            LEFT JOIN
	            tbl_shop_products_extended ON tbl_shop_products_extended.productId = tbl_shop_products.id
            WHERE
                tbl_shop_categories.userId = ' . $this->vendorId . '
                AND tbl_shop_categories.id = ' . $this->categoryId . '
                AND tbl_shop_products_extended.name = "' . $oldProductName . '";';
            $result = $this->db->query($query);
            $result = $result->result_array();

            if (empty($result)) {
                // insert product
                $this->load->model('shopproduct_model');
                $this->shopproduct_model->setObjectFromArray([
                    'categoryId' => $this->categoryId,
                    'active' => '0',
                    'archived' => '1',
                    'dateTimeFrom' => date('2020-06-01 00:00:00'),
                    'dateTimeTo' => date('2020-09-01 00:00:00'),

                ])->create();

                // insert product ex
                $this->load->model('shopproductex_model');
                $porductExtended = [
                    'productId'         => $this->shopproduct_model->id,
                    'name'              => $oldProductName,
                    'shortDescription'  => $oldProductName,
                    'price'             => $product['product_info']['price'],
                    'productTypeId'     => $this->mainProductTypeId,
                    'updateCycle'       => 1,
                    'vatpercentage'     => $this->getShopProductVat(strval($product['product_info']['url'])),
                    'showInPublic'      => '0',
                    'archived'          => '1'
                ];
                $this->shopproductex_model->setObjectFromArray($porductExtended)->create();

                // insert times
                $this->load->model('shopproducttime_model');
                // $this->shopproducttime_model->insertProductTimes($this->shopproduct_model->id);
                return $this->shopproductex_model->id;
            } else {
                $countResult = count($result);
                $lastIndex = $countResult - 1;
                $lastInsertedProduct = $result[$lastIndex];
                if ($lastInsertedProduct['price'] === $product['product_info']['price']) {
                    return $lastInsertedProduct['id'];
                } else {
                    $lastInsertedProduct['updateCycle'] = $countResult;
                    $lastInsertedProduct['price'] = $product['product_info']['price'];
                    $lastInsertedProduct['showInPublic'] = '0';
                    $lastInsertedProduct['archived'] = '1';
                    $this->shopproductex_model->setObjectFromArray($lastInsertedProduct)->create();
                    return $this->shopproductex_model->id;
                }                
            }
        }

        private function getShopProductVat(string $key): int
        {
            $query = 'SELECT products.vatpercentage FROM products WHERE products.url = "' .  $key . '";';

            $result = $this->connection->query($query);
            $result = $result->result_array();

            return empty($result) ? 21 : intval(reset($result)['vatpercentage']);
        }

        private function isImported(): bool
        {
            $filter = [
                'what' => ['id'],
                'where' => [
                    'imported=' => '1',
                    'vendorId=' => $this->vendorId
                ]
            ];

            return $this->readImproved($filter) ? true : false;
        }
    }
   