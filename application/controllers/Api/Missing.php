<?php


defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Missing extends REST_Controller
{

	function __construct()
    {
        parent::__construct();
		$this->load->model('api_model');
		$this->load->model('label_model');
		$this->load->model('spot_model');
		$this->load->model('bookandpay_model');
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

	public function getqrcode_post()
	{
		$qrcode = $this->security->xss_clean($this->post('qrcode'));
		$result = $this->spot_model->getItem($qrcode);
		$labelInfo['numberin']=$result->numberin+1;
		$result = $this->bookandpay_model->editbookandpay($labelInfo, $qrcode);
		$result = $this->spot_model->getItem($qrcode);
		$this->response($result, 200);
	}
	
	public function missingitems_post(): void
	{
		$apiKey = $this->security->xss_clean($this->post('api_key'));
		$userId = $this->security->xss_clean($this->post('user_id'));
		$lat = $this->security->xss_clean($this->post('location_lat'));
		$lng = $this->security->xss_clean($this->post('location_lng'));
		$radius = $this->security->xss_clean($this->post('location_radius'));
		if ($this->authenticate($userId, $apiKey) === true) {
			$items = $this->label_model->getItemsInPointRadius(floatval($lat), floatval($lng), floatval($radius), 1);
			foreach ($items as $index => $item) {
				unset($items[$index]['distance']);
			}
			$this->response([
				'items' => $items,
			], 200);
		};
	}

	public function locateditem_post() {
		$apiKey = $this->security->xss_clean($this->post('api_key'));
		$userId = $this->security->xss_clean($this->post('user_id'));
		$lat = $this->security->xss_clean($this->post('location_lat'));
		$lng = $this->security->xss_clean($this->post('location_lng'));
		$radius = $this->security->xss_clean($this->post('location_radius'));
		$authResponse = $this->authenticate($userId, $apiKey);
//		$items = $this->missing_model->getMissingItemsNearMe($lat, $long);
		$items = $this->missing_model->getItem($lat,$lng);
		$this->response([
			'items' => $items,
		], 200);
//		if ($authResponse) {
//			$this->response([
//				'items' => $items,
//			], 200);
//		}
	}

	public function descitem_post() {
		$apiKey = $this->security->xss_clean($this->post('api_key'));
		$userId = $this->security->xss_clean($this->post('user_id'));
		$description = $this->security->xss_clean($this->post('item_desc'));
		$authResponse = $this->authenticate($userId, $apiKey);
		if ($authResponse) {
			$items = $this->missing_model->getItems();
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
