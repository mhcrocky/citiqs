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
            $this->load->helper('validate_data_helper');

            $data = get_object_vars($this);
            foreach($data as $key => $value) {
                
                if ($key === 'id' || (!$value && !Validate_data_helper::validateNumber($value))) {
                    unset($data[$key]);
                }
            }
            return $data ? $data : null;
        }

        private function getDataArrayForDatabaseUpdate(): ?array
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

        public function prepareInsertQuery(array $data): string
        {
            $keys = array_keys($data);
            $values = array_values($data);
            $escapeValues = array_map(function($value) {
                return $this->db->escape($value);
            }, $values);

            $query  = 'INSERT INTO ' . $this->getThisTable() . ' ';
            $query .= ' (' . implode(',' , $keys) . ')  VALUES (' . implode(',', $escapeValues) . ') ';
            $query .= ' ON DUPLICATE KEY UPDATE ';

            foreach ($keys as $index => $key) {
                $query .= $key . ' = ' . $escapeValues[$index] . ',';
                
            }
            $query = rtrim($query, ',') . ';';

            return $query;
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
            if (isset($filter['escape'])) {
                $result = $this->db->select(implode(',', $filter['what']), $filter['escape']);
            } else {
                $result = $this->db->select(implode(',', $filter['what']));
            }

            if (isset($filter['joins']) && count($filter['joins']) ) {
                $joins = $filter['joins'];
                foreach ($joins as $join) {
                    $this->db->join(...$join);
                }
            }

            if (!empty($filter['where'])) {
                $result = $this->db->where($filter['where']);
            }

            if (!empty($filter['whereIn'])) {
                $whereIn = $filter['whereIn'];
                $result = $this->db->where_in($whereIn['column'], $whereIn['array']);
            }

            if (isset($filter['conditions'])) {
                $conditions = $filter['conditions'];
                foreach ($conditions as $order => $arguments) {
                    $result = $this->db->$order(...$arguments);
                }
            }
            // $result = $this->db->get($this->getThisTable());
            // echo $this->db->last_query(); die();
            $result = $this->db->get($this->getThisTable())->result_array();

            $querylogging=0;
            if ($querylogging === 1) {
                $file = FCPATH . 'application/tiqs_logs/querylogging.txt';
                $this->load->helper('utility_helper');
				Utility_helper::logMessage($file, $this->db->last_query());
			}

			return $result ? $result : null;
        }

        public function update(): bool
        {
            $data = $this->getDataArrayForDatabaseUpdate();
            if (!$data || !$this->updateValidate($data)) return false;
            $where = ' id = ' . $this->id;
            return $this->db->update($this->getThisTable(), $data, $where);
        }

        public function multipleUpdate($ids, $where): bool
        {
            $data = $this->getDataArrayForDatabaseUpdate();
            if (!$data || !$this->updateValidate($data)) return false;
            $this->db->where_in('id', $ids);
            return $this->db->update($this->getThisTable(), $data, $where);
        }

        public function customUpdate(array $where): bool
        {
            $data = $this->getDataArrayForDatabaseUpdate();

            if (!$data || !$this->updateValidate($data)) return false;

            $this->db->update($this->getThisTable(), $data, $where);

            $affectedRows = $this->db->affected_rows();

            return $affectedRows > 0 ? true : false;
        }

        public function delete(): bool
        {
            $where = [
                'id' => $this->id
            ];
            $this->db->delete($this->getThisTable(), $where);
            return $this->db->affected_rows() ? true : false;
        }

        public function multipleDelete($ids, $where): bool
        {
            $this->db->where_in('id', $ids);
            $this->db->delete($this->getThisTable(), $where);
            return $this->db->affected_rows() ? true : false;
        }

        public function getProperty(string $property)
        {
            $result = $this->readImproved([
                'what'  => [$property],
                'where' => [
                    'id' => $this->id,
                ]
            ]);
            if (!empty($result)) {
                return $result[0][$property];
            }
            return null;
        }

        public function customDelete(array $where): bool
        {
           	// $text = 'Abstract CRUD delete';
           	// var_dump($where);
			// echo $this->getThisTable();
            $this->db->delete($this->getThisTable(), $where);
            // echo $this->db->last_query;
			// die();
            return $this->db->affected_rows() ? true : false;
        }

        public function customDeleteTest(array $where): bool
        {
            var_dump($where);
            

           	// $text = 'Abstract CRUD delete';
           	// var_dump($where);
			// echo $this->getThisTable();
            $this->db->delete($this->getThisTable(), $where);
            echo $this->db->last_query();
            var_dump($this->db->affected_rows());
			die();
            return $this->db->affected_rows() ? true : false;
        }

    }
