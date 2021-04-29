<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    class Curl_helper
    {
        public static function sendCurlPostRequest(string $url, array $post, array $headers = [])
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            if (!empty($headers)) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }            
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response ? json_decode($response) : null;
        }

        public static function sendCurlRawDataRequest(string $url, string $rawData, array $headers): ?object
        {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response ? json_decode($response) : null;
        }

        public static function sendSms(string $url, array $post, array $headers = [])
        {
            $response = self::sendCurlPostRequest($url, $post, $headers = []);
            return $response === 'send' ? true : false;
        }

        public static function sendSmsNew(string $mobile, string $message): bool
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://tiqs.com/lostandfound/Api/Missing/sendsms",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => array('mobilenumber' => $mobile, 'messagetext' => $message),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            return ($response === '"send"') ? true : false;
        }

        public static function sendPutRequest(string $url, array $data, array $headers): ?object
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $response = curl_exec($ch);
            curl_close($ch);
            return $response ? json_decode($response) : null;
        }

        public static function sendGetRequest(string $url, array $headers): ?object
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $response = curl_exec($ch);
            curl_close($ch);
            return $response ? json_decode($response) : null;
        }
    }
