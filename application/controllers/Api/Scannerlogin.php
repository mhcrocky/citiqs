<?php

// use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Scannerlogin extends REST_Controller
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

    public function qrcode_post()
    {
        // $email = $_POST["email"];
        $qrcode = $this->security->xss_clean($this->input->post('scannercode'));
        // $password = $_POST["password"];
		// search qrcode
		if($qrcode !='qwerty'){
			$message = [
				'vendor' => '0'
			];
		}
		else {

//        $this->db->select('id as userId, password');
//        $this->db->from('tbl_user');
//        $this->db->where('email', $email);
//        $this->db->where('isDeleted', 0);
//        $this->db->where('IsDropOffPoint', 1);
//        $query = $this->db->get();
//        $user = $query->row();
//
//        if(!empty($user))
//        {
//            if (verifyHashedPassword($password, $user->password))
//            {
//                $hash = bin2hex(random_bytes(32));
//            }
//            else
//            {
//                $hash = "";
//            }
//            $this->db->set('hash', $hash);
//            $this->db->where('id', $user->userId);
//            $this->db->where('isDeleted', 0);
//            $this->db->update('tbl_user');
//            $affected_rows = $this->db->affected_rows();
//        }
//        else
//            {
//                $hash = "";
//                $affected_rows = -1;
//            }
//
//        $message = [
//            'hash' => $hash,
//            'affected_rows' => "$affected_rows",
//			'vendor' => $user->userId
//        ];
//
//        $this->set_response($message, 200); // CREATED (201) being the HTTP response code
			$message = [
				'vendor' => '43533'
			];
		}

		$this->set_response($message, 200); // CREATED (201) being the HTTP response code

    }


}
