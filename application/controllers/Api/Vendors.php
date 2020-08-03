<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class Vendors extends REST_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model('shopvendor_model');
            $this->load->model('api_model');


            $this->load->library('language', array('controller' => $this->router->class));
        }

        public function data_get(): void
        {
            $header = getallheaders();
            $key = $header['x-api-key'];
            if ($this->api_model->userAuthentication($key)) {
                $where = [
                    'tbl_shop_vendors.payNlServiceId!=' => null,
                ];
                $vendors = $this->shopvendor_model->getVendors($where);
                $this->set_response($vendors, 200);
            }
            return;
        }

    }

