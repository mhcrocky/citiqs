<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/SendyPHP.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/vendor/autoload.php';

class Bookingpay extends BaseControllerWeb
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->helper('utility_helper');
        $this->load->helper('email_helper');
        $this->load->helper('jwt_helper');
        $this->load->helper('pay_helper');
        $this->load->helper('reservationsemail_helper');
        
        $this->load->model('log_model');
        $this->load->model('bookandpay_model');
        $this->load->model('bookandpaytimeslots_model');
        $this->load->model('bookandpayspot_model');
        $this->load->model('bookandpayagenda_model');
        $this->load->model('sendreservation_model');
        $this->load->model('email_templates_model');
        $this->load->model('shopvendor_model');
        $this->load->model('shopsession_model');
        $this->load->model('shopvoucher_model');

        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('form_validation');
    }

    public function index()
    {

        if (isset($_SESSION["reservation_data"])) {
            $data = $_SESSION["reservation_data"];
        } else {
            // var_dump();

            redirect('thuishaven');
        }

        $result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);
        if (empty($result)) {
            // var_dump();
            redirect('thuishaven');
        }
        // time set in db
        $result = $this->bookandpay_model->editbookandpay($data, $_SESSION['ReservationId']);
        $result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);

        $_SESSION['ReservationId'] = $result->reservationId;
        $this->global['pageTitle'] = 'TIQS : BOOKING';
//		var_dump($_SESSION['ReservationId']);
//		var_dump($_SESSION['ReservationId2']);
//
//		die();
        $this->loadViews("booking", $this->global, $data, 'bookingfooter', "bookingheader");

    }


    public function bookingpay()
    {

        // checken we hier nog de betaling een keer op uitverkocht?
        //				var_dump($_SESSION['ReservationId']);
        //				var_dump($_SESSION['ReservationId2']);
        //				var_dump($_SESSION['ReservationId']);
        //				var_dump($_SESSION['ReservationId2']);
        //				var_dump($_SESSION['reservation_data']);
        //				var_dump($_SESSION['reservation_data2']);
        //
        //				die();


        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Full Name', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');

        $databooking['mobilephone'] = strtolower($this->security->xss_clean($this->input->post('mobile')));
        $databooking['email'] = strtolower($this->security->xss_clean($this->input->post('email')));
        $databooking['name'] = strtolower($this->security->xss_clean($this->input->post('username')));

        $price = 0;

        if ($this->session->userdata('reservation_data')) {
            $data = $this->session->userdata('reservation_data');
            $data1 = $this->session->userdata('reservation_data');
            $price = strval(floatval($data1['price']));
            //			var_dump($data1);

            $result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);
            if ($result->SpotId != 3) {
                $this->bookandpay_model->newvoucher($_SESSION['ReservationId']);
            }

            $result = $this->bookandpay_model->editbookandpay($databooking, $_SESSION['ReservationId']);
            $result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);
            $qrtext = $result->reservationId;

            if (empty($result)) {
                // someting went wrong.
                var_dump($databooking);
                Die();
            }

            ////		var_dump($databooking);
            ////		Die();

        } else {
            //			var_dump();
            redirect('thuishaven');
        }

        if (isset($_SESSION["reservation_data2"])) {
            $data = $_SESSION["reservation_data2"];
            $data2 = $_SESSION["reservation_data2"];
            var_dump($data2);
            if (!empty($data2['price'])) {
                $price2 = strval(floatval($data2['price']));
                $price = $price + $price2;
            }
            $arrArguments['statsData']['extra2'] = $_SESSION['ReservationId2'];
            //			var_dump($price);
            //			var_dump($_SESSION["reservation_data"]);
            $result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId2']);
            if ($result->SpotId != 3) {
                $this->bookandpay_model->newvoucher($_SESSION['ReservationId2']);
            }
            $result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId2']);
            $qrtext = $result->reservationId;

            //		$reservationId = $_SESSION['ReservationId'];
            $result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId2']);

            if (empty($result)) {
                // someting went wrong.
            }

            ////		var_dump($databooking);
            ////		Die();
            $result = $this->bookandpay_model->editbookandpay($databooking, $_SESSION['ReservationId2']);
        } else {
            // var_dump($_SESSION["reservation_data"]);
            // geen tweede reservering
        }


        $price = $price * 100;
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


        $_SESSION['final_amount'] = $data['finalbedrag'];
        $_SESSION['final_amountex'] = $data['finalbedragexfee'];
        $_SESSION['final_amountfee'] = $data['finalbedragfee'];


