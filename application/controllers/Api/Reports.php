<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Reports extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('shopprinters_model');
		// $this->load->model('shoporder_model');
		// $this->load->model('shoporderex_model');
		// $this->load->model('shopvendor_model');
		// $this->load->model('fodfdm_model');

		// $this->load->helper('utility_helper');
		// $this->load->helper('validate_data_helper');
		// $this->load->helper('sanitize_helper');
		// $this->load->helper('email_helper');
		// $this->load->helper('curl_helper');
		// $this->load->helper('orderprint_helper');

		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function index_get(): void
	{
		return;
    }
    
    public function xreport_get(): void
    {
        // $mac = $
        // var_dump($mac);

        // die();
    }
}

