<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login_model (Login Model)
 * Login model class to get to authenticate user credentials
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Bookandpay_model extends CI_Model
{

	public $uploadFolder = FCPATH . 'uploads/LabelImages';

	public $id;
	public $TransactionID;
	public $reservationId;

	function newbooking($labelInfo)
	{
//		var_dump($labelInfo);
//		die();

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

	function newbuyer()
	{
		try {
			$set = '3456789ABCDEFGHJKLMNPQRSTVWXY';
			do {
				$buyer = 'B-' . substr(str_shuffle($set), 0, 6);
				$this->db->select('id');
				$this->db->from('tbl_bookandpaybuyer');
				$this->db->where('buyer', $buyer);
				$query = $this->db->get();
			} while (!empty($query->row()));  // code in tbl_label table?

			$labelInfo['buyer'] = $buyer;

			if ($this->db->insert('tbl_bookandpaybuyer', $labelInfo))
				$insert_id = $this->db->insert_id();
			else {
				$testquery = $this->db->last_query();
				$insert_id = -1;
			}

			if ($insert_id > 0) {
				return $buyer;
			} else {
				return $insert_id;
			}
			//				$testquery = $this->db->last_query();
			//				var_dump($testquery);
			//				die();
		}
		 catch (Exception $ex) {
				return FALSE;
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

	public function getReservationTicketFee($reservationId)
	{
		$this->db->select('nonSharedTicketFee as ticketFee');
		$this->db->from('tbl_bookandpay');
		$this->db->join('tbl_ticket_options', 'tbl_ticket_options.ticketId = tbl_bookandpay.eventId', 'LEFT');
		$this->db->where('reservationId', $reservationId);
		$query = $this->db->get();
		$ticketFee = 0;
		if($query->num_rows() > 0)
		{
			$result = $query->first_row();
			$ticketFee = floatval($result->ticketFee);
		}

		return $ticketFee;
	}

	public function getReservationByMail($email,$eventdate,$reservationId)
	{
		$this->db->from('tbl_bookandpay');
		$this->db->where('email', $email);
		$this->db->where('reservationId', $reservationId);
		$this->db->where('eventdate', $eventdate);
		$query = $this->db->get();
		$result = $query->row();
		// $testquery = $this->db->last_query();
		// var_dump($testquery);
		// die();
		return $result;
	}
 

	public function updateBookandpayByTransactionId($TransactionID)
	{
		try {
			$this->db->where('TransactionID', $TransactionID);
			$this->db->set('paid', 1);
			$this->db->update('tbl_bookandpay');
			return TRUE;
		}

		catch (Exception $ex)
		{
			return FALSE;
		}
	}


	public function updateTransactionIdByReservationIds($reservationIds, $TransactionID)
	{
		$this->db->where_in('id', $reservationIds);
		$this->db->set('TransactionID', $TransactionID);
		$this->db->update('tbl_bookandpay');
		return TRUE;

	}

	public function updateTransactionIdByReservations($reservationIds, $TransactionID)
	{
		$this->db->where_in('reservationId', $reservationIds);
		$this->db->set('TransactionID', $TransactionID);
		$this->db->update('tbl_bookandpay');
		return TRUE;

	}


	public function editbookandpay($labelInfo, $reservationId)
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

	public function countreservationsinprogresoverall($customer,$eventdate)
	{
		$this->db->select('id');
		$this->db->from('tbl_bookandpay');
		$this->db->where('reservationset', 1);
		$this->db->where('timeslot !=', 0 );
		$this->db->where('customer', $customer );
		$this->db->where('eventdate', $eventdate );
		$num_results = $this->db->count_all_results();
//				$testquery = $this->db->last_query();
//				var_dump($testquery);
//				die();
		return $num_results;
	}

	function countreservationsinprogress($SpotId,$customer,$eventdate)
	{
		$this->db->select('id');
		$this->db->from('tbl_bookandpay');
		$this->db->where('SpotId', $SpotId);
		$this->db->where('reservationset', 1);
		$this->db->where('timeslot !=', 0 );
		$this->db->where('customer', $customer );
		$this->db->where('eventdate', $eventdate );
		$num_results = $this->db->count_all_results();
//				$testquery = $this->db->last_query();
//				var_dump($testquery);
//				var_dump($num_results);
//				die();
		return $num_results;
	}

	function countreservationsinprogresstime($SpotId,$timeslot,$customer,$eventdate)
	{
		$this->db->select('id');
		$this->db->from('tbl_bookandpay');
		$this->db->where('SpotId', $SpotId);
		$this->db->where('reservationset', 1);
		$this->db->where('timeslot', $timeslot);
		$this->db->where('customer', $customer );
		$this->db->where('eventdate', $eventdate );
		$num_results = $this->db->count_all_results();
//				$testquery = $this->db->last_query();
//				var_dump($testquery);
//				die();
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

	/*
	 * Added functions from booking2020(bookandpay_model)
	 * author : Dorian Rina
	 * since : 18 November 2020
	 */

	function getBookingCountByTimeSlot($timeSlotId, $fromtime, $totime)
    {
		$dt = new DateTime( 'now');
		$current_timestamp = $dt->format('Y-m-d H:i:s');

		$this->db->select('*');
        $this->db->from('tbl_bookandpay');
		$this->db->where('timeslotId', $timeSlotId);
		$this->db->like('timefrom', $fromtime);
		$this->db->like('timeto', $totime);
		$this->db->where('(paid="1" OR DATE_ADD(bookdatetime, INTERVAL 10 MINUTE) >= "'.$current_timestamp.'")', NULL, false);

        $query = $this->db->get();

        if($query) {
            return $query->num_rows();
        }

        return 0;
	}
	
	function getBookingCountBySpot($spotId, $timeSlotId, $fromtime, $totime)
    {
		$dt = new DateTime( 'now');
		$current_timestamp = $dt->format('Y-m-d H:i:s');

        $this->db->select('*');
        $this->db->from('tbl_bookandpay');
		$this->db->where('timeslotId', $timeSlotId);
		$this->db->where('SpotId', $spotId);
		$this->db->like('timefrom', $fromtime);
		$this->db->like('timeto', $totime);
		$this->db->where('(paid="1" OR DATE_ADD(bookdatetime, INTERVAL 10 MINUTE) >= "'.$current_timestamp.'")', NULL, false);

        $query = $this->db->get();

        if($query) {
            return $query->num_rows();
        }

        return 0;
	}

	function getBookingCountByAgenda($agendaId)
    {
		$dt = new DateTime( 'now');
		$current_timestamp = $dt->format('Y-m-d H:i:s');

        $this->db->select('*');
        $this->db->from('tbl_bookandpay');
		$this->db->where('eventid', $agendaId);
		$this->db->where('SpotId <>', '0');
		$this->db->where('(paid="1" OR DATE_ADD(bookdatetime, INTERVAL 10 MINUTE) >= "'.$current_timestamp.'")', NULL, false);
		
        $query = $this->db->get();

        if($query) {
            return $query->num_rows();
        }

        return 0;
	}


	public function getReservationsByIds($reservationIds)
	{
		$this->db->from('tbl_bookandpay');
		$this->db->where_in('reservationId', $reservationIds);
		$query = $this->db->get();

//				$testquery = $this->db->last_query();
//				var_dump($testquery);
//				die();
        $result = $query->result();
		return $result;
	}

	public function getBookingsByIds($ids)
	{
		$this->db->from('tbl_bookandpay');
		$this->db->where_in('id', $ids);
		$query = $this->db->get();

//				$testquery = $this->db->last_query();
//				var_dump($testquery);
//				die();
        $result = $query->result();
		return $result;
	}

	public function getReservationsByTransactionId($TransactionId, $what = [])
	{
		if (count($what) > 0) {
			$this->db->select(implode(',', $what));
		}
		$this->db->from('tbl_bookandpay');
		$this->db->where_in('TransactionID', $TransactionId);
		$query = $this->db->get();
        $result = $query->result();
		return $result;
	}


	public function getReservationsById($reservationId)
	{
		$this->db->from('tbl_bookandpay');
		$this->db->where('reservationId', $reservationId);
		$query = $this->db->get();
        $result = $query->result();
		return $result;
	}

	public function getReservationsByEmailAndDate($email, $eventDate)
	{
		$this->db->from('tbl_bookandpay');
		$this->db->where('paid', '1');
		$this->db->where('email', $email);
		$this->db->like('eventdate', $eventDate);
		$query = $this->db->get();
        $result = $query->result();
		return $result;
	}

	public function checkPaidStatus($transactionId) : bool
	{
		$this->db->select('TransactionID');
		$this->db->from('tbl_bookandpay');
		$this->db->where('paid', '1');
		$this->db->where('TransactionID', $transactionId);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return true;
		}
		return false;
	}

	function getBookingByTimeSlot($customer, $eventDate, $timeSlot)
    {
        $this->db->select('*');
        $this->db->from('tbl_bookandpay');
        $this->db->where('reservationset', 1);
        $this->db->where('customer', $customer);
        $this->db->where('timeslot', $timeSlot);

        $this->db->where('eventdate', date("yy-m-d", strtotime($eventDate)));
        $query = $this->db->get();

        if($query) {
            return $query->result();
        }

        return false;
	}

	public function getUserSlCode($id)
	{
		$this->db->select('TpayNlServiceId');
		$this->db->from('tbl_shop_vendors');
		$this->db->where('vendorId', $id);
		$query = $this->db->get();

        $result = $query->row();
		return $result->TpayNlServiceId;
	}
	
	public function getReservationById($id)
	{
		$this->db->from('tbl_bookandpay');
		$this->db->where('id', $id);
		$query = $this->db->get();

        $result = $query->row();
		return $result;
	}

	public function deleteReservation($id): bool
	{
		$where = [
			'tbl_bookandpay.id=' => $id
		];
		return $this->db->delete('tbl_bookandpay', $where);
	}

	function save_reservations($userInfo, $bookings){
		$data = [];
		$reservationIds = [];
		foreach($bookings as $booking){
			$savedatetime = new DateTime( 'now');
			$bookdatetime = $savedatetime->format('Y-m-d H:i:s');
			for($i=0; $i < $booking['quantity']; $i++):
			$set = '3456789abcdefghjkmnpqrstvwxyABCDEFGHJKLMNPQRSTVWXY';
			$reservationId = 'T-' . substr(str_shuffle($set), 0, 16);
			$reservationIds[] = $reservationId;
			
			$data[] = [
				'reservationId' => $reservationId,
				'customer' => $booking['customer'],
				'eventid' => $booking['eventid'],
				'SpotId' => $booking['SpotId'],
				'eventdate' => date('Y-m-d', strtotime($booking['eventdate'])),
				'bookdatetime' => $bookdatetime,
				'timefrom' => $booking['timefrom'],
				'timeto' => $booking['timeto'],
				'price' => $booking['price'],
				'reservationFee' => $booking['reservationFee'],
				'numberofpersons' => $booking['numberofpersons'],
				'name' => $userInfo['name'],
				'email' => $userInfo['email'],
				'age' => $userInfo['age'],
				'gender' => $userInfo['gender'],
				'mobilephone' => $userInfo['mobileNumber'],
				'Address' => $userInfo['address'],
				'reservationset' => '1',
				'timeslot' => $booking['timeslotId'],
			];
			endfor;
			
		}

		$this->db->insert_batch('tbl_bookandpay',$data);

		return $reservationIds;
	}

	public function getBookingByReservationId(string $reservationId): ?array
	{
		$this->db->where('reservationId', $reservationId);
		$result = $this->db->get('tbl_bookandpay')->result_array();
		return empty($result) ? null : reset($result);
	}

	public function updateBooking(array $what): bool
	{
		if ($this->id) {
			$this->db->where('id', $this->id);
		} elseif ($this->TransactionID) {
			$this->db->where('TransactionID', $this->TransactionID);
		} elseif ($this->reservationId) {
			$this->db->where('reservationId', $this->reservationId);
		}

        foreach ($what as $key => $value) {
            $this->db->set($key, $value);
        }

        return $this->db->update('tbl_bookandpay');
	}

	public function setPropertry(string $key, $value): Bookandpay_model
	{
		$this->{$key} = $value;
		return $this;
	}

	public function get_financial_report($vendorId, $sql='')
	{
		$query = $this->db->query("SELECT id, eventdate, voucher, reservationId, reservationtime, price, numberofpersons, name, email, mobilephone, Spotlabel, timefrom, timeto, TransactionID, SpotId
		FROM tbl_bookandpay
		WHERE paid = '1' AND SpotId <> '0' AND customer = ".$vendorId." $sql
		ORDER BY reservationtime DESC");
		$result = $query->result_array();
		return empty($result) ? [] : $result;
	}

	public function get_vouchers($vendorId) : array
	{
		$query = $this->db->query("SELECT code
		FROM tbl_shop_voucher
		WHERE productGroup = 'Reservations' AND vendorId = ".$vendorId);
		$results = $query->result_array();
		$vouchers = [];
		if($query->num_rows() > 0){
			foreach($results as $result){
				$vouchers[] = $result['code'];
			}
		}
		return $vouchers;
	}

	public function getReservationsByTransactionIdImproved(string $TransactionId, $what = []): ?array
	{
		if ($what) {
			$this->db->select(implode(',', $what));
		}
		$this->db->from('tbl_bookandpay');
		$this->db->where('TransactionId', $TransactionId);
		$query = $this->db->get();
		$result = $query->result();

		return empty($result) ? null : $result;
	}

	public function getReservationDataByKey(string $key, string $value, array $what): ?array
	{
		$this->db->select(implode(',', $what));
		$this->db->from('tbl_bookandpay');
		$this->db->where($key, $value);
		$query = $this->db->get();
		$result = $query->result();

		return empty($result) ? null : $result;
	}
}
