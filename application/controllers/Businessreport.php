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
		$report = $this->group_by('order_id',$report);
		$report = $this->table_data($report);
		echo json_encode($report);
		
	}

	public function sortWidgets()
    {
    
        $userId = $this->session->userdata("userId");
        $this->businessreport_model->sortWidgets($userId);  
    }

    public function sortedWidgets()
    {
        $userId = $this->session->userdata("userId");
        echo json_encode($this->businessreport_model->sortedWidgets($userId));
	}
	


	function group_by($key, $data) {

		$result = array();

		foreach($data as $val) {
			if(array_key_exists($key, $val)){
				$result[$val[$key]][] = $val;
			}else{
				$result[""][] = $val;
			}
		}

		return $result;
	}

	function row_total($key,$data){
		$sum = 0;
		foreach ($data as $item) {
			$sum += $item[$key];
		}
		return $sum;
	}

	function table_data($data){
		$rows = [];
		foreach($data as $key =>$val){
			$total_price = $this->row_total('price',$val);
			$total_quantity = $this->row_total('quantity',$val);
			$total_AMOUNT = $this->row_total('AMOUNT',$val)+$val[0]['serviceFee'];
			$total_EXVAT = $this->row_total('EXVAT',$val);
			$total_VAT = $this->row_total('VAT',$val);
			$total_EXVATSERVICE = $this->row_total('EXVATSERVICE',$val);

			
			
			$rows[] = [
				'order_id'=>$val[0]['order_id'],
				'order_date'=>$val[0]['order_date'],
				'serviceFee'=>$val[0]['serviceFee'],
				'service_type'=>$val[0]['service_type'],
				'price'=>$total_price,
				'quantity'=>$total_quantity,
				'AMOUNT'=>$total_AMOUNT,
				'EXVAT'=>$total_EXVAT,
				'VAT'=>$total_VAT,
				'EXVATSERVICE' => $total_EXVATSERVICE,
				'child'=>$val];
		}

		return $rows;

	}



}
