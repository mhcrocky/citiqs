<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
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

    public function payment_proceed()
    {
        $this->load->model('bookandpay_model');
        $totalPrice = 0;
        $buyerInfo = $this->input->post(null, true);
        $tickets = $this->session->userdata('tickets');
        $this->session->set_userdata('eventShop', 'true');
        $this->session->set_userdata('buyerEmail', $buyerInfo['email']);
        $customer = $this->session->userdata('customer');
        if(!$this->session->userdata('reservationIds')){
            $reservationIds = $this->event_model->save_event_reservations($buyerInfo, $tickets, $customer);
            $this->session->set_userdata('reservationIds', $reservationIds);
            
        }
        $reservationIds = $this->session->userdata('reservationIds');
        $arrArguments = array();

        if ($buyerInfo) {
            $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);

            foreach ($reservations as $key => $reservation) {
                $totalPrice += floatval($reservation->price);

                if ($key == 0) {
                    $arrArguments['transaction']['description'] = "tiqs - " . $reservation->eventdate . " - " . $reservation->timeslot;
                    $arrArguments['finishUrl'] = base_url() . 'booking/successpay/' . $reservation->reservationId;
                }

                $arrArguments['statsData']['extra' . ($key + 1)] = $reservation->reservationId;
                $arrArguments['saleData']['orderData'][$key]['productId'] = $reservation->reservationId;
                $arrArguments['saleData']['orderData'][$key]['description'] = $reservation->Spotlabel;
                $arrArguments['saleData']['orderData'][$key]['productType'] = 'HANDLIUNG';
                $arrArguments['saleData']['orderData'][$key]['price'] = $reservation->price * 100;
                $arrArguments['saleData']['orderData'][$key]['quantity'] = 1;
                $arrArguments['saleData']['orderData'][$key]['vatCode'] = 'H';
                $arrArguments['saleData']['orderData'][$key]['vatPercentage'] = '0.00';

                if ($reservation->SpotId != 3) {
                    $this->bookandpay_model->newvoucher($reservation->reservationId);
                }

                $this->bookandpay_model->editbookandpay([
                    'mobilephone' => $buyerInfo['mobileNumber'],
                    'email' => $buyerInfo['email'],
                ], $reservation->reservationId);
            }
        } else {
            redirect('agenda_booking/pay');
        }

        $price = $totalPrice * 100;
        $priceofreservation = $price;

        if ($price == 1000) {
            $price = $price + 90;  // service fee.
        } elseif ($price == 2000) {
            $price = $price + 180;
        } elseif ($price == 3000) {
            $price = $price + 270;  // service fee.
        } elseif ($price == 4000) {
            $price = $price + 360;  // service fee.
        } elseif ($price == 5000) {
            $price = $price + 450;  // service fee.
        } elseif ($price == 6000) {
            $price = $price + 540;  // service fee.
        } elseif ($price == 7000) {
            $price = $price + 630;  // service fee.
        } elseif ($price == 8000) {
            $price = $price + 720;  // service fee.
        } elseif ($price == 15000) {
            $price = $price + 400;  // service fee.
        } elseif ($price == 20000) {
            $price = $price + 600;
        }// service fee.
        elseif ($price == 30000) {
            $price = $price + 800;
        }// service fee.
        elseif ($price == 16000) {
            $price = $price + 490;  // service fee.
        } elseif ($price == 17000) {
            $price = $price + 580;  // service fee.
        }

        $priceoffee = $price - $priceofreservation;

        $data['finalbedrag'] = $price / 100;
        $data['finalbedragfee'] = $priceoffee / 100;
        $data['finalbedragexfee'] = $priceofreservation / 100;
		$customer = $this->session->userdata('customer');
		$SlCode = $this->bookandpay_model->getUserSlCode($customer['id']);
		$arrArguments['serviceId'] = $SlCode;  // TEST PAYNL_SERVICE_ID_CHE/K424; SL-3157-0531(thuishaven) (eigen test SL-2247-8501)
