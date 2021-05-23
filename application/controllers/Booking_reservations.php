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
        $this->load->model('shopvendor_model');
        $this->load->model('shopsession_model');
        $this->load->model('bookandpay_model');
        $this->load->model('bookandpayspot_model');
        $this->load->model('bookandpayagendabooking_model');
        $this->load->model('bookandpaytimeslots_model');
        $this->load->model('sendreservation_model');
        $this->load->model('email_templates_model');

        $this->load->helper('jwt_helper');
        $this->load->library('language', array('controller' => $this->router->class)); 
    } 

    public function index($shortUrl = false)
    {
        $this->global['pageTitle'] = 'TIQS: RESERVATIONS & BOOKINGS';

        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;

        $orderData = [];

        if($orderRandomKey){
            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        }


        if (!$shortUrl) {
            redirect(base_url());
        }


        $customer = $this->user_model->getUserInfoByShortUrl($shortUrl);       
        

        if (!$customer) {
			redirect(base_url());
        }

        $sessionData['vendorId'] = $customer->id;
        $sessionData['shortUrl'] = $shortUrl;
        $sessionData['spotId'] = 0;
        $sessionData['bookings'] = [];
        $sessionData['expTime'] = false;
        $sessionData['totalAmount'] = false;

        $logoUrl = (property_exists($customer, 'logo')) ? $customer->logo : '';
        $sessionData['customer'] = [
            'id' => $customer->id,
            'usershorturl' => $customer->usershorturl,
            'username' => $customer->username,
            'first_name' => $customer->first_name,
            'second_name' => $customer->second_name,
            'email' => $customer->email,
            'logo' => $customer->logo,
        ];

        $sessionData['logoUrl'] = $logoUrl;
        

        if(count($orderData) < 1){
            $orderData = $this->shopsession_model->insertSessionData($sessionData);
            redirect(base_url() . 'booking_reservations/' . $shortUrl . '?order=' . $orderData->randomKey);
        }


        $logoUrl = 'assets/home/images/tiqslogowhite.png';
        if ($customer->logo) {
			$logoUrl = 'assets/images/vendorLogos/' . $customer->logo;
        }



        $data['logoUrl'] = $logoUrl;

        $data['agendas'] = $this->bookandpayagendabooking_model->getbookingagenda($customer->id);

        $this->global['orderRandomKey'] = $orderRandomKey;
        $this->global['bookings'] = $orderData['bookings'];
        $this->global['expTime'] = $orderData['expTime'];
        $this->global['totalAmount'] = $orderData['totalAmount'];
        $this->global['logoUrl'] = $orderData['logoUrl'];
       ;
        
        $this->loadViews("booking_agenda/shop", $this->global, $data, 'footerBooking', 'headerBooking');

    }

    public function spots($eventDate = false, $eventId = false)
    {
        if(!$this->input->post('isAjax')){ 
            redirect(base_url());
            return; 
        }

        $orderRandomKey = $this->input->post('order') ? $this->input->post('order') : false;

        $orderData = [];

        if($orderRandomKey){
            $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();
        } else {
            return ;
        }

        $customer = $orderData['customer'];

        if (empty($customer) || !isset($customer['id'])) {
            redirect();
        }

        if (empty($eventDate) || empty($eventId)) {
            redirect('booking_reservations/' . $customer['usershorturl']);
        }


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

        $data['checkout_reservations'] = $orderData['bookings'];

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

        $bookings = $orderData['bookings'];
        $customer = $orderData['customer'];
        $first_booking = false;
        
        if(count($bookings) < 1){
            $first_booking = true;
        }
        
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

        $current_time = date($booking['time']);
        $newTime = date("Y-m-d H:i:s",strtotime("$current_time +10 minutes"));
        $orderData['expTime'] = $newTime;
        $amount = (floatval($booking['price']) + floatval($booking['reservationFee']))*floatval($booking['quantity']);
        
        $agenda = $this->bookandpayagendabooking_model->getAgendaById($booking['agendaId']);
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
        
        $total = number_format($total, 2, '.', '');
        $orderData['totalAmount'] = $total; 
        $orderData['bookings'] = $bookings; 

        $this
        ->shopsession_model
        ->setIdFromRandomKey($orderRandomKey)
        ->setProperty('orderData', Jwt_helper::encode($orderData))
        ->update();
        
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
        
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : '';
        
        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();;

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
            $this->session->set_flashdata('expired', 'Session Expired!');
            redirect('/booking_reservations/'. $shortUrl);
        }

        return ;
        
        
        
    }

    public function delete_reservation()
    {
        $orderRandomKey = $this->input->post('order') ? $this->input->post('order') : false;

        if(!$orderRandomKey){
            return ;
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            return ;
        }

        $bookings = $orderData['bookings'];
        $timeslotId = $this->input->post('id');
    
        unset($bookings[$timeslotId]);

        $items = $this->input->post('list_items');
        $total = $this->input->post('totalBasket');
        $total = number_format($total, 2, '.', '');
        $orderData['totalAmount'] = $total; 
        $orderData['bookings'] = $bookings;

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
        $orderRandomKey = $this->input->post('orderRandomKey') ? $this->input->post('orderRandomKey') : false;

        if(!$orderRandomKey){
            redirect(base_url());
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }

        $amount = 0;
        $buyerInfo = $this->input->post(null, true);
        $bookings = $orderData['bookings'];

        $reservationIds = $this->bookandpay_model->save_reservations($buyerInfo, $bookings);

        $orderData['reservations'] = $reservationIds;

        
        if ($buyerInfo) {
            $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);

            foreach ($reservations as $key => $reservation) {
                $amount += floatval($reservation->price) + floatval($reservation->reservationFee);

                if ($reservation->SpotId != 3) {
                    $this->bookandpay_model->newvoucher($reservation->reservationId);
                }

               
            }

            $orderData['amount'] = number_format($amount, 2, '.', '');

        } else {
            redirect(base_url());
        }

        $this
                ->shopsession_model
                ->setIdFromRandomKey($orderRandomKey)
                ->setProperty('orderData', Jwt_helper::encode($orderData))
                ->update();

        
        redirect('/booking_reservations/select_payment_type?order=' . $orderRandomKey);
        
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
            $total_amount = floatval($amount)*floatval($reservationsPayment['percent']) + floatval($reservationsPayment['amount']);
            if((isset($vendorCost[$key]) && $vendorCost[$key] == 1) || $total_amount  == 0){
                $data[$paymentMethod] = '&nbsp';
            } else {
                $data[$paymentMethod] = '€'. number_format($total_amount, 2, '.', '');
            }
        }
        
        $this->global['amount'] = $orderData['amount'];
        $this->global['orderRandomKey'] = $orderRandomKey;

        $this->loadViews("bookings/select_payment_type", $this->global, $data, 'footerPayment', "headerPayment");
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