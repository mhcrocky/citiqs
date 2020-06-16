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
            $this->load->helper('form');
            $this->load->helper('validate_data_helper');
            $this->load->helper('utility_helper');

            $this->load->model('user_subscription_model');
            $this->load->model('shopcategory_model');
            $this->load->model('shopproduct_model');
            $this->load->model('shopproductex_model');
            $this->load->model('shoporder_model');
            $this->load->model('shoporderex_model');
            $this->load->model('shopprinters_model');
            $this->load->model('shopproductprinters_model');
            $this->load->model('shopspot_model');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('form_validation');

            $this->load->config('custom');

            $this->isLoggedIn();
            // $this->checkSubscription();
        }

        private function checkSubscription(): void
        {
            // $subscription = $this->user_subscription_model->getLastSubscriptionId($this->userId);
            // if (is_null($subscription) || !Utility_helper::compareTwoDates(date('Y-m-d'), date($subscription['expireDtm']))) {
            //     redirect('profile');
            // }
        }

        public function index(): void
        {
            $this->global['pageTitle'] = 'TIQS : WAREHOSUE';

            $userId = intval($_SESSION['userId']);
            var_dump($this->shoporder_model->fetchReportDetails($userId));
            die();
            $this->loadViews('warehouse/warehouse', $this->global, null, null, 'headerWarehouse');
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
                redirect($_SERVER['HTTP_REFERER']);
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

            redirect($_SERVER['HTTP_REFERER']);
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
                'products' => $this->shopproductex_model->getUserLastProductsDetails($where),
                'printers' => $this->shopprinters_model->read(['*'], $where),
            ];

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

            // insert product
            if (!$this->shopproduct_model->setObjectFromArray($data['product'])->create()) {
                $this->session->set_flashdata('error', 'Product insert failed! Please try again.');
                redirect($_SERVER['HTTP_REFERER']);
            };

            // insert product extended
            $data['productExtended']['productId'] = $this->shopproduct_model->id;

            if(!$this->shopproductex_model->setObjectFromArray($data['productExtended'])->create()) {
                $this->shopproduct_model->delete();
                $this->session->set_flashdata('error', 'Product insert failed! Please try again.');
                redirect($_SERVER['HTTP_REFERER']);
            };

            // INSERT PRINTERS
            foreach($data['productPrinters'] as $printerId) {
                $printerInsert = [
                    'printerId' => $printerId,
                    'productId' => $this->shopproduct_model->id
                ];

                if (!$this->shopproductprinters_model->setObjectFromArray($printerInsert)->create()) {
                    $this->session->set_flashdata('error', 'Pinter inserted failed. Please check');
                }

            }

            $this->session->set_flashdata('success', 'Product inserted.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        /**
         * Update product
         *
         * @return void
         */
        public function editProduct(): void
        {
            if (Validate_data_helper::validateInteger($this->uri->segment(4))) {
                $update = $this
                        ->shopproduct_model
                        ->setObjectId(intval($this->uri->segment(3)))
                        ->setObjectFromArray(['active' => $this->uri->segment(4)])
                        ->update();

                if ($update) {
                    $this->session->set_flashdata('success', 'Product updated');
                } else {
                    $this->session->set_flashdata('error', 'Update failed! Please try again.');
                }
            } else {
                $data = $this->input->post(null, true);
                // update
                $update = $this
                        ->shopproduct_model
                        ->setObjectId(intval($this->uri->segment(3)))
                        ->setObjectFromArray($data['product'])
                        ->update();

                // insert new product deatils
                $insert = $this->shopproductex_model->setObjectFromArray($data['productExtended'])->create();
                
                if ($insert && $update) {
                    $this->session->set_flashdata('success', 'Product updated');
                } else {
                    $this->session->set_flashdata('error', 'Update failed! Please try again.');
                }
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
            }

            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        // ORDERS
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
            if (Validate_data_helper::validateInteger($this->uri->segment(4))) {
                // change active status
                $data = ['active' => $this->uri->segment(4)];
            } else {
                // update mac and/or printer name
                $data = $this->input->post(null, true);
            }

            $update = $this
                    ->shopprinters_model
                    ->setObjectId(intval($this->uri->segment(3)))
                    ->setObjectFromArray($data)
                    ->update();

            if ($update) {
                $this->session->set_flashdata('success', 'Printer updated');
            } else {
                $this->session->set_flashdata('error', 'Update failed! Please try again.');
            }

            redirect($_SERVER['HTTP_REFERER']);
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
            // var_dump($data);
            // die();

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
            if (Validate_data_helper::validateInteger($this->uri->segment(4))) {
                // change active status
                $data = ['active' => $this->uri->segment(4)];
            } else {
                // update data
                $data = $this->input->post(null, true);
            }

            $update = $this
                    ->shopspot_model
                    ->setObjectId(intval($this->uri->segment(3)))
                    ->setObjectFromArray($data)
                    ->update();

            if ($update) {
                $this->session->set_flashdata('success', 'Spot updated');
            } else {
                $this->session->set_flashdata('error', 'Update failed! Please try again.');
            }

            redirect($_SERVER['HTTP_REFERER']);
            return;
        }        
    }
