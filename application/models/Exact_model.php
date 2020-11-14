<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exact_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * save_provider
     *
     * @param array $data
     * @return bool
     *
     */

    public function get_auth_data($ID) {
        return $this->db->query("SELECT exact_auth from tbl_export_setting WHERE `user_ID` ='".$ID."'")->row()->exact_auth;
    }

    public function set_auth_data($data) {
        $this->db->select("*")
            ->from('tbl_export_setting')
            ->where('user_ID', $this->session->userdata('userId'))
            ->limit(1);
        $q = $this->db->get();
        if($q->num_rows()==1){
            $this->db->where('user_ID', $this->session->userdata('userId'))->update('tbl_export_setting', array('exact_auth' => $data));
            return $this->db->affected_rows();
        }else{
            return $this->db->insert('tbl_export_setting', ['exact_option'=>1,'user_ID'=>$this->session->userdata('userId'),'exact_auth' => $data]);
        }
    }

    public function get_settings($ID) {
        return $this->db->query("SELECT option_exact from tbl_export_setting WHERE `user_ID` ='".$ID."'")->row();
    }

    public function get_exact_settings($ID) {
        return $this->db->query("SELECT * from tbl_export_setting WHERE `user_ID` ='".$ID."'")->row();
    }

    public function get_data($user_ID)
    {
        $this->db->select("*")
            ->from('tbl_export_setting')
            ->where('user_ID', (int) $user_ID)
            ->limit(1);

        $q = $this->db->get();
        return ($q->num_rows() == 1 ? $q->row() : false);
    }

    public function update_order_export_status($order_id, $export_id)
    {
        $this->db->set('export_id', ($export_id))->where('id', (int) $order_id)->update('tbl_shop_orders');
        return $this->db->total_queries();
    }

    public function update_exact_settings($user_ID, $data)
    {
        $this->db->set('exact_year', trim($data['exact_year']));
        $this->db->set('exact_division', trim($data['exact_division']));
        $this->db->set('exact_journal', trim($data['exact_journal']));

        $this->db->where('user_ID', (int) $user_ID);
        $this->db->update('tbl_export_setting');

        $result = $this->db->total_queries();
        return $result;
    }
}