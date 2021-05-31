<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Booking_agenda extends BaseControllerWeb
{
    private $data = array();

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
        

        if(count($orderData) < 1){
            $orderData = $this->shopsession_model->insertSessionData($sessionData);
            redirect('/booking_agenda/'.$shortUrl.'?order='.$orderData->randomKey);
            return ;
        }

        $data['agenda'] = $this->bookandpayagendabooking_model->getbookingagenda($customer->id);

        $logoUrl = 'assets/home/images/tiqslogowhite.png';
        if ($customer->logo) {
			$logoUrl = 'assets/images/vendorLogos/' . $customer->logo;
        }

        $data['logoUrl'] = $logoUrl;
        $data['pageTitle'] = 'TIQS: RESERVATIONS & BOOKINGS';
        $data['shortUrl'] = $shortUrl;
        $data['orderRandomKey'] = $orderRandomKey;
        $this->loadViews('bookings/index', $data, '', 'bookingfooter', 'bookingheader');
        

        
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

        if (empty($customer) || !isset($customer['id'])) {
            redirect();
        }

        if (empty($eventDate) || empty($eventId)) {
            redirect('booking_agenda/' . $customer['usershorturl']);
        }

        $orderData['eventDate'] = $eventDate;
        $orderData['eventId'] = $eventId;
        $orderData['spot'] = $eventId;

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
                'data' => $spot,
                'status' => 'open'
            ];

            $allTimeSlots = $this->bookandpaytimeslots_model->getTimeSlotsByCustomerAndSpot($customer['id'], $spot->id);
            $isThereAvailableTimeSlots = true;

            foreach ($allTimeSlots as $key => $timeSlot) {
                $spotsReserved = $this->bookandpay_model->getBookingByTimeSlot($customer['id'], $eventDate, $timeSlot->id);
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

            if (!$isThereAvailableTimeSlots) {
                $spots['spot' . $spot->id]['status'] = 'soldout';
            }
        }

        $data["eventDate"] = $eventDate;
        $data["eventId"] = $eventId;
        $data["spots"] = $spots;
        $data["bookingfee"] = 0.15;
        $data["orderRandomKey"] = $orderRandomKey;


        $this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->loadViews("bookings/spots_booking", $this->global, $data, 'bookingfooter', 'bookingheader');    
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

        $eventDate = $orderData['eventDate'];
        $eventId = $orderData['eventId'];

        if (empty($eventDate) || empty($eventId)) {
            redirect('booking_agenda/' . $customer['usershorturl']);
        }
 
        $spot = $this->bookandpayspot_model->getSpot($spotId);
        $spotReservations = 0;

        $availableItems = $spot->available_items;
        $price = $spot->price;
        $spotLabel = $spot->numberofpersons . ' persoonstafel';
        $numberOfPersons = $spot->numberofpersons;

        $resultcount = $this->bookandpay_model->countreservationsinprogress($spot->id, $customer['id'], $eventDate);
        //$allTimeSlots = $this->bookandpaytimeslots_model->getTimeSlotsByCustomerAndSpot($customer['id'], $spot->id);

        $allTimeSlots = $this->bookandpaytimeslots_model->getTimeSlotsBySpotId($spotId);
        $eventDate = $this->bookandpayspot_model->getAgendaBySpotId($spotId)->ReservationDateTime;
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
        

        if ($spotReservations >= $availableItems) {
            redirect('soldout');
        }


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
            $newBooking = [
                'customer' => $customer['id'],
                'eventid' => $eventId,
                'eventdate' => date("Y-m-d", strtotime($eventDate)),
                'SpotId' => $spot->id,
                'Spotlabel' => $spotLabel,
                'timefrom' => $fromtime,
                'timeto' => $totime,
                'timeslot' => $selectedTimeSlot->id,
                'timeslotId' => $selectedTimeSlot->id,
                'reservationFee' => $selectedTimeSlot->reservationFee,
                'price' => $selectedTimeSlot->price ? $selectedTimeSlot->price : $price,
                'numberofpersons' => $numberOfPersons,
                'reservationset' => '1'
            ];

            // create new id for user of this session
            $result = $this->bookandpay_model->newbooking($newBooking);

            if (empty($result)) {
                // someting went wrong.
                redirect('booking_agenda/' . $customer['usershorturl']);
            }

            $reservations = $orderData['reservations'];

            if (!is_null($reservations)) {
                array_push($reservations, $result->reservationId);
            } else {
                $reservations = [$result->reservationId];
            }

            if(count($reservations) <= $spot->maxBooking){
                $orderData['reservations'] = $reservations;
                $orderData['selectedTimeSlot'] = $selectedTimeSlot;
            }

            $this
            ->shopsession_model
            ->setIdFromRandomKey($orderRandomKey)
            ->setProperty('orderData', Jwt_helper::encode($orderData))
            ->update();

            if($spot->price == 0){
                redirect('booking_agenda/pay?order=' . $orderRandomKey);
            }

            if($spot->maxBooking > 1){
                redirect('booking_agenda/reserved?order=' . $orderRandomKey);
            } else {
                redirect('booking_agenda/pay?order=' . $orderRandomKey);
            }

            
        }

        $this
            ->shopsession_model
            ->setIdFromRandomKey($orderRandomKey)
            ->setProperty('orderData', Jwt_helper::encode($orderData))
            ->update();

        $data['count'] = $resultcount;
        $data['spot'] = $spot;
        $data['timeSlots'] = $timeSlots;
        $data['eventDate'] = $eventDate;
        $data["orderRandomKey"] = $orderRandomKey;
        
        $this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->load->config('custom');
        $this->load->helper('directory');
        $this->load->model('floorplandetails_model');
        $this->load->model('floorplanareas_model');
        $planId = $this->bookandpaytimeslots_model->getPlanId($spotId);
		if ($planId) {
			$data['floorplan'] = $this->floorplandetails_model->get_floorplan($planId);
			$data['areas'] = $this->floorplanareas_model->get_floorplan_areas($planId);
        }

		//Get all files from dir
        $floorplan_images = directory_map(FCPATH . $this->config->item('floorPlansImagesPath'), FALSE);

		//Remove '/' from category name, remove index.html
        foreach ($floorplan_images as $category => $val) {
            $new_cat_name = str_replace(DIRECTORY_SEPARATOR, '',$category);
            $floorplan_images[$new_cat_name] = $floorplan_images[$category];
            unset($floorplan_images[$category]);
            if (isset($floorplan_images[$new_cat_name]) AND is_array($floorplan_images[$new_cat_name])) {
                foreach ($floorplan_images[$new_cat_name] as $key => $file) {
                    if ($file == 'index.html') {
                        unset($floorplan_images[$new_cat_name][$key]);
                    }

                }
            }
        }

        $data['floorplan_images_path'] = $this->config->item('floorPlansImagesPath');
        $data['floorplan_images']  = $floorplan_images;

        $this->loadViews("bookings/timeslot_booking", $this->global, $data, 'bookingfooter', 'bookingheader');
    }

    public function reserved()
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
        $reservationIds = $orderData['reservations'];
        $selectedTimeSlot = $orderData['selectedTimeSlot'];

        if (empty($customer) || !isset($customer['id'])) {
            redirect();
        }

        if (!$reservationIds) {
            redirect('booking_agenda/' . $customer['usershorturl']);
        }

        $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
        if (!$reservations) {
            redirect('booking_agenda/' . $customer['usershorturl']);
        }

        $logoUrl = 'assets/user_images/no_logo.png';
        if ($customer['logo']) {
			$logoUrl = 'assets/images/vendorLogos/' . $customer['logo'];
        }

        $allTimeSlots = $this->bookandpaytimeslots_model->getTimeSlotsByCustomerAndSpot($customer['id'], $selectedTimeSlot['spot_id']);

        $data['logoUrl'] = $logoUrl;
        $data['reservations'] = $reservations;
        $data['selectedTimeSlot'] = $selectedTimeSlot;
        $data['allTimeSlots'] = $allTimeSlots;
        $spot = $this->bookandpayspot_model->getSpot($selectedTimeSlot['spot_id']);
        $data['maxBooking'] = intval($spot->maxBooking);
        $data["orderRandomKey"] = $orderRandomKey;
        $data["bookings"] = $orderData['reservations'];

     
        $this->global['pageTitle'] = 'TIQS : BOOKINGS';

        $this->loadViews("bookings/next_time_slot", $this->global, $data, 'bookingfooter', 'bookingheader'); // payment screen
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

        $customer = $orderData['customer'];
        $reservationIds = $orderData['reservations'];

        $this->load->library('form_validation');
        


        if (empty($customer) || !isset($customer['id'])) {
            redirect();
        }

        if (!$reservationIds) {
            redirect('booking_agenda/' . $customer['usershorturl']);
        }

        $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
        if (!$reservations) {
            redirect('booking_agenda/' . $customer['usershorturl']);
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

            redirect('booking_agenda/payment_proceed?order=' . $orderRandomKey);
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
        $data['orderRandomKey'] = $orderRandomKey;

        $this->global['pageTitle'] = 'TIQS : BOOKINGS'; 
        $data['termsofuse'] = $this->bookandpayagendabooking_model->getTermsofuse();
        $this->loadViews("bookings/final", $this->global, $data, 'bookingfooter', 'bookingheader'); // payment screen
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


        $amount = 0;
        $buyerInfo = $orderData['buyer_info'];
        var_dump($buyerInfo);
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
            redirect('booking_agenda/pay?order=' . $orderRandomKey);
        }

        
        redirect('/booking_agenda/select_payment_type?order=' . $orderRandomKey);
        
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

        $this->loadViews("bookings/select_payment_type", $this->global, $data, 'footerPayment', "headerPayment");
    }

    public function delete_reservation($id = false)
    {
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;
        
        if(!$orderRandomKey){
            redirect(base_url());
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }



        if(!$id) {
            redirect();
        }

        $reservation = $this->bookandpay_model->getReservationById($id);

        if(!$reservation) {
            redirect();
        }

        

        $reservationIds = $orderData['reservations'];
        //var_dump($reservationIds);
        
        foreach ($reservationIds as $key=>$item) {
            if($item == $reservation->reservationId) {
                unset($reservationIds[$key]);
                $this->bookandpay_model->deleteReservation($id);
            }
        }


        $orderData['reservations'] = $reservationIds;

        $this
            ->shopsession_model
            ->setIdFromRandomKey($orderRandomKey)
            ->setProperty('orderData', Jwt_helper::encode($orderData))
            ->update();

        redirect('booking_agenda/reserved?order=' . $orderRandomKey);
    }


    public function create_spots()
    {
        $this->load->model('Bookandpayspot_model');
        $data = array(
            'agenda_id' => $this->input->post('agenda_id'),
            'email_id' => 0,
            'numberofpersons' => $this->input->post('numberofpersons'),
            'sort_order' => $this->input->post('order'),
            'price' => $this->input->post('price'),
            'descript' => $this->input->post('description'),
            'soldoutdescript' => $this->input->post('soldoutdescript'),
            'pricingdescript' => $this->input->post('pricingdescript'),
            'feedescript' => $this->input->post('feedescript'),
            'available_items' => $this->input->post('available_items'),
            'image' => $this->input->post('image')
        );
        $this->Bookandpayspot_model->addSpot($data);
    }

    public function get_agenda($shortUrl=false)
    {
        $customer = $this->user_model->getUserInfoByUrlName($shortUrl);
        $date = $this->input->post('date');
        $data['agenda'] = $this->bookandpayagendabooking_model->getBookingAgendaByDate($customer->id, $date);
        echo json_encode($data['agenda']);
        
    }

    public function getAllAgenda($shortUrl=false)
    {
        $customer = $this->user_model->getUserInfoByUrlName($shortUrl);
        $agendas = $this->bookandpayagendabooking_model->getAllCustomerAgenda($customer->id);
        $allAgenda = [];
        foreach($agendas as $agenda){
            $status = $this->bookandpay_model->getBookingCountByAgenda($customer->id,$agenda->id);
            $agenda->status = $status > 0 ? 1 : 0;
            $allAgenda[] = $agenda;

        }

        echo json_encode($allAgenda);
        
    }

    public static function explode_time($time){
        $time = explode(':', $time);
        $time = $time[0]*3600+$time[1]*60;
        return $time;
    }

    public static function second_to_hhmm($time){
        $hour = floor($time/3600);
        $hour = ($hour > 24) ? $hour - 24 : $hour;
        $min = strval(floor(($time%3600)/60));
        if($min <= 9){
            $min = '0'.$min;
        }
        $time = $hour . ':' . $min; 
        return $time;
    }

    public static function check_if_soldout($timeslotId, $fromtime, $totime, $availableItems) : bool
    {
        $CI =& get_instance();
        $spotReserved = $CI->bookandpay_model->getBookingCountByTimeSlot($timeslotId, $fromtime, $totime);
        if($spotReserved >= $availableItems){
            return true;
        }
        return false;
    }

    public function changeReservation(): void
    {
        $data['pageTitle'] = 'TIQS : CHANGE RESERVATION';

        $this->loadViews('bookings/changeReservation', $data, '', 'bookingfooter', 'bookingheader');
    }

    public function resendReservation() : void
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
        $shortUrl = $customer['usershorturl'];

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[255]');
        $this->form_validation->set_rules('eventdate', 'Event Date', 'trim|required|max_length[255]');

        $eventdate = $this->input->post('eventdate');
        $getDate = explode('/', $eventdate);

        if (!$this->form_validation->run() && is_array($getDate) && count($getDate) !== 3) {
            redirect('/booking_agenda/' . $shortUrl . '?order='. $orderRandomKey);
        }

		$email = strtolower($this->input->post('email'));
        
		$dateFormat = $getDate[2] . '-' . $getDate[1] . '-' . $getDate[0];

        $this->load->helper('reservationsemail_helper');
        $reservations = $this->bookandpay_model->getReservationsByEmailAndDate($email, $dateFormat);
        if(Reservationsemail_helper::sendEmailReservation($reservations, true, true)){
            redirect('/booking_agenda/' . $shortUrl . '?order='. $orderRandomKey);
        } else {
            redirect('/booking_agenda/' . $shortUrl . '?order='. $orderRandomKey);
        }
        
    }

}
