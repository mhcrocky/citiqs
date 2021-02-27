<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Events extends REST_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('api_model');
		$this->load->helper('utility_helper');
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));

	}

    public function allcategories_get()
    {
        $this->db->select('id, description');
        $this->db->from('tbl_category');
        $this->db->order_by('description');
        $query = $this->db->get();
        $result = $query->result_array();
        $this->response($result, 200);
    }

	public function Records_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));

		$this->db->where('vendorId', $vendorId);
		$this->db->from('tbl_events');
		$query = $this->db->get();
		$result = $query->result_array();
//		var_dump($result);
		$this->response($result, 200);
	}

	public function Tickettypes_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		$eventid = $this->security->xss_clean($this->input->post('description'));


		$this->db->select('id', 'description');
		$this->db->from('tbl_');
		$this->db->order_by('description');
		$query = $this->db->get();
		$result = $query->result_array();

		$this->response($result, 200);
	}

	public function Tickets_post()
	{
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		$eventid = $this->security->xss_clean($this->input->post('eventId'));
		$changetimein = $this->security->xss_clean($this->input->post('changeTimeIn'));
		$changetimeout = $this->security->xss_clean($this->input->post('changeTimeOut'));

//		echo 'hello';
//		die();

		$this->db->where('customer', $vendorId);
		$this->db->where('eventid', $eventid);
		$this->db->where('scannedtime >=', date_create($changetimein)->format('Y-m-d H:i:s'));
		$this->db->where('scannedtime <=', date_create($changetimeout)->format('Y-m-d H:i:s'));

		$this->db->from('tbl_bookandpay');
		$query = $this->db->get();
		$result = $query->result_array();
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
