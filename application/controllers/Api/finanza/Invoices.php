<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Invoices extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('shopprinters_model');
		$this->load->model('shoporder_model_finanza');
		$this->load->model('shoporderex_model');
		$this->load->model('shopvendor_model');

		$this->load->helper('utility_helper');
		$this->load->helper('validate_data_helper');
		$this->load->helper('sanitize_helper');
		$this->load->helper('email_helper');
		$this->load->helper('curl_helper');

		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function orders_get($vendorId)
	{
		$orderslist = $this->shoporder_model_finanza->returnInfoOrders($vendorId);
		echo json_encode($orderslist);
	}

	public function ordersselected_get($vendorId, $accepted, $processed, $ready, $refused)
	{
		$orderslist = $this->shoporder_model_finanza->returnOrders($vendorId);
		echo json_encode($orderslist);
	}

		public function orderprocessed_get($vendorId)
	{
		$processed = true;
		echo json_encode($processed);

	}

}

