<?php
class Event_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
	}

	public function save_event($data)
	{
		$this->db->insert('tbl_events',$data);
		return $this->db->insert_id();
	}

	public function update_event($eventId, $data)
	{
		$this->db->where("id", $eventId);
		return $this->db->update('tbl_events',$data);
	}

	public function save_ticket($data)
	{
		return $this->db->insert('tbl_event_tickets',$data);
	}

	public function save_ticket_options($data)
	{
		$ticketId = $data['ticketId'];
		if($ticketId == ""){
			return $this->db->insert('tbl_ticket_options',$data);
		}
		$this->db->where('ticketId ',$ticketId );
		return $this->db->update('tbl_ticket_options',$data);
		
	}

	public function save_ticket_group($groupname,$quantity)
	{
		$this->db->insert('tbl_ticket_groups',['groupname' => $groupname, 'capacity' => $quantity]);
		return $this->db->insert_id();
		
	}

	public function get_ticket_options($ticketId)
	{
		$this->db->select('*');
		$this->db->from('tbl_ticket_options');
		$this->db->where('ticketId', $ticketId);
		$query = $this->db->get();
		$results = $query->result_array();
		if(isset($results[0])){
			return $results[0];
		}
		return '';
	}

	public function get_events($vendor_id)
	{
		
		$this->db->where('vendorId', $vendor_id);
		$query = $this->db->get('tbl_events');
		return $query->result_array();
	} 

	public function get_event($vendor_id,$eventId)
	{
		$this->db->where('id', $eventId);
		$this->db->where('vendorId', $vendor_id);
		$query = $this->db->get('tbl_events');
		return $query->first_row();
	}

	public function get_ticket($ticketId)
	{
		$this->db->where('id', $ticketId);
		$query = $this->db->get('tbl_event_tickets');
		return $query->first_row();
	}

	public function get_tickets($vendor_id,$eventId)
	{
		$this->db->select('*,tbl_event_tickets.id as ticketId');
		$this->db->from('tbl_event_tickets');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId');
		$this->db->join('tbl_ticket_groups', 'tbl_ticket_groups.id = tbl_event_tickets.ticketGroupId');
		$this->db->join('tbl_ticket_options', 'tbl_ticket_options.ticketId = ticketId');
		$this->db->where('vendorId', $vendor_id);
		$this->db->where('tbl_event_tickets.eventId', $eventId);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_ticket_groups()
	{
		$this->db->select('*');
		$this->db->from('tbl_ticket_groups');
		$query = $this->db->get();
		return $query->result_array();
	}

	function save_design($vendor_id,$design){
		$this->db->set('shopDesign', $design);
		$this->db->where('vendorId', $vendor_id);
		return $this->db->update('tbl_events');
	}

	function update_email_template($id, $emailId){
		$this->db->set('emailId', $emailId);
		$this->db->where('id', $id);
		return $this->db->update('tbl_event_tickets');
	}

	function get_design($vendor_id){

		$this->db->select('shopDesign')
		->from('tbl_events')
		->where('vendorId',$vendor_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	function save_event_reservations($userInfo, $tickets = array(), $customer){
		$data = [];
		if(!isset($userInfo['email'])){ return ;}
		$reservationIds = [];
		foreach($tickets as $ticket){
			$set = '3456789abcdefghjkmnpqrstvwxyABCDEFGHJKLMNPQRSTVWXY';
			$reservationId = 'T-' . substr(str_shuffle($set), 0, 16);
			$reservationIds[] = $reservationId;
			$data[] = [
				'reservationId' => $reservationId,
				'customer' => $customer,
				'eventId' => $ticket['id'],
				'eventdate' => date('Y-m-d', strtotime($ticket['startDate'])),
				'timefrom' => $ticket['startTime'],
				'timeto' => $ticket['endTime'],
				'price' => $ticket['price'],
				'numberofpersons' => $ticket['quantity'],
				'email' => $userInfo['email'],
				'mobilephone' => $userInfo['mobileNumber'],
				'Address' => $userInfo['address'],

				//SQL
				/*
				ALTER TABLE `tbl_bookandpay` ADD `gender` VARCHAR(255) NOT NULL AFTER `email`, ADD `age` DATE NOT NULL AFTER `gender`; 
				
				*/
			];
		}
		$this->db->insert_batch('tbl_bookandpay',$data);
		 return $reservationIds;
	}

	public function get_ticket_report($vendorId, $eventId, $sql='')
	{
		$query = $this->db->query("SELECT reservationId, reservationtime, price,numberofpersons,(price*numberofpersons) as amount, mobilephone, email, ticketDescription, ticketQuantity
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_events.vendorId = ".$vendorId." AND tbl_events.Id = ".$eventId." $sql
		ORDER BY reservationtime DESC");
		return $query->result_array();
	}

	public function get_tickets_report($vendorId, $sql='')
	{
		$query = $this->db->query("SELECT reservationId, reservationtime, price,numberofpersons,(price*numberofpersons) as amount, mobilephone, email, ticketDescription, eventname
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_events.vendorId = ".$vendorId." $sql
		ORDER BY reservationtime DESC");
		return $query->result_array();
	}

	public function get_booking_report_of_days($vendorId, $eventId, $sql='')
	{
		$query = $this->db->query("SELECT DATE(reservationtime) AS day_date,  eventdate, reservationtime, sum(numberofpersons) AS tickets 
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_events.vendorId = ".$vendorId." AND tbl_events.Id = ".$eventId." $sql AND paid=1  GROUP BY day_date 
		ORDER BY day_date ASC");
		return $query->result_array();
	}

	function get_days_report($vendor_id, $eventId, $sql=''){
		$results = $this->get_booking_report_of_days($vendor_id, $eventId, $sql);
		$tickets = [];
		$newData = [];
		$maxDays = 0;
		foreach($results as $key => $result){
			$reservationDate = $result['day_date'];
			$eventDate = $result['eventdate'];
			$dStart = new DateTime($reservationDate);
			$dEnd  = new DateTime($eventDate);
			$dDiff = $dStart->diff($dEnd);
			$days = abs($dDiff->format('%r%a'));
			if($days > $maxDays){
				$maxDays = $days;
			}
			$tickets[$days] = $result['tickets'];
		}
	
		for($i = $maxDays; $i > 0; $i--){
			
			$newData[] = [
				"days" => ($i == 1) ? $i.' day' : $i.' days',
				"tickets" => isset($tickets[$i]) ? (int) $tickets[$i] : 0,
			];
		}
		return $newData;
	}


}
