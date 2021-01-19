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

    public function edit($eventId)
    {
        $this->global['pageTitle'] = 'TIQS: Edit Event';
        $data['event'] = $this->event_model->get_event($this->vendor_id,$eventId);
        $data['countries'] = Country_helper::getCountries();

        $this->loadViews("events/edit_event", $this->global, $data, 'footerbusiness', 'headerbusiness');
        

    }

    public function shop()
    {
        $this->global['pageTitle'] = 'TIQS: Shop';
        $design = $this->event_model->get_design($this->session->userdata('userId'));
        $this->global['design'] = unserialize($design[0]['shopDesign']);
        $data['events'] = $this->event_model->get_events($this->vendor_id);
        $this->loadViews("events/shop", $this->global, $data, null, 'headerNewShop');

    }

    public function tickets($eventId)
    {
        $this->session->unset_userdata("event_date");
        $this->global['pageTitle'] = 'TIQS: Step Two';
        $design = $this->event_model->get_design($this->session->userdata('userId'));
        $this->global['design'] = unserialize($design[0]['shopDesign']);
        $event = $this->event_model->get_event($this->vendor_id,$eventId);
        $event_start =  date_create($event->StartDate . " " . $event->StartTime);
        $event_end = date_create($event->EndDate . " " . $event->EndTime);
        $event_date = date_format($event_start, "d M Y H:i") . " - ". date_format($event_end, "d M Y H:i");
        $this->session->set_userdata("event_date",$event_date);
        $data = [
            'tickets' => $this->event_model->get_tickets($this->vendor_id,$eventId),
            'eventId' => $eventId
        ];
        $this->loadViews("events/tickets", $this->global, $data, null, 'headerNewShop');

    }

    public function your_tickets()
    {
        $this->global['pageTitle'] = 'TIQS: Your Tickets';
        $results = $this->input->post(null, true);
        if(count($results) > 0){
            $quantities = $results['quantity'];
            $id = $results['id'];
            $descript = $results['descript'];
            $price = $results['price'];
            $tickets = [];
            foreach($quantities as $key => $quantity){
                if($quantity == '0'){ continue; }
                    $tickets[] = [
                        'id' => $id[$key],
                        'descript' => $descript[$key],
                        'quantity' => $quantity,
                        'price' => $price[$key],
                        'amount' => floatval($price[$key])*floatval($quantity)
                    ];
            }
            
            $this->session->set_tempdata('tickets', $tickets, 600);
            $current_time = date($results['current_time']);
            $newTime = date("Y-m-d H:i:s",strtotime("$current_time +10 minutes"));
            $this->session->set_tempdata('exp_time', $newTime, 600);
        }
   
        $this->loadViews("events/your_tickets", $this->global, '', 'nofooter', 'headerNewShop');

    }

    public function pay()
    {
        $this->global['pageTitle'] = 'TIQS: Pay';
        $this->loadViews("events/pay", $this->global, '', 'nofooter', 'headerNewShop');
    }

    public function save_event()
    {
        $config['upload_path']   = FCPATH . 'assets/images/events';
        $config['allowed_types'] = 'jpg|png|jpeg|webp|bmp';
        $config['max_size']      = '102400'; // 102400 100mb
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $errors   = $this->upload->display_errors('', '');
            var_dump($errors);
            redirect('events/create');
        } else {
            $upload_data = $this->upload->data();
            $data = $this->input->post(null, true);
            $data['vendorId'] = $this->vendor_id;
			$file_name = $upload_data['file_name'];
            $data['eventimage'] = $file_name;
            $eventId = $this->event_model->save_event($data);
        }
        redirect('events/event/'.$eventId);

    }

    public function update_event($eventId)
    {
        $imgChanged = $this->input->post("imgChanged");
        if($imgChanged == 'false') {
            $data = $this->input->post(null, true);
            $data['vendorId'] = $this->vendor_id;
            unset($data['imgChanged']);
            unset($data['imgName']);
            $this->event_model->update_event($eventId, $data);
            redirect('events');
        }
        $config['upload_path']   = FCPATH . 'assets/images/events';
        $config['allowed_types'] = 'jpg|png|jpeg|webp|bmp';
        $config['max_size']      = '102400'; // 102400 100mb
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $errors   = $this->upload->display_errors('', '');
            var_dump($errors);
            redirect('events/create');
        } else {
            $upload_data = $this->upload->data();
            $data = $this->input->post(null, true);
            $data['vendorId'] = $this->vendor_id;
			$file_name = $upload_data['file_name'];
            $data['eventimage'] = $file_name;
            unlink(FCPATH . 'assets/images/events/'.$data['imgName']);
            unset($data['imgChanged']);
            unset($data['imgName']);
            $this->event_model->update_event($eventId, $data);
        }
        redirect('events');

    }

    public function save_ticket()
    {
        $data = $this->input->post(null, true);
        $this->event_model->save_ticket($data);
        redirect('events/event/'.$data['eventId']);

    }

    public function save_ticket_options($eventId)
    {
        $data = $this->input->post(null, true);
        $this->event_model->save_ticket_options($data);
        redirect('events/event/'.$eventId);

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
        $this->load->model('shopvendor_model');
        $design = $this->event_model->get_design($this->vendor_id);
        $id = intval($this->shopvendor_model->setProperty('vendorId', $this->vendor_id)->getProperty('id'));
        $data = [ 
            'id' => $id,
            'vendorId' => $this->vendor_id,
            'iframeSrc' => base_url() . 'events/shop',
            'design' => unserialize($design[0]['shopDesign']),
            'devices' => $this->bookandpayagendabooking_model->get_devices(),
            'analytics' => $this->shopvendor_model->setObjectId($id)->getVendorAnalytics()
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