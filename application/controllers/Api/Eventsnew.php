<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Eventsnew extends REST_Controller
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
        StartTime,EndTime, eventImage");
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

		$this->db->where('customer', $vendorId);
		$this->db->where('eventid', $eventid);
		$this->db->where('scannedtime >=', date_create($changetimein)->format('Y-m-d H:i:s'));
		$this->db->where('scannedtime <=', date_create($changetimeout)->format('Y-m-d H:i:s'));
		$this->db->where_in('paid', [1,3]);
		$this->db->from('tbl_bookandpay');
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}

	public function Ticketsguest_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		$eventid = $this->security->xss_clean($this->input->post('eventId'));
		$changetimein = $this->security->xss_clean($this->input->post('changeTimeIn'));
		$changetimeout = $this->security->xss_clean($this->input->post('changeTimeOut'));

		$this->db->where('customer', $vendorId);
		$this->db->where('eventid', $eventid);
		$this->db->where('scannedtime >=', date_create($changetimein)->format('Y-m-d H:i:s'));
		$this->db->where('scannedtime <=', date_create($changetimeout)->format('Y-m-d H:i:s'));
		$this->db->where_in('tbl_bookandpay.paid', [1,3]);
		$this->db->from('tbl_bookandpay');
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}



	public function Ticketsbuyer_post()
	{
//		$email = $this->security->xss_clean($this->input->post('email'));
//		$file = FCPATH . 'application/tiqs_logs/mobileemail.txt';
//		$errorMessage = 'email for tickets: ' . $email;
//		Utility_helper::logMessage($file, $errorMessage);
//		$result = [];
//		$this->response($result, 200);
//		Return;

		$email = $this->security->xss_clean($this->input->post('email'));
		$this->db->select('tbl_events.eventname, tbl_events.eventImage, tbl_bookandpay.*');
		$this->db->from('tbl_bookandpay');
		$this->db->join('tbl_event_tickets', 'tbl_event_tickets.id = tbl_bookandpay.eventid', 'inner');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'ínner');
		$this->db->where('tbl_bookandpay.email', $email);
		$this->db->where_in('tbl_bookandpay.paid', [1,3]);
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}

	public function Ticketguest_post()
	{
//		$email = $this->security->xss_clean($this->input->post('email'));
//		$file = FCPATH . 'application/tiqs_logs/mobileemail.txt';
//		$errorMessage = 'email for tickets: ' . $email;
//		Utility_helper::logMessage($file, $errorMessage);

		$email = $this->security->xss_clean($this->input->post('email'));
		$this->db->select('tbl_events.eventname, tbl_events.eventImage, tbl_bookandpay.*');
		$this->db->from('tbl_bookandpay');
		$this->db->join('tbl_event_tickets', 'tbl_event_tickets.id = tbl_bookandpay.eventid', 'inner');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'ínner');
		$this->db->where('tbl_bookandpay.email', $email);
		$this->db->where_in('tbl_bookandpay.paid', [1,3]);
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}



	public function SingleTickets_post()
	{
		$reservationId = $this->security->xss_clean($this->input->post('reservationId'));
//		$email = $this->security->xss_clean($this->input->post('email'));
		$file = FCPATH . 'application/tiqs_logs/mobileemail.txt';
		$errorMessage = 'Single ticket: ' . $reservationId;
		Utility_helper::logMessage($file, $errorMessage);
//		$result = [];
//		$this->response($result, 200);
//		Return;

//		$email = $this->security->xss_clean($this->input->post('email'));
		$this->db->select('tbl_events.eventname, tbl_events.eventImage, tbl_bookandpay.*');
		$this->db->from('tbl_bookandpay');
		$this->db->join('tbl_event_tickets', 'tbl_event_tickets.id = tbl_bookandpay.eventid', 'inner');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'ínner');
		$this->db->where('tbl_bookandpay.reservationId', $reservationId);
		$this->db->where_in('tbl_bookandpay.paid', [1,3]);
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}

	public function Ticketsevent_post()
	{
		$eventsId = $this->security->xss_clean($this->input->post('eventId'));
//		$file = FCPATH . 'application/tiqs_logs/mobileemail.txt';
//		$errorMessage = 'email for tickets: ' . $eventsId;
//		Utility_helper::logMessage($file, $errorMessage);
//		$result = [];
//		$this->response($result, 200);
//		Return;
//		$email = $this->security->xss_clean($this->input->post('email'));
		$this->db->select('tbl_events.eventname, tbl_events.eventImage, tbl_bookandpay.*');
		$this->db->from('tbl_bookandpay');
		$this->db->join('tbl_event_tickets', 'tbl_event_tickets.id = tbl_bookandpay.eventid', 'inner');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'ínner');
		$this->db->where('tbl_events.id', $eventsId);
		$this->db->where_in('tbl_bookandpay.paid', [1,3]);
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}

	public function Ticketseventtobescanned_post()
	{
		$eventsId = $this->security->xss_clean($this->input->post('eventId'));
//		$file = FCPATH . 'application/tiqs_logs/mobileemail.txt';
//		$errorMessage = 'email for tickets: ' . $eventsId;
//		Utility_helper::logMessage($file, $errorMessage);
//		$result = [];
//		$this->response($result, 200);
//		Return;
//		$email = $this->security->xss_clean($this->input->post('email'));
//		$this->db->select_sum('tbl_bookandpay.numberofpersons');
		$this->db->select( 'SUM(tbl_bookandpay.numberofpersons) as scanstobemade' , 'tbl_events.eventname, tbl_events.eventImage, tbl_bookandpay.*');
		$this->db->from('tbl_bookandpay');
		$this->db->join('tbl_event_tickets', 'tbl_event_tickets.id = tbl_bookandpay.eventid', 'inner');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'ínner');
		$this->db->where('tbl_events.id', $eventsId);
