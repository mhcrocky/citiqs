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
        $query = $this->db->get();
        $result = $query->result();
        return $result;
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

}
