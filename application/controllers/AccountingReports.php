<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class AccountingReports extends BaseControllerWeb
{
	private $vendor_id;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('accountingReports_model','accounting_reports');
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
		// echo 'here';
		// die;
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
		$vendor_id = $this->vendor_id;
		$data['day_total'] = $this->accounting_reports->get_day_totals($vendor_id);
		$data['last_week_total'] = $this->accounting_reports->get_this_week_totals($vendor_id);
		$data['compare'] = $this->accounting_reports->get_last_week_compare($vendor_id);
		$data['service_types'] = $this->accounting_reports->get_service_types();
		$this->loadViews("accounting_reports/index2", $this->global, $data, 'footerbusiness', 'headerbusiness'); // payment screen

	}

	public function get_report(){
		$vendor_id = $this->vendor_id;//418
		$pickup = $this->accounting_reports->get_pickup_report($vendor_id);
		$delivery = $this->accounting_reports->get_delivery_report($vendor_id);
		$local = $this->accounting_reports->get_local_report($vendor_id);
		$report = array_merge($pickup, $delivery, $local);
		$report = $this->group_by('order_id',$report);
		$report = $this->table_data($report);
		echo json_encode($report);

	}

	public function get_timestamp_totals(){
		$vendor_id = $this->vendor_id;
		$min_date = $this->input->post('min');
		$max_date = $this->input->post('max');
		$totals = $this->accounting_reports->get_date_range_totals($vendor_id, $min_date, $max_date);
		echo json_encode($totals);

	}

	public function sortWidgets()
    {

        $userId = $this->vendor_id;
        $this->accounting_reports->sortWidgets($userId);
    }

    public function sortedWidgets()
    {
        $userId = $this->vendor_id;
        echo json_encode($this->accounting_reports->sortedWidgets($userId));
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
			$total_AMOUNT = $this->row_total('AMOUNT',$val);
			$total_EXVAT = $this->row_total('EXVAT',$val);
			$total_VAT = $this->row_total('VAT',$val);
			$total_EXVATSERVICE = $this->row_total('EXVATSERVICE',$val);
			$exservicefee = ($val[0]['serviceFee'])-($val[0]['VATSERVICE']);
			if($val[0]['export_ID']!=''){
				$status = 'Exported';
			}else{
				$status = 'N/A';
			}
			$rows[] = [
				'order_id'=>$val[0]['order_id'],
				'order_date'=>$val[0]['order_date'],
				'serviceFee'=>$val[0]['serviceFee'],
				'serviceFeeTax'=>$val[0]['serviceFeeTax'],
				'waiterTip'=>$val[0]['waiterTip'],
				'EXVATSERVICE'=>$exservicefee,
				'VATSERVICE'=>$val[0]['VATSERVICE'],
				'service_type'=>$val[0]['service_type'],
				'price'=>$total_price,
				'quantity'=>$total_quantity,
				'total_AMOUNT'=>($total_AMOUNT+$val[0]['serviceFee']+$val[0]['waiterTip']),
				'AMOUNT'=>$total_AMOUNT,
				'EXVAT'=>$total_EXVAT,
				'status'=>$status,
				'export_ID' =>$val[0]['export_ID'],
				'VAT'=>$total_VAT,
				'child'=>$val
			];

		}

		return $rows;

	}




}
