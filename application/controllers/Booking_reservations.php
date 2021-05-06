<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
include APPPATH . '/libraries/ical/ICS.php';

class Booking_reservations extends BaseControllerWeb
{
    function __construct()
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
        $this->load->library('language', array('controller' => $this->router->class)); 
    } 

    public function index($shortUrl = false)
    {
        if (!$shortUrl) {
            redirect('https://tiqs.com/places');
        }

        $this->session->unset_userdata('customer');

        if($this->session->userdata('eTicketing')){
            session_unset();
        }

        $this->session->set_userdata('bookings', true);

        $customer = $this->user_model->getUserInfoByShortUrl($shortUrl);
        

        if (!$customer) {
			redirect('https://tiqs.com/places');
        }

        $logoUrl = 'assets/home/images/tiqslogowhite.png';
        if ($customer->logo) {
			$logoUrl = 'assets/images/vendorLogos/' . $customer->logo;
        }

        if($this->session->userdata('shortUrl') != $shortUrl){
            $this->session->unset_userdata('tickets');
            $this->session->unset_userdata('exp_time');
            $this->session->unset_userdata('total');
        }

        $this->session->set_userdata('shortUrl', $shortUrl);

        $data['logoUrl'] = $logoUrl;
        $this->global['pageTitle'] = 'TIQS: RESERVATIONS & BOOKINGS';

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
        $customer = $this->user_model->getUserInfoByShortUrl($shortUrl);
        

        
        $this->loadViews("booking_agenda/shop", $this->global, $data, 'footerBooking', 'headerBooking');

    }

    public function spots($eventDate = false, $eventId = false)
    {
        if(!$this->input->post('isAjax')){ 
            redirect('booking_agenda/shop/'. $this->session->userdata('shortUrl'));
            return; 
        }

        $customer = $this->session->userdata('customer');

        if (empty($customer) || !isset($customer['id'])) {
            redirect();
        }

        if (empty($eventDate) || empty($eventId)) {
            redirect('booking_reservations/' . $customer['usershorturl']);
        }

       

        $this->session->set_userdata('eventDate', $eventDate);
        $this->session->set_userdata('eventId', $eventId);
        $this->session->set_userdata('spot', $eventId);

        $allSpots = $this->bookandpayspot_model->getAllSpots($customer['id']);

        $data['agenda'] = $this->bookandpayagendabooking_model->getAgendaById($eventId);
        $agenda = $this->bookandpayagendabooking_model->getbookingagenda($customer['id']);

        $spots = [];

        foreach ($allSpots as $spot) {
            $allSpotReservations = 0;
            $availableItems = 0;

            //if spot description is empty we use agenda description
            if(empty($spot->descript) && isset($agenda[0])) {
                $spot->descript = $agenda[0]->ReservationDescription;
            }

            $allTimeSlots = $this->bookandpaytimeslots_model->getTimeSlotsByCustomerSpotId($customer['id'], $spot->id);

            
            $isThereAvailableTimeSlots = true;
            $timeslots = [];
            foreach ($allTimeSlots as $key => $timeSlot) {
                $spotsReserved = $this->bookandpay_model->getBookingByTimeSlot($customer['id'], $eventDate, $timeSlot->id);
                $availableItems += $timeSlot->available_items;
                $totalSpotsReserved = $this->bookandpay_model->getBookingCountByTimeSlot($customer['id'], $timeSlot->id, $spot->id, $timeSlot->fromtime);
                
                if($totalSpotsReserved >= $timeSlot->available_items){
                    continue;
                } else {
                    $timeslots[] = $timeSlot;
                }



                if($spotsReserved) {
                    $allSpotReservations += count($spotsReserved);
                }

                
            }

            $spots['spot' . $spot->id] = [
                'data' => $spot,
                'status' => 'open',
                'timeslots' => $timeslots
            ];

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

        $this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $result = $this->load->view("booking_agenda/spots", $data,true);
				if( isset($result) ) {
					return $this->output
					->set_content_type('application/json')
					->set_status_header(200)
					->set_output(json_encode($result));
				}
           
    }

    public function add_to_basket()
    {
        $customer = $this->session->userdata('customer');
        $first_booking = false;
        if(!$this->session->userdata('tickets')){
            $first_booking = true;
        }
        $bookings = $this->session->userdata('tickets') ?? [];
        $quantity = 0;
        if(count($bookings) > 0){
            foreach($bookings as $booking){
                $quantity = $quantity + $booking['quantity'];
            }
        }
        $booking = $this->input->post(null, true);
        $timeslotId = $booking['timeslotId'];
        if(($quantity == 2 && !isset($booking['remove'])) || $quantity > 2){
            echo 'error';
            return ;
        }

        $this->session->unset_userdata('bookings');
        $current_time = date($booking['time']);
        $newTime = date("Y-m-d H:i:s",strtotime("$current_time +10 minutes"));
        $this->session->set_tempdata('exp_time', $newTime, 600);
        $amount = (floatval($booking['price']) + floatval($booking['reservationFee']))*floatval($booking['quantity']);
        
        $agenda = $this->bookandpayagendabooking_model->getAgendaById($booking['agendaId']);
        unset($bookings[$timeslotId]);
        $timeslot = $this->bookandpaytimeslots_model->getTimeSlot($timeslotId);
        $bookings[$timeslotId] = [
            'customer' => $customer['id'],
            'eventid' => $booking['agendaId'],
            'eventdate' => date("Y-m-d", strtotime($agenda->ReservationDateTime)),
            'SpotId' => $booking['spotId'],
            'timefrom' => urldecode($booking['fromtime']),
            'timeto' => urldecode($booking['totime']),
            'timeslotId' => $timeslotId,
            'reservationFee' => $booking['reservationFee'],
            'price' => $booking['price'],
            'numberofpersons' => $booking['numberofpersons'],
            'reservationset' => '1',
            'quantity' => $booking['quantity']
        ];

        $dt1 = new DateTime(urldecode($booking['fromtime']));
        $fromtime = $dt1->format('H:i');
        $dt2 = new DateTime(urldecode($booking['totime']));
        $totime = $dt2->format('H:i');

        $total = 0;
        foreach($bookings as $booking){
            $total = $total + (floatval($booking['price']) + floatval($booking['reservationFee']))*floatval($booking['quantity']);
        }
        
        $this->session->set_tempdata('bookings', $bookings, 600);
        $this->session->set_tempdata('tickets', $bookings, 600);
        $total = number_format($total, 2, '.', '');
        $this->session->set_tempdata('total', $total, 600); 
        
        $reservation_data = [
            'fromtime'=> $fromtime,
            'totime'=>$totime,
            'numberofpersons' => $booking['numberofpersons'],
            'first_booking' => $first_booking,
            'eventDate' => date("d.m.Y", strtotime($agenda->ReservationDateTime)) 
        ];
        echo json_encode($reservation_data);
    }

    public function clear_reservations()
    {
        $this->session->unset_userdata('bookings');
        $this->session->unset_userdata('tickets');
        $this->session->unset_userdata('exp_time');
        $this->session->unset_userdata('total');
        $this->session->unset_tempdata('bookings');
        $this->session->unset_tempdata('tickets');
        $this->session->unset_tempdata('exp_time');
        $this->session->unset_tempdata('total');
        if(!$this->session->tempdata('tickets')){
            $this->session->set_flashdata('expired', 'Session Expired!');
            redirect('booking_reservations/'. $this->session->userdata('shortUrl'));
        }
    }

    public function delete_reservation()
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
            redirect('booking_reservations/'. $this->session->userdata('shortUrl'));
        }
        $this->loadViews("booking_agenda/pay", $this->global, '', 'footerBooking', 'headerBooking');
    }

    public function payment_proceed()
    {
        if($this->session->userdata('eTicketing')){
            redirect(base_url().'/booking_reservations/'.$this->session->userdata('shortUrl'));
        }

        $amount = 0;
        $buyerInfo = $this->input->post(null, true);
        $bookings = $this->session->tempdata('tickets');

        $reservationIds = $this->bookandpay_model->save_reservations($buyerInfo, $bookings);

        $this->session->set_userdata('reservations', $reservationIds);

        
        if ($buyerInfo) {
            $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
            $this->session->set_userdata('buyerEmail', $buyerInfo['email']);

            foreach ($reservations as $key => $reservation) {
                $amount += floatval($reservation->price) + floatval($reservation->reservationFee);

                if ($reservation->SpotId != 3) {
                    $this->bookandpay_model->newvoucher($reservation->reservationId);
                }

               
            }

            $this->session->set_userdata('amount', number_format($amount, 2, '.', ''));

        } else {
            //redirect('agenda_booking/pay');
        }

        
        redirect('/booking_reservations/select_payment_type');
        
    }
    
    
    public function select_payment_type()
    {
        if (empty($_SESSION['reservationIds'])) {
            redirect(base_url());
        }

        $this->load->helper('money');

        $this->global['pageTitle'] = 'Payment Method';
        $data['activePayments'] = $this->bookandpayagendabooking_model->get_active_payment_methods($this->session->userdata('customer')['id']);
        $data['idealPaymentType'] = $this->config->item('idealPaymentType');
        $data['creditCardPaymentType'] = $this->config->item('creditCardPaymentType');
        $data['bancontactPaymentType'] = $this->config->item('bancontactPaymentType');
        $data['giroPaymentType'] = $this->config->item('giroPaymentType');
        $data['payconiqPaymentType'] = $this->config->item('payconiqPaymentType');
        $data['pinMachinePaymentType'] = $this->config->item('pinMachinePaymentType');
        $data['myBankPaymentType'] = $this->config->item('myBankPaymentType');
        $amount = $this->session->userdata('amount');

        $reservationsPayments = $this->bookandpayagendabooking_model->get_payment_methods($this->session->userdata('customer')['id']);
        $vendorCost = $this->bookandpayagendabooking_model->get_vendor_cost($this->session->userdata('customer')['id']);
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
        
        $data['amount'] = $this->session->userdata('amount');

        $this->loadViews("booking_agenda/select_payment_type", $this->global, $data, 'footerPayment', "headerPayment");
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

}