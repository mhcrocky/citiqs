<?php


defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Itemlist extends REST_Controller
{

	function __construct()
    {
        parent::__construct();
		$this->load->model('Uniquecode_model');
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
		$result = $this->Uniquecode_model->Stpversion2();
		$UniqueId = $result;
		$message['uniqueId'] =  "$UniqueId";
		$this->response($message, 200);

	}

	public function allitems_post() {
		$apiKey = $this->security->xss_clean($this->post('api_key'));
		$userId = $this->security->xss_clean($this->post('user_id'));
		$authResponse = $this->authenticate($userId, $apiKey);
		if ($authResponse) {
			$username = $this->api_model->getUserNameById($userId);
			$items = $this->api_model->getAllItems($userId);
			$this->response([
				'status' => true,
				'userid' => $userId,
				'username' => $username->username,
				'items' => $items
			], 200);
		}
	}

	public function descitem_post() {
		$apiKey = $this->security->xss_clean($this->post('api_key'));
		$userId = $this->security->xss_clean($this->post('user_id'));
		$description = $this->security->xss_clean($this->post('item_desc'));
		$authResponse = $this->authenticate($userId, $apiKey);
		if ($authResponse) {
			$username = $this->api_model->getUserNameById($userId);
			$items = $this->api_model->getItemByDescription($description, $userId);
			$this->response([
				'status' => true,
				'userid' => $userId,
				'username' => $username->username,
				'items' => $items
			], 200);
		}
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
