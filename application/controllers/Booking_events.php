<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Booking_events extends BaseControllerWeb
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('event_model');
        $this->load->library('language', array('controller' => $this->router->class));
    } 

    public function index($shortUrl = false)
    {
        $this->load->model('user_model');
        $this->session->unset_userdata('customer');
        $this->global['pageTitle'] = 'TIQS: Shop';
        $this->session->unset_userdata('reservationIds');
        $customer = $this->user_model->getUserInfoByShortUrl($shortUrl);
        
        if (!$shortUrl) {
            redirect('https://tiqs.com/info');
        }

        if(!$customer){
            redirect('https://tiqs.com/info');
        }

        if($this->session->userdata('shortUrl') != $shortUrl){
            $this->session->unset_userdata('tickets');
            $this->session->unset_userdata('exp_time');
            $this->session->unset_userdata('total');
        }

        $this->session->set_userdata('customer', $customer->id);
        $this->session->set_userdata('shortUrl', $shortUrl);
        $design = $this->event_model->get_design($customer->id);
        if(isset($design[0])){
            $this->global['design'] = unserialize($design[0]['shopDesign']);
        }
        $data['events'] = $this->event_model->get_events($customer->id);
        $this->loadViews("events/shop", $this->global, $data, 'footerShop', 'headerShop');

    }

    public function tickets($eventId)
    {
        if(!$this->input->post('isAjax')){ 
            redirect('events/shop/'. $this->session->userdata('shortUrl'));
            return; 
        }
        $vendor_id = $this->session->userdata('customer');
        $this->session->unset_userdata("event_date");
        $this->global['pageTitle'] = 'TIQS: Step Two';
        $design = $this->event_model->get_design($vendor_id);
        $this->global['design'] = unserialize($design[0]['shopDesign']);
        $event = $this->event_model->get_event($vendor_id,$eventId);
        $event_start =  date_create($event->StartDate . " " . $event->StartTime);
        $event_end = date_create($event->EndDate . " " . $event->EndTime);
        $event_date = date_format($event_start, "d M Y H:i") . " - ". date_format($event_end, "d M Y H:i");
        $this->session->set_userdata("event_date",$event_date);
        $this->session->set_userdata("startDate",$event->StartDate);
        $this->session->set_userdata("startTime",$event->StartTime);
        $this->session->set_userdata("endDate",$event->EndDate);
        $this->session->set_userdata("endTime",$event->EndTime);
        $this->session->set_userdata("eventImage",$event->eventImage);
        $data = [
            'tickets' => $this->event_model->get_tickets($vendor_id,$eventId),
            'eventId' => $eventId,
            'eventName' => $event->eventname,
            'eventImage' => $event->eventImage
        ];
        $result = $this->load->view("events/tickets", $data,true);
				if( isset($result) ) {
					return $this->output
					->set_content_type('application/json')
					->set_status_header(200)
					->set_output(json_encode($result));
				}
        $this->loadViews("events/tickets", $this->global, $data, 'footerShop', 'headerShop');

    }

    public function your_tickets()
    {
        $this->global['pageTitle'] = 'TIQS: Your Tickets';
        $vendor_id = $this->session->userdata('customer');
        $results = $this->input->post(null, true);
        if(count($results) > 0){
            $total = 0;
            $quantities = $results['quantity'];
            $id = $results['id'];
            $descript = $results['descript'];
            $price = $results['price'];
            $tickets = [];
 
            foreach($quantities as $key => $quantity){
                if($quantity == '0'){ continue; }
                $amount = floatval($price[$key])*floatval($quantity);
                $total = $total + $amount;
                    $tickets[$id[$key]] = [
                        'id' => $id[$key],
                        'descript' => $descript[$key],
                        'quantity' => $quantity,
                        'price' => $price[$key],
                        'amount' => $amount,
                        'startDate' => $this->session->userdata("startDate"),
                        'startTime' => $this->session->userdata("startTime"),
                        'endDate' => $this->session->userdata("endDate"),
                        'endTime' => $this->session->userdata("endTime")
                    ];
            }
            if($this->session->tempdata('tickets')){
                $old_tickets = $this->session->tempdata('tickets');
                $tickets1 = $this->check_diff_multi($tickets, $old_tickets);
                $tickets2 = $this->check_diff_multi($old_tickets, $tickets);
                $tickets = $tickets1 + $tickets2;
                //$tickets = $this->unique_multidim_array($tickets, 'id');
            }
            
            $this->session->set_tempdata('tickets', $tickets, 600);
            $current_time = date($results['current_time']);
            $newTime = date("Y-m-d H:i:s",strtotime("$current_time +10 minutes"));
            $this->session->set_tempdata('exp_time', $newTime, 600);
            $total = number_format($total, 2, '.', '');
            $this->session->set_tempdata('total', $total, 600);
        }
        if(!$this->session->tempdata('tickets')){
            $this->session->set_flashdata('expired', 'Session Expired!');
            redirect('events/shop/'. $this->session->userdata('shortUrl'));
        }
   
        $this->loadViews("events/your_tickets", $this->global, '', 'footerShop', 'headerShop');

    }

    public function add_to_basket()
    {
        $vendor_id = $this->session->userdata('customer');
        $first_ticket = false;
        if(!$this->session->userdata('tickets')){
            $first_ticket = true;
        }
        $tickets = $this->session->userdata('tickets') ?? [];
        $ticket = $this->input->post(null, true);
        $current_time = date($ticket['time']);
        $newTime = date("Y-m-d H:i:s",strtotime("$current_time +10 minutes"));
        $this->session->set_tempdata('exp_time', $newTime, 600);
        $amount = floatval($ticket['price'])*floatval($ticket['quantity']);
        $ticketId = $ticket['id'];
        unset($tickets[$ticketId]);
        $tickets[$ticketId] = [
            'id' => $ticketId,
            'descript' => $ticket['descript'],
            'quantity' => $ticket['quantity'],
            'price' => $ticket['price'],
            'amount' => $amount,
            'startDate' => $this->session->userdata("startDate"),
            'startTime' => $this->session->userdata("startTime"),
            'endDate' => $this->session->userdata("endDate"),
            'endTime' => $this->session->userdata("endTime")
        ];
        
        echo json_encode(['descript'=>$ticket['descript'],'price' => $ticket['price'], 'first_ticket' => $first_ticket]);
        
        if($ticket['quantity'] != 0){
            $this->session->unset_userdata('tickets');
            $this->session->unset_tempdata('tickets');
            $this->session->set_tempdata('tickets', $tickets, 600);
        }

        $total = 0;
        foreach($tickets as $ticket){
            $total = $total + $ticket['amount'];
        }
        $total = number_format($total, 2, '.', '');
        $this->session->set_tempdata('total', $total, 600);  
    }

    public function clear_tickets()
    {
        $this->session->unset_userdata('tickets');
        $this->session->unset_userdata('exp_time');
        $this->session->unset_userdata('total');
        $this->session->unset_tempdata('tickets');
        $this->session->unset_tempdata('exp_time');
        $this->session->unset_tempdata('total');
        if(!$this->session->tempdata('tickets')){
            $this->session->set_flashdata('expired', 'Session Expired!');
            redirect('events/shop/'. $this->session->userdata('shortUrl'));
        }
    }

    public function pay()
    {
        $this->global['pageTitle'] = 'TIQS: Pay';
        if(!$this->session->tempdata('tickets')){
            $this->session->set_flashdata('expired', 'Session Expired!');
            redirect('events/shop/'. $this->session->userdata('shortUrl'));
        }
        $this->loadViews("events/pay", $this->global, '', 'footerShop', 'headerShop');
    }

    public function selectpayment()
    {
        $userInfo = $this->input->post(null, true);
        $tickets = $this->session->userdata('tickets');
        //$this->session->unset_userdata('tickets');
        //$this->session->unset_userdata('total');

        $customer = $this->session->userdata('customer');

        if(!$this->session->userdata('reservationIds')){
            $reservationIds = $this->event_model->save_event_reservations($userInfo,$tickets, $customer);
            $this->session->set_userdata('reservationIds', $reservationIds);
            //$this->emailReservation($userInfo['email']);
        }

        $this->global['pageTitle'] = 'TIQS: Select Payment';
        $this->session->set_userdata('userInfo', $userInfo);
        
        
        $this->loadViews("events/selectpayment", $this->global, '', 'footerShop', 'headerShop');
    }


    public function delete_ticket()
    {
        $tickets = $this->session->tempdata('tickets');
        $ticketId = $this->input->post('id');
        $time = (int)($this->input->post('current_time')/1000);
        $time = $time - 2;
        unset($tickets[$ticketId]);
        
        $this->session->unset_userdata('tickets');
        $this->session->unset_tempdata('tickets');
        $this->session->set_tempdata('tickets', $tickets, $time);
        return ;
    }


    function check_diff_multi($array1, $array2){
        $result = array();
        foreach($array1 as $key => $val) {
             if(isset($array2[$key])){
               if(is_array($val) && $array2[$key]){
                   $result[$key] = $this->check_diff_multi($val, $array2[$key]);
               }
           } else {
               $result[$key] = $val;
           }
        }
    
        return $result;
    }

    
    public function emailReservation($email)
	{
        require APPPATH . '/libraries/phpqrcode/qrlib.php';
        $this->load->model('bookandpay_model');
        $this->load->model('sendreservation_model');
        $this->load->model('email_templates_model');
        $reservationIds = $this->session->userdata('reservationIds');
        $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
        $eventdate = '';
        $i = 0;
        foreach ($reservations as $key => $reservation):
            $eventdate = $reservation->eventdate;
            $data['paid'] = '1';
            $this->bookandpay_model->editbookandpay($data, $reservationIds[$i]);
            $result = $this->sendreservation_model->getReservationByMailandEventDate($email, $eventdate);
            
            $TransactionId='empty';
            
            foreach ($result as $record) {
                $customer = $record->customer;
				$eventid = $record->eventid;
				$eventdate = $record->eventdate;
				$reservationId = $record->reservationId;
				$price = $record->price;
				$Spotlabel = $record->Spotlabel;
				$numberofpersons = $record->numberofpersons;
				$name = $record->name;
				$email = $record->email;
				$mobile = $record->mobilephone;
				$reservationset = $record->reservationset;
				$fromtime = $record->timefrom;
				$totime = $record->timeto;
				$paid = $record->paid;
				$TransactionId = $record->TransactionID;
                $voucher = $record->voucher;
                
                
                    if ($paid == 1) {
                        
                        $qrtext = $reservationId;

						switch (strtolower($_SERVER['HTTP_HOST'])) {
							case 'tiqs.com':
								$file = '/home/tiqs/domains/tiqs.com/public_html/alfred/uploads/qrcodes/';
								break;
							case '127.0.0.1':
								$file = 'C:/wamp64/www/tiqs/booking2020/uploads/qrcodes/';
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
								$SERVERFILEPATH = 'http://127.0.0.1/spot/uploads/thuishaven/qrcodes/';
								break;
							default:
								break;
                        }

                        $emailId = $this->event_model->get_ticket($eventid)->emailId;
                        
						switch (strtolower($_SERVER['HTTP_HOST'])) {
							case 'tiqs.com':
								$SERVERFILEPATH = 'https://tiqs.com/alfred/uploads/qrcodes/';
								break;
							case '127.0.0.1':
								$SERVERFILEPATH = 'http://127.0.0.1/spot/uploads/thuishaven/qrcodes/';
								break;
							default:
								break;
                        }
                        
						if($emailId) {
                            $emailTemplate = $this->email_templates_model->get_emails_by_id($emailId);
                            $mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$customer.'/'.$emailTemplate->template_file);
                            $qrlink = $SERVERFILEPATH . $file_name1;
							if($mailtemplate) {
								$mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$customer.'/'.$emailTemplate->template_file);
								$mailtemplate = str_replace('[customer]', $customer, $mailtemplate);
								$mailtemplate = str_replace('[eventdate]', date('d.m.yy', strtotime($eventdate)), $mailtemplate);
								$mailtemplate = str_replace('[reservationId]', $reservationId, $mailtemplate);
								$mailtemplate = str_replace('[price]', $price, $mailtemplate);
								$mailtemplate = str_replace('[spotlabel]', $Spotlabel, $mailtemplate);
								$mailtemplate = str_replace('[numberofpersons]', $numberofpersons, $mailtemplate);
								$mailtemplate = str_replace('[name]', $name, $mailtemplate);
								$mailtemplate = str_replace('[email]', $email, $mailtemplate);
								$mailtemplate = str_replace('[mobile]', $mobile, $mailtemplate);
								$mailtemplate = str_replace('[fromtime]', $fromtime, $mailtemplate);
								$mailtemplate = str_replace('[totime]', $totime, $mailtemplate);
								$mailtemplate = str_replace('[TransactionId]', $TransactionId, $mailtemplate);
								$mailtemplate = str_replace('[voucher]', $voucher, $mailtemplate);
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
								$mailtemplate = str_replace('Image', '', $mailtemplate);
                                $mailtemplate = str_replace('Text', '', $mailtemplate);
                                $mailtemplate = str_replace('Title', '', $mailtemplate);
                                $mailtemplate = str_replace('QR Code', '', $mailtemplate);
                                $mailtemplate = str_replace('Divider', '', $mailtemplate);
                                $mailtemplate = str_replace('Button', '', $mailtemplate);
                                $mailtemplate = str_replace('Social Links', '', $mailtemplate);
								$subject = 'Your tiqs reservation(s)';

								$datachange['mailsend'] = 1;
								$this->sendEmail("pnroos@icloud.com", $subject, $mailtemplate);
								if($this->sendEmail($email, $subject, $mailtemplate)) {
                                    $this->sendreservation_model->editbookandpaymailsend($datachange, $reservationId);
                                    redirect('booking/successbooking');
                                }
                            
                        }
                    }
                }
            }
            $i++;
            endforeach;
        }

    public function sendEmail($email, $subject, $message)
	{
		$configemail = array(
			'protocol' => PROTOCOL,
			'smtp_host' => SMTP_HOST,
			'smtp_port' => SMTP_PORT,
			'smtp_user' => SMTP_USER, // change it to yours
			'smtp_pass' => SMTP_PASS, // change it to yours
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'smtp_crypto' => 'tls',
			'wordwrap' => TRUE,
			'newline' => "\r\n"
		);

		$config = $configemail;
		$CI =& get_instance();
		$CI->load->library('email', $config);
		$CI->email->set_header('X-SES-CONFIGURATION-SET', 'ConfigSet');
		$CI->email->set_newline("\r\n");
		$CI->email->from('support@tiqs.com');
		$CI->email->to($email);
		$CI->email->subject($subject);
		$CI->email->message($message);
		return $CI->email->send();
    }



}