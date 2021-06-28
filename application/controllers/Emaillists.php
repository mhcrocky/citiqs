<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';


class Emaillists extends BaseControllerWeb
{
    private $vendor_id;
    function __construct()
    {
        parent::__construct();
        $this->load->model('emaillist_model');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->helper('utility_helper');
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
    } 


    public function index()
    {
        $this->global['pageTitle'] = 'TIQS: Email Lists';
        $this->loadViews("emaillists/index", $this->global, '', 'footerbusiness', 'headerbusiness');

    }

    public function get_email_lists()
    {
        $join = [
			0 => [
				'tbl_customer_emails',
				'tbl_customer_emails.id = tbl_emails_lists.emailId',
				'left',
            ],
            1 => [
				'tbl_lists',
				'tbl_lists.id = tbl_emails_lists.listId',
				'left',
			]
		];
		$what = [
            'tbl_emails_lists.id',
            'tbl_customer_emails.id AS customerEmailId',
            'tbl_customer_emails.email AS customerEmail',
            'tbl_customer_emails.name AS customerName',
            'tbl_customer_emails.active AS customerActive',
            'tbl_lists.id AS listId',
            'tbl_lists.list AS list',
            'tbl_lists.active AS listActive'
        ];
		$where = ["tbl_customer_emails.vendorId" => $this->vendor_id];
			
		$emailLists = $this->emaillist_model->read($what,$where, $join, 'group_by', ['tbl_emails_lists.id']);

        $emailLists = ($emailLists === null) ? [] : $emailLists;

        echo json_encode($emailLists);
    }

    public function delete_email_list()
    {
        $id = $this->input->post('id');

        $this->emaillist_model->id = $id;

        if($this->emaillist_model->delete()){
            $response = [
                'status' => 'success',
                'message' => 'Email list is deleted successfully!'
            ];
            echo json_encode($response);
            return ;
        }
        
        $response = [
            'status' => 'error',
            'message' => 'Email list is not deleted successfully!'
        ];
        echo json_encode($response);
    }


} 
