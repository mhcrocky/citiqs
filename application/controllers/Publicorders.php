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

        public function confirm_order(): void
        {
            if (empty($_POST)) {
                redirect('make_order');
            }
            var_dump($_POST);
        }
    }
    