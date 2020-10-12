<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Google_helper
    {

        public static function getLatLong(string $address, string $zipcode = '', string $city = '', string $country = ''): ?array
        {
            $resp = self::getGeoData($address, $zipcode, $city, $country);    
            // response status will be 'OK', if able to geocode given address
            if ($resp['status'] == 'OK') {    
                // get the important data
                $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
                $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
                $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";    
                // verify if data is complete
                if ($lati && $longi && $formatted_address) {    
                    // put the data in the array
                    $data_arr = array("lat" => $lati, "long" => $longi);
                    return $data_arr;
                } else {
                    return null;
                }
            } else {
                // put the data in the array
                $data_arr = array("lat" => "0", "long" => "0");
                return $data_arr;
            }
        }

        public static function getGeoData(string $address, string $zipcode = '', string $city = '', string $country = ''): array
        {
            // url encode the address
            $address = $address . " " . $zipcode . " " . $city . " " . $country;
            $address = urlencode($address);
    
            // google map geocode api url
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . self::getGoogleKey();
            // get the json response
            $resp_json = file_get_contents($url);
    
            // decode the json
            return json_decode($resp_json, true);
        }

        public static function getTimeZone(string $lat, string $lng): array
        {
            $location =  $lat . ',' . $lng;
            // google map geocode api url
            $url = 'https://maps.googleapis.com/maps/api/timezone/json?location=' . $location . '&timestamp=' . time() . '&key=' . self::getGoogleKey();
            // get the json response
            $resp_json = file_get_contents($url);    
            // decode the json
            return json_decode($resp_json, true);
        }

        public static function getGmtOffset(array $geoCoordinates): int
        {
            $gmtDtz = new DateTimeZone('Etc/GMT');
            $gmtDt = new DateTime("now", $gmtDtz);
            $result = Google_helper::getTimeZone(strval($geoCoordinates['lat']) , strval($geoCoordinates['long']));
            if ($result['status'] === 'OK') {
                $userDtz = new DateTimeZone($result['timeZoneId']);
                $userDt = new DateTime("now", $userDtz);
                $offset = ($userDtz->getOffset($userDt) - $gmtDtz->getOffset($gmtDt))  / 3600;
                return $offset;
            }
            return 0;
        }

        public static function getAddress(float $lat, float $lng): string
        {
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&key=' . self::getGoogleKey();
            $json = @file_get_contents($url);
            $data = json_decode($json);
            if($data->status === "OK") {
                return $data->results[0]->formatted_address;
            }
            return '';
        }

        public static function getDistance(array $pointeOne, array $pointTwo) : ?array
        {
            $url  = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=';
            $url .= '&origins=' . $pointeOne['lat'] .',' . $pointeOne['lng'];
            $url .= '&destinations=' . $pointTwo['lat'] .',' . $pointTwo['lng'];
            $url .= '&key=' . self::getGoogleKey();

            // get the json response            
            $data = file_get_contents($url);
            $data = json_decode($data, true);

            if ($data['status'] === 'OK' && $data['rows'][0]['elements'][0]['status'] === 'OK') {
                return $data['rows'][0]['elements'][0];
            }
            return null;
        }

        public static function getGoogleKey(): string
        {
            return 'AIzaSyCst0EJ-LFVj3q0a6NHGFDU6HQ10H84HTI';
        }
    }


    #https://maps.googleapis.com/maps/api/distancematrix/json?units=&origins=40.6655101,-73.89188969999998&destinations=40.6905615,12&key=AIzaSyCst0EJ-LFVj3q0a6NHGFDU6HQ10H84HTI