<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Spot_model extends CI_Model
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

		public function getItem($qrcode) {
			$this->db->select('*');
			$this->db->from('tbl_bookandpay');
			$this->db->where("reservationId", $qrcode);
			$query = $this->db->get();
//			$lastquery = $this->db->last_query();
			$result = $query->row();
			return $result;
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
				$set = '3456789abcdefghjkmnpqrstvwxyABCDEFGHJKLMNPQRSTVWXY';
				$data = [
					'timestamp' => date('Y-m-d H:i:s'),
					'code' => 'S2-' . substr(str_shuffle($set), 0, 8),
				];
			} while (!$this->insert($data));
			return $data['code'];
		}
    }
