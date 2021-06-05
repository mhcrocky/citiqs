<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Loggedin extends BaseControllerWeb
{
	/**
	 * This is default constructor of the class
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('validate_data_helper');
		$this->load->model('shopvendor_model');
		$this->load->helper('utility_helper');
		$this->load->helper('url');

		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function index()
	{
		$this->global['pageTitle'] = 'TIQS : DASHBOARD';

		if (empty($_SESSION['isLoggedIn'])) {
			redirect('login');
		}

		if ($this->isBuyer()) {
			redirect('buyer');
		} else {
			$data = [
				'vendor' => $this->shopvendor_model->setProperty('vendorId', $_SESSION['userId'])->getVendorData(),
			];
			$this->loadViews('nolabels', $this->global, $data, 'footerbusiness', 'headerbusiness');
		}
	}
}
