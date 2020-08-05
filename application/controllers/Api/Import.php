<?php
    declare(strict_types=1);

    ini_set('max_execution_time', '3600');

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class Import extends REST_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model('shopimport_model');
            // $this->load->model('shopprinters_model');
            // $this->load->model('shoporder_model');
            // $this->load->model('shoporderex_model');

            $this->load->helper('utility_helper');
            $this->load->helper('validate_data_helper');
            // $this->load->helper('sanitize_helper');            
            // $this->load->helper('email_helper');

            // $this->load->config('custom');
            $this->load->library('language', array('controller' => $this->router->class));
        }

        public function data_get(): void
        {
            $data = $this->input->get(null, true);

            $import = $this
                        ->shopimport_model
                        ->setProperty('vendorId', $data['vendorid'])
                        ->setShopVendor()
                        ->setDatabaseCredantations($data)
                        ->setConnection()
                        ->setMainProductTypeId()
                        ->setVendorCategory()
                        ->import();

            echo ($import) ? 'Import succes' : 'Import failed';

            die();
        }

    }
