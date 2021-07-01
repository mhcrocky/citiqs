<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include(APPPATH . '/libraries/koolreport/core/autoload.php');

require APPPATH . '/libraries/BaseControllerWeb.php';

use \koolreport\drilldown\DrillDown;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\clients\Bootstrap4;


class Businessreport extends BaseControllerWeb
{
	private $vendor_id;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('businessreport_model');
		$this->load->model('event_model');
		$this->load->model('shopprinters_model');
		$this->load->model('shoppaymentmethods_model');
		$this->load->model('shopvendor_model');

		$this->load->library('language', array('controller' => $this->router->class));
		$this->load->config('custom');

		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
	}

	public function index()
	{ 
		$data['title'] =  $this->language->tLine('Business Reports');
		$vendor_id = $this->vendor_id;
		$this->global['pageTitle'] = $this->language->tLine('TIQS Business Reports');
		$data['day_total'] = $this->businessreport_model->get_day_totals($vendor_id);
		$data['last_week_total'] = $this->businessreport_model->get_this_week_totals($vendor_id);
		$data['compare'] = $this->businessreport_model->get_last_week_compare($vendor_id);
		$data['day_orders'] = $this->businessreport_model->get_day_orders($vendor_id);
		$data['week_orders'] = $this->businessreport_model->get_this_week_orders($vendor_id);
		$data['last_week_orders'] = $this->businessreport_model->get_last_week_orders($vendor_id);
		$event_orders = $this->event_model->get_events_stats($vendor_id);
		$tickets_gender = $this->event_model->get_tickets_gender($vendor_id);
		if(is_array($event_orders) && count($event_orders) > 0){
			$data['tags'] = $event_orders['tag'];
			$data['bookings_number'] = $event_orders['booking_number'];
			$data['amounts'] = $event_orders['amount'];
			unset($event_orders['tag']);
			unset($event_orders['booking_number']);
			unset($event_orders['amount']);
		}
		if(is_array($tickets_gender) && count($tickets_gender) > 0){
			$data['gender_tags'] = $tickets_gender['tag'];
			$data['avg_age'] = $tickets_gender['avg_age'];
			unset($tickets_gender['tag']);
			unset($tickets_gender['avg_age']);
		}
		
		$data['event_orders'] = $event_orders;
		$data['tickets_gender'] = $this->event_model->get_tickets_gender($vendor_id);
		$this->loadViews("businessreport/index", $this->global, $data, 'footerbusiness', 'headerbusiness'); // payment screen

	}

	public function reports()
	{
		$this->global['pageTitle'] = 'TIQS: Financial Reports';
		$data = [
			'service_types' => $this->businessreport_model->get_service_types(),
			'title' => 'Financial Reports',
			'xReport' => $this->config->item('x_report'),
			'zReport' => $this->config->item('z_report'),
			'reportPrinters' => $this->shopprinters_model->setProperty('userId', intval($_SESSION['userId']))->checkPrinterReportes(),
			'emailFinanceReporets' => $this->shopvendor_model->setProperty('vendorId', intval($_SESSION['userId']))->getProperty('emailFinanceReporets')
		];
		$this->loadViews("businessreport/reports", $this->global, $data, 'footerbusiness', 'headerbusiness'); // payment screen

	}

	public function get_report(){
		ini_set('memory_limit','1024M');
		$vendor_id = $this->vendor_id;
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
			if(array_key_exists($key, $val)) {
				$result[$val[$key]][] = $val;
			} else {
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
			$totalOrderAmount = floatval($total_AMOUNT) + floatval($val[0]['serviceFee']) + floatval($val[0]['waiterTip']);
			$rows[] = [
				'order_id'=>$val[0]['order_id'],
				'total_AMOUNT'=>($total_AMOUNT+$val[0]['serviceFee']+$val[0]['waiterTip']),
				'voucherAmount' => round($val[0]['voucherAmount'], 2),
				'voucherCode' => $val[0]['voucherCode'],
				'amountWithoutVoucher' => round(($totalOrderAmount - floatval($val[0]['voucherAmount'])), 2),
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
				'username' => $val[0]['username'],
				'email' => $val[0]['email'],
				//'price'=>$total_price,
				'paymenttype' => $val[0]['paymenttype'],
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

	public function get_totals(){
		$totals = $this->businessreport_model->get_report_of($this->vendor_id, $this->input->post('min'), $this->input->post('max'), 'total', '', '');
		if(count($totals) > 0){
			echo json_encode($totals);
			return ;
		}
		echo false;
		
	}

	public function get_graphs($label = false){
		$vendor_id = $this->vendor_id;
		if($this->input->post('labels')){
			$graphs = DrillDown::create(array(
				"name" => "saleDrillDown",
				"title" => " ",
				"levels" => array(
					array(
						"title" => "Business Report",
						"content" => function ($params, $scope) {
							$labels = json_decode($this->input->post('labels'));
							$labels = (array) $labels;
							if(count($labels) > 0){
								$dataSource = $this->businessreport_model->get_label_report_of($this->session->userdata('userId'), $this->input->post('min'), $this->input->post('max'),$this->input->post('selected'), $this->input->post('sql'), $labels);
							} else {
								$dataSource = $this->businessreport_model->get_report_of($this->session->userdata('userId'), $this->input->post('min'), $this->input->post('max'),$this->input->post('selected'), $this->input->post('sql'), $this->input->post('specific'));
							}
							
							ColumnChart::create(array(
								"dataSource" => ($dataSource), 
								"columns" => array(
									"date" => array(
										"type" => "string",
										"label" => "Date",
									),
									"local" => array(
										"label" => "Local",
										"id" => "Local",
										"type" => "number",
										"prefix" => '€',
									    "decimals" => 2
									),
									"pickup" => array(
										"label" => "Pickup",
										"type" => "number",
										"prefix" => '€',
									    "decimals" => 2
									),
									"delivery" => array(
										"label" => "Delivery",
										"type" => "number",
										"prefix" => '€',
									    "decimals" => 2
									),
									"invoice" => array(
										"label" => "Invoices",
										"type" => "number",
										"prefix" => '€',
									    "decimals" => 2
									),
									"booking" => array(
										"label" => "Tickets",
										"type" => "number",
										
									)
								),
								"class"=>array(
									"button"=>"bg-warning"
								),
								"clientEvents" => array(
									"itemSelect" => "function(params){
										var date = params.selectedRow[0];
										var dateSplit = date.split(' - ');
										if(dateSplit.length == 2){
											clickBar(params.columnName);
										}
										
										saleDrillDown.next({spot_id:params.selectedRow[0]});
									}",
								),
								"colorScheme"=>array(
									"#3366cc",
									"#dc3912",
									"#ff9900",
									"#6600cc",
									"#375068"
								)
							));
						}
					),
	
	 
	
				),
			   
			), true);
			echo json_encode($graphs);
			return ;
		}
		$graphs = DrillDown::create(array(
            "name" => "saleDrillDown",
            "title" => " ",
            "levels" => array(
                array(
                    "title" => "Business Report",
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->businessreport_model->get_report_of($this->session->userdata('userId'), $this->input->post('min'), $this->input->post('max'),$this->input->post('selected'), $this->input->post('sql'), $this->input->post('specific'))), 
                            "columns" => array(
                                "date" => array(
                                    "type" => "string",
                                    "label" => "Date",
								),
								"local" => array(
									"label" => "Local",
									"id" => "Local",
									"type" => "number",
									"prefix" => '€',
									"decimals" => 2
                                ),
                                "pickup" => array(
                                    "label" => "Pickup",
									"type" => "number",
									"prefix" => '€',
									"decimals" => 2
                                ),
								"delivery" => array(
									"label" => "Delivery",
									"type" => "number",
									"prefix" => '€',
									"decimals" => 2
								),
								"invoice" => array(
									"label" => "Invoices",
									"type" => "number",
									"prefix" => '€',
									"decimals" => 2
								),
								"booking" => array(
									"label" => "Tickets",
									"type" => "number",
									
								)
							),
							"class"=>array(
								"button"=>"bg-warning"
							),
                            "clientEvents" => array(
                                "itemSelect" => "function(params){
									var date = params.selectedRow[0];
									var dateSplit = date.split(' - ');
									if(dateSplit.length == 2){
										clickBar(params.columnName);
									}
									
                                    saleDrillDown.next({spot_id:params.selectedRow[0]});
                                }",
							),
							"colorScheme"=>array(
								"#3366cc",
								"#dc3912",
								"#ff9900",
								"#6600cc",
								"#375068"
							)
                        ));
                    }
                ),

 

            ),
           
		), true);
		echo json_encode($graphs);

	}

	public function allPaymentMethods(): void
	{
		if (intval($_SESSION['userId']) !== $this->config->item('tiqsId')) {
			redirect('logout');
			exit;
		}

		$this->global['pageTitle'] = 'TIQS: Payment methods';
		$this->loadViews("businessreport/allPaymentMethods", $this->global, null, 'footerbusiness', 'headerbusiness');
	}

	public function paymentMethods(): void
	{
		// $this->shoppaymentmethods_model->insertProductGroupsAndPaymentMethods(intval($_SESSION['userId']));

		$data = [
			'productGroups' => $this->config->item('productGroups')
		];

		$this->global['pageTitle'] = 'TIQS: Payment methods';
		$this->loadViews("businessreport/paymentMethods", $this->global, $data, 'footerbusiness', 'headerbusiness');
	}
}

