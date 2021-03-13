<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Email_templates_model extends CI_Model
{

    public function add_email_template ($data)
    {
        $this->db->insert('tbl_email_templates', $data);
        return $this->db->insert_id();
    } 

    public function get_emails_by_user ($user_id) {
        $this->db->from('tbl_email_templates');
        $this->db->where('user_id', $user_id);
        $this->db->not_like('template_name', 'ticketing_');
        $this->db->not_like('template_name', 'voucher_');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_ticketing_email_by_user ($user_id) {
        $this->db->from('tbl_email_templates');
        $this->db->where('user_id', $user_id);
        $this->db->like('template_name', 'ticketing_');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_voucher_email_by_user ($user_id) {
        $this->db->from('tbl_email_templates');
        $this->db->where('user_id', $user_id);
        $this->db->like('template_name', 'voucher_');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->first_row();
            return $result;
        }
        return false;
        
    }

    public function get_emails_by_id ($id) {
        $this->db->from('tbl_email_templates');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function deleteEmail ($id) {
        $this->db->where('id', $id);
        $this->db->delete('tbl_email_templates');
        return $this->db->affected_rows();
    }

    public function update_email_template ($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('tbl_email_templates', $data);
        return $this->db->affected_rows() || $id;
    }

    public function get_emails_by_name ($name) {
        $this->db->from('tbl_email_templates');
        $this->db->where('template_name', $name);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['id'];
    }

    public function get_emails_by_user_and_name ($user_id, $name) {
        $this->db->from('tbl_email_templates');
        $this->db->where(array('user_id' => $user_id ,'template_name' => $name));
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function check_template_exists($name, $user_id)
    {
        $query = $this->db->get_where('tbl_email_templates', array('template_name' => $name, 'user_id' => $user_id));
        if (!empty($query->result_array())) {
            return true;
        } else {
            return false;
        }
    }

}
