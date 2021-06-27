<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Reservations extends REST_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('api_model');
		$this->load->helper('utility_helper');
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function reservationsagendas_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));

		$this->db->where('Customer', $vendorId);
		$this->db->where('ReservationDateTime =', date_create(date('Y-m-d 00:00:00'))->format('Y-m-d H:i:s'));
		$this->db->from('tbl_bookandpayagenda');
		$query = $this->db->get();
		$result = $query->result_array();
//		var_dump($result);
		$this->response($result, 200);
	}

	public function reservationsspots_post()
	{
		$agendaId = $this->security->xss_clean($this->input->post('agendaId'));
//		$ticketType = $this->security->xss_clean($this->input->post('Type'));
		$this->db->select('*');
		$this->db->from('tbl_bookandpayspot');
		$this->db->where('agenda_id', $agendaId);
//		if($ticketType != '0') {
//			$this->db->where('ticketType', $ticketType);
//		}
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}

	public function reservationstimeslots_post()
	{
		$spotId = $this->security->xss_clean($this->input->post('spotId'));

		$this->db->select('*');
		$this->db->from('tbl_bookandpaytimeslots');
		$this->db->where('spot_id', $spotId);
//		if($ticketType != '0') {
//			$this->db->where('ticketType', $ticketType);
//		}
		$query = $this->db->get();
		$result = $query->result_array();

		$this->response($result, 200);
	}

//	public function Ticketevents_post()
//	{
//		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
//		$this->db->select("id,vendorId,eventname,eventdescript,eventVenue,
//		eventAddress,eventCity,eventZipcode,
//		eventCountry,StartDate,EndDate,
//        StartTime,EndTime");
//		$this->db->from('tbl_events');
//		$this->db->where('vendorId', $vendorId);
//		$query = $this->db->get();
//		$result = $query->result_array();
//		$this->response($result, 200);
//	}

	public function Ticketsbyagendaid_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		$id = $this->security->xss_clean($this->input->post('Id'));
		$changetimein = $this->security->xss_clean($this->input->post('changeTimeIn'));
		$changetimeout = $this->security->xss_clean($this->input->post('changeTimeOut'));


//		echo var_dump($vendorId);
//		echo var_dump($eventid);
//		echo var_dump($changetimein);
//		echo var_dump($changetimeout);
//
//

//		die();

		$this->db->where('customer', $vendorId);
		$this->db->where('eventid', $id);
		$this->db->where('scannedtime >=', date_create($changetimein)->format('Y-m-d H:i:s'));
		$this->db->where('scannedtime <=', date_create($changetimeout)->format('Y-m-d H:i:s'));

		$this->db->from('tbl_bookandpay');
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}


	public function Ticketsbyspotid_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		$id = $this->security->xss_clean($this->input->post('Id'));
		$changetimein = $this->security->xss_clean($this->input->post('changeTimeIn'));
		$changetimeout = $this->security->xss_clean($this->input->post('changeTimeOut'));


//		echo var_dump($vendorId);
//		echo var_dump($eventid);
//		echo var_dump($changetimein);
//		echo var_dump($changetimeout);
//
//

//		die();

		$this->db->where('customer', $vendorId);
		$this->db->where('SpotId', $id);
		$this->db->where('scannedtime >=', date_create($changetimein)->format('Y-m-d H:i:s'));
		$this->db->where('scannedtime <=', date_create($changetimeout)->format('Y-m-d H:i:s'));

		$this->db->from('tbl_bookandpay');
		$query = $this->db->get();
		$result = $query->result_array();
		$this->response($result, 200);
	}

	public function Ticketsbytimeslot_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		$eventid = $this->security->xss_clean($this->input->post('Id'));
		$changetimein = $this->security->xss_clean($this->input->post('changeTimeIn'));
		$changetimeout = $this->security->xss_clean($this->input->post('changeTimeOut'));


//		echo var_dump($vendorId);
//		echo var_dump($eventid);
//		echo var_dump($changetimein);
//		echo var_dump($changetimeout);
//
//

//		die();

		$this->db->where('customer', $vendorId);
		$this->db->where('timeslotId', $eventid);
		$this->db->where('scannedtime >=', date_create($changetimein)->format('Y-m-d H:i:s'));
		$this->db->where('scannedtime <=', date_create($changetimeout)->format('Y-m-d H:i:s'));

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
