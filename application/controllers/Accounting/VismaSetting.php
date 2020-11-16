<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';
// use DB;
class VismaSetting extends BaseControllerWeb {

    /**
     * This is default constructor of the class
     */
    private $settings =	array();
    private $user_ID = '';

    public function __construct() {
        parent::__construct();

        $this->user_ID =  $this->session->userdata('userId');
        $this->load->helper('url');
        $this->load->helper('country_helper');
        $this->load->helper('form');
        $this->load->helper('google_helper');
        $this->load->library('form_validation');
        $this->load->model('visma_model');
		$this->load->model('vat_rates_model');
        $this->setting = $this->visma_model->get_data($this->user_ID);
        $this->load->helper('visma_helper');
		$this->load->library('language', array('controller' => $this->router->class));

        $this->load->library('pagination');
        $this->load->config('custom');
        $this->isLoggedIn();

    }

    /**
     * This function used to load the first screen of the user
     */
    public function index() {

        $setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

        if(empty($setting)){
            redirect('/visma');
        }


        $token  = update_token($setting->visma_refresh_token, $this->user_ID);
        if($token){
			$refresh_token =  $token->refresh_token;
			$access_token = $token->access_token;
		}else{
            redirect('/visma');
        }
		$year_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/fiscalyears');
		$years = apiRequestGet($year_endpoint, $access_token, $refresh_token,$this->user_ID);
        // print_r($years);
        // exit;
		$year_id = $this->setting->visma_year;
		$year_data = [];
		if(isset($years['success']) && $years['success'] == 1){
			foreach ($years['result']->Data as $year) {
				$year_data[] = $year->Id.'|'.date('d-M-Y', strtotime($year->StartDate)).' - '.date('d-M-Y', strtotime($year->EndDate));
				$last_year = $year->Id;
			}
        }

		if(empty($this->setting->visma_year)){
			$year_id = $last_year;
        }

		$content_data['years'] = $year_data;

        // $bank_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/bankaccounts');
        // $bank_accounts = apiRequestGet($bank_endpoint, $access_token, $refresh_token,$this->user_ID);

		// echo $account_endpoint;
		// $vat_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/vatcodes');
		// echo $vat_endpoint;
		// $vats = apiRequestGet($vat_endpoint, $access_token, $refresh_token,$this->user_ID);
		// $incomes_data = [];
        // $vats_data = [];
        // echo '<pre>';
        // // $content_data['vat_rates'] = $this->vat_rates_model->get_vat_rates($this->user_ID);



		// $account_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/accounts');
		// $accounts = apiRequestGet($account_endpoint, $access_token, $refresh_token,$this->user_ID);

        // if(isset($accounts['success']) && $accounts['success'] == 1){
		// 	foreach ($accounts['result']->Data as $bank) {
		// 		if ($bank->Type == 13) {
		// 			$banks_data[] = $bank->Number.'|['.trim($bank->Number).'] '.$bank->Name;
		// 		}
        //     }

        // }

        // $content_data['debtors'] = $debtors;
		// $content_data['incomes'] = $incomes_data;
		// if(isset($vats['success']) && $vats['success'] == 1){
		// 	foreach ($vats['result']->Data as $vat) {
		// 		$vats_data[] = $vat->RelatedAccounts->AccountNumber1.'|['.trim($vat->RelatedAccounts->AccountNumber1).'] '.$vat->Description;
		// 	}
        // }
        // $content_data['banks_data'] = $banks_data;

		$content_data['setting'] = $this->setting;
        $this->global['pageTitle'] = 'TIQS : HOME';
		$this->loadViews("visma/visma_config", $this->global, $content_data, NULL,'headerwebloginhotelProfile');
    }

    function app_setting(){
        $data = $this->input->post();
        // $refresh_token =  $this->setting->visma_refresh_token;
		// $access_token = $this->setting->visma_access_token;
        $token  = update_token($this->setting->visma_refresh_token, $this->user_ID);
        if($token){
			$refresh_token =  $token->refresh_token;
			$access_token = $token->access_token;
		}else{
            redirect('/visma');
        }

        // $create_account = '
        // {
        //     "Name": "Bank Account '.$this->input->post('visma_booking_account').'",
        //     "Number": "'.$this->input->post('visma_booking_account').'",
        //     "Type" : 13,
        //     "FiscalYearId": "'.$this->input->post('visma_year').'",
        //     "ModifiedUtc": "'.date('Y-m-d').'",
        //     "IsActive": true,
        //     "IsProjectAllowed": true,
        //     "IsCostCenterAllowed": true,
        //     "IsBlockedForManualBooking": false
        // }';
        // $put_account_apiendpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/accounts/'.$this->input->post('visma_year').'/'.$this->input->post('visma_booking_account'));

        // $add = apiPut($put_account_apiendpoint,$access_token,$refresh_token,$this->user_ID,$create_account);
        // if(isset($add['success']) && $add['success'] == 1){
            $data=['visma_year'=>$this->input->post('visma_year')];
            $this->visma_model->update_visma_settings($this->user_ID,$data);
            $this->session->set_flashdata('success', 'Setting Updated successfully');
        // }else{
            // $this->session->set_flashdata('error', $add['message']);
        // }
        redirect('/visma/config');
    }
}

?>
