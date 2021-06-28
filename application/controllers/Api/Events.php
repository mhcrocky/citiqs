<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Events extends REST_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('api_model');
		$this->load->helper('utility_helper');
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));

	}

    public function allcategories_get()
    {
        $this->db->select('id, description');
        $this->db->from('tbl_category');
        $this->db->order_by('description');
        $query = $this->db->get();
        $result = $query->result_array();
        $this->response($result, 200);
    }

	public function Records_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));

		$this->db->where('vendorId', $vendorId);
		$this->db->from('tbl_events');
		$query = $this->db->get();
		$result = $query->result_array();
//		var_dump($result);
		$this->response($result, 200);
	}

	public function Tickettypes_post()
	{
		$eventId = $this->security->xss_clean($this->input->post('eventId'));
		$ticketType = $this->security->xss_clean($this->input->post('ticketType'));
		$this->db->select('*');
		$this->db->from('tbl_event_tickets');
		$this->db->where('eventId', $eventId);
		if($ticketType != '0') {
			$this->db->where('ticketType', $ticketType);
		}
		$query = $this->db->get();
		$result = $query->result_array();

		$this->response($result, 200);
	}

	public function Ticketevents_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));

		$this->db->select("id,vendorId,eventname,eventdescript,eventVenue,
		eventAddress,eventCity,eventZipcode,
		eventCountry,StartDate,EndDate,
        StartTime,EndTime");
		$this->db->from('tbl_events');
		$this->db->where('vendorId', $vendorId);
		$query = $this->db->get();
		$result = $query->result_array();

		$this->response($result, 200);
	}

	public function Tickets_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		$eventid = $this->security->xss_clean($this->input->post('eventId'));
		$changetimein = $this->security->xss_clean($this->input->post('changeTimeIn'));
		$changetimeout = $this->security->xss_clean($this->input->post('changeTimeOut'));


//		echo var_dump($vendorId);
//		echo var_dump($eventid);
//		echo var_dump($changetimein);
//		echo var_dump($changetimeout);

//		die();

		$this->db->where('customer', $vendorId);
		$this->db->where('eventid', $eventid);
		$this->db->where('scannedtime >=', date_create($changetimein)->format('Y-m-d H:i:s'));
		$this->db->where('scannedtime <=', date_create($changetimeout)->format('Y-m-d H:i:s'));

		$this->db->from('tbl_bookandpay');
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}

	public function Ticketsbuyer_post()
	{
		$email = $this->security->xss_clean($this->input->post('email'));
		$this->db->where('email', $email);
		$this->db->from('tbl_bookandpay');
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
