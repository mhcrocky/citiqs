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

class Pay extends BaseControllerWeb {

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

    //
    // https://tiqs.com/lostandfound//pay/1/pnroos%40icloud.com
    //

    public function index($subscriptionid, $email = "")
    {
        if (empty($subscriptionid)) {
            $this->session->set_flashdata('error', 'Empty subscription');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            return;
        }

        $subscriptionInfo = $this->subscription_model->getSubscriptionInfoById($subscriptionid);
      
        if (empty($subscriptionInfo)) {
            $this->session->set_flashdata('error', 'Unknown subscription');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            return;
        }

        if ($subscriptionInfo->active == 0) {
            $this->session->set_flashdata('error', 'Subscription not active');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            //            $this->load->view('payerror', $data);
            return;
        }

        
        $pporcc = $this->security->xss_clean($this->session->userdata('pporcc'));
        unset($_SESSION['pporcc']);
        if (empty($email) || ($subscriptionid === "3" && empty($pporcc))) {
            $this->paysubscriptionwithui($subscriptionid, urldecode($email));
            return;
        }

        $email = urldecode($email);
        $userInfo = $this->user_model->getUserInfoByMail($email);
        if (empty($userInfo)) {
            $this->session->set_flashdata('error', 'Unknown user (not registered)');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            return;
        }

        // Any items already found and no subscription? Force last minute onboarding subscription
		// not nescessary anymore.
        $result = $this->user_subscription_model->getUserSubscriptionInfoByUserId($userInfo->userId);
        if (empty($result)) {
            // No subscription, any found labels...?
            $result = $this->label_model->getFoundLabelsByUserId($userInfo->userId);
            if ($result > 0) {
                $subscriptionid = 3;
                $subscriptionInfo = $this->subscription_model->getSubscriptionInfoById($subscriptionid);
            }
        }

        $arrArguments = array();
        $arrArguments['serviceId'] = PAYNL_SERVICE_ID;
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
        
        $arrArguments['finishUrl'] = base_url() . 'pay/successpay';
        $orderExchangeUrl =  base_url() . 'pay/exchangepay';

        if (isset($pporcc) && $pporcc === "visamastercard")
            $arrArguments['paymentOptionId'] = '706';   // Visa or Mastercard

        $arrArguments['statsData']['promotorId'] = $userInfo->userId;
        // niet $arrArguments['statsData']['extra1'] = $this->orderId;;
        // niet $arrArguments['statsData']['extra2'] = $_SESSION['spot_id'];
        $arrArguments['enduser']['emailAddress'] = $email;
        // $arrArguments['enduser']['company']['name'] = 'tiqs';
        $arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
        $arrArguments['saleData']['deliveryDate'] = date('d-m-Y');
        $arrArguments['saleData']['orderData'][0]['productId'] = $subscriptionid;
        $arrArguments['transaction']['description'] = $subscriptionInfo->description;
        $arrArguments['saleData']['orderData'][0]['description'] = $subscriptionInfo->description;
        if ($subscriptionid == "3") {
            $arrArguments['saleData']['orderData'][0]['productType'] = 'IDENTITY';
            $arrArguments['transaction']['orderExchangeUrl'] = $orderExchangeUrl;
        } else
            $arrArguments['saleData']['orderData'][0]['productType'] = 'HANDLING';
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
            $usersubscriptionInfo = $this->user_subscription_model->getUserSubscriptionInfoByUserIdAndSubscriptionId($userInfo->userId, $subscriptionid);
            if (!empty($usersubscriptionInfo)) {
                switch ($usersubscriptionInfo->paystatus) {
                    case "0": // never payed, error somewhere else
                    case "1": // a previous payment paystatus = 1 = error. Try again
                        $updatedusersubscriptionInfo = array(
                            'transactionid' => $result->transaction->transactionId,
                            'createdDtm' => date('Y-m-d H:i:s')
                        );
                        if ($this->user_subscription_model->update($updatedusersubscriptionInfo, $usersubscriptionInfo))
                            if ($pporcc == "paypal") {
                                // pass new transactionId to paypal
                                $usersubscriptionInfo->transactionid = $result->transaction->transactionId;
                                $this->paypal($usersubscriptionInfo, $subscriptionInfo->amount);
                            } else
                                redirect($result->transaction->paymentURL);
                        else {
                            log_message('error', print_r($this->db->error(), true));
                            $this->session->set_flashdata('error', 'Update user subscription error @ ' . __LINE__ . '. Please, contact staff');
                            $data = array();
							$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
							$this->loadViews("payerror", $this->global, $data, NULL);
                            //                            $this->load->view('payerror', $data);
                            return;
                        }
                        break;
                    case "2": // already payed
                        $subscriptionInfo = $this->subscription_model->getSubscriptionInfoById($usersubscriptionInfo->subscriptionid);
                        if (empty($subscriptionInfo))
                            $description = "Subscription unknown. Please, contact our staff";
                        else
                            $description = $subscriptionInfo->description;
                        $this->session->set_flashdata('error', 'You\'ve already payed for this subscription:<br/>' . $description);
                        $data = array();
						$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
						$this->loadViews("payerror", $this->global, $data, NULL);
                        //                        $this->load->view('payerror', $data);
                        return;
                        break;
                    case "3": // pending
                        $subscriptionInfo = $this->subscription_model->getSubscriptionInfoById($usersubscriptionInfo->subscriptionid);
                        if (empty($subscriptionInfo))
                            $description = "Subscription unknown. Please, contact our staff";
                        else
                            $description = $subscriptionInfo->description;
                        $this->session->set_flashdata('error', 'Your payment is pending for this subscription:<br/>' . $description . '<br/><br/>Please, contact our staff if you haven\'t received a payment confirmation by email at ' . $email . ' in two workdays');
                        $data = array();
						$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
						$this->loadViews("payerror", $this->global, $data, NULL);
                        //                        $this->load->view('payerror', $data);
                        return;
                        break;
                }
            } else {
                // new subscription for this user
                $usersubscriptionInfo = array(
                    'userid' => $userInfo->userId,
                    'subscriptionid' => $subscriptionid,
                    'transactionid' => $result->transaction->transactionId,
                    'createdDtm' => date('Y-m-d H:i:s')
                );
                if ($this->user_subscription_model->insert($usersubscriptionInfo))
                    if ($pporcc == "paypal") {
                        $this->paypal($usersubscriptionInfo, $subscriptionInfo->amount);
                    } else
                        redirect($result->transaction->paymentURL);
                else {
                    log_message('error', print_r($this->db->error(), true));
                    $this->session->set_flashdata('error', 'Couldn\'t store subscription. Please, contact staff');
                    $data = array();
					$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
					$this->loadViews("payerror", $this->global, $data, NULL);
                    //                    $this->load->view('payerror', $data);
                    return;
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            //            $this->load->view('payerror', $data);
            return;
        }
    }

    private function paypal($usersubscriptionInfo, $amount) {
        $apiContext = $this->getPayPalAPIContext();
        // https://github.com/paypal/PayPal-PHP-SDK/wiki/Making-First-Call
        // Create a new billing plan
        $plan = new Plan();
        $plan->setType('INFINITE');
        // $plan->setType('FIXED');
        $plan->setName('tiqslostandfoundsubscription')
                ->setDescription('Tiqs lost and found recurring subscription payment');
        // Set billing plan definitions
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
                ->setType('REGULAR')
                // ->setType('INFINITE')
                ->setFrequency('MONTH')
                ->setFrequencyInterval('1')
                // ->setCycles('12')
                ->setCycles('0')    // infinite
                ->setAmount(new Currency(array(
                            'value' => $amount,
                            'currency' => 'EUR'
        )));

        // Set charge models
        /*
          $chargeModel = new ChargeModel();
          $chargeModel->setType('SHIPPING')->setAmount(new Currency(array(
          'value' => 1,
          'currency' => 'EUR'
          )));
          $paymentDefinition->setChargeModels(array(
          $chargeModel
          ));
         */

        // Set merchant preferences
        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(base_url() . 'payppcallback/success?tid=' . $usersubscriptionInfo->transactionid)
                ->setCancelUrl(base_url() . 'payppcallback/cancel?tid=' . $usersubscriptionInfo->transactionid)
                ->setAutoBillAmount('yes')
                ->setInitialFailAmountAction('CONTINUE')
                ->setMaxFailAttempts('0')
                ->setSetupFee(new Currency(array(
                            'value' => 0,
                            'currency' => 'EUR'
        )));

        $plan->setPaymentDefinitions(array(
            $paymentDefinition
        ));
        $plan->setMerchantPreferences($merchantPreferences);

        try {
            $createdPlan = $plan->create($apiContext);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            log_message('error', print_r($ex->getCode(), true));
            log_message('error', print_r($ex->getData(), true));
            $this->session->set_flashdata('error', 'Error creating PayPal plan @ ' . __LINE__ . '. Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            //            $this->load->view('payerror', $data);
            return;
        } catch (Exception $ex) {
            log_message('error', print_r($ex->getMessage(), true));
            $this->session->set_flashdata('error', 'Unknown error creating PayPal plan @ ' . __LINE__ . '. Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            //            $this->load->view('payerror', $data);
            return;
        }

        // Activate billing plan
        try {
            $patch = new Patch();
            $value = new PayPalModel('{"state":"ACTIVE"}');
            $patch->setOp('replace')
                    ->setPath('/')
                    ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);
            $createdPlan->update($patchRequest, $apiContext);
            $patchedPlan = Plan::get($createdPlan->getId(), $apiContext);

            // require_once "createPHPTutorialSubscriptionAgreement.php";
            // Create billing agreement
            // Create new agreement
            $startDate = date('c', time() + 3600);
            $agreement = new Agreement();
            $agreement->setName('Tiqs lost and found Plan Subscription Agreement')
                    ->setDescription('Tiqs lost and found Plan Subscription Billing Agreement')
                    ->setStartDate($startDate);

            // Set plan id
            $plan = new Plan();
            $plan->setId($patchedPlan->getId());
            $agreement->setPlan($plan);

            // Add payer type
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $agreement->setPayer($payer);


            // Adding shipping details
            /*
              $shippingAddress = new ShippingAddress();
              $shippingAddress->setLine1('111 First Street')
              ->setCity('Saratoga')
              ->setState('CA')
              ->setPostalCode('95070')
              ->setCountryCode('US');
              $agreement->setShippingAddress($shippingAddress);
             */

            try {
                // Create agreement
                $agreement = $agreement->create($apiContext);

                // Extract approval URL to redirect user
                $approvalUrl = $agreement->getApprovalLink();

                redirect($approvalUrl);
                // header("Location: " . $approvalUrl);
                exit();
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                log_message('error', print_r($ex->getCode(), true));
                log_message('error', print_r($ex->getData(), true));
                $this->session->set_flashdata('error', 'Error creating PayPal agreement @ ' . __LINE__ . '. Please, contact staff');
                $data = array();
				$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
				$this->loadViews("payerror", $this->global, $data, NULL);
            //                $this->load->view('payerror', $data);
                return;
            } catch (Exception $ex) {
                log_message('error', print_r($ex->getMessage(), true));
                $this->session->set_flashdata('error', 'Unknown error creating PayPal agreement @ ' . __LINE__ . '. Please, contact staff');
                $data = array();
				$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
				$this->loadViews("payerror", $this->global, $data, NULL);
            //                $this->load->view('payerror', $data);
                return;
            }
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            log_message('error', print_r($ex->getCode(), true));
            log_message('error', print_r($ex->getData(), true));
            $this->session->set_flashdata('error', 'Error creating PayPal billing plan @ ' . __LINE__ . '. Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            //            $this->load->view('payerror', $data);
            return;
        } catch (Exception $ex) {
            log_message('error', print_r($ex->getMessage(), true));
            $this->session->set_flashdata('error', 'Unknown error creating PayPal billing plan @ ' . __LINE__ . '. Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            //            $this->load->view('payerror', $data);
            return;
        }
    }

    public function payppcallback($status) {
        $token = $this->security->xss_clean($this->input->get('token'));
        // $userid = $this->security->xss_clean($this->input->get('uid'));
        // $subscriptionid = $this->security->xss_clean($this->input->get('sid'));
        $transactionid = $this->security->xss_clean($this->input->get('tid'));

        $usersubscriptionInfo = $this->user_subscription_model->getUserSubscriptionInfoByTransactionId($transactionid);

        if (empty($usersubscriptionInfo)) {
            $this->session->set_flashdata('error', 'Unknown subscription for this user. Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            //            $this->load->view('payerror', $data);
            return;
        }

        // needed for Sendy below
        $userInfo = $this->user_model->getUserInfoById($usersubscriptionInfo->userid);
        $this->sendyunsubscribe($userInfo->email);

        switch ($status) {
            case 'success':
                $apiContext = $this->getPayPalAPIContext();
                $agreement = new \PayPal\Api\Agreement();

                try {
                    // Execute agreement
                    $result = $agreement->execute($token, $apiContext);
                    if ($result) {
                        $updatedusersubscriptionInfo = array(
                            'type' => 'pp',
                            'paystatus' => 2, // payed
                            'transactionid' => $token,
                            'createdDtm' => date('Y-m-d H:i:s')
                        );
                        $result = $this->user_subscription_model->update($updatedusersubscriptionInfo, $usersubscriptionInfo);
                        if ($result) {
                            $subscriptionInfo = $this->subscription_model->getSubscriptionInfoById($usersubscriptionInfo->subscriptionid);
                            if (empty($subscriptionInfo)) {
                                $this->session->set_flashdata('error', 'Unknown subscription');
                                $data = array();
								$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
								$this->loadViews("payerror", $this->global, $data, NULL);
                                //                                $this->load->view('payerror', $data);
                                return;
                            }

                            $config = [
                                'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
                                'api_key' => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
                                'list_id' => '2Vh65Ld8fnXPkpZXPebzPw', // Pay success
                            ];
                            $sendy = new \SendyPHP\SendyPHP($config);
                            $responseArray = $sendy->subscribe(
                                    array(
                                        'name' => ($userInfo->name == 'Unknown') ? 'Customer' : $userInfo->name,
                                        'email' => $userInfo->email,
                                        'Transactionid' => $token,
                                        'Subscription' => $subscriptionInfo->description
                                    )
                            );

                            if ($userInfo->payedwithoutlabels) {     // Payed without registered tags or sticker qr codes, mail send only once
                                $data['payedwithoutlabels'] = false;
                                $this->user_model->editUser($data, $userInfo->userId);

                                $config = [
                                    'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
                                    'api_key' => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
                                    'list_id' => 'plLE1iVlW7630CpRqPVq7WLQ', // Ask for address newsletter
                                ];
                                $sendy = new \SendyPHP\SendyPHP($config);
                                $responseArray = $sendy->subscribe(
                                        array(
                                            'name' => ($userInfo->name == 'Unknown') ? 'Customer' : $userInfo->name,
                                            'email' => $userInfo->email
                                        )
                                );
                            }

                            $data['description'] = $subscriptionInfo->description;
                            $data['amount'] = $subscriptionInfo->amount;
							$this->global['pageTitle'] = 'TIQS : PAYMENT SUCCESSFUL';
							$this->loadViews("paysuccess", $this->global, $data, NULL);
                            //                            $this->load->view('paysuccess', $data);
                        } else {
                            log_message('error', print_r($this->db->error(), true));
                            $this->session->set_flashdata('error', 'Update user subscription error @ ' . __LINE__ . '. Please, contact staff');
                            $data = array();
							$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
							$this->loadViews("payerror", $this->global, $data, NULL);
                            //                            $this->load->view('payerror', $data);
                            return;
                        }
                    }
                } catch (PayPal\Exception\PayPalConnectionException $ex) {
                    log_message('error', print_r($ex->getCode(), true));
                    log_message('error', print_r($ex->getData(), true));
                    $this->session->set_flashdata('error', 'Error creating PayPal executing agreement @ ' . __LINE__ . '. Please, contact staff');
                    $data = array();
					$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
					$this->loadViews("payerror", $this->global, $data, NULL);
                    //                    $this->load->view('payerror', $data);
                    return;
                } catch (Exception $ex) {
                    log_message('error', print_r($ex->getMessage(), true));
                    $this->session->set_flashdata('error', 'Unknown error creating PayPal  executing agreement @ ' . __LINE__ . '. Please, contact staff');
                    $data = array();
					$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
					$this->loadViews("payerror", $this->global, $data, NULL);
                    //                    $this->load->view('payerror', $data);
                    return;
                }
                break;

            case 'cancel':
                $updatedusersubscriptionInfo = array(
                    'type' => 'pp',
                    'paystatus' => 1, // error
                    'transactionid' => $token,
                    'createdDtm' => date('Y-m-d H:i:s')
                );
                $result = $this->user_subscription_model->update($updatedusersubscriptionInfo, $usersubscriptionInfo);
                if ($result) {
                    $subscriptionInfo = $this->subscription_model->getSubscriptionInfoById($usersubscriptionInfo->subscriptionid);
                    if (empty($subscriptionInfo)) {
                        $this->session->set_flashdata('error', 'Unknown subscription');
                        $data = array();
						$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
						$this->loadViews("payerror", $this->global, $data, NULL);
                        //                        $this->load->view('payerror', $data);
                        return;
                    }

                    $config = [
                        'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
                        'api_key' => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
                        'list_id' => 'JNTHyS90CBizZy1B763g4vIA', // Pay error
                    ];
                    $sendy = new \SendyPHP\SendyPHP($config);
                    $responseArray = $sendy->subscribe(
                            array(
                                'name' => ($userInfo->name == 'Unknown') ? 'Customer' : $userInfo->name,
                                'email' => $userInfo->email,
                                'Transactionid' => $token,
                                'Subscription' => $subscriptionInfo->description,
                                'Pay_link' => base_url() . "pay/" . $usersubscriptionInfo->subscriptionid . "/" . urlencode($userInfo->email)
                            )
                    );

                    $this->session->set_flashdata('error', 'Payment declined. Please, contact staff if you didn\'t cancel the payment yourself');
                    $data = array();
					$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
					$this->loadViews("payerror", $this->global, $data, NULL);
                    //                    $this->load->view('payerror', $data);
                    return;
                } else {
                    log_message('error', print_r($this->db->error(), true));
                    $this->session->set_flashdata('error', 'Update user subscription error @ ' . __LINE__ . '. Please, contact staff');
                    $data = array();
					$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
					$this->loadViews("payerror", $this->global, $data, NULL);
                    //                    $this->load->view('payerror', $data);
                    return;
                }

                break;
        }
    }

    private function getPayPalAPIContext() {
        switch (strtolower($_SERVER['HTTP_HOST'])) {
            case 'tiqs.com':
                require_once('/home/tiqs/domains/tiqs.com/public_html/lostandfound/vendor/autoload.php');
                // Get credentials from https://developer.paypal.com/developer/applications/
                $apiContext = new \PayPal\Rest\ApiContext(
                        new \PayPal\Auth\OAuthTokenCredential(
                                'Aaf8D0MuuLu2P-rc5jOVD08-6uWc298Txbw632BSXQ7Fm7HIG4erfvrTG8SaTUAYNxleoPSNufoUM-Cl', // ClientID
                                'EK2R3G1001Sv6U7InQjVzjAE5nW_38LtQOJ0SRQRAYwlE5TJLdCgHTVPGAS5__MXhIwND9QYJXdSC3cH'      // ClientSecret
                        )
                );

                $apiContext->setConfig(
                        array(
                            'mode' => 'live',
                        )
                );
                break;
            case 'loki-lost.com':
            case '10.0.0.48':
            case '192.168.1.67':
                require_once('/usr/share/nginx/html/lostandfound/vendor/autoload.php');
                // Get credentials from https://developer.paypal.com/developer/applications/
                $apiContext = new \PayPal\Rest\ApiContext(
                        new \PayPal\Auth\OAuthTokenCredential(
                                'AU6Mj3kC1KCBllnL7eRYOvWTEH8iWO2fsdm9H2j3dosgyhYhOLjwWVGxm45__UNifunHbcR7GdXdLxat', // ClientID
                                'EF7eJdl9OZnQCqtcW8golmwYaEaglaSrwO7OTtLODdJTploHpL_uGDGn8ial1XiQ9eYadeBNT9idoXOf'      // ClientSecret
                        )
                );
                break;
            default:
                require_once('/Users/peterroos/www/lostandfound/vendor/autoload.php');
                // Get credentials from https://developer.paypal.com/developer/applications/
                $apiContext = new \PayPal\Rest\ApiContext(
                        new \PayPal\Auth\OAuthTokenCredential(
                //                        'Aaf8D0MuuLu2P-rc5jOVD08-6uWc298Txbw632BSXQ7Fm7HIG4erfvrTG8SaTUAYNxleoPSNufoUM-Cl',     // ClientID
                //                        'EK2R3G1001Sv6U7InQjVzjAE5nW_38LtQOJ0SRQRAYwlE5TJLdCgHTVPGAS5__MXhIwND9QYJXdSC3cH'      // ClientSecret
                                'AU6Mj3kC1KCBllnL7eRYOvWTEH8iWO2fsdm9H2j3dosgyhYhOLjwWVGxm45__UNifunHbcR7GdXdLxat', // ClientID
                                'EF7eJdl9OZnQCqtcW8golmwYaEaglaSrwO7OTtLODdJTploHpL_uGDGn8ial1XiQ9eYadeBNT9idoXOf'      // ClientSecret
                        )
                );
                break;
        }

        return ($apiContext);
    }

    public function paysubscriptionwithui($subscriptionid, $email = '')
    {
        $data['email'] = $email;
        $data['subscriptionid'] = $subscriptionid;
        $data['subscriptions'] = $this->subscription_model->getallsubscriptions();
        
        foreach ($data['subscriptions'] as $subscription) {
            if ($subscription['id'] === $subscriptionid) {
                $data['message'] = $subscription['description'];
            }
            if ($subscription['id'] === '1') {
                $data['starterPackagePrice'] = $subscription['amount'];
            } elseif ($subscription['id'] === '3') {
                $data['basicPackagePrice'] = $subscription['amount'];
            } elseif ($subscription['id'] === '5') {
                $data['kidsPackagePrice'] = $subscription['amount'];
            } elseif ($subscription['id'] === '6') {
			$data['StickerPackagePrice'] = $subscription['amount'];
	}
        }

        $this->global['pageTitle'] = 'tiqs : Pay subscription';
		$this->loadViews("pay", $this->global, $data, NULL);
    }

    public function ExchangePay() {
        /*
          $uploaddir = '/home/tiqs/domains/tiqs.com/public_html/lostandfound/uploads/LabelImages/';

          $myFile = "ExchangePay.txt";
          $fh = fopen($uploaddir .$myFile, 'w') or die("can't open file");

          $stringData = "\$_GET\n";
          $stringData .= "-----------------------------\n";
          foreach($_GET as $key_name => $key_value) {
          $stringData .= $key_name . " = " . $key_value . "\n";
          }
          $stringData .= "\n\n\$_POST\n";
          $stringData .= "-----------------------------\n";
          foreach($_POST as $key_name => $key_value) {
          $stringData .= $key_name . " = " . $key_value . "\n";
          }
          $stringData .= "\n\n\$_SERVER\n";
          $stringData .= "-----------------------------\n";
          foreach($_SERVER as $key_name => $key_value) {
          $stringData .= $key_name . " = " . $key_value . "\n";
          }
          fwrite($fh, $stringData);
          fclose($fh);
         */

        // order_id -> contains pay.nl transactionID
        $transactionid = $this->security->xss_clean($this->input->post('order_id'));


        $usersubscriptionInfo = $this->user_subscription_model->getUserSubscriptionInfoByTransactionId($transactionid);

        if (empty($usersubscriptionInfo)) {
            $this->session->set_flashdata('error', 'Unknown subscription for this user (ExchangeURL). Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            //            $this->load->view('payerror', $data);
            return;
        }

        $updatedusersubscriptionInfo = array(
            'type' => 'cc',
            'recurring_id' => $this->security->xss_clean($this->input->post('recurring_id')),
            'recurring_token' => $this->security->xss_clean($this->input->post('recurring_token')),
            'createdDtm' => date('Y-m-d H:i:s')
        );

        $result = $this->user_subscription_model->update($updatedusersubscriptionInfo, $usersubscriptionInfo);

        if ($result) {
            
        } else {
            log_message('error', print_r($this->db->error(), true));
            $this->session->set_flashdata('error', 'Update user subscription (ExchangeURL) error @ ' . __LINE__ . '. Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            //            $this->load->view('payerror', $data);
            return;
        }

        echo('TRUE|');
    }

    public function successDeliveryDhlPay(): void
    {
        $orderstatusid = intval($this->input->get('orderStatusId'));
        $dhlId = intval($this->uri->segment(3));
        $data = [];

        if ($orderstatusid == 100) {
            $payStatus = $this->config->item('paystatusPayed');
            $data = [
                'description' => "DHL delivery",
                'dhl' => true,
            ];
            $this->global['pageTitle'] = 'TIQS : PAYMENT SUCCESFUL';
            $view = 'paysuccess';            
        } elseif ($orderstatusid < 0) {
            $payStatus = $this->config->item('paystatusError');
            $this->session->set_flashdata('error', 'Payment declined. Please, contact staff if you didn\'t cancel the payment yourself');
            $this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
            $view = 'payerror';
        } elseif ($orderstatusid >= 0) {  
            $payStatus = $config['paystatusPending'];
            $this->session->set_flashdata('error', 'Payment pending. Please, contact staff');            
            $this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
            $view = 'payerror';
        } else {
            $payStatus = $this->config->item('paystatusError');
            $this->session->set_flashdata('error', 'Something really went wrong! Please, contact staff');
            $this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
            $view = 'payerror';
        }
        
        $insert = [
            'paystatus'         => $payStatus,
            'orderStatusId'     =>  $orderstatusid,
            'transactionid'     => $this->security->xss_clean($this->input->get('orderId')),            
            'paymentSessionId'  => $this->security->xss_clean($this->input->get('paymentSessionId')),
            'dhlId'             => $dhlId,
        ];

        $this->user_paymenthistory_model->save($insert);
        $this->loadViews($view, $this->global, $data, NULL);
        return;
    }

    public function successPaymentPay() {
        // orderId -> contains pay.nl transactionID
        $transactionid = $this->security->xss_clean($this->input->get('orderId'));

        $usersubscriptionInfo = $this->user_subscription_model->getUserSubscriptionInfoByTransactionId($transactionid);

        if (empty($usersubscriptionInfo)) {
            $this->session->set_flashdata('error', 'Unknown subscription for this user. Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            //            $this->load->view('payerror', $data);
            return;
        }

        // needed for Sendy below
        $userInfo = $this->user_model->getUserInfoById($usersubscriptionInfo->userid);

        $this->sendyunsubscribe($userInfo->email);

        // process pay.nl statuscode
        $statuscode = intval($this->input->get('orderStatusId'));

        if ($statuscode == 100) {
            $updatedusersubscriptionInfo = array(
                'paystatus' => 2, // payed
                'createdDtm' => date('Y-m-d H:i:s')
            );
            $result = $this->user_subscription_model->update($updatedusersubscriptionInfo, $usersubscriptionInfo);
            if ($result) {
                $subscriptionInfo = $this->subscription_model->getSubscriptionInfoById($usersubscriptionInfo->subscriptionid);
                if (empty($subscriptionInfo)) {
                    $this->session->set_flashdata('error', 'Unknown subscription');
                    $data = array();
					$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
					$this->loadViews("payerror", $this->global, $data, NULL);
                    //                    $this->load->view('payerror', $data);
                    return;
                }

                $config = [
                    'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
                    'api_key' => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
                    'list_id' => '2Vh65Ld8fnXPkpZXPebzPw', // Pay success
                ];
                $sendy = new \SendyPHP\SendyPHP($config);
                $responseArray = $sendy->subscribe(
                        array(
                            'name' => ($userInfo->name == 'Unknown') ? 'Customer' : $userInfo->name,
                            'email' => $userInfo->email,
                            'Transactionid' => $transactionid,
                            'Subscription' => $subscriptionInfo->description
                        )
                );

                if ($userInfo->payedwithoutlabels) {     // Payed without registered tags or sticker qr codes, mail send only once
                    $data['payedwithoutlabels'] = false;
                    $this->user_model->editUser($data, $userInfo->userId);

                    $config = [
                        'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
                        'api_key' => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
                        'list_id' => 'plLE1iVlW7630CpRqPVq7WLQ', // Ask for address newsletter
                    ];
                    $sendy = new \SendyPHP\SendyPHP($config);
                    $responseArray = $sendy->subscribe(
                            array(
                                'name' => ($userInfo->name == 'Unknown') ? 'Customer' : $userInfo->name,
                                'email' => $userInfo->email
                            )
                    );
                }

                $data['description'] = $subscriptionInfo->description;
                $data['amount'] = $subscriptionInfo->amount;
				$this->global['pageTitle'] = 'TIQS : PAYMENT SUCCESFUL';
				$this->loadViews("paysuccess", $this->global, $data, NULL);
                //                $this->load->view('paysuccess', $data);
            } else {
                log_message('error', print_r($this->db->error(), true));
                $this->session->set_flashdata('error', 'Update user subscription error @ ' . __LINE__ . '. Please, contact staff');
                $data = array();
				$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
				$this->loadViews("payerror", $this->global, $data, NULL);
                //                $this->load->view('payerror', $data);
                return;
            }
        } elseif ($statuscode < 0) {
            $updatedusersubscriptionInfo = array(
                'paystatus' => 1, // error
                'createdDtm' => date('Y-m-d H:i:s')
            );
            $result = $this->user_subscription_model->update($updatedusersubscriptionInfo, $usersubscriptionInfo);
            if ($result) {
                $subscriptionInfo = $this->subscription_model->getSubscriptionInfoById($usersubscriptionInfo->subscriptionid);
                if (empty($subscriptionInfo)) {
                    $this->session->set_flashdata('error', 'Unknown subscription');
                    $data = array();
					$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
					$this->loadViews("payerror", $this->global, $data, NULL);
                    //                    $this->load->view('payerror', $data);
                    return;
                }

                $config = [
                    'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
                    'api_key' => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
                    'list_id' => 'JNTHyS90CBizZy1B763g4vIA', // Pay error
                ];
                $sendy = new \SendyPHP\SendyPHP($config);
                $responseArray = $sendy->subscribe(
                        array(
                            'name' => ($userInfo->name == 'Unknown') ? 'Customer' : $userInfo->name,
                            'email' => $userInfo->email,
                            'Transactionid' => $transactionid,
                            'Subscription' => $subscriptionInfo->description,
                            'Pay_link' => base_url() . "pay/" . $usersubscriptionInfo->subscriptionid . "/" . urlencode($userInfo->email)
                        )
                );

                $this->session->set_flashdata('error', 'Payment declined. Please, contact staff if you didn\'t cancel the payment yourself');
                $data = array();
				$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
				$this->loadViews("payerror", $this->global, $data, NULL);
                //                $this->load->view('payerror', $data);
                return;
            } else {
                log_message('error', print_r($this->db->error(), true));
                $this->session->set_flashdata('error', 'Update user subscription error @ ' . __LINE__ . '. Please, contact staff');
                $data = array();
				$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
				$this->loadViews("payerror", $this->global, $data, NULL);
                //                $this->load->view('payerror', $data);
                return;
            }
        } elseif ($statuscode >= 0) {
            // Payment is pending
            $updatedusersubscriptionInfo = array(
                'paystatus' => 3, // pending
                'createdDtm' => date('Y-m-d H:i:s')
            );
            $result = $this->user_subscription_model->update($updatedusersubscriptionInfo, $usersubscriptionInfo);
            if ($result) {
                $subscriptionInfo = $this->subscription_model->getSubscriptionInfoById($usersubscriptionInfo->subscriptionid);
                if (empty($subscriptionInfo)) {
                    $this->session->set_flashdata('error', 'Unknown subscription');
                    $data = array();
					$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
					$this->loadViews("payerror", $this->global, $data, NULL);
                    //                    $this->load->view('payerror', $data);
                    return;
                }

                $config = [
                    'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
                    'api_key' => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
                    'list_id' => 'avmOrgRU2Tm5eeaDUaRUzA', // Pay pending
                ];
                $sendy = new \SendyPHP\SendyPHP($config);
                $responseArray = $sendy->subscribe(
                        array(
                            'name' => ($userInfo->name == 'Unknown') ? 'Customer' : $userInfo->name,
                            'email' => $userInfo->email,
                            'Transactionid' => $transactionid,
                            'Subscription' => $subscriptionInfo->description,
                            'Pay_link' => base_url() . "pay/" . $usersubscriptionInfo->subscriptionid . "/" . urlencode($userInfo->email)
                        )
                );

                $this->session->set_flashdata('error', 'Payment pending. Please, contact staff');
                $data = array();
				$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
				$this->loadViews("payerror", $this->global, $data, NULL);
                //                $this->load->view('payerror', $data);
                return;
            } else {
                log_message('error', print_r($this->db->error(), true));
                $this->session->set_flashdata('error', 'Update user subscription error @ ' . __LINE__ . '. Please, contact staff');
                $data = array();
				$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
				$this->loadViews("payerror", $this->global, $data, NULL);
                //                $this->load->view('payerror', $data);
                return;
            }
        } else {
            // shit hits the fan....
            $this->session->set_flashdata('error', 'Something really went wrong! Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
            //            $this->load->view('payerror', $data);
            return;
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

    private function fbinit() {
        if (!session_id())
            session_start();

        $fb = new Facebook\Facebook([
            'app_id' => '2175769952520353',
            'app_secret' => '4676f8d1eb74eda3caf3ba9083817fac',
            'default_graph_version' => 'v2.10',
        ]);
        return $fb;
    }

    public function facebook() {

        // $subscriptionid = $_POST['subscriptionid'];
        $subscriptionid = $this->security->xss_clean($this->input->post('subscriptionid'));
        if (!empty($subscriptionid)) {
            $this->session->set_userdata('subscriptionid', $subscriptionid);
        }

        $fb = $this->fbinit();
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email'];
        $loginUrl = $helper->getLoginUrl(base_url() . 'payfbcallback', $permissions);
        header('Location:' . $loginUrl);
    }

    public function fbcallback() {

        $fb = $this->fbinit();
        $helper = $fb->getRedirectLoginHelper();

        $this->session->set_userdata('state', $_GET['state']);

        $app_id = "2175769952520353";
        $app_secret = "4676f8d1eb74eda3caf3ba9083817fac";
        $my_url = base_url() . 'payfbcallback';

        $code = $_GET["code"];

        // If we get a code, it means that we have re-authed the user
        // and can get a valid access_token.
        if (isset($code)) {
            $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
                    . $app_id . "&redirect_uri=" . urlencode($my_url)
                    . "&client_secret=" . $app_secret
                    . "&code=" . $code . "&display=popup";
            $response = file_get_contents($token_url);
            $params = json_decode($response);
            $accessToken = $params->access_token;
        }

        try {
            $response = $fb->get('/me?fields=id,name,email', $accessToken);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'ERROR: Graph ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'ERROR: validation fails ' . $e->getMessage();
            exit;
        }

        $me = $response->getGraphUser();
        $sessionArray = array(
            'name' => $me->getName('name'),
            'email' => $me->getEmail(),
            'facebookid' => $me->getId(),
            'source' => 'facebook',
        );
        $this->session->set_userdata($sessionArray);

        redirect('/payregisterandpaysubscription');
    }

    public function payregisterandpaysubscription()
    {   
        $this->form_validation->set_rules('user[email]', 'Email', 'trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('emailverify', 'Email', 'trim|required|matches[user[email]]');

        if (!$this->form_validation->run()) {
            $redirect = 'pay/' . $_POST['subscriptionid'];
            redirect($redirect);
        }

        //sanitiaze data
        $data = $this->input->post(null, true);

        // set session
        if (isset($data['paypal_x'])) $this->session->set_userdata('pporcc', 'paypal');
        if (isset($data['visamastercard_x']))  $this->session->set_userdata('pporcc', 'visamastercard');

        // register user if it is not
        $this->user_model->manageAndSetUser($data['user'])->sendActivationLink();

        $redirect = base_url() . 'pay' . DIRECTORY_SEPARATOR . $data['subscriptionid']  . DIRECTORY_SEPARATOR . urlencode($data['user']['email']);
        redirect($redirect);
    }

    public function paynl($dhlId)
    {
        $dhl = $this->dhl_model->setId(intval($dhlId))->fetch();
        $dhl = reset($dhl);
        $amount = floatval($dhl['dhlAmount']) + floatval($dhl['tiqsCommission']);        

        $payData['format'] = 'json';
        $payData['tokenid'] = PAYNL_DATA_TOKEN_ID;
        $payData['token'] = PAYNL_DATA_TOKEN;
        $payData['gateway'] = 'rest-api.pay.nl';
        $payData['namespace'] = 'Transaction';
        $payData['function'] = 'start';
        $payData['version'] = 'v13';

        $strUrl  = 'http://' . $payData['tokenid'] . ':' . $payData['token'] . '@';
        $strUrl .= $payData['gateway'] . '/' . $payData['version'] . '/' . $payData['namespace'] . '/';
        $strUrl .= $payData['function'] . '/' . $payData['format'] . '?';

        $arrArguments = [];
        $arrArguments['serviceId'] = PAYNL_SERVICE_ID;
        $arrArguments['amount'] = strval($amount * 100);
        $arrArguments['ipAddress'] = $_SERVER['REMOTE_ADDR'];
        $arrArguments['finishUrl'] = base_url()  . 'pay/successdeliverydhlpay/' . $dhlId;
        $arrArguments['statsData']['promotorId'] = $dhl['claimerId'];
        $arrArguments['enduser']['emailAddress'] = $dhl['claimerEmail'];
        $arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
        $arrArguments['saleData']['deliveryDate'] = date('d-m-Y');
        $arrArguments['saleData']['orderData'][0]['dhlId'] = $dhlId;
        $arrArguments['transaction']['description'] = "";
        $arrArguments['saleData']['orderData'][0]['description'] = "";
        $arrArguments['saleData']['orderData'][0]['productType'] = 'HANDLING';
        $arrArguments['saleData']['orderData'][0]['price'] = strval(floatval($amount) * 100);
        $arrArguments['saleData']['orderData'][0]['quantity'] = 1;
        $arrArguments['saleData']['orderData'][0]['vatCode'] = 'H';
        $arrArguments['saleData']['orderData'][0]['vatPercentage'] = '21.00';
        $arrArguments['enduser']['language'] = 'EN';

        # Prepare complete API URL
        $strUrl = $strUrl . http_build_query($arrArguments);

        # Get API result
        $result = @file_get_contents($strUrl);
        $result = json_decode($result);

        if (!is_null($result) && $result->request->result == '1') {
            redirect($result->transaction->paymentURL);
        } else {
            $this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
            $data = array();
			$this->global['pageTitle'] = 'TIQS : PAYMENT ERROR';
			$this->loadViews("payerror", $this->global, $data, NULL);
        }
        return;
    }

    public function paynlRecurring() {
        //Put this in your cron job page: /usr/local/bin/php /home/tiqs/domains/tiqs.com/public_html/index.php Pay paynlRecurring
        //Run only from command line interface
        if (is_cli()) {
        	// log here entry
			$this->user_subscription_model->logRecurringPaymentCall(date(now()));
            $results = $this->user_subscription_model->getUsersSubscriptionsInfoForPaynlRecurringPayments();
            $amount = $this->subscription_model->getSubscriptionInfoById("3");
            if (!empty($amount)) {
                $recuringCharge = (float) $amount->amount * 100;
                if (!empty($results)) {
                    foreach ($results as $result) {
                        $nowDateTime = new DateTime();
                        $createDateTime = new DateTime($result['createdDtm']);
                        $interval = $nowDateTime->diff($createDateTime);
                        $elapsedDays = $interval->format('%a');
                        if ($elapsedDays >= 30) {
                            $payData = [];
                            $payData['format'] = 'json';
                            $payData['tokenid'] = PAYNL_DATA_TOKEN_ID_RECURRING;
                            $payData['token'] = PAYNL_DATA_TOKEN_RECURRING;
                            $payData['gateway'] = 'rest-api.pay.nl';
                            $payData['namespace'] = 'Transaction';
                            $payData['function'] = 'byRecurringId';
                            $payData['version'] = 'v15';
                            $strUrl = "https://" . $payData['tokenid'] .
                                    ":" . $payData['token'] .
                                    "@" . $payData['gateway'] .
                                    "/" . $payData['version'] .
                                    "/" . $payData['namespace'] .
                                    "/" . $payData['function'] .
                                    "/" . $payData['format'];
                            $arrArguments = array();
                            $arrArguments['recurringId'] = $result['recurring_id'];
                            $arrArguments['serviceId'] = PAYNL_SERVICE_ID_RECURRING;
                            $arrArguments['amount'] = $recuringCharge;
                            $arrArguments['currency'] = 'EUR';
                            $arrArguments['description'] = 'Recurring Charge';
                            $objCurl = curl_init($strUrl);
                            curl_setopt($objCurl, CURLOPT_URL, $strUrl);
                            curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($objCurl, CURLOPT_TIMEOUT, 5);
                            curl_setopt($objCurl, CURLOPT_POST, 1);
                            curl_setopt($objCurl, CURLOPT_POSTFIELDS, $arrArguments);
                            curl_setopt($objCurl, CURLOPT_USERAGENT, "Pay Gateway");
                            $strReturnData = curl_exec($objCurl);
                            $arrResult = json_decode($strReturnData);
                            $iErrorNumber = curl_errno($objCurl);
                            if ($iErrorNumber != 0) {//Curl failed
                                //Don't do anything, the cron curl will run the next hour.
                            } elseif ($arrResult === false) {//Curl sent no response.
                                //Don't do anything, the cron curl will run the next hour.
                            } else {
                                //handle response call
                                $resultNumber = $arrResult->request->result;
                                $orderId = $arrResult->transaction->orderId;
                                if($resultNumber == "1"){
                                    //Payment success.
                                    $this->user_subscription_model->updateRecurringPaymentRocord($result['recurring_id'], "2", $nowDateTime->format('Y-m-d H:i:s'), $orderId);
                                }else if($resultNumber == "0"){
                                    //Payment failed.
                                    $this->user_subscription_model->updateRecurringPaymentRocord($result['recurring_id'], "1", $result['createdDtm'], NULL);
                                }
                            }
                            curl_close($objCurl);
                            //Cleanup API data
                            unset($payData, $strUrl, $iErrorNumber, $strErrorMessage, $arrArguments);
                        }
                    }
                }
            }
        }
    }

    public function tesDhlLogin() {
        
    }
}