//		var_dump($price);
//		die();

        $ReservationId1 = "";
        if (isset($_SESSION["reservation_data"])) {
            $data1 = $_SESSION["reservation_data"];
            $ReservationId1 = $_SESSION['ReservationId'];;
        } else {
            //			var_dump($_SESSION["reservation_data"]);
        }

        $ReservationId2 = "";
        if (isset($_SESSION["reservation_data2"])) {
            $data2 = $_SESSION["reservation_data2"];
            $ReservationId2 = $_SESSION['ReservationId2'];;
            $timeslot2 = $data2['timeslot'];

        } else {
            //			var_dump($_SESSION["reservation_data"]);
        }


        $result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);
        $data = $result;
        $data1 = $result;

        $result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId2']);
        $data2 = $result;

        if (!empty($data2)) {
            // leeg
            $data2 = array(
                $reservationId = NUll,
                $email = '',
                $name = '',
                $qrcode = '',
                $voucher = '',
                $mobile = '',
                $fromtime = '',
                $totime = '',
                $spotlabel = '',
                $numberofperons = '0',
                $eventdate = NULL,
            );
        }

        $arrArguments = array();
        $customer = $this->session->userdata('customer');
        $SlCode = $this->bookandpay_model->getUserSlCode($customer['id']);
        $arrArguments['serviceId'] = $SlCode;  // TEST PAYNL_SERVICE_ID_CHE/K424; SL-3157-0531(thuishaven) (eigen test SL-2247-8501)
        //$arrArguments['serviceId'] = "SL-3157-0531";  // THUISHAVEN

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

        $arrArguments['finishUrl'] = base_url() . 'booking/successpay/' . $data->reservationId;
        $orderExchangeUrl = base_url() . '/booking/ExchangePay';

        $arrArguments['statsData']['promotorId'] = '0000001';
        $arrArguments['statsData']['extra1'] = $data->reservationId;
        $arrArguments['statsData']['extra2'] = $ReservationId2;
        $arrArguments['enduser']['emailAddress'] = $data->email;
        $arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
        $arrArguments['saleData']['deliveryDate'] = date('d-m-Y');
        $arrArguments['saleData']['orderData'][0]['productId'] = $data->reservationId;
        // $arrArguments['transaction']['description'] = $data->timeslot."U".strtoupper($ReservationId1)."-".$timeslot2." "."U".strtoupper($ReservationId2);
        $arrArguments['transaction']['description'] = "tiqs - " . $data->eventdate . " - " . $data->timeslot;
        $arrArguments['saleData']['orderData'][0]['description'] = $data->Spotlabel;
        $arrArguments['saleData']['orderData'][0]['productType'] = 'HANDLIUNG';
        $arrArguments['saleData']['orderData'][0]['price'] = $data1->price * 100;
        $arrArguments['saleData']['orderData'][0]['quantity'] = 1;
        $arrArguments['saleData']['orderData'][0]['vatCode'] = 'H';
        $arrArguments['saleData']['orderData'][0]['vatPercentage'] = '0.00';
