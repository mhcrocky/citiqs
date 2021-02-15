<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class TicketTypes extends REST_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('api_model');
		$this->load->helper('utility_helper');
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function Types_post()
	{
		$eventId = $this->security->xss_clean($this->input->post('eventId'));

		$this->db->where('eventId', $eventId);
		$this->db->from('tbl_event_tickets');
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
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

}

?>
