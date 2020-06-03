<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Thuishavensoldout extends BaseControllerWeb
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
        $this->global['pageTitle'] = 'TIQS : SOLDOUT';

		$this->loadViews("thuishavensoldout", $this->global, NULL, 'nofooter', 'noheader'); // payment screen

	}

}