//         Issue met de prijs moeten we bij houden in record verkoop

        if (!empty($data2->reservationId)) {
            $arrArguments['saleData']['orderData'][1]['productId'] = $data2->reservationId;
            $arrArguments['saleData']['orderData'][1]['description'] = $data2->Spotlabel;
            $arrArguments['saleData']['orderData'][1]['productType'] = 'HANDLIUNG';
            $arrArguments['saleData']['orderData'][1]['price'] = $data2->price * 100;
            $arrArguments['saleData']['orderData'][1]['quantity'] = 1;
            $arrArguments['saleData']['orderData'][1]['vatCode'] = 'H';
            $arrArguments['saleData']['orderData'][1]['vatPercentage'] = '0.00';
        }

        $arrArguments['enduser']['language'] = 'NL';
        $arrArguments['transaction']['orderExchangeUrl'] = $orderExchangeUrl;

        $_SESSION['strUrl'] = $strUrl;
        $_SESSION['arrArguments'] = $arrArguments;
        $_SESSION['discountAmount'] = $arrArguments['amount'];

        redirect('/booking/selectpaymenttype');

        # Prepare complete API URL
//        $strUrl = $strUrl . http_build_query($arrArguments);
//        # Get API result
//        $strResult = @file_get_contents($strUrl);
//        $result = json_decode($strResult);
//
//        var_dump($result);
//        die();
//		if (!is_null($result) && $result->request->result == '1') {
//			redirect($result->transaction->paymentURL);
//		} else {
//			$this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
//			$data = array();
//			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
//			$this->loadViews("thuishavenerror", $this->global, $data,  NULL, "bookingheader");
//		}
        return;
    }

    public function selectPaymenttype()
    {
        $this->load->helper('money');
        $data = array();
        $head = array();
        $head['title'] = 'BETALEN';
        //$data['paypal_email'] = $this->Home_admin_model->getValueStore('paypal_email');
        //$data['bestSellers'] = $this->Public_model->getbestSellers();
        $data['voucheramount'] = $_SESSION['discountAmount'];
        $data['finalbedrag'] = $_SESSION['final_amount'];
        $data['finalbedragfee'] = $_SESSION['final_amountfee'];
        $data['finalbedragexfee'] = $_SESSION['final_amountex'];
        $this->loadViews("selectpaymenttype", $this->global, $data, 'bookingfooter', "bookingheader");
//		$this->render('selectpaymenttype', $head, $data);
    }

    public function selectediDealPaymenttype($num)
    {
        $strUrl = $this->session->userdata('strUrl');
        $arrArguments = $this->session->userdata('arrArguments');
        $paymentData = $this->session->userdata('payment_data');
        $customer = $this->session->userdata('customer');
        $customerId = isset($customer['id']) ? $customer['id'] : $customer;
        $SlCode = $this->bookandpay_model->getUserSlCode($customerId);
        //$arrArguments['serviceId'] = $SlCode;
        $paymentData['arrArguments']['serviceId'] = $SlCode; //SL-2247-8501
        $arrArguments = $paymentData['arrArguments'];
        $strUrl = $paymentData['strUrl'];
        
        
        $arrArguments['paymentOptionId'] = '10';
        $arrArguments['paymentOptionSubId'] = $num;

        # Prepare complete API URL
        $strUrl = $strUrl . http_build_query($arrArguments);

        $this->processPaymenttype($strUrl, $reservationIds);

        # Get API result
        /*
        $strResult = @file_get_contents($strUrl);
        $result= json_decode($strResult);
        if ($result->request->result == '1') {
            $this->db->where('order_id', $this->orderId);
            if (!$this->db->update('orders', array(
                'transactionid' => $result->transaction->transactionId,
                'processed' => 0
            ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            redirect($result->transaction->paymentURL);
        }
        else
        {
            redirect(LANG_URL . '/checkout');
        }
        */
    }

    public function onlinepayment($paymentType, $paymentOptionSubId = '0')
    {
        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;
        
        if(!$orderRandomKey){
            redirect(base_url());
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            redirect(base_url());
        }

         

        $paymentType = strval($this->uri->segment('3'));
        $paymentOptionSubId = ($this->uri->segment('4')) ? strval($this->uri->segment('4')) : '0';
        $vendorId = $orderData['customer']['id'];
        $SlCode = $this->bookandpay_model->getUserSlCode($vendorId);
        $reservationIds = $orderData['reservations'];
        $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
        
        $arrArguments = Pay_helper::getReservationsArgumentsArray($vendorId, $reservations, strval($SlCode), $paymentType, $paymentOptionSubId);
        $namespace = $this->config->item('transactionNamespace');
        $function = $this->config->item('orderPayNlFunction');
        $version = $this->config->item('orderPayNlVersion');

        foreach ($reservations as $key => $reservation) {
            $arrArguments['statsData']['extra' . ($key + 1)] = $reservation->reservationId;
            $arrArguments['saleData']['orderData'][$key]['productId'] = $reservation->reservationId;
            $arrArguments['saleData']['orderData'][$key]['description'] = $reservation->Spotlabel;
            $arrArguments['saleData']['orderData'][$key]['productType'] = 'HANDLIUNG';
            $arrArguments['saleData']['orderData'][$key]['price'] = $reservation->price * 100;
            $arrArguments['saleData']['orderData'][$key]['quantity'] = 1;
            $arrArguments['saleData']['orderData'][$key]['vatCode'] = 'H';
            $arrArguments['saleData']['orderData'][$key]['vatPercentage'] = '0.00';

        }

        $strUrl = Pay_helper::getPayNlUrl($namespace,$function,$version,$arrArguments);


        $this->removeOrderIds($orderData, $orderRandomKey);

        $this->processPaymenttype($strUrl, $reservationIds);
        

    }

    private function removeOrderIds(array $orderData, string $orderRandomKey): void
    {
        unset($orderData['reservations']);
        $this
            ->shopsession_model
            ->setProperty('randomKey', $orderRandomKey)
            ->updateSessionData($orderData);

        return;
    }

    private function processPaymenttype($strUrl, $reservationIds)
    {
        # Get API result
        $strResult = @file_get_contents($strUrl);
        $result = json_decode($strResult);
        if ($result->request->result == '1') {
        //			$this->db->where('order_id',  $_SESSION['order_id']);
        //			if (!$this->db->update('orders', array(
        //				'transactionid' => $result->transaction->transactionId,
        //				'processed' => 0
        //			))) {
        //				log_message('error', print_r($this->db->error(), true));
        //			}

            
            $transactionId = $result->transaction->transactionId;
            $this->bookandpay_model->updateTransactionIdByReservations($reservationIds, $transactionId);
            redirect($result->transaction->paymentURL);

        } else {
            $this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
            $data = array();
            $this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
            $this->loadViews("thuishavenerror", $this->global, $data, NULL, "bookingheader");

        }

    }

    public function selectedCCPaymenttype()
    {
        $strUrl = ($this->session->userdata('strUrl')) ? $this->session->userdata('strUrl') : $this->session->userdata('payment_data')['strUrl'];
        $arrArguments = ($this->session->userdata('arrArguments')) ? $this->session->userdata('arrArguments') : $this->session->userdata('payment_data')['arrArguments'];
        $customer = $this->session->userdata('customer');
        $SlCode = $this->bookandpay_model->getUserSlCode($customer['id']);
        $arrArguments['serviceId'] = $SlCode;
        //$strUrl = $this->session->userdata('strUrl')
        //$arrArguments = $this->session->userdata(''arrArguments');

        $arrArguments['paymentOptionId'] = '706' ;
        //		$arrArguments['paymentOptionSubId'] = $num;

        # Prepare complete API URL
        $strUrl = $strUrl . http_build_query($arrArguments);
        //var_dump($arrArguments);
        $this->processPaymenttype($strUrl);

        //		$cardholder = $_POST['cardholder'];
        // cardholder
        //cardnumber
        //cc-exp
        //cardcvc
    }

    public function ExchangePay()
	{

        ////////  

        $get = $this->input->get(null, true);
        $transactionid = $this->input->get('order_id'); 
        $action = $this->input->get('action', true);

        if ($get['action'] === 'new_ppt') {
            // WE HAVE SUCCESS
            // transactionId ID IS UNIQUE SO YOU CAN UPDATE paid STATUS TO 1 tbl_bookandpay
            // 
            //$query = 'UPDATE tbl_bookandpay SET paid = "1" WHERE TransactionID = "' . $this->db->escape($transactionid) . '"';
            //$this->db->query($query);
            $this->exchangeSideJobs($transactionid);
            echo('TRUE| '. $transactionid.'-status-'.$action.'-date-'.date('Y-m-d H:i:s'));
        } else {
			echo('TRUE| NOT FIND '. $transactionid.'-status-'.$action.'-date-'.date('Y-m-d H:i:s'));
        }
    }

    public function successPaymentPay($reservation_id)
    {
        $statuscode = intval($this->input->get('orderStatusId'));

		if ($statuscode == 100) {

			$data = array();
            $this->global['pageTitle'] = 'TIQS : THANKS';
            $this->session->sess_destroy();
			$this->loadViews("bookingsuccess", $this->global, $data, 'bookingfooter', "bookingheader");

		} elseif ($statuscode <0) {
			$data = array();
            $this->global['pageTitle'] = 'TIQS : THANKS';
            $this->session->sess_destroy();
			$this->loadViews("thuishavenerror", $this->global, $data, 'bookingfooter', "bookingheader");
		} elseif ($statuscode >= 0) {
			$data = array();
            $this->global['pageTitle'] = 'TIQS : THANKS';
            $this->session->sess_destroy();
			$this->loadViews("thuishavenerror", $this->global, $data, 'bookingfooter', "bookingheader");
		} else {
			$data = array();
            $this->global['pageTitle'] = 'TIQS : THANKS';
            $this->session->sess_destroy();
			$this->loadViews("thuishavenerror", $this->global, $data, 'bookingfooter', "bookingheader");
		}

	}

    private function sendyunsubscribe($email)
    {
        $config = [
            'installation_url' => 'https://tiqs.com/newsletters',
            'api_key' => 'TtlB6UhkbYarYr4PwlR1',
            'list_id' => 'EdH9trleYtp0JHdiS763X892AQ', // Pay success
        ];

        $sendy = new \SendyPHP\SendyPHP($config);
        $responseArray = $sendy->delete($email);
        $config['list_id'] = 'JNTHyS90CBizZy1B763g4vIA'; // Pay error
        $sendy = new \SendyPHP\SendyPHP($config);
        $responseArray = $sendy->delete($email);

        $config['list_id'] = 'avmOrgRU2Tm5eeaDUaRUzA'; // Pay pending
        $sendy = new \SendyPHP\SendyPHP($config);
        $responseArray = $sendy->delete($email);
    }

    public function pay424item()
    {
        //sanitiaze data
        $data = $this->input->post(null, true);
        $redirect = base_url() . 'pay424' . DIRECTORY_SEPARATOR . $data['subscriptionid'] . DIRECTORY_SEPARATOR . urlencode($data['user']['email']);
        redirect($redirect);
    }

    public function cronDeleteReservations()
    {
        $this->bookandpay_model->cronDeleteReservations();
    }

    public function emailReservation($transactionId)
	{
        
        $reservations = $this->bookandpay_model->getReservationsByTransactionId($transactionId);
        Reservationsemail_helper::sendEmailReservation($reservations, true);

    }



    public function download_email_pdf($emailId,$reservationId)
	{
        
        $reservations = $this->bookandpay_model->getReservationsById($reservationId);
        $eventdate = '';
        foreach ($reservations as $key => $reservation):
            $result = $this->sendreservation_model->getEventReservationData($reservation->reservationId);
            
            foreach ($result as $record) {
                $customer = $record->customer;
				$eventid = $record->eventid;
				$eventdate = $record->eventdate;
				$reservationId = $record->reservationId;
				$spotId = $record->SpotId;
				$price = $record->price;
                $reservationFee = $record->reservationFee;
                $orderAmount = floatval($record->price) + floatval($record->reservationFee);
                $orderAmount = number_format($orderAmount, 2, '.', '');
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
                $evenDescript = $record->ReservationDescription;
                $orderId = $record->orderId;
                
                    if ($paid = 1) {
                        
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
                                $mailtemplate = str_replace('[currentDate]', $name, $mailtemplate);
                                $mailtemplate = str_replace('[orderId]', $orderId, $mailtemplate);
                                $mailtemplate = str_replace('[orderAmount]', $orderAmount, $mailtemplate);
                                $mailtemplate = str_replace('[buyerName]', $name, $mailtemplate);
                                $mailtemplate = str_replace('[buyerEmail]', $email, $mailtemplate);
                                $mailtemplate = str_replace('[buyerMobile]', $mobile, $mailtemplate);
								$mailtemplate = str_replace('[customer]', $customer, $mailtemplate);
								$mailtemplate = str_replace('[eventDate]', date('d.m.Y', strtotime($eventdate)), $mailtemplate);
								$mailtemplate = str_replace('[reservationId]', $reservationId, $mailtemplate);
								$mailtemplate = str_replace('[spotId]', $spotId, $mailtemplate);
								$mailtemplate = str_replace('[price]', $price, $mailtemplate);
                                $mailtemplate = str_replace('[ticketPrice]', $price, $mailtemplate);
								$mailtemplate = str_replace('[spotLabel]', $Spotlabel, $mailtemplate);
                                $mailtemplate = str_replace('[ticketQuantity]', $numberofpersons, $mailtemplate);
								$mailtemplate = str_replace('[numberOfPersons]', $numberofpersons, $mailtemplate);
								$mailtemplate = str_replace('[startTime]', $fromtime, $mailtemplate);
								$mailtemplate = str_replace('[endTime]', $totime, $mailtemplate);
								$mailtemplate = str_replace('[timeSlot]', $timeSlotId, $mailtemplate);
								$mailtemplate = str_replace('[transactionId]', $TransactionId, $mailtemplate);
								$mailtemplate = str_replace('[WalletCode]', $voucher, $mailtemplate);
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
								//Pdf_helper::HtmlToPdf($mailtemplate);
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
            $get = Utility_helper::sanitizeGet();

            if (ENVIRONMENT === 'development') {
                $this->exchangeSideJobs($get['orderId']);
            }
            
            if ($get['orderStatusId'] === $this->config->item('payNlSuccess')) {
                // need to do something with the facebook pixel.
                $redirect = base_url() . 'reservation_success?orderid=' . $get['orderId'];
            } elseif (in_array($get['orderStatusId'], $this->config->item('payNlPending'))) {
                $redirect = base_url() . 'reservation_pending?orderid=' . $get['orderId'];
            } elseif ($get['orderStatusId'] === $this->config->item('payNlAuthorised')) {
                $redirect = base_url() . 'reservation_authorised?orderid=' . $get['orderId'];
            } elseif ($get['orderStatusId'] === $this->config->item('payNlVerify')) {
                $redirect = base_url() . 'reservation_verify?orderid=' . $get['orderId'];
            } elseif ($get['orderStatusId'] === $this->config->item('payNlCancel')) {
                $redirect = base_url() . 'reservation_cancel?orderid=' . $get['orderId'];
            } elseif ($get['orderStatusId'] === $this->config->item('payNlDenied')) {
                $redirect = base_url() . 'reservation_denied?orderid=' . $get['orderId'];
            } elseif ($get['orderStatusId'] === $this->config->item('payNlPinCanceled')) {
                $redirect = base_url() . 'reservation_pin_canceled?orderid=' . $get['orderId'];
            }
            
            redirect($redirect);

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

        $CI->email->send();
        return $CI->email->clear(true);
    }

    public static function getConfig()
    {
        return [
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
        ];
    }

    private function exchangeSideJobs($transactionId): void
    {
        $this->bookandpay_model->updateBookandpayByTransactionId($transactionId);

        $this->shopvoucher_model->createReservationVoucher($this->bookandpay_model, $transactionId);

        $this->emailReservation($transactionId);
        return;
    }

}
