<?php
declare(strict_types=1);

if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Scanner extends BaseControllerWeb
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        // $this->load->helper('form');
        // $this->load->helper('validate_data_helper');
        // $this->load->helper('utility_helper');
        // $this->load->helper('country_helper');
        // $this->load->helper('date');
        // $this->load->helper('jwt_helper');
        // $this->load->helper('fod_helper');


        $this->load->model('shoporder_model');
        // $this->load->model('shoporderex_model');
        // $this->load->model('user_model');
        // $this->load->model('shopspot_model');
        // $this->load->model('shopvendor_model');
        // $this->load->model('shopvisitorreservtaion_model');
        // $this->load->model('shopvendortime_model');
        // $this->load->model('shopspottime_model');
        // $this->load->model('shopvoucher_model');
        // $this->load->model('shopsession_model');
        // $this->load->model('fodfdm_model');
        // $this->load->model('shopprinters_model');
        // $this->load->model('shopvendortemplate_model');
        // $this->load->model('shoppaymentmethods_model');

        $this->load->config('custom');

        $this->load->library('language', array('controller' => $this->router->class));


        $this->load->library('session');
    }

    public function index(): void
    {
        $this->global['pageTitle'] = 'TIQS : SCANNER';

        $this->loadViews('scanner/scanner', $this->global, null, null, 'headerWarehousePublic');
    }
}