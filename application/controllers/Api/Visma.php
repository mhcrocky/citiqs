<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class Visma extends CI_Controller
{
	private $setting =	array();

	private $user_ID = '';
	function __construct()
	{
		parent::__construct();
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		// print_r($_SESSION);
		$this->user_ID =  $this->session->userdata('userId');
		// echo $this->user_ID;
		// exit;
		$this->load->helper('utility_helper');
		$this->load->helper('validate_data_helper');
		$this->load->helper('sanitize_helper');
		$this->load->helper('email_helper');
		$this->load->helper('curl_helper');

		$this->load->config('custom');
		$this->load->model('visma_model');
		$this->load->helper('visma_helper');
		$this->data = array();
		$this->load->library('form_validation');
		$this->setting = $this->visma_model->get_data($this->user_ID);

		$this->load->model('shopprinters_model');
		$this->load->model('shoporder_model2', "shoporder_model");
		$this->load->model('shoporderex_model');
		$this->load->model('shopvendor_model');


		$this->load->library('language', array('controller' => $this->router->class));
	}


	public function index()
	{

		// $this->session->sess_destroy();
		if ($this->input->get('code')) {
			// echo $API_token_endpoint;
			$api_endpoint = get_api_endpoint('api_token_endpoint', VISMA_SANDBOX_DEBUG_MODE);

			$token = getAccessToken($api_endpoint, array(
				'grant_type' => 'authorization_code',
				'redirect_uri' => VISMA_redirect,
				'code' => $this->input->get('code')
			));

			// print_r($token);
			// exit;

			if (isset($token->access_token)) {
				$_SESSION['access_token'] = $token->access_token;
				$_SESSION['refresh_token'] = $token->refresh_token;
				$setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

				if (!empty($setting)) {
					$this->visma_model->update_access_data(['visma_access_token' => $_SESSION['access_token'], 'visma_refresh_token' => $_SESSION['refresh_token'], 'user_ID' => $this->user_ID]);
				} else {
					$this->visma_model->insert_access_data(['visma_access_token' => $_SESSION['access_token'], 'visma_refresh_token' => $_SESSION['refresh_token'], 'user_ID' => $this->user_ID,'visma_option'=>1]);
				}
				header('Location: ' . base_url() . 'visma/config');
			} else {
				header('Location: ' . base_url() . 'visma/login');
				exit;
			}
		} else {
			header('Location: ' . base_url() . 'visma/login');
		}
	}

	public function login()
	{

		$api_endpoint = get_api_endpoint('api_authorize_endpoint', VISMA_SANDBOX_DEBUG_MODE);

		$_SESSION['state'] = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);
		unset($_SESSION['access_token']);

		$params = array(
			'client_id' => VISMA_client_id,
			'response_type' => 'code',
			'redirect_uri' => VISMA_redirect,
			'scope' => VISMA_scope,
			'state' => $_SESSION['state'],
			'prompt' => 'login'
		);

		header('Location: ' . $api_endpoint . '?' . http_build_query($params));
		die();
	}


	/*******Some Private function will here*******/
	private function tokenupdate($api_endpoint)
	{
		$token = getAccessToken($api_endpoint, array(
			'grant_type' => 'refresh_code',
			'refresh_code' => $this->setting->visma_refresh_token
		));
		if (isset($token->refresh_token)) {
			$this->visma_model->update_access_data(['visma_access_token' => $token->access_token, 'visma_refresh_token' => $token->refresh_token, 'user_ID' => $this->user_ID]);
		}
	}

	public function new_account($customer)
	{

		$data['setting'] = $this->visma_model->get_data($this->user_ID);


		$data['customer'] = $this->visma_model->get_customer($customer);

		$refresh_token =  $this->setting->visma_refresh_token;
		$access_token = $this->setting->visma_access_token;

		$terms_api_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/termsofpayments');
		$terms = apiRequestGet($terms_api_endpoint, $access_token, $refresh_token, $this->user_ID);

		if ($terms['success']) {
			foreach ($terms['result']->Data as $term) {
				if ($term->TermsOfPaymentTypeId == 2 && $term->TermsOfPaymentTypeText == 'Cash') {

					$terms_id = $term->Id;
				}
			}
		}

		if (isset($terms_id)) {
			$access = 1;
			$customer_api_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/customers');

			$cp = $data['customer']->first_name . ' ' . $data['customer']->second_name;
			if ($data['customer']->business_name != '') {
				$c_name = $data['customer']->business_name;
			} else {
				$c_name = $cp;
			}
			if (trim($c_name) == '') {
				$c_name = $data['customer']->username;
			}

			$payload = '
				{
					"CustomerNumber": "' . 'TIQS' . $data['customer']->id . '",
					"Name": "' . htmlspecialchars_decode($c_name) . '",
					"IsPrivatePerson": 1,
					"EmailAddress": "' . trim($data['customer']->email_general) . '",
					"InvoiceAddress1" : "' . htmlspecialchars_decode($data['customer']->address) . '",
					"InvoiceCity" : "' . htmlspecialchars_decode($data['customer']->city) . '",
					"InvoicePostalCode" : "' . $data['customer']->zipcode . '",
					"InvoiceCountryCode" : "' . $data['customer']->country . '",
					"TermsOfPaymentId":"' . $terms_id . '",
					"IsActive": true
				}
			';

			$add = apiRequest($customer_api_endpoint, $access_token, $refresh_token, $this->user_ID, $payload);

			if (isset($add['result']->Id)) {
				$this->visma_model->update_customer(['user_ID' => $this->user_ID, 'external_ID' => $add['result']->Id]);
			}
			return $add['result']->Id;
		}
	}

	function create_debit_account($category, $number, $user_ID, $token)
	{
		$this->setting = $this->visma_model->get_data($user_ID);
		$create_account = '
		{
			"Name": "' . $category . '",
			"Number": "' . $number . '",
			"Type" : 29,
			"FiscalYearId": "' . $this->setting->visma_year . '",
			"ModifiedUtc": "' . date('Y-m-d') . '",
			"IsActive": true,
			"IsProjectAllowed": true,
			"IsCostCenterAllowed": true,
			"IsBlockedForManualBooking": false
		}';
		$create_account_api_account = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/accounts?useDefaultAccountType=false');
		$add = apiRequest($create_account_api_account, $token->access_token, $token->refresh_token, $user_ID, $create_account);
		if (isset($add['success']) && $add['success'] == 1) {
			return $add['result'];
		} else {
			return $add['message'] = $add;
		}
	}
	function searchForId($id, $array)
	{

		foreach ($array as $key => $val) {
			if ($val['external_id'] == $id) {
				return $id;
			}
		}
		return false;
	}
	function searchForCategory($cat, $array)
	{

		foreach ($array as $key => $val) {
			if ($val['name'] === $cat) {
				return $val;
			}
		}
	}

	function get_external_id($id, $array)
	{
		// if external id exist already then increment by one and search again for new value.
		if ($this->searchForId($id, $array)) {
			$id++;
			$this->get_external_id($id, $array);
		}
		return end($array);
	}


	public function export_single_invoice($order_ID)
	{
		$setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

		if (empty($setting)) {
			echo json_encode(['status' => '402', 'login' => base_url('/visma')]);
			// echo 'here';
			exit;
		}
		// // exit;
		$this->load->library('encryption');
		$order = $this->visma_model->fetchOrdersForPrintcopy($order_ID);
		$order_items = $this->visma_model->get_order_products($order_ID);
		$order = $order[0];

		// echo '<pre>';
		// print_r($order_items);
		// print_r($order);
		// // exit;

		$data['setting'] = $this->setting;
		$refresh_token =  $this->setting->visma_refresh_token;
		$access_token = $this->setting->visma_access_token;

		$token  = update_token($refresh_token, $this->user_ID);
		if ($token) {
			$refresh_token =  $token->refresh_token;
			$access_token = $token->access_token;
		}

		$vat_data = [];
		foreach ($order_items as $key => $val) {
			// echo $key;
			foreach ($val as $key => $value) {
				if ($key == 'productVat') {
					$vat_type = $value;
				}
				if ($key == 'VAT') {
					$vat_data[$vat_type][] = $value;
				}
			}
		}
		$vat_data[number_format($order->serviceFeeTax,2)][] = $order->VATSERVICE;
		// print_r($vat_data);
		// exit;
		$data['orders'] = $order_items;

		$payload = '';

		$debit_account = $this->visma_model->get_visma_debitor($this->user_ID, $order->paymentType);
		$service_account = $this->visma_model->get_visma_service($this->user_ID, $order->serviceId);
		// print_r($service_account);
		// exit;
		if ($service_account == false) {
			echo json_encode(['status' => 401, 'response' => $order->paymentType . ' service fee is not linked with visma service fee ledger please update the visma setting','ledger'=>$order->serviceFee]);
			return;
		} else {
			$service_account = $service_account->external_id;
		}

		if ($debit_account == false) {
			// if payment type is empty then use the 1100 banking account as default booking account
			if(empty($order->paymentType)){
				$debit_account = 1100;
			// if payment type is exist in oder line but is not linked with any visma account in tiqs system.
			}else{
				echo json_encode(['status' => 401, 'response' => $order->paymentType . ' payment type is not linked with visma booking ledger please update the visma setting','ledger'=>$order->paymentType]);
				return;
			}
		} else {
			$debit_account = $debit_account->external_id;
		}
		$total_amount = round($order->amount + $order->serviceFee,2);
		$EXSERVICEVAT = round($order->serviceFee - $order->VATSERVICE,2);
		// echo $total_amount;
		// exit;
		$payload = '{
			"VoucherDate": "' . date('Y-m-d', strtotime($order->orderCreated)) . '",
			"VoucherText": "ORDER-' . $order->orderId . ' / ' . $order->paymentType . '",
			"useDefaultNumberSeries" : "false",
			"NumberSeries": ' . $order->orderId . ',
			"VoucherType" : 2,
			"Rows": [';
		$payload .= '
				{
					"AccountNumber": "' . $debit_account . '",
					"DebitAmount": ' . $total_amount . ',
					"CreditAmount": 0
				},';
		$payload .= '
				{
					"AccountNumber": "' . $service_account . '",
					"DebitAmount": 0,
					"CreditAmount": ' . $EXSERVICEVAT . '
				},';
		foreach ($order_items as $order_item) {
			$sales_ledger = $this->visma_model->get_visma_creditor($this->user_ID, $order_item['cat_id']);
			if ($sales_ledger == false) {
				echo json_encode(['status' => 401, 'response' => $order_item["category"] . ' Category is not linked with visma VAT ledger please update the visma setting','ledger'=>$order_item["category"]]);
				return;
			} else {
				$number = $sales_ledger->external_id;
				$payload .= '
						{
							"AccountNumber": "' . $number . '",
							"CreditAmount": ' . ROUND($order_item['EXVAT'], 2) . ',
							"DebitAmount": 0,
							"TransactionText": "' . $order_item['productName'] . '",
							"Quantity": "' . $order_item['quantity'] . '",
						},';
			}
		}
		foreach ($vat_data as $key => $val) {
			$vat = array_sum($val);
			$vat_account   = $this->visma_model->get_visma_vat($this->user_ID, $key);
			if ($vat_account == false) {
				echo json_encode(['status' => 401, 'response' => "VAT ($key%)" . " VAT Ledger not linked please update the visma setting",'ledger'=>"VAT ($key%)"]);
				return;
			} else {
				$vat_number = $vat_account->vat_external_code;
			}
			$payload .= '
					{
						"AccountNumber": "' . $vat_number . '",
						"CreditAmount": ' . ROUND($vat, 2) . ',
						"DebitAmount": 0
					},';
		}
		$payload .= ']';
		$payload .= '}';
		// echo $payload;
		// exit;
		$voucher_api_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/vouchers');
		$add = apiRequest($voucher_api_endpoint, $access_token, $refresh_token, $this->user_ID, $payload);
		if (isset($add['success']) && $add['success'] == true) {
			$this->visma_model->update_order_export_status($order->orderId, $add['result']->Id);
			echo json_encode(['status' => 200, 'response' => 'Order Exported Successfully']);
		} else {
			echo json_encode(['status' => 401, 'response' => $add['message'], 'payload' => $payload]);
		}
	}
}
