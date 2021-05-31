<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Agenda_reservation extends BaseControllerWeb
{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->helper('url');
        $this->load->helper('jwt_helper');

        
        $this->load->model('user_model');
        $this->load->model('bookandpay_model');
        $this->load->model('bookandpayspot_model');
        $this->load->model('bookandpayagendabooking_model');
        $this->load->model('bookandpaytimeslots_model');
        $this->load->model('shopsession_model');
        $this->load->library('language', array('controller' => $this->router->class)); 
    }


    public function index($shortUrl=false)
    {

        if (!$shortUrl) {
            redirect(base_url());
        }

        $customer = $this->user_model->getUserInfoByShortUrl($shortUrl);
    
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;

        if (!$customer) {
			redirect(base_url());
        }

        $orderData = [];

        if($orderRandomKey){
            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        }


        $customer->logo = (property_exists($customer, 'logo')) ? $customer->logo : '';
        $sessionData['customer'] = [
            'id' => $customer->id,
            'usershorturl' => $customer->usershorturl,
            'username' => $customer->username,
            'first_name' => $customer->first_name,
            'second_name' => $customer->second_name,
            'email' => $customer->email,
            'logo' => $customer->logo,
        ];

        $sessionData['vendorId'] = $customer->id;
        $sessionData['spotId'] = 0;
        $sessionData['reservations'] = [];
        $sessionData['totalAmount'] = false;
        $sessionData['eventId'] = false;
        $sessionData['eventDate'] = false;
        $sessionData['timeslot'] = false;
        

        if(count($orderData) < 1){
            $orderData = $this->shopsession_model->insertSessionData($sessionData);
            redirect(base_url() . 'agenda_reservation/'.$shortUrl.'?order='.$orderData->randomKey);
            return ;
        }


        
        $agendas = $this->bookandpayagendabooking_model->getbookingagenda($customer->id);
        $agendas_calendar = [];

        foreach($agendas as $agenda){
            $date = explode(' ', $agenda->ReservationDateTime)[0];
			$dateFormat = str_replace('-', '', $date);
            $agendas_calendar[] = [
                'eventName' => $agenda->ReservationDescription,
                'dateTime' => $agenda->ReservationDateTime,
                'calendar' => 'Other',
                'color' => 'green',
                'spotLink' => base_url() . 'agenda_booking/spots/' . $dateFormat . '/' . $agenda->id . '?order=' . $orderRandomKey
            ];
        }

        $data['agendas_calendar'] = $agendas_calendar;
        $logoUrl = 'assets/user_images/no_logo.png';
        if ($customer->logo) {
			$logoUrl = 'assets/images/vendorLogos/' . $customer->logo;
        }
        $data['logoUrl'] = $logoUrl;
        $this->global['pageTitle'] = 'TIQS: AGENDA';
        $this->global['customDesign'] = $this->bookandpayagendabooking_model->get_agenda_booking_design($customer->id);
        $this->global['shortUrl'] = $orderData['customer']['usershorturl'];
        $this->global['orderRandomKey'] = $orderRandomKey;
        $this->global['eventId'] = $orderData['eventId'];
        $this->global['eventDate'] = str_replace('-', '', $orderData['eventDate']);
        $this->global['spotId'] = $orderData['spotId'];
        $this->global['timeslot'] = $orderData['timeslot'];
        $this->loadViews('new_bookings/index', $this->global, $data, 'newbookingfooter', 'newbookingheader');
        

        
    }

    public function spots($eventDate = false, $eventId = false)
    {

        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;
        
        if(!$orderRandomKey){
            redirect(base_url());
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }

        $customer = $orderData['customer'];

        if (empty($eventDate) || empty($eventId)) {
            redirect('agenda_booking/' . $customer['usershorturl']);
        }

        $orderData['eventDate'] = $eventDate;
        
        $orderData['spot'] =  $eventId;

        $orderData['eventId'] =  $eventId;

        $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();
        

        $allSpots = $this->bookandpayspot_model->getAllSpots($customer['id']);
        
        $agenda = $this->bookandpayagendabooking_model->getbookingagenda($customer['id']);
        $agendaInfo = $this->bookandpayagendabooking_model->get_agenda_by_id($eventId);
        $agendaReservations = $this->bookandpay_model->getBookingCountByAgenda($eventId);

        if($agendaReservations >= intval($agendaInfo->max_spots)){
            redirect('soldout');
        }

        $spots = [];

        foreach ($allSpots as $spot) {
            $allSpotReservations = 0;
            $availableItems = 0;

            //if spot description is empty we use agenda description
            if(empty($spot->descript) && isset($agenda[0])) {
                $spot->descript = $agenda[0]->ReservationDescription;
            }

            $spots['spot' . $spot->id] = [
                'data' => $spot
            ];

            $allTimeSlots = $this->bookandpaytimeslots_model->getTimeSlotsByCustomerAndSpot($customer['id'], $spot->id);
            $isThereAvailableTimeSlots = true;
            $spotReservations = 0;

            foreach ($allTimeSlots as $key => $timeSlot) {
                $spotsReserved = $this->bookandpay_model->getBookingByTimeSlot($customer['id'], $eventDate, $timeSlot->id);
                $spotReservations = $spotReservations + $this->bookandpay_model->getBookingCountBySpot($spot->id, $timeSlot->id, $timeSlot->fromtime, $timeSlot->totime);
                $availableItems += $timeSlot->available_items;

                if($spotsReserved) {
                    $allSpotReservations += count($spotsReserved);
                }
            }

            if(!$availableItems) {
                $availableItems = $spot->available_items;
            }

            if ($allSpotReservations >= $availableItems) {
                $isThereAvailableTimeSlots = false;
            }

            if ($spotReservations >= $spot->available_items) {
                $spots['spot' . $spot->id]['data']->status = 'soldout';
            } else {
                $spots['spot' . $spot->id]['data']->status = 'available';
            }
        }


        $data["eventDate"] = $eventDate;
        $data["eventId"] = $eventId;
        $data["spots"] = $spots;
        $data["bookingfee"] = 0.15;
        $data['orderRandomKey'] = $orderRandomKey;

        $this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->global['customDesign'] = $this->bookandpayagendabooking_model->get_agenda_booking_design($customer['id']);
        $this->global['shortUrl'] = $orderData['customer']['usershorturl'];
        $this->global['eventId'] = $orderData['eventId'];
        $this->global['eventDate'] = str_replace('-', '', $orderData['eventDate']);
        $this->global['orderRandomKey'] = $orderRandomKey;
        $this->global['spotId'] = $orderData['spotId'];
        $this->global['timeslot'] = $orderData['timeslot'];
        $this->loadViews("new_bookings/spots_booking", $this->global, $data, 'newbookingfooter', 'newbookingheader');    
    }

    public function time_slots($spotId)
    {
        
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;
        
        if(!$orderRandomKey){
            redirect(base_url());
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }

        $customer = $orderData['customer'];

        if (empty($customer) || !isset($customer['id'])) {
            redirect();
        }


        $spot = $this->bookandpayspot_model->getSpot($spotId);
        $spotReservations = 0;
        $orderData['spotDescript'] = $spot->descript;
        $orderData['spotPrice'] = $spot->price;
        

        $availableItems = $spot->available_items;
        $price = $spot->price;
        $spotLabel = $spot->numberofpersons . ' persoonstafel';
        $numberOfPersons = $spot->numberofpersons;
        $eventDate = $this->bookandpayspot_model->getAgendaBySpotId($spotId)->ReservationDateTime;
        $eventId = $this->bookandpayspot_model->getAgendaBySpotId($spotId)->agenda_id;

        $resultcount = $this->bookandpay_model->countreservationsinprogress($spot->id, $customer['id'], $eventDate);
        //$allTimeSlots = $this->bookandpaytimeslots_model->getTimeSlotsByCustomerAndSpot($customer['id'], $spot->id);

        $allTimeSlots = $this->bookandpaytimeslots_model->getTimeSlotsBySpotId($spotId);
        
        $timeSlots = [];
        //$allSpotReservations = 0;
        //$allAvailableItems = 0;
        

        foreach ($allTimeSlots as $timeSlot) {
            $spotsReserved = $this->bookandpay_model->getBookingCountByTimeSlot($timeSlot['id'], $timeSlot['fromtime'], $timeSlot['totime']);
            $spotReservations = $spotReservations + $this->bookandpay_model->getBookingCountBySpot($spotId, $timeSlot['id'], $timeSlot['fromtime'], $timeSlot['totime']);
            if($spotsReserved >= $timeSlot['available_items']){
                $status = 'soldout';
            } else {
                $status = 'open';
            }


            $timeSlot['status'] = $status;
            
            $timeSlots[] = $timeSlot; 
            /*

            $timeSlots['timeSlot' . $timeSlot->id] = [
                'data' => $timeSlot,
                'status' => 'open'
            ];

            if($spotsReserved) {
                $allSpotReservations += count($spotsReserved);
            }

            $availableItems = $timeSlot->available_items;
            $allAvailableItems += $availableItems;

            if ($spotsReserved && count($spotsReserved) >= $availableItems) {
                unset($timeSlots['timeSlot' . $timeSlot->id]);
            }
            */
        }
        /*
        if ($allSpotReservations >= $allAvailableItems) {
            //redirect('soldout');
        }
        */

        if ($spotReservations >= intval($availableItems)) {
            redirect('soldout');
        }


        $data['orderRandomKey'] = $orderRandomKey;

        if ($this->input->post('save')) {
            $timeslotId = $this->input->post('selected_time_slot_id');
            $fromtime = '';
            $totime = '';
            $selectedTimeSlot = $this->bookandpaytimeslots_model->getTimeSlot($timeslotId);
            if($selectedTimeSlot->multiple_timeslots == 1){
                $fromtime = self::second_to_hhmm($this->input->post('startTime'));
                $totime = self::second_to_hhmm($this->input->post('endTime'));
            } else {
                $fromtime = $selectedTimeSlot->fromtime;
                $totime = $selectedTimeSlot->totime;
            }
            $timeslot_sess = date("H:i", strtotime($fromtime)).' - '.date("H:i", strtotime($totime));
            $orderData['timeslot'] = $timeslot_sess;
            $orderData['spotId'] = $spot->id;
            $newBooking = [
                'customer' => $customer['id'],
                'eventid' => $eventId,
                'eventdate' => date("Y-m-d", strtotime($eventDate)),
                'SpotId' => $spot->id,
                'Spotlabel' => $spotLabel,
                'timefrom' => $fromtime,
                'timeto' =>  $totime,
                'timeslot' => $selectedTimeSlot->id,
                'timeslotId' => $selectedTimeSlot->id,
                'reservationFee' => $selectedTimeSlot->reservationFee,
                'price' => ($selectedTimeSlot->price != '0') ? $selectedTimeSlot->price : $price,
                'numberofpersons' => $numberOfPersons,
                'reservationset' => '1'
            ];

            // create new id for user of this session
            $result = $this->bookandpay_model->newbooking($newBooking);

            if (empty($result)) {
                // someting went wrong.
                redirect('agenda_booking/' . $customer['usershorturl']);
            }

            $reservations = $orderData['reservations'];

            if (!is_null($reservations)) {
                array_push($reservations, $result->reservationId);
            } else {
                $reservations = [];
            }

            if(is_array($reservations) && count($reservations) <= 1){
                $orderData['reservations'] = $result->reservationId;
                $orderData['selectedTimeSlot'] = $selectedTimeSlot;
                $orderData['timeslotPrice'] = $selectedTimeSlot->price;
                $orderData['reservationFee'] = $selectedTimeSlot->reservationFee;
            }
            
            $orderData['spotId'] = $spotId;

            $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();

            if($spot->price == 0){
                redirect('agenda_booking/pay?order=' . $orderRandomKey);
            }

            

            redirect('agenda_booking/pay?order=' . $orderRandomKey);
            
        }

        foreach($timeSlots as $key => $timeslot){
            $timeSlots[$key]['price'] = ($timeslot['price'] == '0') ? $spot->price : $timeslot['price'];
            
        }

        $data['count'] = $resultcount;
        $data['spot'] = $spot;
        $data['timeSlots'] = $timeSlots;
        $data['eventDate'] = $orderData['eventDate'];
        $data['eventId'] = $eventId;

        $this
            ->shopsession_model
            ->setIdFromRandomKey($orderRandomKey)
            ->setProperty('orderData', Jwt_helper::encode($orderData))
            ->update();

        
        $this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->global['customDesign'] = $this->bookandpayagendabooking_model->get_agenda_booking_design($customer['id']);
        $this->global['shortUrl'] = $orderData['customer']['usershorturl'];
        $this->global['eventId'] = $orderData['eventId'];
        $this->global['eventDate'] = str_replace('-', '', $orderData['eventDate']);
        $this->global['spotId'] = $spotId;
        $this->global['timeslot'] = $orderData['timeslot'];
        $this->global['orderRandomKey'] = $orderRandomKey;

        $this->loadViews("new_bookings/timeslot_booking", $this->global, $data, 'newbookingfooter', 'newbookingheader');
    }

    public function pay()
    {
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;
        
        if(!$orderRandomKey){
            redirect(base_url());
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }

        $data['orderRandomKey'] = $orderRandomKey;

        $this->load->library('form_validation');
        $customer = $orderData['customer'];
        $reservationIds = $orderData['reservations'];
        $data['reservationFee'] = $orderData['reservationFee'];

        if (empty($customer) || !isset($customer['id'])) {
            redirect();
        }

        if (!$reservationIds) {
            redirect('agenda_booking/' . $customer['usershorturl']);
        } 

        $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
        if (!$reservations) {
            redirect('agenda_booking/' . $customer['usershorturl']);
        }

        $this->form_validation->set_rules('username', 'Name', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile', 'Phone Number', 'trim|required|min_length[10]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');


        if ($this->form_validation->run()) {
            $buyer_info['mobilephone'] = strtolower($this->input->post('mobile'));
            $buyer_info['email'] = strtolower($this->input->post('email'));
            $buyer_info['name'] = strtolower($this->input->post('username'));

            $orderData['buyer_info'] = $buyer_info;

            $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();

            redirect('agenda_booking/payment_proceed?order=' . $orderRandomKey);
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }

        $logoUrl = 'assets/user_images/no_logo.png';
        if ($customer['logo']) {
        	// needs to change...
            $logoUrl = 'assets/images/vendorLogos/' . $customer['logo'];
        }

        $data['reservations'] = $reservations;
        $data['logoUrl'] = $logoUrl;

        $data['eventDate'] = isset($orderData['eventDate']) ? $orderData['eventDate'] : '';
        $data['spotDescript'] = isset($orderData['spotDescript']) ? $orderData['spotDescript'] : '';
        $data['timeslot'] = isset($orderData['timeslot']) ? $orderData['timeslot'] : '';
        $data['timeslotPrice'] = !empty($orderData['timeslotPrice']) ? $orderData['timeslotPrice'] : floatval($orderData['spotPrice']);

        $this->global['pageTitle'] = 'TIQS : BOOKINGS'; 
        $this->global['customDesign'] = $this->bookandpayagendabooking_model->get_agenda_booking_design($customer['id']);
        $this->global['shortUrl'] = $orderData['customer']['usershorturl'];
        $this->global['eventId'] = $orderData['eventId'];
        $this->global['eventDate'] = str_replace('-', '', $orderData['eventDate']);
        $this->global['spotId'] = $orderData['spotId'];
        $this->global['timeslot'] = true;
        $this->global['orderRandomKey'] = $orderRandomKey;
        $data['termsofuse'] = $this->bookandpayagendabooking_model->getTermsofuse();

        $this->loadViews("new_bookings/final", $this->global, $data, 'newbookingfooter', 'newbookingheader'); // payment screen
    }

    public function payment_proceed()
    {
        
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;
        
        if(!$orderRandomKey){
            redirect(base_url());
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }

        $buyerInfo = $orderData['buyer_info'];
        $customer = $orderData['customer'];

        $amount = 0;
        $reservationIds = $orderData['reservations'];
        
        if ($buyerInfo) {
            $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
            $orderData['buyerEmail'] = $buyerInfo['email'];

            foreach ($reservations as $key => $reservation) {
                $amount += floatval($reservation->price) + floatval($reservation->reservationFee);

                if ($reservation->SpotId != 3) {
                    $this->bookandpay_model->newvoucher($reservation->reservationId);
                }

                $this->bookandpay_model->editbookandpay([
                    'mobilephone' => $buyerInfo['mobilephone'],
                    'email' => $buyerInfo['email'],
                    'name' => $buyerInfo['name'],
                ], $reservation->reservationId);
            }

            $orderData['amount'] = number_format($amount, 2, '.', '');

            $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();

        } else {
            redirect('agenda_booking/pay?order=' . $orderRandomKey);
        }

        
        redirect('/agenda_booking/select_payment_type?order=' . $orderRandomKey);
        
    }

    public function select_payment_type()
    {
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;
        
        if(!$orderRandomKey){
            redirect(base_url());
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }

        $customer = $orderData['customer'];

        $this->load->helper('money');

        $this->global['pageTitle'] = 'Payment Method';

        $data['activePayments'] = $this->bookandpayagendabooking_model->get_active_payment_methods($customer['id']);
        $data['idealPaymentType'] = $this->config->item('idealPaymentType');
        $data['creditCardPaymentType'] = $this->config->item('creditCardPaymentType');
        $data['bancontactPaymentType'] = $this->config->item('bancontactPaymentType');
        $data['giroPaymentType']           = $this->config->item('giroPaymentType');
        $data['payconiqPaymentType']       = $this->config->item('payconiqPaymentType');
        $data['myBankPaymentType']         = $this->config->item('myBankPaymentType');
        $data['shortUrl']                  = $customer['usershorturl'];
        $data['idealPaymentText']          = $this->config->item('idealPayment');
        $data['creditCardPaymentText']    = $this->config->item('creditCardPayment');
        $data['bancontactPaymentText']     = $this->config->item('bancontactPayment');
        $data['giroPaymentText']         = $this->config->item('giroPayment');
        $data['payconiqPaymentText']       = $this->config->item('payconiqPayment');
        $data['voucherPaymentText']        = $this->config->item('voucherPayment');
        $data['pinMachinePaymentText']     = $this->config->item('pinMachinePayment');
        $data['myBankPaymentText']         = $this->config->item('myBankPayment');

        $amount = $orderData['amount'];

        $reservationsPayments = $this->bookandpayagendabooking_model->get_payment_methods($customer['id']);
        $vendorCost = $this->bookandpayagendabooking_model->get_vendor_cost($customer['id']);
        $data['vendorCost'] = $vendorCost;
        foreach($reservationsPayments as $key => $reservationsPayment){
            $paymentMethod = ucwords($key);
            $paymentMethod = str_replace(' ', '', $paymentMethod);
            $paymentMethod = lcfirst($paymentMethod);
            $total_amount = (floatval($amount)*floatval($reservationsPayment['percent'])/100) + floatval($reservationsPayment['amount']);
            if((isset($vendorCost[$key]) && $vendorCost[$key] == 1) || $total_amount  == 0){
                $data[$paymentMethod] = 0;
            } else {
                $data[$paymentMethod] = number_format($total_amount, 2, '.', '');
            }
        }
        
        $this->global['amount'] = $orderData['amount'];
        $data['orderRandomKey'] = $orderRandomKey;

        $this->loadViews("new_bookings/select_payment_type", $this->global, $data,  'footerPayment', 'headerPayment');
    }

}