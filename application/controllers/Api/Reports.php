<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Reports extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('shoporder_model');
		$this->load->model('businessreport_model');
		
		$this->load->helper('utility_helper');

		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function index_get(): void
	{
		return;
    }

    public function reports_get(): void
    {
		$vendorId = intval($this->input->get('vendorid', true));
		if (!$vendorId) return;
		$data = $this->shoporder_model->getDayReport($vendorId);
		if (!$data) return;
		$data = Utility_helper::resetArrayByKeyMultiple($data, 'order_id');
		#echo '<pre>'		;
		#print_r($data);
		ksort($data, SORT_NUMERIC);
		var_dump($data);
		
    }
}

