<?php

// use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Settings extends REST_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('api_model');
		$this->load->helper('utility_helper');
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));

	}

    public function printer_get()
    {
		$get = Utility_helper::sanitizeGet();
		$vendorId= $get['vendorId'];


        $this->db->select('*');
        $this->db->from('tbl_app_settings');
		$this->db->where('vendorId', $vendorId);
		$query = $this->db->get();
        $result = $query->row();
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
