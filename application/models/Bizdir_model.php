<?php
class Bizdir_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_bizdir()
	{
		$this->db->where('roleid', 2);
		$this->db->where('IsDropOffPoint', 1);
		$this->db->where('address !=', '');
		$this->db->where('bizdir', 1);
		$query = $this->db->get('tbl_user');
		return $query->result_array();
	}

	public function set_bizdir()
	{
		$data = array(
			'business_name' => $this->input->post('name'),
			'address' => $this->input->post('address'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'website' => $this->input->post('website'),
			'image' => $this->input->post('image'),
			'category' => $this->input->post('category'),
		);
		return $this->db->insert('directory', $data);
	}
}
