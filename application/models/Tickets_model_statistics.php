<?php
declare(strict_types=1);

require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
require_once APPPATH . 'abstract/AbstractSet_model.php';

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tickets_model_statistics extends CI_Model
{
        private $table = 'tbl_bookandpay';

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function fetchTicketsForStatistics(string $from = '', $to = ''): ?array
        {
			$select =   array(
				'sum(numberofpersons) * 0.90 as totalfee'
			);
			$this->db->select($select);
			$this->db->from('tbl_bookandpay');
			$this->db->where('paid', '1', );
			$this->db->where('SpotId', '0', );
			$this->db->where('bookdatetime >=', date_create($from)->format('Y-m-d H:i:s'));
			$this->db->where('bookdatetime <=', date_create($to)->format('Y-m-d H:i:s'));
			$this->db->where('customer <>', '43533' );
			$this->db->where('customer <>', '45330' );
			$query = $this->db->get();

			$result1 = $query->row();
//			$returnjson = array($result1);

			$select =   array(
				'*',
				'paid as paymentfee'
			);

			$this->db->select($select);
			$this->db->from('tbl_bookandpay');
			$this->db->where('paid', '1', );
			$this->db->where('SpotId', '0', );
			$this->db->where('bookdatetime >=', date_create($from)->format('Y-m-d H:i:s'));
			$this->db->where('bookdatetime <=', date_create($to)->format('Y-m-d H:i:s'));
			$this->db->where('customer <>', '43533' );
			$this->db->where('customer <>', '45330' );
			$this->db->group_by('TransactionID');

//			$query = $this->db->count_all_results();
			$query = $this->db->get();
			$result2 = $query->num_rows()*0.50;
//			$result2 = $query->result();

			$select =   array(
				'sum(numberofpersons) * 0.70 as reservationfee'
			);
			$this->db->select($select);
			$this->db->from('tbl_bookandpay');
			$this->db->where('paid', '1', );
			$this->db->where('SpotId <>', '0', );
			$this->db->where('bookdatetime >=', date_create($from)->format('Y-m-d H:i:s'));
			$this->db->where('bookdatetime <=', date_create($to)->format('Y-m-d H:i:s'));
			$this->db->where('customer <>', '43533' );
			$this->db->where('customer <>', '45330' );
			$query = $this->db->get();

			$result3 = $query->result();

			$select =   array(
				'*',
				'paid as paymentfee'
			);

			$this->db->select($select);
			$this->db->from('tbl_bookandpay');
			$this->db->where('paid', '1', );
			$this->db->where('SpotId <>', '0', );
			$this->db->where('bookdatetime >=', date_create($from)->format('Y-m-d H:i:s'));
			$this->db->where('bookdatetime <=', date_create($to)->format('Y-m-d H:i:s'));
			$this->db->where('customer <>', '43533' );
			$this->db->where('customer <>', '45330' );
			$this->db->group_by('TransactionID');

//			$query = $this->db->count_all_results();
			$query = $this->db->get();
			$result4 = $query->num_rows()*0.50;






			$returnjson = array($result1, $result2, $result3, $result4);

			return $returnjson;

        }

		public function fetchReservationsForStatistics(string $from = '', $to = ''): ?array
		{
			$select =   array(
				'sum(numberofpersons) * 0.90 as totalfee'
			);
			$this->db->select($select);
			$this->db->from('tbl_bookandpay');
			$this->db->where('paid', '1', );
			$this->db->where('SpotId <>', '0', );
			$this->db->where('bookdatetime >=', date_create($from)->format('Y-m-d H:i:s'));
			$this->db->where('bookdatetime <=', date_create($to)->format('Y-m-d H:i:s'));
			$this->db->where('customer <>', '43533' );
			$this->db->where('customer <>', '45330' );
			$query = $this->db->get();

			$result = $query->result();
			return $result;

		}

    }
