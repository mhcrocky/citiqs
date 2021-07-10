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
            $this->load->model('shopvendortemplate_model');
            $this->load->model('bookandpayagendabooking_model');
            $this->load->model('shoparea_model');
            $this->load->model('user_model');
            $this->load->model('shopcategorytime_model');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');

            $this->load->config('custom');

            $this->isLoggedIn();
        }

        private function prepareRerpotesDates(): array
        {
            $post = [];;

            if(!empty($_POST)) {
                $datetimes = $this->input->post('datetimes', true);
                $datetimes = explode(' - ', $datetimes);
                $post['from'] = $datetimes[0];
                $post['to'] = $datetimes[1];
            }

            return $post;

        }

        /**
         * Reports
         *
         * @return void
         */
        public function index(): void
        {
            $this->global['pageTitle'] = 'TIQS : WAREHOUSE';

            $data = [];
            $userId = intval($_SESSION['userId']);
            $post = $this->prepareRerpotesDates();
            $data['from'] = empty($post['from']) ? date('Y-m-d 00:00:00', strtotime('-2 days')) : $post['from'];
            $data['to'] = empty($post['to']) ? date('Y-m-d 23:59:59') : $post['to'];
            $reportsData = $this->shoporder_model->fetchReportDetails($userId, $data['from'], $data['to']);

            if ($reportsData) {
                // $data['reports'] = [
                //     'orders' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'orderId'),
                //     'categories' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'category'),
                //     'spots' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'spotId'),
                //     'buyers' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'buyerId'),
                //     'products' => Utility_helper::resetArrayByKeyMultiple($reportsData, 'productId'),
                // ];
                $data['reports'] = Shoporder_model::prepareReportes($reportsData);
            }

            $this->loadViews('warehouse/warehouse', $this->global, $data, 'footerbusiness', 'headerbusiness');
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
                'archived'  => '0',
                'isApi'  => '0',
            ];

            if (isset($_GET['active']) && ($_GET['active'] === '0' || $_GET['active'] === '1')) {
                $where['active'] = $_GET['active'];
            }

            $data = [
                'userId' => intval($_SESSION['userId']),
                'categories' => $this->shopcategory_model->fetch($where),
                'imgFolder' => (base_url() . $this->config->item('categoriesImagesRelPath')),
                'dayOfWeeks' => $this->config->item('weekDays'),
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
            $this->setCategoryImage($data);

            if ($this->shopcategory_model->checkIsInserted($data)) {
                $this->session->set_flashdata('error', 'Insert failed! Category with this name already inserted');
            } elseif ($this->shopcategory_model->setObjectFromArray($data)->create()) {
                $this->uploadCategoryImage($data);
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
            $data = Validate_data_helper::validateInteger($this->uri->segment(4)) ? ['active' => $this->uri->segment(4)] : $this->security->xss_clean($_POST);
            $this->shopcategory_model->setObjectId(intval($this->uri->segment(3)));

            if(isset($data['category']) && $this->shopcategory_model->checkIsInserted($data)) {
                $this->session->set_flashdata('error', 'Update failed! Category with name "' . $data['category'] . '" already inserted');
                redirect('product_categories');
            }

            $this->setCategoryImage($data);
            $this->deleteOldCategoryImage($data);

            if ($this->shopcategory_model->setObjectFromArray($data)->update()) {
                $this->uploadCategoryImage($data);
                $this->session->set_flashdata('success', 'Category updated');
            } else {
                $this->session->set_flashdata('error', 'Update failed! Please try again.');
            }

            redirect('product_categories');
            return;
        }

        private function setCategoryImage(array &$data): void
        {
            if (!empty($_FILES['image']['name'])) {
                $data['image'] = time() . '_' . $_SESSION['userId'] . '_' . rand(1, 99999) . '.' . Uploadfile_helper::getFileExtension($_FILES['image']['name']);
                $_FILES['image']['name'] = $data['image'];
            } else {
                unset($data['image']);
            }

            return;
        }

        private function uploadCategoryImage(array $data): void
        {
            if (!empty($data['image'])) {
                Uploadfile_helper::uploadFiles($this->config->item('categoriesImagesFullPath'));
            }
            return;
        }

        private function deleteOldCategoryImage($data): void
        {
            if ($this->shopcategory_model->id && !empty($data['image'])) {
                $image = $this->config->item('categoriesImagesFullPath') . $this->shopcategory_model->getProperty('image');
                if (file_exists($image)) {
                    unlink($image);
                }
            }
        }

        /**
         * Add times to category
         *
         * @return void
         */
        public function addCategoryTimes($id): void
        {
            $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
            if (!$this->shopcategory_model->setObjectId(intval($id))->setProperty('userId', $_SESSION['userId'])->isVendorCategory()) {
                $this->session->set_flashdata('error', 'Not allowed');
                redirect($redirect);
            }

            $data = $this->input->post(null, true);
            $days = $data['categoryTime'];

            $this->shopcategorytime_model->categoryId = $this->shopcategory_model->id;
            $this->shopcategorytime_model->deleteProductTimes();

            foreach ($days as $day => $value) {
                if (isset($value['day']) && $value['from'][0] && $value['to'][0]) {
                    $count = count($value['from']);
                    for ($i = 0; $i < $count; $i++) {
                        $insert = [
                            'day' => $day,
                            'timeFrom' => $value['from'][$i],
                            'timeTo' => $value['to'][$i],
                        ];
                        if (!$this->shopcategorytime_model->setObjectFromArray($insert)->create()) {
                            $this->shopcategorytime_model->deleteProductTimes();
                            $this->session->set_flashdata('error', 'Availability time(s) for category "' . $data['category'] . '" not inserted! Please try again');
                            redirect($redirect);
                        };
                    }
                }
            }

            if (!empty($insert)) {
                $this->session->set_flashdata('success', 'Availability time(s) for category "' . $data['category'] . '" inserted.');
            } else {
                $this->session->set_flashdata('success', 'Category is available from 00:00:00 to 23:59:59');
            }

            redirect($redirect);
            return;
        }

        // PRODUCTS
        /**
         * Read products
         *
         * @return void
         */
        public function products($active = ''): void
        {
            if ($active === 'active') {
                $activeFilter = '1';
            } elseif ($active === 'archived') {
                $activeFilter = '0';
            } else {
                $activeFilter = '';
            }

            $this->global['pageTitle'] = 'TIQS : PRODUCTS';

            $userId = intval($_SESSION['userId']);
            $productNames = $this->shopproductex_model->getProductsNames($userId, $activeFilter);
            if ($productNames) {
                Utility_helper::array_sort_by_column($productNames, 'name');
            }
            $offset = intval($this->input->get('offset', true));
            $perPage = 21;
            $whereIn = [];
            $url = 'products' . DIRECTORY_SEPARATOR . $active;
            $pagination = Utility_helper::getPaginationLinks(count($productNames), $perPage, $url);

            // filter productes ny name(s)
            if (!empty($_POST)) {
                $post = Utility_helper::sanitizePost();
                $whereIn = [
                    'column' => 'tbl_shop_products_extended.productId',
                    'array' => $post['names']
                ];
                $pagination = '';
            }

            // for country taxes
            $this->user_model->setUniqueValue($userId)->setWhereCondtition()->setUser('country');

            $data = [
                'categories' => $this->shopcategory_model->fetch(['userId' => $userId]),
                'products' => $this->shopproductex_model->getUserProducts($userId, $perPage, $offset, $whereIn, $activeFilter),
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
                'taxRates' => $this->config->item('countriesTaxes')[$this->user_model->country]['taxRates'],
                'active' => $active,
            ];

            $this->loadViews('warehouse/products', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

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
            if ($this->shopproductex_model->checkProductNameNew($userId, $data['productExtended']['name'])) {
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

            $this->changeProductStatus($productId);

            // CHECK PRODUCT NAME
            if ($this->shopproductex_model->checkProductNameNew($userId, $data['productExtended']['name'], intval($data['productExtended']['productId']))) {
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

        private function changeProductStatus(int $productId): void
        {
            if ($this->uri->segment(4) === '1' || $this->uri->segment(4) === '0' ) {
                $isDelete = (isset($_GET['delete']) && $_GET['delete'] === '1');
                $property = $isDelete ? 'archived' : 'active';
                $update = $this
                            ->shopproduct_model
                            ->setObjectId($productId)
                            ->setObjectFromArray([$property => $this->uri->segment(4)])
                            ->update();
                if ($update) {
                    if ($isDelete) {
                        $newStatus = 'deleted';
                    } else {
                        $newStatus = ($this->uri->segment(4) === '1') ? 'activated' : 'blocked';
                    }

                    $this->session->set_flashdata('success', 'Procuct ' . $newStatus);
                } else {
                    $this->session->set_flashdata('error', 'Update failed');
                }
                $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
                redirect($redirect);
                return;
            }
        }
        /**
         * Add times to product
         *
         * @return void
         */
        public function addProductTimes($id): void
        {
            $data = $this->input->post(null, true);
            $days = $data['productTime'];

            $this->shopproducttime_model->productId = intval($id);
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
                                            'active' => '1'
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

            $this->loadViews('warehouse/orders', $this->global, $data, 'footerbusiness', 'headerbusiness');//null, 'headerWarehouse');
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
                'printers' => $this->shopprinters_model->setProperty('userId', $userId)->fetchPrinters(),
                'messageToBuyerTags' => $this->config->item('messageToBuyerTags'),
            ];

            $this->loadViews('warehouse/printers', $this->global, $data, 'footerbusiness', 'headerbusiness');
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
                                                    'tbl_shop_spots.archived=' => '0',
                                                    'tbl_shop_spots.isApi=' => '0'
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
            $data = $this->security->xss_clean($_POST);
            $productId = intval($this->uri->segment(3));
            $product =  $this->shopproductex_model->setProperty('productId', $productId)->getProductName();

            if (!$this->shopproductaddons_model->setProperty('productId', $productId)->deleteProductAddons()) {
                $this->session->set_flashdata('error', 'Addons update failed for product "' . $product . '"!');
            } else {
                $this->insertAddons($data, $productId, $product);
            }

            $redirect = empty($_SERVER['HTTP_REFERER']) ? 'products' : $_SERVER['HTTP_REFERER'];
            redirect($redirect);
        }

        private function insertAddons(array $data, int $productId, string $product): void
        {
            if (empty($data['productAddons'])) {
                $this->session->set_flashdata('success', 'No new addons for product "' . $product . '"!');    
                return;
            }

            $productAddons = $data['productAddons'];
            $productQuantities = $data['productQuantities'];

            foreach($productAddons as $productExtendedId => $addonProductId) {
                $insert = [
                    'addonProductId' => $addonProductId,
                    'productExtendedId' => $productExtendedId,
                    'quantity' => $productQuantities[$productExtendedId],
                ];
                if (!$this->shopproductaddons_model->setObjectFromArray($insert)->create()) {
                    $this->shopproductaddons_model->setProperty('productId', $productId)->deleteProductAddons();
                    $this->session->set_flashdata('error', 'Addons update failed for product "' . $product . '"!');
                    return;
                };
            }

            $this->session->set_flashdata('success', 'Addons updated for product "' . $product . '"!');

            return;
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
			$this->loadViews('warehouse/dayreport', $this->global, $data, 'footerbusiness', 'headerbusiness');
        }

		public function Vatreport(): void
		{
			$this->global['pageTitle'] = 'TIQS : Dailyreport';
			$data = [
				'vendorId' => $_SESSION['userId']
			];
			$this->loadViews('warehouse/vatreport', $this->global, $data, 'footerbusiness', 'headerbusiness');
        }

        // Design
        /**
         * Add colors to make order new view
         */
        public function viewdesign(): void
        {
            $userId = intval($_SESSION['userId']);
            $designId = intval($this->input->get('designid', true));
            $defaultDesignId = intval($this->input->get('defaultdesignid', true));
            $id = intval($this->shopvendor_model->setProperty('vendorId', $userId)->getProperty('id')); // this is row id in tbl_shop_vendors, we need to update iframe
            $data = [
                'id' => $id,
                'vendorId' => $userId,
                'iframeSrc' => base_url() . 'make_order?vendorid=' . $userId,
                'spots' => Utility_helper::resetArrayByKeyMultiple($this->shopspot_model->fetchUserActiveSpots($userId), 'spotType'),
                'categories' => $this->shopcategory_model->setProperty('userId', $userId)->setProperty('active', '1')->fetcUserCategories(),
                'allDefaultDesigns' => $this->shopvendortemplate_model->getAllDefaultDesigns(),
                'allVendorDesigns'=> $this->shopvendortemplate_model->setProperty('vendorId', $userId)->getVendorDesigns(),
                'designId' => $designId,
                'defaultDesignId' => $defaultDesignId,
                'devices' => $this->bookandpayagendabooking_model->get_devices(),
                'analytics' => $this->shopvendor_model->setObjectId($id)->getVendorAnalytics()
            ];
            $this->setDesign($designId, $defaultDesignId, $data);

            $this->global['pageTitle'] = 'TIQS : DESIGN';
            $this->loadViews('warehouse/design', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

        private function setDesign(int $designId, int $defaultDesignId, array &$data): void
        {
            if ($designId) {
                $this->shopvendortemplate_model->setObjectId($designId);
            }

            if (!$designId && $defaultDesignId) {
                $this->shopvendortemplate_model->setObjectId($defaultDesignId);
            }

            if ($this->shopvendortemplate_model->id) {
                $designData = $this->shopvendortemplate_model->getDesign();
                unset($this->shopvendortemplate_model->id);

                $data['design'] = $designData['templateValue'];
                $data['designName'] = $designData['templateName'];
                $data['designActive'] = $designData['active'];
                $data['designVendorId'] = intval($designData['vendorId']);
            }

            return;
        }

        public function replacePopupButtonStyle()
        {
            
            $cssFile = FCPATH . 'assets/home/styles/popup-alfred-style.css';
            $jsFile = FCPATH . 'assets/home/js/popup-alfred.js';
            //CSS FILE
            $f = fopen($cssFile, 'r');
            $newCssContent = '';
            for ($i = 1; ($line = fgets($f)) !== false; $i++) {
                if($line == '#iframe-popup-open{'){
                    echo 'true';
                }
                if (strpos($line, '#iframe-popup-open') !== false) {
                    break;
                }
                $newCssContent.= $line;
            }

            $newCssContent .= $this->input->post('buttonStyle');
            $f = fopen($cssFile, 'w');
            fwrite($f,$newCssContent);
            fclose($f);

            //JS FILE
            $f = fopen($jsFile, 'r');
            $newJsContent = '';
            $btnText = $this->input->post('btnText');
            for ($i = 1; ($line = fgets($f)) !== false; $i++) {
                if (strpos($line, "document.getElementById('iframe-popup-open').textContent") !== false) {
                    $line = "document.getElementById('iframe-popup-open').textContent = '$btnText'; \n";
                }
                $newJsContent .= $line;
            }
            $f = fopen($jsFile, 'w');
            fwrite($f,$newJsContent);
            fclose($f);
        }

        public function areas(): void
        {
            $userId = intval($_SESSION['userId']);
            $data = [
                'printers' => $this->shopprinters_model->read(['*'], ['userId' => $userId, 'archived' => '0', 'active' => '1']),
                'spots' => $this->shopspot_model->fetchUserSpots($userId),
                'areas' => $this->shoparea_model->setProperty('vendorId', $userId)->fetchVednorAreas()
            ];

            // var_dump($data);
            // die();

            $this->global['pageTitle'] = 'TIQS : AREAS';
            $this->loadViews('warehouse/areas', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

        public function addArea(): void
        {
            $post = $this->security->xss_clean($_POST);

            $this->validateAreaData($post);
            $this->insertArea($post);
            $this->updateSpots($post);

            $this->session->set_flashdata('success', 'Area created');
            redirect('areas');
        }

        private function validateAreaData(array $post): void
        {
            if (empty($post)) {
                $this->session->set_flashdata('error', 'No data sent');
                $err = true;
            } elseif (empty($post['area']['area'])) {
                $this->session->set_flashdata('error', 'Area name is required');
                $err = true;
            } elseif (empty($post['area']['printerId'])) {
                $this->session->set_flashdata('error', 'Printer not selected');
                $err = true;
            } elseif (empty($post['areaSpots'])) {
                $this->session->set_flashdata('error', 'You must select at least one spot for area');
                $err = true;
            }

            if (isset($err)) redirect('areas');
        }

        private function insertArea(array $post): void
        {
            $vendorId = intval($_SESSION['userId']);
            $this
                ->shoparea_model
                    ->setProperty('vendorId', $vendorId)
                    ->setProperty('area', $post['area']['area'])
                    ->setProperty('printerId', $post['area']['printerId'])
                    ->createArea();

            if (is_null($this->shoparea_model->id)) {
                $this->session->set_flashdata('error', 'Process failed. Check is area with name "' . $post['area']['area'] . '"aleary exists');
                redirect('areas');
            };
        }

        private function updateSpots(array $post): void
        {
            $this->shopspot_model->setProperty('areaId', $this->shoparea_model->id)->updateAreaIdToNull();

            foreach ($post['areaSpots'] as $spotId) {
                $spotId = intval($spotId);
                $update = $this
                            ->shopspot_model
                            ->setObjectId($spotId)
                            ->setProperty('printerId', intval($post['area']['printerId']))
                            ->setProperty('areaId', $this->shoparea_model->id)
                            ->update();
                if (!$update) {
                    $this->session->set_flashdata('error', 'Process failed while updating spot data. Try again');
                    redirect('areas');
                }
            }
            return;
        }

        private function checkAreaId(int $vendorId, int $areaId): void
        {
            $vendorId = intval($_SESSION['userId']);
            $this
                ->shoparea_model
                ->setObjectId($areaId)
                ->setProperty('vendorId', $vendorId);
            if (!$this->shoparea_model->checkAreaId()) redirect('logout');
        }

        public function deleteArea($areaId): void
        {
            $vendorId = intval($_SESSION['userId']);
            $areaId = intval($areaId);

            $this->checkAreaId($vendorId, $areaId);

            if (!$this->shopspot_model->setProperty('areaId', $this->shoparea_model->id)->updateAreaIdToNull()) {
                $this->session->set_flashdata('error', 'Process failed. Spots update failed');
                redirect('areas');
            }

            if (!$this->shoparea_model->delete()) {
                $this->session->set_flashdata('error', 'Process failed. Area did not delete');
                redirect('areas');
            }

            $this->session->set_flashdata('success', 'Area deleted');
            redirect('areas');
            return;
        }

        public function editArea($areaId): void
        {
            $vendorId = intval($_SESSION['userId']);
            $areaId = intval($areaId);

            $this->checkAreaId($vendorId, $areaId);

            $post = $this->security->xss_clean($_POST);

            $this->validateAreaData($post);
            $this->updateArea($vendorId, $areaId, $post['area']);
            $this->updateSpots($post);

            $this->session->set_flashdata('success', 'Area updated');
            redirect('areas');
            return;
        }

        public function updateArea(int $vendorId, int $areaId, array $area): void
        {
            $update = $this
                        ->shoparea_model
                            ->setObjectId($areaId)
                            ->setProperty('vendorId', $vendorId)
                            ->setProperty('area', $area['area'])
                            ->setProperty('printerId', $area['printerId'])
                            ->updateArea();

            if (!$update) {
                $this->session->set_flashdata('error', 'Update failed. Check is area with name "' . $area['area'] . '"aleary exists');
                redirect('areas');
            };

            return;
        }
    }
