<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';


class Customeremail extends BaseControllerWeb
{
    private $vendor_id;
    function __construct()
    {
        parent::__construct();
        $this->load->model('customeremail_model');
        $this->load->model('campaign_model');
        $this->load->model('customeremailsent_model');
        $this->load->model('emaillist_model');
        $this->load->model('list_model');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->helper('utility_helper');
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
    } 


    public function index()
    {
        $this->global['pageTitle'] = 'TIQS: Customer Emails';
        $this->campaign_model->vendorId = $this->vendor_id;
        $campaigns = $this->campaign_model->fetchCampaigns();
        $data['campaigns'] = ($campaigns === null) ? [] : $campaigns;
        $this->list_model->vendorId = $this->vendor_id;
        $lists = $this->list_model->fetchVendorLists();
        $data['lists'] = ($lists === null) ? [] : $lists;

        $this->loadViews("customeremail/index", $this->global, $data, 'footerbusiness', 'headerbusiness');

    }

    public function sent()
    { 
        $this->global['pageTitle'] = 'TIQS: Customer Emails Sent';
        $this->loadViews("customeremail/sent", $this->global, '', 'footerbusiness', 'headerbusiness');

    }

    public function get_customer_emails()
    {
        $this->customeremail_model->vendorId = $this->vendor_id;

        $customer_emails = $this->customeremail_model->fetchVendorEmails();

        $customer_emails = ($customer_emails === null) ? [] : $customer_emails;

        echo json_encode($customer_emails);
    }

    public function get_customer_emails_sent()
    {
        $join = [
			0 => [
				'tbl_customer_emails',
				'tbl_customer_emails.id = tbl_customer_emails_sent.emailId',
				'left',
            ]
		];
		$what = ['tbl_customer_emails_sent.*'];

        $where = ["vendorId" => $this->vendor_id];
			
		$customer_emails_sent = $this->customeremailsent_model->read($what, $where, $join, 'group_by', ['tbl_customer_emails_sent.id']);

        $customer_emails_sent = ($customer_emails_sent === null) ? [] : $customer_emails_sent;

        echo json_encode($customer_emails_sent);
    } 


    public function send_multiple_emails()
	{
        $ids = json_decode($this->input->post('ids'));

        $where = ["vendorId" => $this->vendor_id];
			
		$emails = $this->customeremail_model->read(['*'], $where, [], 'where_in', [$ids]);

        $campaignId = $this->input->post('campaignId');

        $this->customeremailsent_model->campaignId = (int) $campaignId;
        
        $this->customeremailsent_model->sendEmails($emails, 1, 'email_helper', 'sendCampaignEmailWithTemplate', ['email', 'subject']);
        
        $response = [
            'status' => 'success',
            'message' => 'Emails are sent successfully!'
        ];
        echo json_encode($response);
        return ;   

    }

    public function send_emails_from_campaign()
	{

		$campaignId = $this->input->post('campaignId');

        $this->customeremailsent_model->campaignId = (int) $campaignId;
        
        $this->customeremailsent_model->sendCampaignEmails(1, 'email_helper', 'sendCampaignEmailWithTemplate', ['email', 'subject']);

        $response = [
            'status' => 'success',
            'message' => 'Emails are sent successfully!'
        ];
        echo json_encode($response);
        return ;   

    }

    public function save_emails_list()
	{
        $ids = json_decode($this->input->post('ids'));
        $listId = $this->input->post('listId');
        $data = [];
        foreach($ids as $key => $id){
            $data[$key] = [
                'emailId' => $id,
                'listId' => $listId
            ];
        }
			
		if($this->emaillist_model->multipleCreate($data)){
            $response = [
                'status' => 'success',
                'message' => 'Emails list is saved successfully!'
            ];
            echo json_encode($response);
            return ;   

        }

       
        
        $response = [
            'status' => 'error',
            'message' => 'Emails list is saved successfully!'
        ];
        echo json_encode($response);
        return ;   

    }

    public function import_customers(){
        $customers = json_decode($this->input->post('customers'));
        $data = [];
        foreach($customers as $key => $customer){
            $data[$key] = [
                'email' => urldecode($customer->email),
                'vendorId' => $this->vendor_id,
                'name' => $customer->name
            ];
        }

        if($this->customeremail_model->insertEmails($data)){
            $response = [
                'status' => 'success',
                'message' => 'Emails are imported successfully!'
            ];
            echo json_encode($response);
            return ;
        }
        
        $response = [
            'status' => 'error',
            'message' => 'Emails are already imported!'
        ];
        echo json_encode($response);
        
    }

} 
