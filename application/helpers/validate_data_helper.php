<?php
    /**
     * File contains class ValidateData
     */
    declare(strict_types=1);

	if (!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * ValidateData class
     * 
     * ValidateData class contains public static methods for data validation.
     */
    Class Validate_data_helper
    {
        
        /**
         * validateString
         * 
         * Method validates string. It returns true if argument is number
         * or argument is a type of string and has at least one character that is not empty space,
         * else it returns false.
         * 
         * @access public
         * @static
         * @param $string Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validateString($string): bool
        {
            if (is_bool($string)) return false;
            if (self::validateNumber($string)) return true;
            if (gettype($string) === 'string' && trim($string)) return true;
            return false;
        }

        /**
         * validateString
         * 
         * Method validates string. It returns true if argument is number
         * or argument is a type of string and has at least one character that is not empty space,
         * else it returns false.
         * 
         * @access public
         * @static
         * @param $string Argument is required.
         * @param int $minLength Argument is optional, default value is 0.
         * @return bool Method returns true or false.
         */
        public static function validateStringImproved($string, int $minLength = 0): bool
        {
            if (!is_string($string)) return false;            
            return (strlen(trim($string)) >= $minLength) ? true : false;
        }

        /**
         * validateInteger
         * 
         * Method validates integer. It returns true if argument is integer or 0, else it returns false.
         * It uses filter_var() php internal function with FILTER_VALIDATE_INT filter.
         * 
         * @link https://www.php.net/manual/en/filter.filters.validate.php
         * @access public
         * @static
         * @param $integer Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validateInteger($integer): bool
        {
            if (is_bool($integer) || is_null($integer)) return false;
            if (filter_var($integer, FILTER_VALIDATE_INT) === 0 || filter_var($integer, FILTER_VALIDATE_INT)) {
                return true;
            }
            return false;
        }

        /**
         * validateFloat
         * 
         * Method validates float. It returns true if argument is float or 0.0, else it returns false.
         * It uses filter_var() php internal function with FILTER_VALIDATE_FLOAT filter.
         * 
         * @link https://www.php.net/manual/en/filter.filters.validate.php
         * @access public
         * @static
         * @param $float Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validateFloat($float): bool
        {
            if (is_bool($float) || is_null($float)) return false;
            if (filter_var($float, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($float, FILTER_VALIDATE_FLOAT)) {
                return true;
            }
            return false;
        }

        /**
         * validateNumber
         * 
         * Method validates number. It returns true if argument is integer, float, 0 or 0.0, else it returns false.
         * It uses ValidateData::validateInteger($number) and ValidateData::validateFloat($number) methods.
         * 
         * @access public
         * @static
         * @param $number Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validateNumber($number): bool
        {
            if (self::validateInteger($number) || self::validateFloat($number)) {
                return true;
            }
            return false;
        }

        /**
         * validateEmail
         * 
         * Method validates email. It returns true if argument is valid email, else it returns false.
         * It uses filter_var() php internal function with FILTER_VALIDATE_EMAIL filter.
         * 
         * @link https://www.php.net/manual/en/filter.filters.validate.php
         * @access public
         * @static
         * @param $email Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validateEmail(string $email): bool
        {
            return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
        }

        /**
         * validatePassword
         * 
         * Method validates password. 
         * Password must have ten or more characters, at least one number and at least one upper case.
         * It returns true if all conditions are met, else it returns false.
         * 
         * @access public
         * @static
         * @param string $password Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validatePassword(string $password, int $passwordLength): bool
        {
            if ( strlen($password) >= $passwordLength && strpbrk($password, '0123456789') && strtolower($password) !== $password ) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * validateDate
         * 
         * Method validates date. It returns true if argument is valid date, else it returns false.
         * 
         * @access public
         * @static
         * @param string $date Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validateDate(string $date): bool
        {
            $date = trim($date);
            return strtotime($date) ? true : false;
        }

        public static function validateMobileNumber(string $mobile): bool
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            return strlen(trim($mobile)) >= $CI->config->item('minMobileLength') && is_numeric($mobile) ? true : false;
        }

        public static function filterDataArray(array $data): array
        {
            $filter = array_filter($data, function($value, $key) {
                if (self::validateNumber($value) || $value) {
                    return [$key => $value];
                }
            }, ARRAY_FILTER_USE_BOTH);

            return $filter;
        }
    }
