<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Clearing extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('utility_helper');
		$this->load->helper('validate_data_helper');
		$this->load->helper('sanitize_helper');
		$this->load->helper('email_helper');
		$this->load->helper('curl_helper');

		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}


	public function clearing_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		$paidby = $this->security->xss_clean($this->input->post('paidby'));
		$payout = $this->security->xss_clean($this->input->post('payout'));
		$totaltobepaid = $this->security->xss_clean($this->input->post('totaltobepaid'));
		$settled = $this->security->xss_clean($this->input->post('settled'));
		$settledinvoice = $this->security->xss_clean($this->input->post('settledinvoice'));
		$topay = $this->security->xss_clean($this->input->post('topay'));
		$clearingdate = $this->security->xss_clean($this->input->post('clearingdate'));
		$settlementdatefrom = $this->security->xss_clean($this->input->post('settlementdatefrom'));
		$settlementdateto = $this->security->xss_clean($this->input->post('settlementdateto'));

		$registerclearing = array(
			'vendorId' =>            $vendorId,
			'paidby' =>              $paidby,
			'payout' =>              $payout,
			'totaltobepaid' =>       $totaltobepaid,
			'settled'=>              $settled,
			'settledinvoice' =>      $settledinvoice,
			'topay' =>               $topay,
			'clearingdate' =>        $clearingdate,
			'settlementdatefrom' =>  $settlementdatefrom,
			'settlementdateto' =>    $settlementdateto
		);

		try {

			if ($this->db->insert('tbl_finance_clearing', $registerclearing)){
				$insert_id = $this->db->insert_id();}
			else{
				$insert_id = -1;
			}

		}
		catch (Exception $ex)
		{
			$insert_id= -1;
		}

		if($insert_id>0) {
			$message = [
				'insert_id' => $insert_id
			];
		}
		else{
			$message = [
				'insert_id' => '0'
			];
		}

		$this->set_response($message, 201); // CREATED (201) being the HTTP response code
	}
}

