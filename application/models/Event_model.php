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

	public function get_events($vendor_id)
	{
		$this->db->select('id, eventname');
		$this->db->from('tbl_events');
		$this->db->where('vendorId', $vendor_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_tickets($vendor_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_event_tickets');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId');
		$this->db->where('vendorId', $vendor_id);
		$query = $this->db->get();
		return $query->result_array();
	}
}
