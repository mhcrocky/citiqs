<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vat_rates_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function save($data) {
        $this->db->insert('vat_rates', $data);
        return $this->db->insert_id();
    }

    public function get_vat_rates($user_ID,$accounting) {
        $this->db->select('c1.*')->from('vat_rates c1');
        $this->db->where("user_ID", $user_ID);
        $this->db->where("accounting", $accounting);
        $this->db->order_by("rate_perc", "DESC");
        $q = $this->db->get();

        if ($q->num_rows() > 0) {
            return $q->result();
        }

        return false;
    }

    public function get_item($ID) {
        return $this->db->query("SELECT rate_desc from vat_rates WHERE id='".$ID."'")->row()->rate_desc;
    }



    public function delete_row($id, $user_ID) {
        $this->db->where('id', $id);
        $this->db->where('user_ID', $user_ID);
        $this->db->delete("vat_rates");
    }

    public function get_data($id) {
        $this->db->select('*')
            ->from('vat_rates')
            ->where('id', $id)
            ->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row();
        }

        return false;
    }

    public function update($data) {

        $this->db->set('rate_desc', $data['rate_desc']);
        $this->db->set('rate_code', $data['rate_code']);
        $this->db->set('rate_perc', $data['rate_perc']);
        $this->db->set('vat_external_code', $data['vat_external_code']);
        $this->db->where('id', $data['id']);
        $this->db->where('user_ID', $data['user_ID']);
        $this->db->update('vat_rates');
        return $this->db->total_queries();
    }

    public function delete_debitor_row($id, $user_ID) {
        $this->db->where('id', $id);
        $this->db->where('user_ID', $user_ID);
        $this->db->delete("tbl_export_debitor");
    }

}