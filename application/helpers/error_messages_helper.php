<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Error_messages_helper
    {
        // NO DATA
        public static $NO_DATA = 1;

        // AUTHENTICATION ERROR CODES
        public static $AUTHENTICATION_KEY_NOT_SET = 2;
        public static $INVALID_AUTHENTICATION_KEY = 3;
        public static $ACCESS_DENIED = 4;
        public static $ERROR_VENDOR_AUTHENTICATION = 5;

        // BUYER ERROR CODES
        public static $BUYER_INSERT_FAILED = 100;
        public static $NO_BUYER_DATA = 101;
        public static $ERR_BUYER_EMAIL_NOT_SET = 102;
        public static $INVALID_BUYER_EMAIL = 103;
        public static $BUYER_NOT_EXISTS = 104;
        public static $BUYER_ALREADY_EXISTS = 105;
        public static $BUYER_MOBILE_REQUIRED = 106;
        public static $BUYER_MOBILE_NOT_VALID = 107;
        public static $MOBILE_UNALLOWED_LENGTH = 108;
        public static $BUYER_FIRST_NAME_REQUIRED = 109;
        public static $BUYER_LAST_NAME_REQUIRED = 110;
        public static $NOT_EXISTING_BUYER_API_IDENTIFIER = 111;
        public static $BUYER_UPDATE_NOT_ALLOWED = 112;
        public static $BUYER_UPDATE_FAILED = 113;

        public static function getErrorMessage(int $errorCode): string
        {

            $CI =& get_instance();
            $CI->load->config('custom');

            // NO DATA MESSAGE
            if ($errorCode === self::$NO_DATA) {
                return 'Empty set of data sent';
            }

            // AUTHENTICATION ERRORS MESSAGES
            if ($errorCode === self::$AUTHENTICATION_KEY_NOT_SET) {
                return 'Authentication key is not set';
            }

            if ($errorCode === self::$INVALID_AUTHENTICATION_KEY) {
                return 'Invalid authentication key';
            }

            if ($errorCode === self::$ACCESS_DENIED) {
                return 'Access denied';
            }

            if ($errorCode === self::$ERROR_VENDOR_AUTHENTICATION) {
                return 'Error on vendor authentication';
            }

            // BUYER ERROR MESSAGES            
            if ($errorCode === self::$BUYER_INSERT_FAILED) {
                return 'Buyer insert failed';
            }

            if ($errorCode === self::$NO_BUYER_DATA) {
                return 'No buyer data';
            }

            if ($errorCode === self::$ERR_BUYER_EMAIL_NOT_SET) {
                return 'Buyer email is requried';
            }

            if ($errorCode === self::$INVALID_BUYER_EMAIL) {
                return 'Buyer email address is not valid';
            }

            if ($errorCode === self::$BUYER_NOT_EXISTS) {
                return 'Buyer with this email does not exists';
            }

            if ($errorCode === self::$BUYER_ALREADY_EXISTS) {
                return 'Buyer with this email already exists';
            }

            if ($errorCode === self::$BUYER_MOBILE_REQUIRED) {
                return 'Buyer mobile is required';
            }

            if ($errorCode === self::$BUYER_MOBILE_NOT_VALID) {
                return 'Mobile phone number can contain only digits';
            }

            if ($errorCode === self::$MOBILE_UNALLOWED_LENGTH) {
                return 'Mobile phone number must contain minimum ' . $CI->config->item('minMobileLength') . ' digits';
            }

            if ($errorCode === self::$BUYER_FIRST_NAME_REQUIRED) {
                return 'Buyer first name is required';
            }

            if ($errorCode === self::$BUYER_LAST_NAME_REQUIRED) {
                return 'Buyer last name is required';
            }

            if ($errorCode === self::$NOT_EXISTING_BUYER_API_IDENTIFIER) {
                return 'Unknown api identifier';
            }

            if ($errorCode === self::$BUYER_UPDATE_NOT_ALLOWED) {
                return 'Buyer with this api identifier does not exist';
            }

            if ($errorCode === self::$BUYER_UPDATE_FAILED) {
                return 'Buyer update failed';
            }
        }
    }
