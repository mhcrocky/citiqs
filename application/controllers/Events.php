<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

include(APPPATH . '/libraries/koolreport/core/autoload.php');

require APPPATH . '/libraries/BaseControllerWeb.php';

use \koolreport\drilldown\DrillDown;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\clients\Bootstrap4;
use \koolreport\bootstrap3\Theme;

class Events extends BaseControllerWeb
{
    private $vendor_id;
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('email_templates_model');
        $this->load->model('event_model');
        $this->load->model('bookandpay_model');
        
        $this->load->helper('country_helper');
        $this->load->helper('email_helper');
        $this->load->helper('ticketingemail_helper');
        $this->load->helper('text');
        $this->load->helper('cookie');
        $this->load->library('language', array('controller' => $this->router->class));
        

        $this->load->helper('utility_helper');

		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
    } 


    public function index()
    {
        $this->global['pageTitle'] = 'TIQS: Events';
        $data['shopsettings'] = $this->event_model->get_shopsettings($this->vendor_id);
        $where = ['vendorId' => $this->vendor_id];
        $data['tags'] = $this->event_model->get_event_tags($where);
        $data['shortUrl'] = $this->session->userdata('userShortUrl');
        $data['fullBaseUrl'] = (strpos(base_url(), 'https://') !== false) ? str_replace('https://', 'https://www.', base_url()) : str_replace('http://', 'http://www.', base_url());


        if(isset($_COOKIE['eventId'])){
            $data['cookieEventId'] = $_COOKIE['eventId'];
        }

        $this->loadViews("events/events", $this->global, $data, 'footerbusiness', 'headerbusiness');

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

        $cookie = array('eventId', $eventId, time() + 3600);
        setcookie('eventId', $eventId, time() + 3600, '/');


        $this->load->model('shopvoucher_model');
		$what = ['tbl_shop_voucher.id' ,'tbl_shop_voucher.description', 'tbl_email_templates.template_name'];
        $join = [
			0 => [
				'tbl_email_templates',
				'tbl_email_templates.id = tbl_shop_voucher.emailId',
				'right'
			]
		];
		$where = [
            "tbl_shop_voucher.vendorId" => $this->vendor_id,
            "tbl_shop_voucher.productGroup" => $this->config->item('eTicketing')
        ]; 

        $data = [
            'event' => $this->event_model->get_event($this->vendor_id,$eventId),
            'eventId' => $eventId,
            'emails' => $this->email_templates_model->get_ticketing_email_by_user($this->vendor_id),
            'vouchers' => $this->shopvoucher_model->read($what,$where,$join, 'group_by', ['tbl_shop_voucher.id']),
            'groups' => $this->event_model->get_ticket_groups($eventId),
            'guests' => $this->event_model->get_guestlist($eventId, $this->vendor_id),
            'tickets' => $this->event_model->get_tickets($this->vendor_id, $eventId),
            'vendorTicketFee' => $this->event_model->get_vendor_ticketfee($this->vendor_id)
        ];
        
        $this->loadViews("events/step-two", $this->global, $data, 'footerbusiness', 'headerbusiness');

    }


    public function guestlist($eventId)
    {
       $this->global['pageTitle'] = 'TIQS: GUESTLIST';
       $data['eventId'] = $eventId;
       $data['tickets'] = $this->event_model->get_all_event_tickets($this->vendor_id, $eventId);
       $this->loadViews("events/guestlist", $this->global, $data, 'footerbusiness', 'headerbusiness');

    }

    public function get_guestlist($eventId)
    {
       $guestlist = $this->event_model->get_guestlist($eventId, $this->vendor_id);
       echo json_encode($guestlist);

    }

    public function get_guestlists()
    {
       $guestlists = $this->event_model->get_guestlists($this->vendor_id);
       echo json_encode($guestlists);

    }

    public function add_guest()
    {
       $data = $this->input->post(null, true);
       $data['guestEmail'] = urldecode($data['guestEmail']);
       $dt = new DateTime( 'now');
       $bookdatetime = $dt->format('Y-m-d H:i:s');
       $ticket = $this->event_model->get_ticket_by_id($this->vendor_id, $data['ticketId']);
       if (empty($ticket)) {
            $response = [
                'status' => '0',
                'messages' => ['Process failed']
            ];
            echo json_encode($response);
            return;
       }

       $ticketQuantity = intval($data['ticketQuantity']);
       $transactionId = $this->generateTransactionId();
       $booking = [
			'customer' => $this->vendor_id,
			'eventId' => $data['ticketId'],
			'eventdate' => date('Y-m-d', strtotime($ticket->StartDate)),
			'bookdatetime' => $bookdatetime,
			'timefrom' => $ticket->StartTime,
			'timeto' => $ticket->EndTime,
			'price' => $ticket->ticketPrice,
            'ticketFee' => ($ticket->ticketFee != null) ? $ticket->ticketFee : 0,
            'paid' => 3,
			'numberofpersons' => 1,
			'name' => $data['guestName'],
			'email' => $data['guestEmail'],
			'ticketDescription' => $ticket->ticketDescription,
			'ticketType' => $ticket->ticketType,
            'guestlist' => 1,
            'TransactionID' => $transactionId,
            'isTicket' => 1
        ];
        
        if (empty($this->event_model->save_guest_reservations($booking, $ticketQuantity))) {
            $response = [
                'status' => '0',
                'messages' => ['Guest reservation(s) not saved']
            ];
            echo json_encode($response);
            return;
        };
        $data['transactionId'] = $transactionId;
        $data['vendorId'] = $this->vendor_id;
        if (!$this->event_model->save_guest($data)) {
            $response = [
                'status' => '0',
                'messages' => ['Guest not saved']
            ];
            echo json_encode($response);
            return;
        }

        $this->emailReservation($transactionId);
        $response = [
            'status' => '1',
            'messages' => ['Guest is added successfully']
        ];
        echo json_encode($response);
    }

    public function delete_guest()
    {
        $id = $this->input->post('id');
        if($this->event_model->delete_guest($this->vendor_id, $id)){
            $response = [
                'status' => 'success',
                'message' => 'The guest is deleted successfully!'
            ];
            echo json_encode($response);
            return ;
        }

        $response = [
            'status' => 'error',
            'message' => 'The guest is not deleted successfully!'
        ];
        echo json_encode($response);
        return ;
    }

    public function delete_multiple_guests()
    {
        $ids = json_decode($this->input->post('ids'));

        if($this->event_model->delete_multiple_guests($this->vendor_id, $ids)){
            $response = [
                'status' => 'success',
                'message' => 'The guests are deleted successfully!'
            ];
            echo json_encode($response);
            return ;
        }

        $response = [
            'status' => 'error',
            'message' => 'The guests are not deleted successfully!'
        ];
        echo json_encode($response);
        return ;
    }

    /*
    public function send_guest_ticket()
    {
        $id = $this->input->post('id');
        $ids = $this->event_model->save_guest_to_bookandpay($this->vendor_id, $id);
        //var_dump($ids);
        if(!$ids){
            $response = [
                'status' => 'error',
                'message' => 'The guest ticket is not sent!'
            ];
            echo json_encode($response);
            return ;
        }

        $reservations = $this->bookandpay_model->getBookingsByIds($ids);

        if(Ticketingemail_helper::sendEmailReservation($reservations, true, true)){
            $response = [
                'status' => 'success',
                'message' => 'The guest ticket is sent successfully!'
            ];
            echo json_encode($response);
            return ;

        }
        
        $response = [
            'status' => 'error',
            'message' => 'The guest ticket is sent successfully!'
        ];
        echo json_encode($response);
        return ;
    }
    */

    public function save_guest_ticket_pdf()
    {
        $id = $this->input->post('id');
        $ids = $this->event_model->save_guest_to_bookandpay($this->vendor_id, $id);
        //var_dump($ids);
        if(!$ids){
            $response = [
                'status' => 'error',
                'message' => 'The pdf file is not generate successfully!'
            ];
            echo json_encode($response);
            return ;
        }

        $reservations = $this->bookandpay_model->getBookingsByIds($ids);
        $template = Ticketingemail_helper::getTemplates($reservations);

        if(count($template) > 0){
            Ticketingemail_helper::sendEmailReservation($reservations, true);
            $response = [
                'status' => 'success',
                'message' => 'The pdf file is generate successfully!',
                'templates' => $template
            ];
            echo json_encode($response);
            return ;

        }
        
        $response = [
            'status' => 'error',
            'message' => 'The pdf file is not generate successfully!'
        ];
        echo json_encode($response);
        return ;
    }

    /*
    public function send_multiple_guests_ticket()
    {
        $guest_ids = json_decode($this->input->post('ids'));
        $bookandpay_ids = $this->event_model->save_multiple_guests_to_bookandpay($this->vendor_id, $guest_ids);
        //var_dump($ids);
        if(count($bookandpay_ids) < 1){
            $response = [
                'status' => 'error',
                'message' => 'The guest ticket is not sent!'
            ];
            echo json_encode($response);
            return ;
        }

        $reservations = $this->bookandpay_model->getBookingsByIds($bookandpay_ids);

        if(Ticketingemail_helper::sendEmailReservation($reservations, true, true)){
            $response = [
                'status' => 'success',
                'message' => 'The guest ticket is sent successfully!'
            ];
            echo json_encode($response);
            return ;

        }
        
        $response = [
            'status' => 'error',
            'message' => 'The guest ticket is sent successfully!'
        ];
        echo json_encode($response);
        return ;
    }
    */

    public function save_multiple_guests_ticket()
    {
        $guest_ids = json_decode($this->input->post('ids'));
        $bookIds = json_decode($this->input->post('bookIds'));
        $guests = $this->event_model->get_guests_by_ids($this->vendor_id, $bookIds);
        $bookandpay_ids = [];
        if(is_countable($guest_ids) && count($guest_ids) > 0){
            $bookandpay_ids = $this->event_model->save_multiple_guests_to_bookandpay($this->vendor_id, $guest_ids);
        }

        $transactionIds = [];

        if(count($guests) > 0){
            foreach($guests as $guest){
                $transactionIds[] = $guest->transactionId;
            }
        }
        
        
        //var_dump($ids);
        if(count($bookandpay_ids) < 1 && count($transactionIds) < 1){
            $response = [
                'status' => 'error',
                'message' => 'Something went wrong!'
            ];
            echo json_encode($response);
            return ;
        }

        $reservationsByIds = [];
        $reservationsByTransactionIds = [];

        if(count($bookandpay_ids) > 1){
            $reservationsByIds = $this->bookandpay_model->getBookingsByIds($bookandpay_ids);
        }

        if(count($transactionIds) > 1){
            $reservationsByTransactionIds = $this->bookandpay_model->getReservationsByTransactionId($transactionIds);
        }

        $reservations = array_merge($reservationsByIds, $reservationsByTransactionIds);
        
        $templates = Ticketingemail_helper::getTemplates($reservations);

        if(count($templates) > 0){
            Ticketingemail_helper::sendEmailReservation($reservations, true);
            $response = [
                'status' => 'success',
                'message' => 'The pdf files are generate successfully!',
                'templates' => $templates
            ];
            echo json_encode($response);
            return ;

        }
        
        
        $response = [
            'status' => 'error',
            'message' => 'The pdf files are not generate successfully!'
        ];
        echo json_encode($response);
        return ;
    }

    public function save_again_guest_ticket()
    {
        $transactionId = $this->input->post('transactionId');
        $reservations = $this->bookandpay_model->getReservationsByTransactionId($transactionId);
        $template = Ticketingemail_helper::getTemplates($reservations);

        if(count($template) > 0){
            Ticketingemail_helper::sendEmailReservation($reservations, true);
            $response = [
                'status' => 'success',
                'message' => 'The pdf file is generate successfully!',
                'templates' => $template
            ];
            echo json_encode($response);
            return ;

        }
        
        $response = [
            'status' => 'error',
            'message' => 'The pdf file is not generate successfully!'
        ];
        echo json_encode($response);
        return ;
    }

    public function import_guestlist()
    {
       $data_post = $this->input->post(null, true);
       $guestName = $data_post['guestName'];
       $guestEmail = $data_post['guestEmail'];
       $ticketQuantity = is_numeric($data_post['ticketQuantity']) ? $data_post['ticketQuantity'] : 1;
       $jsonData = json_decode($data_post['jsonData']);
       $dt = new DateTime( 'now');
       $bookdatetime = $dt->format('Y-m-d H:i:s');
       $ticket = $this->event_model->get_ticket_by_id($this->vendor_id, $data_post['ticketId']);
       $guestlist = [];
       $reservationIds = [];
       foreach($jsonData as $data){
        $transactionId = $this->generateTransactionId();
        $booking = [
			'customer' => $this->vendor_id,
			'eventId' => $data_post['ticketId'],
			'eventdate' => date('Y-m-d', strtotime($ticket->StartDate)),
			'bookdatetime' => $bookdatetime,
			'timefrom' => $ticket->StartTime,
			'timeto' => $ticket->EndTime,
			'price' => $ticket->ticketPrice,
            'ticketFee' => ($ticket->ticketFee != null) ? $ticket->ticketFee : 0,
            'paid' => 3,
			'numberofpersons' => 1,
			'name' => $data->$guestName,
			'email' => $data->$guestEmail,
			'ticketDescription' => $ticket->ticketDescription,
			'ticketType' => $ticket->ticketType,
            'guestlist' => 1,
            'TransactionID' => $transactionId,
            'isTicket' => 1
        ]; 

        $this->event_model->save_guest_reservations($booking, $ticketQuantity); //save to tbl_bookandpay
           
           $guestlist[] = [
               'guestName' => $data->$guestName,
               'guestEmail' => $data->$guestEmail,
               'ticketQuantity' => intval($ticketQuantity),
               'eventId' => intval($data_post['eventId']),
               'ticketId' => intval($data_post['ticketId']),
               'transactionId' => $transactionId,
               'vendorId' => $this->vendor_id
           ];
       }
       $this->event_model->save_multiple_guests($guestlist);
       //$this->emailReservation($transactionId);

    }

    public function resend_reservation()
    {
        $transactionId = $this->input->post('transactionId');
        $sendToSupport = ($this->input->post('sendTo') == 1) ? true : false;
        $supportEmail = ($this->input->post('sendTo') == 1) ? urldecode($this->input->post('email')) : 'support@tiqs.com';
        $reservations = $this->bookandpay_model->getReservationsByTransactionId($transactionId);
        if(Ticketingemail_helper::sendEmailReservation($reservations, true, true, $sendToSupport, $supportEmail)){
            echo 'true';
        } else {
            echo 'false';
        }
        return ;
    }

    public function edit($eventId)
    {
        $this->global['pageTitle'] = 'TIQS: Edit Event';
        $cookie = array( 'eventId', $eventId, time() + 3600);
        setcookie('eventId', $eventId, time() + 3600, '/');
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
        $data['eventimage'] = '';
        $data['backgroundImage'] = '';
        $data = $this->input->post(null, true);
        $data['vendorId'] = $this->vendor_id;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $errors   = $this->upload->display_errors('', '');
            //var_dump($errors);
        } else {
            $upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];
            $data['eventimage'] = $file_name;
        }

        if (!$this->upload->do_upload('backgroundfile')) {
            $errors   = $this->upload->display_errors('', '');
            //var_dump($errors);
        } else {
            $upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];
            $data['backgroundImage'] = $file_name;
        }

