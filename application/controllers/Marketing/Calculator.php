<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Calculator extends BaseControllerWeb {

    
    public function __construct(){
        parent::__construct();
    }

    public function index() {
        $this->global['pageTitle'] = 'TIQS CALCULATOR';
        $this->loadViews("marketing/calculator", $this->global, '', 'footerpublicbizdir', 'noheaderbizdir');
    }

    public function saveCalc() {
        $data = array (
            'amount' => $this->input->post('amount'),
            'times_per_day' => $this->input->post('times_per_day'),
            'commission' => $this->input->post('commission'),
            'email' => $this->input->post('email'),
            'vendor_id' => $this->session->userdata('userId')
        );

        $this->load->model('Calculator_model');
        $this->Calculator_model->save($data);
        
    }

}
