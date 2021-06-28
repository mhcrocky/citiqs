<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';


class Campaignslists extends BaseControllerWeb
{
    private $vendor_id;
    function __construct()
    {
        parent::__construct();
        $this->load->model('campaign_model');
        $this->load->model('campaignlist_model');
        $this->load->model('list_model');
        $this->load->model('email_templates_model');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->helper('utility_helper');
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
    } 


    public function index()
    {
        $this->global['pageTitle'] = 'TIQS: Campaigns Lists';
        $this->campaign_model->vendorId = $this->vendor_id;
        $this->list_model->vendorId = $this->vendor_id;
        $data['campaigns'] = $this->campaign_model->fetchCampaigns();
        $data['lists'] = $this->list_model->fetchVendorLists();
        $this->loadViews("campaigns/lists", $this->global, $data, 'footerbusiness', 'headerbusiness');

    }

    public function get_campaigns_lists()
    {
        $join = [
			0 => [
				'tbl_campaigns',
				'tbl_campaigns.id = tbl_campaigns_lists.campaignId',
				'left',
            ],
            1 => [
				'tbl_lists',
				'tbl_lists.id = tbl_campaigns_lists.listId',
				'left',
			]
		];
		$what = [
           'tbl_campaigns_lists.id',
           'tbl_campaigns.id AS campaignId',
           'tbl_campaigns.campaign AS campaignName',
           'tbl_campaigns.description AS campaignDescription',
           'tbl_campaigns.active AS campaignActive',
           'tbl_lists.id AS listId',
           'tbl_lists.list AS list',
           'tbl_lists.active AS listActive',
        ];
		$where = ["tbl_campaigns.vendorId" => $this->vendor_id];
			
		$campaignLists = $this->campaignlist_model->read($what,$where, $join, 'group_by', ['tbl_campaigns_lists.id']);

        $campaignLists = ($campaignLists === null) ? [] : $campaignLists;

        echo json_encode($campaignLists);
    }

    public function save_campaign_list()
    {
        $data = $this->input->post(null, true);

        if($this->campaignlist_model->insertCampaignList($data)){
            $response = [
                'status' => 'success',
                'message' => 'Campaign list is saved successfully!'
            ];
            echo json_encode($response);
            return ;
        }
        
        $response = [
            'status' => 'error',
            'message' => 'Campaign list is not saved successfully!'
        ];
        echo json_encode($response);

    }

    public function delete_campaign_list()
    {
        $id = $this->input->post('id');

        $this->campaignlist_model->id = $id;

        if($this->campaignlist_model->delete()){
            $response = [
                'status' => 'success',
                'message' => 'Campaign list is deleted successfully!'
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
