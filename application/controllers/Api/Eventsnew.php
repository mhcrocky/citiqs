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

		/*
		 *
		"id": "243148",
        "customer": "45846",
        "eventid": "53",
        "eventdate": "2021-08-28",
        "reservationId": "T-MBxmfQwcATVEkr3j",
        "bookdatetime": "2021-04-28 21:42:47",
        "ticketType": "1",
        "ticketDescription": "Early Bird",
        "paymentMethod": null,
        "isTicket": "0",
        "SpotId": "0",
        "price": "0",
        "reservationFee": "0.00",
        "ticketFee": "0.00",
        "Spotlabel": "",
        "numberofpersons": "1",
        "name": "Uncle John VVK",
        "email": "support@tiqs.com",
        "gender": null,
        "age": null,
        "Address": "",
        "city": "",
        "zipcode": "",
        "country": "",
        "mobilephone": "",
        "reservationset": "0",
        "reservationtime": "2021-04-28 21:42:47",
        "timefrom": "12:00:00",
        "timeto": "23:00:00",
        "paid": "3",
        "timeslot": "0",
        "timeslotId": "0",
        "voucher": null,
        "TransactionID": "",
        "bookingsequenceId": "0",
        "bookingsequenceamount": "0",
        "numberin": "1",
        "mailsend": "1",
        "scanned": "2",
        "scannedtime": "2021-06-28 13:50:03",
        "guestlist": "0",
        "tag": "0",
        "refundRequested": "0"
		 *
		 * event
    	 "id": "131",
        "vendorId": "43533",
        "eventname": "Den Haag Outdoor",
        "eventdescript": "<p>text and more......</p><p><span xss=removed>text and more......</span></p><p><span xss=removed>text and more......text and more......</span></p><p><span xss=removed>text and more......</span></p><p><span xss=removed>text and more......text and more....",
        "eventVenue": "Henriëtte Roland Holstweg",
        "eventAddress": "Zuiderpark",
        "eventCity": "Den Haag",
        "eventZipcode": "2533ST ",
        "eventCountry": "Netherlands",
        "StartDate": "2021-07-31",
        "EndDate": "2021-07-31",
        "StartTime": "16:00:00",
        "EndTime": "18:00:00",
        "eventImage": "4d0a5eda8277b7381f0cb9ca738e7898.png"
		 *
		 */
		$email = $this->security->xss_clean($this->input->post('email'));
		$this->db->select('tbl_events.eventname, tbl_events.eventImage, tbl_bookandpay.*');
		$this->db->from('tbl_bookandpay');
		$this->db->join('tbl_event_tickets', 'tbl_event_tickets.id = tbl_bookandpay.eventid', 'inner');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'ínner');
		$this->db->where('email', $email);
		$where = "paid=1 OR paid=3";
		$this->db->where($where);
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
