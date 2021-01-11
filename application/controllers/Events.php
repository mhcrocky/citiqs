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
        parent::__construct();
        $this->load->model('event_model');
        $this->load->helper('country_helper');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
    } 


    public function index()
    {
        $this->global['pageTitle'] = 'TIQS: Events';
        $this->loadViews("events/events", $this->global, '', 'footerbusiness', 'headerbusiness');

    }

    public function create()
    {
        $this->global['pageTitle'] = 'TIQS: Create Event';
        $data['countries'] = Country_helper::getCountries();
        $this->loadViews("events/step-one", $this->global, $data, 'footerbusiness', 'headerbusiness');

    }

    public function event($eventId)
    {
        $this->global['pageTitle'] = 'TIQS: Step Two';
        $data = [
            'events' => $this->event_model->get_events($this->vendor_id),
            'eventId' => $eventId
        ];
        $this->loadViews("events/step-two", $this->global, $data, 'footerbusiness', 'headerbusiness');

    }

    public function shop()
    {
        $this->global['pageTitle'] = 'TIQS: Shop';
        $design = $this->event_model->get_design($this->session->userdata('userId'));
        $data = [
            'design' => unserialize($design[0]['shopDesign']),
            'events' => $this->event_model->get_events($this->vendor_id)
        ];
        $this->loadViews("events/shop", $this->global, $data, null, 'headerNewShop');

    }

    public function tickets($eventId)
    {
        $this->global['pageTitle'] = 'TIQS: Step Two';
        $design = $this->event_model->get_design($this->session->userdata('userId'));
        $data = [
            'design' => unserialize($design[0]['shopDesign']),
            'tickets' => $this->event_model->get_tickets($this->vendor_id,$eventId),
            'eventId' => $eventId
        ];
        $this->loadViews("events/tickets", $this->global, $data, null, 'headerNewShop');

    }

    public function save_event()
    {
        $data = $this->input->post(null, true);
        $data['vendorId'] = $this->vendor_id;
        $eventId = $this->event_model->save_event($data);
        redirect('events/event/'.$eventId);

    }

    public function save_ticket()
    {
        $data = $this->input->post(null, true);
        $this->event_model->save_ticket($data);
        redirect('events/event/'.$data['eventId']);

    }

    public function save_ticket_options()
    {
        $data = $this->input->post(null, true);
        $this->event_model->save_ticket_options($data);
        redirect('events/event');

    }

    public function get_events()
    {
        $data = $this->event_model->get_events($this->vendor_id);
        echo json_encode($data);

    }

    public function get_ticket_options($ticketId)
    {
        $data = $this->event_model->get_ticket_options($ticketId);
        echo json_encode($data);

    }

    public function get_tickets()
    {
        $eventId = $this->input->post("id");
        $data  = $this->event_model->get_tickets($this->vendor_id,$eventId);
        echo json_encode($data);

    }

    public function viewdesign(): void
    {
        $this->load->model('bookandpayagendabooking_model');
        $design = $this->event_model->get_design($this->vendor_id);
        $data = [ 
            'vendorId' => $this->vendor_id,
            'iframeSrc' => base_url() . 'events/shop',
            'design' => unserialize($design[0]['shopDesign']),
            'devices' => $this->bookandpayagendabooking_model->get_devices(),
        ];

        $this->global['pageTitle'] = 'TIQS : DESIGN';
        $this->loadViews('events/design', $this->global, $data, 'footerbusiness', 'headerbusiness');
        return;
    }

    public function save_design()
    {
        $design = serialize($this->input->post(null,true));
        $this->event_model->save_design($this->vendor_id,$design);
        redirect('events/viewdesign');
    }

}
