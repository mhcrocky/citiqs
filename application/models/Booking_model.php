<?php
declare (strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model
{
    public $id;
    public $appointmentId;
    public $userclaimId;
    public $labelId;
    public $active;

    private $table = 'tbl_booking';

    public function setId(int $id): Booking_model
    {
        $this->id = $id;
        return $this;
    }

    public function setAppointmentId(int $appointmentId): Booking_model
    {
        $this->appointmentId = $appointmentId;
        return $this;
    }

    public function setUserclaimId(int $userclaimId): Booking_model
    {
        $this->userclaimId = $userclaimId;
        return $this;
    }

    public function setLabelId(int $labelId): Booking_model
    {
        $this->labelId = $labelId;
        return $this;
    }

    public function setActive(int $active): Booking_model
    {
        $this->active = $active;
        return $this;
    } 
    public function checkBookingByAppointmentId(): int
    {
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where("appointmentId", $this->appointmentId);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function insert(array $booking): bool
    {
        $this->db->insert($this->table, $booking);
        $this->id = $this->db->insert_id();
        return $this->id ? true:false;
    }

    public function update($update): bool
    {
        $this->db->where("id", $this->id);
        $this->db->update($this->table, $update);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows ? true : false;
    }

    public function delete(): bool
    {
        $this->db->where('id', $this->id);
        $this->db->delete($this->table);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows ? true : false;
    }

    public function getClaimerBookings(): ?array
    {
        $appointments = [];
        $result =   $this->db->select( 
                        $this->table . '.id, ' .
                        $this->table . '.appointmentId,' .
                        'tbl_appointment.date, tbl_appointment.dayofweek, tbl_appointment.timefrom, tbl_appointment.timeto'
                    )
                    ->join('tbl_appointment', $this->table.'.appointmentId = tbl_appointment.id', 'INNER')
                    ->where($this->table.'.userclaimId=', $this->userclaimId)
                    ->where($this->table.'.labelId=', $this->labelId)
                    ->where($this->table.'.active=', $this->active)
                    ->get($this->table)
                    ->result_array();
        return $result;
    }
}
