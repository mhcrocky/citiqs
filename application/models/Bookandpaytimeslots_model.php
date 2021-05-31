<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Bookandpaytimeslots_model extends CI_Model
{
    public function getTimeSlot($id)
    {
        $this->db->select('tbl_bookandpaytimeslots.*, tbl_bookandpaytimeslots.available_items as timeslot_items, spot.price as spot_price, 
        spot.numberofpersons, spot.agenda_id, spot.descript as spot_descript, tbl_email_templates.template_name, tbl_email_templates.id as email_id');
        $this->db->from('tbl_bookandpaytimeslots');
        $this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpaytimeslots.email_id', 'left');
        $this->db->join('tbl_bookandpayspot as spot', 'spot.id = tbl_bookandpaytimeslots.spot_id', 'left');
        $this->db->where('tbl_bookandpaytimeslots.id', $id);
        $query = $this->db->get();

        if($query) {
            $result = $query->row();
            return $result;
        }

        return false;
    }

    public function addTimeSlot($data){
        $this->db->insert('tbl_bookandpaytimeslots', $data);
        return $this->db->insert_id();
    }

    public function updateTimeSlot ($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('tbl_bookandpaytimeslots', $data);
        return $this->db->affected_rows() || $id;
    }

    public function getTimeSlotsBySpotId ($spot_id) {
        $this->db->select('tbl_bookandpaytimeslots.*, tbl_email_templates.template_name');
        $this->db->from('tbl_bookandpaytimeslots');
        $this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpaytimeslots.email_id', 'left');
        $this->db->join('tbl_bookandpayspot as spot', 'spot.id = tbl_bookandpaytimeslots.spot_id', 'left');
        $this->db->where('tbl_bookandpaytimeslots.spot_id', $spot_id);
        $this->db->order_by("fromtime", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTimeSlotsByCustomerSpotId ($customer_id, $spot_id) {
        $this->db->select('tbl_bookandpaytimeslots.*, tbl_bookandpaytimeslots.id as timeslotId');
        $this->db->from('tbl_bookandpaytimeslots');
        $this->db->join('tbl_bookandpayspot', 'tbl_bookandpayspot.id = tbl_bookandpaytimeslots.spot_id', 'left');
        $this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
        $this->db->where('tbl_bookandpayagenda.Customer', $customer_id);
        $this->db->where('tbl_bookandpaytimeslots.spot_id', $spot_id);
        $this->db->order_by("fromtime", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    public function getTimeSlotsByCustomer ($customer_id, $spotId = false) {
        $this->db->select('tbl_bookandpaytimeslots.*, tbl_email_templates.template_name');
        $this->db->from('tbl_bookandpaytimeslots');
        $this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpaytimeslots.email_id', 'left');
        $this->db->join('tbl_bookandpayspot', 'tbl_bookandpayspot.id = tbl_bookandpaytimeslots.spot_id', 'left');
        $this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
        $this->db->where('tbl_bookandpayagenda.Customer', $customer_id);

        if($spotId) {
            $this->db->where('tbl_bookandpaytimeslots.spot_id', $spotId);
        }

        $query = $this->db->get();

        if($query) {
            return $query->result();
        }

        return false;
    }

    public function getTimeSlotsByCustomerAndSpot($customer_id, $spotId) {
        $this->db->select('tbl_bookandpaytimeslots.*,tbl_bookandpayspot.price, tbl_email_templates.template_name');
        $this->db->from('tbl_bookandpaytimeslots');
        $this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpaytimeslots.email_id', 'left');
        $this->db->join('tbl_bookandpayspot', 'tbl_bookandpayspot.id = tbl_bookandpaytimeslots.spot_id', 'left');
        $this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
        $this->db->where('tbl_bookandpayagenda.Customer', $customer_id);
        $this->db->where('tbl_bookandpaytimeslots.spot_id', $spotId);
        
        $query = $this->db->get();

        if($query) {
            return $query->result();
        }

        return false;
    }

    public function deleteTimeSLot ($id) {
        $this->db->where('id', $id);
        $this->db->delete('tbl_bookandpaytimeslots');
        return $this->db->affected_rows();
    }

    public function getPlanId($spotId)
    {
        $this->db->select('tbl_floorplan_details.id');
        $this->db->from('tbl_bookandpayspot');
        $this->db->join('tbl_floorplan_details', 'tbl_floorplan_details.id = tbl_bookandpayspot.spotLabelId', 'left');
        $this->db->join('tbl_floorplan_areas', 'tbl_floorplan_areas.floorplanID = tbl_floorplan_details.id', 'left');
        
        $this->db->where('tbl_bookandpayspot.id', $spotId);

        $query = $this->db->get();
        $result = $query->row();

        if (!empty($result)) {
            return $result->id;
        }

        return $query->result();
    }
    
}
