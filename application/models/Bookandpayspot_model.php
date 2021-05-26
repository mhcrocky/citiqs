<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bookandpayspot_model extends CI_Model
{
    public function getSpot($id)
    {
        $this->db->select('tbl_bookandpayspot.*, tbl_bookandpayagenda.ReservationDateTime,
         tbl_bookandpayagenda.Background as background, tbl_bookandpayagenda.Customer, tbl_email_templates.template_name, tbl_email_templates.id as email_id');
        $this->db->from('tbl_bookandpayspot');
        $this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
        $this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpayspot.email_id', 'left');
        $this->db->where('tbl_bookandpayspot.id', $id);
        $query = $this->db->get();

        if ($query) {
            return $query->row();
        }

        return false;
    }

    public function addSpot($data)
    {
        $this->db->insert('tbl_bookandpayspot', $data);
        return $this->db->insert_id();
    }

    public function updateSpot($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_bookandpayspot', $data);
        return $this->db->affected_rows() || $id;
    }

    public function updateSpotOrder($order, $id)
    {
        $this->db->set('sort_order', $order);
        $this->db->where('id', $id);
        $this->db->update('tbl_bookandpayspot');
        return true;
    }

    public function getSpotsByCustomer($customer_id, $agendaId = false)
    {
        $this->db->select('tbl_bookandpayspot.*, tbl_bookandpayagenda.ReservationDateTime, tbl_bookandpayagenda.Background as background, tbl_email_templates.template_name ');
        $this->db->from('tbl_bookandpayspot');
        $this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
        $this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpayspot.email_id', 'left');
        $this->db->where('tbl_bookandpayagenda.Customer', $customer_id);
        $this->db->order_by('tbl_bookandpayspot.sort_order');

        if($agendaId) {
            $this->db->where('tbl_bookandpayagenda.id', $agendaId);
        }

        $query = $this->db->get();

        if ($query) {
            return $query->result();
        }

        return false;
    }

    public function getSpotsById($spot_id)
    {
        $this->db->select('tbl_bookandpayspot.*, tbl_bookandpayagenda.ReservationDateTime, tbl_bookandpayagenda.Background as background, tbl_email_templates.template_name ');
        $this->db->from('tbl_bookandpayspot');
        $this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
        $this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpayspot.email_id', 'left');
        $this->db->where('tbl_bookandpayspot.id', $spot_id);

        $query = $this->db->get();

        if ($query) {
            return $query->result();
        }

        return false;
    }

    public function getMaxPersonsPerDay($customer_id)
    {
        $this->db->select('SUM(tbl_bookandpayspot.numberofpersons) AS max_persons_per_day');
        $this->db->from('tbl_bookandpayspot');
        $this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
        $this->db->where('tbl_bookandpayagenda.Customer', $customer_id);
        $query = $this->db->get();

        if ($query) {
            $result = $query->result();

            if(isset($result[0])) {
                return $result[0]->max_persons_per_day;
            }
        }

        return 0;
    }

    public function getAllSpots($customer_id)
    {
        $this->db->select('
            tbl_bookandpayspot.id,
            tbl_bookandpayspot.*,
            tbl_bookandpaytimeslots.reservationFee,
            tbl_bookandpaytimeslots.price timeSlotPrice
        ');
        $this->db->from('tbl_bookandpayspot');
        $this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
        $this->db->join('tbl_bookandpaytimeslots', 'tbl_bookandpaytimeslots.spot_id = tbl_bookandpayspot.id', 'left');
        $this->db->where('tbl_bookandpayagenda.Customer', $customer_id);
        $this->db->order_by('sort_order', 'asc');
        $query = $this->db->get();

        if ($query) {
            return $query->result();
        }

        return false;
    }

    public function getSpotsByAgenda($agenda_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_bookandpayspot');
        $this->db->where('tbl_bookandpayspot.agenda_id', $agenda_id);
        $query = $this->db->get();

        if ($query) {
            return $query->result();
        }

        return false;
    } 

    public function getAgendaBySpotId($spot_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_bookandpayspot');
        $this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
        $this->db->where('tbl_bookandpayspot.id', $spot_id);
        $query = $this->db->get();

        if ($query) {
            return $query->result()[0];
        }

        return false;
    }

    public function deleteSpot($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_bookandpayspot');
        return $this->db->affected_rows();
    }

    public function getSpotsLabel($userId)
    {
        $this->db->select('tbl_floorplan_areas.id,tbl_floorplan_areas.area_label,tbl_floorplan_areas.area_count');
        $this->db->from('tbl_floorplan_areas');
        $this->db->join('tbl_floorplan_details', 'tbl_floorplan_details.id = tbl_floorplan_areas.floorplanID', 'left');
        $this->db->join('tbl_spot_objects', 'tbl_spot_objects.id = tbl_floorplan_details.spot_object_id', 'left');
        $this->db->where('tbl_spot_objects.userId', $userId);

        $query = $this->db->get();

        if ($query) {
            return $query->result();
        }

        return false;
    }
}
