<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
include APPPATH . '/libraries/ical/ICS.php';

class Booking_events extends BaseControllerWeb
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('pay_helper');
        $this->load->helper('pdf_helper');
        $this->load->model('event_model');
        $this->load->model('bookandpay_model');
        $this->load->model('sendreservation_model');
        $this->load->model('email_templates_model');
        $this->load->config('custom');
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
        
        $eventId = '';
        $get_by_event_id = false;
        
        if(!$customer){
            if(is_numeric($shortUrl)){
                $eventId = $shortUrl;
                $shortUrl = $this->event_model->get_usershorturl($eventId);
                $customer = $this->user_model->getUserInfoByShortUrl($shortUrl);
                $get_by_event_id = ($customer) ? true : false;
            }
        }

        if (!$shortUrl || !$customer) {
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

        if($get_by_event_id){
            $events = $this->event_model->get_event_by_id($customer->id, $eventId);
        } else {
            $events = $this->event_model->get_events($customer->id);
        }

        $data['events'] = $events;
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
            'tickets' => $this->event_model->get_event_tickets($vendor_id,$eventId),
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
        $amount = (floatval($ticket['price']) + floatval($ticket['ticketFee']))*floatval($ticket['quantity']);
        $ticketId = $ticket['id'];
        $eventName = $this->event_model->get_eventname_by_ticket($ticketId);
        $ticketType = $this->event_model->get_ticket_type($ticketId);
        unset($tickets[$ticketId]);
        $tickets[$ticketId] = [
            'id' => $ticketId,
            'eventName' => $eventName,
            'descript' => $ticket['descript'],
            'quantity' => $ticket['quantity'],
            'price' => $ticket['price'],
            'ticketType' => $ticketType,
            'ticketFee' => $ticket['ticketFee'],
            'amount' => $amount,
            'startDate' => $this->session->userdata("startDate"),
            'startTime' => $this->session->userdata("startTime"),
            'endDate' => $this->session->userdata("endDate"),
            'endTime' => $this->session->userdata("endTime")
        ];
        
        echo json_encode(['descript'=>$ticket['descript'],'price' => $ticket['price'], 'ticketFee' => $ticket['ticketFee'], 'first_ticket' => $first_ticket, 'eventName' => $eventName ]);
        
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

    public function delete_ticket()
    {
        $tickets = $this->session->tempdata('tickets');
        $ticketId = $this->input->post('id');
        $time = (int)($this->input->post('current_time')/1000);
        $time = $time - 2;
        unset($tickets[$ticketId]);
        
        $this->session->unset_userdata('tickets');
        $this->session->unset_tempdata('tickets');
        $this->session->unset_tempdata('total');
        $items = $this->input->post('list_items');
        $total = $this->input->post('totalBasket');
        $total = number_format($total, 2, '.', '');
        $this->session->set_tempdata('total', $total, 600); 
        $this->session->set_tempdata('tickets', $tickets, $time); 
        if($items == 0){
            $this->session->unset_tempdata('exp_time');
        }
        return ;
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
            $reservationsQuantity = [];
            foreach ($reservations as $key => $reservation) {
                $reservationsQuantity[$reservation->reservationId] = $reservation->numberofpersons;
                if ($reservation->SpotId != 3) {
                    $this->bookandpay_model->newvoucher($reservation->reservationId);
                }

                $this->bookandpay_model->editbookandpay([
                    'mobilephone' => $buyerInfo['mobileNumber'],
                    'email' => $buyerInfo['email'],
                ], $reservation->reservationId);
            }
            $this->session->unset_userdata('reservationsQuantity');
            $this->session->set_userdata('reservationsQuantity', $reservationsQuantity);
        } else {
            redirect('agenda_booking/pay');
        }


        redirect('/events/selectpayment');
        
        
    }

    public function selectpayment()
    {
        $this->global['pageTitle'] = 'TIQS: Select Payment';
        
        $ticketingPayments = $this->event_model->get_payment_methods($this->session->userdata('customer'));
        $data['activePayments'] = $this->event_model->get_active_payment_methods($this->session->userdata('customer'));
        $data['idealPaymentType'] = $this->config->item('idealPaymentType');
        $data['creditCardPaymentType'] = $this->config->item('creditCardPaymentType');
        $data['bancontactPaymentType'] = $this->config->item('bancontactPaymentType');
        $data['giroPaymentType'] = $this->config->item('giroPaymentType');
        $data['payconiqPaymentType'] = $this->config->item('payconiqPaymentType');
        $data['pinMachinePaymentType'] = $this->config->item('pinMachinePaymentType');
        $data['myBankPaymentType'] = $this->config->item('myBankPaymentType');
        $amount = floatval($this->session->tempdata('total'));
        $reservationIds = $this->session->userdata('reservationIds');
        $ticketsFee = $this->session->userdata('ticketsFee');
        $reservationsQuantity = $this->session->userdata('reservationsQuantity');
        
        foreach($reservationIds as $reservationId){
            $amount += floatval($amount);
        }

        $amount = $amount/100;

        foreach($ticketingPayments as $key => $ticketingPayment){
            $paymentMethod = ucwords($key);
            $paymentMethod = str_replace(' ', '', $paymentMethod);
            $paymentMethod = lcfirst($paymentMethod);
            $data[$paymentMethod] = $amount*$ticketingPayment['percent'] + $ticketingPayment['amount'];
        }

        $this->loadViews("events/selectpayment", $this->global, $data, 'footerShop', 'headerShop');
    }

    public function onlinepayment($paymentType, $paymentOptionSubId = '0')
    {
        $paymentType = strval($this->uri->segment('3'));
        $paymentOptionSubId = ($this->uri->segment('4')) ? strval($this->uri->segment('4')) : '0';
        $vendorId = $this->session->userdata('customer');
        $SlCode = $this->bookandpay_model->getUserSlCode($vendorId);
        $reservationIds = $this->session->userdata('reservationIds');
        $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
        $arrArguments = Pay_helper::getTicketingArgumentsArray($vendorId, $reservations, strval($SlCode), $paymentType, $paymentOptionSubId);

        $namespace = $this->config->item('transactionNamespace');
        $function = $this->config->item('orderPayNlFunction');
        $version = $this->config->item('orderPayNlVersion');

        $strUrl = Pay_helper::getPayNlUrl($namespace,$function,$version,$arrArguments);
        

        $this->session->set_userdata('payment_data', [
            'strUrl' => $strUrl,
            'arrArguments' => $arrArguments,
            'discountAmount' => $arrArguments['amount']
        ]);


        $this->processPaymenttype($strUrl);

    }

    private function processPaymenttype($strUrl)
	{
		# Get API result
		$strResult = @file_get_contents($strUrl);
		$result = json_decode($strResult);
        
		if ($result->request->result == '1') {
            $transactionId = $result->transaction->transactionId;
            $reservationIds = $this->session->userdata('reservations');
            $this->bookandpay_model->updateTransactionIdByReservationIds($reservationIds, $transactionId);
			redirect($result->transaction->paymentURL);
		} else {
			$this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
			$data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("thuishavenerror", $this->global, $data, NULL, "noheader");

		}

	}

    public function ExchangePay()
	{

        $get = $this->input->get(null, true);
        $transactionid = $this->input->get('order_id'); 
        $action = $this->input->get('action', true);

        if ($get['action'] === 'new_ppt') {
            // WE HAVE SUCCESS
            // transactionId ID IS UNIQUE SO YOU CAN UPDATE paid STATUS TO 1 tbl_bookandpay
            // 
            //$query = 'UPDATE tbl_bookandpay SET paid = "1" WHERE TransactionID = "' . $this->db->escape($transactionid) . '"';
            //$this->db->queyr($query);

            $this->bookandpay_model->updateBookandpayByTransactionId($transactionid);
            echo('TRUE| '. $transactionid.'-status-'.$action.'-date-'.date('Y-m-d H:i:s'));
            $this->emailReservation($transactionid);
        } else {
			echo('TRUE| NOT FIND '. $transactionid.'-status-'.$action.'-date-'.date('Y-m-d H:i:s'));
        }

        return;
        ////////////////////////
		$this->load->model('email_templates_model');
		$this->load->model('bookandpayspot_model');
		$this->load->model('bookandpayagenda_model');
		$this->load->model('bookandpaytimeslots_model');


		$namespace = $this->config->item('transactionNamespace');
        $function = $this->config->item('orderPayNlFunction');
        $version = $this->config->item('orderPayNlVersion');

        $arrArguments = $this->session->userdata('arrArguments');
        $strUrl = $this->session->userdata('strUrl');

		$strResult = @file_get_contents($strUrl);

		if (empty($transactionid)) {
			echo('FALSE|' . $transactionid);
			die();
		}

		$strResult = unserialize($strResult);
		$result1 = $strResult;

//        if ($result1['paymentDetails']['state'] == 100 || $result1['paymentDetails']['state'] == 20) {
		if ($result1['paymentDetails']['state'] == 100 ) {
			foreach ($strResult['saleData']['orderData'] as $key => $product) {
				if($product['productId'] !== '000000') {
					$reservationId = $product['productId'];

					if (empty($reservationId)) {
						echo('FALSE|' . $reservationId);
						die();
					}

					$data['paid'] = '1';
					$data['TransactionID'] = $transactionid;

					$this->bookandpay_model->editbookandpay($data, $reservationId);
				}
			}
        }

        $this->emailReservation();
    }


    private function check_diff_multi($array1, $array2){
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

    public function emailReservation($transactionId)
	{
        $reservations = $this->bookandpay_model->getReservationsByTransactionId($transactionId);
        foreach ($reservations as $key => $reservation):
            $result = $this->sendreservation_model->getEventTicketingData($reservation->reservationId);
            
            foreach ($result as $record) {
                $customer = $record->customer;
                $Spotlabel = $record->Spotlabel;
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
                $mailsend = $record->mailsend;
                
                
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

                        $emailId = $record->emailId;
                        
                        
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
                                $mailtemplate = str_replace('[reservationId]', $reservationId, $mailtemplate);
                                $mailtemplate = str_replace('[spotLabel]', $Spotlabel, $mailtemplate);
								$mailtemplate = str_replace('[transactionId]', $TransactionId, $mailtemplate);
								$mailtemplate = str_replace('[voucher]', $voucher, $mailtemplate);
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
                                $mailtemplate .= '<div style="width:100%;text-align:center;margin-top: 30px;">';
                                $download_pdf_link = base_url() . "booking_events/pdf/" . $emailId . "/" . $reservationId;
                                $mailtemplate .= '<a href="'.$download_pdf_link.'" id="pdfDownload" style="background-color:#008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;">Download as PDF</a>';
                                $mailtemplate .= '</div>';
								$subject = ($emailTemplate->template_subject) ? strip_tags($emailTemplate->template_subject) : 'Your tiqs reservation(s)';
								$datachange['mailsend'] = 1;



                                if($mailsend == 0){
                                    
                                    $ics = new ICS(array(
                                        'location' => $eventAddress . ', ' . $eventCity . ', ' . $eventCountry,
                                        'organizer' => 'TIQS:malito:support@tiqs.com',
                                        'description' => strip_tags($eventName),
                                        'dtstart' => date('Y-m-d', strtotime($eventDate)) . ' ' .$fromtime,
                                        'dtend' => date('Y-m-d', strtotime($endDate)) . ' ' .$totime,
                                        'summary' => strip_tags($eventName),
                                        'url' => base_url()
                                    ));
                                    
                                    $icsContent = $ics->to_string();
                                    
                                    $this->sendEmail("pnroos@icloud.com", $subject, $mailtemplate, $icsContent );
								    if($this->sendEmail($buyerEmail, $subject, $mailtemplate, $icsContent)) {
                                        $this->sendreservation_model->editbookandpaymailsend($datachange, $reservationId);
                                    
                                    }

                                }
                            
                        }
                    }
                }
            }
            endforeach;
        }


    public function download_email_pdf($emailId,$reservationId)
	{
        $reservations = $this->bookandpay_model->getReservationsById($reservationId);
        foreach ($reservations as $key => $reservation):
            $result = $this->sendreservation_model->getEventTicketingData($reservation->reservationId);
            
            foreach ($result as $record) {
                $customer = $record->customer;
                $Spotlabel = $record->Spotlabel;
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
                                $mailtemplate = str_replace('[reservationId]', $reservationId, $mailtemplate);
                                $mailtemplate = str_replace('[spotLabel]', $Spotlabel, $mailtemplate);
								$mailtemplate = str_replace('[transactionId]', $TransactionId, $mailtemplate);
								$mailtemplate = str_replace('[voucher]', $voucher, $mailtemplate);
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
                                Pdf_helper::HtmlToPdf($mailtemplate);
                            
                        }
                    }
                }
            }
            endforeach;
        }
    
        public function successBooking()
        {
            $statuscode = intval($this->input->get('orderStatusId'));
            if ($statuscode == 100) {
                $data = array();
                $this->global['pageTitle'] = 'TIQS : THANKS';
                $this->session->sess_destroy();
                $this->loadViews("bookingsuccess", $this->global, $data, 'nofooter', "noheader");
            } elseif ($statuscode <0) {
                $data = array();
                $this->global['pageTitle'] = 'TIQS : THANKS';
                $this->session->sess_destroy();
                $this->loadViews("thuishavenerror", $this->global, $data, 'nofooter', "noheader");
            } elseif ($statuscode >= 0) {
                $data = array();
			    $this->global['pageTitle'] = 'TIQS : THANKS';
			    $this->session->sess_destroy();
			    $this->loadViews("thuishavenerror", $this->global, $data, 'nofooter', "noheader");
            } else {
			    $data = array();
			    $this->global['pageTitle'] = 'TIQS : THANKS';
			    $this->session->sess_destroy();
			    $this->loadViews("thuishavenerror", $this->global, $data, 'nofooter', "noheader");
            }

	}

    public function sendEmail($email, $subject, $message, $icsContent=false)
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
        if($icsContent){
            $this->email->attach($icsContent, 'attachment', 'reservation.ics', 'text/calendar');
        }
        
        
		return $CI->email->send();
    }

}