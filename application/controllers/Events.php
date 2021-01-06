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
        $this->load->model('event_model');
        $this->load->helper('country_helper');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
    } 


    public function index()
    {
        $this->global['pageTitle'] = 'TIQS: Create Event';
        $data['countries'] = Country_helper::getCountries();
        $this->loadViews("events/step-one", $this->global, $data, 'footerbusiness', 'headerbusiness');

    }

    public function event()
    {
        $this->global['pageTitle'] = 'TIQS: Step Two';
        $this->loadViews("events/step-two", $this->global, '', 'footerbusiness', 'headerbusiness');

    }

    public function save_event()
    {
        $data = $this->input->post(null, true);
        $data['vendorId'] = $this->vendor_id;
        $this->event_model->save_event($data);
        redirect('events/event');

    }


    public function test()
    {
        $data = [
            [
                'id' => '1',
                'name' => 'Early Bird',
                'quantity'  => '18',
                'price' => '0.00',
                'design' => 'A',
                'group' => ''
            ],
            [
                'id' => '2',
                'name' => 'Normal Bird',
                'quantity'  => '19',
                'price' => '0.00',
                'design' => 'A',
                'group' => ''
            ],
            [
                'id' => '3',
                'name' => 'VIP Ticket',
                'quantity'  => '20',
                'price' => '0.00',
                'design' => 'B',
                'group' => 'VIP'
            ],
            [
                'id' => '4',
                'name' => 'Group Ticket 4 personen',
                'quantity'  => '21',
                'price' => '0.00',
                'design' => 'B',
                'group' => 'Group'
            ],
        ];
        echo  json_encode($data);

    }


}
