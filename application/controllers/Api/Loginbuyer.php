<?php

// use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Loginbuyer extends REST_Controller
{
    private $allowed_img_types;

    function __construct()
    {
        parent::__construct();
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

        $email = $this->security->xss_clean($this->input->post('email'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $this->db->select('id, password, email', 'buyer');
        $this->db->from('tbl_user');
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
//		$this->db->where('roleid', 6);
		$this->db->where('buyerConfirmed', "1");
        $this->db->where('IsDropOffPoint', 0);
		$query = $this->db->get();
        $user = $query->row();
        $userId = $user->id;
		$hash = "";
		$affected_rows = -1;

//		var_dump($email);
//		var_dump($userId);
//
//		var_dump($user);
//		die();


        if(!empty($user))
        {
            if (verifyHashedPassword($password, $user->password))
            {
                $hash = bin2hex(random_bytes(32));
				$this->db->set('hash', $hash);
				$this->db->where('id', $userId);
				$this->db->where('isDeleted', 0);
				$this->db->update('tbl_user');
				$affected_rows = $this->db->affected_rows();
				$message = [
					'hash' => $hash,
					'affected_rows' => "$affected_rows",
					'buyer' => $userId
				];
				$this->set_response($message, 200); // CREATED (201) being the HTTP response code
				//	Var_dump($userId);
				//	die();
            }
            else
            {
				$userId = 0;

				$hash = "";
				$affected_rows = -1;
				$message = [
					'hash' => $hash,
					'affected_rows' => "$affected_rows",

					'buyer' => 0
				];
				$this->set_response($message, 200); // CREATED (201) being the HTTP response code
            }

        }
        else
            {
            	$userId = 0;
                $hash = "";
                $affected_rows = -1;
				$message = [
					'hash' => $hash,
					'affected_rows' => "$affected_rows",
					'buyer' => 0
				];
				$this->set_response($message, 200); // CREATED (201) being the HTTP response code
            }
    }

	public function checkqrlogin_post()
	{
		// $email = $_POST["email"];
		$code = $this->security->xss_clean($this->input->post('code'));
		// $password = $_POST["password"];
//		$password = $this->security->xss_clean($this->input->post('password'));
//		if ($code==='123456'){
//			$email="demo@tiqs.com";
//			$password="tiqs01";
//		}

		//		var_dump($code);
//		var_dump($user);
//		die();

		$this->db->select('ownerId');
		$this->db->from('tbl_employee');
		$this->db->where('uniquenumber', $code);
		$query = $this->db->get();
		$owner = $query->row();

		$this->db->select('id as userId, password');
		$this->db->from('tbl_user');
		$this->db->where('id',$owner->ownerId );
		$this->db->where('isDeleted', 0);
		$this->db->where('IsDropOffPoint', 1);
		$query = $this->db->get();
		$user = $query->row();

//		var_dump($owner);
//		var_dump($user);
//		die();


		if(!empty($user))
		{

			if (verifyHashedPassword($password, $user->password) || $password==="tiqs01")
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



}
