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
            $this->load->helper('country_helper');
            

            $this->load->model('user_subscription_model');
            $this->load->model('shopcategory_model');
            $this->load->model('shopproduct_model');
            $this->load->model('shopproductex_model');
            $this->load->model('shoporder_model');
            $this->load->model('shoporderex_model');
            $this->load->model('user_model');
            $this->load->model('shopspot_model');
            $this->load->model('shopvendor_model');

            $this->load->config('custom');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');
        }

        public function index(): void
        {
            $get = $this->input->get(null, true);

            // FETCH AND SAVE VENDOR DATA IN SESSION
            $vendor = $this->shopvendor_model->setProperty('vendorId', $get['vendorid'])->getVendorData();
            if (is_null($vendor['payNlServiceId'])) {
                redirect(base_url());
            }
            $_SESSION['vendor'] = $vendor;

            // VENDOR SELECTED SPOT VIEW
            if (isset($get['spotid'])) {
                $spotId = intval($_GET['spotid']);
                if ($this->shopspot_model->setObjectId($spotId)->isActive()) {
                    $this->loadSpotView($spotId);
                    return;
                }
            }
            
            // SELECT VENDOR SPOT VIEW
            $this->loadVendorView();
            return;
      
        }

        private function loadSpotView(int $spotId): void
        {
            $this->global['pageTitle'] = 'TIQS : ORDERING';

            $userId = $_SESSION['vendor']['vendorId'];
            $time = time();

            $data = [
                'categoryProducts' => $this->shopproductex_model->getUserProductsPublic($userId),
                'spotId' => $spotId,
                'day' => date('D', $time),
                'hours' => strtotime(date('H:i:s', $time))
            ];
            
            $data['ordered'] = isset($_SESSION['order']) ? $_SESSION['order'] : null;

            $this->loadViews('publicorders/makeOrder', $this->global, $data, null, 'headerWarehousePublic');
            return;
        }

        private function loadVendorView(): void
        {
            $this->global['pageTitle'] = 'TIQS : SELECT SPOT';

            $where = [
                'tbl_shop_printers.userId=' => $_SESSION['vendor']['vendorId'],
                'tbl_shop_spots.active' => '1'
            ];

            $data = [
                'vendor' => $_SESSION['vendor'],
                'spots' => $this->shopspot_model->fetchUserSpotsImporved($where)
            ];

            $this->loadViews('publicorders/selectSpot', $this->global, $data, null, 'headerWarehousePublic');
            return;
        }

        public function checkout_order(): void
        {
            $this->global['pageTitle'] = 'TIQS : CHECKOUT';
            if ( (empty($_POST) && !isset($_SESSION['order'])) || (!isset($_SESSION['vendor']) || !$_SESSION['vendor']) ) {
                redirect(base_url());
            }

            $post = $this->input->post(null, true);

            if (!empty($post)) {
                $_SESSION['spotId'] = $post['spotId'];
                unset($post['spotId']);
                $_SESSION['order'] = $post;
            }

            $data = [
                'spotId' => $_SESSION['spotId'],
                'vendor' =>  $_SESSION['vendor'],
                'orderDetails' => $_SESSION['order'],
                'buyerRole' => $this->config->item('buyer'),
                'usershorturl' => 'tiqs_shop_service',
                'salesagent' => $this->config->item('tiqsId'),
                'countries' => Country_helper::getCountries(),
                'countryCodes' => Country_helper::getCountryPhoneCodes(),
            ];

            $data['username'] = isset($_SESSION['postOrder']['user']['username']) ? $_SESSION['postOrder']['user']['username'] : '';
            $data['email'] = isset($_SESSION['postOrder']['user']['email']) ? $_SESSION['postOrder']['user']['email'] : '';
            $data['userCountry'] = isset($_SESSION['postOrder']['user']['country']) ? $_SESSION['postOrder']['user']['country'] : '';
            $data['mobile'] = isset($_SESSION['postOrder']['user']['mobile']) ? $_SESSION['postOrder']['user']['mobile'] : '';
            $data['phoneCountryCode'] = isset($_SESSION['postOrder']['phoneCountryCode']) ? $_SESSION['postOrder']['phoneCountryCode'] : Country_helper::getCountryCodeFromIp();

            $this->loadViews('publicorders/checkoutOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function submitOrder(): void
        {
            if (empty($_POST) || !isset($_SESSION['order']) || !$_SESSION['vendor']) {
                redirect(base_url());
            }
            $_SESSION['postOrder'] = $this->input->post(null, true);
            

            redirect('pay_order');
        }

        public function pay_order(): void
        {
            if (!isset($_SESSION['order']) || !$_SESSION['vendor'] || !$_SESSION['postOrder']) {
                redirect(base_url());
            }

            $this->global['pageTitle'] = 'TIQS : PAY';

            $data = [
                'ordered' => $_SESSION['order'],
                'vendor' => $_SESSION['vendor'],
                'paymentMethod' => $this->config->item('idealPaymentType'),
            ];

            $this->loadViews('publicorders/payOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function insertOrder($paymentType): void
        {
            if (!isset($_SESSION['order']) || !$_SESSION['vendor'] || !$_SESSION['postOrder'] || !$_SESSION['spotId']) {
                redirect(base_url());
            }

            
            // fetch order data from session and unset $_SESSION['postOrder']
            $post = Utility_helper::getSessionValue('postOrder');
            $post['user']['mobile'] = $post['phoneCountryCode'] . $post['user']['mobile'];
            $this->user_model->manageAndSetBuyer($post['user']);
            if (!$this->user_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Email, name and mobile are mandatory fields. Please try again');
                redirect('checkout_order');
                exit();
            }

            // prepare failed redirect
            $failedRedirect = 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'] . '&spotid=' . $_SESSION['spotId'];

            // unset session data
            unset($_SESSION['order']);
            unset($_SESSION['spotId']);

            // insert order
            $post['order']['buyerId'] = $this->user_model->id;
            $post['order']['paid'] = '0';

            $this->shoporder_model->setObjectFromArray($post['order'])->create();            
            
            if (!$this->shoporder_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Please try again');
                redirect($failedRedirect);
                exit();
            }

            // insert order details
            foreach ($post['orderExtended'] as $id => $details) {
                $details['productsExtendedId'] = intval($id);
                $details['orderId'] = $this->shoporder_model->id;
                if (!$this->shoporderex_model->setObjectFromArray($details)->create()) {
                    $this->shoporderex_model->orderId = $details['orderId'];
                    $this->shoporderex_model->deleteOrderDetails();
                    $this->shoporder_model->delete();
                    $this->session->set_flashdata('error', 'Order not made! Please try again');
                    redirect($failedRedirect);
                    exit();
                }
            }

            // save orderId in SESSION
            $_SESSION['orderId'] = $this->shoporder_model->id;

            // go to Alfredpament controller to finish paying
            $successRedirect = 'paymentengine' . DIRECTORY_SEPARATOR . $paymentType;
            redirect($successRedirect);
        }
    }
