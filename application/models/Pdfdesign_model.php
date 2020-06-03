<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pdfdesign_model extends CI_Model {

    public function insertTemplate($template) {
        $this->db->trans_start();
        $this->db->insert('tbl_pdf_templates', $template);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function loadTemplate($userId, $design_name) {
        $this->db->from('tbl_pdf_templates');
        $this->db->where("userId", $userId);
        $this->db->where("templateName", $design_name);
        $query = $this->db->get();
        return $query->result();
    }

    public function checkTemplate($userId, $design_name) {
        $this->db->where("userId", $userId);
        $this->db->where("templateName", $design_name);
        $this->db->from('tbl_pdf_templates');
        return $this->db->count_all_results();
    }

    public function updateTemplate($template, $userId, $design_name) {
        $this->db->trans_start();
        $this->db->where("userId", $userId);
        $this->db->where("templateName", $design_name);
        $this->db->update('tbl_pdf_templates', $template);
        $affected_rows = $this->db->affected_rows();
        $this->db->trans_complete();
        return $affected_rows;
    }

    public function getDefaultTemplate($userId) {
        $this->db->from('tbl_pdf_templates');
        $this->db->where("userId", $userId);
        $this->db->where("defaulttemplate", "1");
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllTemplatesByUser($userId) {
        $this->db->from('tbl_pdf_templates');
        $this->db->where("userId", $userId);
        $this->db->order_by("templateName", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function removeTemplateByName($templateName, $userId) {
        $this->db->where('templateName', $templateName);
        $this->db->where('userId', $userId);
        $this->db->delete('tbl_pdf_templates');
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }
    
    public function setTemplateDefault($templateName, $userId){
        $this->db->trans_start();
        $this->db->set("defaulttemplate", "0");
        $this->db->update('tbl_pdf_templates');
        
        $this->db->set("defaulttemplate", "1");
        $this->db->where("userId", $userId);
        $this->db->where("templateName", $templateName);
        $this->db->update('tbl_pdf_templates');
        $affected_rows = $this->db->affected_rows();
        $this->db->trans_complete();
        return $affected_rows;
    }

}
