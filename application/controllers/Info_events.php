<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Info_events extends BaseControllerWeb
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
        $this->global['pageTitle'] = 'TIQS : HOW IT WORKS';
        $this->loadViews("info_events", $this->global, NULL, NULL);
    }

}

