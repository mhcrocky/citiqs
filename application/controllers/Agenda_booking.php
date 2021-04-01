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
        $this->load->model('user_model');
        $this->load->model('bookandpay_model');
        $this->load->model('bookandpayspot_model');
        $this->load->model('bookandpayagendabooking_model');
        $this->load->model('bookandpaytimeslots_model');
        $this->load->model('sendreservation_model');
        $this->load->model('email_templates_model');
        $this->load->helper('utility_helper');
        $this->load->library('language', array('controller' => $this->router->class)); 
    }

    public function index($shortUrl=false)
    {

        if (!$shortUrl) {
            redirect('https://tiqs.com/places');
        }

        $customer = $this->user_model->getUserInfoByShortUrl($shortUrl);
        

        if (!$customer) {
			redirect('https://tiqs.com/places');
        }

        $this->session->unset_userdata('reservations');
        $this->session->unset_userdata('spotDescript');
        $this->session->unset_userdata('spotPrice');
        $this->session->unset_userdata('timeslot');
        $customer->logo = (property_exists($customer, 'logo')) ? $customer->logo : '';
        $this->session->set_userdata('customer', [
            'id' => $customer->id,
            'usershorturl' => $customer->usershorturl,
            'username' => $customer->username,
            'first_name' => $customer->first_name,
            'second_name' => $customer->second_name,
            'email' => $customer->email,
            'logo' => $customer->logo,
        ]);

        $data['agendas'] = $this->bookandpayagendabooking_model->getbookingagenda($customer->id);
        $data['agenda_dates'] = $this->bookandpayagendabooking_model->getbookingagendadate($customer->id);


        $logoUrl = 'assets/user_images/no_logo.png';
        if ($customer->logo) {
			$logoUrl = 'assets/images/vendorLogos/' . $customer->logo;
        }
        $data['logoUrl'] = $logoUrl;
        $this->global['pageTitle'] = 'TIQS: AGENDA';
        $this->global['customDesign'] = $this->bookandpayagendabooking_model->get_agenda_booking_design($customer->id);
        $this->session->set_userdata('shortUrl', $shortUrl);
        $data['shortUrl'] = $shortUrl;
        $this->loadViews('new_bookings/index', $this->global, $data, 'newbookingfooter', 'newbookingheader');
        

        
    }

    public function spots($eventDate = false, $eventId = false)
    {
        $customer = $this->session->userdata('customer');

        if (empty($customer) || !isset($customer['id'])) {
            redirect();
        }

        if (empty($eventDate) || empty($eventId)) {
            redirect('agenda_booking/' . $customer['usershorturl']);
        }

        $this->session->set_userdata('eventDate', $eventDate);
        $this->session->set_userdata('eventId', $eventId);
        $this->session->set_userdata('spot', $eventId);
        $this->session->unset_userdata('spotDescript');
        $this->session->unset_userdata('spotPrice');
        $this->session->unset_userdata('timeslot');

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
        $data['isManager'] = ($this->session->userdata('role') == ROLE_MANAGER) ? true : false;
        $data['spot_images'] = [
            'twoontable.png',
            'sixtable.png',
            'fourontable.png',
            'eighttable.png',
            'sunbed.png',
            'terracereservation.png'
        ];

        $this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->global['customDesign'] = $this->bookandpayagendabooking_model->get_agenda_booking_design($customer['id']);
        $this->loadViews("new_bookings/spots_booking", $this->global, $data, 'newbookingfooter', 'newbookingheader');    
    }

    public function time_slots($spotId)
    {
        
        $customer = $this->session->userdata('customer');

        if (empty($customer) || !isset($customer['id'])) {
            redirect();
        }

        $eventDate = $this->session->userdata('eventDate');
        $eventId = $this->session->userdata('eventId');

        if (empty($eventDate) || empty($eventId)) {
            redirect('agenda_booking/' . $customer['usershorturl']);
        }

        $spot = $this->bookandpayspot_model->getSpot($spotId);
        $spotReservations = 0;
        $this->session->set_userdata('spotDescript', $spot->descript);
        $this->session->set_userdata('spotPrice', $spot->price.' €');
        $this->session->unset_userdata('timeslot');

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
            $this->session->set_userdata('timeslot', $timeslot_sess);
            $this->session->set_userdata('spotId', $spot->id);
            $newBooking = [
                'customer' => $customer['id'],
                'eventid' => $eventId,
                'eventdate' => date("yy-m-d", strtotime($eventDate)),
                'SpotId' => $spot->id,
                'Spotlabel' => $spotLabel,
                'timefrom' => $fromtime,
                'timeto' =>  $totime,
                'timeslot' => $selectedTimeSlot->id,
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

            $reservations = $this->session->userdata('reservations');

            if (!is_null($reservations)) {
                array_push($reservations, $result->reservationId);
            } else {
                $reservations = [$result->reservationId];
            }

            if(count($reservations) <= 2){
                $this->session->set_userdata('reservations', $reservations);
                $this->session->set_userdata('selectedTimeSlot', $selectedTimeSlot);
            }

            if($spot->price == 0){
                redirect('agenda_booking/pay');
            }

            

            redirect('agenda_booking/pay');
            
        }

        $data['count'] = $resultcount;
        $data['spot'] = $spot;
        $data['timeSlots'] = $timeSlots;
        $data['eventDate'] = $eventDate;
        
        $this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->global['customDesign'] = $this->bookandpayagendabooking_model->get_agenda_booking_design($customer['id']);

        $this->loadViews("new_bookings/timeslot_booking", $this->global, $data, 'newbookingfooter', 'newbookingheader');
    }

    public function reserved()
    {
        $reservationIds = $this->session->userdata('reservations');
        $customer = $this->session->userdata('customer');
        $selectedTimeSlot = $this->session->userdata('selectedTimeSlot');

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

        $logoUrl = 'assets/user_images/no_logo.png';
        if ($customer['logo']) {
			$logoUrl = 'assets/images/vendorLogos/' . $customer->logo;
        }

        $allTimeSlots = $this->bookandpaytimeslots_model->getTimeSlotsByCustomerAndSpot($customer['id'], $selectedTimeSlot->spot_id);

        $data['logoUrl'] = $logoUrl;
        $data['reservations'] = $reservations;
        $data['selectedTimeSlot'] = $selectedTimeSlot;
        $data['allTimeSlots'] = $allTimeSlots;

        $this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->global['customDesign'] = $this->bookandpayagendabooking_model->get_agenda_booking_design($customer['id']);

        $this->loadViews("new_bookings/next_time_slot", $this->global, $data, 'newbookingfooter', 'newbookingheader'); // payment screen
    }

    public function pay()
    {
        $this->load->library('form_validation');
        $reservationIds = $this->session->userdata('reservations');
        $customer = $this->session->userdata('customer');

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
            $data['mobilephone'] = strtolower($this->input->post('mobile'));
            $data['email'] = strtolower($this->input->post('email'));
            $data['name'] = strtolower($this->input->post('username'));

            $this->session->set_userdata('buyer_info', $data);

            redirect('agenda_booking/payment_proceed');
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

        $this->global['pageTitle'] = 'TIQS : BOOKINGS'; 
        $this->global['customDesign'] = $this->bookandpayagendabooking_model->get_agenda_booking_design($customer['id']);
        $data['termsofuse'] = $this->bookandpayagendabooking_model->getTermsofuse();
        $this->loadViews("new_bookings/final", $this->global, $data, 'newbookingfooter', 'newbookingheader'); // payment screen
    }

    public function payment_proceed()
    {
        $amount = 0;
        $buyerInfo = $this->session->userdata('buyer_info');
        $reservationIds = $this->session->userdata('reservations');
        
        if ($buyerInfo) {
            $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
            $this->session->set_userdata('buyerEmail', $buyerInfo['email']);

            foreach ($reservations as $key => $reservation) {
                $amount += floatval($reservation->price);

                if ($reservation->SpotId != 3) {
                    $this->bookandpay_model->newvoucher($reservation->reservationId);
                }

                $this->bookandpay_model->editbookandpay([
                    'mobilephone' => $buyerInfo['mobilephone'],
                    'email' => $buyerInfo['email'],
                    'name' => $buyerInfo['name'],
                ], $reservation->reservationId);
            }

            $this->session->set_userdata('amount', $amount);

        } else {
            redirect('agenda_booking/pay');
        }

        
        redirect('/agenda_booking/select_payment_type');
        
    }

    public function select_payment_type()
    {
        $this->load->helper('money');

        $this->global['pageTitle'] = 'Payment Method';
        $data['idealPaymentType'] = $this->config->item('idealPaymentType');
        $data['creditCardPaymentType'] = $this->config->item('creditCardPaymentType');
        $data['bancontactPaymentType'] = $this->config->item('bancontactPaymentType');
        $data['giroPaymentType'] = $this->config->item('giroPaymentType');
        $data['payconiqPaymentType'] = $this->config->item('payconiqPaymentType');
        $data['pinMachinePaymentType'] = $this->config->item('pinMachinePaymentType');
        $data['myBankPaymentType'] = $this->config->item('myBankPaymentType');
        $amount = $this->session->userdata('amount');

        $reservationsPayments = $this->bookandpayagendabooking_model->get_payment_methods($this->session->userdata('customer')['id']);
        foreach($reservationsPayments as $key => $reservationsPayment){
            $paymentMethod = ucwords($key);
            $paymentMethod = str_replace(' ', '', $paymentMethod);
            $paymentMethod = lcfirst($paymentMethod);
            $data[$paymentMethod] = floatval($amount/100)*$reservationsPayment['percent'] + $reservationsPayment['amount'];
        }
        
        $data['amount'] = $this->session->userdata('amount');

        $this->loadViews("new_bookings/select_payment_type", $this->global, $data, 'bookingfooter', "bookingheader");
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