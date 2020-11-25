<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/BaseControllerWeb.php';

class Booking_agenda extends BaseControllerWeb
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

        $data['agenda'] = $this->bookandpayagendabooking_model->getbookingagenda($customer->id);

        $logoUrl = 'assets/user_images/no_logo.png';
        if ($customer->logo) {
			$logoUrl = 'assets/images/vendorLogos/' . $customer->logo;
        }

        $data['logoUrl'] = $logoUrl;
        $data['pageTitle'] = 'TIQS: Thuishaven';
        $data['shortUrl'] = $shortUrl;
        $this->loadViews('bookings/index', $data, '', 'bookingfooter', 'bookingheader');
        

        
    }

    public function spots($eventDate = false, $eventId = false)
    {
        $customer = $this->session->userdata('customer');

        if (empty($customer) || !isset($customer['id'])) {
            redirect();
        }

        if (empty($eventDate) || empty($eventId)) {
            redirect('booking_agenda/' . $customer['usershorturl']);
        }

        $this->session->set_userdata('eventDate', $eventDate);
        $this->session->set_userdata('eventId', $eventId);
        $this->session->set_userdata('spot', $eventId);

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
        $this->loadViews("bookings/spots_booking", $this->global, $data, 'bookingfooter', 'bookingheader');    
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
            $selectedTimeSlot = $this->bookandpaytimeslots_model->getTimeSlot($this->input->post('selected_time_slot_id'));
            $newBooking = [
                'customer' => $customer['id'],
                'eventid' => $eventId,
                'eventdate' => date("yy-m-d", strtotime($eventDate)),
                'SpotId' => $spot->id,
                'Spotlabel' => $spotLabel,
                'timefrom' => $selectedTimeSlot->fromtime,
                'timeto' => $selectedTimeSlot->totime,
                'timeslot' => $selectedTimeSlot->id,
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
                redirect('booking_agenda/pay');
            }

            if(AVAILABLE_TO_BOOK_EXTRA_TIME == true && HOW_MANY_SLOTS_CAN_BE_BOOKED > 1){
                redirect('booking_agenda/reserved');
            } else {
                redirect('booking_agenda/pay');
            }

            
        }

        $data['count'] = $resultcount;
        $data['spot'] = $spot;
        $data['timeSlots'] = $timeSlots;
        $data['eventDate'] = $eventDate;
        
        $this->global['pageTitle'] = 'TIQS : BOOKINGS';

        $this->loadViews("bookings/timeslot_booking", $this->global, $data, 'bookingfooter', 'bookingheader');
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
            redirect('booking_agenda/' . $customer['usershorturl']);
        }

        $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
        if (!$reservations) {
            redirect('booking_agenda/' . $customer['usershorturl']);
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

        $this->loadViews("bookings/next_time_slot", $this->global, $data, 'bookingfooter', 'bookingheader'); // payment screen
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
            $data['mobilephone'] = strtolower($this->input->post('mobile'));
            $data['email'] = strtolower($this->input->post('email'));
            $data['name'] = strtolower($this->input->post('username'));

            $this->session->set_userdata('buyer_info', $data);

            redirect('booking_agenda/payment_proceed');
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
        $data['termsofuse'] = $this->bookandpayagendabooking_model->getTermsofuse();
        $this->loadViews("bookings/final", $this->global, $data, 'bookingfooter', 'bookingheader'); // payment screen
    }

    public function payment_proceed()
    {
        $totalPrice = 0;
        $buyerInfo = $this->session->userdata('buyer_info');
        $reservationIds = $this->session->userdata('reservations');
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
                    'mobilephone' => $buyerInfo['mobilephone'],
                    'email' => $buyerInfo['email'],
                    'name' => $buyerInfo['name'],
                ], $reservation->reservationId);
            }
        } else {
            redirect('booking_agenda/pay');
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
            redirect('/booking_agenda/select_payment_type');
        }
        
    }

    public function select_payment_type()
    {
        $this->load->helper('money');
        $data = array();
        $head = array();

        $head['title'] = 'Payment Method';
        $this->global['pageTitle'] = 'Payment Method';

        $paymentData = $this->session->userdata('payment_data');

        $data['voucheramount'] = $paymentData['discountAmount'];
        $data['finalbedrag'] = $paymentData['final_amount'];
        $data['finalbedragfee'] = $paymentData['final_amountfee'];
        $data['finalbedragexfee'] = $paymentData['final_amountex'];

        $this->loadViews("bookings/select_payment_type", $this->global, $data, 'bookingfooter', "bookingheader");
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

        redirect('booking_agenda/reserved');
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

    public function emailReservation($email,$reservationIds)
	{
        $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
        $eventdate = '';
        foreach ($reservations as $key => $reservation) {
            $eventdate = $reservation->eventdate;
            
            
        }
        $data['paid'] = '1';
        $this->bookandpay_model->editbookandpay($data, $reservationIds[0]);
        $result = $this->sendreservation_model->getReservationByMailandEventDate($email, $eventdate);
        //var_dump($email);

        $TransactionId='empty';

			foreach ($result as $record) {
				$customer = $record->customer;
				$eventid = $record->eventid;
				$eventdate = $record->eventdate;
				$reservationId = $record->reservationId;
				$spotId = $record->SpotId;
				$price = $record->price;
				$Spotlabel = $record->Spotlabel;
				$numberofpersons = $record->numberofpersons;
				$name = $record->name;
				$email = $record->email;
				$mobile = $record->mobilephone;
				$reservationset = $record->reservationset;
				$fromtime = $record->timefrom;
				$totime = $record->timeto;
				$paid = $record->paid;
				$timeSlotId = $record->timeslot;
				$TransactionId = $record->TransactionID;
				$voucher = $record->voucher;

				if ($timeSlotId != 0) {
					if ($paid == 1) {


						$qrtext = $reservationId;

						switch (strtolower($_SERVER['HTTP_HOST'])) {
							case 'tiqs.com':
								$file = '/home/tiqs/domains/tiqs.com/public_html/alfred/uploads/qrcodes/';
								break;
							case '127.0.0.1':
								$file = 'C:/wamp64/www/tiqs/booking2020/uploads/qrcodes/';
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
								$SERVERFILEPATH = 'http://127.0.0.1/spot/uploads/thuishaven/qrcodes/';
								break;
							default:
								break;
						}


//                        $file_name = $file . '/' . $reservationId . ".png";
//                        $webUrl = site_url($webUrl . '/' . $reservationId . ".png");
//
//                        QRcode::png($reservationId, $file_name);

						$timeSlot = $this->bookandpaytimeslots_model->getTimeSlot($timeSlotId);
						$spot = $this->bookandpayspot_model->getSpot($spotId);
						$agenda = $this->bookandpayagendabooking_model->getBookingAgendaById($spot->agenda_id);

						$emailId = $agenda->email_id;

//                        var_dump($emailId);
						switch (strtolower($_SERVER['HTTP_HOST'])) {
							case 'tiqs.com':
								$SERVERFILEPATH = 'https://tiqs.com/alfred/uploads/qrcodes/';
								break;
							case '127.0.0.1':
								$SERVERFILEPATH = 'http://127.0.0.1/spot/uploads/thuishaven/qrcodes/';
								break;
							default:
								break;
                        }
                        
						if($emailId) {
							var_dump($emailId);
//                            $emailTemplate = $this->email_templates_model->get_emails_by_id($emailId->email_id);
                            $emailTemplate = $this->email_templates_model->get_emails_by_id($emailId);
                            
							$qrlink = $SERVERFILEPATH . $file_name1;

							if($emailTemplate) {
								$mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$customer.'/'.$emailTemplate->template_file);
								$mailtemplate = str_replace('[customer]', $customer, $mailtemplate);
								$mailtemplate = str_replace('[eventdate]', date('d.m.yy', strtotime($eventdate)), $mailtemplate);
								$mailtemplate = str_replace('[reservationId]', $reservationId, $mailtemplate);
								$mailtemplate = str_replace('[SpotId]', $spotId, $mailtemplate);
								$mailtemplate = str_replace('[price]', $price, $mailtemplate);
								$mailtemplate = str_replace('[spotlabel]', $Spotlabel, $mailtemplate);
								$mailtemplate = str_replace('[numberofpersons]', $numberofpersons, $mailtemplate);
								$mailtemplate = str_replace('[name]', $name, $mailtemplate);
								$mailtemplate = str_replace('[email]', $email, $mailtemplate);
								$mailtemplate = str_replace('[mobile]', $mobile, $mailtemplate);
								$mailtemplate = str_replace('[fromtime]', $fromtime, $mailtemplate);
								$mailtemplate = str_replace('[totime]', $totime, $mailtemplate);
								$mailtemplate = str_replace('[timeslot]', $timeSlotId, $mailtemplate);
								$mailtemplate = str_replace('[TransactionId]', $TransactionId, $mailtemplate);
								$mailtemplate = str_replace('[voucher]', $voucher, $mailtemplate);
//                                $mailtemplate = str_replace('[QRlink]', "<img src='$webUrl'>", $mailtemplate);
//								$mailtemplate = str_replace('[QRlink]', $webUrl, $mailtemplate);
//                                $subject = 'Your tiqs reservation(s)';
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
								$mailtemplate = str_replace('Image', '', $mailtemplate);
								$mailtemplate = str_replace('Text', '', $mailtemplate);
								$subject = 'Your tiqs reservation(s)';
//                                include(APPPATH . 'libraries/simple_html_dom.php');
//
//                                $html = str_get_html($mailtemplate);
//
//                                foreach($html->find('img.qr-code-image') as $e) {
//                                    $e->src = $webUrl;
//                                }

								$datachange['mailsend'] = 1;
								$this->sendEmail("pnroos@icloud.com", $subject, $mailtemplate);
								if($this->sendEmail($email, $subject, $mailtemplate)) {
                                    $this->sendreservation_model->editbookandpaymailsend($datachange, $reservationId);
                                    redirect('booking/successbooking');
                                }
                               
                                
							}
						}
					}
				}
            }
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
