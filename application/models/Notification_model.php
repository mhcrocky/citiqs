<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model
{

    function addOneSignalId($user)
    {
		$this->db->trans_start();
		$this->db->insert('tbl_user_notificationIds', $user);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return $insert_id;
    }

	function checkOneSignalId($user)
	{
		$this->db->select("*");
		$this->db->from("tbl_user_notificationIds");
		$this->db->where("emailBuyer", $user['emailBuyer']);
		$this->db->where("vendorId", $user['vendorId']);
		$this->db->where("appId", $user['appId']);
		$this->db->where("playerId", $user['playerId']);
//		var_dump($user);
		$query = $this->db->get();
//		var_dump($query->row());
		return $query->row();
	}

	function checkOneSignalIdUser($user)
	{
//		var_dump($user);

		$this->db->select("*");
		$this->db->from("tbl_user");
		$this->db->where("email", $user['emailBuyer']);
		$query = $this->db->get();
//		var_dump($query->row());
//		die();
		return $query->row();

	}


}