//
//		$arrArguments['serviceId'] = "SL-2247-8501";  // TEST PAYNL_SERVICE_ID_CHE/K424; SL-3157-0531(thuishaven) (eigen test SL-2247-8501)

        $arrArguments['amount'] = $price;
        $arrArguments['ipAddress'] = $_SERVER['REMOTE_ADDR'];

        $payData['format'] = 'json';
        $payData['tokenid'] = PAYNL_DATA_TOKEN_ID;

        $payData['token'] = PAYNL_DATA_TOKEN;
        $payData['gateway'] = 'rest-api.pay.nl';
        $payData['namespace'] = 'Transaction';
        $payData['function'] = 'start';
        $payData['version'] = 'v13';

        $strUrl = 'http://' . $payData['tokenid'] . ':' . $payData['token'] . '@' . $payData['gateway'] . '/' . $payData['version'] . '/' . $payData['namespace'] . '/' .
            $payData['function'] . '/' . $payData['format'] . '?';

        $orderExchangeUrl = base_url() . '/booking/ExchangePay';

        $arrArguments['statsData']['promotorId'] = $customer['id'];
        $arrArguments['enduser']['emailAddress'] = $buyerInfo['email'];
        $arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
        $arrArguments['saleData']['deliveryDate'] = date('d-m-Y');

        $arrArguments['enduser']['language'] = 'NL';
        $arrArguments['transaction']['orderExchangeUrl'] = $orderExchangeUrl;

        $this->session->set_userdata('payment_data', [
            'strUrl' => $strUrl,
            'arrArguments' => $arrArguments,
            'discountAmount' => $arrArguments['amount'],
            'final_amount' => $data['finalbedrag'],
            'final_amountex' => $data['finalbedragexfee'],
            'final_amountfee' => $data['finalbedragfee'],
        ]);

        if($data['finalbedrag'] == 0){
            $this->emailReservation($buyerInfo['email'], $reservationIds);
        } else {
            redirect('/events/selectpayment');
        }
        
    }

    public function selectpayment()
    {
        
        //$this->session->unset_userdata('tickets');
        //$this->session->unset_userdata('total');



        $this->global['pageTitle'] = 'TIQS: Select Payment';
        
        
        $this->loadViews("events/selectpayment", $this->global, '', 'footerShop', 'headerShop');
    }

    public function paydorian()
    {
        $this->emailReservation($this->session->userdata('userEmail'));
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

    
    public function emailReservation()
	{
        $this->load->model('bookandpay_model');
        $this->load->model('sendreservation_model');
        $this->load->model('email_templates_model');
        $email = (null !== $this->input->post('email') && !empty($this->input->post('email'))) ? rawurldecode($this->input->post('email')) : $this->session->userdata('buyerEmail');
        $reservationIds = (null !== $this->input->post('reservationId') && !empty($this->input->post('reservationId'))) ? $this->input->post('reservationId') : $this->session->userdata('reservationIds');
        $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
        $eventdate = '';
        $i = 0;
        foreach ($reservations as $key => $reservation):
            $eventdate = $reservation->eventdate;
            $data['paid'] = '1';
            $this->bookandpay_model->editbookandpay($data, $reservationIds[$i]);
            $result = $this->sendreservation_model->getEventReservationData($reservation->reservationId, $email, $eventdate);
            
            $TransactionId='empty';
            
            foreach ($result as $record) {
                $customer = $record->customer;
				$eventDate = $record->eventdate;
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
                $buyerEmail = $record->email;
				$buyerMobile = $record->mobilephone;
				$reservationset = $record->reservationset;

				//$fromtime = $record->timefrom;
				//$totime = $record->timeto;
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
								$mailtemplate = str_replace('[ticketQuantity]', $ticketQuantity, $mailtemplate);
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
								$subject = 'Your tiqs reservation(s)';

								$datachange['mailsend'] = 1;
								$this->sendEmail("pnroos@icloud.com", $subject, $mailtemplate);
								if($this->sendEmail($email, $subject, $mailtemplate)) {
                                    $this->sendreservation_model->editbookandpaymailsend($datachange, $reservationId);
                                    if(null === $this->input->post('reservationId') || empty($this->input->post('reservationId'))){
                                        $this->session->sess_destroy();
                                        redirect('booking/successbooking');
                                    }
                                    
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