<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';
// use DB;
class ExactSetting extends BaseControllerWeb {

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
        $this->setting = $this->exact_model->get_data($this->user_ID);
        $this->load->helper('exact_online_helper');
		$this->load->library('language', array('controller' => $this->router->class));

        $this->load->library('pagination');
        $this->load->config('custom');
        $this->isLoggedIn();

    }

    /**
     * This function used to load the first screen of the user
     */
    public function index() {
        // echo 'here';
        // exit;
        $setting = $this->db->select('*')->where("user_ID", $this->user_ID)->get('tbl_export_setting')->row();

        if(empty($setting)){
            redirect('/exact');
        }
        // echo '<pre>';
        require FCPATH . 'vendor\autoload.php';
        $clientDivision = $setting->exact_division;
        $connection = connect(EXACT_RETURN, EXACT_CLIENT, EXACT_SECRET);
        $connection->setDivision($clientDivision);

        $test = new \Picqer\Financials\Exact\Division($connection);


        if ($setting->exact_auth != '' ) {
            $clientDivision = $clientDivision;
            $connection = connect(EXACT_RETURN, EXACT_CLIENT, EXACT_SECRET);
            $connection->setDivision($clientDivision);

            $test = new \Picqer\Financials\Exact\Division($connection);


            $result = $test->filter('', '', '');
            foreach ($result as $test) {
                $division[] = $test->Description.'|'.trim($test->Code);
            }
            $content_data['divisions'] = $division;

            $financialPeriod = new \Picqer\Financials\Exact\FinancialPeriod($connection);
            $result = $financialPeriod->filter('', '', '', array('$orderby' => 'ID'));
            foreach ($result as $financialPeriod) {
                $years[] = $financialPeriod->ID.'|['.get_date($financialPeriod->StartDate,'d-M-Y').']|['.get_date($financialPeriod->EndDate,'d-M-Y').']';
            }
            $content_data ['years'] = $years;

            $journals = new \Picqer\Financials\Exact\Journal($connection);
            $result = $journals->filter('', '', '', array('$orderby' => 'Code'));

            foreach ($result as $journal) {
                $jrnl[] = $journal->Code.'|['.trim($journal->Code).'] '.$journal->Description;
            }
            $content_data['journals'] = $jrnl;
            // echo '<pre>';
            // print_r($content_data);
            // exit;

        //     $Gla = new \Picqer\Financials\Exact\GLAccount($connection);
        //     $result = $Gla->filter('', '', '', array('$orderby' => 'Code'));

        //     foreach ($result as $gla) {
        //         $glas[] = $gla->ID.'|['.trim($gla->Code).'] '.$gla->Description.'|'.trim($gla->Code);
        //     }
        //     $content_data['glas'] = $glas;


        }

		$content_data['setting'] = $this->setting;
        $this->global['pageTitle'] = 'TIQS : Exact';
		$this->loadViews("setting/exact_config", $this->global, $content_data, NULL,'headerwebloginhotelProfile');
    }

    function app_setting(){
        $data = $this->input->post();
        $this->exact_model->update_exact_settings($this->user_ID,$data);
        $this->session->set_flashdata('success', 'Setting Updated successfully');
        redirect('/exact/config');
    }
}

?>
