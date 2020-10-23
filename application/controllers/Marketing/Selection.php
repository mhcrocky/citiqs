<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Selection extends BaseControllerWeb {

    
    public function __construct(){
        parent::__construct();
        if (empty($this->session->userdata('userId'))) {
			redirect('login');
		}
    }
    public function index() {
        $this->global['pageTitle'] = 'TIQS BUYERS';
        $this->loadViews("marketing/selection", $this->global, '', 'footerpublicbizdir', 'noheaderbizdir');
    }

    public function sendMessage() {
        $buyerId = $this->input->post('buyerId');
        $buyerMobile = $this->input->post('buyerMobile');
        $buyerOneSignalId = $this->input->post('buyerOneSignalId');
        $message = $this->input->post('message');
        if($buyerOneSignalId == 'null'){
            $this->load->library('Sms');
            $sms = new Sms;
            $sms->send($buyerMobile,$message);
            echo 'sms success';
        } else {
            $this->load->library('Notification');
            $notification = new Notification;
            $notification->sendMessage($buyerOneSignalId,$message);
        }

    }

    public function allbuyers(){
        $this->load->model('Selection_model');
        $userId = $this->session->userdata('userId');
        $buyers = $this->Selection_model->get_buyers($userId);
        /*
        return $this->output
					->set_content_type('application/json')
					->set_status_header(200)
                    ->set_output(json_encode($buyers));
        */
        echo json_encode($buyers);
    }

}