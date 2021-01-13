<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Connections_helper
    {
        public static $FAILED_STATUS = 0;
        public static $SUCCESS_STATUS = 1;

        public static function getFailedResponse(int $errorCode): array
        {
            $CI =& get_instance();
            $CI->load->helper('error_messages_helper');
            return [
                'status' => Connections_helper::$FAILED_STATUS,
                'errorCode' => $errorCode,
                'message' => Error_messages_helper::getErrorMessage($errorCode)
            ];
        }

        public static function sendGetRequest(string $url, array $headers): ?object
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response ? json_decode($response) : null;
        }

        public static function sendPostRequest(string $url, array $post, array $headers): ?object
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response ? json_decode($response) : null;
        }

        public static function sendPutRequest(string $url, string $rawData, array $headers): ?object
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response ? json_decode($response) : null;
        }
    }
