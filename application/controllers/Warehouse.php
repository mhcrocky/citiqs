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
            $this->load->model('shopcategories_model');
            $this->load->model('shopproducts_model');
            $this->load->model('shopproductex_model');
            $this->load->model('shoporders_model');
            $this->load->model('shopordersex_model');

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

        public function productCategories(): void
        {
            $this->global['pageTitle'] = 'TIQS : CATEGOIRES';

            $this->loadViews('warehouse/productCategories', $this->global, null, null, 'headerWarehouse');
        }

        public function products(): void
        {
            $this->global['pageTitle'] = 'TIQS : PRODUCTS';

            $this->loadViews('warehouse/products', $this->global, null, null, 'headerWarehouse');
        }

        public function orders(): void
        {
            $this->global['pageTitle'] = 'TIQS : ORDERS';

            $this->loadViews('warehouse/orders', $this->global, null, null, 'headerWarehouse');
        }
    }
