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

	public function index($idplaces ='')
	{

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$category = $this->input->get("category");
		$location = $this->input->get("location");
		if(!empty($idplaces)){
			$data = $this->bizdir_model->get_bizdir_by_defaultkey($idplaces);
			$this->session->set_flashdata('location_data',$data);
			redirect('places');
		}
		//$data['directories'] = $this->bizdir_model->get_bizdir(); 
		$data['title'] = 'TIQS PLACES';
		$this->global['pageTitle'] = 'TIQS PLACES';
		$this->loadViews("bizdir/index", $this->global, $data, 'footerpublicbizdir', 'noheaderbizdir'); // payment screen
	}

}