//		$this->db->where('tbl_bookandpay.scanned !=', "0");
		$this->db->where_in('tbl_bookandpay.paid', [1,3]);
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}

	public function Ticketseventscanned_post()
	{
		$eventsId = $this->security->xss_clean($this->input->post('eventId'));
//		$file = FCPATH . 'application/tiqs_logs/mobileemail.txt';
//		$errorMessage = 'email for tickets: ' . $eventsId;
//		Utility_helper::logMessage($file, $errorMessage);
//		$result = [];
//		$this->response($result, 200);
//		Return;
//		$email = $this->security->xss_clean($this->input->post('email'));
		$this->db->select( 'SUM(tbl_bookandpay.numberin) as scansmade' , 'tbl_events.eventname, tbl_events.eventImage, tbl_bookandpay.*');
		$this->db->from('tbl_bookandpay');
		$this->db->join('tbl_event_tickets', 'tbl_event_tickets.id = tbl_bookandpay.eventid', 'inner');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'ínner');
		$this->db->where('tbl_events.id', $eventsId);
//		$this->db->where('tbl_bookandpay.scanned !=', "0");
		$this->db->where_in('tbl_bookandpay.paid', [1,3]);
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}

	public function Ticketseventnotscanned_post()
	{
		$eventsId = $this->security->xss_clean($this->input->post('eventId'));
//		$file = FCPATH . 'application/tiqs_logs/mobileemail.txt';
//		$errorMessage = 'email for tickets: ' . $eventsId;
//		Utility_helper::logMessage($file, $errorMessage);
//		$result = [];
//		$this->response($result, 200);
//		Return;
//		$email = $this->security->xss_clean($this->input->post('email'));
		$this->db->select( 'SUM(tbl_bookandpay.numberofpersons - tbl_bookandpay.numberin) as scanstobemade' , 'tbl_events.eventname, tbl_events.eventImage, tbl_bookandpay.*');
		$this->db->from('tbl_bookandpay');
		$this->db->join('tbl_event_tickets', 'tbl_event_tickets.id = tbl_bookandpay.eventid', 'inner');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'ínner');
		$this->db->where('tbl_events.id', $eventsId);
//		$this->db->where('tbl_bookandpay.scanned', "0");
		$this->db->where_in('tbl_bookandpay.paid', [1,3]);
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
