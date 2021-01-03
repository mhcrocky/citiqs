<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include(APPPATH . '/libraries/koolreport/core/autoload.php');

require APPPATH . '/libraries/BaseControllerWeb.php';

use \koolreport\drilldown\DrillDown;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\clients\Bootstrap;

class Events extends BaseControllerWeb
{
	private $vendor_id;
    function __construct()
    {
		//		die('constructor');
        parent::__construct();
        $this->load->model('Events_model');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
    } 


    public function index()
    {
        $this->global['pageTitle'] = 'TIQS: Control Event';
        $this->loadViews("events/step-one", $this->global, '', 'footerbusiness', 'headerbusiness');

    }

}
