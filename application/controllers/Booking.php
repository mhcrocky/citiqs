<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/SendyPHP.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/vendor/autoload.php';


class Booking extends BaseControllerWeb {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->helper('utility_helper');
        $this->load->helper('email_helper');
        $this->load->model('log_model');
        $this->load->model('bookandpay_model');
        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('form_validation');
    }

    public function index()
	{

		if(isset($_SESSION["reservation_data"])) {
			$data = $_SESSION["reservation_data"];
		} else {
			redirect('thuishaven');
		}

		$result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);
		if(empty($result)){
			redirect('thuishaven');
		}
		// time set in db
		$result = $this->bookandpay_model->editbookandpay($data, $_SESSION['ReservationId']);
		$result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);


		$_SESSION['ReservationId'] = $result->reservationId;
		$this->global['pageTitle'] = 'TIQS : BOOKING';
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

		$result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);
		if($result->SpotId!=3) {
			$this->bookandpay_model->newvoucher($_SESSION['ReservationId']);
		}
		$result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);
		$qrtext = $result->reservationId;

//		$reservationId = $_SESSION['ReservationId'];
		$result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);

		if(empty($result)){
			// someting went wrong.
		}
////		var_dump($databooking);
////		Die();

		$result = $this->bookandpay_model->editbookandpay($databooking, $_SESSION['ReservationId']);
		$result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);

		$data = $result;
		$arrArguments = array();
//        $arrArguments['serviceId'] = "SL-2247-8501";  // TEST PAYNL_SERVICE_ID_CHE/K424; SL-3157-0531(thuishaven) (eigen test SL-2247-8501)
		$arrArguments['serviceId'] = "SL-3157-0531";  // THUISHAVEN

		$arrArguments['amount'] = strval(floatval($data->price) * 100);
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
        
        $arrArguments['finishUrl'] = base_url() . 'booking/successpay/'.$data->reservationId;
        $orderExchangeUrl =  'https://tiqs.com/spot/booking/ExchangePay';

        $arrArguments['statsData']['promotorId'] = '0000001';
        $arrArguments['statsData']['extra1'] = $data->reservationId;
        // niet $arrArguments['statsData']['extra2'] = $_SESSION['spot_id'];
        $arrArguments['enduser']['emailAddress'] = $data->email;
        // $arrArguments['enduser']['company']['name'] = 'tiqs';
        $arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
        $arrArguments['saleData']['deliveryDate'] = date('d-m-Y');
        $arrArguments['saleData']['orderData'][0]['productId'] = $data->reservationId;
        $arrArguments['transaction']['description'] = $data->Spotlabel." - 01-06 -".$data->timefrom." -".$data->timeto;
        $arrArguments['saleData']['orderData'][0]['description'] = $data->Spotlabel;
        $arrArguments['saleData']['orderData'][0]['productType'] = 'HANDLIUNG';
        $arrArguments['saleData']['orderData'][0]['price'] = strval(floatval($data->price) * 100);
        $arrArguments['saleData']['orderData'][0]['quantity'] = 1;
        $arrArguments['saleData']['orderData'][0]['vatCode'] = 'H';
        $arrArguments['saleData']['orderData'][0]['vatPercentage'] = '0.00';
        $arrArguments['enduser']['language'] = 'NL';
		$arrArguments['transaction']['orderExchangeUrl'] = $orderExchangeUrl;

        # Prepare complete API URL
        $strUrl = $strUrl . http_build_query($arrArguments);
        # Get API result
        $strResult = @file_get_contents($strUrl);
        $result = json_decode($strResult);
