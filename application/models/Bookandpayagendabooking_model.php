<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login_model (Login Model)
 * Login model class to get to authenticate user credentials
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */ 
class   Bookandpayagendabooking_model extends CI_Model
{

	public $uploadFolder = FCPATH . 'uploads/LabelImages';
	private function generalquery(){
		return " ".
			
			"AND eventdate >= CURDATE() AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00')
			".((isset($_GET["ids"]) && $_GET["ids"]!="" && $_GET["ids"]!="--")?" AND id='".$_GET["ids"]."'":"")." 
			".((isset($_GET['names']) && $_GET["names"]!="" && $_GET['names']!="--")?" AND name ='".$_GET["names"]."'":"")." 
			".((isset($_GET['customer']) && $_GET["customer"]!="" && $_GET['customer']!="--")?" AND customer ='".$_GET["customer"]."'":"")." 
			".((isset($_GET['eventid']) && $_GET["eventid"]!="" && $_GET['eventid']!="--")?" AND eventid ='".$_GET["eventid"]."'":"")." 
			".((isset($_GET['reservationId']) && $_GET["reservationId"]!="" && $_GET['reservationId'] !="--")?" AND reservationId ='".$_GET["reservationId"]."'":"")." 
			".((isset($_GET['bookdatetime']) && $_GET["bookdatetime"]!="" && $_GET['bookdatetime']!="--")?" AND bookdatetime ='".$_GET["bookdatetime"]."'":"")." 
			".((isset($_GET['SpotId']) && $_GET["SpotId"]!="" && $_GET['SpotId']!="--")?" AND SpotId ='".$_GET["SpotId"]."'":"")." 
			".((isset($_GET['price']) && $_GET["price"]!="" && $_GET['price']!="--")?" AND price ='".$_GET["price"]."'":"")." 
			".((isset($_GET['numberofpersons']) && $_GET["numberofpersons"]!="" && $_GET['numberofpersons']!="--")?" AND numberofpersons ='".$_GET["numberofpersons"]."'":"")." 
			".((isset($_GET['email']) && $_GET["email"]!="" && $_GET['email']!="--")?" AND email ='".$_GET["email"]."'":"")." 
			".((isset($_GET['mobilephone']) && $_GET["mobilephone"]!="" && $_GET['mobilephone']!="--")?" AND mobilephone ='".$_GET["mobilephone"]."'":"")." 
			".((isset($_GET['reservationset']) && $_GET["reservationset"]!="" && $_GET['reservationset']!="--")?" AND reservationset ='".$_GET["reservationset"]."'":"")." 
			".((isset($_GET['reservationtime']) && $_GET["reservationtime"]!="" && $_GET['reservationtime']!="--")?" AND reservationtime ='".$_GET["reservationtime"]."'":"")." 
			".((isset($_GET['timefrom']) && $_GET["timefrom"]!="" && $_GET['timefrom']!="--")?" AND timefrom <='".$_GET["timefrom"]."'":"")." 
			".((isset($_GET['timeto']) && $_GET["timeto"]!="" && $_GET['timeto']!="--")?" AND timeto >='".$_GET["timeto"]."'":"")." 
			".((isset($_GET['paid']) && $_GET["paid"]!="" && $_GET['paid']!="--")?" AND paid <='".$_GET["paid"]."'":"")." 
			".((isset($_GET['timeslot']) && $_GET["timeslot"]!="" && $_GET['timeslot']!="--")?" AND timeslot ='".$_GET["timeslot"]."'":"")." 
			".((isset($_GET['voucher']) && $_GET["voucher"]!="" && $_GET['voucher']!="--")?" AND voucher ='".$_GET["voucher"]."'":"")." 
			".((isset($_GET['TransactionID']) && $_GET["TransactionID"]!="" && $_GET['TransactionID']!="--")?" AND TransactionID ='".$_GET["TransactionID"]."'":"")."
			".((isset($_GET['bookingsequenceId']) && $_GET["bookingsequenceId"]!="" && $_GET['bookingsequenceId']!="--")?" AND bookingsequenceId ='".$_GET["bookingsequenceId"]."'":"")."
			".((isset($_GET['bookingsequenceamount']) && $_GET["bookingsequenceamount"]!="" && $_GET['bookingsequenceamount']!="--")?" AND bookingsequenceamount ='".$_GET["bookingsequenceamount"]."'":"")."
			".((isset($_GET['numberin']) && $_GET["numberin"]!="" && $_GET['numberin']!="--")?" AND numberin ='".$_GET["numberin"]."'":"")."
			".((isset($_GET['mailsend']) && $_GET["mailsend"]!="" && $_GET['mailsend']!="--")?" AND mailsend ='".$_GET["mailsend"]."'":"")." ";
	}
	//////Logic 2/////////////////
	function runquery($sql){
		$query = $this->db->query($sql);

		if($query) {
		    return $query->result_array();
        }
		return false;
	}

    function get_bookandpay_data()
    {
        $sql = "select * from tbl_bookandpay where timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00') AND eventdate >= CURDATE()";
        $query = $this->db->query($sql);

        if($query) {
            return $query->result_array();
        }
        return false;
    }

