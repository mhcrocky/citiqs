<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Profile extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('language', array('controller' => $this->router->class));
     	$this->load->model('user_model');
		$this->load->helper('country_helper');
		$this->load->model('businesstype_model');
		$this->load->config('custom');
        $this->isLoggedIn();
    }

    public function index()
    {
    	$active="details";
		$this->global['pageTitle'] = $active == "details" ? 'tiqs : My Profile' : 'tiqs : Change Password';
		$this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
		$data = [
			'user' => $this->user_model,
			'active' => $active,
			'countries' => Country_helper::getCountries(),
			'action' => 'profileUpdate',
			'businessTypes' => $this->businesstype_model->getAll(),
			'starterzero' => $this->config->item('starterzero'),
			'starter' => $this->config->item('starter'),
			'basic' => $this->config->item('basic'),
			'YEARLY_200_500' => $this->config->item('YEARLY_200_500'),
			'MONTHLY_200_500' => $this->config->item('MONTHLY_200_500'),
			'YEARLY_500_999' => $this->config->item('YEARLY_500_999'),
			'MONTHLY_500_999' => $this->config->item('MONTHLY_500_999'),
			'YEARLY_1000_1999' => $this->config->item('YEARLY_1000_1999'),
			'MONTHLY_1000_1999' => $this->config->item('MONTHLY_1000_1999'),
			'YEARLY_2000_2999' => $this->config->item('YEARLY_2000_2999'),
			'MONTHLY_2000_2999' => $this->config->item('MONTHLY_2000_2999'),
			'YEARLY_3000_3999' => $this->config->item('YEARLY_3000_3999'),
			'MONTHLY_3000_3999' => $this->config->item('MONTHLY_3000_3999'),
			'YEARLY_4000_4999' => $this->config->item('YEARLY_4000_4999'),
			'MONTHLY_4000_4999' => $this->config->item('MONTHLY_4000_4999'),
			'YEARLY_200_500_PRICE' => $this->config->item('YEARLY_200_500_PRICE'),
			'MONTHLY_200_500_PRICE' => $this->config->item('MONTHLY_200_500_PRICE'),
			'YEARLY_500_999_PRICE' => $this->config->item('YEARLY_500_999_PRICE'),
			'MONTHLY_500_999_PRICE' => $this->config->item('MONTHLY_500_999_PRICE'),
			'YEARLY_1000_1999_PRICE' => $this->config->item('YEARLY_1000_1999_PRICE'),
			'MONTHLY_1000_1999_PRICE' => $this->config->item('MONTHLY_1000_1999_PRICE'),
			'YEARLY_2000_2999_PRICE' => $this->config->item('YEARLY_2000_2999_PRICE'),
			'MONTHLY_2000_2999_PRICE' => $this->config->item('MONTHLY_2000_2999_PRICE'),
			'YEARLY_3000_3999_PRICE' => $this->config->item('YEARLY_3000_3999_PRICE'),
			'MONTHLY_3000_3999_PRICE' => $this->config->item('MONTHLY_3000_3999_PRICE'),
			'YEARLY_4000_4999_PRICE' => $this->config->item('YEARLY_4000_4999_PRICE'),
			'MONTHLY_4000_4999_PRICE' => $this->config->item('MONTHLY_4000_4999_PRICE'),
		];
		$this->loadViews("profile", $this->global, $data, NULL, 'headerwebloginhotelProfile'); // Menu profilepage

		//$this->loadViews("profile", $this->global, $data, NULL);
	    //    $this->global['pageTitle'] = 'TIQS : PROFILE';
		// 	$this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
		// 	$data = [
		// 		'user' => $this->user_model,
		// 		'active' => 'details',
		// 		'countries' => Country_helper::getCountries(),
		// 		'action' => 'profileUpdate',
		// 		'businessTypes' => $this->businesstype_model->getAll(),
		// 	];
		// 	$this->loadViews("profile", $this->global, $data, NULL, 'headerwebloginhotelProfile'); // Menu profilepage
    }

}

