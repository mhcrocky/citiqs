<?php


defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Qrcodelist extends REST_Controller
{

	function __construct()
    {
        parent::__construct();
		$this->load->model('QRUniquecode_model');
		$this->load->model('api_model');
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
		$result = $this->QRUniquecode_model->Stpversion2();
//		$UniqueId = $result->code;
//		$message['uniqueId'] =  "$UniqueId";
		$UniqueId = $result;
//		$message =  "$UniqueId";
		$message =  $UniqueId;
		$this->response($message, 200);

	}

	private function authenticate($userId, $apiKey) {
		$result = $this->api_model->getUserByIdAndApiKey($userId, $apiKey);
		if (!empty($result)) {
			if ($result->userid == $userId && $result->apikey == $apiKey && $result->access == "1") {
				return true;
			} else {
				$this->response([
					'status' => false,
					'message' => 'Unauthorized'
				], 401);
			}
		} else {
			$this->response([
				'status' => false,
				'message' => 'Unauthorized'
			], 401);
		}
	}


}
