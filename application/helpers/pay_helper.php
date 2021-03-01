<?php
    declare(strict_types=1);

    class Pay_helper
    {
        public static function getPayNlUrl(array $argumentsArray, string $namespace, string $function, string $version): string
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

            if ($namespace === $CI->config->item('orderPayNlNamespace')) {
                $payData['tokenid'] = PAYNL_DATA_TOKEN_ID;
                $payData['token'] = PAYNL_DATA_TOKEN;
            } elseif ($namespace === $CI->config->item('addMerchantPayNlNamecpace')) {
                $payData['tokenid'] = PAYNL_DATA_TOKEN_ID_ALLIANCE;
                $payData['token'] = PAYNL_DATA_TOKEN_ALLIANCE;
            }

            $strUrl  = 'http://' . $payData['tokenid'] . ':' . $payData['token'] . '@';
            $strUrl .= $payData['gateway'] . DIRECTORY_SEPARATOR . $payData['version'] . DIRECTORY_SEPARATOR;
            $strUrl .= $payData['namespace'] . DIRECTORY_SEPARATOR . $payData['function'] . DIRECTORY_SEPARATOR;
            $strUrl .= $payData['format'];
            $strUrl .= '?' . http_build_query($argumentsArray);
            
            return $strUrl;
        }

        // for oreder
        public static function getArgumentsArray(int $vendorId, array $order, string $serviceId, string $paymentType, string $paymentOptionSubId = '0'): array
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
            if ($paymentType ===  $CI->config->item('idealPaymentType') && $paymentOptionSubId) {
                $arrArguments['paymentOptionSubId'] = $paymentOptionSubId;
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

            return $arrArguments;
        }

        public static function createMerchant(int $userId, array $data): object
        {
            $CI =& get_instance();
            $CI->load->model('user_model');
            $CI->load->config('custom');

            $CI->user_model->setUniqueValue(strval($userId))->setWhereCondtition()->setUser();

            $argumentsArray = self::getMerchantArgumentsArray($CI->user_model, $data);
            $url = self::getPayNlUrl($argumentsArray, $CI->config->item('addMerchantPayNlNamecpace'), $CI->config->item('addMerchantPayNlFunction'), $CI->config->item('addMerchantPayNlVersion'));

            $result = file_get_contents($url);
            $result = json_decode($result);

            return $result;
        }

        public static function getPayNlServiceId(string $merchantId, int $userId): object
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

            $url = self::getPayNlUrl($argumentsArray, $CI->config->item('addPayNlServiceNamecpace'), $CI->config->item('addPayNlServiceFunction'), $CI->config->item('addPayNlServiceVersion'));

            $result = file_get_contents($url);
            $result = json_decode($result);

            return $result;
        }

        public static function getMerchantArgumentsArray(object $user, array $data): array
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $argumentsArray = $data;

            // split address with space, use last element of address for houseNumber
            $addressPieces = explode(' ', $user->address);
    
            // populate merchant array
            $argumentsArray['merchant']['name'] = $user->username;
            $argumentsArray['merchant']['vat'] = $user->vat_number;
            $argumentsArray['merchant']['street'] = $user->address;
            $argumentsArray['merchant']['houseNumber'] = $addressPieces[count($addressPieces) -1];
            $argumentsArray['merchant']['houseNumberAddition'] = $user->addressa;
            $argumentsArray['merchant']['postalCode'] = $user->zipcode;
            $argumentsArray['merchant']['city'] = $user->city;
            $argumentsArray['merchant']['countryCode'] = $user->country;
            $argumentsArray['merchant']['contactEmail'] = $user->email;
            $argumentsArray['merchant']['contactPhone'] = $user->mobile;
    
            // populate account array
            $argumentsArray['accounts']['authorizedToSign'] = '1';
            $argumentsArray['accounts']['ubo'] = '1';
            $argumentsArray['accounts']['uboPercentage'] = '100';
            $argumentsArray['accounts']['useCompanyAuth'] = '1';
            $argumentsArray['accounts']['hasAccess'] = '1';
            $argumentsArray['accounts']['language'] = $CI->config->item('englishLngPayNlId');
    
            // populate settings array
            $argumentsArray['settings']['package'] = 'Alliance';
            $argumentsArray['settings']['sendEmail'] = '1';
            $argumentsArray['settings']['settleBalance'] = '1';
            $argumentsArray['settings']['referralProfileId'] = PAYNL_MERCHANT_ID;
            $argumentsArray['settings']['clearingInterval'] = 'manual';

            return $argumentsArray;
    
        }
    }
