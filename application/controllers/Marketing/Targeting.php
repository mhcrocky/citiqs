<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';


class Targeting extends BaseControllerWeb
{
	private $vendor_id;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('targeting_model');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
	}

	public function index()
	{ 
		$data['title'] = 'Targeting';
		$vendor_id = $this->vendor_id;
		$data['queries'] = $this->targeting_model->get_queries($vendor_id);
		$data['cronJobs'] = $this->targeting_model->getCronJobs();
		$this->global['pageTitle'] = 'TIQS: Targeting';
		$this->loadViews("marketing/targeting", $this->global, $data, 'footerbusiness', 'headerbusiness'); // payment screen

	}

	public function get_report(){
		ini_set('memory_limit','1024M');
		$vendor_id = $this->vendor_id;//418
		$sql1 = ($this->input->post('sql1') == 'AND%20()') ? "" : rawurldecode($this->input->post('sql1'));
		$sql2 = ($this->input->post('sql2') == 'undefined') ? "" : rawurldecode($this->input->post('sql2'));
		$pickup = $this->targeting_model->get_pickup_report($vendor_id, $sql1, $sql2);
		$delivery = $this->targeting_model->get_delivery_report($vendor_id, $sql1, $sql2);
		$local = $this->targeting_model->get_local_report($vendor_id, $sql1, $sql2);
		$report = array_merge($pickup, $delivery, $local);
		$report = $this->group_by('order_id',$report);
		$report = $this->table_data($report);
		echo json_encode($report);
		
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
			$rows[] = [
				'order_id'=>$val[0]['order_id'],
				'total_AMOUNT'=>($total_AMOUNT+$val[0]['serviceFee']+$val[0]['waiterTip']),
				'quantity'=>$total_quantity,
				'service_type'=>$val[0]['service_type'],
				'serviceFee'=>$val[0]['serviceFee'],
				'serviceFeeTax'=>$val[0]['serviceFeeTax'],
				'VATSERVICE'=>$val[0]['VATSERVICE'],
				'EXVATSERVICE'=>$val[0]['EXVATSERVICE'],
				'waiterTip'=>$val[0]['waiterTip'],
				'AMOUNT'=>$total_AMOUNT,
//				'EXVAT'=>$total_EXVAT,
//				'VAT'=>$total_VAT,
				'order_date'=>$val[0]['order_date'],
				'username' => $val[0]['username'],
				'email' => $val[0]['email'],
				//'price'=>$total_price,
				'child'=>$val,
				'vendor_id'=> $this->session->userdata("userId"),
				'paymenttype' => $val[0]['paymenttype'],
				'user_id' => $val[0]['buyerId']
			];
			
		}

		return $rows;

	}

	public function save_results(){
		$results = $this->input->post('results');
		return $this->targeting_model->save_results($results);
	}

	public function save_query(){
		$data = $this->input->post(null,true);
		$data['vendor_id'] = $this->vendor_id;
		return $this->targeting_model->save_query($data);
	}

	public function save_cron_job(){
		$data = $this->input->post(null,true);
		return $this->targeting_model->saveQueryCron($data);
	}

	public function edit_query(){
		$data = $this->input->post(null,true);
		$id = $data['id'];
		unset($data['id']);
		$this->targeting_model->update_query($id, $data);
		return ;
	}

	public function delete_query(){
		$data = $this->input->post(null,true);
		$id = $data['id'];
		unset($data['id']);
		$this->targeting_model->delete_query($id);
		return ;
	}
	

}
