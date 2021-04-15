<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Selection extends BaseControllerWeb {

    
    public function __construct(){
        parent::__construct();
        $this->load->model('selection_model');
        $this->load->model('user_model');
        $this->isLoggedIn();
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index() {
        $this->global['pageTitle'] = 'TIQS BUYERS';
        $this->loadViews("marketing/selection", $this->global, '', 'footerbusiness', 'headerbusiness');
    }

    public function sendMessage() {
        $buyerId = $this->input->get('buyerId');
        $buyerMobile = $this->input->get('buyerMobile');
        $buyerOneSignalId = $this->input->get('buyerOneSignalId');
        $message = $this->input->get('message');
        //var_dump($buyerId);
//        die('here we are 2');
        if($buyerOneSignalId == ''){
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
        
        $userId = $this->session->userdata('userId');
        $buyers = $this->selection_model->get_buyers($userId);
        echo json_encode($buyers);
    }

    public function update_onesignal() {
        $buyerId = $this->input->post('buyerId');
        $buyerOneSignalId = $this->input->post('buyerOneSignalId');
        $this->user_model->updateOneSignalId($buyerId, $buyerOneSignalId);

    }

}
