<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/BaseControllerWeb.php';

class Agenda_booking extends BaseControllerWeb
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('jwt_helper');
        $this->load->helper('utility_helper');


        $this->load->model('user_model');
        $this->load->model('bookandpay_model');
        $this->load->model('bookandpayspot_model');
        $this->load->model('bookandpayagendabooking_model');
        $this->load->model('bookandpaytimeslots_model');
        $this->load->model('sendreservation_model');
        $this->load->model('email_templates_model');
        $this->load->model('shopvendor_model');
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
            redirect(base_url() . 'agenda_booking/'.$shortUrl.'?order='.$orderData->randomKey);
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
        $data['shortUrl'] = $shortUrl;
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

        $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();
        

        $allSpots = $this->bookandpayspot_model->getAllSpots($customer['id']);
        
        $agenda = $this->bookandpayagendabooking_model->getbookingagenda($customer['id']);

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
                $spotReservations = $spotReservations + $this->bookandpay_model->getBookingCountBySpot($customer['id'], $spot->id, $timeSlot->id, $timeSlot->fromtime);
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
        $orderData['spotPrice'] = $spot->price.' €';
        

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
            $spotsReserved = $this->bookandpay_model->getBookingCountByTimeSlot($customer['id'], $timeSlot['id'], $spotId, $timeSlot['fromtime']);
            $spotReservations = $spotReservations + $this->bookandpay_model->getBookingCountBySpot($customer['id'], $spotId, $timeSlot['id'], $timeSlot['fromtime']);
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
                'reservationFee' => $selectedTimeSlot->reservationFee,
                'price' => $selectedTimeSlot->price ? $selectedTimeSlot->price : $price,
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

            if(count($reservations) <= 1){
                $orderData['reservations'] = $result->reservationId;
                $orderData['selectedTimeSlot'] = $selectedTimeSlot;
                $orderData['timeslotPrice'] = $selectedTimeSlot->price;
                $orderData['reservationFee'] = $selectedTimeSlot->reservationFee;
            }
            

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
        $data['timeslotPrice'] = isset($orderData['timeslotPrice']) ? $orderData['timeslotPrice'] : '';

        $this->global['pageTitle'] = 'TIQS : BOOKINGS'; 
        $this->global['customDesign'] = $this->bookandpayagendabooking_model->get_agenda_booking_design($customer['id']);
        $data['termsofuse'] = $this->bookandpayagendabooking_model->getTermsofuse();
        $this->loadViews("new_bookings/final", $this->global, $data, 'newbookingfooter', 'newbookingheader'); // payment screen
    }

    public function payment_proceed()
    {
        $buyerInfo = $this->input->post(null, true);
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;
        
        if(!$orderRandomKey){
            redirect(base_url());
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }

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

        $data = [
            'activePayments'            => $this->bookandpayagendabooking_model->get_active_payment_methods($customer['id']),
            'idealPaymentType'          => $this->config->item('idealPaymentType'),
            'creditCardPaymentType'     => $this->config->item('creditCardPaymentType'),
            'bancontactPaymentType'     => $this->config->item('bancontactPaymentType'),
            'giroPaymentType'           => $this->config->item('giroPaymentType'),
            'payconiqPaymentType'       => $this->config->item('payconiqPaymentType'),
            'myBankPaymentType'         => $this->config->item('myBankPaymentType'),
            'shortUrl'                  => $customer['usershorturl'],
            'idealPaymentText'          => $this->config->item('idealPayment'),
            'creditCardPaymentText'     => $this->config->item('creditCardPayment'),
            'bancontactPaymentText'     => $this->config->item('bancontactPayment'),
            'giroPaymentText'           => $this->config->item('giroPayment'),
            'payconiqPaymentText'       => $this->config->item('payconiqPayment'),
            'voucherPaymentText'        => $this->config->item('voucherPayment'),
            'pinMachinePaymentText'     => $this->config->item('pinMachinePayment'),
            'myBankPaymentText'         => $this->config->item('myBankPayment'),
        ];

        $amount = $orderData['amount'];

        $reservationsPayments = $this->bookandpayagendabooking_model->get_payment_methods($customer['id']);
        $vendorCost = $this->bookandpayagendabooking_model->get_vendor_cost($customer['id']);
        foreach($reservationsPayments as $key => $reservationsPayment){
            $paymentMethod = ucwords($key);
            $paymentMethod = str_replace(' ', '', $paymentMethod);
            $paymentMethod = lcfirst($paymentMethod);
            $total_amount = floatval($amount)*floatval($reservationsPayment['percent']) + floatval($reservationsPayment['amount']);
            if((isset($vendorCost[$key]) && $vendorCost[$key] == 1) || $total_amount  == 0){
                $data[$paymentMethod] = '&nbsp';
            } else {
                $data[$paymentMethod] = '€'. number_format($total_amount, 2, '.', '');
            }
        }
        
        $this->global['amount'] = $orderData['amount'];
        $data['orderRandomKey'] = $orderRandomKey;

        $this->loadViews("new_bookings/select_payment_type", $this->global, $data,  'footerPayment', 'headerPayment');
    }

    public function delete_reservation($id = false)
    {
        if(!$id) {
            redirect();
        }

        $reservation = $this->bookandpay_model->getReservationById($id);

        if(!$reservation) {
            redirect();
        }

        

        $reservationIds = $this->session->userdata('reservations');
        //var_dump($reservationIds);
        
        foreach ($reservationIds as $key=>$item) {
            if($item == $reservation->reservationId) {
                unset($reservationIds[$key]);
                $this->bookandpay_model->deleteReservation($id);
            }
        }


        $this->session->set_userdata('reservations', $reservationIds);

        redirect('agenda_booking/reserved');
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
        $customer = $this->user_model->getUserInfoByShortUrl($shortUrl);
        $date = $this->input->post('date');
        $this->session->set_userdata('date', $date);
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
        $min = strval(floor(($time%3600)/60));
        if($min <= 9){
            $min = '0'.$min;
        }
        $time = $hour . ':' . $min; 
        return $time;
    }

    public function design()
    {
        $this->load->model('user_modelpublic');
        if(null === $this->session->userdata('userId')) return;
        if(!$this->session->userdata('userId')) return;
        $this->load->model('user_model');
        $vendor_id = $this->session->userdata('userId');
        $userShortUrl = $this->user_model->getUserShortUrlById($vendor_id);
        $user = $this->user_modelpublic->getUserInfoById($vendor_id);
        $iframeSrc = base_url() . 'agenda_booking/' . $user->usershorturl;
        $design = $this->bookandpayagendabooking_model->get_agenda_booking_design($vendor_id);
        $devices = $this->bookandpayagendabooking_model->get_devices();
        $data = [
                'iframeSrc' => $iframeSrc,
                'id' => $user->userId,
                'userShortUrl' => $userShortUrl,
                'devices' => $devices,
                'design' => unserialize($design[0]['design']),
            ];


        $this->global['pageTitle'] = 'TIQS : DESIGN';
        $this->loadViews('new_bookings/agenda_booking_design', $this->global, $data, 'footerbusiness', 'headerbusiness');
        return;
    }

    public function saveDesign()
    {
        $data = [
            'vendor_id' => $this->session->userdata('userId'),
            'design' => serialize($this->input->post(null,true)),
        ];

        $this->bookandpayagendabooking_model->save_agenda_booking_design($this->session->userdata('userId'),$data);
        redirect('agenda_booking/design');
    }

    public function iframeJson($shortUrl=false)
    {
        $data['shortUrl'] = $shortUrl;
        $result = $this->load->view('popup', $data,true);
        return $this->output
					->set_content_type('application/json')
					->set_status_header(200)
					->set_output(json_encode($result));
        
    }

    public function replaceButtonStyle()
    {
        
        $cssFile = FCPATH.'assets/home/styles/popup-style.css';
        $jsFile = FCPATH.'assets/home/js/popup.js';
        //CSS FILE
        $f = fopen($cssFile, 'r');
        $newCssContent = '';
        for ($i = 1; ($line = fgets($f)) !== false; $i++) {
            if($line == '#iframe-popup-open{'){
                echo 'true';
            }
            if (strpos($line, '#iframe-popup-open') !== false) {
                break;
            }
            $newCssContent.= $line;
        }

        $newCssContent .= $this->input->post('buttonStyle');
        $f = fopen($cssFile, 'w');
        fwrite($f,$newCssContent);
        fclose($f);

        //JS FILE
        $f = fopen($jsFile, 'r');
        $newJsContent = '';
        $btnText = $this->input->post('btnText');
        for ($i = 1; ($line = fgets($f)) !== false; $i++) {
            if (strpos($line, "document.getElementById('iframe-popup-open').textContent") !== false) {
                $line = "document.getElementById('iframe-popup-open').textContent = '$btnText'; \n";
            }
            $newJsContent .= $line;
        }
        $f = fopen($jsFile, 'w');
        fwrite($f,$newJsContent);
        fclose($f);
    }

}