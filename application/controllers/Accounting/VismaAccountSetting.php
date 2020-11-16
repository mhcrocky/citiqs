<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';
// use DB;
class VismaAccountSetting extends BaseControllerWeb {

    /**
     * This is default constructor of the class
     */
    private $setting =	array();
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
		$this->load->model('debitor_model');
		$this->load->model('services_model');
		$this->load->model('creditor_model');
        $this->load->helper('visma_helper');
		$this->load->library('language', array('controller' => $this->router->class));
        $this->user_ID =  $this->session->userdata('userId');
        $this->setting = $this->visma_model->get_data($this->user_ID);
        $this->load->library('pagination');
        $this->load->config('custom');
        $this->isLoggedIn();

    }

    /**
     * This function used to load the first screen of the user
     */
    public function vat_rates() {
        $setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

        if(empty($setting)){
            redirect('/visma');
        }

        $token  = update_token($this->setting->visma_refresh_token, $this->user_ID);
        if($token){
			$refresh_token =  $token->refresh_token;
			$access_token = $token->access_token;
		}else{
            redirect('/visma');
        }
        $content_data['vat_rates'] = $this->vat_rates_model->get_vat_rates($this->user_ID,'visma');
        $vat_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/accounts/'.$this->setting->visma_year.'?$pagesize=1000&$orderby=Number');
        // $vat_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/vatcodes');

        $vats = apiRequestGet($vat_endpoint, $access_token, $refresh_token,$this->user_ID);
        // echo '<pre>';
        // print_r($vats);
        // exit;
        $vats_data = [];
        if(isset($vats['success']) && $vats['success'] == 1){
            foreach ($vats['result']->Data as $vat) {

                if($vat->Type==27){
					$vats_data[] = $vat->Number.'|['.trim($vat->Number).'] '.$vat->Name;
				}
            }
        }
        // if(isset($vats['success']) && $vats['success'] == 1){
        //     foreach ($vats['result']->Data as $vat) {
        //         $vats_data[] = $vat->RelatedAccounts->AccountNumber1.'|['.trim($vat->RelatedAccounts->AccountNumber1).'] '.$vat->Description;
        //     }
        // }

        $content_data['vats'] = $vats_data;
		$content_data['setting'] = $this->setting;

		$this->global['pageTitle'] = 'TIQS : Vat Rates';
		$this->loadViews("setting/vat_rates", $this->global, $content_data, NULL,'headerwebloginhotelProfile');
    }

    public function vat_rates_edit($id) {
        // $this->output->delete_cac
        $setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

        if(empty($setting)){
            redirect('/visma');
        }

        $token  = update_token($this->setting->visma_refresh_token, $this->user_ID);
        if($token){
			$refresh_token =  $token->refresh_token;
			$access_token = $token->access_token;
		}else{
            redirect('/visma');
        }
        // print_r($token);

        $content_data['vat_rates'] = $this->vat_rates_model->get_vat_rates($this->user_ID,'visma');
        $content_data['rate'] = $this->vat_rates_model->get_data($this->uri->segment(4));

        $vat_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/accounts/'.$this->setting->visma_year.'?$pagesize=1000&$orderby=Number');

        $vats = apiRequestGet($vat_endpoint, $access_token, $refresh_token,$this->user_ID);
        // exit;
        // echo '<pre>';
        $vats_data = [];

        if(isset($vats['success']) && $vats['success'] == 1){
            foreach ($vats['result']->Data as $vat) {

                if($vat->Type==27){
					$vats_data[] = $vat->Number.'|['.trim($vat->Number).'] '.$vat->Name;
				}
            }
        }

        $content_data['vats'] = $vats_data;
		$content_data['setting'] = $this->setting;

		$this->global['pageTitle'] = 'TIQS : Vat Rates';
		$this->loadViews("setting/vat_rates_edit", $this->global, $content_data, NULL,'headerwebloginhotelProfile');
    }

    public function save_visma_vat() {
        // print_r($this->input->post());
        // exit;
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('rate_desc', 'VAT Description', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('vat_external_code', 'VAT Code', 'trim');
        $this->form_validation->set_rules('rate_perc', 'VAT Percentage', 'trim');


        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata($_POST);
            redirect('/setting/visma/vat');
            exit();
        }

        $data = array(
            'rate_desc' => $this->input->post('rate_desc'),
            'rate_code' => $this->input->post('vat_external_code'),
            'rate_perc' => $this->input->post('rate_perc'),
            'vat_external_code' => $this->input->post('vat_external_code'),
            'user_ID' => $this->user_ID,
            'accounting' => 'visma',
        );

        $save_vat_rate = $this->vat_rates_model->save($data);



        if ($save_vat_rate) {
            $this->session->set_flashdata('success', 'Vat rate group saved');
        } else {
            $this->session->set_flashdata('error', 'Error in adding Vat rate group');
        }

        redirect('/setting/visma/vat');
    }

    public function update_visma_vat() {
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('rate_desc','VAT description', 'trim|required|max_length[100]');
        // $this->form_validation->set_rules('vat_external_code', 'trim');
        $this->form_validation->set_rules('rate_perc','VAT Percentage', 'trim');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata($_POST);
            redirect('/setting/visma/vat/'.$this->input->post('id'));
            exit();
        }

        $data = array(
            'rate_desc' => $this->input->post('rate_desc'),
            'user_ID' => $this->user_ID,
            'rate_code' => $this->input->post('vat_external_code'),
            'rate_perc' => $this->input->post('rate_perc'),
            'vat_external_code' => $this->input->post('vat_external_code'),
            'id' => $this->input->post('id'),
            'accounting' => 'visma',
        );
        if ($this->vat_rates_model->update($data)) {
            $this->session->set_flashdata('success', 'Vat rate group updated');
        } else {
            $this->session->set_flashdata('error', 'Vat rate group update issue');
        }

        redirect('/setting/visma/vat/'.$this->input->post('id'));
    }

    function delete_visma_vat($id){

        if ($this->vat_rates_model->delete_row($id,$this->user_ID)) {
            $this->session->set_flashdata('success', 'Vat rate group deleted');
        } else {
            $this->session->set_flashdata('error', 'Error in deleting vat rate group');
        }

        redirect('/setting/visma/vat/');

    }

    function app_setting(){
        $data = $this->input->post();
        $this->visma_model->update_visma_setting($this->user_ID,$data);
    }

    public function debitors() {

        $setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

        if(empty($setting)){
            redirect('/visma');
        }
        $payment_type = array(
            'prePaid'=>'PrePaid',
            'postPaid'=>'PostPaid',
            'idealPayment'=>'Ideal payment',
            'creditCardPayment'=>'Credit card payment',
            'bancontactPayment'=>'Bancontact payment',
            'giroPayment'=>'Giro payment',
            'payconiqPayment'=>'Payconiq payment',
            'pinMachinePayment'=>'Pin machine',
            'voucherPayment'=>'Voucher',
        );
        $content_data['debitors'] = $this->debitor_model->get_debitor($this->user_ID,'visma');
        $token  = update_token($setting->visma_refresh_token, $this->user_ID);
        if($token){
			$refresh_token =  $token->refresh_token;
			$access_token = $token->access_token;
		}else{
            redirect('/visma');
        }
        $accouts_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/accounts/'.$setting->visma_year.'?$pagesize=1000&$orderby=Number');
        // echo $accouts_endpoint;
		$accounts = apiRequestGet($accouts_endpoint, $access_token, $refresh_token,$this->user_ID);
        $accounts_data = [];

        if(isset($accounts['success']) && $accounts['success'] == 1){
            foreach ($accounts['result']->Data as $debt) {
                if($debt->Type==7 || $debt->Type==9 || $debt->Type==10 || $debt->Type==13 || $debt->Type==26 || $debt->Type==29  ){
                    $accounts_data[] = $debt->Number.'|['.trim($debt->Number).'] '.$debt->Name;
                }
            }
        }

        $content_data['payment_types'] = $payment_type;
        $content_data['external_debitors'] = $accounts_data;
		$content_data['setting'] = $this->setting;
		$this->global['pageTitle'] = 'TIQS : Debtors';
		$this->loadViews("setting/debitors", $this->global, $content_data, NULL,'headerwebloginhotelProfile');
    }

    public function debitors_edit($id) {

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
        $content_data['debitor_data'] = $this->debitor_model->get_data($this->uri->segment(4));
        // exit;
        $content_data['debitors'] = $this->debitor_model->get_debitor($this->user_ID,'visma');
        $content_data['categories'] = $this->debitor_model->get_categories($this->user_ID);

        $accouts_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/accounts/'.$setting->visma_year.'?$pagesize=1000&$orderby=Number');
        // print_r($accouts_endpoint);
        // print_r($access_token);
        // exit;

		$accounts = apiRequestGet($accouts_endpoint, $access_token, $refresh_token,$this->user_ID);
        // print_r($accounts);
        // exit;
        $accounts_data = [];

        if(isset($accounts['success']) && $accounts['success'] == 1){
            foreach ($accounts['result']->Data as $debt) {
                if($debt->Type==7 || $debt->Type==9 || $debt->Type==10 || $debt->Type==13 || $debt->Type==26 || $debt->Type==29  ){
                    $accounts_data[] = $debt->Number.'|['.trim($debt->Number).'] '.$debt->Name;
                }
            }
        }
        $payment_type = array(
            'prePaid'=>'PrePaid',
            'postPaid'=>'PostPaid',
            'idealPayment'=>'Ideal payment',
            'creditCardPayment'=>'Credit card payment',
            'bancontactPayment'=>'Bancontact payment',
            'giroPayment'=>'Giro payment',
            'payconiqPayment'=>'Payconiq payment',
            'pinMachinePayment'=>'Pin machine',
            'voucherPayment'=>'Voucher',
        );

        $content_data['payment_types'] = $payment_type;
        $content_data['external_debitors'] = $accounts_data;
		$content_data['setting'] = $setting;
		$this->global['pageTitle'] = 'TIQS : Debtors';
		$this->loadViews("setting/debitors_edit", $this->global, $content_data, NULL,'headerwebloginhotelProfile');
    }

    public function save_debitor() {
        // print_r($this->input->post());
        // exit;
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('external_id', 'External Id', 'trim|max_length[150]');
        $this->form_validation->set_rules('payment_type', 'Payment Type', 'trim|max_length[100]');


        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata($_POST);
            redirect('/setting/visma/debitors');
            exit();
        }

        $data = array(
            'accounting' => 'visma',
            'external_id' => $this->input->post('external_id'),
            'external_code' => $this->input->post('external_id'),
            'payment_type' => $this->input->post('payment_type'),
            'user_ID' => $this->user_ID,
        );

        $save_debitor = $this->debitor_model->save($data);



        if ($save_debitor) {
            $this->session->set_flashdata('success', 'Booking account saved');
        } else {
            $this->session->set_flashdata('error', 'Error in adding Booking account');
        }

        redirect('/setting/visma/debitors');
    }

    public function update_debitor() {
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('external_id', 'External Id', 'trim|max_length[150]');
        $this->form_validation->set_rules('payment_type', 'Payment Type', 'trim|max_length[100]');


        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata($_POST);
            redirect('/setting/visma/debitors/'.$this->input->post('id'));

            exit();
        }

        $data = array(
            'accounting' => 'visma',
            'external_id' => $this->input->post('external_id'),
            'external_code' => $this->input->post('external_id'),
            'payment_type' => $this->input->post('payment_type'),
            'user_ID' => $this->user_ID,
            'id' =>$this->input->post('id')
        );
        // print_r($data);exit;
        if ($this->debitor_model->update($data)) {
            $this->session->set_flashdata('success', 'Booking account updated');
        } else {
            $this->session->set_flashdata('error', 'Booking update issue');
        }

        redirect('/setting/visma/debitors/'.$this->input->post('id'));
    }

    function delete_debitor($id){

        if ($this->debitor_model->delete_row($id,$this->user_ID)) {
            $this->session->set_flashdata('success', 'Booking deleted');
        } else {
            $this->session->set_flashdata('error', 'Error in deleting Booking');
        }

        redirect('/setting/visma/debitors');

    }

    public function creditors() {

        $this->setting = $this->visma_model->get_data($this->user_ID);
        $setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

        if(empty($setting)){
            redirect('/visma');
        }
        // echo '<pre>';
        $products = $this->visma_model->get_products($this->user_ID);
        $content_data['products'] = $products;
        // print_r($products);
        // exit;

        $token  = update_token($this->setting->visma_refresh_token, $this->user_ID);
        if($token){
			$refresh_token =  $token->refresh_token;
			$access_token = $token->access_token;
		}else{
            redirect('/visma');
        }
        $accouts_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/accounts/'.$this->setting->visma_year.'?$pagesize=1000&$orderby=Number');
        // echo $accouts_endpoint;
		$accounts = apiRequestGet($accouts_endpoint, $access_token, $refresh_token,$this->user_ID);
        $accounts_data = [];
        $content_data['creditors'] = $this->creditor_model->get_creditor($this->user_ID,'visma');
        $content_data['categories'] = $this->creditor_model->get_categories($this->user_ID);

        if(isset($accounts['success']) && $accounts['success'] == 1){
            foreach ($accounts['result']->Data as $debt) {
                if($debt->Type==29){
                    $accounts_data[] = $debt->Number.'|['.trim($debt->Number).'] '.$debt->Name;
                }
            }
        }

        $content_data['external_creditors'] = $accounts_data;
		$content_data['setting'] = $this->setting;
		$this->global['pageTitle'] = 'TIQS : Creditors';
		$this->loadViews("setting/creditors", $this->global, $content_data, NULL ,'headerwebloginhotelProfile');
    }

    public function creditors_edit($id) {

        $this->setting = $this->visma_model->get_data($this->user_ID);
        $setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

        if(empty($setting)){
            redirect('/visma');
        }

        $token  = update_token($this->setting->visma_refresh_token, $this->user_ID);
        if($token){
			$refresh_token =  $token->refresh_token;
			$access_token = $token->access_token;
		}else{
            redirect('/visma');
        }
        $products = $this->visma_model->get_products($this->user_ID);
        $content_data['products'] = $products;
        $content_data['creditor_data'] = $this->creditor_model->get_data($this->uri->segment(4));
        $content_data['creditors'] = $this->creditor_model->get_creditor($this->user_ID,'visma');
        $content_data['categories'] = $this->creditor_model->get_categories($this->user_ID);

        $accouts_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/accounts/'.$this->setting->visma_year.'?$pagesize=1000&$orderby=Number');

		$accounts = apiRequestGet($accouts_endpoint, $access_token, $refresh_token,$this->user_ID);
        $accounts_data = [];
        if(isset($accounts['success']) && $accounts['success'] == 1){
            foreach ($accounts['result']->Data as $debt) {
                if($debt->Type==29){
                    $accounts_data[] = $debt->Number.'|['.trim($debt->Number).'] '.$debt->Name;
                }
            }
        }


        $content_data['external_creditors'] = $accounts_data;
		$content_data['setting'] = $this->setting;
		$this->global['pageTitle'] = 'TIQS : Creditors';
		$this->loadViews("setting/creditors_edit", $this->global, $content_data,null,'headerwebloginhotelProfile');
    }

    public function save_credit() {
        // print_r($this->input->post());
        // exit;
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('external_id', 'Visma External Id', 'trim|max_length[150]');
        $this->form_validation->set_rules('product_category_id', 'Product Type', 'trim|max_length[100]');


        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata($_POST);
            redirect('/setting/visma/creditors');
            exit();
        }
        if (!empty($this->input->post('product_id'))) {
            $product_id = $this->input->post('product_id');
        }else{
            $product_id = null;
        }


        $data = array(
            'accounting' => 'visma',
            'external_id' => $this->input->post('external_id'),
            'product_category_id' => $this->input->post('product_category_id'),
            'product_id' => $product_id,
            'user_ID' => $this->user_ID,
        );

        $save = $this->creditor_model->save($data);



        if ($save) {
            $this->session->set_flashdata('success', 'Creditor account saved');
        } else {
            $this->session->set_flashdata('error', 'Error in adding Creditor account');
        }

        redirect('/setting/visma/creditors');
    }

    public function update_credit() {
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('external_id', 'Visma External Id', 'trim|max_length[150]');
        $this->form_validation->set_rules('product_category_id', 'Product Type', 'trim|max_length[100]');


        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata($_POST);
            redirect('/setting/visma/creditors/'.$this->input->post('id'));

            exit();
        }
        if (!empty($this->input->post('product_id'))) {
            $product_id = $this->input->post('product_id');
        }else{
            $product_id = null;
        }

        $data = array(
            'accounting' => 'visma',
            'user_ID' => $this->user_ID,
            'external_id' => $this->input->post('external_id'),
            'product_category_id' => $this->input->post('product_category_id'),
            'product_id' => $product_id,
            'id' => $this->input->post('id')
        );

        if ($this->creditor_model->update($data)) {
            $this->session->set_flashdata('success', 'Creditor updated');
        } else {
            $this->session->set_flashdata('error', 'Creditor update issue');
        }

        redirect('/setting/visma/creditors/'.$this->input->post('id'));
    }

    function delete_credit($id){

        if ($this->creditor_model->delete_row($id,$this->user_ID)) {
            $this->session->set_flashdata('success', 'Creditor deleted');
        } else {
            $this->session->set_flashdata('error', 'Error in deleting Creditor');
        }

        redirect('/setting/visma/creditors');

    }

    public function service() {

        $setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

        if(empty($setting)){
            redirect('/visma');
        }

        $content_data['services'] = $this->services_model->get_services($this->user_ID,'visma');
        $content_data['services_type'] = $this->services_model->get_services_type($this->user_ID);
        $token  = update_token($setting->visma_refresh_token, $this->user_ID);
        if($token){
			$refresh_token =  $token->refresh_token;
			$access_token = $token->access_token;
		}else{
            redirect('/visma');
        }
        $accouts_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/accounts/'.$setting->visma_year.'?$pagesize=1000&$orderby=Number');
        // echo $accouts_endpoint;
		$accounts = apiRequestGet($accouts_endpoint, $access_token, $refresh_token,$this->user_ID);
        $accounts_data = [];

        if(isset($accounts['success']) && $accounts['success'] == 1){
            foreach ($accounts['result']->Data as $debt) {
                if($debt->Type==29){
                    $accounts_data[] = $debt->Number.'|['.trim($debt->Number).'] '.$debt->Name;
                }
            }
        }
        $content_data['external_services'] = $accounts_data;
        // echo '<pre>';
        // print_r($content_data);
        // exit;
		$content_data['setting'] = $this->setting;
		$this->global['pageTitle'] = 'TIQS : Service Fee';
		$this->loadViews("setting/services", $this->global, $content_data, NULL,'headerwebloginhotelProfile');
    }

    public function service_edit($id) {

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
        $content_data['service_row'] = $this->services_model->get_data($this->uri->segment(4));
        // print_r($content_data);
        // exit;
        $content_data['services'] = $this->services_model->get_services($this->user_ID,'visma');
        $content_data['services_type'] = $this->services_model->get_services_type($this->user_ID);

        $accouts_endpoint = get_api_endpoint('api_endpoint', VISMA_SANDBOX_DEBUG_MODE, 'v2/accounts/'.$setting->visma_year.'?$pagesize=1000&$orderby=Number');
        // print_r($accouts_endpoint);
        // print_r($access_token);
        // exit;

		$accounts = apiRequestGet($accouts_endpoint, $access_token, $refresh_token,$this->user_ID);
        // print_r($accounts);
        // exit;
        $accounts_data = [];

        if(isset($accounts['success']) && $accounts['success'] == 1){
            foreach ($accounts['result']->Data as $debt) {
                if($debt->Type==29){
                    $accounts_data[] = $debt->Number.'|['.trim($debt->Number).'] '.$debt->Name;
                }
            }
        }

        $content_data['external_services'] = $accounts_data;
		$content_data['setting'] = $setting;
		$this->global['pageTitle'] = 'TIQS : Services Fee';
		$this->loadViews("setting/services_edit", $this->global, $content_data, NULL,'headerwebloginhotelProfile');
    }

    public function save_service() {
        // print_r($this->input->post());
        // exit;
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('external_id', 'External Id', 'trim|max_length[150]');
        $this->form_validation->set_rules('service_id', 'Service', 'trim|max_length[100]');


        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata($_POST);
            redirect('/setting/visma/service');
            exit();
        }

        $data = array(
            'accounting' => 'visma',
            'external_id' => $this->input->post('external_id'),
            'external_code' => $this->input->post('external_id'),
            'service_id' => $this->input->post('service_id'),
            'user_ID' => $this->user_ID,
        );

        $save_debitor = $this->services_model->save($data);



        if ($save_debitor) {
            $this->session->set_flashdata('success', 'Service account saved');
        } else {
            $this->session->set_flashdata('error', 'Error in adding Service account');
        }

        redirect('/setting/visma/service');
    }

    public function update_service() {
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('external_id', 'External Id', 'trim|max_length[150]');
        $this->form_validation->set_rules('service_id', 'Service', 'trim|max_length[100]');


        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata($_POST);
            redirect('/setting/visma/service/'.$this->input->post('id'));

            exit();
        }

        $data = array(
            'accounting' => 'visma',
            'external_id' => $this->input->post('external_id'),
            'external_code' => $this->input->post('external_id'),
            'service_id' => $this->input->post('service_id'),
            'user_ID' => $this->user_ID,
            'id' =>$this->input->post('id')
        );
        // print_r($data);exit;
        if ($this->services_model->update($data)) {
            $this->session->set_flashdata('success', 'Service account updated');
        } else {
            $this->session->set_flashdata('error', 'Service update issue');
        }

        redirect('/setting/visma/service/'.$this->input->post('id'));
    }

    function delete_service($id){

        if ($this->services_model->delete_row($id,$this->user_ID)) {
            $this->session->set_flashdata('success', 'Service deleted');
        } else {
            $this->session->set_flashdata('error', 'Error in deleting Service');
        }

        redirect('/setting/visma/service');

    }

}

?>
