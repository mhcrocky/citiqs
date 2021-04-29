<?php
declare(strict_types=1);

if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Queue_helper
{

    public static function releaseQueue(int $buyers = 1)
    {
        $CI =& get_instance();
        $CI->load->helper('curl_helper');
        $url = RELEASE_QUEUE_CALL . '?buyers=' . $buyers;
        $headers = ['X-Api-Key:' . QUEUE_X_API_KEY];
        return Curl_helper::sendGetRequest($url, $headers);
    }

    public static function echoReleaseQueueResponse(int $buyers = 1): void
    {
        echo json_encode(self::releaseQueue($buyers));
        return;
    }


}
