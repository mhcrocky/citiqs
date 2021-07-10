<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Error_messages_helper
    {
        // NO DATA
        public static $NO_DATA_SENT = 1;
        public static $NO_DATA_RETURN = 2;

        // AUTHENTICATION ERROR CODES
        public static $AUTHENTICATION_KEY_NOT_SET = 10;
        public static $INVALID_AUTHENTICATION_KEY = 11;
        public static $ACCESS_DENIED = 12;
        public static $ERROR_VENDOR_AUTHENTICATION = 13;

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
        public static $BUYER_EX_UPDATE_FAILED = 114;

        // ORDER ERROR CODES
        public static $NO_ORDER_DATA = 200;
        public static $INVALID_ORDER_DATA = 201;
        public static $SERVICE_TYPE_NOT_SET = 202;
        public static $INVALID_SERVICE_TYPE = 203;
        public static $TYPE_NOT_ALLOWED_BY_VENDOR = 204;
        public static $ORDER_AMOUNT_NOT_SET = 205;
        public static $ORDER_AMOUNT_INVALID_FORMAT = 206;
        public static $ORDER_AMOUNT_NOT_POSITIVE = 207;
        public static $WAITERTIP_AMOUNT_INVALID_FORMAT = 208;
        public static $WAITERTIP_AMOUNT_NOT_POSITIVE = 209;
        public static $ORDER_TIME_NOT_SET = 210;
        public static $ORDER_INVALID_TIME = 211;
        public static $INVALID_ORDER_REMARK = 212;
        public static $ORDER_BUYER_NOT_SET = 213;
        public static $ISPAID_STATUS_NOT_SET = 214;
        public static $INVALID_ISPAID_STATUS = 215;
        public static $PRODUCTS_NOT_SET = 216;
        public static $PRODUCT_NAME_NOT_SET = 217;
        public static $PRODUCT_NAME_INVALID_FORMAT = 218;
        public static $PRODUCT_PRICE_NOT_SET = 219;
        public static $PRODUCT_PRICE_INVALID_FORMAT = 220;
        public static $PRODUCT_PRICE_VALUE = 221;
        public static $PRODUCT_QUANTITY_NOT_SET = 222;
        public static $PRODUCT_QUANTITY_INVALID_FORMAT = 223;
        public static $PRODUCT_QUANTITY_VALUE = 224;
        public static $ORDER_INSERT_FAILED_ON_PRODUCT_INSERT = 225;
        public static $VENDOR_DELIVERY_SERVICE_FEE_NOT_SET = 226;
        public static $VENDOR_PICKUP_SERVICE_FEE_NOT_SET = 227;
        public static $PRODUCT_REMARK_INVALID = 228;
        public static $ORDER_FAILED_ON_INSERT_IN_DB = 229;
        public static $ORDER_FAILED_ON_INSERT_ORDEREX = 230;

        public static function getErrorMessage(int $errorCode): string
        {

            $CI =& get_instance();
            $CI->load->config('custom');

            // NO DATA MESSAGE
            if ($errorCode === self::$NO_DATA_SENT) {
                return 'Empty set of data sent';
            }

            if ($errorCode === self::$NO_DATA_RETURN) {
                return 'Empty set of data return';
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
                return 'Buyer second name is required';
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

            if ($errorCode === self::$BUYER_EX_UPDATE_FAILED) {
                return 'Buyer extended update failed';
            }

            if ($errorCode === self::$NO_ORDER_DATA) {
                return 'No order data';
            }

            if ($errorCode === self::$INVALID_ORDER_DATA) {
                return 'Invalid order data';
            }

            if ($errorCode === self::$SERVICE_TYPE_NOT_SET) {
                return 'Service type is not set';
            }

            if ($errorCode === self::$INVALID_SERVICE_TYPE) {
                return 'Service type can only be ' . $CI->config->item('deliveryTypeString') . ' or ' . $CI->config->item('pickupTypeString') . ' type.'  ;
            }

            if ($errorCode === self::$TYPE_NOT_ALLOWED_BY_VENDOR) {
                return 'Service type is not allowed by vendor';
            }

            if ($errorCode === self::$ORDER_AMOUNT_NOT_SET) {
                return 'Order amount is not set';
            }

            if ($errorCode === self::$ORDER_AMOUNT_INVALID_FORMAT) {
                return 'Order amount must be integer or float number';
            }

            if ($errorCode === self::$ORDER_AMOUNT_NOT_POSITIVE) {
                return 'Order amount must be positive number';
            }

            if ($errorCode === self::$WAITERTIP_AMOUNT_INVALID_FORMAT) {
                return 'Waiter tip amount must be integer or float number';
            }

            if ($errorCode === self::$WAITERTIP_AMOUNT_NOT_POSITIVE) {
                return 'Waiter tip must be positive number';
            }

            if ($errorCode === self::$ORDER_TIME_NOT_SET) {
                return 'Order time is not set';
            }

            if ($errorCode === self::$ORDER_INVALID_TIME) {
                return 'Order time is not valid';
            }

            if ($errorCode === self::$INVALID_ORDER_REMARK) {
                return 'Order remark must be string';
            }

            if ($errorCode === self::$ORDER_BUYER_NOT_SET) {
                return 'Order buyer is not set';
            }

            if ($errorCode === self::$ISPAID_STATUS_NOT_SET) {
                return 'Order paid status is not set';
            }

            if ($errorCode === self::$INVALID_ISPAID_STATUS) {
                return 'Order paid status can have value 0 or 1, string type';
            }

            if ($errorCode === self::$PRODUCTS_NOT_SET) {
                return 'No product(s) in order';
            }

            if ($errorCode === self::$PRODUCT_NAME_NOT_SET) {
                return 'Prroduct name is not set';
            }

            if ($errorCode === self::$PRODUCT_NAME_INVALID_FORMAT) {
                return 'Prroduct name must be a string';
            }

            if ($errorCode === self::$PRODUCT_PRICE_NOT_SET) {
                return 'Prroduct price is not set';
            }

            if ($errorCode === self::$PRODUCT_PRICE_INVALID_FORMAT) {
                return 'Prroduct price must be integer or float greater than 0';
            }

            if ($errorCode === self::$PRODUCT_PRICE_VALUE) {
                return 'Prroduct price must be greater than 0';
            }

            if ($errorCode === self::$PRODUCT_QUANTITY_NOT_SET) {
                return 'Prroduct quantity is not set';
            }

            if ($errorCode === self::$PRODUCT_QUANTITY_INVALID_FORMAT) {
                return 'Prroduct quantity must be integer greater than 0';
            }

            if ($errorCode === self::$PRODUCT_QUANTITY_VALUE) {
                return 'Prroduct quantity must be greater than 0';
            }

            if ($errorCode === self::$ORDER_INSERT_FAILED_ON_PRODUCT_INSERT) {
                return 'Order insert failed';
            }

            if ($errorCode === self::$VENDOR_DELIVERY_SERVICE_FEE_NOT_SET) {
                return 'Order insert failed. Vendor delivery servicefee and(or) amount are not set';
            }

            if ($errorCode === self::$VENDOR_PICKUP_SERVICE_FEE_NOT_SET) {
                return 'Order insert failed. Vendor pickup servicefee and(or) amount are not set';
            }

            if ($errorCode === self::$PRODUCT_REMARK_INVALID) {
                return 'Product remark must be string';
            }

            if ($errorCode === self::$ORDER_FAILED_ON_INSERT_IN_DB) {
                return 'Order insert failed';
            }

            if ($errorCode === self::$ORDER_FAILED_ON_INSERT_ORDEREX) {
                return 'Order insert failed';
            }
        }
    }
