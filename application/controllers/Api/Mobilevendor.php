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
//		$this->load->model('mobilevendor_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }


    /*
     * check login, return hash
     *
     *  http://192.168.1.67/Api/Login/checklogin
     *
     */


	public function appsettings_post()
	{
		// $email = $_POST["email"];
		$email = $this->security->xss_clean($this->input->post('email'));
		// $password = $_POST["password"];
		$password = $this->security->xss_clean($this->input->post('password'));

		$message = [

			"merchandise" => "https://tiqs.com/info",
    		"ticketshop" => "https://tiqs.com/events/shop/37"
		];

		$this->set_response($message, 200); // CREATED (201) being the HTTP response code
	}

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

}
