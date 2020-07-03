<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';
    
    class Publicorders extends BaseControllerWeb
    {
        public function __construct()
        {
            parent::__construct();

            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->helper('validate_data_helper');
            $this->load->helper('utility_helper');
            $this->load->helper('country_helper');
            

            $this->load->model('user_subscription_model');
            $this->load->model('shopcategory_model');
            $this->load->model('shopproduct_model');
            $this->load->model('shopproductex_model');
            $this->load->model('shoporder_model');
            $this->load->model('shoporderex_model');
            $this->load->model('user_model');
            $this->load->model('shopspot_model');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->config('custom');
        }

        public function index(): void
        {
            if(!isset($_GET['vendorid'])) {
                redirect(base_url());
            }

            // SAVE VENODR DATA IN SESSION
            $_SESSION['vendor'] = $this->user_model->getUserInfo($_GET['vendorid']);
            if (!$_SESSION['vendor']) {
                redirect(base_url());
            }

            if (isset($_GET['spotid']) && is_numeric($_GET['spotid'])) {

                $this->loadSpotView();
                return;
            }

            if (isset($_GET['vendorid']) && is_numeric($_GET['vendorid'])) {
                $this->loadVendorView();
                return;
            }            
        }

        private function loadSpotView(): void
        {
            $this->global['pageTitle'] = 'TIQS : ORDERING';
            $spotId = intval($_GET['spotid']);
            $userId = intval($_SESSION['vendor']->userId);

            $data = [
                'categoryProducts' => $this->shopproductex_model->getUserLastProductsDetailsPublic($spotId, $userId, 'category'),
                'spotId' => $spotId,
            ];

            if (isset($_SESSION['order'])) {
                $data['ordered'] = $_SESSION['order'];
            }

            $this->loadViews('publicorders/makeOrder', $this->global, $data, null, 'headerWarehousePublic');
            return;
        }

        private function loadVendorView(): void
        {
            $this->global['pageTitle'] = 'TIQS : SELECT SPOT';
            $userId = intval($_SESSION['vendor']->userId);

            $data = [
                'vendor' => $_SESSION['vendor'],
                'spots' => $this->shopspot_model->fetchUserSpots($userId)
            ];

            $this->loadViews('publicorders/selectSpot', $this->global, $data, null, 'headerWarehousePublic');
            return;
        }

        public function checkout_order(): void
        {
            $this->global['pageTitle'] = 'TIQS : CHECKOUT';
            if (empty($_POST) && (!isset($_SESSION['order']) || !$_SESSION['vendor'])) {
                redirect(base_url());
            }

            $post = $this->input->post(null, true);

            if (!empty($post)) {
                $_SESSION['spotId'] = $post['spotId'];
                unset($post['spotId']);
                $_SESSION['order'] = $post;
            }

            $data = [
                'spotId' => $_SESSION['spotId'],
                'userId' => intval($_SESSION['vendor']->userId),
                'orderDetails' => $_SESSION['order'],
                'buyerRole' => $this->config->item('buyer'),
                'usershorturl' => 'tiqs_shop_service',
                'salesagent' => $this->config->item('tiqsId'),
                'countries' => Country_helper::getCountries()
            ];

            $data['username'] = isset($_SESSION['postOrder']['user']['username']) ? $_SESSION['postOrder']['user']['username'] : '';
            $data['email'] = isset($_SESSION['postOrder']['user']['email']) ? $_SESSION['postOrder']['user']['email'] : '';
            $data['userCountry'] = isset($_SESSION['postOrder']['user']['country']) ? $_SESSION['postOrder']['user']['country'] : '';
            $data['mobile'] = isset($_SESSION['postOrder']['user']['mobile']) ? $_SESSION['postOrder']['user']['mobile'] : '';        

            $this->loadViews('publicorders/checkoutOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function submitOrder(): void
        {
            if (empty($_POST) || !isset($_SESSION['order']) || !$_SESSION['vendor']) {
                redirect(base_url());
            }
            $_SESSION['postOrder'] = $this->input->post(null, true);
            

            redirect('pay_order');
        }

        public function pay_order(): void
        {
            if (!isset($_SESSION['order']) || !$_SESSION['vendor'] || !$_SESSION['postOrder']) {
                redirect(base_url());
            }

            $this->global['pageTitle'] = 'TIQS : PAY';

            $data = [
                'ordered' => $_SESSION['order'],
                'vendor' => $_SESSION['vendor']
            ];

            $this->loadViews('publicorders/payOrder', $this->global, $data, null, 'headerWarehousePublic');
        }

        public function paymentEngine(): void
        {
			$post =  $_SESSION['postOrder'];
//            $post =  Utility_helper::getSessionValue('postOrder');
            $this->user_model->manageAndSetBuyer($post['user']);

            if (!$this->user_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Email, name and mobile are mandatory fields. Please try again');
                redirect('checkout_order');
                exit();
            }

            $failedRedirect = 'make_order?vendorid=' . $_SESSION['vendor']->userId . '&spotid=' . $_SESSION['spotId'];

            // insert order
            $post['order']['buyerId'] = $this->user_model->id;
            $post['order']['paid'] = '0';

            $this->shoporder_model->setObjectFromArray($post['order'])->create();            
            
            if (!$this->shoporder_model->id) {
                $this->session->set_flashdata('error', 'Order not made! Please try again');
                redirect($failedRedirect);
                exit();
            }

            // insert order details
            foreach ($post['orderExtended'] as $id => $details) {
                $details['productsExtendedId'] = intval($id);
                $details['orderId'] = $this->shoporder_model->id;
                if (!$this->shoporderex_model->setObjectFromArray($details)->create()) {
                    $this->shoporderex_model->orderId = $details['orderId'];
                    $this->shoporderex_model->deleteOrderDetails();
                    $this->shoporder_model->delete();
                    $this->session->set_flashdata('error', 'Order not made! Please try again');
                    redirect($failedRedirect);
                    exit();
                }
            }

            // go to paying if everything OK
            echo '<pre>';

            print_r($_SESSION);

            echo '</pre>';

            echo 'shoporder_model';

			echo '<pre>';

			print_r($this->shoporder_model->setObjectId( $this->shoporder_model->id)->fetchOne());

			echo '</pre>';
//
//            // TIQS TO DO !!!!!!!!! UNSET SESSION !!!!!!!!!!!!!!!!!!!!!
//            die();

			die();
			$payData['format'] = 'json';
			$payData['tokenid'] = 'AT-0051-0895';
			$payData['token'] = '35c1bce89516c74ce7f8475d66c31dd59937d72a';
			$payData['gateway'] = 'rest-api.pay.nl';
			$payData['namespace'] = 'Transaction';
			$payData['function'] = 'start';
			$payData['version'] = 'v13';

			$strUrl = 'http://' . $payData['tokenid'] . ':' . $payData['token'] . '@' . $payData['gateway'] . '/' . $payData['version'] . '/' . $payData['namespace'] . '/' .
				$payData['function'] . '/' . $payData['format'] . '?';

			$arrArguments = array();
			$_SESSION['order_id'] = $this->orderId;
			$_SESSION['final_amountc'] = $_POST['final_amount'];
			$_SESSION['final_amountfee'] = round($_SESSION['final_amountc'] * 4.5);
			if ($_SESSION['final_amountfee'] >= 350) {
				$_SESSION['final_amountfee'] = 350;
			}
			$_SESSION['final_amountt'] = $_SESSION['final_amountc'] * 100 + $_SESSION['final_amountfee'];
			$_SESSION['final_amountex'] = $_SESSION['final_amountc'] * 100;
			$amountrounded = round($_SESSION['final_amountt'], 0);

			$arrArguments['finishUrl'] = 'https://tiqs.com/shop/checkout/successpay';
			$orderExchangeUrl = 'https://tiqs.com/shop/checkout/ExchangePay';
			$arrArguments['statsData']['promotorId'] = $_SESSION['vendor'];
			$arrArguments['statsData']['extra1'] = $this->orderId;;
			$arrArguments['statsData']['extra2'] = $_SESSION['spot_id'];
			$arrArguments['enduser']['emailAddress'] = $_POST['email'];
//			$arrArguments['enduser']['company']['name'] = 'TIQS';
			$arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
			$arrArguments['saleData']['deliveryDate'] = date('d-m-Y');
			$arrArguments['saleData']['orderData'][0]['productId'] = $this->orderId;
			$arrArguments['saleData']['orderData'][0]['description'] = 'Order from : ' . $_SESSION['vendor_id'] . ' Spot : ' . $_SESSION['spot_id'];
			$arrArguments['transaction']['description'] = "tiqs - ".$this->orderId;
			$arrArguments['saleData']['orderData'][0]['productType'] = 'HANDLING';
			$arrArguments['saleData']['orderData'][0]['price'] = $amountrounded;
			$arrArguments['saleData']['orderData'][0]['quantity'] = 1;
			$arrArguments['saleData']['orderData'][0]['vatCode'] = 'N';
			$arrArguments['saleData']['orderData'][0]['vatPercentage'] = '0,00';
			$arrArguments['enduser']['language'] = 'NL';
			$arrArguments['transaction']['orderExchangeUrl'] = $orderExchangeUrl;

			$data['finalbedrag'] = $_SESSION['final_amountt'];
			$_SESSION['strUrl'] = $strUrl;

			$_SESSION['arrArguments'] = $arrArguments;

			redirect('/publicorders/selectpaymenttype');

			}


		public function selectPaymenttype()
		{
			$data = array();
			$head = array();
			$head['title'] = 'BETALEN';
			//$data['paypal_email'] = $this->Home_admin_model->getValueStore('paypal_email');
			//$data['bestSellers'] = $this->Public_model->getbestSellers();
			$data['finalbedrag']= $_SESSION['final_amount']  ;
			$data['finalbedragfee']= $_SESSION['final_amountfee']  ;
			$data['finalbedragexfee']= $_SESSION['final_amountex']  ;
			$this->loadViews("selectpaymenttype", $this->global, $data, 'nofooter', "noheader");
		}

		public function selectediDealPaymenttype($num)
		{
			$strUrl = $this->session->userdata('strUrl');
			$arrArguments = $this->session->userdata('arrArguments');

			$arrArguments['paymentOptionId'] = '10';
			$arrArguments['paymentOptionSubId'] = $num;

			# Prepare complete API URL
			$strUrl = $strUrl.http_build_query($arrArguments);
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
			}
			else
			{
				$this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
				$data = array();
				$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
				$this->loadViews("thuishavenerror", $this->global, $data,  NULL, "noheader");

			}

		}

		public function selectedCCPaymenttype()
		{
			$strUrl = $this->session->userdata('strUrl');
			$arrArguments = $this->session->userdata('arrArguments');

			$arrArguments['paymentOptionId'] = '706';
//		$arrArguments['paymentOptionSubId'] = $num;

			# Prepare complete API URL
			$strUrl = $strUrl.http_build_query($arrArguments);
			$this->processPaymenttype($strUrl);

//		$cardholder = $_POST['cardholder'];
			// cardholder
			//cardnumber
			//cc-exp
			//cardcvc
		}

		public function successPaymentPay($reservationId) {

			$statuscode = intval($this->input->get('orderStatusId'));
			$orderId = $this->input->get('orderId');
//		$data['paid'] = '9';
//		$data['TransactionID'] = $orderId;
//		// je kan hier niets doen, want je hebt de laatste status niet, al hoewel.....
//		$result = $this->bookandpay_model->editbookandpay($data, $reservationId);
//		$result = $this->bookandpay_model->getReservationId($reservationId);

			if ($statuscode == 100) {

//			$result = $this->bookandpay_model->getReservationId($reservationId);
//			if(empty($result)){
//				// we are fucked.
//				redirect('thuishaven');
//			}
//
//			$data['paid'] = '1';
//			$data['TransactionID'] = $orderId;
//
//			$result = $this->bookandpay_model->editbookandpay($data, $reservationId);
//			$result = $this->bookandpay_model->getReservationId($reservationId);
//			if($result->SpotId!=3) {
//				$this->bookandpay_model->newvoucher($reservationId);
//			}
//			$result = $this->bookandpay_model->getReservationId($reservationId);
//			$qrtext = $result->reservationId;
//
//			switch (strtolower($_SERVER['HTTP_HOST'])) {
//				case 'tiqs.com':
//					$file = '/home/tiqs/domains/tiqs.com/public_html/spot/uploads/thuishaven/qrcodes/' ;
//					break;
//				case '127.0.0.1':
//					$file = '/Users/peterroos/www/spot/uploads/thuishaven/qrcodes/';
//					break;
//				default:
//					break;
//			}
//
//			$SERVERFILEPATH = $file;
//			$text = $qrtext;
//			$folder = $SERVERFILEPATH;
//			$file_name1 = $qrtext . ".png";
//			$file_name = $folder.$file_name1;
//
//			QRcode::png($text,$file_name);
//			switch (strtolower($_SERVER['HTTP_HOST'])) {
//				case 'tiqs.com':
//					$SERVERFILEPATH = 'https://tiqs.com/spot/uploads/thuishaven/qrcodes/';
//					break;
//				case '127.0.0.1':
//					$SERVERFILEPATH = 'http://127.0.0.1/spot/uploads/thuishaven/qrcodes/';
//					break;
//				default:
//					break;
//			}
//
//			$qrlink = $SERVERFILEPATH.$file_name1;
//			$email = $result->email;
//			$name= $result->name;
//			$qrcode= $result->reservationId;
//			$voucher = $result->voucher;
//			$mobile = $result->mobilephone;
//			$fromtime = $result->timefrom;
//			$totime = $result->timeto;
//			$spotlabel = $result->Spotlabel;
//			$numberofperons = $result->numberofpersons;
//			$eventdate = $result->eventdate;
//
//			$config = [
//				'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
//				'api_key'   => 'TtlB6UhkbYarYr4PwlR1' // Your API key. Available in Sendy Settings.
//			];
//
//			$config['list_id'] ='EdH9trleYtp0JHdiS763X892AQ';
//
//			$this->sendyunsubscribe($email);
//
//			$sendy = new \SendyPHP\SendyPHP($config);
//			$responseArray = $sendy->subscribe(
//				array(
//					'name' => $name,
//					'email' => $email,
//					'Qrcodeurl' => $qrlink,
//					'Voucher' => $voucher,
//					'Mobile' => $mobile,
//					'Fromtime' => $fromtime,
//					'Totime' => $totime,
//					'Spotlabel'	=> $spotlabel,
//					'Maxpersons' => $numberofperons,
//					'Eventdate' => $eventdate
//				));

				$data = array();
				$this->global['pageTitle'] = 'TIQS : THANKS';
				$this->loadViews("successpayment", $this->global, $data, 'nofooter', "noheader");

			} elseif ($statuscode <0) {
				$data = array();
				$this->global['pageTitle'] = 'TIQS : THANKS';
				$this->loadViews("errorpayment", $this->global, $data, 'nofooter', "noheader");
			} elseif ($statuscode >= 0) {
				$data = array();
				$this->global['pageTitle'] = 'TIQS : THANKS';
				$this->loadViews("errorpayment", $this->global, $data, 'nofooter', "noheader");
			} else {
				$data = array();
				$this->global['pageTitle'] = 'TIQS : THANKS';
				$this->loadViews("thuishavenerror", $this->global, $data, 'nofooter', "noheader");
			}

		}



    }

