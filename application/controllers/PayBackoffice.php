<?php

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/SendyPHP.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/vendor/autoload.php';

class PayBackoffice extends BaseControllerWeb {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->helper('utility_helper');
        $this->load->helper('email_helper');
        $this->load->model('log_model');
        $this->load->model('user_model');
        $this->load->model('label_model');
        $this->load->model('subscription_model');
        $this->load->model('user_subscription_model');
        $this->load->model('user_paymenthistory_model');
        $this->load->model('dhl_model');
        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('form_validation');
    }

    public function index()
    {
		$data = $this->input->get(null, true);

//		echo '<pre>';
//		print_r(($data));
//		echo '</pre>';

        $arrArguments = array();
        $arrArguments['serviceId'] = PAYNL_SERVICE_ID;
        $arrArguments['amount'] = strval(floatval($data['invoice']['total']) * 100);
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
        
        $arrArguments['finishUrl'] = base_url() . 'PayBackoffice/successpayoffice';

        $arrArguments['statsData']['promotorId'] = $data['invoice']['client']['lostandfound_user_id'];
        $arrArguments['enduser']['emailAddress'] = 'pnroos@tiqs.com';
        $arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
        $arrArguments['saleData']['deliveryDate'] = date('d-m-Y');
        $arrArguments['saleData']['orderData'][0]['productId'] = 'invoice';
        $arrArguments['transaction']['description'] = 'Shortdecription';
        $arrArguments['saleData']['orderData'][0]['description'] = 'Shortdecription';

		$arrArguments['saleData']['orderData'][0]['productType'] = 'HANDLING';
		$arrArguments['saleData']['orderData'][0]['price'] = strval(floatval($data['invoice']['total']) * 100);
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
			$this->loadViews("payerror", $this->global, $data, NULL);
		}
    }

    public function successpayoffice(): void
    {
//    	var_dump($_GET);
//    	die();

        $orderstatusid = intval($this->input->get('orderStatusId'));
        $data = [];

        if ($orderstatusid == 100) {
            $data = [
                'description' => "Invoice",
            ];
            $this->global['pageTitle'] = 'TIQS : PAYMENT SUCCESFUL';
            $view = 'paysuccess';
        } elseif ($orderstatusid < 0) {
            $this->session->set_flashdata('error', 'Payment declined. Please, contact staff if you didn\'t cancel the payment yourself');
            $this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
            $view = 'payerror';
        } elseif ($orderstatusid >= 0) {
            $this->session->set_flashdata('error', 'Payment pending. Please, contact staff');
            $this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
            $view = 'payerror';
        } else {
            $this->session->set_flashdata('error', 'Something really went wrong! Please, contact staff');
            $this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
            $view = 'payerror';
        }

        $this->loadViews($view, $this->global, $data, NULL);
        return;
    }

}
