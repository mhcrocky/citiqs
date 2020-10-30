<?php
declare(strict_types=1);

ini_set('memory_limit', '256M');

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ajaxdorian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('label_model');
        $this->load->model('user_model');
        $this->load->model('appointment_model');
        $this->load->model('uniquecode_model');
        $this->load->model('user_subscription_model');
        $this->load->model('dhl_model');
        $this->load->model('Bizdir_model');
        $this->load->model('floorplanareas_model');
        $this->load->model('floorplandetails_model');
        $this->load->model('shoporder_model');
        $this->load->model('shopspot_model');
        $this->load->model('shopcategory_model');
        $this->load->model('shopspotproduct_model');
        $this->load->model('shopproductex_model');
        $this->load->model('shopvendor_model');
        $this->load->model('shopvoucher_model');
        $this->load->model('shopsession_model');

        $this->load->helper('cookie');
        $this->load->helper('validation_helper');
        $this->load->helper('utility_helper');
        $this->load->helper('email_helper');
        $this->load->helper('google_helper');
        $this->load->helper('perfex_helper');
        $this->load->helper('curl_helper');
        $this->load->helper('dhl_helper');
        $this->load->helper('validate_data_helper');

        

        $this->load->library('session');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('form_validation');

        $this->load->config('custom');
    }

    
    public function getPlaceByLocation(){
        $location = $this->input->post('location');
        $range = $this->input->post('range');
        set_cookie('location', $location, (365 * 24 * 60 * 60));
        set_cookie('range', $range, (365 * 24 * 60 * 60));
        $coordinates = Google_helper::getLatLong($location);
        $lat = $coordinates['lat'];
        $long = $coordinates['long'];
        $data['directories'] = $this->Bizdir_model->get_bizdir_by_location(floatval($lat),floatval($long),$range);
        $result = $this->load->view('bizdir/place_card', $data,true);
        if( isset($result) ) {
            return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
            ->set_output(json_encode($result));
        } else {
            return $this->output
			->set_content_type('application/json')
			->set_status_header(500)
			->set_output(json_encode(array(
                'text' => 'Not Found',
                'type' => 'Error 404'
            )));
        }
		
    }
    
}