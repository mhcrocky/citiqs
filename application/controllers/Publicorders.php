<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';

    class Publicorders extends BaseControllerWeb
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
            $this->load->model('user_model');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('form_validation');

            $this->load->config('custom');
        }

        public function index(): void
        {
            $this->global['pageTitle'] = 'TIQS : ORDERING';

            $whereCategories = [
                'tbl_shop_categories.active' => '1'
            ];
            $whereProducts = [
                'tbl_shop_categories.active' => '1',
                'tbl_shop_products.active' => '1',
            ];

            $data = [
                'categories' => $this->shopcategory_model->fetch($whereCategories),
                'products' => $this->shopproductex_model->getUserLastProductsDetails($whereProducts)
            ];

            $this->loadViews('publicorders/makeOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function checkout_order(): void
        {
            $this->global['pageTitle'] = 'TIQS : CHECKOUT';

            if (empty($_POST)) {
                redirect('make_order');
            }
            $data = [
                'orderDetails' => $this->input->post(null, true),
                'buyerRole' => $this->config->item('buyer'),
                'usershorturl' => 'tiqs_shop_service',
                'salesagent' => $this->config->item('tiqsId'),
            ];

            $this->loadViews('publicorders/checkoutOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function submitOrder(): void
        {
            $data = $this->input->post(null, true);

            // get buyer id
            $data['user']['username'] = $data['user']['first_name'] . ' ' . $data['user']['second_name'];
            $this->user_model->manageAndSetBuyer($data['user']);

            if (!$this->user_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Please try again');
                redirect('make_order');
                exit();
            }

            // insert order
            $data['order']['buyerId'] = $this->user_model->id;
            $data['order']['paid'] = '0';

            $this->shoporder_model->setObjectFromArray($data['order'])->create();            
            
            if (!$this->shoporder_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Please try again');
                redirect('make_order');
                exit();
            }

            // insert order details
            foreach ($data['orderExtended'] as $id => $details) {
                $details['productsExtendedId'] = intval($id);
                $details['orderId'] = $this->shoporder_model->id;
                if (!$this->shoporderex_model->setObjectFromArray($details)->create()) {
                    $this->shoporderex_model->orderId = $details['orderId'];
                    $this->shoporderex_model->deleteOrderDetails();
                    $this->shoporder_model->delete();
                    $this->session->set_flashdata('error', 'Order not made! Please try again');
                    redirect('make_order');
                    exit();
                }
            }

            // if everything OK, redirect to controller to manage paynl
            $_SESSION['orderId'] = $this->shoporder_model->id;
            redirect('publicorders/paynl');
        }

        public function paynl(): void
        {
            
            $this->shoporder_model->id = Utility_helper::returnSessionValue('orderId');
            var_dump($this->shoporder_model->fetchOne());
            die("TO DO PAYNL payment");

        }
    }
    
