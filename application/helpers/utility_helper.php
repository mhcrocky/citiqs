<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Utility_helper
    {
        public static function shuffleString(int $range): string
        {
            $set = '3456789abcdefghjkmnpqrstvwxyABCDEFGHJKLMNPQRSTVWXY';
            return substr(str_shuffle($set), 0, $range);
        }

        public static function changeClaimCheckoutView(string $businessTypeId): string
        {
            switch ($businessTypeId) {
                case '1':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'airbnb';
                    break;
                case '2':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'amusementPark';
                    break;
                case '3':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'aviation';
                    break;
                case '4':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'businessToBusiness';
                    break;
                case '5':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'bar';
                    break;
                case '6':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'camping';
                    break;
                case '7':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'carRental';
                    break;
                case '8':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'club';
                    break;
                case '9':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'event';
                    break;
                case '10':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'eventHall';
                    break;
                case '11':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'festival';
                    break;
                case '12':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'hotel';
                    break;
                case '13':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'mall';
                    break;
                case '14':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'movieTheater';
                    break;
                case '15':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'municipality';
                    break;
                case '16':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'museum';
                    break;
                case '17':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'publicTransport';
                    break;
                case '18':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'restaurant';
                    break;
                case '19':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'school';
                    break;
                case '20':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'sport';
                    break;
                case '21':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'storeAndMarket';
                    break;
                case '22':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'theater';
                    break;
                case '23':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'tourOperator';
                    break;
                case '24':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'transport';
                    break;
                case '25':
                    $view = 'claimcheckout' . DIRECTORY_SEPARATOR . 'university';
                    break;
                default:
                    $view = 'claimcheckout';
                    break;
            }
            return $view;            
        }

        public static function getDhlShipmentDate(): string
        {
            $date = date('Y-m-d', strtotime('+3 days'));
            $timestamp = strtotime($date);
            $weekday= date("l", $timestamp );
            if ($weekday === "Saturday") {
                return date('Y-m-d', strtotime($date . " + 2 days"));
            } elseif ($weekday === "Sunday") {  
                return date('Y-m-d', strtotime($date . " + 1 day"));
            }
            return $date;      
        }

        public static function getMondayIwWeekendDay(string $date): string
        {
            $timestamp = strtotime($date);
            $weekday= date("l", $timestamp );
            if ($weekday === "Saturday") {
                return date('Y-m-d h:i:s', strtotime($date . " + 2 days"));
            } elseif ($weekday === "Sunday") {  
                return date('Y-m-d h:i:s', strtotime($date . " + 1 day"));
            }
            return $date;      
        }

        public static function resetArrayByKeyMultiple(array $arrays, string $key): array
        {
            if (empty($arrays)) return [];
            $reset = [];
            foreach($arrays as $array) {
                if (!isset($reset[$array[$key]])) {
                    $reset[$array[$key]] = [];
                }
                array_push($reset[$array[$key]], $array);
            }
            return $reset;
        }

        /**
         * compareTwoDates
         * 
         * Checks is first date less or equal to second date. Returns true if it is, else false.
         *
         * @param string $firtsDate
         * @param string $secondDate
         * @param boolean $equal
         * @return boolean
         */
        public static function compareTwoDates(string $firtsDate, string $secondDate, bool $equal = true): bool
        {
            $firtsDate = strtotime($firtsDate);
            $secondDate = strtotime($secondDate);

            if ($equal) {
                return ($firtsDate <= $secondDate);
            }
            return ($firtsDate < $secondDate);
            
        }

        public static function getSessionValue(string $key)
        {
            if (isset($_SESSION[$key])) {
                $return = $_SESSION[$key];
                unset($_SESSION[$key]);
                return $return;
            }
            return null;
            
        }

        // Return empty string if invalid UTF8 string
        public static function check_invalid_utf8($string)
        {
            $string = (string) $string;
            if (0 === strlen( $string )) return '';
            // Check for support for utf8 in the installed PCRE library once and store the result in a static
            static $utf8_pcre = null;
            if (!isset( $utf8_pcre )) $utf8_pcre = @preg_match('/^./u', 'a');
            // We can't demand utf8 in the PCRE installation, so just return the string in those cases
            if (!$utf8_pcre) return $string;
            // preg_match fails when it encounters invalid UTF8 in $string
            if (1 === @preg_match('/^./us', $string)) return $string;
            return '';
        }

        public static function logMessage(string $file, string $message): int
        {
            $message = date('Y-m-d H:i:s') . ' => ' . $message . PHP_EOL;
            return file_put_contents($file, $message, FILE_APPEND);
        }

        public static function getPaginationLinks(int $count, int $perPage, $url) {
            if (!$count) return '';

            $config['base_url'] = base_url() . $url;
            $config['total_rows'] = $count;
            $config['per_page'] = $perPage;
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'offset';

            $CI =& get_instance();
            $CI->load->library('pagination');
            $CI->pagination->initialize($config);

            return $CI->pagination->create_links();
        }

        public static function array_sort_by_column(&$arr, $col, $dir = SORT_ASC)
        {
            $sort_col = array();
            foreach ($arr as $key=> $row) {
                $sort_col[$key] = $row[$col];
            }
            array_multisort($sort_col, $dir, $arr);
        }
    }
