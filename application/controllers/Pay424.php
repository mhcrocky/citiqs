<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/SendyPHP.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/vendor/autoload.php';

class Pay424 extends BaseControllerWeb {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->helper('utility_helper');
        $this->load->helper('email_helper');
        $this->load->model('log_model');
        $this->load->model('subscription_model424');
        $this->load->model('user_subscription_model424');
        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('form_validation');
    }

    //
    // https://tiqs.com/lostandfound//pay/1/pnroos%40icloud.com
    //

    public function index($subscriptionid, $email = "")
    {
        if (empty($subscriptionid)) {
			$data['coffee'] = '1,85';
			$data['coffeeandcroissant'] = '3,60';
			$data['lunch'] = '7,85';
			$data['dinner'] = '14,95';
			$this->global['pageTitle'] = 'TIQS : THANKS';
			$this->loadViews("pay424", $this->global, $data,  NULL, "headercheck424");
            return;
        }

        $subscriptionInfo = $this->subscription_model424->getSubscriptionInfoById($subscriptionid);

        if (empty($subscriptionInfo)) {

			$data['coffee'] = '1,85';
			$data['coffeeandcroissant'] = '3,60';
			$data['lunch'] = '7,85';
			$data['dinner'] = '14,95';
			$this->global['pageTitle'] = 'TIQS : THANKS';
			$this->loadViews("pay424", $this->global, $data,  NULL, "headercheck424");
            return;
        }

        if ($subscriptionInfo->active == 0) {
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror424", $this->global, $data,  NULL, "headercheck424");
            return;
        }

        $arrArguments = array();
        $arrArguments['serviceId'] = PAYNL_SERVICE_ID_CHECK424;
        $arrArguments['amount'] = strval(floatval($subscriptionInfo->amount) * 100);
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
        
        $arrArguments['finishUrl'] = base_url() . 'pay424/successpay';
        $orderExchangeUrl =  base_url() . 'pay424/exchangepay';

        $arrArguments['statsData']['promotorId'] = '0000001';
        // niet $arrArguments['statsData']['extra1'] = $this->orderId;;
        // niet $arrArguments['statsData']['extra2'] = $_SESSION['spot_id'];
        $arrArguments['enduser']['emailAddress'] = $email;
        // $arrArguments['enduser']['company']['name'] = 'tiqs';
        $arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
        $arrArguments['saleData']['deliveryDate'] = date('d-m-Y');
        $arrArguments['saleData']['orderData'][0]['productId'] = $subscriptionid;
        $arrArguments['transaction']['description'] = $subscriptionInfo->description;
        $arrArguments['saleData']['orderData'][0]['description'] = $subscriptionInfo->description;
        $arrArguments['saleData']['orderData'][0]['productType'] = 'HANDLIUNG';
        $arrArguments['saleData']['orderData'][0]['price'] = strval(floatval($subscriptionInfo->amount) * 100);
        $arrArguments['saleData']['orderData'][0]['quantity'] = 1;
        $arrArguments['saleData']['orderData'][0]['vatCode'] = 'H';
        $arrArguments['saleData']['orderData'][0]['vatPercentage'] = '21.00';
        $arrArguments['enduser']['language'] = 'EN';

        # Prepare complete API URL
        $strUrl = $strUrl . http_build_query($arrArguments);
        # Get API result
        $strResult = @file_get_contents($strUrl);
        $result = json_decode($strResult);

		if (!is_null($result) && $result->request->result == '1') {
			redirect($result->transaction->paymentURL);
		} else {
			$this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
			$data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror424", $this->global, $data,  NULL, "headercheck424");
		}
		return;

    }

    public function ExchangePay() {

        $transactionid = $this->security->xss_clean($this->input->post('order_id'));

        $usersubscriptionInfo = $this->user_subscription_model424->getUserSubscriptionInfoByTransactionId($transactionid);

        if (empty($usersubscriptionInfo)) {
            $this->session->set_flashdata('error', 'Unknown subscription for this user (ExchangeURL). Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror424", $this->global, $data,  NULL, "headercheck424");
            //            $this->load->view('payerror424', $data);
            return;
        }

        $updatedusersubscriptionInfo = array(
            'type' => 'cc',
            'recurring_id' => $this->security->xss_clean($this->input->post('recurring_id')),
            'recurring_token' => $this->security->xss_clean($this->input->post('recurring_token')),
            'createdDtm' => date('Y-m-d H:i:s')
        );

        $result = $this->user_subscription_model424->update($updatedusersubscriptionInfo, $usersubscriptionInfo);

        if ($result) {
            
        } else {
            log_message('error', print_r($this->db->error(), true));
            $this->session->set_flashdata('error', 'Update user subscription (ExchangeURL) error @ ' . __LINE__ . '. Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror424", $this->global, $data,  NULL, "headercheck424");
            //            $this->load->view('payerror424', $data);
            return;
        }

        echo('TRUE|');
    }


    public function successPaymentPay() {
        // orderId -> contains pay.nl transactionID
        $transactionid = $this->security->xss_clean($this->input->get('orderId'));
		$statuscode = intval($this->input->get('orderStatusId'));

		if ($statuscode == 100) {
			$data = array();
			$this->global['pageTitle'] = 'TIQS : THANKS';
			$this->loadViews("paysuccess424", $this->global, $data, NULL, "headercheck424");
		} elseif ($statuscode <0) {
			$data = array();
			$this->global['pageTitle'] = 'TIQS : THANKS';
			$this->loadViews("payerror424", $this->global, $data, NULL, "headercheck424");
		} elseif ($statuscode >= 0) {
			$data = array();
			$this->global['pageTitle'] = 'TIQS : THANKS';
			$this->loadViews("payerror424", $this->global, $data, NULL, "headercheck424");
		} else {
			$data = array();
			$this->global['pageTitle'] = 'TIQS : THANKS';
			$this->loadViews("payerror424", $this->global, $data, NULL, "headercheck424");
		}

	}

    private function sendyunsubscribe($email) {
        $config = [
            'installation_url' => 'https://tiqs.com/newsletters',
            'api_key' => 'TtlB6UhkbYarYr4PwlR1',
            'list_id' => '2Vh65Ld8fnXPkpZXPebzPw', // Pay success
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

}
