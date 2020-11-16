<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Debitor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function save($data) {
        $this->db->insert('tbl_export_debitor', $data);
        return $this->db->insert_id();
    }

    public function get_debitor($user_ID,$accounting) {
        $this->db->select('*')->from('tbl_export_debitor');
        $this->db->where("user_ID", $user_ID);
        $this->db->where("accounting", $accounting);

        $q = $this->db->get();
        // echo $this->db->last_query();
        // exit;
        if ($q->num_rows() > 0) {
            return $q->result();
        }

        return false;
    }
    public function get_categories($user_ID) {
        $this->db->select('*')->from('tbl_shop_categories');
        $this->db->where("userId", $user_ID);
        $this->db->where("active", '1');
        $q = $this->db->get();

        if ($q->num_rows() > 0) {
            return $q->result();
        }

        return false;
    }

    public function get_item($ID) {
        return $this->db->query("SELECT rate_desc from tbl_export_debitor WHERE id='".$ID."'")->row()->rate_desc;
    }



    public function delete_row($id, $user_ID) {
        $this->db->where('id', $id);
        $this->db->delete("tbl_export_debitor");
    }

    public function get_data($id) {
        $this->db->select('*')
            ->from('tbl_export_debitor')
            ->where('id', $id)
            ->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row();
        }

        return false;
    }

    public function update($data) {

        $this->db->set('external_id', $data['external_id']);
        $this->db->set('external_code', $data['external_code']);
        $this->db->set('payment_type', $data['payment_type']);
        $this->db->set('accounting', $data['accounting']);
        $this->db->where('id', $data['id']);
        $this->db->where('user_ID', $data['user_ID']);
        $this->db->update('tbl_export_debitor');
        return $this->db->total_queries();
    }

}