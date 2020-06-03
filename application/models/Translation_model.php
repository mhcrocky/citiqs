<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Translation_model extends CI_Model {

    public function getLanguages() {
        $this->db->distinct();
        $this->db->select('language');
        $this->db->from('tbl_language');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getTranslationsByLanguage($language) {
        $this->db->from('tbl_language');
        $this->db->where('language', $language);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getTranslationsById($id) {
        $this->db->select('text');
        $this->db->from('tbl_language');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function updateTranslation($recordId, $row) {
    	$this->phpAlert('update langauge in progress 1');
        $this->db->trans_start();
        $this->db->where("id", $recordId);
        $this->db->update('tbl_language', $row);
        $affected_rows = $this->db->affected_rows();
        $this->db->trans_complete();
        return $affected_rows;
    }

	public function deleteTranslation($recordId) {
		$this->db->query("delete from tbl_language where id='".$recordId."'");
		return 1;
	}

	function phpAlert($msg) {
    	log_message(0,$msg);
		echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}

}
