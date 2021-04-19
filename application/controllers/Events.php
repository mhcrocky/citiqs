<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

include(APPPATH . '/libraries/koolreport/core/autoload.php');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
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
        $this->load->helper('email_helper');
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
        $this->load->model('shopvoucher_model');
		$what = ['tbl_shop_voucher.id' ,'tbl_shop_voucher.description', 'tbl_email_templates.template_name'];
        $join = [
			0 => [
				'tbl_email_templates',
				'tbl_email_templates.id = tbl_shop_voucher.emailId',
				'right'
			]
		];
		$where = ["tbl_shop_voucher.vendorId" => $this->vendor_id];
        $data = [
            'event' => $this->event_model->get_event($this->vendor_id,$eventId),
            'eventId' => $eventId,
            'emails' => $this->email_templates_model->get_ticketing_email_by_user($this->vendor_id),
            'vouchers' => $this->shopvoucher_model->read($what,$where,$join, 'group_by', ['tbl_shop_voucher.id']),
            'groups' => $this->event_model->get_ticket_groups($eventId),
            'guests' => $this->event_model->get_guestlist($eventId, $this->vendor_id)
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
       $booking = [
			'customer' => $this->vendor_id,
			'eventId' => $data['ticketId'],
			'eventdate' => date('Y-m-d', strtotime($ticket->StartDate)),
			'bookdatetime' => $bookdatetime,
			'timefrom' => $ticket->StartTime,
			'timeto' => $ticket->EndTime,
			'price' => 0,
            'paid' => 3,
			'numberofpersons' => $data['ticketQuantity'],
			'name' => $data['guestName'],
			'email' => $data['guestEmail'],
			'ticketDescription' => $ticket->ticketDescription,
			'ticketType' => $ticket->ticketType
        ];
        
        $reservationId = $this->event_model->save_guest_reservations($booking);
        $data['reservationId'] = $reservationId;
        $this->event_model->save_guest($data);
        $this->emailReservation([$reservationId]);

    }

    public function import_guestlist()
    {
       $data_post = $this->input->post(null, true);
       $guestName = $data_post['guestEmail'];
       $guestEmail = $data_post['guestEmail'];
       $ticketQuantity = $data_post['ticketQuantity'];
       $jsonData = json_decode($data_post['jsonData']);
       $dt = new DateTime( 'now');
       $bookdatetime = $dt->format('Y-m-d H:i:s');
       $ticket = $this->event_model->get_ticket_by_id($this->vendor_id, $data_post['ticketId']);
       $guestlist = [];
       $reservationIds = [];
       foreach($jsonData as $data){
           
        $booking = [
			'customer' => $this->vendor_id,
			'eventId' => $data_post['ticketId'],
			'eventdate' => date('Y-m-d', strtotime($ticket->StartDate)),
			'bookdatetime' => $bookdatetime,
			'timefrom' => $ticket->StartTime,
			'timeto' => $ticket->EndTime,
			'price' => 0,
            'paid' => 3,
			'numberofpersons' => $data->$ticketQuantity,
			'name' => $data->$guestName,
			'email' => $data->$guestEmail,
			'ticketDescription' => $ticket->ticketDescription,
			'ticketType' => $ticket->ticketType
        ];

        $reservationId = $this->event_model->save_guest_reservations($booking);
        $reservationIds[] = $reservationId;
           
           $guestlist[] = [
               'guestName' => $data->$guestName,
               'guestEmail' => $data->$guestEmail,
               'ticketQuantity' => intval($data->$ticketQuantity),
               'eventId' => intval($data_post['eventId']),
               'ticketId' => intval($data_post['ticketId']),
               'reservationId' => $reservationId
           ];
       }
       $this->event_model->save_multiple_guests($guestlist);
       $this->emailReservation($reservationIds);

    }

    public function resend_reservation()
    {
        $reservationId = $this->input->post('reservationId');
        $this->emailReservation([$reservationId]);
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
        $data['eventimage'] = '';
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
        $eventId = $this->event_model->save_event($data);
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
 
    public function viewdesign(): void
    {
        $this->load->model('bookandpayagendabooking_model');
        $this->load->model('shopvendor_model');
        $design = $this->event_model->get_design($this->vendor_id);
        $this->load->model('user_model');
        $userShortUrl = $this->user_model->getUserShortUrlById($this->vendor_id);
        $id = intval($this->shopvendor_model->setProperty('vendorId', $this->vendor_id)->getProperty('id'));
        $data = [ 
            'id' => $id,
            'vendorId' => $this->vendor_id,
            'iframeSrc' => base_url() . 'events/shop/' . $userShortUrl,
            'design' => unserialize($design[0]['shopDesign']),
            'devices' => $this->bookandpayagendabooking_model->get_devices(),
            'userShortUrl' => $userShortUrl,
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

    public function update_ticket_group()
    {
        $tickets = json_decode($this->input->post('tickets'));
        $results = [];
        foreach($tickets as $ticket){
            if(!isset($ticket->groupId) || !is_numeric($ticket->groupId)){ continue;}
            if(isset($results[$ticket->groupId])){
                $results[$ticket->groupId] = $results[$ticket->groupId] . ',' . $ticket->ticketId;
            } else {
                $results[$ticket->groupId] =  $ticket->ticketId;
            }
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
        $data['eventId'] = $eventId;
        $data['event'] = $this->event_model->get_event($this->vendor_id,$eventId);
        $this->loadViews('events/reports', $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function financial_report()
    {
        $this->global['pageTitle'] = 'TIQS : FINANCIAL REPORT';
        $this->loadViews('events/financial_report', $this->global, '', 'footerbusiness', 'headerbusiness');
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


    private function emailReservation($reservationIds)
	{
        $this->load->model('bookandpay_model');
        $this->load->model('sendreservation_model');
        $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
        foreach ($reservations as $key => $reservation):
            $result = $this->sendreservation_model->getEventTicketingData($reservation->reservationId);
            
            foreach ($result as $record) {
                $customer = $record->customer;
				$eventDate = $record->eventdate;
                $endDate = $record->EndDate;
                $eventName = $record->eventname;
                $eventVenue = $record->eventVenue;
                $eventAddress = $record->eventAddress;
                $eventCity = $record->eventCity;
                $eventCountry = $record->eventCountry;
                $eventZipcode = $record->eventZipcode;
				$reservationId = $record->reservationId;
				$ticketPrice = $record->price;
                $ticketId = $record->ticketId;
                $ticketDescription = $record->ticketDescription;
				$ticketQuantity = $record->numberofpersons;
                $eventZipcode = $record->ticketDescription;
                $buyerName = $record->name;
                $buyerEmail = $record->email;
				$buyerMobile = $record->mobilephone;
				$reservationset = $record->reservationset;

				$fromtime = $record->timefrom;
				$totime = $record->timeto;
				$paid = $record->paid;
				$TransactionId = $record->TransactionID;
                $voucher = $record->voucher;
                
                
                    if (true) {
                        
                        $qrtext = $reservationId;

						switch (strtolower($_SERVER['HTTP_HOST'])) {
							case 'tiqs.com':
								$file = '/home/tiqs/domains/tiqs.com/public_html/alfred/uploads/qrcodes/';
								break;
							case '127.0.0.1':
								$file = 'C:/wamp64/www/alfred/alfred/uploads/qrcodes/';
								break;
							default:
								break;
						}

						$SERVERFILEPATH = $file;
						$text = $qrtext;
						$folder = $SERVERFILEPATH;
						$file_name1 = $qrtext . ".png";
						$file_name = $folder . $file_name1;

						QRcode::png($text, $file_name);

						switch (strtolower($_SERVER['HTTP_HOST'])) {
							case 'tiqs.com':
								$SERVERFILEPATH = 'https://tiqs.com/alfred/uploads/qrcodes/';
								break;
							case '127.0.0.1':
								$SERVERFILEPATH = 'http://127.0.0.1/alfred/alfred/uploads/qrcodes/';
								break;
							default:
								break;
                        }

                        $emailId = $this->event_model->get_ticket($ticketId)->emailId;
                        
                        
						switch (strtolower($_SERVER['HTTP_HOST'])) {
							case 'tiqs.com':
								$SERVERFILEPATH = 'https://tiqs.com/alfred/uploads/qrcodes/';
								break;
							case '127.0.0.1':
								$SERVERFILEPATH = 'http://127.0.0.1/alfred/alfred/uploads/qrcodes/';
								break;
							default:
								break;
                        }

                        
						if($emailId) {
                            $emailTemplate = $this->email_templates_model->get_emails_by_id($emailId);
                            $this->config->load('custom');
                            
                            $mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$customer.'/'.$emailTemplate->template_file .'.'.$this->config->item('template_extension'));
                            $qrlink = $SERVERFILEPATH . $file_name1;
							if($mailtemplate) {
                                $dt = new DateTime('now');
                                $date = $dt->format('Y.m.d');
                                $mailtemplate = str_replace('[currentDate]', $buyerName, $mailtemplate);
                                $mailtemplate = str_replace('[buyerName]', $buyerName, $mailtemplate);
								$mailtemplate = str_replace('[buyerEmail]', $buyerEmail, $mailtemplate);
                                $mailtemplate = str_replace('[buyerMobile]', $buyerMobile, $mailtemplate);
                                $mailtemplate = str_replace('[eventName]', $eventName, $mailtemplate);
								$mailtemplate = str_replace('[eventDate]', date('d.m.Y', strtotime($eventDate)), $mailtemplate);
								$mailtemplate = str_replace('[eventVenue]', $eventVenue, $mailtemplate);
								$mailtemplate = str_replace('[eventAddress]', $eventAddress, $mailtemplate);
                                $mailtemplate = str_replace('[eventCity]', $eventCity, $mailtemplate);
								$mailtemplate = str_replace('[eventCountry]', $eventCountry, $mailtemplate);
								$mailtemplate = str_replace('[eventZipcode]', $eventZipcode, $mailtemplate);
								$mailtemplate = str_replace('[ticketDescription]', $ticketDescription, $mailtemplate);
								$mailtemplate = str_replace('[ticketPrice]', $ticketPrice, $mailtemplate);
                                $mailtemplate = str_replace('[price]', $ticketPrice, $mailtemplate);
								$mailtemplate = str_replace('[ticketQuantity]', $ticketQuantity, $mailtemplate);
                                $mailtemplate = str_replace('[numberOfPersons]', $ticketQuantity, $mailtemplate);
                                $mailtemplate = str_replace('[startTime]', $fromtime, $mailtemplate);
								$mailtemplate = str_replace('[endTime]', $totime, $mailtemplate);
								$mailtemplate = str_replace('[timeSlot]', '', $mailtemplate);
								$mailtemplate = str_replace('[transactionId]', $TransactionId, $mailtemplate);
								$mailtemplate = str_replace('[voucher]', $voucher, $mailtemplate);
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
								$subject = ($emailTemplate->template_subject) ? strip_tags($emailTemplate->template_subject) : 'Your tiqs reservation(s)';
								$datachange['mailsend'] = 1;
                                
								//Email_helper::sendEmail("pnroos@icloud.com", $subject, $mailtemplate, false );
								if(Email_helper::sendEmail($buyerEmail, $subject, $mailtemplate, false)) {
                                    $this->sendreservation_model->editbookandpaymailsend($datachange, $reservationId);
                                    
                                }
                            
                        }
                    }
                }
            }
            endforeach;
        }
    

} 