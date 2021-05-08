<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

//require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/BaseControllerWeb.php';

class Booking_events extends BaseControllerWeb
{
    function __construct()
    {
        
        parent::__construct();
        $this->load->helper('pay_helper');
        $this->load->helper('utility_helper');
        $this->load->helper('queue_helper');
        $this->load->helper('ticketingemail_helper');

        $this->load->model('event_model');
        $this->load->model('bookandpay_model');
        $this->load->model('user_model');
        $this->load->model('shopvendor_model');

        $this->load->model('sendreservation_model');
        $this->load->model('email_templates_model');
        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));
    } 

    public function index($shortUrl = false)
    {
        
        $this->global['pageTitle'] = 'TIQS: Shop';
        unset($_SESSION['customer']);
        unset($_SESSION['reservationIds']);

        if(!empty($_SESSION['eTicketing'])){
            session_unset();
        }

        if (!$shortUrl) {
            redirect('https://tiqs.com/info');
        }

        $customer = $this->user_model->getUserInfoByShortUrl($shortUrl);
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

        if (!$shortUrl || !$customer || !$this->shopvendor_model->setProperty('vendorId', intval($customer->id))->getProperty('TpayNlServiceId')) {
            redirect('https://tiqs.com/info');
        }

        if($this->session->userdata('shortUrl') != $shortUrl){
            $this->session->unset_userdata('tickets');
            $this->session->unset_userdata('exp_time');
            $this->session->unset_userdata('total');
        }

        
        $_SESSION['eTicketing'] = true;
        $_SESSION['customer'] = $customer->id;
        $this->session->set_userdata('shortUrl', $shortUrl);
        $data['shopsettings'] = $this->event_model->get_shopsettings($customer->id);
        $this->global['vendor'] = (array)$data['shopsettings'];
        $design = $this->event_model->get_vendor_design($customer->id);

        if($get_by_event_id){
            $events = $this->event_model->get_event_by_id($customer->id, $eventId);
            $design = ($this->event_model->get_event_design($customer->id, $eventId)) ? $this->event_model->get_event_design($customer->id, $eventId) : $design;
        } else {
            $events = $this->event_model->get_events($customer->id);
        }

        
        if(isset($design) && $design){
            $this->global['design'] = unserialize($design);
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
        $vendor_id = $_SESSION['customer'];
        //$this->session->unset_userdata("event_date");
        $event = $this->event_model->get_event($vendor_id,$eventId);
        $event_start =  date_create($event->StartDate . " " . $event->StartTime);
        //$event_end = date_create($event->EndDate . " " . $event->EndTime);
        //$event_date = date_format($event_start, "d M Y H:i") . " - ". date_format($event_end, "d M Y H:i");
        //$this->session->set_userdata("event_date",$event_date);

        $eventVenue = ucwords($event->eventVenue);
        $eventDate = date_format($event_start, "d M - H:i");
        $data = [
            'tickets' => $this->event_model->get_event_tickets($vendor_id,$eventId),
            'eventId' => $eventId,
            'eventName' => $event->eventname,
            'eventImage' => $event->eventImage,
            'eventDescription' => $eventVenue . ' ' . $eventDate,
            'vendor_cost_paid' =>  $this->event_model->check_vendor_cost_paid($vendor_id)
            
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

    public function add_to_basket()
    {
        $vendor_id = $_SESSION['customer'];
        $first_ticket = false;
        if(!$this->session->userdata('tickets')){
            $first_ticket = true;
        }
        $tickets = $this->session->userdata('tickets') ?? [];
        $ticket = $this->input->post(null, true);
        $ticketId = $ticket['id'];
        $ticketInfo = $this->event_model->get_ticket_info($ticketId);
        $eventInfo = $this->event_model->get_event_by_ticket($ticketId);
        $current_time = date($ticket['time']);
        $newTime = date("Y-m-d H:i:s",strtotime("$current_time +10 minutes"));
        $this->session->set_tempdata('exp_time', $newTime, 600);
        $amount = (floatval($ticketInfo->ticketPrice) + floatval($ticketInfo->ticketFee))*floatval($ticket['quantity']);
        
        
        
        if(is_numeric($ticketInfo->maxBooking) && $ticket['quantity'] > $ticketInfo->maxBooking){
            $response = [
                'status' => 'error',
                'message' => 'You have reached the maximum bookings for this ticket!',
                'quantity' => $ticketInfo->maxBooking,
                'amount' => floatval($ticket['amount']) - (floatval($ticketInfo->ticketPrice) + floatval($ticketInfo->ticketFee))
            ];
            echo json_encode($response);
            return ;
        }
        $ticketType = $ticketInfo->ticketType;

        $ticket_quantity = intval($ticket['quantity']);
        $ticket_available = intval($ticketInfo->ticketAvailable);
        if($ticket_quantity > $ticket_available){
            $response = [
                'status' => 'error',
                'message' => 'SOLD OUT!',
                'quantity' => $ticket_available,
                'amount' => floatval($ticket['amount']) - (floatval($ticketInfo->ticketPrice) + floatval($ticketInfo->ticketFee))
            ];
            echo json_encode($response);
            return ;
        }
        unset($tickets[$ticketId]);
        $tickets[$ticketId] = [
            'id' => $ticketId,
            'eventName' => $eventInfo->eventname,
            'descript' => $ticketInfo->ticketDescription,
            'quantity' => $ticket['quantity'],
            'price' => $ticketInfo->ticketPrice,
            'ticketType' => $ticketType,
            'ticketFee' => $ticketInfo->ticketFee,
            'amount' => $amount,
            'startDate' => $eventInfo->StartDate,
            'startTime' => $eventInfo->StartTime,
            'endDate' => $eventInfo->EndDate,
            'endTime' => $eventInfo->EndTime
        ];
        
         
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
        $response = [
            'status' => 'success',
            'descript' => $ticket['descript'],
            'price' => $ticketInfo->ticketPrice, 
            'ticketFee' => $ticketInfo->ticketFee,
            'first_ticket' => $first_ticket,
            'eventName' => $eventInfo->eventname
        ];
        echo json_encode($response);
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
        if(!$_SESSION['eTicketing']){
            redirect(base_url().'/events/shop/'.$this->session->userdata('shortUrl'));
        }

        $buyerInfo = $this->input->post(null, true);

        if(!$this->session->tempdata('tickets')){
            $this->session->set_flashdata('expired', 'Session Expired!');
            redirect('events/shop/'. $this->session->userdata('shortUrl'));
        }
        
        $tickets = $this->session->userdata('tickets');

        $this->session->set_userdata('eventShop', 'true');
        $this->session->set_userdata('buyerEmail', $buyerInfo['email']);
        $customer = $_SESSION['customer'];
        if (!$_SESSION['reservationIds']) {
            $reservationIds = $this->event_model->save_event_reservations($buyerInfo, $tickets, $customer);
            $_SESSION['reservationIds'] = $reservationIds;
        }

        $reservationIds = $_SESSION['reservationIds'];
        $arrArguments = array();
        if ($buyerInfo) {
            $reservations = $this->bookandpay_model->getBookingsByIds($reservationIds);
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
        if (empty($_SESSION['reservationIds'])) {
            redirect(base_url());
        }

        $this->global['pageTitle'] = 'TIQS: Select Payment';
        $customer = $_SESSION['customer'];
        $ticketingPayments = $this->event_model->get_payment_methods($customer);
        $data['activePayments'] = $this->event_model->get_active_payment_methods($customer);
        $data['idealPaymentType'] = $this->config->item('idealPaymentType');
        $data['creditCardPaymentType'] = $this->config->item('creditCardPaymentType');
        $data['bancontactPaymentType'] = $this->config->item('bancontactPaymentType');
        $data['giroPaymentType'] = $this->config->item('giroPaymentType');
        $data['payconiqPaymentType'] = $this->config->item('payconiqPaymentType');
        $data['pinMachinePaymentType'] = $this->config->item('pinMachinePaymentType');
        $data['myBankPaymentType'] = $this->config->item('myBankPaymentType');
        $amount = floatval($this->session->tempdata('total'));
        $reservationIds = $_SESSION['reservationIds'];
        $ticketsFee = $this->session->userdata('ticketsFee');
        $reservationsQuantity = $this->session->userdata('reservationsQuantity');

        foreach($reservationIds as $reservationId){
            $amount += floatval($amount);
        }

        $amount = $amount/100;

        $vendorCost = $this->event_model->get_vendor_cost($customer);
        foreach ($ticketingPayments as $key => $ticketingPayment) {
            $paymentMethod = ucwords($key);
            $paymentMethod = str_replace(' ', '', $paymentMethod);
            $paymentMethod = lcfirst($paymentMethod);
            $total_amount = $amount * $ticketingPayment['percent'] + $ticketingPayment['amount'];
            if((isset($vendorCost[$key]) && $vendorCost[$key] == 1) || $total_amount  == 0) {
                $data[$paymentMethod] = '&nbsp';
            } else {
                $data[$paymentMethod] = '€'. number_format($total_amount, 2, '.', '');
            }
        }

        $data['vendorCost'] = $this->event_model->get_vendor_cost($customer);
        $this->global['vendor'] = (array) $this->event_model->get_shopsettings($customer);

        $this->loadViews("events/selectpayment", $this->global, $data, 'footerShop', 'headerShop');
    }

    public function onlinepayment($paymentType, $paymentOptionSubId = '0')
    {
        if($_SESSION['customer'] === NULL) {
            redirect(base_url());
        }

        // update payment method
        $this->event_model->updatePaymentMethod($_SESSION['reservationIds'], Pay_helper::returnPaymentMethod($paymentType));
        // release queue
        Queue_helper::releaseQueue();

        $paymentType = strval($paymentType);
        $paymentOptionSubId = ($paymentOptionSubId) ? strval($paymentOptionSubId) : '0';
        $vendorId = $_SESSION['customer'];
        $SlCode = $this->bookandpay_model->getUserSlCode($vendorId);
        $reservationIds = $_SESSION['reservationIds'];
        $reservations = $this->bookandpay_model->getBookingsByIds($reservationIds);

        $arrArguments = Pay_helper::getTicketingArgumentsArray($vendorId, $reservations, strval($SlCode), $paymentType, $paymentOptionSubId);
        $namespace = $this->config->item('transactionNamespace');
        $function = $this->config->item('orderPayNlFunction');
        $version = $this->config->item('orderPayNlVersion');

        $arrArguments['statsData']['info'] = $vendorId;
        foreach ($reservations as $key => $reservation) {
            $arrArguments['statsData']['extra' . ($key + 1)] = $reservation->reservationId;
            $arrArguments['saleData']['orderData'][$key]['productId'] = $reservation->reservationId;
            $arrArguments['saleData']['orderData'][$key]['description'] = $reservation->ticketDescription;
            $arrArguments['saleData']['orderData'][$key]['productType'] = 'HANDLIUNG';
            $arrArguments['saleData']['orderData'][$key]['price'] = $reservation->price * 100;
            $arrArguments['saleData']['orderData'][$key]['quantity'] = 1;
            $arrArguments['saleData']['orderData'][$key]['vatCode'] = 'H';
            $arrArguments['saleData']['orderData'][$key]['vatPercentage'] = '0.00';

        }

        $strUrl = Pay_helper::getPayNlUrl($namespace,$function,$version,$arrArguments);

        $reservationIds = $_SESSION['reservationIds'];
        // destroy session in this place
        // because user maybe will not be redirected to $result->transaction->paymentURL
        // This prevent that user update existing ids with new transaction id
        #$this->session->sess_destroy();
        //session_destroy();
        $this->processPaymenttype($strUrl, $reservationIds);
    }

    private function processPaymenttype(string $strUrl, array $reservationIds)
	{
		# Get API result
		$strResult = @file_get_contents($strUrl);
        $result = json_decode($strResult);

        if ($result->request->result == '1') {
            $transactionId = $result->transaction->transactionId;
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

        session_unset();

        return;
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
        Ticketingemail_helper::sendEmailReservation($reservations, true);

    }
    
    public function download_email_pdf($emailId, $reservationId)
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
                $ticketFee = $record->ticketFee;
                $ticketId = $record->ticketId;
                $ticketDescription = $record->ticketDescription;
				$ticketQuantity = $record->numberofpersons;
                $orderAmount = intval($ticketQuantity) * (floatval($record->price) + floatval($record->ticketFee));
                $orderAmount = number_format($orderAmount, 2, '.', '');
                $eventZipcode = $record->ticketDescription;
                $buyerName = $record->name;
                $buyerEmail = $record->email;
				$buyerMobile = $record->mobilephone;
				$reservationset = $record->reservationset;
                $orderId = $record->orderId;
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
                            
                            
                            $mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$customer.'/'.$emailTemplate->template_file .'.'.$this->config->item('template_extension'));
                            $qrlink = $SERVERFILEPATH . $file_name1;
							if($mailtemplate) {
                                $dt = new DateTime('now');
                                $date = $dt->format('Y.m.d');
                                $mailtemplate = str_replace('[currentDate]', $buyerName, $mailtemplate);
                                $mailtemplate = str_replace('[orderId]', $orderId, $mailtemplate);
                                $mailtemplate = str_replace('[orderAmount]', $orderAmount, $mailtemplate);
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
                                //Pdf_helper::HtmlToPdf($mailtemplate);
                                $mailtemplate = str_replace("font-family: 'arial black', sans-serif", 'font-weight: bold', $mailtemplate);
                                $data['mailtemplate'] = $mailtemplate;
                                $this->load->view('generate_pdf', $data);
                            
                        }
                    }
                }
            }
        endforeach;
    }
    
    public function successBooking()
    {
        // uncomment for landing pages if you like and think it is ok
        session_unset();
        $get = Utility_helper::sanitizeGet();

        if ($get['orderStatusId'] === $this->config->item('payNlSuccess')) {
            // need to do something with the facebook pixel.
            $redirect = base_url() . 'ticketing_success?orderid=' . $get['orderId'];
        } elseif ($get['orderStatusId'] === $this->config->item('payNlPending')) {
            $redirect = base_url() . 'ticketing_pending?orderid=' . $get['orderId'];
        } elseif ($get['orderStatusId'] === $this->config->item('payNlAuthorised')) {
            $redirect = base_url() . 'ticketing_authorised?orderid=' . $get['orderId'];
        } elseif ($get['orderStatusId'] === $this->config->item('payNlVerify')) {
            $redirect = base_url() . 'ticketing_verify?orderid=' . $get['orderId'];
        } elseif ($get['orderStatusId'] === $this->config->item('payNlCancel')) {
            $redirect = base_url() . 'ticketing_cancel?orderid=' . $get['orderId'];
        } elseif ($get['orderStatusId'] === $this->config->item('payNlDenied')) {
            $redirect = base_url() . 'ticketing_denied?orderid=' . $get['orderId'];
        } elseif ($get['orderStatusId'] === $this->config->item('payNlPinCanceled')) {
            $redirect = base_url() . 'ticketing_pin_canceled?orderid=' . $get['orderId'];
        }

        redirect($redirect);

        /*
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
        */

	}


}
