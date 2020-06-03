<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    public function getOwnerEmployees($ownerId) {
        $this->db->from('tbl_employee');
        $this->db->where("ownerId", $ownerId);
        $query = $this->db->get();
        return $query->result();
    }

	public function getTokenEmployees($token, $ownerid) {
		$this->db->from('tbl_employee');
		$this->db->where("ownerId", $ownerid);
		$this->db->where("uniquenumber", $token);
		$query = $this->db->get();
		return $query->result();
	}

    public function addNewEmployee($employee) {
        $this->db->trans_start();
        $this->db->insert('tbl_employee', $employee);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getEmployeeById($employeeId, $ownerId) {
        $this->db->from('tbl_employee');
        $this->db->where("ownerId", $ownerId);
        $this->db->where("id", $employeeId);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateEmployee($employee, $employeeId) {
        $this->db->trans_start();
        $this->db->where("id", $employeeId);
        $this->db->update('tbl_employee', $employee);
        $affected_rows = $this->db->affected_rows();
        $this->db->trans_complete();
        return $affected_rows;
    }

    public function deleteEmployeeById($employeeid) {
        $this->db->where('id', $employeeid);
        $this->db->delete('tbl_employee');
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    public function getEmployeeIdByEmail($email, $ownerId) {
        $this->db->select('id');
        $this->db->where('email', $email);
        $this->db->where("ownerId", $ownerId);
        $this->db->from('tbl_employee');
        $query = $this->db->get();
        return $query->result();
    }

    public function getEmployee(array $what, array $where)
    {
        $this->db->select(implode(',', $what));
        $this->db->where($where);
        $this->db->from('tbl_employee');
        $query = $this->db->get();
        return $query->result();
    }
}