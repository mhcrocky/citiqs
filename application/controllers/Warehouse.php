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
            $this->load->helper('uploadfile_helper');

            $this->load->model('shopcategory_model');
            $this->load->model('shopproduct_model');
            $this->load->model('shopproductex_model');
            $this->load->model('shoporder_model');
            $this->load->model('shoporderex_model');
            $this->load->model('shopprinters_model');
            $this->load->model('shopproductprinters_model');
            $this->load->model('shopspot_model');
            $this->load->model('shopspotproduct_model');
            $this->load->model('shopproducttime_model');
            $this->load->model('shopprodutctype_model');
            $this->load->model('shopproductaddons_model');
            $this->load->model('shopspottype_model');
            $this->load->model('shopspottime_model');
            $this->load->model('shopvendor_model');
            $this->load->model('shopvendortypes_model');

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

            $data = [];
            $userId = intval($_SESSION['userId']);
            $post = (!empty($_POST)) ? $this->input->post(null, true) : [];
            $data['from'] = empty($post['from']) ? date('Y-m-d H:i:s', strtotime('-2 days')) : $post['from'];
            $data['to'] = empty($post['to']) ? date('Y-m-d H:i:s') : $post['to'];
            $reportsData = $this->shoporder_model->fetchReportDetails($userId, $data['from'], $data['to']);

            if ($reportsData) {
                $data['reports'] = [
                    'orders' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'orderId'),
                    'categories' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'category'),
                    'spots' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'spotId'),
                    'buyers' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'buyerId'),
                    'products' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'productId'),
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
            $this->global['pageTitle'] = 'TIQS : CATEGORIES';

            $where = [
                'userId'    => intval($_SESSION['userId']),
                'archived'  => '0'
            ];

            if (isset($_GET['active']) && ($_GET['active'] === '0' || $_GET['active'] === '1')) {
                $where['active'] = $_GET['active'];
            }

            $data = [
                'userId' => intval($_SESSION['userId']),
                'categories' => $this->shopcategory_model->fetch($where),
            ];

            $this->loadViews('warehouse/productCategories', $this->global, $data, 'footerbusiness', 'headerbusiness');
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
            $this->shopcategory_model->setObjectId(intval($this->uri->segment(3)));

            if(isset($data['category']) && $this->shopcategory_model->checkIsInserted($data)) {
                $this->session->set_flashdata('error', 'Update failed! Category with name "' . $data['category'] . '" already inserted');
                redirect('product_categories');
            }

            $update =   $this
                        ->shopcategory_model
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
            $productNames = $this->shopproductex_model->getProductsNames($userId);
            if ($productNames) {
                Utility_helper::array_sort_by_column($productNames, 'name');
            }
            $offset = intval($this->input->get('offset', true));
            $perPage = 21;
            $whereIn = [];
            $pagination = Utility_helper::getPaginationLinks(count($productNames), $perPage, 'products');

            // filter productes ny name(s)
            if (!empty($_POST)) {
                $post = Utility_helper::sanitizePost();
                $whereIn = [
                    'column' => 'tbl_shop_products_extended.productId',
                    'array' => $post['names']
                ];
                $pagination = '';
            }

            $data = [
                'categories' => $this->shopcategory_model->fetch(['userId' => $userId]),
                'products' => $this->shopproductex_model->getUserProducts($userId, $perPage, $offset, $whereIn),
                'printers' => $this->shopprinters_model->read(['*'], ['userId' => $userId, 'archived' => '0']),
                'userSpots' => $this->shopspot_model->fetchUserSpots($userId),
                'productTypes' => $this->shopprodutctype_model->fetchProductTypes($userId),
                'concatSeparator' => $this->config->item('concatSeparator'),
                'productNames' => $productNames,
                'pagination' => $pagination,
                'dayOfWeeks' => $this->config->item('weekDays'),
                'allergies' => $this->config->item('allergies'),
                'showAllergies' => $this->shopvendor_model->setProperty('vendorId', $userId)->getProperty('showAllergies'),
                'vendorTypes' => $this->shopvendortypes_model->setProperty('vendorId', $userId)->fetchActiveVendorTypes(),
                'localTypeId' => $this->config->item('local'),
                'deliveryTypeId' => $this->config->item('deliveryType'),
                'pickupTypeId' => $this->config->item('pickupType'),
            ];

            $this->loadViews('warehouse/products', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

        // PRODUCTS
        /**
         * Return json data for datatables
         *
         * @return void
         */
        public function getProducts(): void
        {
            $userId = intval($_SESSION['userId']);
            $products = $this->shopproductex_model->getAllUserProducts($userId);
            echo json_encode($products);
            return;
        }

        public function updateProductOrderNo()
        {
            $products = $this->input->post('products');
            foreach($products as $product){
                $this->shopproductex_model->updateProductOrderNo($product[0],$product[1]);
            }
            
        }

        public function productsOrder(): void
        {
            $this->global['pageTitle'] = 'TIQS : PRODUCTS SORT';
            $userId = intval($_SESSION['userId']);
            $data['categories'] = $this->shopproductex_model->getProductCategories($userId);
            $this->loadViews('warehouse/productsOrder', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

        /**
         * Insert product
         *
         * @return void
         */
        public function addProdcut(): void
        {
            $data = Utility_helper::sanitizePost();
            $userId = intval($_SESSION['userId']);

            //CHECK PRODUCT NAME
            $where = [
                'tbl_shop_categories.userId' => $userId,
                'tbl_shop_products_extended.name=' => $data['productExtended']['name']
            ];

            if ($this->shopproductex_model->checkProductName($where)) {
                $this->session->set_flashdata('error', 'Product with this name already exists! Insert failed');
                $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
                redirect($redirect);
            };

            
            // insert product
            if ($data['product']['dateTimeFrom'] && $data['product']['dateTimeTo']) {
                $data['product']['dateTimeFrom'] = date('Y-m-d H:i:s', strtotime($data['product']['dateTimeFrom']));
                $data['product']['dateTimeTo'] = date('Y-m-d H:i:s', strtotime($data['product']['dateTimeTo']));
            } else {
                $data['product']['dateTimeFrom'] = date('Y-m-d H:i:s');
                $data['product']['dateTimeTo'] = date('Y-m-d H:i:s', strtotime('+10 years', time()));
            }

            if (!$data['productExtended']['shortDescription']) {
                $data['productExtended']['shortDescription'] = $data['productExtended']['name'];
            }

            if (!$this->shopproduct_model->setObjectFromArray($data['product'])->create()) {
                $this->session->set_flashdata('error', 'Product insert failed! Please try again.');
                $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
                redirect($redirect);
            };

            // upload image
            if (!empty($_FILES['productImage']['name'])) {
                $this->shopproduct_model->uploadImage();
            }

            $this->shopspotproduct_model->insertProductSpots($this->shopspot_model, $this->shopproduct_model->id, $userId);

            // insert product extended
            $countTypes = 0;

            foreach($data['productTypes'] as $typeId => $typeValues) {
                if (isset($typeValues['check'])) {
                    $countTypes++;
                    $data['productExtended']['productId'] = $this->shopproduct_model->id;
                    $data['productExtended']['productTypeId'] = intval($typeId);
                    $data['productExtended']['price'] = !empty($typeValues['price']) ? floatval($typeValues['price']) : '0';
                    $data['productExtended']['deliveryPrice'] = !empty($typeValues['deliveryPrice']) ? floatval($typeValues['deliveryPrice']) : $data['productExtended']['price'];
                    $data['productExtended']['pickupPrice'] = !empty($typeValues['pickupPrice']) ? floatval($typeValues['pickupPrice']) : $data['productExtended']['price'];
                    $data['productExtended']['updateCycle'] = 1;
                    $data['productExtended']['showInPublic'] = '1';
                    if(!$this->shopproductex_model->setObjectFromArray($data['productExtended'])->create()) {
                        $this->shopspotproduct_model->setProperty('productId', $this->shopproduct_model->id)->deleteProductSpots();
                        $this->shopproduct_model->delete();
                        $this->session->set_flashdata('error', 'Product insert failed! Please try again.');
                        $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
                        redirect($redirect);
                    };
                }
            }

            if ($countTypes === 0) {
                $this->shopproduct_model->delete();
                $this->session->set_flashdata('error', 'Please select product type(s).');
                $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
                redirect($redirect);
            }
            
            if (isset($data['productPrinters'])) {
                foreach($data['productPrinters'] as $printerId) {
                    $printerInsert = [
                        'printerId' => $printerId,
                        'productId' => $this->shopproduct_model->id
                    ];
                    if (!$this->shopproductprinters_model->setObjectFromArray($printerInsert)->create()) {
                        $this->session->set_flashdata('error', 'Printer insert failed. Please check');
                        break;
                    }
                }
            }

            //insert product available times
            if (!$this->shopproducttime_model->insertProductTimes($this->shopproduct_model->id)) {
                $this->session->set_flashdata('error', 'Product times insert');
            }

            $this->session->set_flashdata('success', 'Product inserted.');
            $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
            redirect($redirect);
            return;
        }

        /**
         * Update product
         *
         * @return void
         */
        public function editProduct(): void
        {
            $data = Utility_helper::sanitizePost();
            $productId = intval($this->uri->segment(3));
            $userId = intval($_SESSION['userId']);

            if ($this->uri->segment(4) === '1' || $this->uri->segment(4) === '0' ) {
                $update = $this
                            ->shopproduct_model
                            ->setObjectId($productId)
                            ->setObjectFromArray(['active' => $this->uri->segment(4)])
                            ->update();
                if ($update) {
                    $newStatus = ($this->uri->segment(4) === '1') ? 'activated' : 'blocked';
                    $this->session->set_flashdata('success', 'Procuct ' . $newStatus);
                } else {
                    $this->session->set_flashdata('error', 'Update failed');
                }
                $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
                redirect($redirect);
                return;
            }

            // CHECK PRODUCT NAME
            $where = [
                'tbl_shop_categories.userId' => $userId,
                'tbl_shop_products_extended.productId !=' => $productId,
                'tbl_shop_products_extended.name=' => $data['productExtended']['name']
            ];

            if ($this->shopproductex_model->checkProductName($where)) {
                $this->session->set_flashdata('error', 'Product with this name already exists! Update failed');
                $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
                redirect($redirect);
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

            // upload image
            if (!empty($_FILES['productImage']['name'])) {
                $this->shopproduct_model->uploadImage();
            }

            // insert new product extended deatils
            $countTypes = 0;
            $main = false;
            foreach($data['productTypes'] as $typeId => $typeValues) {
                var_dump($typeValues);
                if (isset($typeValues['check'])) {
                    $countTypes++;
                    $data['productExtended']['productId'] = $this->shopproduct_model->id;
                    $data['productExtended']['productTypeId'] = intval($typeId);
                    $data['productExtended']['price'] = !empty($typeValues['price']) ? floatval($typeValues['price']) : '0';
                    $data['productExtended']['deliveryPrice'] = !empty($typeValues['deliveryPrice']) ? floatval($typeValues['deliveryPrice']) : $data['productExtended']['price'];
                    $data['productExtended']['pickupPrice'] = !empty($typeValues['pickupPrice']) ? floatval($typeValues['pickupPrice']) : $data['productExtended']['price'];
                    if (isset($typeValues['showInPublic'])) {
                        $data['productExtended']['showInPublic'] = '1';
                    } else {
                        $data['productExtended']['showInPublic'] = '0';
                    }

                    if(!$this->shopproductex_model->setObjectFromArray($data['productExtended'])->create()) {
                        $insert = false;
                        break;
                    } else {
                        if (!empty($typeValues['oldExtendedId'])) {
                            $oldExtendedId = intval($typeValues['oldExtendedId']);
                            $this->shopproductaddons_model->updateProductExtendedId($oldExtendedId, $this->shopproductex_model->id);
                        }
                    };

                    if ($typeValues['isMain'] === '1') $main = true;
                }
                $insert = true;
            }

            if ($insert && $update && $countTypes > 0 ) {
                if  ($countTypes === 1 && $main)  {
                    $this
                        ->shopproductaddons_model
                        ->setProperty('addonProductId', $data['productExtended']['productId'])
                        ->deleteAddon();                    
                }
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
            $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
            redirect($redirect);
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
                            $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
                            redirect($redirect);
                        };
                    }
                }
            }
            $this->session->set_flashdata('success', 'Availability time(s) for product "' . $data['productName'] . '" updated.');
            $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
            redirect($redirect);
            return;
        }

        /**
         * Add allergies to product
         *
         * @return void
         */
        public function addProductAllergies($productExId): void
        {
            $post = $this->input->post(null, true);
            $allergies = serialize($post);
            $product = $this->shopproductex_model->setObjectId(intval($productExId))->setObject();

            $update =   $this
                            ->shopproduct_model
                                ->setObjectId($product->productId)
                                ->setProperty('allergies', $allergies)
                                ->update();

            if ($update) {
                $this->session->set_flashdata('success', 'Allergies inserted for product "' . $product->name . '"');
            } else {
                $this->session->set_flashdata('error', 'Allergies insert failed  for product "' . $product->name . '"');
            }

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
            $userId = intval($_SESSION['userId']);

            $data = [
                'orderStatuses' => $this->config->item('orderStatuses'),
                'vendor'        => $_SESSION['name'],
                'printers'      => $this->shopprinters_model->readImproved([
                                        'what' => ['id', 'printer'],
                                        'where' => [
                                            'userId' => $userId,
                                        ]
                                    ]),
                'vendorData' => $this->shopvendor_model->setProperty('vendorId', $userId)->getProperties(['id', 'requireRemarks', 'busyTime', 'minBusyTime', 'maxBusyTime']),
                'typeColors' => $this->config->item('typeColors'),
                'localTypeId' => $this->config->item('local'),
                'deliveryTypeId' => $this->config->item('deliveryType'),
                'pickupTypeId' => $this->config->item('pickupType'),
                'orderConfirmWaiting' => $this->config->item('orderConfirmWaiting'),
                'orderConfirmTrue' => $this->config->item('orderConfirmTrue'),
                'orderConfirmFalse' => $this->config->item('orderConfirmFalse'),
                'rejectedColor' => $this->config->item('notActiveColor'),
                'prePaid' => $this->config->item('prePaid'),
                'postPaid' => $this->config->item('postPaid'),
                'userId' => $userId,
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
                'printers' => $this->shopprinters_model->setProperty('userId', $userId)->fetchPrinters()
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
                'printers' => $this->shopprinters_model->read(['*'], ['userId=' => $userId, 'masterMac=' => '0']),
                'spots' => $this->shopspot_model->fetchUserSpotsImporved([
                                                    'tbl_shop_printers.userId=' => $userId,
                                                    'tbl_shop_spots.archived=' => '0'
                                                ]),
                'spotTypes' =>$this->shopspottype_model->read(['*'], ['id>' => 0]),
                'dayOfWeeks' => $this->config->item('weekDays'),
                'colors' => $this->config->item('typeColors'),
                'localTypeId' => $this->config->item('local'),
                'deliveryTypeId' => $this->config->item('deliveryType'),
                'pickupTypeId' => $this->config->item('pickupType'),
                'notActiveColor' => $this->config->item('notActiveColor'),
                'activePos' => $_SESSION['activatePos'],
            ];

            $this->loadViews('warehouse/spots', $this->global, $data, 'footerbusiness', 'headerbusiness');
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
                $this
                    ->shopspottime_model
                    ->setProperty('spotId', $this->shopspot_model->id)
                    ->insertSpotTime();
                $this->shopspotproduct_model->insertSpotProducts($this->shopproduct_model, $this->shopspot_model->id, intval($_SESSION['userId']));
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

        public function addSpotTimes($spotId): void
        {
            $post = $this->input->post(null, true);
            $this->shopspottime_model->setProperty('spotId', $spotId)->deleteSpotTimes();

            foreach ($post as $day => $value) {
                if (count($value['timeFrom']) === count($value['timeTo'])) {
                    $insert = array_map(function($from, $to) use($day, $spotId) {
                        if ($from && $to) {
                            return [
                                'spotId'	=> $spotId,
                                'day'		=> $day,
                                'timeFrom'	=> $from,
                                'timeTo'	=> $to,
                            ];
                        }
                    }, $value['timeFrom'], $value['timeTo'] );

                    $insert = array_filter($insert, function($data) {
                        if (!empty($data)) return $data;
                    });

                    if (!empty($insert)) {
                        if (!$this->shopspottime_model->multipleCreate($insert)) {
                            $this->session->set_flashdata('error', 'Time update failed');
                            redirect('spots');
                            return;
                        };
                    }
                }
            }
            $this->session->set_flashdata('success', 'Time updated');
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
            $this->loadViews('warehouse/productTypes', $this->global, $data, 'footerbusiness', 'headerbusiness');
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

        // ADDONS
        /**
         * Add addons to a product
         */
        public function addProductAddons(): void
        {
            $productId = intval($this->uri->segment(3));
            $data = $this->input->post(null, true);
            $productAddons = $data['productAddons'];
            $productQuantities = $data['productQuantities'];
            $product =  $this->shopproductex_model->setProperty('productId', $productId)->getProductName();
            $success = true;
            if (!$this->shopproductaddons_model->setProperty('productId', $productId)->deleteProductAddons()) {
                $this->session->set_flashdata('error', 'Addons update failed for product "' . $product . '"!');
            } else {
                foreach($productAddons as $productExtendedId => $addonProductId) {
                    $insert = [
                        'addonProductId' => $addonProductId,
                        'productExtendedId' => $productExtendedId,
                        'quantity' => $productQuantities[$productExtendedId],
                    ];
                    if (!$this->shopproductaddons_model->setObjectFromArray($insert)->create()) {
                        $this->shopproductaddons_model->setProperty('productId', $productId)->deleteProductAddons();
                        $this->session->set_flashdata('error', 'Addons update failed for product "' . $product . '"!');
                        $success = false;
                        break;
                    };
                }

                if ($success) $this->session->set_flashdata('success', 'Addons updated for product "' . $product . '"!');
            }

            $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
            redirect($redirect);
        }

        // VISITORS
        /**
         * Koolreportes visitors
         */
        public function visitors(): void
        {
            $this->global['pageTitle'] = 'TIQS : VISITORS';
            $data = [
                'vendorId' => $_SESSION['userId']
            ];
            $this->loadViews('warehouse/visitors', $this->global, $data, null, 'headerWarehouse');
        }

		public function Dayreport(): void
		{
			$this->global['pageTitle'] = 'TIQS : Dailyreport';
			$data = [
				'vendorId' => $_SESSION['userId']
			];
			$this->loadViews('warehouse/dayreport', $this->global, $data, null, 'headerWarehouse');
        }

		public function Vatreport(): void
		{
			$this->global['pageTitle'] = 'TIQS : Dailyreport';
			$data = [
				'vendorId' => $_SESSION['userId']
			];
			$this->loadViews('warehouse/vatreport', $this->global, $data, null, 'headerWarehouse');
        }

        // Design
        /**
         * Add colors to make order new view
         */
        public function viewdesign(): void
        {
            $userId = intval($_SESSION['userId']);
            $iframeSrc = base_url() . 'make_order?vendorid=' . $userId;
            $vendorData = $this->shopvendor_model->setProperty('vendorId', $userId)->getProperties(['id', 'design']);
            $id = $vendorData['id'];
            $design = ($vendorData['design']) ? unserialize($vendorData['design']) : null;
            $spots = Utility_helper::resetArrayByKeyMultiple($this->shopspot_model->fetchUserActiveSpots($userId), 'spotType');
            $categories = $this
                            ->shopcategory_model
                                ->setProperty('userId', $userId)
                                ->setProperty('active', '1')
                                ->fetcUserCategories();

            $data = [
                'iframeSrc' => $iframeSrc,
                'id' => $id,
                'design' => $design,
                'spots' => $spots,
                'categories' => $categories,
            ];

            $this->global['pageTitle'] = 'TIQS : DESIGN';
            $this->loadViews('warehouse/design', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

    }
