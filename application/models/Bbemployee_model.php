<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Bbemployee_model extends CI_Model
{
	function getEmployeeByMac($macNumber){
		$this->db->where('tbl_shop_printers.macNumber',$macNumber);
		$this->db->where('tbl_shop_printers.active','1');
		$this->db->from("tbl_shop_printers");
		$this->db->join('tbl_fdm_printer_status', 'tbl_shop_printers.id = tbl_fdm_printer_status.printer_id');
		
		$printerDetails =	$this->db->get()->row();
//		print_r($this->db->last_query());
//		var_dump($macNumber);
//		die();
		if(isset($printerDetails->userId) && $printerDetails->userId!=0){
			return $this->getemployee($printerDetails->userId);
		}
		// return $printerDetails;
	}
	public function getemployee($userId): ?object
	{
		$this->load->model('employee_model');
		return $this->employee_model->setProperty('ownerId', $userId)->getEmployeeForBB();
	}
	function updateemployeenext($id,$next){
		$this->db->where("id",$id);
		$this->db->set('next',$next);
		$this->db->update('tbl_employee');
	}
}
