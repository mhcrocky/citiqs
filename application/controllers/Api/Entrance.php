<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Entrance extends REST_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('api_model');
		$this->load->helper('utility_helper');
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function in_post()
	{
		$qrcode = $this->security->xss_clean($this->input->post('QRcode'));
		$this->db->where('reservationId', $qrcode);
		$this->db->from('tbl_bookandpay');
		$query = $this->db->get();
		$result = $query->result_array();
//		var_dump($result);
//		var_dump($result[0]['scanned']);
		if(empty($result)){
			// we could not find the T-qrcode
			$result = array(
				'scanned' => '0'
			);
		}
		else
		{
			// we found the code let see if it already scanned
			// change update data
			// and scannedin
			if ($result[0]['scanned']=='2'){
				$this->db->set('scanned', '2');
				$this->db->where('reservationId', $qrcode);
				$result = $this->db->update('tbl_bookandpay');
				if($result) {
					$this->db->where('reservationId', $qrcode);
					$this->db->from('tbl_bookandpay');
					$query = $this->db->get();
					$result = $query->result_array();
				}
			}

			if ($result[0]['scanned']=='1'){
				if ($result[0]['numberin']<$result[0]['numberofpersons']){
					$result[0]['numberin']=$result[0]['numberin']+1;
					$this->db->set('numberin',$result[0]['numberin'] );
					$this->db->set('scanned', '1');
					$this->db->set('scannedtime', date_create('now')->format('Y-m-d H:i:s'));
				} else {
					$this->db->set('scanned', '2');
					$this->db->set('scannedtime', date_create('now')->format('Y-m-d H:i:s'));
				}

				$this->db->where('reservationId', $qrcode);
				$result = $this->db->update('tbl_bookandpay');
				if($result) {
					$this->db->where('reservationId', $qrcode);
					$this->db->from('tbl_bookandpay');
					$query = $this->db->get();
					$result = $query->result_array();
				}
			} elseif($result[0]['scanned']=='0'){
				$result[0]['numberin']=$result[0]['numberin']+1;
				$this->db->set('numberin',$result[0]['numberin'] );
				$this->db->set('scanned', '1');
				$this->db->set('scannedtime', date_create('now')->format('Y-m-d H:i:s'));
				$this->db->where('reservationId', $qrcode);
				$result = $this->db->update('tbl_bookandpay');
				if($result) {
					$this->db->where('reservationId', $qrcode);
					$this->db->from('tbl_bookandpay');
					$query = $this->db->get();
					$result = $query->result_array();
				}
			}

		}

		$this->response($result, 200);
	}

	public function index_get()
	{
		$data = "No function called like this";
		$this->response($data, REST_Controller::HTTP_OK);
	}

	public function index_post()
	{
		$data = "No function called like this";
		$this->response($data, REST_Controller::HTTP_OK);
	}

}

?>
