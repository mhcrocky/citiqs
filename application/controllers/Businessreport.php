<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Businessreport extends BaseControllerWeb
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('businessreport_model');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
	}

	public function index()
	{ 
		$data['title'] = 'Business Reports';
		$vendor_id = $this->session->userdata("userId");
		$this->global['pageTitle'] = 'TIQS Business Reports';
		$data['day_total'] = $this->businessreport_model->get_day_totals($vendor_id);
		$data['last_week_total'] = $this->businessreport_model->get_this_week_totals($vendor_id);
		$data['compare'] = $this->businessreport_model->get_last_week_compare($vendor_id);
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

	public function sortWidgets()
    {
        $this->load->model('user_modelpublic');
        $userId = $this->session->userdata("userId");
        $this->businessreport_model->sortWidgets($userId);  
    }

    public function sortedWidgets()
    {
        $this->load->model('user_modelpublic');
        $userId = $this->session->userdata("userId");
        echo json_encode($this->businessreport_model->sortedWidgets($userId));
    }


}
