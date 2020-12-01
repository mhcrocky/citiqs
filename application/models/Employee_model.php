<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
require_once APPPATH . 'abstract/AbstractSet_model.php';

class Employee_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
{
    public $id;
    public $username;
    public $email;
    public $uniquenumber;
    public $ownerId;
    public $validitytime;
    public $expiration_time;
    public $expiration_time_value;
    public $expiration_time_type;
    public $next;
    public $INSZnumber;


    private $table = 'tbl_employee';

    protected function setValueType(string $property,  &$value): void
    {
        $this->load->helper('validate_data_helper');
        if (!Validate_data_helper::validateNumber($value)) return;

        if ($property === 'id' || $property === 'ownerId') {
            $value = intval($value);
        }

        return;
    }

    protected function getThisTable(): string
    {
        return $this->table;
    }
    public function insertValidate(array $data): bool
    {
        // TO DO SET CONDITIONS
        return $this->updateValidate($data);
    }

    public function updateValidate(array $data): bool
    {
        // TO DO SET CONDITIONS
        return true;
    }


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
        return ($affected_rows > 0) ? $affected_rows : 0;
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

    public function getEmployeeForBB()
    {

        $result = $this->readImproved([
            'what' => [
                $this->table . '.id',
                $this->table . '.username',
                $this->table . '.email',
                $this->table . '.uniquenumber',
                $this->table . '.ownerId',
                $this->table . '.validitytime',
                $this->table . '.expiration_time',
                $this->table . '.expiration_time_value',
                $this->table . '.expiration_time_type',
                $this->table . '.next',
                $this->table . '.INSZnumber',
                'tbl_employee_inout.id AS inOutId',
                'tbl_employee_inout.inOutEmployee AS action',
                'tbl_employee_inout.inOutDateTime'
            ],
            'where' => [
                $this->table . '.ownerId=' => $this->ownerId,
                'tbl_employee_inout.processed=' => '0'
            ],
            'joins' => [
                ['tbl_employee_inout', 'tbl_employee_inout.employeeId = ' .  $this->table . '.id', 'INNER'],
            ],
            'conditions' => [
                'ORDER_BY' => ['tbl_employee_inout.id ASC'],
                'LIMIT' => ['1'],
            ]
        ]);

        if (empty($result)) return null;

        $result = reset($result);
        $result = (object) $result;

        return $result;
    }
}