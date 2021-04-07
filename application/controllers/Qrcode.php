<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Qrcode extends BaseControllerWeb {

    
    public function __construct(){
        parent::__construct();
        $this->load->model('qrcode_model');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('session');
        $this->isLoggedIn();
    }

    public function index() {
        $this->global['pageTitle'] = 'TIQS QRCode';
        $this->loadViews("qrcodeview/index", $this->global, '', 'footerbusiness', 'headerbusiness');
    }

    public function get_qrcodes() {
        $vendorId = $this->session->userdata('userId');
        $qrcodes = $this->qrcode_model->get_qrcodes($vendorId);
        echo json_encode($qrcodes);

    }

    public function save_qrcode() {
        $data = $this->input->post(null, true);
        $qrcodeId = $data['qrcodeId'];
        unset($data['qrcodeId']);
        $vendorId = $this->session->userdata('userId');
        $data['vendorId'] = $vendorId;
        $response = $this->qrcode_model->save_qrcode($qrcodeId, $data);
        echo json_encode($response);

    }

    public function update_qrcode() {
        $qrcodeId = $this->input->post('qrcodeId');
        $spot = $this->input->post('spot');
        $vendorId = $this->session->userdata('userId');
        return $this->qrcode_model->update_qrcode($spot, $qrcodeId, $vendorId);

    }
    


}
