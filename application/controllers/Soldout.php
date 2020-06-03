<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Soldout extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
		$this->load->model('bookandpay_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index()
    {
    	$data="";
        $this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->loadViews("thuishavensoldout", $this->global, $data, 'nofooter', 'noheader');
    }

}

