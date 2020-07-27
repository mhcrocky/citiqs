<?php


defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Stpmaker extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		$this->load->model('label_model');
		$this->load->model('spot_model');
		$this->load->model('bookandpay_model');
		$this->load->model('uniquecode_model');
		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function index_get()
	{
		$data = "No function called like this";
		$this->response($data, REST_Controller::HTTP_OK);
	}

	public function index_post()
	{
		$data = "No function called like this";
		$this->response($data, REST_Controller::HTTP_OK);
	}


	public function getnextsticker_get()
	{
		$result = $this->uniquecode_model->STPVersion2();
		$UniqueId = $result;
		$message['uniqueId'] =  "$UniqueId";
//		$message="hello form sticker";
		$this->response($message, 200);
	}

}
