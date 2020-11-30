<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Testscreen extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('language', array('controller' => $this->router->class));
		$this->load->library('notificationvendor');
	}

    public function index()
    {
//        $this->global['pageTitle'] = 'TIQS : TESTSCREEN';
//        $amount=10;
//        $description="";
//        $data = array(
//        	'amount' => $amount,
//
//	'description' =>'testscreen'
//		);
		$this->notificationvendor->sendVendorMessage();

//		$this->loadViews("paysuccesslinkth", $this->global, $data, NULL); // payment screen
//		$this->loadViews("checkLabelregisterednew", $this->global, NULL, NULL); // payment screen
//		$this->loadViews("newregisteredhotelinfo", $this->global, NULL, NULL);
//		$this->loadViews("nolabels", $this->global, NULL, NULL); // payment screen
//		$data =array('code'=>'tesscreen', 'token'=>'121212','userId'=> '1');
//		$this->loadViews("bagit", $this->global, $data, NULL); // payment screen
//		$this->loadViews("ordernewtiqsbags", $this->global, NULL, NULL); // payment screen
//		$this->loadViews("homenew", $this->global, NULL, NULL); // payment screen

//        $data = array(
//        	'Spotlabel' => '2 Persoonstafel',
//        	'price' => 10,
//			'timeto' =>'12:00',
//			'timefrom' => '13:00',
//			'numberofpersons' => 2
//		);
//
//		$this->loadViews("Dashboard", $this->global, $data, 'nofooter', 'headerDashboard'); // payment screen

	}

}

