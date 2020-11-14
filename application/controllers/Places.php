<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Places extends BaseControllerWeb
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bizdir_model');
		$this->load->helper('url_helper');
		$this->load->helper('url');
		$this->load->library('language', array('controller' => $this->router->class));

	}

	public function index()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');

		$category = $this->input->get("category");
		$location = $this->input->get("location");
		//$data['directories'] = $this->bizdir_model->get_bizdir(); 
		$data['title'] = 'TIQS PLACES';

		$this->global['pageTitle'] = 'TIQS PLACES';


		$this->loadViews("bizdir/index", $this->global, $data, 'footerpublicbizdir', 'noheaderbizdir'); // payment screen

	}

	public function any()
	{
		$data['title'] = 'Biz Dir: Any Page';
		$this->load->view('bizdir/any', $data);
	}

	public function add()
	{
//		$this->load->helper('form');
//		$this->load->library('form_validation');
//		$this->load->library('session');
//
//		$this->form_validation->set_rules('name', 'Name', 'required');
//		$this->form_validation->set_rules('address', 'Address', 'required');
//		$this->form_validation->set_rules('category', 'Category', 'required');
//
//		$data['title'] = 'Add Business';
//
//		if ($this->input->server('REQUEST_METHOD') == "POST") {
//			$business_name = $this->input->post("name");
//			if ($this->form_validation->run() === FALSE) {
//				$this->session->set_flashdata('message', 'Error adding ' . $business_name);
//				$this->session->set_flashdata('status', 'danger');
//			} else {
//				$this->bizdir_model->set_bizdir();
//				$this->session->set_flashdata('message', $business_name . ' was successfully added');
//				$this->session->set_flashdata('status', 'success');
//			}
//		}
//
//		$this->load->view('templates/header', $data);
//		$this->load->view('bizdir/add', $data);
//		$this->load->view('templates/footer');
	}
}