//		var_dump($data);
//		die();

        $eventId = $this->event_model->save_event($data);
        redirect('events/event/'.$eventId);

    }

    public function update_event($eventId)
    {
        $data = $this->input->post(null, true);
        $data['vendorId'] = $this->vendor_id;
        $data['eventimage'] = '';
        $data['backgroundImage'] = '';
        $imgChanged = $this->input->post("imgChanged");
        $backgroundImgChanged = $this->input->post("backgroundImgChanged");
        if($imgChanged == 'false') {
            $data['eventimage'] = $data['imgName'];
            unset($data['imgChanged']);
            unset($data['imgName']);
            
        }

        if($backgroundImgChanged == 'false') {
            $data['backgroundImage'] = $data['backgroundImgName'];
            unset($data['backgroundImgChanged']);
            unset($data['backgroundImgName']);
            
        }
        
        $config['upload_path']   = FCPATH . 'assets/images/events';
        $config['allowed_types'] = 'jpg|png|jpeg|webp|bmp';
        $config['max_size']      = '102400'; // 102400 100mb
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $errors   = $this->upload->display_errors('', '');
        } else {
            $upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];
            $data['eventimage'] = $file_name;
            if($data['imgName'] != ''){
                unlink(FCPATH . 'assets/images/events/'.$data['imgName']);
            }
            unset($data['imgChanged']);
            unset($data['imgName']);
        }

        if (!$this->upload->do_upload('backgroundfile')) {
            $errors   = $this->upload->display_errors('', '');
        } else {
            $upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];
            $data['backgroundImage'] = $file_name;
            if($data['backgroundImgName'] != ''){
                unlink(FCPATH . 'assets/images/events/'.$data['backgroundImgName']);
            }
            unset($data['backgroundImgChanged']);
            unset($data['backgroundImgName']);
        }



        $this->event_model->update_event($eventId, $data);
        redirect('events/event/'.$eventId);

    }

    public function save_ticket()
    {
        $data = $this->input->post(null, true);
        if($data['ticketType'] == 'group'){
            $data['ticketType'] = 2;
            $groupId = $this->event_model->save_ticket_group($data['ticketDescription'],$data['ticketQuantity'],$data['eventId']);
            $data['ticketGroupId'] = $groupId;
            //$this->event_model->save_ticket($data);
        } else { 
            $data['ticketType'] = 1;
            $this->event_model->save_ticket($data);
        }
        
        return ;
    }

    public function save_ticket_options()
    {
        $data = $this->input->post(null, true);
        $this->event_model->save_ticket_options($data);
        return ;
    }

    public function get_events()
    {
        $data = $this->event_model->get_all_events($this->vendor_id);
        echo json_encode($data);

    }

    public function get_ticket_options($ticketId)
    {
        $data = $this->event_model->get_ticket_options($ticketId);
        if(is_array($data)){
            $data['startDate'] = date('d-m-Y', strtotime($data['startDate']));
            $data['endDate'] = date('d-m-Y', strtotime($data['endDate']));
        }
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

    public function get_email_templates()
    {
        $vendorId = $this->session->userdata('userId');
        $this->load->model('email_templates_model');
		$emails = $this->email_templates_model->get_ticketing_email_by_user($vendorId);
        echo json_encode($emails);
    }
 
    public function viewdesign($eventId = false): void
    {
        $this->load->model('bookandpayagendabooking_model');
        $this->load->model('shopvendor_model');
        $design = $this->event_model->get_vendor_design($this->vendor_id);
        if($eventId){
            $design = $this->event_model->get_event_design($this->vendor_id, $eventId);
        }


        
        $this->load->model('user_model');
        $userShortUrl = $this->user_model->getUserShortUrlById($this->vendor_id);
        $id = intval($this->shopvendor_model->setProperty('vendorId', $this->vendor_id)->getProperty('id'));
        $data = [ 
            'id' => $id,
            'vendorId' => $this->vendor_id,
            'eventId' => ($eventId == false) ? '' : $eventId,
            'iframeSrc' => ($eventId == false) ? base_url() . 'events/shop/' . $userShortUrl : base_url() . 'events/shop/' . $eventId,
            'design' => unserialize($design),
            'devices' => $this->bookandpayagendabooking_model->get_devices(),
            'userShortUrl' => $userShortUrl,
            'analytics' => $this->event_model->get_shopsettings($this->vendor_id)
        ];

        if($eventId){
            $data['event'] = (object) $this->event_model->get_event_by_id($this->vendor_id, $eventId, false)[0];
        }

        $defaultDesign = $this->event_model->get_vendor_design('1');
        if($defaultDesign){
            $data['defaultDesign'] = unserialize($defaultDesign);
        }
        

        $this->global['pageTitle'] = 'TIQS : DESIGN';
        $this->loadViews('events/design', $this->global, $data, 'footerbusiness', 'headerbusiness');
        return;
    }

    public function save_design($eventId = false)
    {
        $design = $this->input->post(null,true);
        
        $upload_background_image = (!$eventId) ? $this->uploadBodyBackgroundImg() : $this->uploadBodyBackgroundImg($eventId);
        $background_image = isset($design['shop']['background-image']) ? $design['shop']['background-image'] : '';
        $design['shop']['background-image'] = (!$upload_background_image) ? $design['shop']['background-image'] : $upload_background_image;

        if($design['img_delete'] == '1'){
            unlink(FCPATH . 'assets/images/events/' . $design['shop']['background-image']);
            unset($design['shop']['background-image']);
            unset($design['img_delete']);
        }

        if(isset($design['shop']['background-image']) && $design['shop']['background-image'] == ''){
            unset($design['shop']['background-image']);
        }
        
        $design = serialize($design);

        $config['upload_path']   = FCPATH . 'assets/images/events';
        $config['allowed_types'] = 'jpg|png|jpeg|webp|bmp';
        $config['max_size']      = '102400'; // 102400 100mb
        $config['encrypt_name'] = TRUE;


        $event['backgroundImage'] = '';

        //$data['vendorId'] = $this->vendor_id;
        $this->load->library('upload', $config);


        

        if (!$this->upload->do_upload('backgroundfile')) {
            $errors   = $this->upload->display_errors('', '');
            //var_dump($errors);
        } else {
            $upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];
            $backgroundImage = $file_name;
            if($eventId){
                $this->event_model->update_event_background_image($this->vendor_id, $eventId, $backgroundImage);
            }
        }

        if($eventId){
            $this->event_model->save_event_design($this->vendor_id, $eventId, $design);
            redirect('events/viewdesign/'.$eventId);
            return ;
        }

        $this->event_model->save_vendor_design($this->vendor_id, $design);


        redirect('events/viewdesign');
    }

    private function uploadBodyBackgroundImg($eventId = 'main'){
        $config['upload_path']   = FCPATH . 'assets/images/events';
        $config['allowed_types'] = 'jpg|png|jpeg|webp|bmp';
        $config['max_size']      = '102400'; // 102400 100mb
        $config['file_name'] = 'background_img_' . $eventId . "." . pathinfo($_FILES['backgroundimage']['name'], PATHINFO_EXTENSION);
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        //$this->upload->intialize($config);

        $img_name = false;

        if (!$this->upload->do_upload('backgroundimage')) {
            $errors   = $this->upload->display_errors('', '');
            //var_dump($errors);
        } else {
            $upload_data = $this->upload->data();
			$img_name = $upload_data['file_name'];
        }

        return $img_name;

    }

    public function save_shopsettings()
    {
        $data = $this->input->post(null,true);
        if(isset($data['userfile'])) { unset($data['userfile']); }
        $uploaddir = FCPATH . "uploads/termsofuse";

        if (!is_dir($uploaddir)) {
			mkdir($uploaddir, 0777, TRUE);
		}

        $config['upload_path']   = $uploaddir;
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = '102400'; // 102400 100mb
        $config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);

        $pdfFile = '';

        $shopsettings = $this->event_model->get_shopsettings($this->vendor_id);

        

        if (!$this->upload->do_upload('userfile')) {
            $errors   = $this->upload->display_errors('', '');
            //var_dump($errors);
        } else {
            $upload_data = $this->upload->data();
			$pdfFile = $upload_data['file_name'];
            if(isset($shopsettings->termsofuseFile) && $shopsettings->termsofuseFile != ''){
                unlink($uploaddir .'/' . $shopsettings->termsofuseFile);
            }
        }
        $data['termsofuseFile'] = $pdfFile;
        
        $this->event_model->save_shopsettings($this->vendor_id, $data);
        redirect('events/viewdesign');
        return;
    }

    public function update_email_template()
    {
        $id = $this->input->post('id');
        $emailId = $this->input->post('emailId');
        $this->event_model->update_email_template($id, $emailId);
    }

    public function update_ticket()
    {
        $id = $this->input->post('id');
        $param = $this->input->post('param');
        $value = $this->input->post('value');
        $this->event_model->update_ticket($id, $param, $value);
    }

    public function update_group()
    {
        $id = $this->input->post('id');
        $param = $this->input->post('param');
        $value = $this->input->post('value');
        $this->event_model->update_group($id, $param, $value);
    }

    public function update_event_archived() : bool
    {
        $eventId = $this->input->post('id');
        $value = intval($this->input->post('value'));
        return $this->event_model->update_event_archived($this->vendor_id, $eventId, $value);
    }

    public function update_ticket_group()
    {
        $tickets = json_decode($this->input->post('tickets'));
        $results = [];
        foreach($tickets as $ticket){
            if(!isset($ticket->groupId) || !is_numeric($ticket->groupId)){ continue;}
            if(isset($results[$ticket->groupId])){
                $results[$ticket->groupId][0] = $results[$ticket->groupId][0] . ',' . $ticket->ticketId;
            } else {
                $results[$ticket->groupId][0] =  $ticket->ticketId;
            }
            $results[$ticket->groupId][1][$ticket->ticketId] =  $ticket->position;
        }
        return $this->event_model->update_ticket_group($results);
    }

    private function _group_by($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }

    public function delete_ticket()
    {
        $ticketId = $this->input->post('ticketId');
        $this->event_model->delete_ticket($ticketId);
    }

    public function delete_group()
    {
        $groupId = $this->input->post('groupId');
        $this->event_model->delete_group($groupId);
    }

    public function report($eventId)
    {
        $this->global['pageTitle'] = 'TIQS : EVENT REPORT';
        $first_where = [
            'vendorId' => $this->vendor_id,
            'eventId' => '0'
        ];

        $second_where = [
            'vendorId' => $this->vendor_id,
            'eventId' => $eventId
        ];

        $shopInputs = $this->event_model->get_event_inputs($first_where);
        $eventInputs = $this->event_model->get_event_inputs($second_where);
        $shopInputs = is_array($shopInputs) ? $shopInputs : [];
		$eventInputs = is_array($eventInputs) ? $eventInputs : [];
        $inputs = array_merge($shopInputs, $eventInputs);
        $inputs = $this->event_model->unique_multidim_array($inputs, 'fieldName');


		$data['inputs'] = $inputs;
        $data['eventId'] = $eventId;
        $data['event'] = $this->event_model->get_event($this->vendor_id, $eventId);
        $this->loadViews('events/reports', $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function financial_report()
    {
        $this->global['pageTitle'] = 'TIQS : FINANCIAL REPORT';
        $this->loadViews('events/financial_report', $this->global, '', 'footerbusiness', 'headerbusiness');
    }

    public function tags(){
		$this->global['pageTitle'] = 'TIQS: Event Tags';
		
		$this->loadViews("events/tags", $this->global, '', 'footerbusiness', 'headerbusiness'); 
	}

    public function get_event_tags(){
		$where = ['vendorId' => $this->vendor_id];
		$data = $this->event_model->get_event_tags($where);
		echo json_encode($data);
	}

	public function save_event_tags(){
		$data = $this->input->post(null, true);
		$data['vendorId'] = $this->vendor_id;
		if($this->event_model->save_event_tags($data)){
			$response = [
				'status' => 'success',
				'message' => 'Created successfully!'
			];
			echo json_encode($response);
			return ;
		}

		$response = [
			'status' => 'error',
			'message' => 'Something went wrong!'
		];
		echo json_encode($response);
		return ;
		
	}

	public function update_event_tags(){
		$where = [
			'id' => $this->input->post('id'),
			'vendorId' => $this->vendor_id
		];

		$data = [
			'tag' => $this->input->post('tag'),
			'userId' => $this->input->post('userId')
		];

		if($this->event_model->update_event_tags($data, $where)){
			$response = [
				'status' => 'success',
				'message' => 'Updated successfully!'
			];
			echo json_encode($response);
			return ;
		}

		$response = [
			'status' => 'error',
			'message' => 'Something went wrong!'
		];
		echo json_encode($response);
		return ;
	}

	public function delete_event_tags(){
		$where = [
			'id' => $this->input->post('id'),
			'vendorId' => $this->vendor_id
		];
		
		if($this->event_model->delete_event_tags($where)){
			$response = [
				'status' => 'success',
				'message' => 'Deleted successfully!'
			];
			echo json_encode($response);
			return ;
		}

		$response = [
			'status' => 'error',
			'message' => 'Something went wrong!'
		];
		echo json_encode($response);
		return ;
	}


    public function inputs($eventId = false){
		$this->global['pageTitle'] = 'TIQS: Event Inputs';
		$data['eventId'] = $eventId ? $eventId : '0';
		$this->loadViews("events/inputs", $this->global, $data, 'footerbusiness', 'headerbusiness'); 
	}

    public function get_event_inputs(){
        $eventId = $this->input->post('eventId');
		$where = [
            'vendorId' => $this->vendor_id,
            'eventId' => $eventId
        ];
		$data = $this->event_model->get_event_inputs($where);
		echo json_encode($data);
	}

	public function save_event_inputs(){
		$data = $this->input->post(null, true);
		$data['vendorId'] = $this->vendor_id;
		if($this->event_model->save_event_inputs($data)){
			$response = [
				'status' => 'success',
				'message' => 'Created successfully!'
			];
			echo json_encode($response);
			return ;
		}

		$response = [
			'status' => 'error',
			'message' => 'Something went wrong!'
		];
		echo json_encode($response);
		return ;
		
	}

	public function update_event_inputs(){
		$where = [
			'id' => $this->input->post('id'),
			'vendorId' => $this->vendor_id
		];

		$data = [
            'fieldName' => $this->input->post('fieldName'),
			'fieldLabel' => $this->input->post('fieldLabel'),
			'fieldType' => $this->input->post('fieldType'),
            'requiredField' => $this->input->post('requiredField')
		];

		if($this->event_model->update_event_inputs($data, $where)){
			$response = [
				'status' => 'success',
				'message' => 'Updated successfully!'
			];
			echo json_encode($response);
			return ;
		}

		$response = [
			'status' => 'error',
			'message' => 'Something went wrong!'
		];
		echo json_encode($response);
		return ;
	}

	public function delete_event_inputs(){
		$where = [
			'id' => $this->input->post('id'),
			'vendorId' => $this->vendor_id
		];
		
		if($this->event_model->delete_event_inputs($where)){
			$response = [
				'status' => 'success',
				'message' => 'Deleted successfully!'
			];
			echo json_encode($response);
			return ;
		}

		$response = [
			'status' => 'error',
			'message' => 'Something went wrong!'
		];
		echo json_encode($response);
		return ;
	}


    public function graph($eventId)
    {
        $this->global['pageTitle'] = 'TIQS : EVENT GRAPH';
        $data['eventId'] = $eventId;
        $data['event'] = $this->event_model->get_event($this->vendor_id,$eventId);
        $data['days_graph'] = $this->get_graphs($this->vendor_id, $eventId);
        $data['tickets_graph'] = $this->get_tickets_graphs($this->vendor_id, $eventId, false);
        $this->loadViews('events/graph', $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function get_ticket_report()
    {
        $eventId = $this->input->post('eventId');
        $sql = ($this->input->post('sql') == 'AND%20()') ? "" : rawurldecode($this->input->post('sql'));
        $report = $this->event_model->get_event_report($this->vendor_id, $eventId, $sql);
        echo json_encode($report);
    }

    public function get_tickets_report()
    {
        $sql = ($this->input->post('sql') == 'AND%20()') ? "" : rawurldecode($this->input->post('sql'));
        $report = $this->event_model->get_events_report($this->vendor_id, $sql);
        echo json_encode($report);
    }

    public function get_financial_report()
    {
        $sql = ($this->input->post('sql') == 'AND%20()') ? "" : rawurldecode($this->input->post('sql'));
        $report = $this->event_model->get_financial_report($this->vendor_id, $sql);
        echo json_encode($report);
    }

    public function email_designer()
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['page'] = 'Email Templates List';
        $baseUrl = base_url();

        $this->global = [
            'user' => $this->user_model,
            'pageTitle' => 'Email Templates List'
        ];

        $data = [
            'user' => $this->user_model,
            'baseUrl' => $baseUrl,
            'updateTemplate' => $baseUrl . 'update_template' . DIRECTORY_SEPARATOR,
            'templates' => (array) $this->email_templates_model->get_ticketing_email_by_user($this->user_model->id),

        ];

        $this->loadViews("templates/listTemplates", $this->global, $data, "footerbusiness", "headerbusiness");
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
                    "title" => "",
                    "content" => function ($params, $scope) {
                        global $vendorId;
                        global $eventId;
                        global $sql;
                        ColumnChart::create(array(
                            "dataSource" => $this->event_model->get_tickets_report($vendorId, $eventId, true), 
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
                            ),
                        ));
                    }
                ),

 

            ),
           
		), true);
		return $graphs;

	}

    public function get_tickets_graphs($vendorId, $eventId, $sql=''){
        $GLOBALS['vendorId'] = $vendorId;
        $GLOBALS['eventId'] = $eventId;
        $GLOBALS['sql'] = $sql;

		$graphs = DrillDown::create(array(
            "name" => "saleDrillDown",
            "title" => " ",
            "levels" => array(
                array(
                    "title" => "",
                    "content" => function ($params, $scope) {
                        global $vendorId;
                        global $eventId;
                        global $sql;
                        $ticketTypes =$this->event_model->get_tickets_report_types($vendorId, $eventId);
                        $columnArr = array(
                            "days" => array(
                                "type" => "integer",
                                "label" => "Days",
                            )
                            );

                        foreach($ticketTypes as $ticketType){
                            $columnArr[$ticketType] = [
                                "label" => $ticketType,
								"id" => $ticketType,
                            ];
                        }

                        ColumnChart::create(array(
                            "dataSource" => $this->event_model->get_tickets_report($vendorId, $eventId, false), 
                            "columns" => $columnArr,
							"class"=>array(
								"button"=>"bg-warning"
							),
                            
							"colorScheme"=>array(
								"#3366cc",
								"#dc3912"
                            ),
                            "options"=>array(
                                "isStacked"=>true
                            )
                        ));
                    }
                ),

 

            ),
           
		), true);
		return $graphs;

	}

    public function scannedin(){

        $this->global['pageTitle'] = 'Scanned In';

        $data['scan_graphs'] = DrillDown::create(array(
            "name" => "scanDrillDown",
            "title" => "Scan Report",
            "levels" => array(
                array(
                    "title" => "E-Ticketing",
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->event_model->get_scannedin_by_events($this->session->userdata('userId'))), 
                            "columns" => array(
                                "date" => array(
                                    "type" => "string",
                                    "label" => "Date",
                                ),
                                "tickets" => array(
                                    "label" => "Bookings",
                                ),
                                "scanned" => array(
                                    "label" => "Scanned in",
                                ),
                            ),
                            "clientEvents" => array(
                                "itemSelect" => "function(params){
                                    scanDrillDown.next({date:params.selectedRow[0]});
                                }",
                            ),
                            "colorScheme"=>array(
                                "#3366cc",
                                "#ffff00",
                                "#c2b9b0",
                                "#7e685a",
                                "#afd275"
                            )
                        ));
                    }
                ),


            ),
            
        ), true);

        $this->loadViews('events/scannedin_graph', $this->global, $data, 'footerbusiness', 'headerbusiness' );    

    }

    public function clearingtickets()
	{
        $this->global['pageTitle'] = 'TIQS: Clearing Tickets';
        $events = $this->event_model->get_all_events($this->vendor_id);
        $data['event_stats'] = isset($events[0]) ? $this->get_clearing_stats($events[0]['id']) : [];
        $data['payment_stats'] = isset($events[0]) ? $this->event_model->get_payment_methods_stats($this->vendor_id, $events[0]['id']) : [];
        $data['events'] = $events;


        $this->loadViews('events/clearing_tickets', $this->global, $data, 'footerbusiness', 'headerbusiness' );  

    }

    public function clearings()
	{
        $this->global['pageTitle'] = 'TIQS: Event Clearings';
        $data['events'] = $this->event_model->get_all_events($this->vendor_id);

        $this->loadViews('events/event_clearings', $this->global, $data, 'footerbusiness', 'headerbusiness' );  

    }

    public function resend_ticket()
	{
        $reservationId = $this->input->post('reservationId');
        $sendToSupport = ($this->input->post('sendTo') == 1) ? true : false;
        $supportEmail = ($this->input->post('sendTo') == 1) ? urldecode($this->input->post('email')) : 'support@tiqs.com';
        $reservations = $this->bookandpay_model->getReservationsByIds([$reservationId]);
        if(Ticketingemail_helper::sendEmailReservation($reservations, true, true, $sendToSupport, $supportEmail)){
            echo 'true';
        } else {
            echo 'false';
        }
        
        return ;

    }

    public function get_clearing_stats($eventId = false)
	{
        $id = ($eventId !== false) ? $eventId : $this->input->post('eventId');
        $event_stats = $this->event_model->get_clearing_event_stats($this->vendor_id, $id);
        $payment_stats = $this->event_model->get_payment_methods_stats($this->vendor_id, $id);
        $promoterPaid = 0;
        $event_clearing = $this->event_model->get_event_clearings($this->vendor_id, $id);

        if(is_countable($event_clearing) && count($event_clearing) > 0) {
            foreach($event_clearing as $clearing){
                $promoterPaid += floatval($clearing['amount']);
            }
        }

        $payment_stats['promoterPaid'] = $promoterPaid;

        $stats = array_merge($event_stats, $payment_stats);
        
        
        if($eventId !== false){
            return $stats;
        }

        echo json_encode($stats);

        return ;

    }

    public function get_event_clearings()
	{
        $eventId = $this->input->post('eventId');
        if($eventId == '0'){
            $data = $this->event_model->get_event_clearings($this->vendor_id, $eventId);
        }else {
            $data = $this->event_model->get_event_clearings($this->vendor_id, $eventId);
        }
        echo json_encode($data);

    }

    public function get_promoter_paid()
	{
        $eventId = $this->input->post('id');

        $promoterPaid = $this->event_model->get_promoter_amount($this->vendor_id, $eventId);
        echo $promoterPaid;
    }

    public function save_event_clearing()
	{
        $data = $this->input->post(null, true);
        $data['vendorId'] = $this->vendor_id;
        if($this->event_model->add_event_clearings($data)){
            $response = [
                'status' => 'success',
                'message' => 'The event clearing is saved successfully'
            ];

            echo json_encode($response);
            return ;


        }

        $response = [
            'status' => 'error',
            'message' => 'The event clearing is not saved successfully'
        ];
        echo json_encode($response);

    }

    public function update_event_clearing()
	{
        $data = $this->input->post(null, true);
        $id = $data['id'];
        unset($data['id']);
        if($this->event_model->update_event_clearings($this->vendor_id, $id, $data)){
            $response = [
                'status' => 'success',
                'message' => 'The event clearing is updated successfully'
            ];

            echo json_encode($response);
            return ;


        }

        $response = [
            'status' => 'error',
            'message' => 'The event clearing is not updated successfully'
        ];
        echo json_encode($response);

    }

    public function delete_event_clearing()
	{
        $id = $this->input->post('id');

        if($this->event_model->delete_event_clearings($this->vendor_id, $id)){
            $response = [
                'status' => 'success',
                'message' => 'The event clearing is deleted successfully'
            ];

            echo json_encode($response);
            return ;


        }

        $response = [
            'status' => 'error',
            'message' => 'The event clearing is not deleted successfully'
        ];
        echo json_encode($response);

    }

    public function emailReservation($transactionId)
	{
        $reservations = $this->bookandpay_model->getReservationsByTransactionId($transactionId);
        Ticketingemail_helper::sendEmailReservation($reservations, true);
        return ;

    }

    public function copy_event()
	{
        $eventId = $this->input->post('eventId');
        $copy_event = $this->event_model->copy_event($this->vendor_id, $eventId);
        
        $response = [
            'status' => 'success',
            'message' => 'The event is copied successfully!'
        ];

        if(!$copy_event){
            $response = [
                'status' => 'error',
                'message' => 'Something went wrong!'
            ];
        }

        echo json_encode($response);

    }

    public function tags_graphs()
	{
        $this->global['pageTitle'] = 'TIQS: Tags Graphs';
        $reservations = $this->event_model->get_reservations_stats_by_tags($this->vendor_id);



        if(count($reservations) == 0){
            $data['sold_tickets_graph'] = [];
            $data['sold_amount_graph'] = [];
            $data['tags'] = [];
            $data['events'] = [];
            $this->loadViews('events/tags_graphs', $this->global, $data, 'footerbusiness', 'headerbusiness' );  
        }



        $tags = array_values(array_unique($reservations['tags']));
        $events = array_values(array_unique($reservations['events']));
        $sold_tickets = $reservations['sold_tickets'];
        $sold_amount = $reservations['amount'];
        $sold_tickets_graph = [];
        $label = (object) [];
        $emphasis = (object) [];
        $newData = [];
        $soldTicketsArr = [];
        $soldAmountArr = [];



        //Tickets Sold Number graph data
        foreach($tags as $key => $tag){
            
            $label->show = true;
            $emphasis->focus = 'series';
            $newData['name'] = $events[$key];
            $newData['type'] = 'bar';
            $newData['stack'] = 'total';
            $newData['label'] = $label;
            $newData['emphasis'] = $emphasis;

            $tempData = [];
            foreach($events as $event){
                $tempData[] = isset($sold_tickets[$tag][$event]) ? $sold_tickets[$tag][$event] : 0;
            }

            $newData['data'] = $tempData;
            $soldTicketsArr[$key] = (object) $newData;
 
        }

        //Tickets Sold Amount graph data

        foreach($tags as $key => $tag){
 
            $label->show = true;
            $emphasis->focus = 'series';
            $newData = [];
            $newData['name'] = $events[$key];
            $newData['type'] = 'bar';
            $newData['stack'] = 'total';
            $newData['label'] = $label;
            $newData['emphasis'] = $emphasis;

            $tempData = [];
            foreach($events as $event){
                $tempData[] = isset($sold_amount[$tag][$event]) ? number_format($sold_amount[$tag][$event], 2) : '0.00';
            }

            $newData['data'] = $tempData;
            $soldAmountArr[$key] = (object) $newData;
 
        }


      

        $data['sold_tickets_graph'] = $soldTicketsArr;
        $data['sold_amount_graph'] = $soldAmountArr;
        
        $data['tags'] = $tags;
        $data['events'] = $events;
 
        $this->loadViews('events/tags_graphs', $this->global, $data, 'footerbusiness', 'headerbusiness' );  

    }

    public function tags_stats()
	{
        $this->global['pageTitle'] = 'TIQS: Tags Graphs';
        $reservations = $this->event_model->get_reservations_stats_by_tags($this->vendor_id);
        $events = $this->event_model->get_all_events($this->vendor_id);
        $data['events'] = $events;

        $data['graph'] = isset($events[0]) ? $this->get_tags_stats($events[0]['id'], true) : [];


 
        $this->loadViews('events/tags_stats', $this->global, $data, 'footerbusiness', 'headerbusiness' );  

    }

    public function get_tags_stats($eventId = false, $dateRange = false)
    {

        $issetEventId = ($eventId) ? true : false;
        $eventId = ($eventId) ? $eventId : $this->input->post('eventId');
        $dateRange = (!$dateRange) ? urldecode($this->input->post('dateRange')) : '1970-01-01 - 2100-01-01';
        $dateRange = explode(' - ', $dateRange);

        $GLOBALS['eventId'] = $eventId;
        $GLOBALS['startDate'] = $dateRange[0] . ' 00:00:00';
        $GLOBALS['endDate'] = $dateRange[1] . ' 23:59:59';

        $graph = DrillDown::create(array(
            "name" => "saleDrillDown",
            "title" => "Tags Stats",
            "levels" => array(
                array(
                    "title" => "Tickets Sold",
                    "content" => function ($params, $scope) {
                        global $eventId;
                        global $startDate;
                        global $endDate;

                        $conditions = [
                            'eventId' => $eventId,
                            'startDate' => $startDate,
                            'endDate' => $endDate
                        ];

                        $tags = $this->event_model->get_tags_ticket_sold_stats($this->vendor_id, $eventId, $startDate, $endDate);

                        $columnArr['date'] = [
                            "type" => "string",
                            "label" => "Date",
                        ];

                        foreach($tags as $tag){
                            $keys = array_keys($tag);
                            foreach($keys as $key){
                                if($key == 'date') { continue; }
                                $tag = $key;
                                $columnArr[$tag] = [
                                    "label" => $tag
                                ];
                            }
                            
                        }

                        $tags = array_values($tags);


                        
                        ColumnChart::create(array(
                            "dataSource" => $tags, 
                            "columns" => $columnArr,
                            "clientEvents" => array(
                                "itemSelect" => "function(params){
                                    saleDrillDown.next({conditions:" . json_encode($conditions) . "});
                                }",
                            ),
                            "options"=>array(
                                "isStacked"=>true
                            )
                        ));
                    }
                ),

                array(
                    "title" => function ($params, $scope) {
                        return "Amount";
                    },
                    "content" => function ($params, $scope) {

                        $conditions = $params['conditions'];
                        $eventId = $conditions['eventId'];
                        $startDate = $conditions['startDate'];
                        $endDate = $conditions['endDate'];

                        $tags = $this->event_model->get_tags_amount_stats($this->vendor_id, $eventId, $startDate, $endDate);

                        $tags = array_values($tags);

                        $columnArr['date'] = [
                            "type" => "string",
                            "label" => "Date",
                        ];

                        foreach($tags as $tag){
                            $keys = array_keys($tag);
                            foreach($keys as $key){
                                if($key == 'date') { continue; }
                                $tag = $key;
                                $columnArr[$tag] = [
                                    "label" => $tag,
                                    "type"=>"number",
                                    "prefix"=>"€"
                                ];
                            }
                            
                        }


                        ColumnChart::create(array(
                            "dataSource" => $tags, 
                            "columns" => $columnArr,
                            "clientEvents" => array(
                                "itemSelect" => "function(params){
                                    saleDrillDown.next({date:params.selectedRow[0]});
                                }",
                            ),
                            "options"=>array(
                                "isStacked"=>true
                            )
                           
                        ));
                    }
                ),

            ),
            "themeBase" => "bs4",
        ), true);
        if($issetEventId){
            return $graph;
        }
        echo json_encode($graph);

    }

    public function marketing()
	{
        $this->global['pageTitle'] = 'TIQS: Marketing';

        $data['templates'] = $this->email_templates_model->get_mailing_email_by_user($this->vendor_id);
        $this->loadViews('events/marketing', $this->global, $data, 'footerbusiness', 'headerbusiness' );  

    }

    public function send_multiple_emails()
	{
        $ids = json_decode($this->input->post('ids'));
        $emailId = $this->input->post('templateId');
        $reservations = $this->bookandpay_model->getBookingsByIds($ids);

        $response = [
            'status' => 'error',
            'message' => 'Emails are not sent successfully!'
        ];

        if(Ticketingemail_helper::sendEmailReservation($reservations, false, true, false, '', $emailId)){
            $response = [
                'status' => 'success',
                'message' => 'Emails are sent successfully!'
            ];

        }

        echo json_encode($response);

        return ;

    }

    private function generateTransactionId(){
        $set = '3456789abcdefghjkmnpqrstvwxyABCDEFGHJKLMNPQRSTVWXY';
        $transactionId = '14';
        $transactionId .= intval(microtime(true));
        $transactionId .= strtoupper(substr(str_shuffle($set), 0, 10));
        return $transactionId;
    }

    public function add_additional_info()
	{
        $id = $this->input->post('id');
        $additionalInfo = $this->input->post('additionalInfo');
        //var_dump($additionalInfo);
        //exit();
        if($this->event_model->add_additional_info($this->vendor_id, $id, $additionalInfo)){
            $response = [
                'status' => 'success',
                'message' => 'Additional info is added successfully!'
            ];

            echo json_encode($response);
            return ;
        }

        $response = [
            'status' => 'error',
            'message' => 'Additional info is not added successfully!'
        ];

        echo json_encode($response);
    }
    

} 
