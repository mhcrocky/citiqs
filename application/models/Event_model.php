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
		$this->db->where('vendorId', $vendor_id);
		$this->db->where('eventId', $eventId);
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
				'eventdate' => $ticket['startDate'],
				'timefrom' => $ticket['startTime'],
				'timeto' => $ticket['endTime'],
				'price' => $ticket['price'],
				'numberofpersons' => $ticket['quantity'],
				'email' => $userInfo['email'],
				'mobilephone' => $userInfo['mobileNumber'],
			];
		}
		$this->db->insert_batch('tbl_bookandpay',$data);
		 return $reservationIds;
	}
}
