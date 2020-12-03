<?php
declare(strict_types=1);

require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
require_once APPPATH . 'abstract/AbstractSet_model.php';

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fodfdm_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
{

	public $id;
	public $printer_id;
	public $FDM_active;
	private $table = 'tbl_fdm_printer_status';

	protected function setValueType(string $property,  &$value): void
	{
		$this->load->helper('validate_data_helper');
		if (!Validate_data_helper::validateNumber($value)) return;

		if ($property === 'id' || $property === 'printer_id') {
			$value = intval($value);
		}

		return;
	}

	protected function getThisTable(): string
	{
		return $this->table;
	}

	public function insertValidate(array $data): bool
	{
		if (isset($data['printer_id']) && isset($data['FDM_active'])) {
			return $this->updateValidate($data);
		}
		return false;
	}

	public function updateValidate(array $data): bool
	{
		if (!count($data)) return false;
		if (isset($data['printer_id']) && !Validate_data_helper::validateInteger($data['printer_id'])) return false;
		if (isset($data['FDM_active']) && !($data['showInPublic'] === 1 || $data['showInPublic'] === 0)) return false;

		return true;
	}

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

	public function isActive(): ?bool
	{
		$activeStatus = $this->readImproved([
			'what'	=> [$this->table . '.FDM_active'],
			'where'	=> [
				$this->table. '.printer_id' => $this->printer_id,
			],
			'conditions' => [
				'ORDER_BY' => [$this->table . '.id ASC'],
				'LIMIT' => ['1']
			]
		]);
		if (is_null($activeStatus)) return null;
		$activeStatus = intval($activeStatus[0]['FDM_active']);

		// if activeStatus is 0 everything is OK, else we have an error => updated from black box
		return !$activeStatus;
	}
}
