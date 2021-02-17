<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

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
            'events' => $this->event_model->get_events($this->vendor_id),
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

    public function email_designer_edit($email_id = null)
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['page'] = 'Email Designer';

        $this->global = [
            'user' => $this->user_model,
            'images_path' => base_url() . 'assets/user_images/' . $this->user_model->id,
            'template_id' => $email_id,
            'pageTitle' => 'Email editor'
        ];

        $data = [];

        if ($email_id) {
            $email_template = $this->email_templates_model->get_emails_by_id($email_id);
            $data['email_template'] = $email_template;
            $data['template_html'] = read_file(FCPATH . 'assets/email_templates/' . $this->user_model->id . '/' . $email_template->template_file);
        }

        $this->loadViews("events/email_designer", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

}