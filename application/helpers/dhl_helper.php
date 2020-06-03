<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . '/libraries/XmlLibrary.php';
    require APPPATH . '/libraries/getRateRequest.php';

    Class Dhl_helper
    {
        public static function dhlpricing(array $label): array
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $dhlPrice = new getRateRequest($label);
            $dhlPrice->send();
            $dhlPrice->saveRequestToXml($CI->config->item('dhlXmlRequests'));
            $dhlPrice->saveResponseToXml($CI->config->item('dhlXmlRequests'));
            $dhlPrice->setDomestic();
            // TIQS TO DO -> manage xml or soap, not string parse, see dhl documentation
            $responseString = $dhlPrice->response->__toString();
            $parsed = self::get_string_between($responseString, '<rateresp:RateResponse xmlns:rateresp="http://scxgxtt.phx-dc.dhl.com/euExpressRateBook/RateMsgResponse"><Provider code="DHL"><Notification code="0"><Message/></Notification>', '</Provider></rateresp:RateResponse>');
    
            if (empty($parsed)) {
                $response['html'] = self::get_string_between($responseString, '<Message>', '</Message>');
                return $response;
            } else {
                return self::getPricesFromParsedResponse($parsed, $dhlPrice->domestic);
            }
        }
    
        public static function get_string_between($string, $start, $end) {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) {
                return '';
            }
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }
    
        public static function getPricesFromParsedResponse($parsed, $domestic): array
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $xml = simplexml_load_string('<root>' . $parsed . '</root>', "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);
            $response = [];
    
            $html = "<ul>";
            // CHANGE BY PETER SHIFTING THE ARRAY ONE UP SOLVES THE ISSUE
            // @ATTRIBUTES ERROR
            $array = array_shift($array);
            $Amount ='';
            $currency= 'EUR';
            // if not indexed array
            if (isset($array['@attributes'])) {
                try {
                    $valueprice = $array['@attributes']['type'];
                    if (strpos ('DUN', $valueprice) != 0 ) {
                        $domestic = $valueprice;
                    }
                    if ($array['@attributes']['type'] === $domestic) {
                        $servicecharges = $array['Charges']['Charge'];
                        foreach ($servicecharges as $chargeservice) {
                            $html .= "<li style='font-family: campton-light'>" . $chargeservice['ChargeType'] . " " . $chargeservice['ChargeAmount'] . " " . $array['TotalNet']['Currency'] . "</li>";
                        }
                        $response['amount'] = $array['TotalNet']['Amount'];
                        $response['currency'] = $array['TotalNet']['Currency'];
                        $response['type'] = $array['@attributes']['type'];
                    }
                }
                catch (Exception $ex) {}
            } else {
                foreach ($array as $service) {
                    //We get only service with type P
                    try {
                        $valueprice = $service['@attributes']['type'];
                        if (strpos ('DUN', $valueprice) != 0 ) {
                            $domestic = $valueprice;
                        }
                        if ($service['@attributes']['type'] === $domestic) {
                            $servicecharges = $service['Charges']['Charge'];
                            foreach ($servicecharges as $chargeservice) {
                                $html .= "<li style='font-family: campton-light'>" . $chargeservice['ChargeType'] . " " . $chargeservice['ChargeAmount'] . " " . $service['TotalNet']['Currency'] . "</li>";
                             }
                            $response['amount'] = $service['TotalNet']['Amount'];
                            $response['currency'] = $service['TotalNet']['Currency'];
                            $response['type'] = $service['@attributes']['type'];
                        }
                    }
                    catch (Exception $ex) {}
                }
            }
            $html .= "</ul>";
            // if amount is empty we should check also D for international
            // p for europe
            // same country is 7 (i think)...
            if (!$response['amount']) {
                $html .= "<h3 style='font-family: campton-bold'>NO PRICE COULD BE CALCULATED CHECK YOUR ADDRESS</h3>";
            } else {
                $html .= "<h2 style='font-family: campton-bold'> Total: " . ($response['amount'] + $CI->config->item('tiqsCommission')) . " " . $response['currency'] . "</h2>";
            }
            $response['html'] = $html;
            return $response;
        }


        public static function prepraeDhlData(array $label, array $response): array
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            return [
                'labelId'			=> $label['labelId'],
                'dhlAmount'			=> $response['amount'],
                'tiqsCommission'	=> $CI->config->item('tiqsCommission'),
                'currency'			=> $response['currency'],
                'type'				=> $response['type'],
                'fromaddress'		=> $label['finderAddress'],
                'fromaddressa'		=> $label['finderAddressa'],
                'fromaddresscity'	=> $label['finderCity'],
                'fromaddresszip'	=> $label['finderZipcode'],
                'fromaddresscountry' => $label['finderCountry'],
                'toaddress'			=> $label['claimerAddress'],
                'toaddressa'		=> $label['claimerAddressa'],
                'toaddresscity'		=> $label['claimerCity'],
                'toaddresszip'		=> $label['claimerZipcode'],
                'toaddresscountry'	=> $label['claimerCountry'],
                'created_at'		=> date('Y-m-d H:i:s'),
            ];
        }
    }