<?php
    declare(strict_types=1);

    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    Abstract Class AbstractCrud_model extends CI_Model
    {
   
        abstract protected function getThisTable(): string;

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }
        
        private function getDataArrayForDatabase(): ?array
        {
            $data = get_object_vars($this);
            foreach($data as $key => $value) {
                if ($key === 'id' || (!$value && !Validate_data_helper::validateNumber($value))) {
                    unset($data[$key]);
                }
            }
            return $data ? $data : null;
        }

        public function create(): bool
        {
            $data = $this->getDataArrayForDatabase();
            if (!$data) return false;
            $this->db->insert($this->getThisTable(), $data);
            $this->id  = $this->db->insert_id();
            return $this->id ? true : false;
        }

        public function multipleCreate(array $data) : ?int
        {
            $insert = $this->db->insert_batch($this->getThisTable(), $data);
            return $insert ? $insert : null;
        }

        public function read(array $what, array $where, array $join = [], string $condition = '', array $conditionArguments = []): ?array
        {
            $result = $this->db->select(implode(',', $what));
            if (count($join) ) {
                foreach ($join as $data) {
                    $this->db->join(...$data);
                }
            }
            $result = $this->db->where($where);
            if ($condition) {                
                $result = $this->db->$condition(...$conditionArguments);
            }
            $result = $this->db->get($this->getThisTable())->result_array();
            return $result ? $result : null;
        }

        public function update(): bool
        {
            $data = $this->getDataArrayForDatabase();
            if (!$data) return false;
            $where = ' id = ' . $this->id;
            return $this->db->update($this->getThisTable(), $data, $where);
        }

        public function delete(): bool
        {
            $where = [
                'id' => $this->id
            ];
            $this->db->delete($this->getThisTable(), $where);
            return $this->db->affected_rows() ? true : false;
        }

    }
