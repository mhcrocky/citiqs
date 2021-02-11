<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Legal extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('google');
     }

    public function index()
    {
        $this->global['pageTitle'] = 'tiqs : LEGAL';
        $data = '';
        $this->loadViews("legal", $this->global, $data, "nofooter", "headerpublic");

	}


}

