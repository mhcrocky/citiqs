<?php
class Calculator_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function save($data)
	{
		$this->db->insert('tbl_calculator', $data);
	}
}
