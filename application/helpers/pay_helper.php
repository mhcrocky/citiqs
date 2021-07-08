<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Pay_helper
    {
        public static function getPayNlUrl(string $namespace, string $function, string $version, array $argumentsArray = []): string
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $payData = [
                'format'    => 'json',                
                'gateway'   => 'rest-api.pay.nl',
                'namespace' => $namespace,
                'function'  => $function,
                'version'   => $version
            ];

            self::setTokens($payData, $namespace, $function);

            $strUrl  = 'http://' . $payData['tokenid'] . ':' . $payData['token'] . '@';
            $strUrl .= $payData['gateway'] . "/" . $payData['version'] . "/";
            $strUrl .= $payData['namespace'] . "/" . $payData['function'] . "/";
            $strUrl .= $payData['format'];

            if ($argumentsArray) {
                $strUrl .= '?' . http_build_query($argumentsArray);
            }

            return $strUrl;
        }

        private static function setTokens(array &$payData, string $namespace, string $function): void
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            if ($namespace === $CI->config->item('transactionNamespace')) {
                $payData['tokenid'] = PAYNL_DATA_TOKEN_ID;
                $payData['token'] = PAYNL_DATA_TOKEN;
            } elseif ($namespace === $CI->config->item('allianceNamespace') || $namespace === $CI->config->item('documentNamespace')) {
                $payData['tokenid'] = PAYNL_DATA_TOKEN_ID_ALLIANCE;
                $payData['token'] = PAYNL_DATA_TOKEN_ALLIANCE;
            }

            return;
        }
 
        public static function payOrder(int $vendorId, array $order, string $serviceId, string $paymentType, string $paymentOptionSubId = '0'): ?object
        {
            // echo var_dump($paymentType);
            // echo var_dump($paymentOptionSubId);
            // die();
            $CI =& get_instance();
            $CI->load->config('custom');

            $arguments = self::getOrderArgumentsArray($vendorId, $order, $serviceId, $paymentType, $paymentOptionSubId);

            return Pay_helper::getRequestResult(
                $arguments,
                $CI->config->item('transactionNamespace'),
                $CI->config->item('orderPayNlFunction'),
                $CI->config->item('orderPayNlVersion')
            );
        }

        public static function getOrderArgumentsArray(int $vendorId, array $order, string $serviceId, string $paymentType, string $paymentOptionSubId = '0'): array
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $amount = floatval($order['orderAmount']) + floatval($order['serviceFee']) - floatval($order['voucherAmount']) + $order['waiterTip'];
            $amount = round($amount, 2);
            $amount = $amount * 100;
            $arrArguments = [];

            $arrArguments['serviceId'] = $serviceId;
            $arrArguments['amount'] = strval($amount);
            $arrArguments['ipAddress'] = $_SERVER['REMOTE_ADDR'];
            $arrArguments['paymentOptionId'] = $paymentType;

            // for PIN PAyment we also need to have a paymentOptionSubId...
			// This is the terminal linked with the POS system.....
			// So each POS system needs to have identification set .... we need to discuss
			// of course if there a multiple POS systems in one business...

			if ($paymentType ===  $CI->config->item('idealPaymentType') && $paymentOptionSubId) {
                $arrArguments['paymentOptionSubId'] = $paymentOptionSubId;
            }

			if ($paymentType ===  "1927") {
				$arrArguments['paymentOptionSubId'] = "TH-9268-3020";
			}

            $arrArguments['finishUrl'] = base_url() . 'successPayment';

            $arrArguments['transaction']['orderExchangeUrl'] = base_url() . 'exchangePay';
            $arrArguments['transaction']['description'] = 'tiqs - ' . $order['orderId'];

            $arrArguments['statsData']['promotorId'] = $vendorId;
            $arrArguments['statsData']['extra1'] = $order['orderId'];
            $arrArguments['statsData']['extra2'] = $order['spotId'];

            $arrArguments['enduser']['emailAddress'] = $order['buyerEmail'];
            $arrArguments['enduser']['language'] = 'NL';

            $arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
            $arrArguments['saleData']['deliveryDate'] = date('d-m-Y');
            $arrArguments['saleData']['orderData'][0]['productId'] = $order['orderId'];
            $arrArguments['saleData']['orderData'][0]['description'] = 'Order from : ' . $vendorId . ' Spot : ' . $order['spotId'];
            $arrArguments['saleData']['orderData'][0]['productType'] = 'HANDLING';
            $arrArguments['saleData']['orderData'][0]['price'] = $amount;
            $arrArguments['saleData']['orderData'][0]['quantity'] = 1;
            $arrArguments['saleData']['orderData'][0]['vatCode'] = 'N';
            $arrArguments['saleData']['orderData'][0]['vatPercentage'] = '0,00';

            // echo var_dump($arrArguments);
            // die();
            return $arrArguments;
        }

        public static function getTicketingArgumentsArray(int $vendorId, array $reservations, string $serviceId, string $paymentType, string $paymentOptionSubId = '0'): array
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $CI->load->model('event_model');
            $paymentsCost = $CI->event_model->get_payment_methods($vendorId);
            $vendorCost = $CI->event_model->get_vendor_cost($vendorId);
            $buyerEmail = '';
            $totalAmount = 0;
            $arrArguments = [];
            
            $transactionDescription = [];

            foreach ($reservations as $key => $reservation) {
                
                $totalAmount +=  floatval($reservation->price) + floatval($reservation->ticketFee);
                $transactionDescription[] = $reservation->eventid . " - " . $reservation->ticketDescription;

                if ($key == 0) {
                    $buyerEmail = $reservation->email;
                }



            }
            

            $payment = self::getPaymentMethod($paymentType);
            $amountCost = $paymentsCost[$payment]['amount'];
            $percentCost = $paymentsCost[$payment]['percent'];
            $reservationsAmount = $totalAmount;
            if(isset($vendorCost[$payment]) && $vendorCost[$payment] == 0){
                $reservationsAmount = $totalAmount + ($percentCost*$totalAmount/100) + $amountCost;
            }
            
            $amount = round($reservationsAmount * 100);
            $arrArguments['serviceId'] = $serviceId;
            $arrArguments['amount'] = strval($amount);
            $arrArguments['ipAddress'] = $_SERVER['REMOTE_ADDR'];
            $arrArguments['paymentOptionId'] = $paymentType;

            // for PIN PAyment we also need to have a paymentOptionSubId...
			// This is the terminal linked with the POS system.....
			// So each POS system needs to have identification set .... we need to discuss
			// of course if there a multiple POS systems in one business...

			if ($paymentType ===  $CI->config->item('idealPaymentType') && $paymentOptionSubId) {
                $arrArguments['paymentOptionSubId'] = $paymentOptionSubId;
            }

			if ($paymentType ===  "1927") {
				$arrArguments['paymentOptionSubId'] = "TH-9268-3020";
			}

            $arrArguments['finishUrl'] = base_url() . 'booking_events/successBooking/';
            $arrArguments['transaction']['orderExchangeUrl'] = base_url() . 'booking_events/ExchangePay/';

            
            $arrArguments['enduser']['language'] = 'NL';

            $arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
            $arrArguments['saleData']['deliveryDate'] = date('d-m-Y');

            

            $arrArguments['enduser']['emailAddress'] = $buyerEmail;
            $arrArguments['transaction']['description'] = substr(implode(' | ', $transactionDescription), 0, 28);
            
   


            // echo var_dump($arrArguments);
            // die();
            return $arrArguments;
        }

        public static function getReservationsArgumentsArray(int $vendorId, array $reservations, string $serviceId, string $paymentType, string $paymentOptionSubId = '0'): array
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $CI->load->model('bookandpayagendabooking_model');
            $paymentsCost = $CI->bookandpayagendabooking_model->get_payment_methods($vendorId);
            $vendorCost = $CI->bookandpayagendabooking_model->get_vendor_cost($vendorId);
            $buyerEmail = '';
            $totalAmount = 0;
            $arrArguments = [];
            
            foreach ($reservations as $key => $reservation) {
                
                $totalAmount +=  floatval($reservation->price) + floatval($reservation->reservationFee);

                if ($key == 0) {
                    $arrArguments['transaction']['description'] = "tiqs - " . $reservation->eventdate . " - " . $reservation->timeslot;
                    $buyerEmail = $reservation->email;
                }


            }

            $payment = self::getPaymentMethod($paymentType);
            $amountCost = $paymentsCost[$payment]['amount'];
            $percentCost = $paymentsCost[$payment]['percent'];

            $reservationsAmount = $totalAmount;
            if(isset($vendorCost[$payment]) && $vendorCost[$payment] == 0){
                $reservationsAmount = $totalAmount + ($percentCost*$totalAmount/100) + $amountCost;
            }
            
            $amount = round($reservationsAmount * 100);

            $arrArguments['serviceId'] = $serviceId;
            $arrArguments['amount'] = strval($amount);
            $arrArguments['ipAddress'] = $_SERVER['REMOTE_ADDR'];
            $arrArguments['paymentOptionId'] = $paymentType;

            // for PIN PAyment we also need to have a paymentOptionSubId...
			// This is the terminal linked with the POS system.....
			// So each POS system needs to have identification set .... we need to discuss
			// of course if there a multiple POS systems in one business...

			if ($paymentType ===  $CI->config->item('idealPaymentType') && $paymentOptionSubId) {
                $arrArguments['paymentOptionSubId'] = $paymentOptionSubId;
            }

			if ($paymentType ===  "1927") {
				$arrArguments['paymentOptionSubId'] = "TH-9268-3020";
			}

            $arrArguments['finishUrl'] = base_url() . 'bookingpay/successBooking/';

            $arrArguments['transaction']['orderExchangeUrl'] = base_url() . 'bookingpay/ExchangePay/';


            $arrArguments['statsData']['promotorId'] = $vendorId;

            $arrArguments['enduser']['emailAddress'] = $buyerEmail;
            $arrArguments['enduser']['language'] = 'NL';

            $arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
            $arrArguments['saleData']['deliveryDate'] = date('d-m-Y');
   


            // echo var_dump($arrArguments);
            // die();
            return $arrArguments;
        }

        public static function createMerchant(int $userId, array $data): ?object
        {
            $CI =& get_instance();
            $CI->load->model('user_model');
            $CI->load->config('custom');

            $CI->user_model->setUniqueValue(strval($userId))->setWhereCondtition()->setUser();

            $argumentsArray = self::getMerchantArgumentsArray($CI->user_model, $data);

            return self::getRequestResult(
                $argumentsArray,
                $CI->config->item('allianceNamespace'),
                $CI->config->item('addMerchantPayNlFunction'),
                $CI->config->item('addMerchantPayNlVersion')
            );
        }

        public static function getMerchantArgumentsArray(object $user, array $data): array
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $argumentsArray = $data;

            // split address with space, use last element of address for houseNumber
            $addressPieces = explode(' ', $user->address);
    
            // populate merchant array
            $argumentsArray['merchant']['vat'] = $user->vat_number;
            $argumentsArray['merchant']['street'] = $user->address;
            $argumentsArray['merchant']['houseNumber'] = $addressPieces[count($addressPieces) -1];
            $argumentsArray['merchant']['houseNumberAddition'] = ' ';
            $argumentsArray['merchant']['postalCode'] = $user->zipcode;
            $argumentsArray['merchant']['city'] = $user->city;
            $argumentsArray['merchant']['countryCode'] = $user->country;
            $argumentsArray['merchant']['contactEmail'] = $user->email;
            $argumentsArray['merchant']['contactPhone'] = $user->mobile;
    
            // populate account array
            $argumentsArray['accounts']['authorizedToSign'] = '1';
            $argumentsArray['accounts']['ubo'] = '0';
            $argumentsArray['accounts']['uboPercentage'] = '0';
            $argumentsArray['accounts']['useCompanyAuth'] = '1';
            $argumentsArray['accounts']['hasAccess'] = '1';
            $argumentsArray['accounts']['language'] = $CI->config->item('englishLngPayNlId');
    
            // populate settings array
            $argumentsArray['settings']['package'] = 'Alliance';
            $argumentsArray['settings']['sendEmail'] = '0';
            $argumentsArray['settings']['settleBalance'] = '1';
            $argumentsArray['settings']['referralProfileId'] = PAYNL_MERCHANT_ID;
            $argumentsArray['settings']['clearingInterval'] = 'manual';

            return $argumentsArray;    
        }

        public static function getPayNlServiceId(string $merchantId, int $userId): ?object
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $argumentsArray = [
                'merchantId' => $merchantId,
                'name' => 'Food and beverages',
                'description' => 'Online payment service with QR coding',
                'categoryId' => $CI->config->item('payNlServiceCategoryId'),
                'publication' => 'Online payment service with QR coding',
            ];

            return self::getRequestResult(
                $argumentsArray,
                $CI->config->item('allianceNamespace'),
                $CI->config->item('addPayNlServiceFunction'),
                $CI->config->item('addPayNlServiceVersion')
            );
        }

        public static function getMerchant(string $merchantId): ?object
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $argumentsArray = [
                'merchantId' => $merchantId,
            ];

            return self::getRequestResult(
                $argumentsArray,
                $CI->config->item('allianceNamespace'),
                $CI->config->item('getMerchantPayNlFunction'),
                $CI->config->item('getMerchantPayNlVersion')
            );
        }

        public static function addDocument(string $documentId, string $filename, string $documentFile): ?object
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $argumentsArray = [
                'documentId' => $documentId,
                'filename' => $filename,
                'documentFile' => $documentFile
            ];

            return self::postReqeustResult(
                $argumentsArray,
                $CI->config->item('documentNamespace'),
                $CI->config->item('addDocumentPayNlFunction'),
                $CI->config->item('addDocumentPayNlVersion')
            );

        }

        private static function getRequestResult(array $argumentsArray, string $namespace, string $function, string $version): ?object
        {
            $url = self::getPayNlUrl($namespace, $function, $version, $argumentsArray);

            $result = file_get_contents($url);

            return empty($result) ? null : json_decode($result);
        }

        private static function postReqeustResult(array $argumentsArray, string $namespace, string $function, string $version): ?object
        {
            $CI =& get_instance();
            $CI->load->helper('curl_helper');

            $url = self::getPayNlUrl($namespace, $function, $version);
            return Curl_helper::sendCurlPostRequest($url, $argumentsArray);
        }

        private static function getPaymentMethod($paymentType)
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            switch($paymentType){
                case $CI->config->item('idealPaymentType'):
                    return $CI->config->item('idealPayment');
                    break;
                case $CI->config->item('creditCardPaymentType'):
                    return $CI->config->item('creditCardPayment');
                    break;
                case $CI->config->item('bancontactPaymentType'):
                    return $CI->config->item('bancontactPayment');
                    break;
                case $CI->config->item('giroPaymentType'):
                    return $CI->config->item('giroPayment');
                    break;
                case $CI->config->item('payconiqPaymentType'):
                    return $CI->config->item('payconiqPayment');
                    break;
                case $CI->config->item('pinMachinePaymentType'):
                    return $CI->config->item('pinMachinePayment');
                    break;
                case $CI->config->item('myBankPaymentType'):
                    return $CI->config->item('myBankPayment');
                    break;
                default:
                    return '';
                    break;
            }
        }

        public static function returnPaymentMethod(string $paymentTypeId): ?string
        {
            $paymentType = self::getPaymentMethod($paymentTypeId);
            return $paymentType ? $paymentType : null;
        }

        public static function refundAmount(array $argumentsArray): ?object
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            return self::getRequestResult(
                $argumentsArray,
                $CI->config->item('transactionNamespace'),
                $CI->config->item('getRefundPayNlFunction'),
                $CI->config->item('getRefundPayNlVersion')
            );
        }
    }
