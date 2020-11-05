<?php
class Calculator_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function save($data)
	{

		try {
			// $this->db->trans_start();
			if ($this->db->insert('tbl_calculator', $data))
				$insert_id = $this->db->insert_id();
			else
				$insert_id = -1;
			//$this->db->trans_complete();
//			echo var_dump($insert_id);
//			echo var_dump($this->db->last_query());
			return $insert_id;
		}

		catch (Exception $ex)
		{
			return -1;
		}

	}
}
