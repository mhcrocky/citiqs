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
		$this->load->helper('country_helper');
		$this->load->helper('utility_helper');
		
		$this->load->model('user_model');
		$this->load->model('businesstype_model');
		$this->load->model('subscription_model');		
		$this->load->model('user_subscription_model');
		$this->load->model('label_model');
		
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));

		$this->isLoggedIn();
	}

	public function index()
	{
		$active="details";
		$this->global['pageTitle'] = $active == "details" ? 'tiqs : My Profile' : 'tiqs : Change Password';
		$this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();

		$subscriptionWhat = ['id', 'short_description', 'description', 'ROUND(amount, 2) AS amount', 'active', 'tiqssendcom', 'backOfficeItemId', 'type'];
		$data = [
			'user' => $this->user_model,
			'active' => $active,
			'countries' => Country_helper::getCountries(),
			'action' => 'profileUpdate',
			'businessTypes' => $this->businesstype_model->getAll(),
			'subscriptions' => 	Utility_helper::resetArrayByKeyMultiple($this->subscription_model->select($subscriptionWhat), 'type'),
			'userSubscription' => $this->user_subscription_model->getLastSubscriptionId($this->userId),	
		];

		$this->loadViews("profile", $this->global, $data, NULL, 'headerwebloginhotelProfile'); // Menu profilepage
	}

}
