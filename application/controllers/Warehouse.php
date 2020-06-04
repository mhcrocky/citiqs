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

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('form_validation');

            $this->load->config('custom');

            $this->isLoggedIn();
            $this->checkSubscription();
        }

        private function checkSubscription(): void
        {
            $subscription = $this->user_subscription_model->getLastSubscriptionId($this->userId);
            if (is_null($subscription) || !Utility_helper::compareTwoDates(date('Y-m-d'), date($subscription['expireDtm']))) {
                redirect('profile');
            }
        }

        public function index(): void
        {
            $this->global['pageTitle'] = 'TIQS : WAREHOSUE';

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

            $data = [
                'categories' => $this->shopcategory_model->fetch(['userId' => $userId]),
                'products' => $this->shopproductex_model->getUserLastProductsDetails($userId)
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

            $this->session->set_flashdata('success', 'Product inserted.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        public function orders(): void
        {
            $this->global['pageTitle'] = 'TIQS : ORDERS';

            $this->loadViews('warehouse/orders', $this->global, null, null, 'headerWarehouse');
        }

    }
