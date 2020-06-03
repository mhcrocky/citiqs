<?php


defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Music extends REST_Controller
{

	function __construct()
    {
        parent::__construct();
		$this->load->model('api_model');
		$this->load->model('music_model');
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

	public function rating_post() {
//		$apiKey = $this->security->xss_clean($this->post('api_key'));
//		$userId = $this->security->xss_clean($this->post('user_id'));
		$artist = $this->security->xss_clean($this->post('Artist'));
		$song = $this->security->xss_clean($this->post('Song'));
		$updown = $this->security->xss_clean($this->post('updown'));
//		$authResponse = $this->authenticate($userId, $apiKey);
//		$items = $this->missing_model->getMissingItemsNearMe($lat, $long);
		$data = [
			'artist' => $artist,
			'song' => $song,
			'updown' => $updown
		];
		$response = $this->music_model->insert($data);
		$this->response([
			'response' => $response,
		], 200);
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
