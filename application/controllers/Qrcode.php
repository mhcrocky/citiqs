<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Qrcode extends BaseControllerWeb {

    private $vendorId;
    public function __construct(){
        parent::__construct();
        $this->load->model('qrcode_model');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('session');
        $this->isLoggedIn();
        $this->vendorId = $this->session->userdata('userId');
    }

    public function index() {
        $this->load->model('shopspot_model');
        $this->global['pageTitle'] = 'TIQS QRCode';
        $data['spots'] = $this->shopspot_model->fetchUserSpotsImporved([
            'tbl_shop_printers.userId=' => $this->vendorId,
            'tbl_shop_spots.archived=' => '0',
            'tbl_shop_spots.isApi=' => '0'
        ]);
        $this->loadViews("qrcodeview/index", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function get_qrcodes() {
        $qrcodes = $this->qrcode_model->get_qrcodes($this->vendorId);
        echo json_encode($qrcodes);

    }

    public function save_qrcode() {
        $data = $this->input->post(null, true);
        $qrcodeId = $data['qrcodeId'];
        unset($data['qrcodeId']);
        $data['vendorId'] = $this->vendorId;
        $response = $this->qrcode_model->save_qrcode($qrcodeId, $data);
        echo json_encode($response);

    }

    public function update_qrcode() {
        $qrcodeId = $this->input->post('qrcodeId');
        $spot = $this->input->post('spot');
        return $this->qrcode_model->update_qrcode($spot, $qrcodeId, $this->vendorId);

    }
    


}
