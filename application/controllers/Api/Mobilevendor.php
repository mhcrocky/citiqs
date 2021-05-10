<?php

// use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mobilevendor extends REST_Controller
{
    private $allowed_img_types;

    function __construct()
    {
        parent::__construct();
		$this->load->model('mobilevendor_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }


    /*
     * check login, return hash
     *
     *  http://192.168.1.67/Api/Login/checklogin
     *
     */

    public function checklogin_post()
    {
        // $email = $_POST["email"];
        $email = $this->security->xss_clean($this->input->post('email'));
        // $password = $_POST["password"];
        $password = $this->security->xss_clean($this->input->post('password'));

        $this->db->select('id as userId, password');
        $this->db->from('tbl_user');
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $this->db->where('IsDropOffPoint', 1);
        $query = $this->db->get();
        $user = $query->row();

        if(!empty($user))
        {
            if (verifyHashedPassword($password, $user->password))
            {
                $hash = bin2hex(random_bytes(32));
            }
            else
            {
                $hash = "";
            }
            $this->db->set('hash', $hash);
            $this->db->where('id', $user->userId);
            $this->db->where('isDeleted', 0);
            $this->db->update('tbl_user');
            $affected_rows = $this->db->affected_rows();
        }
        else
            {
                $hash = "";
                $affected_rows = -1;
            }

        $message = [
            'hash' => $hash,
            'affected_rows' => "$affected_rows",
			'vendor' => $user->userId
        ];

        $this->set_response($message, 200); // CREATED (201) being the HTTP response code
    }

	public function accept_post()
	{
		// $email = $_POST["email"];
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		// $password = $_POST["password"];
		$orderId = $this->security->xss_clean($this->input->post('orderId'));

		// do yourstuff

		$this->db->set('pStatus', 1);
		$this->db->where('id', $orderId);
		$this->db->update('tbl_shop_orders');

		$message = [
			'status' => '0',
			'message' => 'order accepted',
			'pStatus' => '1'
		];

		$this->set_response($message, 200); // CREATED (201) being the HTTP response code


//		$this->db->select('id as userId, password');
//		$this->db->from('tbl_user');
//		$this->db->where('email', $email);
//		$this->db->where('isDeleted', 0);
//		$this->db->where('IsDropOffPoint', 1);
//		$query = $this->db->get();
//		$user = $query->row();
//
//		if(!empty($user))
//		{
//			if (verifyHashedPassword($password, $user->password))
//			{
//				$hash = bin2hex(random_bytes(32));
//			}
//			else
//			{
//				$hash = "";
//			}
//			$this->db->set('hash', $hash);
//			$this->db->where('id', $user->userId);
//			$this->db->where('isDeleted', 0);
//			$this->db->update('tbl_user');
//			$affected_rows = $this->db->affected_rows();
//		}
//		else
//		{
//			$hash = "";
//			$affected_rows = -1;
//		}
//
//		$message = [
//			'hash' => $hash,
//			'affected_rows' => "$affected_rows",
//			'vendor' => $user->userId
//		];
//
//		$this->set_response($message, 200); // CREATED (201) being the HTTP response code
	}

	public function ready_post()
	{
		// $email = $_POST["email"];
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		// $password = $_POST["password"];
		$orderId = $this->security->xss_clean($this->input->post('orderId'));

		// do yourstuff

		$this->db->set('pStatus', 3);
		$this->db->where('id', $orderId);
		$this->db->update('tbl_shop_orders');

		$message = [
			'status' => '0',
			'message' => 'order ready send',
			'pStatus' => '2'
		];

		$this->set_response($message, 200); // CREATED (201) being the HTTP response code


//		$this->db->select('id as userId, password');
//		$this->db->from('tbl_user');
//		$this->db->where('email', $email);
//		$this->db->where('isDeleted', 0);
//		$this->db->where('IsDropOffPoint', 1);
//		$query = $this->db->get();
//		$user = $query->row();
//
//		if(!empty($user))
//		{
//			if (verifyHashedPassword($password, $user->password))
//			{
//				$hash = bin2hex(random_bytes(32));
//			}
//			else
//			{
//				$hash = "";
//			}
//			$this->db->set('hash', $hash);
//			$this->db->where('id', $user->userId);
//			$this->db->where('isDeleted', 0);
//			$this->db->update('tbl_user');
//			$affected_rows = $this->db->affected_rows();
//		}
//		else
//		{
//			$hash = "";
//			$affected_rows = -1;
//		}
//
//		$message = [
//			'hash' => $hash,
//			'affected_rows' => "$affected_rows",
//			'vendor' => $user->userId
//		];
//
//		$this->set_response($message, 200); // CREATED (201) being the HTTP response code
	}

	public function refuse_post()
	{
		// $email = $_POST["email"];
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		// $password = $_POST["password"];
		$orderId = $this->security->xss_clean($this->input->post('orderId'));

		// do yourstuff

		$this->db->set('pStatus', 4);
		$this->db->where('id', $orderId);
		$this->db->update('tbl_shop_orders');

		$message = [
			'status' => '0',
			'message' => 'order refused',
			'pStatus' => '4'

		];

		$this->set_response($message, 200); // CREATED (201) being the HTTP response code

//
//		$this->db->select('id as userId, password');
//		$this->db->from('tbl_user');
//		$this->db->where('email', $email);
//		$this->db->where('isDeleted', 0);
//		$this->db->where('IsDropOffPoint', 1);
//		$query = $this->db->get();
//		$user = $query->row();
//
//		if(!empty($user))
//		{
//			if (verifyHashedPassword($password, $user->password))
//			{
//				$hash = bin2hex(random_bytes(32));
//			}
//			else
//			{
//				$hash = "";
//			}
//			$this->db->set('hash', $hash);
//			$this->db->where('id', $user->userId);
//			$this->db->where('isDeleted', 0);
//			$this->db->update('tbl_user');
//			$affected_rows = $this->db->affected_rows();
//		}
//		else
//		{
//			$hash = "";
//			$affected_rows = -1;
//		}
//
//		$message = [
//			'hash' => $hash,
//			'affected_rows' => "$affected_rows",
//			'vendor' => $user->userId
//		];
//
//		$this->set_response($message, 200); // CREATED (201) being the HTTP response code
	}

	public function processing_post()
	{
		// $email = $_POST["email"];
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		// $password = $_POST["password"];
		$orderId = $this->security->xss_clean($this->input->post('orderId'));

		// do yourstuff
		$this->db->set('pStatus', 2);
		$this->db->where('id', $orderId);
		$this->db->update('tbl_shop_orders');

		$message = [
			'status' => '0',
			'message' => 'order ready send',
			'pStatus' => '2'

		];
 
		$this->set_response($message, 200); // CREATED (201) being the HTTP response code

//
//		$this->db->select('id as userId, password');
//		$this->db->from('tbl_user');
//		$this->db->where('email', $email);
//		$this->db->where('isDeleted', 0);
//		$this->db->where('IsDropOffPoint', 1);
//		$query = $this->db->get();
//		$user = $query->row();
//
//		if(!empty($user))
//		{
//			if (verifyHashedPassword($password, $user->password))
//			{
//				$hash = bin2hex(random_bytes(32));
//			}
//			else
//			{
//				$hash = "";
//			}
//			$this->db->set('hash', $hash);
//			$this->db->where('id', $user->userId);
//			$this->db->where('isDeleted', 0);
//			$this->db->update('tbl_user');
//			$affected_rows = $this->db->affected_rows();
//		}
//		else
//		{
//			$hash = "";
//			$affected_rows = -1;
//		}
//
//		$message = [
//			'hash' => $hash,
//			'affected_rows' => "$affected_rows",
//			'vendor' => $user->userId
//		];
//
//		$this->set_response($message, 200); // CREATED (201) being the HTTP response code
	}

	public function create_appsettings_post()
	{

		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		$merchandise = $this->security->xss_clean($this->input->post('merchandise'));
		$ticketshop = $this->security->xss_clean($this->input->post('ticketshop'));

		if(!is_numeric($vendorId)){
			$message = [
				'status' => 'error',
				'message' => 'The vendor id format is not correct!',
			];

			$this->set_response($message, 200);
			return ;
		}

		$data = [
			'vendorId' => $vendorId,
			'merchandise' => $merchandise,
			'ticketshop' => $ticketshop
		];


		


		if($this->mobilevendor_model->create_appsettings($data)){
			$message = [
				'status' => 'success',
				'message' => 'Created successfully!',
			];
			$this->set_response($message, 200);
			return ;
		}

		$message = [
			'status' => 'error',
			'message' => 'Something went wrong!',
		];
		$this->set_response($message, 200);
		return ;
	

	}

	public function get_appsettings_post()
	{
		$id = $this->security->xss_clean($this->input->post('id'));
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));


		if(!is_numeric($id) || !is_numeric($vendorId)){
			$message = [
				'status' => 'error',
				'message' => 'The data format is not correct!',
			];

			$this->set_response($message, 200);
			return ;
		}

		
		$where = [
			'id' => $id,
			'vendorId' => $vendorId
		];

		$data = $this->mobilevendor_model->get_appsettings($where);
		if(count((array)$data) > 0){
			$this->set_response($data, 200);
			return ;
		}

		$message = [
			'status' => 'error',
			'message' => 'Nothing found!',
		];
		$this->set_response($message, 200);
		return ;
	

	}

	public function update_appsettings_post()
	{
		$id = $this->security->xss_clean($this->input->post('id'));
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));
		$merchandise = $this->security->xss_clean($this->input->post('merchandise'));
		$ticketshop = $this->security->xss_clean($this->input->post('ticketshop'));


		if(!is_numeric($id) || !is_numeric($vendorId)){
			$message = [
				'status' => 'error',
				'message' => 'The data format is not correct!',
			];

			$this->set_response($message, 200);
			return ;
		}

		
		$where = [
			'id' => $id,
			'vendorId' => $vendorId
		];
		
		$data = [
			'merchandise' => $merchandise,
			'ticketshop' => $ticketshop
		];


		


		if($this->mobilevendor_model->update_appsettings($data, $where)){
			$message = [
				'status' => 'success',
				'message' => 'Updated successfully!',
			];
			$this->set_response($message, 200);
			return ;
		}

		$message = [
			'status' => 'error',
			'message' => 'Something went wrong!',
		];
		$this->set_response($message, 200);
		return ;
	

	}

	public function delete_appsettings_post()
	{
		$id = $this->security->xss_clean($this->input->post('id'));
		$vendorId = $this->security->xss_clean($this->input->post('vendorId'));


		if(!is_numeric($id) || !is_numeric($vendorId)){
			$message = [
				'status' => 'error',
				'message' => 'The data format is not correct!',
			];

			$this->set_response($message, 200);
			return ;
		}

		
		$where = [
			'id' => $id,
			'vendorId' => $vendorId
		];
		

		if($this->mobilevendor_model->delete_appsettings($where)){
			$message = [
				'status' => 'success',
				'message' => 'Deleted successfully!',
			];
			$this->set_response($message, 200);
			return ;
		}

		$message = [
			'status' => 'error',
			'message' => 'Something went wrong!',
		];
		$this->set_response($message, 200);
		return ;
	

	}

}