	function get_agenda($customer){
		// if(isset($_GET['datefrom']) && $_GET['datefrom']!=""){
		// 	$datefromquery=" eventdate >='".$_GET['datefrom']."'";
		// }else{
		// 	$datefromquery=" eventdate >= CURDATE()";
		// }
		// if(isset($_GET['dateto']) && $_GET['dateto']!=""){
		// 	$datetoquery=" AND eventdate <='".$_GET['dateto']."'";
		// }else{
		// 	$datetoquery=" ";
		// }
		// print_r($_GET);
		if(isset($_GET["eventdates"]))
		{
			$queryeventdate=implode(",", array_map(function($string) {
			return '"' . $string . '"';
			}, $_GET["eventdates"] ));
		}
		if(isset($_GET["Spotlabels"]))
		{
			$querySpotlabels=implode(",", array_map(function($string) {
			return '"' . $string . '"';
			}, $_GET["Spotlabels"] ));
		}
		// where ".$datefromquery.$datetoquery." AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00') 
		$sql="SELECT DATE(`ReservationDateTime`) as eventdate, eventid, COUNT(tbl_bookandpay.numberofpersons) as numberofpersons FROM tbl_bookandpayagenda LEFT JOIN tbl_bookandpay ON tbl_bookandpayagenda.id = tbl_bookandpay.eventid  ".
			// "where ".$datefromquery.$datetoquery." AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00') ".
			"where paid='1' AND  tbl_bookandpayagenda.Customer='$customer' AND SpotId <> '0'
			 GROUP BY tbl_bookandpayagenda.id ORDER BY eventdate asc";
		// die();


		$query = $this->db->query($sql);
		
		$data = $query->result_array();
		$newData = [];
		foreach ($data as $key => $value) {
			//$date=date('y-m-d', strtotime($value['eventdate']));
			//if($date!='70-01-01'){
				$newData[$key] = [
					"date" => $value['eventdate'],//$date,
					"numberofpersons" => (int)$value['numberofpersons'],
					"max" => (int)$this->get_timeslotMax_bydate($value['eventdate']),
					"scanned" => $this->get_scannedIn($customer,$value['eventid']),
				];
			//}
		}

		return $newData;
	}

	
	function copy_from_agenda($agendas,$agenda_id){
		$oldagendas = explode(',', $agendas);
		$this->db->select('*');
		$this->db->from('tbl_bookandpayspot');
		foreach($oldagendas as $key => $agenda){
			if($key == 0){
				$this->db->where('agenda_id',$agenda);
			} else {
				$this->db->or_where('agenda_id',$agenda);
			}
		}
		 
		$query = $this->db->get();
		$results = $query->result_array();
		$insertData = [];
		$spot_ids = [];
		$max_spots = intval($this->get_max_spots($agenda_id));
		$spots_count = intval($this->get_spot_count_by_agenda($agenda_id));
		foreach ($results as $result) {
			
			$diff = $max_spots - $spots_count;
			if($diff == 0){
				break;
			}

			$result['agenda_id'] = $agenda_id;
			$id = $result['id'];
			unset($result['id']);
			$insertData = $result;
			$this->db->insert('tbl_bookandpayspot', $insertData);
			$this->copy_timeslots($id, $this->db->insert_id());
			$spots_count++;
		}
	}

	function copy_timeslots($oldSpot,$spot_id){
		$this->db->select('*');
		$this->db->from('tbl_bookandpaytimeslots');
		$this->db->where('spot_id',$oldSpot);
		
		$query = $this->db->get();
		$results = $query->result_array();
		$insertData = [];
		foreach ($results as $result) {
			$result['spot_id'] = $spot_id;
			unset($result['id']);
			array_push($insertData, $result);
		}
		return $this->db->insert_batch('tbl_bookandpaytimeslots', $insertData);
	}

	function get_timeslotMax_bydate($eventdate){
		$sql = "SELECT 
		sum(tbl_bookandpaytimeslots.available_items) as timeslot_max
		FROM
		tbl_bookandpayagenda
		INNER JOIN
		tbl_bookandpayspot
		ON 
			tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id
		INNER JOIN
		tbl_bookandpaytimeslots
		ON 
			tbl_bookandpaytimeslots.spot_id = tbl_bookandpayspot.id
		WHERE tbl_bookandpayagenda.ReservationDateTime = '".$eventdate."'
		GROUP BY
		tbl_bookandpayagenda.ReservationDateTime";
		
		$query = $this->db->query($sql);
		$result = $query->row();
		return isset($result->timeslot_max) ? $result->timeslot_max : 0;

	}

	function save_agenda_booking_design($vendor_id,$data){
		$count = count($this->get_agenda_booking_design($vendor_id));
		if($count == 0){
			return $this->db->insert('tbl_agenda_booking_design', $data);
		} else {
			$this->db->set('design', $data['design']);
			$this->db->where('vendor_id', $vendor_id);
			return $this->db->update('tbl_agenda_booking_design');
		}
			
		
	}

	function update_reservation_amount($reservationId, $amount){
		$this->db->where('reservationId', $reservationId);
		$this->db->update('tbl_bookandpay',['amount' => $amount]);
		return true;
	}

