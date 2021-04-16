<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model
{



    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_user', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


		//$vendorId = $user['VendorId'];
		//$AppId = $user['AppId'];
		//$PlayerId = $user['PLayerId'];

	function checkOneSignalId($user)
	{
		$this->db->select("*");
		$this->db->from("tbl_user_notification_ids");
		$this->db->where("email", $email);
		$this->db->where("", 0);
		if($userId != 0){
			$this->db->where("id !=", $userId);
		}
		$query = $this->db->get();

		return $query->result();

	}


}
