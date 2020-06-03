<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Sms_helper
    {
        public static function sendItemFoundSms(array $label)
        {
            if ($label['claimerId']) {
                $userId = $label['claimerId'];
                $name =  $label['claimerUsername'];
                $mobilesend =  $label['claimerMobile'];
            } elseif ($label['ownerRoleId'] === '3') {
                $userId = $label['ownerId'];
                $name =  $label['ownerUsername'];
                $mobilesend =  $label['ownerMobile'];
            }
            if (isset($userId) && isset($name) && isset($mobilesend)) {
                $CI =& get_instance();
                $CI->load->library('sms');
                $result = $CI->user_subscription_model->getUserSubscriptionInfoByUserIdAndSubscriptionIdPaid($userId, 3);
                $mesage =(empty($result)) ? 'Please pay your subscription, go to https:/tiqs.com/pay/subscription' : 'Go to your tiqs dashboard to contact the finder https:/tiqs.com/login';
                $CI->sms->send($mobilesend, $name.' Your lost item is located with unique code : ' . $label['labelCode'] . '. ' . $message);
            }
        }           
    }