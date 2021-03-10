<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Voucher extends BaseControllerWeb
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'TIQS: Create Vouchers';
        $data['vendorId'] = $this->session->userdata('userId');
		$this->loadViews("voucher/create", $this->global, $data, 'footerbusiness', 'headerbusiness'); 
	}

}