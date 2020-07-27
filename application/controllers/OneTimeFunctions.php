<?php
    declare(strict_types=1);

    set_time_limit(2400);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';

    class OneTimeFunctions extends BaseControllerWeb
    {
        
        public function __construct()
        {
            parent::__construct();

            $this->load->helper('url');
            $this->load->helper('validate_data_helper');
            $this->load->helper('utility_helper');

            // $this->load->model('user_subscription_model');
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
            $this->load->model('shopvendor_model');
            

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');

            $this->load->config('custom');
        }

        public function insertProductsSpots(): void
        {
            // var_dump('START_TIME: ' . date('Y-m-d H:i:s'));
            // $venodrs = $this->shopvendor_model->readImproved([
            //     'what' => ['vendorId'],
            //     'where' => ['id>' => 0],
            // ]);
            
            // foreach ($venodrs as $venodrId) {
            //     $userId = intval($venodrId['vendorId']);
            //     $this->shopspotproduct_model->insertSpotAndProducts($this->shopspot_model, $this->shopproduct_model, $userId);
                
            // }

            

            // var_dump('END_TIME: ' . date('Y-m-d H:i:s'));
            // var_dump('MEMOR_GET_USAGE: '. memory_get_usage());
            // var_dump('MEMOR_GET_PEAK_USAGE: '. memory_get_peak_usage());
            // die('done');

        }
    }