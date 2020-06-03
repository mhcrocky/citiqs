<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Music_model extends CI_Model
    {

        private $table = 'tbl_music';

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }
        
        public function insert(array $data): bool
        {
            $this->db->insert($this->table, $data);
            $this->id  = $this->db->insert_id();
            return $this->id ? true : false;
        }

    }
