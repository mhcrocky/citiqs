<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';


class Lists extends BaseControllerWeb
{
    private $vendor_id;
    function __construct()
    {
        parent::__construct();
        $this->load->model('list_model');
        $this->load->model('email_templates_model');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->helper('utility_helper');
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
    } 


    public function index()
    {
        $this->global['pageTitle'] = 'TIQS: Lists';
        $this->loadViews("lists/index", $this->global, '', 'footerbusiness', 'headerbusiness');

    }

    public function get_lists()
    {
        $this->list_model->vendorId = $this->vendor_id;

        $lists = $this->list_model->fetchVendorLists();

        $lists = ($lists === null) ? [] : $lists;

        echo json_encode($lists);
    }

    public function save_list()
    {
        $data = $this->input->post(null, true);
        $data['vendorId'] = $this->vendor_id;

        if($this->list_model->insertlist($data)){
            $response = [
                'status' => 'success',
                'message' => 'List is saved successfully!'
            ];
            echo json_encode($response);
            return ;
        }
        
        $response = [
            'status' => 'error',
            'message' => 'List is not saved successfully!'
        ];
        echo json_encode($response);

    }

    public function delete_list()
    {
        $id = $this->input->post('id');

        $this->list_model->id = $id;

        if($this->list_model->delete()){
            $response = [
                'status' => 'success',
                'message' => 'List is deleted successfully!'
            ];
            echo json_encode($response);
            return ;
        }
        
        $response = [
            'status' => 'error',
            'message' => 'List is not deleted successfully!'
        ];
        echo json_encode($response);
    }


} 
