<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';

    class Pos extends BaseControllerWeb
    {

        public function __construct()
        {
            parent::__construct();

            $this->load->helper('url');
            $this->load->helper('validate_data_helper');
            $this->load->helper('utility_helper');
            $this->load->helper('country_helper');
            $this->load->helper('date');
            $this->load->helper('jwt_helper');

            $this->load->model('user_subscription_model');
            $this->load->model('shopcategory_model');
            $this->load->model('shopproduct_model');
            $this->load->model('shopproductex_model');
            $this->load->model('shoporder_model');
            $this->load->model('shoporderex_model');
            $this->load->model('user_model');
            $this->load->model('shopspot_model');
            $this->load->model('shopvendor_model');
            $this->load->model('shopvisitorreservtaion_model');
            $this->load->model('shopvendortime_model');
            $this->load->model('shopspottime_model');
            $this->load->model('shopvoucher_model');
            $this->load->model('shopsession_model');

            $this->load->config('custom');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');

            $this->isLoggedIn();
        }

        public function index(): void
        {

            $data = [];
            $userId = intval($_SESSION['userId']);

            // var_dump($userId);
            // die();


            $this->global['pageTitle'] = 'TIQS : POS';
            $this->loadViews('pos/pos', $this->global, null, null, 'headerWarehouse');
        }


    }
