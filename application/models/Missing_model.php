<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Missing_model extends CI_Model {

    public function getItems() {
        $this->db->select('id, Description, Category, reward, address, lat, lng, iconimage, clickurl');
        $this->db->from('tbl_missing');
        $query = $this->db->get();
		$result = $query->result();
		return $result;
    }

	public function getItem($lat,$lng) {
		$this->db->select('id, Description, Category, reward, address, lat, lng, iconimage, clickurl');
		$this->db->from('tbl_missing');
		$this->db->where("lat", $lat);
		$this->db->where("lng", $lng);
		$query = $this->db->get();
		$lastquery = $this->db->last_query();
		$result = $query->result();
		return $result;
	}



}
