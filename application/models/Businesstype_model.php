<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Businesstype_model extends CI_Model
{
    public $id;
    public $busineess_type;
    public $view;

    private $table = 'tbl_business_types';

    public function getAll(): array
    {
        $this->db->select('*');
        $this->db->where('view',1);
        $results = $this->db->get($this->table);
        return $results->result_array();
    }
}