//
//        var_dump($result);
//        die();

		if (!is_null($result) && $result->request->result == '1') {
			redirect($result->transaction->paymentURL);
		} else {
			$this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
			$data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("thuishavenerror", $this->global, $data,  NULL, "noheader");
		}
		return;
    }

    public function ExchangePay() {

		$transactionid = $this->input->get('order_id');

		$payData['format'] = 'array_serialize';
		$payData['tokenid'] = 'AT-0051-0895';
		$payData['token'] = '35c1bce89516c74ce7f8475d66c31dd59937d72a';
		$payData['gateway'] = 'rest-api.pay.nl';
		$payData['namespace'] = 'Transaction';
		$payData['function'] = 'info';
		$payData['version'] = 'v16';

		$strUrl = 'http://' . $payData['tokenid'] . ':' . $payData['token']  . '@' . $payData['gateway'] . '/' . $payData['version'] .  '/' . $payData['namespace'] .  '/' .
			$payData['function'] . '/' . $payData['format'] . '?';


		$arrArguments = array();
		$arrArguments['transactionId'] = $transactionid;

		$strUrl = $strUrl.http_build_query($arrArguments);

		$strResult = @file_get_contents($strUrl);


		if(empty($transactionid)){
			echo('FALSE|'.$transactionid);
			die();
		}

		$strResult = unserialize($strResult);

		//		var_dump($strResult);

//		print("<pre>".print_r($strResult,true)."</pre>");

		//

		$result1= array();
		$result1 = $strResult;

		if($result1['paymentDetails']['state'] == 100) {

			$reservationId = $strResult['saleData']['orderData'][0]['productId'];
//			var_dump($reservationId);
			$reservationId = $strResult['statsDetails']['extra1'];
//			var_dump($reservationId);

			if(empty($reservationId)){
				echo('FALSE|'.$reservationId);
				die();
			}

			$result = $this->bookandpay_model->getReservationId($reservationId);

			$data['paid'] = '1';
			$data['TransactionID'] = $transactionid;

			$result = $this->bookandpay_model->editbookandpay($data, $reservationId);

//			var_dump($result);

			$result = $this->bookandpay_model->getReservationId($reservationId);

//			var_dump($result);

//			if ($result->SpotId != 3) {
//				$this->bookandpay_model->newvoucher($reservationId);
//			}

			$result = $this->bookandpay_model->getReservationId($reservationId);
			$qrtext = $result->reservationId;

			switch (strtolower($_SERVER['HTTP_HOST'])) {
				case 'tiqs.com':
					$file = '/home/tiqs/domains/tiqs.com/public_html/spot/uploads/thuishaven/qrcodes/';
					break;
				case '127.0.0.1':
					$file = '/Users/peterroos/www/spot/uploads/thuishaven/qrcodes/';
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
					$SERVERFILEPATH = 'https://tiqs.com/spot/uploads/thuishaven/qrcodes/';
					break;
				case '127.0.0.1':
					$SERVERFILEPATH = 'http://127.0.0.1/spot/uploads/thuishaven/qrcodes/';
					break;
				default:
					break;
			}

			$qrlink = $SERVERFILEPATH . $file_name1;
			$email = $result->email;
			$name = $result->name;
			$qrcode = $result->reservationId;
			$voucher = $result->voucher;
			$mobile = $result->mobilephone;
			$fromtime = $result->timefrom;
			$totime = $result->timeto;
			$spotlabel = $result->Spotlabel;
			$numberofperons = $result->numberofpersons;
			$eventdate = $result->eventdate;

			$config = [
				'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
				'api_key' => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
			];

			$config['list_id'] ='EdH9trleYtp0JHdiS763X892AQ';

			$this->sendyunsubscribe($email);

			$sendy = new \SendyPHP\SendyPHP($config);
			$responseArray = $sendy->subscribe(
				array(
					'name' => $name,
					'email' => $email,
					'Qrcodeurl' => $qrlink,
					'Voucher' => $voucher,
					'Mobile' => $mobile,
					'Fromtime' => $fromtime,
					'Totime' => $totime,
					'Spotlabel' => $spotlabel,
					'Maxpersons' => $numberofperons,
			        'Eventdate' => $eventdate
				));

			echo('TRUE|');
		}

		echo('TRUE|');
    }

    public function successPaymentPay($reservationId) {

		$statuscode = intval($this->input->get('orderStatusId'));
		$orderId = $this->input->get('orderId');

		if ($statuscode == 100) {

			$result = $this->bookandpay_model->getReservationId($reservationId);
			if(empty($result)){
				// we are fucked.
				redirect('thuishaven');
			}

			$data['paid'] = '1';
			$data['TransactionID'] = $orderId;

			$result = $this->bookandpay_model->editbookandpay($data, $reservationId);
			$result = $this->bookandpay_model->getReservationId($reservationId);
			if($result->SpotId!=3) {
				$this->bookandpay_model->newvoucher($reservationId);
			}
			$result = $this->bookandpay_model->getReservationId($reservationId);
			$qrtext = $result->reservationId;

			switch (strtolower($_SERVER['HTTP_HOST'])) {
				case 'tiqs.com':
					$file = '/home/tiqs/domains/tiqs.com/public_html/spot/uploads/thuishaven/qrcodes/' ;
					break;
				case '127.0.0.1':
					$file = '/Users/peterroos/www/spot/uploads/thuishaven/qrcodes/';
					break;
				default:
					break;
			}

			$SERVERFILEPATH = $file;
			$text = $qrtext;
			$folder = $SERVERFILEPATH;
			$file_name1 = $qrtext . ".png";
			$file_name = $folder.$file_name1;

			QRcode::png($text,$file_name);
			switch (strtolower($_SERVER['HTTP_HOST'])) {
				case 'tiqs.com':
					$SERVERFILEPATH = 'https://tiqs.com/spot/uploads/thuishaven/qrcodes/';
					break;
				case '127.0.0.1':
					$SERVERFILEPATH = 'http://127.0.0.1/spot/uploads/thuishaven/qrcodes/';
					break;
				default:
					break;
			}

			$qrlink = $SERVERFILEPATH.$file_name1;
			$email = $result->email;
			$name= $result->name;
			$qrcode= $result->reservationId;
			$voucher = $result->voucher;
			$mobile = $result->mobilephone;
			$fromtime = $result->timefrom;
			$totime = $result->timeto;
			$spotlabel = $result->Spotlabel;
			$numberofperons = $result->numberofpersons;
			$eventdate = $result->eventdate;

			$config = [
				'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
				'api_key'   => 'TtlB6UhkbYarYr4PwlR1' // Your API key. Available in Sendy Settings.
			];

			$config['list_id'] ='EdH9trleYtp0JHdiS763X892AQ';

			$this->sendyunsubscribe($email);

			$sendy = new \SendyPHP\SendyPHP($config);
			$responseArray = $sendy->subscribe(
				array(
					'name' => $name,
					'email' => $email,
					'Qrcodeurl' => $qrlink,
					'Voucher' => $voucher,
					'Mobile' => $mobile,
					'Fromtime' => $fromtime,
					'Totime' => $totime,
					'Spotlabel'	=> $spotlabel,
					'Maxpersons' => $numberofperons,
					'Eventdate' => $eventdate
				));

			$data = array();
			$this->global['pageTitle'] = 'TIQS : THANKS';
			$this->loadViews("thuishavensuccess", $this->global, $data, 'nofooter', "noheader");

		} elseif ($statuscode <0) {
			$data = array();
			$this->global['pageTitle'] = 'TIQS : THANKS';
			$this->loadViews("thuishavenerror", $this->global, $data, 'nofooter', "noheader");
		} elseif ($statuscode >= 0) {
			$data = array();
			$this->global['pageTitle'] = 'TIQS : THANKS';
			$this->loadViews("thuishavenerror", $this->global, $data, 'nofooter', "noheader");
		} else {
			$data = array();
			$this->global['pageTitle'] = 'TIQS : THANKS';
			$this->loadViews("thuishavenerror", $this->global, $data, 'nofooter', "noheader");
		}

	}

    private function sendyunsubscribe($email) {
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
        $redirect = base_url() . 'pay424' . DIRECTORY_SEPARATOR . $data['subscriptionid']  . DIRECTORY_SEPARATOR . urlencode($data['user']['email']);
        redirect($redirect);
    }

    public function cronDeleteReservations()
    {
        $this->bookandpay_model->cronDeleteReservations();
    }
}
