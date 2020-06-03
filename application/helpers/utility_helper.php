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

    // public static function resetArrayByKey(array $array = [], string $resetKey): array
    // {
    //     if (empty($arrays)) return [];
    //     $reset = [];
    //     foreach($arrays as $key => $value) {
    //         if (!isset($reset[$value[$resetKey]])) {
    //             $reset[$value[$resetKey]] = [];                    
    //         }                
    //         $reset[$value[$resetKey]] = $value;
    //     }
    //     return $reset;
    // }

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

    }