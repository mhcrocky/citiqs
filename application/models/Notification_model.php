<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model
{

    function addOneSignalId($user)
    {
		$this->db->trans_start();
		$this->db->insert('tbl_user_notification', $user);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return $insert_id;
    }

	function checkOneSignalId($user)
	{
		$this->db->select("*");
		$this->db->from("tbl_user_notification_ids");
		$this->db->where("email", $user['emailBuyer']);
		$this->db->where("vendorId", $user['vendorId]']);
		$this->db->where("appId", $user['appId]']);
		$this->db->where("playerId", $user['playerId']);
		$query = $this->db->get();
		if (!empty($query)) {
			return $query->row();
		}
		return '';
	}

	function checkOneSignalIdUser($user)
	{
		$this->db->select("email");
		$this->db->from("tbl_user");
		$this->db->where("email", $user['emailBuyer']);
		$query = $this->db->get();
		if (!empty($query)) {
			return $query->row();
		}
		return '';
	}


}
