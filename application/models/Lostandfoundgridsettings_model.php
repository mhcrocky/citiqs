<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class lostandfoundgridsettings_model extends CI_Model {

    public function addNewUserSetting($usersettings) {
        $this->db->trans_start();
        $this->db->insert('tbl_usersettings', $usersettings);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getUserSettingsById($userId) {
        $this->db->from('tbl_usersettings');
        $this->db->where("userId", $userId);
        $query = $this->db->get();
        return $query->row();
    }


	public function getUserSettingsExist($userId) {
		$this->db->from('tbl_usersettings');
		$this->db->where("userId", $userId);
		$query = $this->db->get();
		if($query->num_rows()==0) {
			return false;
		}
		return true;
	}

    public function updateUserSettings($usersettings) {
        $this->db->trans_start();
        $this->db->where("id", $this->id);
        $this->db->update('tbl_usersettings', $usersettings);
        $affected_rows = $this->db->affected_rows();
        $this->db->trans_complete();
        return $affected_rows;
    }
    
    public function deleteUserSettingsById($userId) {
        $this->db->where('id', $userId);
        $this->db->delete('tbl_usersettings');
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

}
