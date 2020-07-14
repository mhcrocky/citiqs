<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';

    class Warehouse extends BaseControllerWeb
    {

        public function __construct()
        {
            parent::__construct();

            $this->load->helper('url');
            $this->load->helper('validate_data_helper');
            $this->load->helper('utility_helper');

            // $this->load->model('user_subscription_model');
            $this->load->model('shopcategory_model');
            $this->load->model('shopproduct_model');
            $this->load->model('shopproductex_model');
            $this->load->model('shoporder_model');
            $this->load->model('shoporderex_model');
            $this->load->model('shopprinters_model');
            $this->load->model('shopproductprinters_model');
            $this->load->model('shopspot_model');
            $this->load->model('shopspotproducts_model');
            $this->load->model('shopproducttime_model');
            $this->load->model('shopprodutctype_model');
            $this->load->model('shopproductaddons_model');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');

            $this->load->config('custom');

            $this->isLoggedIn();
        }

        /**
         * Reports
         *
         * @return void
         */
        public function index(): void
        {
            $this->global['pageTitle'] = 'TIQS : WAREHOSUE';

            $userId = intval($_SESSION['userId']);
            $data = [];
            if (!empty($_POST)) {
                $data = $this->input->post(null, true);
                $reportsData = $this->shoporder_model->fetchReportDetails($userId, $data['from'], $data['to']);
            } else {
                $reportsData = $this->shoporder_model->fetchReportDetails($userId);
            }

            if ($reportsData) {
                $data = [
                    'reports' => [
                        'orders' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'orderId'),
                        'categories' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'category'),
                        'spots' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'spotId'),
                        'buyers' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'buyerId'),
                        'products' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'productId')
                    ]
                ];
            }

            $this->loadViews('warehouse/warehouse', $this->global, $data, null, 'headerWarehouse');
        }

        // CATEGORIES
        /**
         * Read and filter categoires
         *
         * @return void
         */
        public function productCategories(): void
        {
            $this->global['pageTitle'] = 'TIQS : CATEGOIRES';

            $where['userId'] = intval($_SESSION['userId']);
            if (isset($_GET['active']) && ($_GET['active'] === '0' || $_GET['active'] === '1')) {
                $where['active'] = $_GET['active'];
            }

            $data = [
                'userId' => intval($_SESSION['userId']),
                'categories' => $this->shopcategory_model->fetch($where),
            ];

            $this->loadViews('warehouse/productCategories', $this->global, $data, null, 'headerWarehouse');
            return;
        }

        /**
         * Insert category
         *
         * @return void
         */
        public function addCategory(): void
        {
            $data = $this->input->post(null, true);

            if ($this->shopcategory_model->checkIsInserted($data)) {
                $this->session->set_flashdata('error', 'Insert failed! Role with this name already inserted');
            } elseif ($this->shopcategory_model->setObjectFromArray($data)->create()) {
                $this->session->set_flashdata('success', 'Category "' . $data['category'] . '" created!');
            } else {
                $this->session->set_flashdata('error', 'Insert failed! Please try again.');
            }

            redirect('product_categories');
            return;
        }

        /**
         * Update category
         *
         * @return void
         */
        public function editCategory(): void
        {
            $data = Validate_data_helper::validateInteger($this->uri->segment(4)) ?
                            ['active' => $this->uri->segment(4)] : $this->input->post(null, true);

            if(isset($data['category']) && $this->shopcategory_model->checkIsInserted($data)) {
                $this->session->set_flashdata('error', 'Update failed! Role with name "' . $data['category'] . '" already inserted');
                redirect('product_categories');
            }

            $update =   $this
                        ->shopcategory_model
                        ->setObjectId(intval($this->uri->segment(3)))
                        ->setObjectFromArray($data)
                        ->update();

            if ($update) {
                $this->session->set_flashdata('success', 'Category updated');
            } else {
                $this->session->set_flashdata('error', 'Update failed! Please try again.');
            }

            redirect('product_categories');
            return;
        }

        // PRODUCTS
        /**
         * Read products
         *
         * @return void
         */
        public function products(): void
        {
            $this->global['pageTitle'] = 'TIQS : PRODUCTS';
            $userId = intval($_SESSION['userId']);

            $where = ['userId' => $userId];
            $data = [
                'categories' => $this->shopcategory_model->fetch($where),
                'products' => $this->shopproductex_model->getUserProducts($userId),
                'printers' => $this->shopprinters_model->read(['*'], $where),
                'userSpots' => $this->shopspot_model->fetchUserSpots($userId),
                'separator' => $this->config->item('contactGroupSeparator'),
                'productTypes' => $this->shopprodutctype_model->fetchProductTypes($userId),
            ];

            // echo '<pre>';
            // print_r($data['products']);
            // echo '</pre>';
            // die();
            $this->loadViews('warehouse/products', $this->global, $data, null, 'headerWarehouse');
            return;
        }

        /**
         * Insert product
         *
         * @return void
         */
        public function addProdcut(): void
        {

            $data = $this->input->post(null, true);
            $userId = intval($_SESSION['userId']);

            //CHECK PRODUCT NAME
            $where = [
                'tbl_shop_categories.userId' => $userId,
                'tbl_shop_products_extended.name=' => $data['productExtended']['name']
            ];

            if ($this->shopproductex_model->checkProductName($where)) {
                $this->session->set_flashdata('error', 'Product with this name already exists! Insert failed');
                redirect('products');
            };

            // insert product
            if ($data['product']['dateTimeFrom'] && $data['product']['dateTimeTo']) {
                $data['product']['dateTimeFrom'] = date('Y-m-d H:i:s', strtotime($data['product']['dateTimeFrom']));
                $data['product']['dateTimeTo'] = date('Y-m-d H:i:s', strtotime($data['product']['dateTimeTo']));
            }

            if (!$this->shopproduct_model->setObjectFromArray($data['product'])->create()) {
                $this->session->set_flashdata('error', 'Product insert failed! Please try again.');
                redirect('products');
            };

            // insert product extended
            $countTypes = 0;
            foreach($data['productTypes'] as $typeId => $typeValues) {
                if (isset($typeValues['check'])) {
                    $countTypes++;
                    $data['productExtended']['productId'] = $this->shopproduct_model->id;
                    $data['productExtended']['productTypeId'] = intval($typeId);
                    $data['productExtended']['price'] = floatval($typeValues['price']);
                    $data['productExtended']['updateCycle'] = 1;
                    $data['productExtended']['showInPublic'] = '1';                    
                    if(!$this->shopproductex_model->setObjectFromArray($data['productExtended'])->create()) {
                        $this->shopproduct_model->delete();
                        $this->session->set_flashdata('error', 'Product insert failed! Please try again.');
                        redirect('products');
                    };
                }
            }

            if ($countTypes === 0) {
                $this->shopproduct_model->delete();
                $this->session->set_flashdata('error', 'Please select product type(s).');
                redirect('products');
            }
            

            // insert product printers
            foreach($data['productPrinters'] as $printerId) {
                $printerInsert = [
                    'printerId' => $printerId,
                    'productId' => $this->shopproduct_model->id
                ];
                if (!$this->shopproductprinters_model->setObjectFromArray($printerInsert)->create()) {
                    $this->session->set_flashdata('error', 'Pinter insert failed. Please check');
                }
                break;
            }

            //insert product available times
            $this->shopproducttime_model->insertProductTimes($this->shopproduct_model->id);

            $this->session->set_flashdata('success', 'Product inserted.');
            redirect('products');
            return;
        }

        /**
         * Update product
         *
         * @return void
         */
        public function editProduct(): void
        {

            $data = $this->input->post(null, true);
            $productId = intval($this->uri->segment(3));
            $userId = intval($_SESSION['userId']);

            // CHECK PRODUCT NAME
            $where = [
                'tbl_shop_categories.userId' => $userId,
                'tbl_shop_products_extended.productId !=' => $productId,
                'tbl_shop_products_extended.name=' => $data['productExtended']['name']
            ];

            if ($this->shopproductex_model->checkProductName($where)) {
                $this->session->set_flashdata('error', 'Product with this name already exists! Update failed');
                redirect('products');
            };

            // update
            if ($data['product']['dateTimeFrom'] && $data['product']['dateTimeTo']) {
                $data['product']['dateTimeFrom'] = date('Y-m-d H:i:s', strtotime($data['product']['dateTimeFrom']));
                $data['product']['dateTimeTo'] = date('Y-m-d H:i:s', strtotime($data['product']['dateTimeTo']));
            }

            $update = $this
                    ->shopproduct_model
                    ->setObjectId($productId)
                    ->setObjectFromArray($data['product'])
                    ->update();

            // insert new product extended deatils
            $countTypes = 0;
            foreach($data['productTypes'] as $typeId => $typeValues) {
                if (isset($typeValues['check'])) {                    
                    $countTypes++;
                    $data['productExtended']['productId'] = $this->shopproduct_model->id;
                    $data['productExtended']['productTypeId'] = intval($typeId);
                    $data['productExtended']['price'] = floatval($typeValues['price']);
                    if (isset($typeValues['showInPublic'])) {
                        $data['productExtended']['showInPublic'] = '1';
                    } else {
                        $data['productExtended']['showInPublic'] = '0';
                    }

                    if(!$this->shopproductex_model->setObjectFromArray($data['productExtended'])->create()) {
                        $insert = false;
                        break;
                    };
                }
                $insert = true;
            }


            if ($insert && $update && $countTypes > 0 ) {
                $this->session->set_flashdata('success', 'Product updated');
            } else {
                if ($countTypes === 0) {
                    $this->session->set_flashdata('error', 'Update failed! Please select product type(s)');
                } else {
                    $this->session->set_flashdata('error', 'Update failed! Please try again.');
                }                
            }

            // PRINTERS
            $this->shopproductprinters_model->productId = $this->shopproduct_model->id;
            $this->shopproductprinters_model->deleteProductPrinters();
            if (isset($data['productPrinters'])) {                    

                foreach($data['productPrinters'] as $printerId) {
                    $printerInsert = [
                        'printerId' => $printerId,
                        'productId' => $this->shopproduct_model->id
                    ];
                    $this->shopproductprinters_model->setObjectFromArray($printerInsert)->create();
                }
            }

            redirect('products');
            return;
        }

        /**
         * Add times to product
         *
         * @return void
         */
        public function addProductTimes(): void
        {
            $data = $this->input->post(null, true);
            $days = $data['productTime'];

            $this->shopproducttime_model->productId = intval($this->uri->segment(3));
            $this->shopproducttime_model->deleteProductTimes();

            foreach ($days as $day => $value) {
                if (isset($value['day']) && $value['from'][0] && $value['to'][0]) {                    
                    $count = count($value['from']);
                    for ($i = 0; $i < $count; $i++) {
                        $insert = [
                            'day' => $day,
                            'timeFrom' => $value['from'][$i],
                            'timeTo' => $value['to'][$i],
                        ];
                        if (!$this->shopproducttime_model->setObjectFromArray($insert)->create()) {
                            $this->session->set_flashdata('error', 'Availability time(s) for product "' . $data['productName'] . '" not updated! Please try again');
                            redirect('products');
                        };
                    }
                }
            }
            $this->session->set_flashdata('success', 'Availability time(s) for product "' . $data['productName'] . '" updated.');
            redirect('products');
            return;
        }

        // ORDERS
        /**
         * read orders
         *
         * @return void
         */
        public function orders(): void
        {
            $this->global['pageTitle'] = 'TIQS : ORDERS';

            $data = [
                'orderStatuses' => $this->config->item('orderStatuses'),
                'orderFinished' => $this->config->item('orderFinished'),
            ];

            $this->loadViews('warehouse/orders', $this->global, $data, null, 'headerWarehouse');
        }

        //PRINTERS
        /**
         * Read prnters
         *
         * @return void
         */
        public function printers(): void
        {
            $this->global['pageTitle'] = 'TIQS : PRINTERS';
            $userId = intval($_SESSION['userId']);
            $data = [
                'userId' => $userId,
                'printers' => $this->shopprinters_model->read(['*'], ['userId=' => $userId])
            ];

            $this->loadViews('warehouse/printers', $this->global, $data, null, 'headerWarehouse');
        }

        /**
         * Add printer
         */
        public function addPrinter(): void
        {
            $data = $this->input->post(null, true);

            $where = [
                'userId'    => $data['userId'],
                'printer'   => $data['printer'],
            ];

            if ($this->shopprinters_model->checkPrinterName($where)) {
                $this->session->set_flashdata('error', 'Printer with this name already exists! Insert failed');
                redirect('printers');
            }

            if ($this->shopprinters_model->setObjectFromArray($data)->create()) {
                $this->session->set_flashdata('success', 'Printer added');
            } else {
                $this->session->set_flashdata('error', 'Printer add failed. Try again.');
            }

            redirect('printers');
        }

        /**
         * Update printer
         *
         * @return void
         */
        public function editPrinter(): void
        {
            $printerId = intval($this->uri->segment(3));

            if (Validate_data_helper::validateInteger($this->uri->segment(4))) {
                // change active status
                $data = ['active' => $this->uri->segment(4)];
            } else {
                // update mac and/or printer name
                $data = $this->input->post(null, true);
                // CHECK PRINTER NAME
                if (isset($data['printer'])) {
                    $where = [
                        'userId'    => $_SESSION['userId'],
                        'printer'   => $data['printer'],
                        'id !=' => $printerId,
                    ];
                    if ($this->shopprinters_model->checkPrinterName($where)) {
                        $this->session->set_flashdata('error', 'Printer with this name already exists! Update failed');
                        redirect('printers');
                    }
                }
            }

            $update = $this
                    ->shopprinters_model
                    ->setObjectId(intval($printerId))
                    ->setObjectFromArray($data)
                    ->update();

            if ($update) {
                $this->session->set_flashdata('success', 'Printer updated');
            } else {
                $this->session->set_flashdata('error', 'Update failed! Please try again.');
            }

            redirect('printers');
            return;
        }


        //SPOTS
        /**
         * Read spots
         *
         * @return void
         */
        public function spots(): void
        {
            $this->global['pageTitle'] = 'TIQS : SPOTS';
            $userId = intval($_SESSION['userId']);

            $data = [
                'printers' => $this->shopprinters_model->read(['*'], ['userId=' => $userId]),
                'spots' => $this->shopspot_model->fetchUserSpots($userId)
            ];


            $this->loadViews('warehouse/spots', $this->global, $data, null, 'headerWarehouse');
        }

        /**
         * Add spot
         *
         * @return void
         */
        public function addSpot(): void
        {
            $data = $this->input->post(null, true);

            $where = [
                'tbl_shop_printers.userId=' => $_SESSION['userId'],
                'tbl_shop_spots.spotName=' => $data['spotName'],
            ];

            if ($this->shopspot_model->checkSpottName($where)) {
                $this->session->set_flashdata('error', 'Spot with this name already exists! Insert failed');
                redirect('spots');
            }

            if ($this->shopspot_model->setObjectFromArray($data)->create()) {
                $this->session->set_flashdata('success', 'Spot added');
            } else {
                $this->session->set_flashdata('error', 'Spot add failed. Try again.');
            }

            redirect('spots');
        }

        /**
         * Update spot
         *
         * @return void
         */
        public function editSpot(): void
        {
            $spotId = intval($this->uri->segment(3));

            if (Validate_data_helper::validateInteger($this->uri->segment(4))) {
                // change active status
                $data = ['active' => $this->uri->segment(4)];
            } else {
                // update data
                $data = $this->input->post(null, true);

                if (isset($data['spotName'])) {
                    $where = [
                        'tbl_shop_printers.userId=' => $_SESSION['userId'],
                        'tbl_shop_spots.spotName=' => $data['spotName'],
                        'tbl_shop_spots.id!=' => $spotId
                    ];
        
                    if ($this->shopspot_model->checkSpottName($where)) {
                        $this->session->set_flashdata('error', 'Spot with this name already exists! Insert failed');
                        redirect('spots');
                    }
                }                
            }

            $update = $this
                    ->shopspot_model
                    ->setObjectId($spotId)
                    ->setObjectFromArray($data)
                    ->update();

            if ($update) {
                $this->session->set_flashdata('success', 'Spot updated');
            } else {
                $this->session->set_flashdata('error', 'Update failed! Please try again.');
            }

            redirect('spots');
            return;
        }

        //PRODUCT TYPES
        /**
         * Read product types
         *
         * @return void
         */
        public function productTypes(): void
        {
            $this->global['pageTitle'] = 'TIQS : PRODUCT TYPES';
            $vendorId = intval($_SESSION['userId']);
            $data = [
                'vendorId' => $vendorId,
                'productTypes' => $this->shopprodutctype_model->fetchProductTypes($vendorId),
                'main' => $this->shopprodutctype_model->checkMain($vendorId),
            ];
            $this->loadViews('warehouse/productTypes', $this->global, $data, null, 'headerWarehouse');
        }

        /**
         * Add product type
         *
         * @return void
         */
        public function addProductType(): void
        {
            $data = $this->input->post(null, true);
            $vendorId = intval($_SESSION['userId']);
            $where = [
                'vendorId=' => $vendorId,
                'type=' => $data['type'],
            ];

            if (isset($data['isMain']) && $this->shopprodutctype_model->checkMain($vendorId)) {
                $this->session->set_flashdata('error', 'Only one type can have flag main');
                redirect('product_types');
            }

            if ($this->shopprodutctype_model->checkTypeName($where)) {
                $this->session->set_flashdata('error', 'Type with this name already exists! Insert failed');
                redirect('product_types');
            }

            if ($this->shopprodutctype_model->setObjectFromArray($data)->create()) {
                $this->session->set_flashdata('success', 'Type added');
            } else {
                $this->session->set_flashdata('error', 'Type add failed. Try again.');
            }

            redirect('product_types');
        }

        /**
         * Edit product type
         *
         * @return void
         */
        public function editType(): void
        {
            $typeId = intval($this->uri->segment(3));
            $vendorId = intval($_SESSION['userId']);

            // update data
            $data = $this->input->post(null, true);

            if (isset($data['isMain']) && $this->shopprodutctype_model->checkMain($vendorId, $typeId)) {
                $this->session->set_flashdata('error', 'Only one type can have flag main');
                redirect('product_types');
            }

            if (isset($data['type'])) {
                $where = [
                    'vendorId=' => $vendorId,
                    'type=' => $data['type'],
                    'id!=' => $typeId
                ];
                if ($this->shopprodutctype_model->checkTypeName($where)) {
                    $this->session->set_flashdata('error', 'Type with this name already exists! Update failed');
                    redirect('product_types');
                }
            }

            $data['isMain'] = isset($data['isMain']) ? $data['isMain'] : '0';
            $update = $this
                    ->shopprodutctype_model
                    ->setObjectId($typeId)
                    ->setObjectFromArray($data)
                    ->update();

            if ($update) {
                $this->session->set_flashdata('success', 'Type updated');
            } else {
                $this->session->set_flashdata('error', 'Update failed! Please try again.');
            }
            redirect('product_types');
            return;
        }

        /**
         * Add addons to a product
         */
        public function addProductAddons(): void
        {
            $productId = intval($this->uri->segment(3));
            $data = $this->input->post(null, true);
            $productAddons = $data['productAddons'];
            $product =  $this->shopproductex_model->setProperty('productId', $productId)->getProductName();
            $success = true;            

            if (!$this->shopproductaddons_model->setProperty('productId', $productId)->deleteProductAddons()) {
                $this->session->set_flashdata('error', 'Addons insert failed for product "' . $product . '"!');
            } else {
                foreach($productAddons as $productExtendedId => $addonProductId) {
                    $insert = [
                        'addonProductId' => $addonProductId,
                        'productExtendedId' => $productExtendedId
                    ];
                    if (!$this->shopproductaddons_model->setObjectFromArray($insert)->create()) {
                        $this->shopproductaddons_model->setProperty('productId', $productId)->deleteProductAddons();
                        $this->session->set_flashdata('error', 'Addons insert failed for product "' . $product . '"!');
                        $success = false;
                        break;
                    };
                }

                if ($success) $this->session->set_flashdata('success', 'Addons inserted for product "' . $product . '"!');
            }

            redirect('products');
        }
    }
