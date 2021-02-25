<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

include(APPPATH . '/libraries/koolreport/core/autoload.php');

require APPPATH . '/libraries/BaseControllerWeb.php';

use \koolreport\drilldown\DrillDown;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\clients\Bootstrap4;

class Events extends BaseControllerWeb
{
    private $vendor_id;
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('email_templates_model');
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
            'event' => $this->event_model->get_event($this->vendor_id,$eventId),
            'eventId' => $eventId,
            'emails' => $this->email_templates_model->get_ticketing_email_by_user($this->vendor_id),
            'groups' => $this->event_model->get_ticket_groups()
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
            redirect('events/event/'.$eventId);
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
        redirect('events/event/'.$eventId);

    }

    public function save_ticket()
    {
        $data = $this->input->post(null, true);
        if($data['ticketType'] == 'group'){
            $data['ticketType'] = 2;
            $groupId = $this->event_model->save_ticket_group($data['ticketDescription'],$data['ticketQuantity']);
            $data['ticketGroupId'] = $groupId;
            $this->event_model->save_ticket($data);
        } else {
            $data['ticketType'] = 1;
            $this->event_model->save_ticket($data);
        }
        
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

    public function get_email_template()
    {
        $ticketId = $this->input->post("id");
        $this->load->model('shoptemplates_model');
        $this->shoptemplates_model->setObjectId(intval($ticketId))->setObject();
        $templateContent = file_get_contents($this->shoptemplates_model->getTemplateFile());
        echo json_encode($templateContent);

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
            'iframeSrc' => base_url() . 'events/shop/' . $this->session->userdata('shortUrl'),
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

    public function update_email_template()
    {
        $id = $this->input->post('id');
        $emailId = $this->input->post('emailId');
        $this->event_model->update_email_template($id, $emailId);
    }

    public function report($eventId)
    {
        $this->global['pageTitle'] = 'TIQS : EVENT REPORT';
        $data['eventId'] = $eventId;
        $data['event'] = $this->event_model->get_event($this->vendor_id,$eventId);
        $this->loadViews('events/reports', $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function graph($eventId)
    {
        $this->global['pageTitle'] = 'TIQS : EVENT GRAPH';
        $data['eventId'] = $eventId;
        $data['event'] = $this->event_model->get_event($this->vendor_id,$eventId);
        $data['graphs'] = $this->get_graphs($this->vendor_id, $eventId);
        $this->loadViews('events/graph', $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function get_ticket_report()
    {
        $eventId = $this->input->post('eventId');
        $sql = ($this->input->post('sql') == 'AND%20()') ? "" : rawurldecode($this->input->post('sql'));
        $report = $this->event_model->get_ticket_report($this->vendor_id, $eventId, $sql);
        echo json_encode($report);
    }

    public function get_tickets_report()
    {
        $sql = ($this->input->post('sql') == 'AND%20()') ? "" : rawurldecode($this->input->post('sql'));
        $report = $this->event_model->get_tickets_report($this->vendor_id, $sql);
        echo json_encode($report);
    }

    public function email_designer()
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['page'] = 'Email Templates List';

        $this->global = [
            'user' => $this->user_model,
            'pageTitle' => 'Email Templates List'
        ];

        $data = [
            'user' => $this->user_model,
            'emails' => $this->email_templates_model->get_ticketing_email_by_user($this->user_model->id)
        ];

        $this->loadViews("events/email_designer_list", $this->global, $data, "footerbusiness", "headerbusiness");
    }

    public function email_designer_edit($email_id = false)
    {

        $data = [];

        if ($email_id) {
            $this->load->model('shoptemplates_model');
            $this->shoptemplates_model->setObjectId(intval($email_id))->setObject();

            $data = [
                'emailTemplates' => $this->config->item('emailTemplates'),
                'vendorId' => intval($_SESSION['userId']),
                'tiqsId' => $this->config->item('tiqsId'),
                'templateId' => $email_id,
				'templateName' => $this->shoptemplates_model->template_name,
				'templateContent' => file_get_contents($this->shoptemplates_model->getTemplateFile())
            ];
        } else {
            $data = [
                'emailTemplates' => $this->config->item('emailTemplates'),
                'vendorId' => intval($_SESSION['userId']),
                'tiqsId' => $this->config->item('tiqsId'),
            ];
        }

        $this->global['pageTitle'] = 'TIQS : UPDATE TEMPLATE';
        $this->loadViews("events/email_designer", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function get_graphs($vendorId, $eventId, $sql=''){
        $GLOBALS['vendorId'] = $vendorId;
        $GLOBALS['eventId'] = $eventId;
        $GLOBALS['sql'] = $sql;
        $this->load->model('event_model');
		$graphs = DrillDown::create(array(
            "name" => "saleDrillDown",
            "title" => " ",
            "levels" => array(
                array(
                    "title" => "Business Report",
                    "content" => function ($params, $scope) {
                        global $vendorId;
                        global $eventId;
                        global $sql;
                        ColumnChart::create(array(
                            "dataSource" => $this->event_model->get_days_report($vendorId, $eventId, $sql), 
                            "columns" => array(
                                "days" => array(
                                    "type" => "integer",
                                    "label" => "Days",
								),
								"tickets" => array(
									"label" => "Tickets",
									"id" => "Tickets",
                                ),
							),
							"class"=>array(
								"button"=>"bg-warning"
							),
                            
							"colorScheme"=>array(
								"#3366cc",
								"#dc3912"
							)
                        ));
                    }
                ),

 

            ),
           
		), true);
		return $graphs;

	}

}