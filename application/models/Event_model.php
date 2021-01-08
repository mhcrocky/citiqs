<?php
class Event_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
	}

	public function save_event($data)
	{
		return $this->db->insert('tbl_events',$data);
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

	public function get_tickets($vendor_id)
	{
		$this->db->select('*,tbl_event_tickets.id as ticketId');
		$this->db->from('tbl_event_tickets');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId');
		$this->db->where('vendorId', $vendor_id);
		$query = $this->db->get();
		return $query->result_array();
	}
}