	function get_agenda_booking_design($vendor_id){

		$this->db->select('design')
		->from('tbl_agenda_booking_design')
		->where('vendor_id',$vendor_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_devices(){
		$this->db->select('*')
		->from('tbl_devices_hw');
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_scannedIn($customer, $eventid = false, $spot_id = false, $timeslotId = false){
		$sql="SELECT SUM(numberin) as scannedin FROM tbl_bookandpay 
		WHERE paid='1' AND customer='$customer' AND SpotId <> '0' ";
		if($eventid){
			$sql .= " AND eventid='$eventid'";
			$group_by = " GROUP BY eventid";
		}
		if($spot_id){
		    $sql .= " AND SpotId='$spot_id'";
			$group_by = " GROUP BY SpotId";
		}
		if($timeslot)
		{
			$sql .= " AND timeslotId='$timeslotId'";
			$group_by = " GROUP BY timeslotId";
		}
		 $sql .= $group_by;
		
		$query = $this->db->query($sql);
		$result = $query->first_row();
		return isset($result->scannedin) ? intval($result->scannedin) : 0;

	}

	function get_numberofpersons($customer){

		if(isset($_GET["eventdates"]))
		{
			$queryeventdate=implode(",", array_map(function($string) {
			return '"' . $string . '"';
			}, $_GET["eventdates"] ));
		}
		if(isset($_GET["Spotlabels"]))
		{
			$querySpotlabels=implode(",", array_map(function($string) {
			return '"' . $string . '"';
			}, $_GET["Spotlabels"] ));
		}
		
		$sql="SELECT numberofpersons FROM tbl_bookandpayspot  ".
			
			"where customer=$customer ".
			((isset($queryeventdate))?" and eventdate in ($queryeventdate)":"").
			((isset($querySpotlabels))?" and Spotlabel in ($querySpotlabels)":"").
			$this->generalquery().
		" GROUP by eventdate ORDER BY eventdate asc";
		// die();


		$query = $this->db->query($sql);
		$data = $query->result_array();
		$newData = [];
		foreach ($data as $key => $value) {
			//$date=date('y-m-d', strtotime($value['eventdate']));
			//if($date!='70-01-01'){
				$newData[$key] = [
					"date" => $value['eventdate'],//$date,
					"numberofpersons" => (int)$value['numberofpersons'],
					"max" => (int)$this->get_timeslotMax_bydate($value['eventdate']),
				];
			//}
		}
		return $newData;
	}
	function get_spot_bydate2($date,$customer){
		if(isset($_GET["eventdates"]))
		{
			$queryeventdate=implode(",", array_map(function($string) {
			return '"' . $string . '"';
			}, $_GET["eventdates"] ));
		}
		if(isset($_GET["Spotlabels"]))
		{
			$querySpotlabels=implode(",", array_map(function($string) {
			return '"' . $string . '"';
			}, $_GET["Spotlabels"] ));
		}

		$sql = "SELECT DATE(`ReservationDateTime`) as eventdate, eventid, SpotId, Spotlabel, COUNT(tbl_bookandpay.numberofpersons) as totalpersons 
		FROM tbl_bookandpayagenda LEFT JOIN tbl_bookandpay ON tbl_bookandpayagenda.id = tbl_bookandpay.eventid  
		WHERE paid='1' AND tbl_bookandpayagenda.Customer='$customer' AND SpotId <> '0'
		GROUP by tbl_bookandpayagenda.id,SpotId ORDER BY eventdate asc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		$newData = [];
		foreach ($data as $key => $value) {
			if($value['eventdate'] != $date){
				continue;
			}

			$newData[$key] = [
				"spot_id"=>$value['SpotId'],
				"image" => $value['Spotlabel'],//str_replace(".png","",$value['image']),
				"numberofpersons" => (int)$value['totalpersons'],
				"max_items" => (int)$this->get_timeslot_count($value['SpotId']),
				"date"=>$value['eventdate'],
				"scanned" => $this->get_scannedIn($customer,$value['eventid'],$value['SpotId']),

			];
		}
		return $newData;
	}

	function get_timeslot_count($spot_id){
		$sql="SELECT sum(available_items) as max_items 
		FROM tbl_bookandpaytimeslots 
		WHERE spot_id = '$spot_id'
		GROUP BY spot_id";
		$query = $this->db->query($sql);
		$result = $query->row();
		return Isset($result->max_items) ? $result->max_items : 0;
	}

	function get_slot_byspotidDate($spot_id,$date){
		if(isset($_GET["eventdates"]))
		{
			$queryeventdate=implode(",", array_map(function($string) {
			return '"' . $string . '"';
			}, $_GET["eventdates"] ));
		}
		if(isset($_GET["Spotlabels"]))
		{
			$querySpotlabels=implode(",", array_map(function($string) {
			return '"' . $string . '"';
			}, $_GET["Spotlabels"] ));
		}
		$sql="SELECT CONCAT(`timefrom`, '-', `timeto`) as timediff, count(numberofpersons) as numberofpersons FROM tbl_bookandpay ".
		// " where SpotId='$spot_id' AND eventdate='$date' AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00') ".
		" where 1=1 AND SpotId='$spot_id' AND eventdate='$date' AND customer=1 ".
		((isset($queryeventdate))?" AND eventdate in ($queryeventdate)":"").
		((isset($querySpotlabels))?" AND Spotlabel in ($querySpotlabels)":"").
			$this->generalquery().
		 " GROUP by timediff";
		 // echo $sql;
		$query = $this->db->query($sql);
		$data = $query->result_array();
		$newData = [];
		foreach ($data as $key => $value)
		{
			$newData[$key] = [
				"timediff" => $value['timediff'],
				"numberofpersons" => (int)$value['numberofpersons'],
			];
		}
		// print_r($newData);die();
		return $newData;
	}

	function get_bookings_byspotidDate($spot_id,$date,$customer){
		if(isset($_GET["eventdates"]))
		{
			$queryeventdate=implode(",", array_map(function($string) {
			return '"' . $string . '"';
			}, $_GET["eventdates"] ));
		}
		if(isset($_GET["Spotlabels"]))
		{
			$querySpotlabels=implode(",", array_map(function($string) {
			return '"' . $string . '"';
			}, $_GET["Spotlabels"] ));
		}
		$sql="SELECT CONCAT(`timefrom`, '-', `timeto`) as timediff, timeslotId, eventid, email, count(numberofpersons) as numberofpersons,tbl_bookandpaytimeslots.available_items as max_items, eventdate FROM tbl_bookandpay,tbl_bookandpaytimeslots".
		// " where SpotId='$spot_id' AND eventdate='$date' AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00') ".
		" where tbl_bookandpay.timeslot=tbl_bookandpaytimeslots.id AND paid=1 AND SpotId='$spot_id' AND eventdate='$date' AND customer=$customer".
		((isset($queryeventdate))?" AND eventdate in ($queryeventdate)":"").
		((isset($querySpotlabels))?" AND Spotlabel in ($querySpotlabels)":"").
			$this->generalquery().
		 " GROUP by timediff";
		 // echo $sql;

		$query = $this->db->query($sql);
		$data = $query->result_array();
		$newData = [];
		foreach ($data as $key => $value)
		{
			$matched = 0;
			if($key != 0){
				$last = $key-1;
				$timediff1 = $data[$last]['timediff'];
				$timediff2 = $value['timediff'];
				$matched = $this->get_matchedEmails($spot_id,$date,$customer,$timediff1,$timediff2);
			}
			$max_items = $value['max_items']-$value['numberofpersons'];
			$numberofpersons = $value['numberofpersons']-$matched;
			$newData[$key] = [
				"timediff" => $value['timediff'],
				"numberofpersons" => (int)$numberofpersons,
				"max_items" => (int)$max_items,
				"matched" => (int)$matched,
				"scanned" => $this->get_scannedIn($customer,$value['eventid'],$spot_id,$value['timeslotId']),
				"total_persons" => (int)($value['numberofpersons']),
			];
		}
		// print_r($newData);die();
		return $newData;
	}


	function get_matchedEmails($spot_id,$date,$customer,$timediff1,$timediff2){
		$first_sql="SELECT email FROM tbl_bookandpay,tbl_bookandpaytimeslots 
		WHERE tbl_bookandpay.timeslot=tbl_bookandpaytimeslots.id AND paid=1 AND SpotId='$spot_id' AND eventdate='$date' 
		 AND customer=$customer AND CONCAT(`timefrom`, '-', `timeto`) ='$timediff1'";
		 $first_query = $this->db->query($first_sql);
		 $first_data = $first_query->result_array();
		 $second_sql="SELECT email FROM tbl_bookandpay,tbl_bookandpaytimeslots
		 WHERE tbl_bookandpay.timeslot=tbl_bookandpaytimeslots.id AND paid=1 AND SpotId='$spot_id' AND eventdate='$date' 
		 AND customer=$customer AND CONCAT(`timefrom`, '-', `timeto`) = '$timediff2'";
		 $second_query = $this->db->query($second_sql);
		 $second_data = $second_query->result_array();

		 $first_emails = [];
		 foreach($first_data as $key => $first){
			 $first_emails[] = $first['email'];
		 }

		 $second_emails = [];
		 foreach($second_data as $key => $first){
			 $second_emails[] = $first['email'];
		 }

		 $result = array_intersect(array_unique($first_emails), array_unique($second_emails));
		 return count($result);

	}

	//////Logic 1/////////////////
	function get_agenda_for_chart()
	{
		$sql="SELECT tbl_bookandpayagenda.ReservationDateTime, tbl_bookandpayspot.numberofpersons FROM tbl_bookandpayagenda RIGHT JOIN tbl_bookandpayspot ON tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id ORDER BY tbl_bookandpayagenda.ReservationDateTime asc";
		// $sql = "SELECT ReservationDateTime , visitor_count FROM tbl_bookandpayagenda";
		$query = $this->db->query($sql);

		$data = $query->result_array();

		$newData = [];
		foreach ($data as $key => $value) {
			$date=date('y-m-d', strtotime($value['ReservationDateTime']));
			if($date!='70-01-01'){
				$newData[$key] = [
					"date" => $date,
					"numberofpersons" => (int)$value['numberofpersons'],
				];
			}
		}
		// print_r($newData);die();
		return $newData;
	}

	function get_spot_bydate($date){
		$sql="SELECT tbl_bookandpayagenda.ReservationDateTime, tbl_bookandpayspot.numberofpersons, tbl_bookandpayspot.image, tbl_bookandpayspot.id as spot_id FROM tbl_bookandpayagenda RIGHT JOIN tbl_bookandpayspot ON tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id where DATE(tbl_bookandpayagenda.ReservationDateTime) ='$date' ORDER BY tbl_bookandpayagenda.ReservationDateTime asc";

		// $sql="SELECT tbl_bookandpayspot.image, tbl_bookandpayspot.id as spot_id, sum(tbl_bookandpayspot.numberofpersons) as numberofpersons FROM tbl_bookandpayagenda RIGHT JOIN tbl_bookandpayspot ON tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id where DATE(tbl_bookandpayagenda.ReservationDateTime) ='2020-06-30' GROUP BY tbl_bookandpayspot.image ORDER BY tbl_bookandpayagenda.ReservationDateTime DESC";

		$query = $this->db->query($sql);
		$data = $query->result_array();
		$newData = [];
		foreach ($data as $key => $value)
		{
			$newData[$key] = [
				"spot_id"=>$value['spot_id'],
				"image" => str_replace(".png","",$value['image']),
				"numberofpersons" => (int)$value['numberofpersons'],

			];
		}
		 // print_r($newData);die();
		return $newData;
	}
	function get_slot_byspotid($spot_id){
		// echo $spot_id;
		$sql="SELECT CONCAT(`fromtime`, '-', `totime`) as timediff, tbl_bookandpayspot.numberofpersons FROM tbl_bookandpaytimeslots LEFT JOIN tbl_bookandpayspot ON tbl_bookandpaytimeslots.spot_id = tbl_bookandpayspot.id where tbl_bookandpaytimeslots.spot_id='$spot_id' ";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		$newData = [];
		foreach ($data as $key => $value)
		{
			$newData[$key] = [
				"timediff" => $value['timediff'],
				"numberofpersons" => (int)$value['numberofpersons'],
			];
		}
		// print_r($newData);die();
		return $newData;
	}
	///////////////////////////
	public function getbookingagenda($customer)
	{
		$query = $this->db->query("SELECT `tbl_bookandpayagenda`.*, `tbl_email_templates`.`template_name`
		FROM `tbl_bookandpayagenda`
		LEFT JOIN `tbl_email_templates` ON `tbl_email_templates`.`id` = `tbl_bookandpayagenda`.`email_id`
		WHERE `Customer` = '".$customer."'
		AND `ReservationDateTime` >= '2021-05-30'
		AND `online` = 1
		ORDER BY `ReservationDateTime` ASC");

//		echo $this->db->last_query();exit;

		$result = $query->result();


		return $result;
	}

	public function getbookingspotagenda($customer, $agendaId)
	{
        $this->db->select('tbl_bookandpayagenda.*, tbl_email_templates.template_name');
		$this->db->from('tbl_bookandpayagenda');
        $this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpayagenda.email_id', 'left');
		$this->db->where('Customer', $customer);
		$this->db->where('tbl_bookandpayagenda.id', $agendaId);
		$this->db->where('ReservationDateTime >=', date("Y-m-d") );
		$this->db->order_by('ReservationDateTime', 'ASC');
		$query = $this->db->get();

//		echo $this->db->last_query();exit;

		$result = $query->result();

		return $result;
	}

	public function getbookingagendadate($customer)
	{
        $results = $this->getbookingagenda($customer);
		$agenda_dates = [];
		foreach($results as $result){
			$date_timestamp = $result->ReservationDateTime;
			$date_timestamp = explode(' ', $date_timestamp);
			$fulldate = $date_timestamp[0];
			$fulldate = explode('-', $fulldate);
			$dd = intval($fulldate[2]);
			$mm = intval($fulldate[1]);
			$yyyy = intval($fulldate[0]);
			$agenda_dates[] = $dd . '-' . $mm . '-' . $yyyy;
		}
		return $agenda_dates;
	}

	public function getbookingagendaall($customer)
	{
		$this->db->select('tbl_bookandpayagenda.*, tbl_email_templates.template_name');
		$this->db->from('tbl_bookandpayagenda');
		$this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpayagenda.email_id', 'left');
		$this->db->where('Customer', $customer);
		$this->db->where('ReservationDateTime >=', date("Y-m-d") );
		$this->db->order_by('ReservationDateTime', 'ASC');
		$query = $this->db->get();

//		echo $this->db->last_query();exit;

		$result = $query->result();

		return $result;
	}

	public function getBookingAgendaByDate($customer,$date)
	{
        $this->db->select('tbl_bookandpayagenda.*, tbl_email_templates.template_name');
		$this->db->from('tbl_bookandpayagenda');
        $this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpayagenda.email_id', 'left');
		$this->db->where('Customer', $customer);
		$this->db->where('online', 1);
		$this->db->where('ReservationDateTime >=', date("Y-m-d") );
		$this->db->where('ReservationDateTime', $date );
		$this->db->order_by('ReservationDateTime', 'ASC');
		$query = $this->db->get();

//		echo $this->db->last_query();exit;

		$result = $query->result();

		return $result;
	}

	public function getAllCustomerAgenda($customer)
	{
        $this->db->select('tbl_bookandpayagenda.*, tbl_email_templates.template_name');
		$this->db->from('tbl_bookandpayagenda');
        $this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpayagenda.email_id', 'left');
		$this->db->where('Customer', $customer);
		$this->db->where('online', 1);
		$this->db->where('ReservationDateTime >=', date("Y-m-d") );
		$this->db->order_by('ReservationDateTime', 'ASC');
		$query = $this->db->get();

//		echo $this->db->last_query();exit;

		$result = $query->result();

		return $result;
	}

    public function getBookingAgendaById($id)
    {
        $this->db->select('tbl_bookandpayagenda.*, tbl_email_templates.template_name');
        $this->db->from('tbl_bookandpayagenda');
        $this->db->join('tbl_email_templates', 'tbl_email_templates.id = tbl_bookandpayagenda.email_id', 'left');
        $this->db->where('tbl_bookandpayagenda.id', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

	public function getAgendaById($id)
    {
        $this->db->select('tbl_bookandpayagenda.*');
        $this->db->from('tbl_bookandpayagenda');
        $this->db->where('tbl_bookandpayagenda.id', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

	public function addAgenda($data){
        $this->db->insert('tbl_bookandpayagenda', $data);
        return $this->db->insert_id();
    }

    public function updateAgenda ($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('tbl_bookandpayagenda', $data);
        return $this->db->affected_rows() || $id;
    }

    public function deleteAgenda ($id) {
        $this->db->where('id', $id);
        $this->db->delete('tbl_bookandpayagenda');
        return $this->db->affected_rows();
    }

	public function getbookingagendalist($customer)
	{
		$this->db->from('tbl_bookandpayagenda');
		$this->db->where('Customer', $customer);
//		$this->db->where('online', 1);
//		$this->db->where('ReservationDateTime >=', date("Y-m-d") );
		$this->db->order_by('ReservationDateTime', 'ASC');
		$query = $this->db->get();
		$result = $query->result();
		$testquery = $this->db->last_query();
//				var_dump($testquery);
//				var_dump($result);
//		print("<pre>".print_r($result,true)."</pre>");
//				die();
		return $result;
	}


	function newbookingagenda($labelInfo)
	{
		try
		{
			$set = '3456789abcdefghjkmnpqrstvwxyABCDEFGHJKLMNPQRSTVWXY';
			do
			{
				$reservationId = 'T-' . substr(str_shuffle($set), 0, 16);
				$this->db->select('id');
				$this->db->from('tbl_bookandpay');
				$this->db->where('reservationId', $reservationId);
				$query = $this->db->get();
			}
			while (!empty($query->row()));  // code in tbl_label table?

			$savedatetime = new DateTime( 'now');
			$labelInfo['bookdatetime']= $savedatetime->format('Y-m-d H:i:s');
			$labelInfo['reservationId']= $reservationId;

			if ($this->db->insert('tbl_bookandpay', $labelInfo))
				$insert_id = $this->db->insert_id();
			else {
				$testquery = $this->db->last_query();
				$insert_id = -1;
			}

			if ($insert_id > 0)
			{
				$this->db->select('id, reservationId, bookdatetime');
				$this->db->from('tbl_bookandpay');
				$this->db->where('id', $insert_id);
				$query = $this->db->get();
//				$testquery = $this->db->last_query();
//				var_dump($testquery);
//				die();
				return $query->row();
			}
			else
				return null;
		}

		catch (Exception $ex)
		{
			return null;
		}
	}

	function newvoucher($reservationId)
	{
		try
		{
			$set = '3456789ABCDEFGHJKLMNPQRSTVWXY';
			do
			{
				$voucher = 'V-' . substr(str_shuffle($set), 0, 6);
				$this->db->select('id');
				$this->db->from('tbl_bookandpay');
				$this->db->where('voucher', $voucher);
				$query = $this->db->get();
			}
			while (!empty($query->row()));  // code in tbl_label table?

			$labelInfo['voucher']= $voucher;

			try {
				$this->db->where('reservationId', $reservationId);
				$this->db->update('tbl_bookandpay', $labelInfo);
//				$testquery = $this->db->last_query();
//				var_dump($testquery);
//				die();
				return TRUE;
			}

			catch (Exception $ex)
			{
				return FALSE;
			}

		}

		catch (Exception $ex)
		{
			return null;
		}
	}

	public function getReservationId($reservationId)
	{
		$this->db->from('tbl_bookandpay');
		$this->db->where('reservationId', $reservationId);
		$query = $this->db->get();
		$result = $query->row();
//				$testquery = $this->db->last_query();
//				var_dump($testquery);
//				die();
		return $result;
	}

	function editbookandpay($labelInfo, $reservationId)
	{
		try {
			$this->db->where('reservationId', $reservationId);
			$this->db->update('tbl_bookandpay', $labelInfo);
//				$testquery = $this->db->last_query();
//				var_dump($testquery);
//				die();
			return TRUE;
		}

		catch (Exception $ex)
		{
			return FALSE;
		}
	}

	function countreservationsinprogresoverall()
	{
		$this->db->select('id');
		$this->db->from('tbl_bookandpay');
		$this->db->where('reservationset', 1);
		$this->db->where('timeslot !=', 0 );

		$num_results = $this->db->count_all_results();
				$testquery = $this->db->last_query();
				var_dump($testquery);
				die();
		return $num_results;
	}

	function countreservationsinprogress($SpotId,$customer, $eventdate)
	{
		$this->db->select('id');
		$this->db->from('tbl_bookandpay');
		$this->db->where('SpotId', $SpotId);
		$this->db->where('customer', $customer);
		$this->db->where('eventdate', $eventdate);
		$this->db->where('reservationset', 1);
		$this->db->where('timeslot !=', 0 );

		$num_results = $this->db->count_all_results();
				$testquery = $this->db->last_query();
				var_dump($testquery);
				var_dump($num_results);
				die();
		return $num_results;
	}

	function countreservationsinprogresstime($SpotId,$timeslot)
	{
		$this->db->select('id');
		$this->db->from('tbl_bookandpay');
		$this->db->where('SpotId', $SpotId);
		$this->db->where('reservationset', 1);
		$this->db->where('timeslot', $timeslot);


		$num_results = $this->db->count_all_results();
				$testquery = $this->db->last_query();
				var_dump($testquery);
				die();
		return $num_results;
	}


	public function generateCodeAndInsertLabel(array $labelInfo) : ?object
	{
		try {
			$this->db->insert('tbl_label', $labelInfo);
			$insert_id = $this->db->insert_id();
			if ($insert_id) {
				$this->db->select('id, userId, code, image');
				$this->db->from('tbl_label');
				$this->db->where('id', $insert_id);
				$query = $this->db->get();
				return $query->row();
			} else {
				return null;
			}
		} catch (Exception $ex) {
			return null;
		}
	}

	function getLabelInfoById($id, $userId)
	{
		$this->db->select('code');
		$this->db->from('tbl_label');
		$this->db->where('id', $id);
		$this->db->where('userId', $userId);
		$this->db->where('isDeleted', 0);
		$query = $this->db->get();

		return $query->row();
	}

	function getLabelInfoByCode($code = '', $id = '')
	{
		if (!$id && !$code) return null;
		$this->db->select(
			'tbl_label.id as labelId, 
            tbl_label.userId, 
            tbl_label.userfoundId,
            tbl_label.userclaimId, 
            tbl_label.descript, 
            tbl_label.categoryid, 
            tbl_label.image, 
            tbl_label.code, 
            tbl_label.isDeleted,
            tbl_label.createdDtm, 
            tbl_user.business_type_id,
            tbl_category.description AS categoryDescription,
            claimer.username AS claimerName,
            claimer.email AS claimerEmail,
            claimer.id AS claimerId'

		);
		$this->db->from('tbl_label');
		$this->db->join('tbl_category', 'tbl_label.categoryid = tbl_category.id', 'LEFT');
		$this->db->join('tbl_user', 'tbl_label.userId = tbl_user.id', 'LEFT');
		$this->db->join('tbl_user AS claimer', 'tbl_label.userclaimid = claimer.id', 'LEFT');
		$this->db->where('tbl_label.isDeleted', 0);
		if ($id) {
			$this->db->where('tbl_label.id', $id);
		} elseif ($code) {
			$this->db->where('tbl_label.code', $code);
		}
		$query = $this->db->get();
		return $query->row();
	}



	function doesUserdefinedcodeExist($code)
	{
		$this->db->select('id');
		$this->db->from('tbl_label');
		$this->db->where('code', $code);
		$query = $this->db->get();

		return !empty($query->row());
	}

	function generateCode()
	{
		$data = [];
		do {
			$set = '3456789abcdefghjkmnpqrstvwxyABCDEFGHJKLMNPQRSTVWXY';
			$data = [
				'timestamp' => date('Y-m-d H:i:s'),
				'code' => 'PH-' . substr(str_shuffle($set), 0, 8),
			];
		} while (!$this->insert($data));
		return $data['code'];
	}

	public function update(array $labelInfo, array $where)
	{
		$this->db->where($where);
		return $this->db->update('tbl_label', $labelInfo);
	}

	public function findUserClaimByCode(array $what, string $code): array
	{
		$what = implode(',', $what);
		return $this->db
			->select($what)
			->join('tbl_label', 'tbl_label.userclaimId = tbl_user.id', 'INNER')
			->where('tbl_label.code', $code)
			->get('tbl_user')
			->result_array();
	}

	public function fetchLabel(): array
	{
		if (isset($this->id)) {
			$where = ['tbl_label.id' => $this->id];
		} elseif (isset($this->code)) {
			$where = ['tbl_label.code' => $this->code];
		} else {
			return [];
		}
		// tbl_label.userfoundid AS labelUserFoundId,
		//         tbl_label.userclaimid AS labelUserClaimId,
		return $this->db
			->select(
				'tbl_label.id AS labelId, 
                tbl_label.descript AS labelDescription, 
                tbl_label.code AS labelCode,
                tbl_label.dclw AS labelDclw, 
                tbl_label.dcll AS labelDcll,
                tbl_label.dclh AS labelDclh, 
                tbl_label.dclwgt AS labelDclwgt, 

                owner.id AS ownerId,
                owner.username AS ownerUsername,
                owner.email AS ownerEmail,
                owner.roleid AS ownerRoleId,
                owner.mobile AS ownerMobile,
                owner.IsDropOffPoint AS ownerDropOffPoint,
                owner.address AS ownerAddress,
                owner.addressa AS ownerAddressa,
                owner.city AS ownerCity,
                owner.zipcode AS ownerZipcode,
                owner.country AS ownerCountry,
                owner.gmtOffSet AS ownerGmtOffSet,

                claimer.id AS claimerId,
                claimer.username AS claimerUsername,
                claimer.email AS claimerEmail,
                claimer.roleid AS claimerRoleId,
                claimer.mobile AS claimerMobile,
                claimer.IsDropOffPoint AS claimerDropOffPoint,
                claimer.address AS claimerAddress,
                claimer.addressa AS claimerAddressa,
                claimer.city AS claimerCity,
                claimer.zipcode AS claimerZipcode,
                claimer.country AS claimerCountry,
                claimer.gmtOffSet AS claimerGmtOffSet,

                finder.id AS finderId,
                finder.username AS finderUsername,
                finder.email AS finderEmail,
                finder.roleid AS finderRoleId,
                finder.mobile AS finderMobile,
                finder.IsDropOffPoint AS finderDropOffPoint,
                finder.address AS finderAddress,
                finder.addressa AS finderAddressa,
                finder.city AS finderCity,
                finder.zipcode AS finderZipcode,
                finder.country AS finderCountry,
                finder.gmtOffSet AS finderGmtOffSet,'
			)
			->join('tbl_user AS owner', 'tbl_label.userid = owner.id', 'LEFT')
			->join('tbl_user AS claimer', 'tbl_label.userclaimid = claimer.id', 'LEFT')
			->join('tbl_user AS finder', 'tbl_label.userfoundid = finder.id', 'LEFT')
			->where($where)
			->get('tbl_label')
			->result_array();
	}

	public function filterLabels(array $where): array
	{
		$this->db->select(
			'BaseTbl.id,
            BaseTbl.userId,
            tbl_category.description as categoryname,
            BaseTbl.userfoundId,
            BaseTbl.isDeleted,
            BaseTbl.code,
            BaseTbl.descript,
            BaseTbl.lost,
            BaseTbl.createdDtm,
            BaseTbl.image,
            BaseTbl.categoryid,
            BaseTbl.userclaimId,
            BaseTbl.lat,
            BaseTbl.lng,
            BaseTbl.finder_fee,
            tbl_employee.username AS employee,
            tbl_user.username AS owner,
            tbl_dhl.id AS dhlId,
            tbl_dhl.dhlordernr AS dhlordernr,
            tbl_dhl.dhlcode AS dhlErrorNumber,
            tbl_payments_history.paystatus AS paystatus,
            tbl_payments_history.orderstatusid AS orderstatusid,
            tbl_payments_history.errorMessage AS systemErrorMessage'
		);
		$this->db->from('tbl_label as BaseTbl');
		$this->db->join('tbl_category', 'tbl_category.id = BaseTbl.categoryid','left');
		$this->db->join('tbl_user', 'tbl_user.id = BaseTbl.userId','inner');
		$this->db->join('tbl_employee', 'BaseTbl.employeeId = tbl_employee.id','left');

		$this->db->join('tbl_dhl', 'tbl_dhl.labelId = BaseTbl.id','left');
		$this->db->join('tbl_payments_history', 'tbl_payments_history.dhlId = tbl_dhl.id','left');
		foreach($where as $key => $value) {
			if ($value || is_numeric($value)) {
				$this->db->where('BaseTbl.' . $key, $value);
			}
		}
		$this->db->order_by('BaseTbl.createdDtm', 'DESC');
		$this->db->order_by('tbl_payments_history.id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function insert(array $data): bool
	{
		$this->db->insert('tbl_label', $data);
		$this->id = $this->db->insert_id();
		return $this->id ? true : false;
	}

	public function getItemsInPointRadius(float $lat, float $lng, float $radius, int $lost): array
	{
		$query =
			'SELECT 
                tbl_label.id AS id,
                tbl_label.descript AS Description,
                tbl_category.description AS Category, 
                tbl_label.finder_fee AS reward, 
                tbl_label.lat AS lat, 
                tbl_label.lng AS lng, 
                CONCAT("' . base_url() . 'found/", tbl_label.code) AS clickurl,
                CONCAT("' . base_url() . 'uploads/LabelImages/", tbl_label.userId, "-", tbl_label.code, "-", tbl_label.image ) AS iconimage,                
                (
                    6371000 * acos(
                        cos( radians(' . $lat . ') ) 
                        * cos( radians(tbl_label.lat) ) 
                        * cos( radians(tbl_label.lng) - radians(' . $lng . ')) 
                        + sin(radians(' . $lat . ')) 
                        * sin(radians(tbl_label.lat))
                    )
                ) as distance
                FROM tbl_label
                INNER JOIN tbl_category ON tbl_label.categoryid = tbl_category.id 
                WHERE tbl_label.lost = ' . $lost . ' HAVING distance <' . $radius . ';';

		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function select(array $what, array $where = []): array
	{
		$this->db->select(implode(',', $what));
		$this->db->from('tbl_label');
		if (!empty($where)) {
			foreach($where as $key => $value) {
				$this->db->where([$key => $value]);
			}
		}
		return $this->db->get()->result_array();
	}

	public function cronDeleteReservations(): bool
	{
		$where = [
			'tbl_bookandpay.paid=' => '0',
			'tbl_bookandpay.reservationtime<' => date('Y-m-d H:i:s', strtotime("-10 minutes", strtotime(date('Y-m-d H:i:s')))),
		];
		return $this->db->delete('tbl_bookandpay', $where);
	}
	
	public function updateTermsofuse ($body) {
		$data = ['body' => $body];
        $this->db->where('id', 1);
		return $this->db->update('tbl_termsofuse', $data);
	}

	public function getTermsofuse () {
        $this->db->where('id', 1);
		$query = $this->db->get('tbl_termsofuse');
		return $query->row();
	}

	function get_payment_methods($vendor_id){

		$this->db->select('paymentMethod, percent, amount')
		->from('tbl_shop_payment_methods')
		->where('vendorId',$vendor_id)
		->where('productGroup','Reservations');
		$query = $this->db->get();
		$results = $query->result_array();
		$ticketing = [];
		foreach($results as $result){
			$ticketing[$result['paymentMethod']] = [
				'percent' => $result['percent'],
				'amount' => $result['amount']
			];
		}
		return $ticketing;
	}

	function get_active_payment_methods($vendor_id){

		$this->db->select('paymentMethod, percent, amount, active')
		->from('tbl_shop_payment_methods')
		->where('vendorId',$vendor_id)
		->where('productGroup','Reservations')
		->where('active' , '1');
		$query = $this->db->get();
		$results = $query->result_array();
		$ticketing = [];
		foreach($results as $result){
			$ticketing[] = $result['paymentMethod'];
		}
		return $ticketing;
	}

	function get_max_spots($agenda_id){

		$this->db->select('max_spots')
		->from('tbl_bookandpayagenda')
		->where('id',$agenda_id);
		$query = $this->db->get();
		$result = $query->first_row();
		return $result->max_spots;
	}

	function get_spot_count_by_agenda($agenda_id){

		$this->db->select('count(id) as spot_count')
		->from('tbl_bookandpayspot')
		->where('agenda_id',$agenda_id)
		->group_by('agenda_id');
		$query = $this->db->get();
		$result = $query->first_row();
		return isset($result->spot_count) ? $result->spot_count : 0;
	}

	function get_manual_reservations($vendorId){

		$this->db->select('*')
		->from('tbl_bookandpay')
		->where('paid', 2)->where('customer', $vendorId);
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_agenda_spot_timeslot($vendorId){
		$dt = new DateTime('now');
        $today = $dt->format('Y-m-d');
		$this->db->select('tbl_bookandpaytimeslots.id as timeslot_id, agenda_id, spot_id, ReservationDescription as agenda_descript, ReservationDateTime as event_date, descript as spot_descript, fromtime, totime');
		$this->db->from('tbl_bookandpaytimeslots');
		$this->db->join('tbl_bookandpayspot', 'tbl_bookandpayspot.id = tbl_bookandpaytimeslots.spot_id', 'left');
		$this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
		$this->db->where('tbl_bookandpayagenda.Customer', $vendorId);
		$this->db->where('date(ReservationDateTime) >=', $today);
		$this->db->group_by('tbl_bookandpayagenda.id');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getSpotsByCustomer($customer_id, $agendaId)
    {
        $this->db->select('tbl_bookandpayspot.id as spot_id, descript as spot_descript');
        $this->db->from('tbl_bookandpaytimeslots');
		$this->db->join('tbl_bookandpayspot', 'tbl_bookandpayspot.id = tbl_bookandpaytimeslots.spot_id', 'left');
		$this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
        $this->db->where('tbl_bookandpayagenda.Customer', $customer_id);
		$this->db->where('tbl_bookandpayagenda.id', $agendaId);
        $this->db->group_by('tbl_bookandpayspot.id');

        $query = $this->db->get();
		
		return $query->result_array();
        
    }

	public function getTimeSlotsByCustomer($customer_id, $spotId) {
        $this->db->select('tbl_bookandpaytimeslots.id as timeslot_id, tbl_bookandpaytimeslots.price as timeslot_price, fromtime, totime, multiple_timeslots, duration, overflow, tbl_bookandpaytimeslots.available_items');
        $this->db->from('tbl_bookandpaytimeslots');
		$this->db->join('tbl_bookandpayspot', 'tbl_bookandpayspot.id = tbl_bookandpaytimeslots.spot_id', 'left');
		$this->db->join('tbl_bookandpayagenda', 'tbl_bookandpayagenda.id = tbl_bookandpayspot.agenda_id', 'left');
        $this->db->where('tbl_bookandpayagenda.Customer', $customer_id);
		$this->db->where('tbl_bookandpayspot.id', $spotId);
		$this->db->group_by('tbl_bookandpaytimeslots.id');

        $query = $this->db->get();

        return $query->result_array();

    }

	public function get_vendor_cost($vendorId)
	{
		$this->db->select('paymentMethod, vendorCost');
		$this->db->from('tbl_shop_payment_methods');
		$this->db->where('vendorId', $vendorId);
		$this->db->where('productGroup', 'Reservations');
		$query = $this->db->get();
		$results = $query->result_array();
		$vendorCosts = [];
		foreach($results as $result){
			$paymentMethod = $result['paymentMethod'];
			$vendorCosts[$paymentMethod] = $result['vendorCost'];
		}
		return $vendorCosts;
	}

	public function get_agenda_by_id($agendaId)
	{
		$this->db->select('*');
		$this->db->from('tbl_bookandpayagenda');
		$this->db->where('id', $agendaId);
		$query = $this->db->get();
		$result = $query->first_row();
		return $result;
	}
	
}
