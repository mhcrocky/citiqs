<?php

// use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

//require APPPATH . 'libraries/REST_Controller_Definitions.php';
//require APPPATH . 'libraries/REST_Controller.php';
//require APPPATH . 'libraries/Format.php';

class Activate extends REST_Controller
{
    private $allowed_img_types;

    function __construct()
    {
        parent::__construct();
        $this->load->library('language', array('controller' => $this->router->class));
    }

    /*
     * Check of e-mail al voorkomt in tbl_user en in de commercial tbl_registeremail
     */

    public function email_get($email)
    {
        $email=urldecode($email);
        $this->db->select("email");
        $this->db->from("tbl_user");
        $this->db->where("email", $email);
        $this->db->where("isDeleted", 0);
        $query = $this->db->get();

        if (empty($query->result()))
        {
            $this->db->reset_query();
            $this->db->select("email");
            $this->db->from("tbl_registeremail");
            $this->db->where("email", $email);
            $query = $this->db->get();
            if (empty($query->result))
            {
                $message = [
                    'status' => "false"
                ];
                $this->set_response($message, 201); // CREATED (201) being the HTTP response code
                return;
            }

        }

        $message = [
            'status' => "true"
        ];

        $this->set_response($message, 201); // CREATED (201) being the HTTP response code

    }


    /*
     * Register email from scanner
     */

    public function registeremail_post()
    {
        // $email = $_POST['email'];
        $email = $this->security->xss_clean($this->input->post('email'));

        $registeremail = array(
            'email' => $email
        );

        try {

            // $email=urldecode($email);
            $this->db->select("email");
            $this->db->from("tbl_user");
            $this->db->where("email", $email);
            $this->db->where("isDeleted", 0);
            $query = $this->db->get();

            if (empty($query->result())) {

                // $this->db->trans_start();
                if ($this->db->insert('tbl_registeremail', $registeremail))
                    $insert_id = $this->db->insert_id();
                else
                    $insert_id = -1;
                // $this->db->trans_complete();
                // return $insert_id;
            }
            else
                {
                    $insert_id = -1;
                }
        }

        catch (Exception $ex)
        {
            $insert_id= -1;
        }


        $message = [
            'insert_id' => $insert_id
        ];

        $this->set_response($message, 201); // CREATED (201) being the HTTP response code
    }


}
