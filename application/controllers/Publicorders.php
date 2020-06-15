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
            $this->load->config('custom');
        }

        public function index(): void
        {
            $this->global['pageTitle'] = 'TIQS : ORDERING';
            if(!isset($_GET['spotid'])) {
                redirect(base_url());
            }

            $whereCategories = [
                'tbl_shop_categories.active' => '1'
            ];
            $whereProducts = [
                'tbl_shop_categories.active' => '1',
                'tbl_shop_products.active' => '1',
                'tbl_shop_spots.active' => '1',
                'tbl_shop_printers.active' => '1',
                'tbl_shop_spots.id' => $_GET['spotid'],
            ];

            $data = [
                'categoryProducts' => $this->shopproductex_model->getUserLastProductsDetailsPublic($whereProducts, 'category'),
                'spotId' => $_GET['spotid']
            ];

            $this->loadViews('publicorders/makeOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function checkout_order(): void
        {
            $this->global['pageTitle'] = 'TIQS : CHECKOUT';

            if (empty($_POST)) {
                redirect($_SERVER['HTTP_REFERER']);
            }

            $post = $this->input->post(null, true);
            $spotId = $post['spotId'];
            unset($post['spotId']);

            $data = [
                'spotId' => $spotId,
                'orderDetails' => $post,
                'buyerRole' => $this->config->item('buyer'),
                'usershorturl' => 'tiqs_shop_service',
                'salesagent' => $this->config->item('tiqsId'),
            ];

            $this->loadViews('publicorders/checkoutOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function submitOrder(): void
        {
            $data = $this->input->post(null, true);
            $spotId = $data['order']['spotId'];
            $makeOrderRedirect = 'make_order?spotid=' . $spotId;
            unset($data['order']['spotId']);

            // get buyer id
            $data['user']['username'] = $data['user']['first_name'] . ' ' . $data['user']['second_name'];
            $this->user_model->manageAndSetBuyer($data['user']);

            if (!$this->user_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Please try again');
                redirect($makeOrderRedirect);
                exit();
            }

            // insert order
            $data['order']['buyerId'] = $this->user_model->id;
            $data['order']['paid'] = '0';

            $this->shoporder_model->setObjectFromArray($data['order'])->create();            
            
            if (!$this->shoporder_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Please try again');
                redirect($makeOrderRedirect);
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
                    redirect($makeOrderRedirect);
                    exit();
                }
            }

            // go to paying if everything OK
            $_SESSION['orderId'] = $this->shoporder_model->id;
            $_SESSION['spotId'] = $spotId;
            redirect('payshop/payOrder');
            exit();
        }
    }

