<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/BaseControllerWeb.php';

class Appsettings extends BaseControllerWeb
{
	private $vendorId;
	public function __construct()
	{
		parent::__construct();
		$this->load->config('custom');
		$this->load->model('appsettings_model');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
		$this->vendorId = $this->session->userdata('userId');
	}

	public function index(){
		$this->global['pageTitle'] = 'TIQS: APP Settings';
		
		$this->loadViews("appsettings/index", $this->global, '', 'footerbusiness', 'headerbusiness'); 
	}

	public function get_appsettings(){
		$where = ['vendorId' => $this->vendorId];
		$data = $this->appsettings_model->get_appsettings($where);
		echo json_encode($data);
	}

	public function save_appsettings(){
		$data = $this->input->post(null, true);
		$data['vendorId'] = $this->vendorId;
		if($this->appsettings_model->save_appsettings($data)){
			$response = [
				'status' => 'success',
				'message' => 'Created successfully!'
			];
			echo json_encode($response);
			return ;
		}

		$response = [
			'status' => 'error',
			'message' => 'Something went wrong!'
		];
		echo json_encode($response);
		return ;
		
	}

	public function update_appsettings(){
		$where = [
			'id' => $this->input->post('id'),
			'vendorId' => $this->vendorId
		];

		$data = [
			'merchandise' => $this->input->post('merchandise'),
			'ticketshop' => $this->input->post('ticketshop')
		];

		if($this->appsettings_model->update_appsettings($data, $where)){
			$response = [
				'status' => 'success',
				'message' => 'Updated successfully!'
			];
			echo json_encode($response);
			return ;
		}

		$response = [
			'status' => 'error',
			'message' => 'Something went wrong!'
		];
		echo json_encode($response);
		return ;
	}

	public function delete_appsettings(){
		$where = [
			'id' => $this->input->post('id'),
			'vendorId' => $this->vendorId
		];
		
		if($this->appsettings_model->delete_appsettings($where)){
			$response = [
				'status' => 'success',
				'message' => 'Deleted successfully!'
			];
			echo json_encode($response);
			return ;
		}

		$response = [
			'status' => 'error',
			'message' => 'Something went wrong!'
		];
		echo json_encode($response);
		return ;
	}




}