<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Whatislostisfound_model extends CI_Model {

    public function updateUser($row, $recordId) {
        $this->db->trans_start();
        $this->db->where("id", $recordId);
        $this->db->where("IsDropOffPoint", "1");
        $this->db->update("tbl_user", $row);
        $this->db->trans_complete();
    }

    public function getUsers() {
        $this->db->select("id, username, lat, lng, address, zipcode, city, country");
        $this->db->from("tbl_user");
        $this->db->where("IsDropOffPoint", "1");
		$this->db->where("address !=", "");
		$this->db->where("country !=", "");
		$this->db->where("zipcode !=", "");
		$this->db->where("lat !=", 0);
		$this->db->where("lng !=", 0);

		$query = $this->db->get();
		$str = $this->db->last_query();
        return $query->result();
    }

    public function getUserFoundItems($userId) {
		$this->db->select('User.IsDropOffPoint, BaseTbl.userclaimId, BaseTbl.id,  BaseTbl.userId, BaseTbl.userfoundId, BaseTbl.code, BaseTbl.descript, BaseTbl.lost, BaseTbl.createdDtm');
		$this->db->from('tbl_label as BaseTbl');
		$this->db->join('tbl_user as User', 'User.id = BaseTbl.UserId','left');
		$this->db->where('BaseTbl.userId', $userId);
		$this->db->where("User.IsDropOffPoint", "1");
		$this->db->where('BaseTbl.userclaimId IS NULL',null, false);
		$this->db->where('BaseTbl.IsDeleted', 0);
//		$this->db->from('tbl_label');
		// $query = $this->db->get();
		$str = $this->db->last_query();
        return $this->db->count_all_results();
    }

}
