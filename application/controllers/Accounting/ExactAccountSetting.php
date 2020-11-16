<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';
require FCPATH . 'vendor\autoload.php';
// use DB;
class ExactAccountSetting extends BaseControllerWeb {

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
		$this->load->model('exact_model');
		$this->load->model('vat_rates_model');
		$this->load->model('debitor_model');
		$this->load->model('creditor_model');
        $this->load->helper('exact_online_helper');
		$this->load->library('language', array('controller' => $this->router->class));
        $this->setting = $this->exact_model->get_data($this->user_ID);
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
            redirect('/exact');
        }
        $clientDivision = $setting->exact_division;

        $clientDivision = $clientDivision;
        $connection = connect(EXACT_RETURN, EXACT_CLIENT, EXACT_SECRET);
        $connection->setDivision($clientDivision);

        $content_data['vat_rates'] = $this->vat_rates_model->get_vat_rates($this->user_ID,'exact');

        $vats_data = [];
        $Vat = new \Picqer\Financials\Exact\VatCode($connection);
        $result = $Vat->filter('', '', '', array('$orderby' => 'Code'));

        foreach ($result as $vat) {
            $vats[] = $vat->Code.'|['.trim($vat->Code).'] '.$vat->Description.'|'.trim($vat->Code);
        }

        $Gla = new \Picqer\Financials\Exact\GLAccount($connection);
        $result = $Gla->filter('', '', '', array('$orderby' => 'Code'));

        foreach ($result as $gla) {
            // echo $gla->Type;
            // echo $gla->TypeDescription;
            // echo '<br>';
            // 'TypeDescription',
            if($gla->Type==24){
                $vats[] = $gla->ID.'|['.trim($gla->Code).'] '.$gla->Description.'|'.trim($gla->Code);
            }
        }
        $content_data['vats'] = $vats;
        // echo '<pre>';
        // print_r($content_data);
        // exit;
		$content_data['setting'] = $this->setting;

		$this->global['pageTitle'] = 'TIQS : Vat Rates';
		$this->loadViews("setting/vat_rates", $this->global, $content_data, NULL,'headerwebloginhotelProfile');
    }

    public function vat_rates_edit($id) {
        $setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

        if(empty($setting)){
            redirect('/exact');
        }
        $clientDivision = $setting->exact_division;

        $clientDivision = $clientDivision;
        $connection = connect(EXACT_RETURN, EXACT_CLIENT, EXACT_SECRET);
        $connection->setDivision($clientDivision);

        $content_data['vat_rates'] = $this->vat_rates_model->get_vat_rates($this->user_ID,'exact');
        $content_data['rate'] = $this->vat_rates_model->get_data($this->uri->segment(4));

        $Vat = new \Picqer\Financials\Exact\VatCode($connection);
        $result = $Vat->filter('', '', '', array('$orderby' => 'Code'));

        foreach ($result as $vat) {
            $vats[] = $vat->Code.'|['.trim($vat->Code).'] '.$vat->Description.'|'.trim($vat->Code);
        }

        $Gla = new \Picqer\Financials\Exact\GLAccount($connection);
        $result = $Gla->filter('', '', '', array('$orderby' => 'Code'));

        foreach ($result as $gla) {
            if($gla->Type==24){
                $vats[] = $gla->ID.'|['.trim($gla->Code).'] '.$gla->Description.'|'.trim($gla->Code);
            }
        }
        $content_data['vats'] = $vats;

		$content_data['setting'] = $this->setting;

		$this->global['pageTitle'] = 'TIQS : Vat Rates';
		$this->loadViews("setting/vat_rates_edit", $this->global, $content_data, NULL,'headerwebloginhotelProfile');
    }

    public function save_vat() {
        // print_r($this->input->post());
        // exit;
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('rate_desc', $this->lang->line('rates_desc'), 'trim|required|max_length[100]');
        $this->form_validation->set_rules('rate_code', $this->lang->line('rates_code'), 'trim|max_length[5]');
        $this->form_validation->set_rules('rate_perc', $this->lang->line('rates_perc'), 'trim|max_length[5]');


        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata($_POST);
            redirect('/setting/exact/vat');
            exit();
        }
        $parts = explode("_", $this->input->post('vat_external_code'));
        $vat_id = $parts[0];
        $vat_code = $parts[1];
        $data = array(
            'rate_desc' => $this->input->post('rate_desc'),
            'rate_code' => $vat_code,
            'rate_perc' => $this->input->post('rate_perc'),
            'vat_external_code' => $vat_id,
            'user_ID' => $this->user_ID,
            'accounting' => 'exact',
        );

        $save_vat_rate = $this->vat_rates_model->save($data);



        if ($save_vat_rate) {
            $this->session->set_flashdata('success', 'Vat rate group saved');
        } else {
            $this->session->set_flashdata('error', 'Error in adding Vat rate group');
        }

        redirect('/setting/exact/vat');
    }

    public function update_vat() {
        // print_r($this->input->post());
        // exit;
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('rate_desc', $this->lang->line('rates_desc'), 'trim|required|max_length[100]');
        $this->form_validation->set_rules('rate_code', $this->lang->line('rates_code'), 'trim|max_length[5]');
        $this->form_validation->set_rules('rate_perc', $this->lang->line('rates_perc'), 'trim|max_length[5]');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata($_POST);
            redirect('/setting/exact/vat/'.$this->input->post('id'));
            exit();
        }
        $parts = explode("_", $this->input->post('vat_external_code'));
        $vat_id = $parts[0];
        $vat_code = $parts[1];

        $data = array(
            'rate_desc' => $this->input->post('rate_desc'),
            'user_ID' => $this->user_ID,
            'rate_code' => $vat_code,
            'rate_perc' => $this->input->post('rate_perc'),
            'vat_external_code' => $vat_id,
            'id' => $this->input->post('id'),
            'accounting' => 'exact',
        );
        if ($this->vat_rates_model->update($data)) {
            $this->session->set_flashdata('success', 'Vat rate group updated');
        } else {
            $this->session->set_flashdata('error', 'Vat rate group update issue');
        }

        redirect('/setting/exact/vat/'.$this->input->post('id'));
    }

    function delete_vat($id){

        if ($this->vat_rates_model->delete_row($id,$this->user_ID)) {
            $this->session->set_flashdata('success', 'Vat rate group deleted');
        } else {
            $this->session->set_flashdata('error', 'Error in deleting vat rate group');
        }

        redirect('/setting/exact/vat/');

    }

    function app_setting(){
        $data = $this->input->post();
        $this->visma_model->update_exact_settings($this->user_ID,$data);
    }

    public function debitors() {

        $setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

        if(empty($setting)){
            redirect('/exact');
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
        $content_data['debitors'] = $this->debitor_model->get_debitor($this->user_ID,'exact');
        $clientDivision = $setting->exact_division;

        $clientDivision = $clientDivision;
        $connection = connect(EXACT_RETURN, EXACT_CLIENT, EXACT_SECRET);
        $connection->setDivision($clientDivision);

        $Gla = new \Picqer\Financials\Exact\GLAccount($connection);
        $result = $Gla->filter('', '', '', array('$orderby' => 'Code'));

        // echo '<pre>';
        foreach ($result as $gla) {
            if($gla->Type == 10 || $gla->Type == 12 || $gla->Type == 20){
                // $glas[] = $gla->ID.'|['.trim($gla->Code).'] '.$gla->Description.'|'.trim($gla->Code).'|'.trim($gla->TypeDescription).'|'.trim($gla->Type);
                $glas[] = $gla->ID.'|['.trim($gla->Code).'] '.$gla->Description.'|'.trim($gla->Code);
            }
        }
        // print_r($glas);
        $content_data['external_debitors'] = $glas;
        // exit;
        $content_data['payment_types'] = $payment_type;
		$content_data['setting'] = $this->setting;
		$this->global['pageTitle'] = 'TIQS : Debtors';
		$this->loadViews("setting/debitors", $this->global, $content_data, NULL,'headerwebloginhotelProfile');
    }

    public function debitors_edit($id) {

        $setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

        if(empty($setting)){
            redirect('/exact');
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

        $content_data['debitors'] = $this->debitor_model->get_debitor($this->user_ID,'exact');
        $clientDivision = $setting->exact_division;

        $clientDivision = $clientDivision;
        $connection = connect(EXACT_RETURN, EXACT_CLIENT, EXACT_SECRET);
        $connection->setDivision($clientDivision);

        $Gla = new \Picqer\Financials\Exact\GLAccount($connection);
        $result = $Gla->filter('', '', '', array('$orderby' => 'Code'));

        // echo '<pre>';
        foreach ($result as $gla) {
            if($gla->Type == 10 || $gla->Type == 12 || $gla->Type == 20){
                // $glas[] = $gla->ID.'|['.trim($gla->Code).'] '.$gla->Description.'|'.trim($gla->Code).'|'.trim($gla->TypeDescription).'|'.trim($gla->Type);
                $glas[] = $gla->ID.'|['.trim($gla->Code).'] '.$gla->Description.'|'.trim($gla->Code);
            }
        }
        // print_r($glas);
        $content_data['external_debitors'] = $glas;
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
            redirect('/setting/exact/debitors');
            exit();
        }
        $parts = explode("_", $this->input->post('external_id'));
        $external_id = $parts[0];
        $external_code = $parts[1];

        $data = array(
            'accounting' => 'exact',
            'external_code' => $external_code,
            'external_id' => $external_id,
            'payment_type' => $this->input->post('payment_type'),
            'user_ID' => $this->user_ID,
        );

        $save_debitor = $this->debitor_model->save($data);



        if ($save_debitor) {
            $this->session->set_flashdata('success', 'Booking account saved');
        } else {
            $this->session->set_flashdata('error', 'Error in adding Booking account');
        }

        redirect('/setting/exact/debitors');
    }

    public function update_debitor() {
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('external_id', 'External Id', 'trim|max_length[150]');
        $this->form_validation->set_rules('payment_type', 'Payment Type', 'trim|max_length[100]');


        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata($_POST);
            redirect('/setting/exact/debitors/'.$this->input->post('id'));

            exit();
        }
        $parts = explode("_", $this->input->post('external_id'));
        $external_id = $parts[0];
        $external_code = $parts[1];

        $data = array(
            'accounting' => 'exact',
            'external_code' => $external_code,
            'external_id' => $external_id,
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

        redirect('/setting/exact/debitors/'.$this->input->post('id'));
    }

    function delete_debitor($id){

        if ($this->debitor_model->delete_row($id,$this->user_ID)) {
            $this->session->set_flashdata('success', 'Booking deleted');
        } else {
            $this->session->set_flashdata('error', 'Error in deleting Booking');
        }

        redirect('/setting/exact/debitors');

    }

    public function creditors() {

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

        $content_data['visma_creditors'] = $accounts_data;
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
        $content_data['creditor_data'] = $this->creditor_model->get_data($this->uri->segment(4));
        // print_r($content_data['debitor_data']);
        // exit;
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

        $content_data['visma_creditors'] = $accounts_data;
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

        $data = array(
            'accounting' => 'visma',
            'external_id' => $this->input->post('external_id'),
            'product_category_id' => $this->input->post('product_category_id'),
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

        $data = array(
            'accounting' => 'visma',
            'user_ID' => $this->user_ID,
            'external_id' => $this->input->post('external_id'),
            'product_category_id' => $this->input->post('product_category_id'),
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

}

?>
