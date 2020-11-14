<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fodfdm_model extends CI_Model {

	function getlastRecieptCount($vendorId){
		$this->db->where('vendorId',$vendorId);
		$tbl_vendor_fodnumber_row = $this->db->get("tbl_vendor_fodnumber")->row();
		if(!empty($tbl_vendor_fodnumber_row)){
			return $tbl_vendor_fodnumber_row->lastNumber;
		}else{
			$a = array('vendorId' => $vendorId, 'lastNumber' => '0');
			$this->db->insert('tbl_vendor_fodnumber', $a);
			return 0;
		}
	}
	function updatelastRecieptCount($vendorId){
		$this->db->where('vendorId',$vendorId);
		$this->db->set('lastNumber', 'lastNumber+1', FALSE);
		$this->db->update('tbl_vendor_fodnumber');
	}///

	function updatePrinterStatus($macNumber,$flag){
		$this->db->where('macNumber',$macNumber);
		$this->db->where('active','1');
		$printerDetails =	$this->db->get("tbl_shop_printers")->row();
		// var_dump($printerDetails);die();
		if(!empty($printerDetails)){
		$this->insert_update_tbl_fdm_printer_status(
				array('printer_id' => $printerDetails->id,'FDM_active'=>$flag )
			);
		}
	}
	function insert_update_tbl_fdm_printer_status($data){
		$this->db->where('printer_id',$data['printer_id']);
		$fdmPrintStatus=$this->db->get("tbl_fdm_printer_status")->row();
		if(!empty($fdmPrintStatus)){
			$this->db->where("id",$fdmPrintStatus->id);
			$this->db->set('updated_at', 'DATE_ADD(NOW(), INTERVAL 1 MINUTE)', FALSE);
			$this->db->set('FDM_active',$data['FDM_active']);
			$this->db->update("tbl_fdm_printer_status");
		}else{
			$this->db->insert("tbl_fdm_printer_status",$data);
		}
	}
	function getFDMstatusByMac($macNumber){
		$this->db->where('tbl_shop_printers.macNumber',$macNumber);
		$this->db->where('tbl_shop_printers.active','1');
		$this->db->from("tbl_shop_printers");
		$this->db->join('tbl_fdm_printer_status', 'tbl_shop_printers.id = tbl_fdm_printer_status.printer_id');
		
		$printerDetails =	$this->db->get()->row();
		// print_r($this->db->last_query());
		return $printerDetails;
	}
}