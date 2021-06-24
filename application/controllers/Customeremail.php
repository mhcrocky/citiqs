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
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->helper('utility_helper');
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
    } 


    public function index()
    {
        $this->global['pageTitle'] = 'TIQS: Customer Email';

        $this->loadViews("customeremail/index", $this->global, '', 'footerbusiness', 'headerbusiness');

    }

    public function sent()
    { 
        $this->global['pageTitle'] = 'TIQS: Create Event';
        //$data['countries'] = Country_helper::getCountries();
        $this->loadViews("events/step-one", $this->global, $data, 'footerbusiness', 'headerbusiness');

    }

    public function get_customer_emails()
    {
        $this->customeremail_model->vendorId = $this->vendor_id;

        $customer_emails = $this->customeremail_model->fetchVendorEmails();

        $customer_emails = ($customer_emails === null) ? [] : $customer_emails;

        echo json_encode($customer_emails);
    }


    public function send_multiple_emails()
	{
        $ids = json_decode($this->input->post('ids'));
        $emails = $this->input->post('emails');
        

        $response = [
            'status' => 'error',
            'message' => 'Emails are not sent successfully!'
        ];

        if(Ticketingemail_helper::sendEmailReservation($reservations, false, true, false, '', $emailId)){
            $response = [
                'status' => 'success',
                'message' => 'Emails are sent successfully!'
            ];

        }

        echo json_encode($response);

        return ;

    }

    public function import_emails(){
        $emails = json_decode($this->input->post('emails'));
        $data = [];
        foreach($emails as $key => $email){
            $data[$key] = [
                'email' => urldecode($email),
                'vendorId' => $this->vendor_id
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
