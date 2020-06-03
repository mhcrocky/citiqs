<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';

    class  Warehouse extends BaseControllerWeb
    {

        public function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->helper('validate_data_helper');
            $this->load->helper('utility_helper');

            $this->load->model('user_subscription_model');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('form_validation');
            $this->load->config('custom');
            $this->isLoggedIn();
        }

        public function index(): void
        {
            if (!$this->user_subscription_model->getLastSubscriptionId($this->userId)) redirect('profile');

            $this->global['pageTitle'] = 'TIQS : WAREHOSUE';

            $this->loadViews('warehouse/warehouse', $this->global, null, null, 'headerWarehouse');
        }

        public function productCategories(): void
        {
            if (!$this->user_subscription_model->getLastSubscriptionId($this->userId)) redirect('profile');

            $this->global['pageTitle'] = 'TIQS : CATEGOIRES';

            $this->loadViews('warehouse/productCategories', $this->global, null, null, 'headerWarehouse');
        }

        public function products(): void
        {
            if (!$this->user_subscription_model->getLastSubscriptionId($this->userId)) redirect('profile');

            $this->global['pageTitle'] = 'TIQS : PRODUCTS';

            $this->loadViews('warehouse/products', $this->global, null, null, 'headerWarehouse');
        }

        public function orders(): void
        {
            if (!$this->user_subscription_model->getLastSubscriptionId($this->userId)) redirect('profile');

            $this->global['pageTitle'] = 'TIQS : ORDERS';

            $this->loadViews('warehouse/orders', $this->global, null, null, 'headerWarehouse');
        }
    }
