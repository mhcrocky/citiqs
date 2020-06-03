<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function getCategoryDescription($categoryId) {
        $this->db->select('description');
        $this->db->from('tbl_category');
        $this->db->where("id", $categoryId);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCategories() {
        $this->db->select('*');
        $this->db->order_by('description ASC');
        $this->db->from('tbl_category');        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getCategoryId($description) {
        $this->db->select('id');
        $this->db->from('tbl_category');
        $this->db->where("description", $description);
        $query = $this->db->get();
        return $query->row();
    }

    public function select(array $what, array $where): array
    {
        $this->db->select(implode(',', $what));
        $this->db->from('tbl_category');
        foreach($where as $key => $value) {
            $this->db->where([$key => $value]);
        }
        return $this->db->get()->result_array();
    }
}
