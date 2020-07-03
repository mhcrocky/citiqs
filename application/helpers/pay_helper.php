<?php
    declare(strict_types=1);

    class Pay_helper
    {
        public static function getIdealUrl(array $argumentsArray): string
        {
            $payData = [
                'format'    => 'json',
                'tokenid'   => PAYNL_DATA_TOKEN_ID,
                'token'     => PAYNL_DATA_TOKEN,
                'gateway'   => 'rest-api.pay.nl',
                'namespace' => 'Transaction',
                'function'  => 'start',
                'version'   =>'v13',
            ];

            $strUrl  = 'http://' . $payData['tokenid'] . ':' . $payData['token'] . '@';
            $strUrl .= $payData['gateway'] . DIRECTORY_SEPARATOR . $payData['version'] . DIRECTORY_SEPARATOR;
            $strUrl .= $payData['namespace'] . DIRECTORY_SEPARATOR . $payData['function'] . DIRECTORY_SEPARATOR;
            $strUrl .= $payData['format'];
            $strUrl .= '?' . http_build_query($argumentsArray);
            
            return $strUrl;
        }

        public static function getArgumentsArray(array $order, string $paymentType): array
        {
            $amount = round((floatval($order['orderAmount']) + floatval($order['serviceFee'])) * 100, 0);
            $arrArguments = [];

            $arrArguments['serviceId'] = "SL-3157-0531";
            $arrArguments['amount'] = strval($amount);
            $arrArguments['ipAddress'] = $_SERVER['REMOTE_ADDR'];
            $arrArguments['paymentOptionId'] = '10';
            $arrArguments['paymentOptionSubId'] = $paymentType;
            $arrArguments['finishUrl'] = base_url() . 'successPayment' . DIRECTORY_SEPARATOR . $order['orderId'];

            $arrArguments['transaction']['orderExchangeUrl'] = base_url() . 'exchangePay';
            $arrArguments['transaction']['description'] = 'tiqs - ' . $order['orderId'];

            $arrArguments['statsData']['promotorId'] = $order['vendorId'];
            $arrArguments['statsData']['extra1'] = $order['orderId'];
            $arrArguments['statsData']['extra2'] = $order['spotId'];

            $arrArguments['enduser']['emailAddress'] = $order['buyerEmail'];
            $arrArguments['enduser']['language'] = 'NL';

            $arrArguments['saleData']['invoiceDate'] = date('d-m-Y');
            $arrArguments['saleData']['deliveryDate'] = date('d-m-Y');
            $arrArguments['saleData']['orderData'][0]['productId'] = $order['orderId'];
            $arrArguments['saleData']['orderData'][0]['description'] = 'Order from : ' . $order['vendorId'] . ' Spot : ' . $order['spotId'];
            $arrArguments['saleData']['orderData'][0]['productType'] = 'HANDLING';
            $arrArguments['saleData']['orderData'][0]['price'] = $amount;
            $arrArguments['saleData']['orderData'][0]['quantity'] = 1;
            $arrArguments['saleData']['orderData'][0]['vatCode'] = 'N';
            $arrArguments['saleData']['orderData'][0]['vatPercentage'] = '0,00';

            return $arrArguments;
        }
    }
