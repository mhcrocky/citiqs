<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Businessreport extends BaseControllerWeb
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('businessreport_model');
		if (empty($this->session->userdata('userId'))) {
			redirect('login');
		}


	}

	public function index()
	{ 
		$data['title'] = 'Business Reports';

		$this->global['pageTitle'] = 'TIQS Business Reports';
		$data['service_types'] = $this->businessreport_model->get_service_types();
		$this->loadViews("businessreport/index", $this->global, $data, 'footerbusiness', 'headerbusiness'); // payment screen

	}

	public function get_report(){
		$vendor_id = $this->session->userdata("userId");//418;
		$report = $this->businessreport_model->get_report($vendor_id);
		echo json_encode($report);
		
	}

}
