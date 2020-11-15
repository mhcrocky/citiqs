<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class AccountingReports extends BaseControllerWeb
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AccountingReports_model','accounting_reports');
		/*
		if (empty($this->session->userdata('userId'))) {
			redirect('login');
		}
		*/


	}

	public function index()
	{
		$data['title'] = 'Orders';
		$vendor_id = $this->session->userdata("userId");
		$this->global['pageTitle'] = 'TIQS Accounting Reports';
		$data['local_total'] = $this->accounting_reports->get_local_total($vendor_id);
		$data['delivery_total'] = $this->accounting_reports->get_delivery_total($vendor_id);
		$data['pickup_total'] = $this->accounting_reports->get_pickup_total($vendor_id);
		$data['service_types'] = $this->accounting_reports->get_service_types();
		$this->loadViews("accounting_reports/index", $this->global, $data, 'footerbusiness', 'headerbusiness'); // payment screen

	}

	public function get_report(){
		$vendor_id = $this->session->userdata("userId");//418
		$pickup = $this->accounting_reports->get_pickup_report($vendor_id);
		$delivery = $this->accounting_reports->get_delivery_report($vendor_id);
		$local = $this->accounting_reports->get_local_report($vendor_id);
		$local = $this->group_by('order_id',$local);
		$local = $this->table_data($local);

		// echo '<pre>';
		// print_r($local);
		// exit;
		// print_r($delivery);
		$report = array_merge($pickup, $delivery, $local);
		// print_r($report);
		// exit;
		echo json_encode(['data'=>$report]);

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
			if($val[0]['export_ID']!=''){
				$status = 'Exported';
			}else{
				$status = 'N/A';
			}
			$exservicefee = ($val[0]['serviceFee'])-($val[0]['VATSERVICE']);
			$rows[] = ['order_id'=>$val[0]['order_id'],'order_date'=>$val[0]['order_date'],'serviceFee'=>$val[0]['serviceFee'],'serviceFeeTax'=>$val[0]['serviceFeeTax'],'EXServiceFee'=>$exservicefee,'VATSERVICE'=>$val[0]['VATSERVICE'],'export_ID'=>$val[0]['export_ID'],'status'=>$status,'service_type'=>$val[0]['service_type'],'price'=>$total_price,'quantity'=>$total_quantity,'AMOUNT'=>$total_AMOUNT,'EXVAT'=>$total_EXVAT,'VAT'=>$total_VAT,'child'=>$val];
		}

		return $rows;

	}




}
