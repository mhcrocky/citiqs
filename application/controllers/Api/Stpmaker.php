<?php


defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Stpmaker extends REST_Controller
{

	function __construct()
    {
        parent::__construct();
		$this->load->model('Uniquecode_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }

	public function index_get()
	{
		$data = "hello";
		$this->response($data, REST_Controller::HTTP_OK);
	}

	public function getnextsticker_get()
	{
		$result = $this->Uniquecode_model->Stpversion2();
		$UniqueId = $result;
		$message['uniqueId'] =  "$UniqueId";

		$this->response($message, 200);
	}

	public function getqrcode_get()
	{
//		$userId = $this->security->xss_clean($this->post('user_id'));
		$result = $this->spotnumber_model->spotpeople();
		$UniqueId = $result;
		$message['uniqueId'] =  "$UniqueId";

		$this->response($message, 200);
	}

}
