<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Start extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('utility_helper');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index()
    {
        if (isset($_SESSION['iframeRedirect'])) {
            $iframeRedirect = Utility_helper::getSessionValue('iframeRedirect');
            redirect($iframeRedirect);
            exit();
        };
		redirect('https://tiqs.com');
//
//		$this->global['pageTitle'] = 'TIQS : SPOT';
//
//		$this->loadViews("start", $this->global, NULL, NULL, "headerpublic"); // payment screen
	}

}

