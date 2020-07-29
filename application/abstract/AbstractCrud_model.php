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
                if ($key === 'id' || is_null($value) || is_bool($value)) {
                    unset($data[$key]);
                }
            }
            return $data ? $data : null;
        }

        public function create(): bool
        {
            $data = $this->getDataArrayForDatabase();
            if (!$data || !$this->insertValidate($data)) return false;
            $this->db->insert($this->getThisTable(), $data);
            $this->id  = $this->db->insert_id();
            return $this->id > 0 ? true : false;
        }

        public function multipleCreate(array $data) : ?int
        {
            $insert = $this->db->insert_batch($this->getThisTable(), $data);
            return $insert ? $insert : null;
        }

        public function read(array $what, array $where = null, array $join = [], string $condition = '', array $conditionArguments = []): ?array
        {
            $result = $this->db->select(implode(',', $what));
            if (count($join) ) {
                foreach ($join as $data) {
                    $this->db->join(...$data);
                }
            }

            if ($where) {
                $result = $this->db->where($where);
            }

            if ($condition) {                
                $result = $this->db->$condition(...$conditionArguments);
            }
            $result = $this->db->get($this->getThisTable())->result_array();
            return $result ? $result : null;
        }

        public function readImproved(array $filter, int $querylogging = 0): ?array
        {
            $result = $this->db->select(implode(',', $filter['what']));
            if (isset($filter['joins']) && count($filter['joins']) ) {
                $joins = $filter['joins'];
                foreach ($joins as $join) {
                    $this->db->join(...$join);
                }
            }
            $result = $this->db->where($filter['where']);

            if (isset($filter['conditions'])) {
                $conditions = $filter['conditions'];
                foreach ($conditions as $order => $arguments) {
                    $result = $this->db->$order(...$arguments);
                }
            }
            // $result = $this->db->get($this->getThisTable());
            // echo $this->db->last_query(); die();
            $result = $this->db->get($this->getThisTable())->result_array();

            if ($querylogging === 1) {
				$file = FCPATH . 'application/tiqs_logs/querylogging.txt';
				Utility_helper::logMessage($file, $this->db->last_query());
			}

			return $result ? $result : null;
        }

        public function update(): bool
        {
            $data = $this->getDataArrayForDatabase();
            if (!$data || ! $this->updateValidate($data)) return false;
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
