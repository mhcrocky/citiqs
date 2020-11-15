<?php
class Bizdir_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
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

	public function get_bizdir_by_location($lat,$long,$range)
	{
		// get given location coordinates
		// check this with the stored coordinates lat long in user table
		// show results

		$this->db->where('roleid', 2);
		$this->db->where('bizdir', 1);
		$query = $this->db->get('tbl_user');
		$results = $query->result_array();
		$places = [];
		foreach($results as $result){
			$distance = Utility_helper::getDistance(floatval($lat), floatval($long), floatval($result['lat']), floatval($result['lng']));

			if($distance<=$range){
				$result['distance'] = number_format($distance, 2, '.', '');
				$places[] = $result;
			}
		}

		return $places;
		
	}

	public function get_bizdir_by_defaultkey($defaultkey)
	{
		$this->db->where('defaultkey', $defaultkey);
		$query = $this->db->get('tbl_default_places');
		return $query->row();
		
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
