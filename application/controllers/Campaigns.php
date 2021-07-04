<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';


class Campaigns extends BaseControllerWeb
{
    private $vendor_id;
    function __construct()
    {
        parent::__construct();
        $this->load->model('campaign_model');
        $this->load->model('list_model');
        $this->load->model('email_templates_model');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->helper('utility_helper');
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
    } 


    public function index()
    {
        $this->global['pageTitle'] = 'TIQS: Campaigns';
        $data['templates'] = $this->email_templates_model->get_mailing_email_by_user($this->vendor_id);
        $this->campaign_model->vendorId = $this->vendor_id;
        $campaigns = $this->campaign_model->fetchCampaigns();
        $data['campaigns'] = ($campaigns === null) ? [] : $campaigns;
        $this->list_model->vendorId = $this->vendor_id;
        $lists = $this->list_model->fetchVendorLists();
        $data['lists'] = ($lists === null) ? [] : $lists;
        $this->loadViews("campaigns/index", $this->global, $data, 'footerbusiness', 'headerbusiness');


    }

    public function get_campaigns()
    {
        $this->campaign_model->vendorId = $this->vendor_id;

        $campaigns = $this->campaign_model->fetchCampaigns();

        $campaigns = ($campaigns === null) ? [] : $campaigns;

        echo json_encode($campaigns);
    }

    public function save_campaign()
    {
        $data = $this->input->post(null, true);
        $data['vendorId'] = $this->vendor_id;

        if($this->campaign_model->insertCampaign($data)){
            $response = [
                'status' => 'success',
                'message' => 'Campaign is saved successfully!'
            ];
            echo json_encode($response);
            return ;
        }
        
        $response = [
            'status' => 'error',
            'message' => 'Campaign is not saved successfully!'
        ];
        echo json_encode($response);

    }

    public function delete_campaign()
    {
        $id = $this->input->post('id');

        $this->campaign_model->id = $id;

        if($this->campaign_model->delete()){
            $response = [
                'status' => 'success',
                'message' => 'Campaign is deleted successfully!'
            ];
            echo json_encode($response);
            return ;
        }
        
        $response = [
            'status' => 'error',
            'message' => 'Campaign is not deleted successfully!'
        ];
        echo json_encode($response);
    }


} 
