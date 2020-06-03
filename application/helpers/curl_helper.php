<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    class Curl_helper
    {
        public static function sendCurlPostRequest(string $url, array $post, array $headers = []): ?object
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
    }