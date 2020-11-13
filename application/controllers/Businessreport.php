<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Businessreport extends BaseControllerWeb
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('businessreport_model');
		/*
		if (empty($this->session->userdata('userId'))) {
			redirect('login');
		}
		*/


	}

	public function index()
	{ 
		$data['title'] = 'Business Reports';
		$vendor_id = $this->session->userdata("userId");
		$this->global['pageTitle'] = 'TIQS Business Reports';
		$data['local_total'] = $this->businessreport_model->get_local_total($vendor_id);
		$data['delivery_total'] = $this->businessreport_model->get_delivery_total($vendor_id);
		$data['pickup_total'] = $this->businessreport_model->get_pickup_total($vendor_id);
		$data['service_types'] = $this->businessreport_model->get_service_types();
		$this->loadViews("businessreport/index", $this->global, $data, 'footerbusiness', 'headerbusiness'); // payment screen

	}

	public function get_report(){
		$vendor_id = $this->session->userdata("userId");//418
		$pickup = $this->businessreport_model->get_pickup_report($vendor_id);
		$delivery = $this->businessreport_model->get_delivery_report($vendor_id);
		$local = $this->businessreport_model->get_local_report($vendor_id);
		$report = array_merge($pickup, $delivery, $local);
		echo json_encode($report);
		
	}


}
