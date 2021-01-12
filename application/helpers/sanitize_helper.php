<?php
    declare(strict_types=1);
    /**
     * Sanitize_helper
     *
     * Sanitize_helper class contains public static methods that are used in whole application.
     *
     * @author Ante VIDOVIĆ <antevidovic@gmail.com>
     */
    Class Sanitize_helper
    {
        /**
         * sanitizeData
         *
         * Method sanitizes data to prevents XSS attack. It takes $data as argument.
         * It uses filter_var() php internal function with FILTER_SANITIZE_STRIPPED filter.
         * It returns $data if type of $data is string or is numeric, else it returns null.
         *
         * @static
         * @access public
         * @link https://www.php.net/manual/en/filter.filters.validate.php
         * @param string $data Argument is requried.
         * @return string|null Method returns string or null
         */
        public static function sanitizeData($data): ?string
        {
            if (is_string($data) || is_numeric($data)) {
                $CI =& get_instance();
                $CI->load->helper('validate_data_helper');

                $sanitizeData = (string) $data;
                $sanitizeData = filter_var($sanitizeData, FILTER_SANITIZE_STRIPPED);
                return $sanitizeData || Validate_data_helper::validateNumber($sanitizeData) ? $sanitizeData : null;
            }
            return null;
        }

        /**
         * sanitizeArray
         *
         * Method sanitizes all element of array to prevents XSS attack.  It takes $array as argument.
         * It will return new array only if all elements of passed array (key and values) are safe, else it returns null.
         * Method doesn't sanitze multidimensional array
         *
         * @static
         * @access public
         * @param array &$array Argument is requried.
         * @return array|null Method returns array or null.
         */
        public static function sanitizeArray(array $array): ?array
        {
            $return = [];
            foreach ($array as $key => $value) {
                $key = self::sanitizeData($key);
                $value = self::sanitizeData($value);
                if (is_null($key) || is_null($value))  return null;
                $return[$key] = $value;
            }
            return (!empty($return)) ? $return : null;
        }

        /**
         * sanitizePhpInput
         *
         * Method sanitize "php://input" to prevent XSS attack.
         *
         * @static
         * @access public
         * @return array|null
         */
        public static function sanitizePhpInput(): ?array
        {
            $CI =& get_instance();
            $data = trim(file_get_contents("php://input"));
            if (empty($data)) return null;
            $data = $CI->security->xss_clean($data);
            $data = json_decode($data, true);
            return $data;
        }

        // TO DO UPGRADE WITH PHP BUIL IN FILTERS
        public static function isValidMac($mac)
        {
            if (strlen($mac) != 17) return false;
            if ($mac[2] != ':' || $mac[5] != ':' || $mac[8] != ':'||
                $mac[11] != ':' || $mac[14] != ':') return false;
            if (substr($mac, 0, 5) != '00:11') return false;
            return true;
        }
    }
