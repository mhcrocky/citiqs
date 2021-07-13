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
        $this->load->helper('jwt_helper');

        $this->load->model('event_model');
        $this->load->model('bookandpay_model');
        $this->load->model('user_model');
        $this->load->model('shopvendor_model');
        $this->load->model('shopsession_model');
        $this->load->model('shopvoucher_model');

        $this->load->model('sendreservation_model');
        $this->load->model('email_templates_model');
        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));
    } 

    public function index($shortUrl = false)
    {
        $this->global['pageTitle'] = 'TIQS: Shop';

        
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;

        $orderData = [];

        if($orderRandomKey){
            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
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

        $logoUrl = 'assets/home/images/logo1.png';
        if ($customer->logo) {
			$logoUrl = 'assets/images/vendorLogos/' . $customer->logo;
        }
        
        $tag = $this->input->get('tag') ? $this->input->get('tag') : '0';
        $ip_address = $this->input->ip_address();
        $sessionData['vendorId'] = $customer->id;
        $sessionData['shortUrl'] = $shortUrl;
        $sessionData['spotId'] = 0;
        $sessionData['tickets'] = [];
        $sessionData['expTime'] = false;
        $sessionData['totalAmount'] = false;
        $sessionData['tag'] = $tag;
        $sessionData['ticketFee'] = 0;
        $sessionData['logoUrl'] = $logoUrl;
        $sessionData['eventId'] = $eventId;
        $sessionData['ip_address'] = $ip_address;

        if(count($orderData) < 1 || $orderData['ip_address'] != $ip_address){
            $shopSessionData = $this->shopsession_model->insertSessionData($sessionData);
            $orderData = (array) Jwt_helper::decode($shopSessionData->orderData);
            $orderRandomKey = $shopSessionData->randomKey;
            
        }

        /*

        Redirection
        if(count($orderData) < 1 || $orderData['ip_address'] != $ip_address){
            $orderData = $this->shopsession_model->insertSessionData($sessionData);
            $userShortUrl = ($tag != '0') ? base_url() . 'events/shop/' . $shortUrl . '?tag=' . $tag . '&order=' . $orderData->randomKey : base_url() . 'events/shop/' . $shortUrl . '?order=' . $orderData->randomKey;
            $eventUrl = ($tag != '0') ? base_url() . 'events/shop/' . $eventId . '?tag=' . $tag . '&order=' . $orderData->randomKey : base_url() . 'events/shop/' . $eventId . '?order=' . $orderData->randomKey;
            $redirectUrl = ($get_by_event_id) ? $eventUrl : $userShortUrl;
            redirect($redirectUrl);
        }

        */
       
        

        if (!$shortUrl || !$customer || !$this->shopvendor_model->setProperty('vendorId', intval($customer->id))->getProperty('TpayNlServiceId')) {
            
            redirect('https://tiqs.com/info');
        }

        $data['shopsettings'] = $this->event_model->get_shopsettings($customer->id);
        $this->global['vendor'] = (array)$data['shopsettings'];
        $design = $this->event_model->get_vendor_design($customer->id);

        if($get_by_event_id){
            $events = $this->event_model->get_event_by_id($customer->id, $eventId);
            if(isset($events[0]) && is_array($events[0])){
                $this->setGlobalMetaProperties($events[0]);
            }
            
            $design = ($this->event_model->get_event_design($customer->id, $eventId)) ? $this->event_model->get_event_design($customer->id, $eventId) : $design;
        } else {
            $events = $this->event_model->get_events($customer->id);
            if(isset($events[0]) && is_array($events[0])){
                $this->setGlobalMetaProperties($events[0]);
            }
        }

        
        if(isset($design) && $design){
            $this->global['design'] = unserialize($design);
        } else {
            $design = $this->event_model->get_vendor_design('1');
            if($design) $this->global['design'] = unserialize($design);
        }


        $data['events'] = $events;
        $data['get_by_event_id'] = $get_by_event_id;

        if(isset($events[0])){
            $data['eventTickets'] = $this->tickets($events[0]['id'], $orderData);
        }
        
        $where = [
            'vendorId' => $customer->id,
            'eventId' => ($eventId == '') ? '0' : strval($eventId)
        ];
		$this->global['inputs'] = $this->event_model->get_event_inputs($where);
        $this->global['orderRandomKey'] = $orderRandomKey;
        $this->global['tickets'] = $orderData['tickets'];
        $this->global['expTime'] = $orderData['expTime'];
        $this->global['totalAmount'] = $orderData['totalAmount'];
        $this->global['logoUrl'] = $orderData['logoUrl'];

        if(isset($orderData['errorMessages']) && !$orderData['displayedErrorMessages']){
            $orderData['displayedErrorMessages'] = true;
            $this->global['errorMessages'] = $orderData['errorMessages'];
            $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();
        }


        if(is_array($events) && count($events) < 1){
            $data['closedShopMessage'] = $data['shopsettings']->closedShopMessage;
        }

        $this->loadViews("events/shop", $this->global, $data, 'footerShop', 'headerShop');

    }

    private function setGlobalMetaProperties(array $event): void
    {
        $this->global['facebook'] = [
            'fb:app_id'         => $this->config->item('facebookAppId'),
            'og:site_name'      => 'https://tiqs.com/alfred/',
            'og:url'            => base_url() . 'events/shop/' . $event['id'],
            'og:title'          => $event['eventname'],
            'og:description'    => strip_tags($event['eventdescript']),
            'og:type'           => 'website'
        ];

        if (!empty($event['backgroundImage'])) {
            $imageFile = FCPATH . $this->config->item('eventImagesFolder') . $event['eventImage'];
            $imageUrl = base_url() . $this->config->item('eventImagesFolder') . $event['eventImage'];
            $imageData = (getimagesize($imageFile));
            $this->global['facebook']['og:image'] = $imageUrl;
            $this->global['facebook']['og:image:width'] = $imageData[0];
            $this->global['facebook']['og:image:height'] = $imageData[1];
        }
        return;
    }

    public function tickets($eventId, $orderData = false)
    {
        if(!$this->input->post('isAjax')){ 
            $vendorId = $orderData['vendorId'];
            $event = $this->event_model->get_event($vendorId, $eventId);
            $event_start =  date_create($event->StartDate . " " . $event->StartTime);
            $event_end =  date_create($event->EndDate . " " . $event->EndTime);


            $eventVenue = ucwords($event->eventVenue);
            $eventStartDate = date_format($event_start, "d/m/Y");
            $eventEndDate = date_format($event_end, "d/m/Y");
            $eventDescription = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $event->eventdescript);

            $data = [
                'tickets' => $this->event_model->get_event_tickets($vendorId, $eventId),
                'checkout_tickets' => $orderData['tickets'],
                'eventId' => $eventId,
                'eventName' => $event->eventname,
                'eventImage' => $event->eventImage,
                'eventTitle' => (empty($event->descriptionInShop) || $event->descriptionInShop == '') ? 'Tickets' : $event->descriptionInShop,
                'eventDescription' => $eventDescription,
                'vendor_cost_paid' =>  $this->event_model->check_vendor_cost_paid($vendorId)
            
            ];

            return $data; 
        } 

        $orderRandomKey = $this->input->post('order') ? $this->input->post('order') : false;

        $orderData = [];

        if($orderRandomKey){
            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        } else {
            return ;
        }

        

        $vendor_id = $orderData['vendorId'];
        $event = $this->event_model->get_event($vendor_id,$eventId);
        $event_start =  date_create($event->StartDate . " " . $event->StartTime);
        $event_end =  date_create($event->EndDate . " " . $event->EndTime);


        $eventVenue = ucwords($event->eventVenue);
        $eventStartDate = date_format($event_start, "d/m/Y");
        $eventEndDate = date_format($event_end, "d/m/Y");
        $data = [
            'tickets' => $this->event_model->get_event_tickets($vendor_id,$eventId),
            'checkout_tickets' => $orderData['tickets'],
            'eventId' => $eventId,
            'eventName' => $event->eventname,
            'eventImage' => $event->eventImage,
            'eventTitle' => (empty($event->descriptionInShop) || $event->descriptionInShop == '') ? 'Tickets' : $event->descriptionInShop,
            'eventDescription' => strip_tags($event->eventdescript),
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
        $orderRandomKey = $this->input->post('order') ? $this->input->post('order') : false;

        $orderData = [];

        if($orderRandomKey){
            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        }

        if(count($orderData) < 1){
            $response = [
                'status' => 'error',
                'message' => 'Something went wrong!',
                'quantity' => 1,
                'amount' => 0
            ];

            echo json_encode($response);
            return ;
        }

        $vendor_id = $orderData['vendorId'];
        $first_ticket = false;
        $tickets = $orderData['tickets'] ?? [];
        $ticket = $this->input->post(null, true);

        if(count($orderData['tickets']) < 1){
            $first_ticket = true;
            $current_time = date($ticket['time']);
            $orderData['expTime'] = date("Y-m-d H:i:s",strtotime("$current_time +10 minutes"));
        }
        
        $ticketId = $ticket['id'];
        $ticketInfo = $this->event_model->get_ticket_info($ticketId);
        $eventInfo = $this->event_model->get_event_by_ticket($ticketId);
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

        /*
        $ticket_quantity = intval($ticket['quantity']);
        $ticket_available = intval($ticketInfo->ticketAvailable);
        if($ticket_quantity > $ticket_available){
            $response = [
                'status' => 'error',
                'message' => $this->language->tLine('SOLD OUT') . '!',
                'quantity' => $ticket_available,
                'amount' => floatval($ticket['amount']) - (floatval($ticketInfo->ticketPrice) + floatval($ticketInfo->ticketFee))
            ];
            echo json_encode($response);
            return ;
        }

        */

        $bundleMax = $this->event_model->get_ticket_bundle_max();
        if(isset($bundleMax[$ticketInfo->ticketGroupId])){
            $group = $bundleMax[$ticketInfo->ticketGroupId];
            $diff = intval($group->groupQuantity) - intval($group->tickets);
            $bundleMax = $diff;
        } else if(is_numeric($ticketInfo->groupQuantity)){
            $bundleMax = $ticketInfo->groupQuantity;
        } else {
            $bundleMax = 999;
        }

        unset($tickets[$ticketId]);
        $tickets[$ticketId] = [
            'id' => $ticketId,
            'eventName' => $eventInfo->eventname,
            'descript' => $ticketInfo->ticketDescription,
            'descriptionTitle' => ($ticketInfo->descriptionTitle == null) ? 'description' : $ticketInfo->descriptionTitle,
            'quantity' => $ticket['quantity'],
            'price' => $ticketInfo->ticketPrice,
            'maxTicketQuantity' => $ticketInfo->ticketQuantity,
            'numberofpersons' => $ticketInfo->numberofpersons,
            'ticketType' => $ticketType,
            'ticketFee' => $ticketInfo->ticketFee,
            'ticketGroupId' => $ticketInfo->ticketGroupId,
            'bundleMax' => $bundleMax,
            'amount' => $amount,
            'startDate' => $eventInfo->StartDate,
            'startTime' => $eventInfo->StartTime,
            'endDate' => $eventInfo->EndDate,
            'endTime' => $eventInfo->EndTime
        ];
        
         
        if($ticket['quantity'] != 0){
            $orderData['tickets'] = $tickets;
        }

        $orderData['tickets']  = $tickets;
        $total = 0;
        $ticketFee = 0;
        foreach($tickets as $ticket){
            $total = $total + $ticket['amount'];
            $ticketFee = $ticketFee + floatval($ticket['ticketFee']);
        }
        $total = number_format($total, 2, '.', '');
        $orderData['totalAmount'] = $total;
        $orderData['ticketFee'] = $ticketFee;

        $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();

        
        $response = [
            'status' => 'success',
            'descript' => $ticket['descript'],
            'descriptionTitle' => ($ticketInfo->descriptionTitle == null) ? 'description' : $ticketInfo->descriptionTitle,
            'price' => $ticketInfo->ticketPrice, 
            'ticketFee' => $ticketInfo->ticketFee,
            'groupId' => $ticketInfo->ticketGroupId,
            'bundleMax' => $bundleMax,
            'first_ticket' => $first_ticket,
            'eventName' => $eventInfo->eventname,
            'requiredInfo' => $ticketInfo->requiredInfo
        ];
        echo json_encode($response);
    }

    public function clear_tickets()
    {
        
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : '';
        
        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }

        $shortUrl = $orderData['shortUrl'];
        
        $what = ['id'];
		$where = ["randomKey" => $orderRandomKey];
			
        $result = $this->shopsession_model->read($what,$where);
        $result = reset($result);
        $ids = [$result['id']];

        if($this->shopsession_model->multipleDelete($ids, $where)){
            $orderData['totalAmount'] = false;
            $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();
                $this->redirectToShop($orderData, $orderRandomKey);
        }
        

        return ;
        
        
        
    }

    public function delete_ticket()
    {
        $orderRandomKey = $this->input->post('order') ? $this->input->post('order') : false;

        if(!$orderRandomKey){
            return ;
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            return ;
        }

        $tickets = $orderData['tickets'];
        $ticketId = $this->input->post('id');
    
        unset($tickets[$ticketId]);

        $items = $this->input->post('list_items');
        $total = $this->input->post('totalBasket');
        $total = number_format($total, 2, '.', '');
        $orderData['totalAmount'] = $total; 
        $orderData['tickets'] = $tickets;

        if($items == 0){
            $orderData['expTime'] = false;
        }
        

        $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();
        return ;
    }

    public function payment_proceed()
    {
        
        $buyerInfo = $this->input->post(null, true);

        if(isset($buyerInfo['additionalInfo'])){
            $additional_info = $buyerInfo['additionalInfo'];
            $buyerInfo['additionalInfo'] = serialize($additional_info);
        }
                
        $orderRandomKey = isset($buyerInfo['orderRandomKey']) ? $buyerInfo['orderRandomKey'] : false;

        if(!$orderRandomKey){
            redirect(base_url());
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }
        
        
        $tickets = $orderData['tickets'];
        $customer = $orderData['vendorId'];
        $tag = $orderData['tag'];
        

        foreach($tickets as $key => $ticket){
            if($this->event_model->check_ticket_soldout($customer, $ticket['id'], $ticket['quantity'], $ticket['maxTicketQuantity'])){
                $orderData['displayedErrorMessages'] = false;
                $orderData['errorMessages'][$key] = 'Sorry! ' . $ticket['descript'] . ' ticket is sold out.';
                unset($tickets[$key]);
            }
        }

        if(count($tickets) === 0){
            $orderData['tickets'] = [];
            $orderData['totalAmount'] = false;
            $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();
            $this->redirectToShop($orderData, $orderRandomKey);
        }
        
        

        if (!isset($orderData['reservationIds'])) {
            $reservationIds = $this->event_model->save_event_reservations($buyerInfo, $tickets, $customer, $tag);
            $orderData['reservationIds'] = $reservationIds;
        }

        $reservationIds = $orderData['reservationIds'];
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

        } else {
            redirect(base_url());
        }

        $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();

        redirect('/events/selectpayment?order=' . $orderRandomKey);
        
        
    }

    private function redirectToShop(array $orderData, string $orderRandomKey): void
    {
        $redirect  = base_url() . 'events'. DIRECTORY_SEPARATOR . 'shop' . DIRECTORY_SEPARATOR;
        $redirect .= !empty($orderData['eventId']) ? $orderData['eventId'] : $orderData['shortUrl'];
        $redirect .= '?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey . '#ticket';
        redirect($redirect);
        return;
    }

    public function selectpayment()
    {
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order', true) : false;

        if (!$orderRandomKey) {
            redirect(base_url());
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if (count($orderData) < 1) {
            redirect(base_url());
        }

        if (empty($orderData['reservationIds'])) {
            $this->redirectToShop($orderData, $orderRandomKey);
        }

        $customer = $orderData['vendorId'];
        $ticketingPayments = $this->event_model->get_payment_methods($customer);

        $data['activePayments'] = (array)$this->event_model->get_active_payment_methods($customer);
        $data['idealPaymentType'] = $this->config->item('idealPaymentType');
        $data['creditCardPaymentType'] = $this->config->item('creditCardPaymentType');
        $data['bancontactPaymentType'] = $this->config->item('bancontactPaymentType');
        $data['giroPaymentType']           = $this->config->item('giroPaymentType');
        $data['payconiqPaymentType']       = $this->config->item('payconiqPaymentType');
        $data['myBankPaymentType']         = $this->config->item('myBankPaymentType');
        $data['vendorCost']                = $this->event_model->get_vendor_cost($customer);
        $data['shortUrl']                  = $orderData['shortUrl'];
        $data['idealPaymentText']          = $this->config->item('idealPayment');
        $data['creditCardPaymentText']    = $this->config->item('creditCardPayment');
        $data['bancontactPaymentText']     = $this->config->item('bancontactPayment');
        $data['giroPaymentText']         = $this->config->item('giroPayment');
        $data['payconiqPaymentText']       = $this->config->item('payconiqPayment');
        $data['voucherPaymentText']        = $this->config->item('voucherPayment');
        $data['pinMachinePaymentText']     = $this->config->item('pinMachinePayment');
        $data['myBankPaymentText']         = $this->config->item('myBankPayment');


        $amount = floatval($orderData['totalAmount']);
        $reservationIds = $orderData['reservationIds'];

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


        
        
        
        $this->global = [
            'pageTitle'      => 'TIQS: Select Payment',
            'vendor'         => (array) $this->event_model->get_shopsettings($customer),
            'expTime'        => $orderData['expTime'],
            'totalAmount'    => $orderData['totalAmount'],
            'orderRandomKey' => $orderRandomKey,
            'logoUrl'        => $orderData['logoUrl']
        ];

        if(isset($orderData['errorMessages']) && !$orderData['displayedErrorMessages']){
            $orderData['displayedErrorMessages'] = true;
            $this->global['errorMessages'] = $orderData['errorMessages'];
            $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();
        }

        //$this->loadViews('events/selectpayment', $this->global, $data, null, 'headerWarehousePublic');

        $this->loadViews("events/selectpayment", $this->global, $data, 'footerShop', 'headerShop');
    }

    public function onlinepayment($paymentType, $paymentOptionSubId = '0')
    {
		//Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/ticket_payment.txt', 'order randomkey');
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;

        if(!$orderRandomKey){
			//Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/ticket_payment.txt', 'order randomkey redirect');
            redirect(base_url());
        }


        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
		//Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/ticket_payment.txt', 'order data');


        if(count($orderData) < 1){
            redirect(base_url());
        }

        if(!isset($orderData['reservationIds']) && !is_array($orderData['reservationIds'])){
            $this->redirectToShop($orderData, $orderRandomKey);
            return ;
        }

        // update payment method
        if(isset($orderData['reservationIds']) && is_array($orderData['reservationIds'])){
            $this->event_model->updatePaymentMethod($orderData['reservationIds'], Pay_helper::returnPaymentMethod($paymentType));
        }
        // release queue
        // Queue_helper::releaseQueue();

        $paymentType = strval($paymentType);
        $paymentOptionSubId = ($paymentOptionSubId) ? strval($paymentOptionSubId) : '0';
        $vendorId = $orderData['vendorId'];
        $SlCode = $this->bookandpay_model->getUserSlCode($vendorId);
        $reservationIds = $orderData['reservationIds'];
        $reservations = $this->bookandpay_model->getBookingsByIds($reservationIds);

        $arrArguments = Pay_helper::getTicketingArgumentsArray($vendorId, $reservations, strval($SlCode), $paymentType, $paymentOptionSubId);
        $namespace = $this->config->item('transactionNamespace');
        $function = $this->config->item('orderPayNlFunction');
        $version = $this->config->item('orderPayNlVersion');

        $arrArguments['statsData']['info'] = $vendorId;
        foreach ($reservations as $key => $reservation) {
            $arrArguments['statsData']['extra' . ($key + 1)] = $reservation->reservationId;
            $arrArguments['saleData']['orderData'][$key]['productId'] = $reservation->reservationId;
            $arrArguments['saleData']['orderData'][$key]['description'] = substr($reservation->ticketDescription, 0, 31);
            $arrArguments['saleData']['orderData'][$key]['productType'] = 'HANDLIUNG';
            $arrArguments['saleData']['orderData'][$key]['price'] = $reservation->price * 100;
            $arrArguments['saleData']['orderData'][$key]['quantity'] = 1;
            $arrArguments['saleData']['orderData'][$key]['vatCode'] = 'H';
            $arrArguments['saleData']['orderData'][$key]['vatPercentage'] = '0.00';

        }

        $strUrl = Pay_helper::getPayNlUrl($namespace,$function,$version,$arrArguments);

        // if ($orderData['vendorId'] === 49456) {
        //     $file = FCPATH . 'application/tiqs_logs/payment_logs.txt';
        //     Utility_helper::logMessage($file, serialize($arrArguments));
        //     Utility_helper::logMessage($file, $strUrl);
        // }

        // destroy session in this place
        // because user maybe will not be redirected to $result->transaction->paymentURL
        // This prevent that user update existing ids with new transaction id
        #$this->session->sess_destroy();
        //session_destroy();

        //$what = ['id'];
		//$where = ["randomKey" => $orderRandomKey];

        //$result = $this->shopsession_model->read($what,$where);
        //$result = reset($result);
        //$ids = [$result['id']];

        //Delete data from session table
        //$this->shopsession_model->multipleDelete($ids, $where);

        // remove order ids because user update same orders when go back from payments
        $this->removeOrderIds($orderData, $orderRandomKey);

        $this->processPaymenttype($strUrl, $orderRandomKey, $reservationIds);
    }

    private function removeOrderIds(array $orderData, string $orderRandomKey): void
    {
        unset($orderData['reservationIds']);
        $this
            ->shopsession_model
            ->setProperty('randomKey', $orderRandomKey)
            ->updateSessionData($orderData);

        return;
    }
 
    private function processPaymenttype(string $strUrl, string $orderRandomKey, array $reservationIds)
	{
		# Get API result
		$strResult = @file_get_contents($strUrl);
        $result = json_decode($strResult);
        Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/ticket_payment.txt', "strResult: $strResult");

        if ($result->request->result == '1') {
			//Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/ticket_payment.txt', 'updating transactionid');
            $transactionId = $result->transaction->transactionId;

            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
            $orderData['transactionId'] = $transactionId;
            $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();

            $this->bookandpay_model->updateTransactionIdByReservationIds($reservationIds, $transactionId);
			//Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/ticket_payment.txt', $result->transaction->paymentURL );
			redirect($result->transaction->paymentURL);
		} else {
			//Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/ticket_payment.txt', 'payment error');
			$this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
			$data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("thuishavenerror", $this->global, $data, NULL, "noheader");
		}
	}

    public function ExchangePay()
	{
        $transactionid = $this->input->get('order_id'); 
        $action = $this->input->get('action', true);

        if ($action === 'new_ppt') {
            $this->exchangeSideJobs($transactionid);
            echo('TRUE| ' . $transactionid . '-status-' . $action . '-date-' . date('Y-m-d H:i:s'));
        } else {
			echo('TRUE| NOT FIND ' . $transactionid . '-status-' . $action.'-date-'.date('Y-m-d H:i:s'));
        }

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

    public function termsofuse()
	{
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;

        if(!$orderRandomKey){
            redirect(base_url());
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }

        $customer = $orderData['vendorId'];
        $shopsettings = $this->event_model->get_shopsettings($customer);
        $pdfFile = '';
        $filename = '';
        if(isset($shopsettings->termsofuseFile) && $shopsettings->termsofuseFile != ''){
            $pdfFile = base_url() ."uploads/termsofuse/".$shopsettings->termsofuseFile;
            $filename = $shopsettings->termsofuseFile;
        }

        echo "<title>Terms Of Use</title>";
        echo "<style>body{margin: 0px;}</style>";
        echo '<iframe src="'.$pdfFile.'" width="100%"  style="height:100%" scrolling="no" frameborder="0"></iframe>';
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
								$mailtemplate = str_replace('[WalletCode]', $voucher, $mailtemplate);
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
        $get = Utility_helper::sanitizeGet();

        if (ENVIRONMENT === 'development') {
            $this->exchangeSideJobs($get['orderId']);
        }

        if ($get['orderStatusId'] === $this->config->item('payNlSuccess')) {
            // need to do something with the facebook pixel.
            $redirect = base_url() . 'ticketing_success?orderid=' . $get['orderId'];
        } elseif (in_array($get['orderStatusId'], $this->config->item('payNlPending'))) {
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

    private function createTicketVoucher(string $orderTransactionId): bool
    {
        $data = $this->bookandpay_model->getReservationsByTransactionIdImproved($orderTransactionId, ['eventid', 'voucher']);

        if (is_null($data)) return false;

        $ticketId = intval($data[0]->eventid);
        $voucherId = $this->shopvoucher_model->getTicketVoucherId($ticketId);

        if (is_null($voucherId)) return false;

        $voucherBlueprint = $this->shopvoucher_model->setObjectId($voucherId)->getVoucher();

        foreach($data as $voucherInfo) {
            if (!$this->shopvoucher_model->createVoucherFromTemplate($voucherBlueprint, $voucherInfo->voucher)) return false;
        }

        return true;

    }


    private function exchangeSideJobs($transactionId): void
    {
        $this->bookandpay_model->updateBookandpayByTransactionId($transactionId);
        
        $this->createTicketVoucher($transactionId);

        $this->emailReservation($transactionId);
        return;
    }

            
}
