<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Thuishaven extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
		$this->load->model('bookandpay_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index($eventdate, $eventid)
    {
//    	var_dump($eventdate);
//		var_dump($eventid);
//		die();
//
    	if(empty($eventdate))
		{
			redirect('thuishavenagenda/1');
		}

		$_SESSION['eventid']= $eventid;
		$_SESSION['eventdate']=date('d.m.yy', Date(strtotime($eventdate)));

		$customer = $_SESSION['customer'];
		$eventdate = $_SESSION['eventdate'];
		$eventid = $_SESSION['eventid'];


		// check of event date exists.. for spoofing?

		$data['spot2']="soldout";
		$data['spot4']="soldout";
		$data['spot3']="soldout";

		$data['spot2t1']="soldout";
		$data['spot2t2']="soldout";
		$data['spot2t3']="soldout";
		$data['spot2t4']="soldout";
		$data['spot2t5']="soldout";

		$data['spot4t1']="soldout";
		$data['spot4t2']="soldout";
		$data['spot4t3']="soldout";
		$data['spot4t4']="soldout";
		$data['spot4t5']="soldout";

		$data['spot3t1']="soldout";
		$data['spot3t2']="soldout";
		$data['spot3t3']="soldout";
		$data['spot3t4']="soldout";
		$data['spot3t5']="soldout";
		// alles


		$reservednow = $this->bookandpay_model->countreservationsinprogresoverall($customer,$eventdate);

		// overall
		if ($reservednow >=302){
			redirect('soldout');
		}

		// per type
		$reservedspot2 = $this->bookandpay_model->countreservationsinprogress(2,$customer,$eventdate);
		// needs to be 75
		if ($reservedspot2  >=75){
			$data['spot2']="soldout";
		} else{
			$data['spot2']="open";
		}

		$reservedspot4 = $this->bookandpay_model->countreservationsinprogress(4,$customer,$eventdate);
		if ($reservedspot4 >=225){
			$data['spot4']="soldout";
		} else{
			$data['spot4']="open";
		}

		$reservedspot3 = $this->bookandpay_model->countreservationsinprogress(3,$customer,$eventdate);
		if ($reservedspot3 >=5){
			$data['spot3']="soldout";
		} else{
			$data['spot3']="open";
		}

		$data["eventdate"] = $eventdate;
		$data["eventid"] = $eventid;

//		var_dump($data);
//		die();

		$this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->loadViews("thuishaven", $this->global, $data, 'nofooter', 'noheader');
    }

}

