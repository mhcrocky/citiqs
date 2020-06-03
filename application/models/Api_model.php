<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

    public function getAllItems($userId) {
        $this->db->select(''
                . 'tbl_label.code as itemCode, '
                . 'tbl_label.descript as itemDesc, '
                . 'tbl_label.categoryid as itemCatId, '
                . 'tbl_label.image as itemImage, '
                . 'tbl_category.description as itemCatDesc');
        $this->db->from('tbl_label');
        $this->db->join('tbl_category', 'tbl_category.id = tbl_label.categoryid');
        $this->db->where('userid', $userId);
        $query = $this->db->get();
        return $query->result();
    }

    public function getUserByIdAndApiKey($userId, $apiKey) {
        $this->db->select('userid, apikey, access');
        $this->db->from('tbl_APIkeys');
        $this->db->where('userid', $userId);
        $this->db->where('apikey', $apiKey);
        $query = $this->db->get();
        return $query->row();
    }

    public function getUserNameById($userId) {
        $this->db->select('username');
        $this->db->from('tbl_user');
        $this->db->where('id', $userId);
        $query = $this->db->get();
        return $query->row();
    }

    public function getItemByDescription($description, $userId) {
        $this->db->select('code, descript, categoryid, image');
        $this->db->from('tbl_label');
        $this->db->where('userid', $userId);
        $this->db->like('descript', $description);
        $query = $this->db->get();
        return $query->result();
    }

}
