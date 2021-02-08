<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Uniquecode_model extends CI_Model
    {
        public $id;
        public $code;
        public $bagid;
        public $timestamp;

        private $table = 'tbl_uniquecodes';

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

        public function select(array $what, array $where, array $join = [], string $condition = '', array $conditionArguments = []): ?array
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
            $result = $this->db->get($this->table)->result_array();
            return $result ? $result : null;
        }

        public function update(array $data): bool
        {
            $where = ' id = ' . $this->id;
            $this->db->update($this->table, $data, $where);
            return $this->db->affected_rows() ? true : false;
        }

        public function delete(): bool
        {
            $where = [
                'id' => $this->id
            ];
            $this->db->delete($this->getThisTable(), $where);
            return $this->db->affected_rows() ? true : false;
        }

        public function insertAndSetCode(string $prefix = 'U'): void
        {
            $data = [];
            do {
                $set = '3456789abcdefghjkmnpqrstvwxyABCDEFGHJKLMNPQRSTVWXY';
                $data = [
                    'timestamp' => date('Y-m-d H:i:s'),
                    'code' => $prefix . '-' . substr(str_shuffle($set), 0, 8),
                ];
            } while (!$this->insert($data));
            $this->code = $data['code'];
        }

		public function STPVersion2()
		{
			$data = [];
			do {
				$set = '3456789BCDEFGHJKLMNPQRSTVWXY';
				$data = [
					'timestamp' => date('Y-m-d H:i:s'),
					'code' => 'SPOT-' . substr(str_shuffle($set), 0, 8),
				];
			} while (!$this->insert($data));
			return $data['code'];
		}

		public function tablesticker()
		{
			$data = [];
			do {
				$set = '3456789BCDEFGHJKLMNPQRSTVWXY';
				$data = [
					'timestamp' => date('Y-m-d H:i:s'),
					'code' => 'TABLE-' . substr(str_shuffle($set), 0, 8),
				];
			} while (!$this->insert($data));
			return $data['code'];
		}

    }
