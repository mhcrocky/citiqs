<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Info_spot extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('subscription_model');
        $this->load->helper('utility_helper');
        $this->load->helper('url');

        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index()
    {
        $this->global['pageTitle'] = 'TIQS : SPOT';
		$subscriptionWhat = ['id', 'short_description', 'description', 'ROUND(amount, 2) AS amount', 'active', 'tiqssendcom', 'backOfficeItemId', 'type'];
//		$data = [
//			'subscriptions' => Utility_helper::resetArrayByKeyMultiple($this->subscription_model->select($subscriptionWhat), 'type')
//		];

		$data=array();

//		print("<pre>".print_r($data,true)."</pre>");
////		var_dump($data);
//		die();

        $this->loadViews("info_spot", $this->global, $data, NULL, "header_info_spot");
    }

}

