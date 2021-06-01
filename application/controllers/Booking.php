<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/SendyPHP.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/vendor/autoload.php';

class Booking extends BaseControllerWeb
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->load->helper('utility_helper');
		$this->load->helper('email_helper');
		$this->load->model('log_model');
		$this->load->model('bookandpay_model');
		$this->load->model('sendreservation_model');
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->load->library('form_validation');
	}

	public function index()
	{

		if (isset($_SESSION["reservation_data"])) {
			$data = $_SESSION["reservation_data"];
		} else {
			var_dump();

			redirect('thuishaven');
		}

		$result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);
		if (empty($result)) {
			var_dump();
			redirect('');
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
		$this->loadViews("booking", $this->global, $data, 'nofooter', "noheader");

	}


	public function bookingpay()
	{

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
//			$this->loadViews("thuishavenerror", $this->global, $data,  NULL, "noheader");
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
		$this->loadViews("selectpaymenttype", $this->global, $data, 'nofooter', "noheader");
//		$this->render('selectpaymenttype', $head, $data);
	}

	public function selectediDealPaymenttype($num)
	{
		$strUrl = $this->session->userdata('strUrl');
		$arrArguments = $this->session->userdata('arrArguments');
		$paymentData = $this->session->userdata('payment_data');
		$customer = $this->session->userdata('customer');
		$SlCode = $this->bookandpay_model->getUserSlCode($customer['id']);
		//$arrArguments['serviceId'] = $SlCode;
		$paymentData['arrArguments']['serviceId'] = $SlCode; //SL-2247-8501
		$arrArguments = $paymentData['arrArguments'];
		$strUrl = $paymentData['strUrl'];


		$arrArguments['paymentOptionId'] = '10';
		$arrArguments['paymentOptionSubId'] = $num;

		# Prepare complete API URL
		$strUrl = $strUrl . http_build_query($arrArguments);

		$this->processPaymenttype($strUrl);

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

	private function processPaymenttype($strUrl)
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
			redirect($result->transaction->paymentURL);
		} else {
			$this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
			$data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("thuishavenerror", $this->global, $data, NULL, "noheader");

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
		$this->load->model('email_templates_model');
		$this->load->model('bookandpayspot_model');
		$this->load->model('bookandpayagenda_model');
		$this->load->model('bookandpaytimeslots_model');
		$transactionid = ($this->input->get('order_id')) ? $this->input->get('order_id') : $this->input->get('orderId');

		$payData['format'] = 'array_serialize';
		$payData['tokenid'] = 'AT-0051-0895';
		$payData['token'] = '35c1bce89516c74ce7f8475d66c31dd59937d72a';
		$payData['gateway'] = 'rest-api.pay.nl';
		$payData['namespace'] = 'Transaction';
		$payData['function'] = 'info';
		$payData['version'] = 'v16';

		$strUrl = 'http://' . $payData['tokenid'] . ':' . $payData['token'] . '@' . $payData['gateway'] . '/' . $payData['version'] . '/' . $payData['namespace'] . '/' .
			$payData['function'] . '/' . $payData['format'] . '?';

		$arrArguments = array();
		$arrArguments['transactionId'] = $transactionid;

		$strUrl = $strUrl . http_build_query($arrArguments);

		$strResult = @file_get_contents($strUrl);

		if (empty($transactionid)) {
			echo('FALSE|' . $transactionid);
			die();
		}

		$strResult = unserialize($strResult);
		$result1 = $strResult;

//        if ($result1['paymentDetails']['state'] == 100 || $result1['paymentDetails']['state'] == 20) {
		if ($result1['paymentDetails']['state'] == 100) {
			foreach ($strResult['saleData']['orderData'] as $key => $product) {
				if($product['productId'] !== '000000') {
					$reservationId = $product['productId'];

					if (empty($reservationId)) {
						echo('FALSE|' . $reservationId);
						die();
					}

					$data['paid'] = '1';
					$data['TransactionID'] = $transactionid;

					$this->bookandpay_model->editbookandpay($data, $reservationId);
				}
			}
			
			$result = $this->bookandpay_model->getReservationId($strResult['saleData']['orderData'][0]['productId']);

			$customerId = $result->customer;

			/*

			switch (strtolower($_SERVER['HTTP_HOST'])) {
				case 'tiqs.com':
					$file = '/home/tiqs/domains/tiqs.com/public_html/alfred/uploads/qrcodes/'.$customerId;
					$webUrl = 'uploads/qrcodes/'.$customerId;
					break;
				case 'tiqs.lc':
					$file = '/Users/dmitry/websites/tiqs/booking2020/uploads/qrcodes/'.$customerId;
					$webUrl = 'uploads/qrcodes/'.$customerId;
					break;
				case '127.0.0.1':
					$file = '/Users/peterroos/www/spot/uploads/qrcodes/'.$customerId;
					$webUrl = 'uploads/qrcodes/'.$customerId;
					break;
				default:
					break;
			}

			if(!file_exists($file)) {
				mkdir($file, 0777, true);
			}
//			var_dump($result);
//			die();

			$email = $result->email;
			$eventdate = $result->eventdate;
			$result = $this->sendreservation_model->locatereservationbymailsend($email, $eventdate);
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
						$agenda = $this->bookandpayagenda_model->getBookingAgendaById($spot->agenda_id);

//						var_dump($timeSlotId);
//						var_dump($agenda);
//						var_dump($spotId);
//						die();
						$emailId = false;


						if($timeSlot && $timeSlot->email_id != 0) {
							$emailId = $timeSlot->email_id;
						} elseif ($spot && $spot->email_id != 0) {
							$emailId = $spot->email_id;
						} elseif ($agenda && $agenda->email_id != 0) {
							$emailId = $agenda->email_id;
						}

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
								$mailtemplate = str_replace('Title', '', $mailtemplate);
								$mailtemplate = str_replace('QR Code', '', $mailtemplate);
								$mailtemplate = str_replace('Divider', '', $mailtemplate);
                                $mailtemplate = str_replace('Button', '', $mailtemplate);
                                $mailtemplate = str_replace('Social Links', '', $mailtemplate);
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
								}
							}
						}
					}
				}
			}
			
			*/

			$this->emailReservation();
			echo('TRUE|X' . $transactionid);
		} else {

			echo('TRUE|O' . $transactionid);  // payment gaat niet door....
		}
	}

	public function successPaymentPay($reservation_id)
	{
		$statuscode = intval($this->input->get('orderStatusId'));

		if ($statuscode == 100) {

			$data = array();
			if($this->session->userdata('eventShop')){
				redirect('booking_events/emailReservation');
			}
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

	public function successBooking(){
        $data = array();
		$this->global['pageTitle'] = 'TIQS : THANKS';
		$this->session->sess_destroy();
        $this->loadViews("bookingsuccess", $this->global, $data, 'nofooter', "noheader");
    
    }

	public function emailReservation()
	{
        
        $email = $this->session->userdata('buyerEmail');
        $reservationIds = $this->session->userdata('reservations');
        $reservations = $this->bookandpay_model->getReservationsByIds($reservationIds);
        $eventdate = '';
        $i = 0;
        foreach ($reservations as $key => $reservation):
            $eventdate = $reservation->eventdate;
            $data['paid'] = '1';
            $this->bookandpay_model->editbookandpay($data, $reservationIds[$i]);
            $result = $this->sendreservation_model->getEventReservationData($reservation->reservationId, $email, $eventdate);
            
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
                
                
                    if ($paid == 1) {
                        
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

						QRcode::png($text, $file_name);

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

                        $timeSlot = $this->bookandpaytimeslots_model->getTimeSlot($timeSlotId);
                        $spot = $this->bookandpayspot_model->getSpot($spotId);
                        $agenda = $this->bookandpayagenda_model->getBookingAgendaById($spot->agenda_id);

                        $emailId = false;

                        if($timeSlot && $timeSlot->email_id != 0) {
                            $emailId = $timeSlot->email_id;
                        } elseif ($spot && $spot->email_id != 0) {
                            $emailId = $spot->email_id;
                        } elseif ($agenda && $agenda->email_id != 0) {
                            $emailId = $agenda->email_id;
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
                            $this->config->load('custom');
                            $mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$customer.'/'.$emailTemplate->template_file .'.'.$this->config->item('template_extension'));
                            $qrlink = $SERVERFILEPATH . $file_name1;
							if($mailtemplate) {
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
								$mailtemplate = str_replace('[WalletCode]', $voucher, $mailtemplate);
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
								$subject = ($emailTemplate->template_subject) ? $emailTemplate->template_subject : 'Your tiqs reservation(s)';
								$datachange['mailsend'] = 1;
//								$this->sendEmail("pnroos@icloud.com", $subject, $mailtemplate);
								if($this->sendEmail($email, $subject, $mailtemplate)) {
									$file = FCPATH . 'application/tiqs_logs/messages.txt';
									Utility_helper::logMessage($file, $mailtemplate);
                                    $this->sendreservation_model->editbookandpaymailsend($datachange, $reservationId);
                                    
                                }
                            
                        }
                    }
                }
            }
            $i++;
            endforeach;
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



}
