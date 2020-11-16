<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function save($data) {
        $this->db->insert('tbl_export_services', $data);
        // echo $this->db->last_query();
        return $this->db->insert_id();
    }

    public function get_creditor($user_ID,$accounting) {
        $this->db->select('*')->from('tbl_export_services');
        $this->db->where("user_ID", $user_ID);
        $this->db->where("accounting", $accounting);
        $q = $this->db->get();

        if ($q->num_rows() > 0) {
            return $q->result();
        }

        return false;
    }
    public function get_services_type($user_ID) {
        $q = $this->db->query("SELECT id,serviceFeeAmount,vendorId,serviceFeeTax FROM `tbl_shop_vendors` WHERE vendorId=$user_ID GROUP BY serviceFeeAmount");
        return ($q->num_rows()  ? $q->result() : false);
    }


    public function delete_row($id, $user_ID) {
        $this->db->where('id', $id);
        $this->db->where('user_ID', $user_ID);
        $this->db->delete("tbl_export_services");
    }

    public function get_data($id) {
        $this->db->select('*')
            ->from('tbl_export_services')
            ->where('id', $id)
            ->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row();
        }

        return false;
    }

    public function get_services($user_ID,$accounting) {
        $this->db->select('tbl_export_services.id,external_id,tbl_export_services.service_id,external_code,user_ID,serviceFeeAmount,serviceFeeTax')
            ->from('tbl_export_services')
            ->join('tbl_shop_vendors', 'tbl_shop_vendors.id = tbl_export_services.service_id')
            ->where('user_ID', $user_ID)
            ->where('accounting', $accounting);
        $q = $this->db->get();

        if ($q->num_rows() >0) {
            return $q->result();
        }

        return false;
    }

    public function update($data) {

        $this->db->set('external_id', $data['external_id']);
        $this->db->set('external_code', $data['external_code']);
        $this->db->set('service_id', $data['service_id']);
        $this->db->set('accounting', $data['accounting']);
        $this->db->where('id', $data['id']);
        $this->db->where('user_ID', $data['user_ID']);
        $this->db->update('tbl_export_services');
        return $this->db->total_queries();
    }

}