<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Info_DHL extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index()
    {
        $this->global['pageTitle'] = 'TIQS : DHL PARTNER';
        $this->loadViews("info_DHL", $this->global, NULL, NULL);
    }

}

