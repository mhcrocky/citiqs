<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Whatislostisfound extends BaseControllerWeb {

    public function __construct() {
        parent::__construct();
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->model('whatislostisfound_model');
    }

    public function index() {
        $hotelsNamesCoordinates = $this->whatislostisfound_model->getUsers();
        $listHotels = [];
        foreach ($hotelsNamesCoordinates as $hotelNameCoordinate) {
            $hotels = new stdClass;
            $georesult = $this->tiqsgeocode($hotelNameCoordinate->address." ".$hotelNameCoordinate->zipcode." ".$hotelNameCoordinate->city." ".$hotelNameCoordinate->country);
                if($georesult["lat"]!=0){
                    $geolat = $georesult["lat"];
                    $geolong = $georesult["long"];
                    $hotels->lat = $geolat;
                    $hotels->lng = $geolong;
                }
            $nbrItemsFound = $this->whatislostisfound_model->getUserFoundItems($hotelNameCoordinate->id);//In case of Hotel, user id and hotel (found) id are the same.
            $hotels->id = $hotelNameCoordinate->id;
            $hotels->username = $hotelNameCoordinate->username;
            $hotels->lostfounditems = $nbrItemsFound;
            array_push($listHotels, $hotels);
        }
        $data['hotels'] = json_encode($listHotels, true);
        $this->global['pageTitle'] = 'TIQS : MAP';
        $this->loadViews("map", $this->global, $data, NULL);
    }


    public function tiqsgeocode($address)
    {

        // url encode the address
        $address = urlencode($address);

        // google map geocode api url
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyCst0EJ-LFVj3q0a6NHGFDU6HQ10H84HTI";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);

        // response status will be 'OK', if able to geocode given address
        if ($resp['status'] == 'OK') {

            // get the important data
            $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
            $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
            $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";

            // verify if data is complete
            if ($lati && $longi && $formatted_address) {

                // put the data in the array
                $data_arr = array("lat" => $lati, "long" => $longi, "address" => $formatted_address);
                return $data_arr;

            } else {

				$data_arr = array("lat" => 0, "long" => 0, "address" => $formatted_address);
				return $data_arr;
            }

        } else {
			$data_arr = array("lat" => 0, "long" => 0, "address" =>"ERROR");
			return $data_arr;

        }
    }

    public function saveLocation() {
        if ($this->input->post()) {
            $recordId = $this->security->xss_clean($this->input->post('id'));
            $lat = $this->security->xss_clean($this->input->post('lat'));
            $lng = $this->security->xss_clean($this->input->post('lng'));
            $row = array(
                "lat" => number_format($lat, 6),
                "lng" => number_format($lng, 6)
            );
            $this->whatislostisfound_model->updateUser($row, $recordId);
        }
    }

}
