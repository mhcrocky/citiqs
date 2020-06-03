<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  ThuishavenDay extends BaseControllerWeb
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

    public function index($datum)
    {

    	$data['date']=$datum;

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


		$reservednow = $this->bookandpay_model->countreservationsinprogresoverall();

		// overall
		if ($reservednow >=302){
			redirect('soldout');
		}

		// per type
		$reservedspot2 = $this->bookandpay_model->countreservationsinprogress(2);
		// needs to be 75
		if ($reservedspot2  >=75){
			$data['spot2']="soldout";
		} else{
			$data['spot2']="open";
		}

		$reservedspot4 = $this->bookandpay_model->countreservationsinprogress(4);
		if ($reservedspot4 >=225){
			$data['spot4']="soldout";
		} else{
			$data['spot4']="open";
		}

		$reservedspot3 = $this->bookandpay_model->countreservationsinprogress(3);
		if ($reservedspot3 >=1){
			$data['spot3']="soldout";
		} else{
			$data['spot3']="open";
		}



        $this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->loadViews("thuishaven", $this->global, $data, 'nofooter', 'noheader');
    }

}

