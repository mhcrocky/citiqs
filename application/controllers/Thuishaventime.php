<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Thuishaventime extends BaseControllerWeb
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

    public function index($choice)
    {

    	if(!isset($_SESSION['customer'])){
    		redirect('https://tiqs.com/spot/thuishavenagenda/1');
		}else{
			$customer = $_SESSION['customer'];
		}
		if(!isset($_SESSION['eventdate'])){
			redirect('https://tiqs.com/spot/thuishavenagenda/1');
		}
		if(!isset($_SESSION['eventid'])){
			redirect('https://tiqs.com/spot/thuishavenagenda/1');
		}
		$customer = $_SESSION['customer'];
		$eventdate = $_SESSION['eventdate'];
		$eventid = $_SESSION['eventid'];

//		$buyer = $_SESSION['buyer'];

    	if($choice == 2){
    		$price=10;
			$Spotlabel = '2 persoonstafel';
			$numberofpersons = '2';
		}
		if($choice == 3){
			$price=150;
			$Spotlabel = 'max 15 personen terras';
			$numberofpersons = '15';
		}
		if($choice == 4){
			$price=20;
			$Spotlabel = '4 persoonstafel';
			$numberofpersons = '4';
		}

		$_SESSION['price'] = [
			'price' => $price,
			'SpotId' => $choice,
			'Spotlabel' => $Spotlabel,
			'numberofpersons' => $numberofpersons,
			'reservationset' => '1'
		];

		$labelinfo = $_SESSION['price'];

		$resultcount = $this->bookandpay_model->countreservationsinprogress($choice,$customer,$eventdate);

		if($choice == 2){
			$price=10;
			$Spotlabel = '2 persoonstafel';
			$numberofpersons = '2';
		}
		if($choice == 3){
			$price=150;
			$Spotlabel = 'max 15 personen terras';
			$numberofpersons = '15';
		}
		if($choice == 4){
			$price=20;
			$Spotlabel = '4 persoonstafel';
			$numberofpersons = '4';
		}

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

		$labelinfo['customer']= $customer;
		$labelinfo['eventid']= $eventid;

		$labelinfo['eventdate']= date("yy-m-d", strtotime($eventdate));

		// create new id for user of this session

		$result = $this->bookandpay_model->newbooking($labelinfo);

		if(empty($result)){
			// someting went wrong.
		}


		// per type
		$reservedspot2 = $this->bookandpay_model->countreservationsinprogress(2,$customer,$eventdate);
		if ($reservedspot2  >=75){
			$data['spot2']="soldout";
		} else{
			$data['spot2']="open";
		}

		$reservedspot4 = $this->bookandpay_model->countreservationsinprogress(4,$customer,$eventdate);
		// set value to 225
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



		// Per type,time
		$reservedspot2 = $this->bookandpay_model->countreservationsinprogresstime(2,1,$customer,$eventdate);
		if ($reservedspot2 >=15){
			$data['spot2t1']="soldout";
		} else{
			$data['spot2t1']="open";
		}

		$reservedspot2 = $this->bookandpay_model->countreservationsinprogresstime(2,2,$customer,$eventdate);
		if ($reservedspot2 >=15){
			$data['spot2t2']="soldout";
		} else{
			$data['spot2t2']="open";
		}

		$reservedspot2 = $this->bookandpay_model->countreservationsinprogresstime(2,3,$customer,$eventdate);
		if ($reservedspot2 >=15){
			$data['spot2t3']="soldout";
		} else{
			$data['spot2t3']="open";
		}

		$reservedspot2 = $this->bookandpay_model->countreservationsinprogresstime(2,4,$customer,$eventdate);
		if ($reservedspot2  >=15){
			$data['spot2t4']="soldout";
		} else{
			$data['spot2t4']="open";
		}

		$reservedspot2 = $this->bookandpay_model->countreservationsinprogresstime(2,5,$customer,$eventdate);
		if ($reservedspot2 >=15){
			$data['spot2t5']="soldout";
		} else{
			$data['spot2t5']="open";
		}


		$reservedspot4 = $this->bookandpay_model->countreservationsinprogresstime(4,1,$customer,$eventdate);
		// ste value to 45
		if ($reservedspot4  >=45){
			$data['spot4t1']="soldout";
		} else{
			$data['spot4t1']="open";
		}

		$reservedspot4 = $this->bookandpay_model->countreservationsinprogresstime(4,2,$customer,$eventdate);
		if ($reservedspot4  >=45){
			$data['spot4t2']="soldout";
		} else{
			$data['spot4t2']="open";
		}

		$reservedspot4 = $this->bookandpay_model->countreservationsinprogresstime(4,3,$customer,$eventdate);
		if ($reservedspot4 >=45){
			$data['spot4t3']="soldout";
		} else{
			$data['spot4t3']="open";
		}

		$reservedspot4 = $this->bookandpay_model->countreservationsinprogresstime(4,4,$customer,$eventdate);
		if ($reservedspot4 >=45){
			$data['spot4t4']="soldout";
		} else{
			$data['spot4t4']="open";
		}

		$reservedspot4 = $this->bookandpay_model->countreservationsinprogresstime(4,5,$customer,$eventdate);
		if ($reservedspot4 >=45){
			$data['spot4t5']="soldout";
		} else{
			$data['spot4t5']="open";
		}

		$reservedspot3 = $this->bookandpay_model->countreservationsinprogresstime(3,1,$customer,$eventdate);
		if ($reservedspot3 >=1){
			$data['spot3t1']="soldout";
		} else{
			$data['spot3t1']="open";
		}

		$reservedspot3 = $this->bookandpay_model->countreservationsinprogresstime(3,2,$customer,$eventdate);
		if ($reservedspot3  >=1){
			$data['spot3t2']="soldout";
		} else{
			$data['spot3t2']="open";
		}

		$reservedspot3 = $this->bookandpay_model->countreservationsinprogresstime(3,3,$customer,$eventdate);
		if ($reservedspot3 >=1){
			$data['spot3t3']="soldout";
		} else{
			$data['spot3t3']="open";
		}


		$reservedspot3 = $this->bookandpay_model->countreservationsinprogresstime(3,4,$customer,$eventdate);
		if ($reservedspot3  >=1){
			$data['spot3t4']="soldout";
		} else{
			$data['spot3t4']="open";
		}


		$reservedspot3 = $this->bookandpay_model->countreservationsinprogresstime(3,5,$customer,$eventdate);
		if ($reservedspot3 >=1){
			$data['spot3t5']="soldout";
		} else{
			$data['spot3t5']="open";
		}

//		$_SESSION['ReservationId'] = $result->reservationId;

		$data['count'] = $resultcount;
		$this->global['pageTitle'] = 'TIQS : BOOKINGS';
//		var_dump($data);
//		die();
        $this->loadViews("thuishaven".$choice, $this->global, $data, 'nofooter', 'noheader');
    }

    public function booking()
	{

		$timeslot = $this->security->xss_clean($this->input->post('radio-group'));

//		var_dump($timeslot);
//		die();

		if($timeslot== 1) {
		$from = "12:00";
		$to = "14:15";
		}
		elseif($timeslot== 2){
		$from = "14:30";
		$to = "16:45";
		}

		elseif($timeslot==3){
		$from = "17:00";
		$to = "19:15";
		}

		elseif($timeslot==4){
		$from = "19:30";
			$to = "21:45";
		}

		elseif($timeslot==5) {
		$from = "22:00";
		$to = "00:15";
		}

		$_SESSION['reservation_data'] = [
			'numberofpersons' => $_SESSION['price']['numberofpersons'],
			'SpotId' =>  $_SESSION['price']['SpotId'],
			'Spotlabel' => $_SESSION['price']['Spotlabel'],
			'timefrom' => $from,
			'price' => $_SESSION['price']['price'],
			'timeto' => $to,
			'timeslot' => $timeslot
		];

		$result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);
		if(empty($result)){
			redirect('thuishaven');
		}
		// time set in db
		$data = $_SESSION['reservation_data'];
//		var_dump($data);
//		die();
		$result = $this->bookandpay_model->editbookandpay($data, $_SESSION['ReservationId']);
		$result = $this->bookandpay_model->getReservationId($_SESSION['ReservationId']);

		$data = array(
			'Spotlabel' => '2 Persoonstafel',
			'price' => 10,
			'timeto' =>'12:00',
			'timefrom' => '13:00',
			'numberofpersons' => 2
		);

		$this->loadViews("thuishavennexttimeslot", $this->global, $data, 'nofooter', 'noheader'); // payment screen

	}

}

