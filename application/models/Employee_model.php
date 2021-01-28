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

    public function getMenuOptions()
    {
        $this->db->select('*');
        $this->db->from('tbl_menu_options');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function saveMenuOptionsByEmployee($vendorId, $userId, $items)
    {
        $data = [];
        $menuOptions = array_keys($this->getMenuOptionsByVendor($vendorId)[$userId]);
        $deleted_items = array_diff($menuOptions, $items);
        var_dump($deleted_items);
        foreach($items as $item){
            $menuOptionId = $item;
            $data = [
                'vendorId' => $vendorId,
                'userId' => $userId,
                'menuOptionId' => $menuOptionId
            ];
            $exists = $this->checkIfMenuOptionExistsByUser($userId, $vendorId, $menuOptionId);
            if(!$exists){
                $this->db->insert('tbl_user_allowed', $data);
            }
            
        }
        foreach($deleted_items as $deleted_item){
            $this->db->where([
                'userId' => $userId,
                'vendorId'=> $vendorId,
                'menuOptionId' => $deleted_item
                ]);
            $this->db->delete('tbl_user_allowed');
        }
        return true;
    }

    public function checkIfMenuOptionExistsByUser($userId, $vendorId, $menuOptionId)
    {
        $this->db->select('*')
             ->from('tbl_user_allowed')
             ->where([
                 'userId' => $userId,
                 'vendorId'=> $vendorId,
                 'menuOptionId' => $menuOptionId
                 ]);
        $query = $this->db->get();
        $results = $query->result_array();
        if(count($results) > 0 ){
            return true;
        }
        return false;
    }

    public function getMenuOptionsByVendor($vendorId)
    {
        $this->db->select('tbl_user_allowed.id as allowedId, menuOptionId, menuOption, userId')
         ->from('tbl_user_allowed')
         ->join('tbl_menu_options', 'tbl_user_allowed.menuOptionId = tbl_menu_options.id', 'left')
         ->where('vendorId', $vendorId);
        $query = $this->db->get();
        $results = $query->result_array();
        $options = [];
        if(count($results) > 0){
            foreach($results as $key => $result){
                $userId = $result['userId'];
                $optionId = $result['menuOptionId'];
                $options[$userId][$optionId] = $result;
            }
        }

        return $options;
    }

    public function getEmployeeForBB()
    {
        // get for bb

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

    public function getActiveEmployeeForBB()
    {
        $result = $this->readImproved([
            'what' => [
                $this->table . '.id',
                $this->table . '.username',
                $this->table . '.email'
            ],
            'where' => [
                $this->table . '.ownerId=' => $this->ownerId,
                $this->table . '.expiration_time > ' => time(),
            ],
            'joins' => [
                ['tbl_vendor_fodnumber', 'tbl_vendor_fodnumber.vendorId = ' .  $this->table . '.ownerId', 'INNER'],
            ]
        ]);

        if (empty($result)) return null;

        return $result;
    }
}
