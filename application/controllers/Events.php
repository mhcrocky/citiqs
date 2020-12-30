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

    /*
     * Listing of tbl_events
     */
    function index()
    {
//    	die('index');
        $data['tbl_events'] = $this->Events_model->get_all_tbl_events();
		$this->global['pageTitle'] = 'TIQS: e-ticketing';
		$this->loadViews("events/index", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    /*
     * Adding a new tbl_event
     */
    function add()
    {
    	if(isset($_POST) && count($_POST) > 0)
        {   
            $params = array(
				'userid' => $this->input->post('userid'),
				'EventName' => $this->input->post('EventName'),
				'EventDescription' => $this->input->post('EventDescription'),
				'MinimalAge' => $this->input->post('MinimalAge'),
				'EventType' => $this->input->post('EventType'),
				'Venue' => $this->input->post('Venue'),
				'VenueAddress' => $this->input->post('VenueAddress'),
				'VenueCity' => $this->input->post('VenueCity'),
				'VenueZipcode' => $this->input->post('VenueZipcode'),
				'VenueCountry' => $this->input->post('VenueCountry'),
				'StartDateTime' => $this->input->post('StartDateTime'),
				'EndDateTime' => $this->input->post('EndDateTime'),
            );
            
            $tbl_event_id = $this->Events_model->add_tbl_event($params);
            redirect('events/index');
        }
        else
        {
//			die('else');
			$data= null;
			$this->global['pageTitle'] = 'TIQS: e-ticketing';
			$this->loadViews("events/add", $this->global, $data, 'footerbusiness', 'headerbusiness');
        }
    }  

    /*
     * Editing a tbl_event
     */
    function edit($id)
    {   
        // check if the tbl_event exists before trying to edit it
        $data['tbl_event'] = $this->Events_model->get_tbl_event($id);
        
        if(isset($data['tbl_event']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'userid' => $this->input->post('userid'),
					'EventName' => $this->input->post('EventName'),
					'EventDescription' => $this->input->post('EventDescription'),
					'MinimalAge' => $this->input->post('MinimalAge'),
					'EventType' => $this->input->post('EventType'),
					'Venue' => $this->input->post('Venue'),
					'VenueAddress' => $this->input->post('VenueAddress'),
					'VenueCity' => $this->input->post('VenueCity'),
					'VenueZipcode' => $this->input->post('VenueZipcode'),
					'VenueCountry' => $this->input->post('VenueCountry'),
					'StartDateTime' => $this->input->post('StartDateTime'),
					'EndDateTime' => $this->input->post('EndDateTime'),
                );

                $this->Events_model->update_tbl_event($id,$params);            
                redirect('events/index');
            }
            else
            {
				$this->global['pageTitle'] = 'TIQS: e-ticketing';
				$this->loadViews("events/edit", $this->global, $data, 'footerbusiness', 'headerbusiness');
			}
        }
        else
            show_error('The tbl_event you are trying to edit does not exist.');
    } 

    /*
     * Deleting tbl_event
     */
    function remove($id)
    {
        $tbl_event = $this->Events_model->get_tbl_event($id);

        // check if the tbl_event exists before trying to delete it
        if(isset($tbl_event['id']))
        {
            $this->Events_model->delete_tbl_event($id);
            redirect('events/index');
        }
        else
            show_error('The tbl_event you are trying to delete does not exist.');
    }
    
}
