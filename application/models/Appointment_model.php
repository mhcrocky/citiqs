<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_model extends CI_Model
{
    public $id;
    public $dayofweek;
    public $timefrom;
    public $timeto;
    public $userId;
    public $date;

    private $allowed_keys = ['id', 'dayofweek', 'timefrom', 'timeto', 'userId', 'date'];
    private $table = 'tbl_appointment';
    

    public function setId(int $id): Appointment_model
    {
        $this->id = $id;
        return $this;
    }

    public function setDayOfWeek(string $dayofweek): Appointment_model
    {
        $this->dayofweek = $dayofweek;
        return $this;
    }

    public function setTimeFrom(string $timefrom): Appointment_model
    {
        $this->timefrom = $timefrom;
        return $this;
    }

    public function setTimeTo(string $timeto): Appointment_model
    {
        $this->timeto = $timeto;
        return $this;
    }

    public function setUserId(int $userId): Appointment_model
    {
        $this->userId = $userId;
        return $this;
    }

    public function setDate(string $date): Appointment_model
    {
        $this->date = $date;
        return $this;
    }

    private function filterKeys(array &$data): void
    {
        $keys = array_keys($data);
        foreach ($keys as $key) {
            if (!in_array($key, $this->allowed_keys)) {
                unset($data[$key]);
            }
        }
    }

    private function isDuplicate(array $data): bool
    {
        $this->db->select('id');
        $this->db->from($this->table);
        foreach($data as $key => $value) {
            $this->db->where($key, $value);
        }
        $query = $this->db->get();
        return $query->num_rows() ? true : false;
    }

    public function insert(array $appointment): bool
    {
        $this->filterKeys($appointment);
        if ($this->isDuplicate($appointment)) return false;
        $this->db->insert($this->table, $appointment);
        $this->id = $this->db->insert_id();
        return $this->id ? true : false;
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

    public function getUserAppointments(): array
    {
        $this->db->where("userId", $this->userId);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }
}