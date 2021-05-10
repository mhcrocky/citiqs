<?php
class Mobilevendor_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
	}

	public function create_appsettings($data)
	{
		$this->db->insert('tbl_app_settings',$data);
		return $this->db->insert_id() ? true : false;
	}

	public function update_appsettings($data, $where)
	{
		$this->db->update('tbl_app_settings',$data, $where);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function get_appsettings($where)
	{
		$query = $this->db->get('tbl_app_settings', $where);
		return $query->first_row();
	}

	public function delete_appsettings($where)
	{
		$this->db->delete('tbl_app_settings', $where);
		return ($this->db->affected_rows() > 0) ? true : false;
	}



}
