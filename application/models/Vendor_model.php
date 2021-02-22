<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_model extends CI_Model
{

    public function getMenuOptions()
    {

        $query = $this->db->query("SELECT * FROM tbl_menu_options
        ORDER BY SUBSTRING_INDEX(SUBSTRING_INDEX(CONCAT(hierarchyNumber, '.'), '.', 1), '.', -1) + 0
        , SUBSTRING_INDEX(SUBSTRING_INDEX(CONCAT(hierarchyNumber, '.'), '.', 2), '.', -1) + 0
        , SUBSTRING_INDEX(SUBSTRING_INDEX(CONCAT(hierarchyNumber, '.'), '.', 3), '.', -1) + 0
        , SUBSTRING_INDEX(SUBSTRING_INDEX(CONCAT(hierarchyNumber, '.'), '.', 4), '.', -1) + 0");
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
