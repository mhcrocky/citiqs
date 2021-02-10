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
    public $password;
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

    /*
    public function getEmployeeIdByEmail($email, $ownerId) {
        $this->db->select('id');
        $this->db->from('tbl_employee');
        $this->db->where("ownerId", $ownerId);
        $this->db->where("email", $employeeId);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result->id;
    }
    */

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

    public function getMenuHierarchyNumbers()
    {
        $this->db->select('*');
        $this->db->from('tbl_menu_options');
        $query = $this->db->get();
        $results = $query->result_array();
        $options = [];
        foreach($results as $result){
            $options[] = $result['hierarchyNumber'];
        }
        return $options;
    }

    public function getMenuOptionsByEmployee($userId)
    {
        $this->db->select('hierarchyNumber')
         ->from('tbl_user_allowed')
         ->join('tbl_menu_options', 'tbl_user_allowed.menuOptionId = tbl_menu_options.id', 'left')
         ->where('userId', $userId);
        $query = $this->db->get();
        $results = $query->result_array();
        $options = [];
        $secondOptions = [];
        $parents = [];
        foreach($results as $result){
            if (strpos($result['hierarchyNumber'], '.') !== false) {
                $arr = explode('.', $result['hierarchyNumber']);
                $parents[] = $arr[0];
                if(isset($arr[2])){
                    $secondOptions[] = $arr[0] . '.' . $arr[1];
                }
            }
            $options[] = $result['hierarchyNumber'];
        }

        $options = array_merge($options, $parents);
        $options = array_merge($options, $secondOptions);
        
        //$diff = array_diff($hierarchyMenu,$options);
        return array_unique($options);
    }

    public function saveMenuOptionsByEmployee($vendorId, $userId, $items)
    {
        $data = [];
        $menuOptions = [];
        if(isset($this->getMenuOptionsByVendor($vendorId)[$userId])){
            $menuOptions = array_keys($this->getMenuOptionsByVendor($vendorId)[$userId]);
        }

        $deleted_items = array_diff($menuOptions, $items);
        
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

    public function loginEmployee(): ?int
    {
        $id = $this->readImproved([
            'what' => [$this->table . '.id'],
            'where' => [
                $this->table . '.ownerId' => $this->ownerId,
                $this->table . '.password' => $this->password,
                $this->table . '.email' => $this->email,
            ]
        ]);

        if (is_null($id)) return $id;

        $id = reset($id);
        $id = intval($id['id']);

        return $id;
    }

    public function getMenuOptionEmployees(int $menuOptionId): ?array
    {
        return $this->readImproved([
            'what' => ['DISTINCT(' . $this->table . '.email) employeeEmail'],
            'where' => [
                $this->table . '.ownerId' => $this->ownerId,
                'tbl_user_allowed.menuOptionId' => $menuOptionId,
                $this->table . '.expiration_time > ' => time()
            ],
            'joins' => [
                ['tbl_user_allowed', 'tbl_user_allowed.vendorId = '. $this->table . '.ownerId', 'INNER']
            ],
            'conditstion' => [
                'ORDER_BY' => [$this->table . '.email', 'ASC']
            ]
        ]);
    }
}
