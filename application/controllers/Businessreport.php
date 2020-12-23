<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include(APPPATH . '/libraries/koolreport/core/autoload.php');

require APPPATH . '/libraries/BaseControllerWeb.php';

use \koolreport\drilldown\DrillDown;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\clients\Bootstrap;


class Businessreport extends BaseControllerWeb
{
	private $vendor_id;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('businessreport_model');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
	}

	public function index()
	{ 
		$data['title'] = 'Business Reports';
		$vendor_id = $this->vendor_id;
		$this->global['pageTitle'] = 'TIQS Business Reports';
		$data['day_total'] = $this->businessreport_model->get_day_totals($vendor_id);
		$data['last_week_total'] = $this->businessreport_model->get_this_week_totals($vendor_id);
		$data['compare'] = $this->businessreport_model->get_last_week_compare($vendor_id);
		$data['service_types'] = $this->businessreport_model->get_service_types();
		$data['day_orders'] = $this->businessreport_model->get_day_orders($vendor_id);
		$data['week_orders'] = $this->businessreport_model->get_this_week_orders($vendor_id);
		$data['last_week_orders'] = $this->businessreport_model->get_last_week_orders($vendor_id);
		$this->loadViews("businessreport/index", $this->global, $data, 'footerbusiness', 'headerbusiness'); // payment screen

	}

	public function get_report(){
		ini_set('memory_limit','1024M');
		$vendor_id = $this->vendor_id;//418
		$sql = $this->input->post('sql');
		$pickup = $this->businessreport_model->get_pickup_report($vendor_id, $sql);
		$delivery = $this->businessreport_model->get_delivery_report($vendor_id, $sql);
		$local = $this->businessreport_model->get_local_report($vendor_id, $sql);
		$report = array_merge($pickup, $delivery, $local);
		$report = $this->group_by('order_id',$report);
		$report = $this->table_data($report);
		echo json_encode($report);
		
	}

	public function get_timestamp_totals(){
		$vendor_id = $this->vendor_id;
		$min_date = $this->input->post('min');
		$max_date = $this->input->post('max');
		$totals = $this->businessreport_model->get_date_range_totals($vendor_id, $min_date, $max_date);
		echo json_encode($totals);
		
	}

	public function sortWidgets()
    { 
    
        $userId = $this->vendor_id;
        $this->businessreport_model->sortWidgets($userId);  
    }

    public function sortedWidgets()
    {
        $userId = $this->vendor_id;
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
				'EXVAT'=>$total_EXVAT,
				'VAT'=>$total_VAT,
				'order_date'=>$val[0]['order_date'],
				//'price'=>$total_price,
				'child'=>$val
			];
			
		}

		return $rows;

	}

	public function get_timestamp_orders(){
		$vendor_id = $this->vendor_id;
		$min_date = $this->input->post('min');
		$max_date = $this->input->post('max');
		$orders = $this->businessreport_model->get_date_range_orders($vendor_id, $min_date, $max_date);
		echo json_encode($orders);
	}

	public function get_graphs(){
		$vendor_id = $this->vendor_id;
		$graphs = DrillDown::create(array(
            "name" => "saleDrillDown",
            "title" => " ",
            "levels" => array(
                array(
                    "title" => "Business Report",
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->businessreport_model->get_report_of($this->session->userdata('userId'), $this->input->post('min'), $this->input->post('max'),$this->input->post('selected'), $this->input->post('sql'))), 
                            "columns" => array(
                                "date" => array(
                                    "type" => "string",
                                    "label" => "Date",
								),
								"local" => array(
                                    "label" => "Local",
                                ),
                                "pickup" => array(
                                    "label" => "Pickup",
                                ),
								"delivery" => array(
									"label" => "Delivery",
								)
							),
							"class"=>array(
								"button"=>"bg-warning"
							),
                            "clientEvents" => array(
                                "itemSelect" => "function(params){
                                    saleDrillDown.next({date:params.selectedRow[1]});
                                }",
                            )
                        ));
                    }
                ),

 

            ),
           
		), true);
		echo json_encode($graphs);

	}

}
