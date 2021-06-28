<?php
class Event_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
	}

	public function save_event($data)
	{
		$data['StartDate'] = date('Y-m-d', strtotime($data['StartDate']));
		$data['EndDate'] = date('Y-m-d', strtotime($data['EndDate']));
		$this->db->insert('tbl_events', $data);
		return $this->db->insert_id();
	}

	public function update_event($eventId, $data)
	{
		$data['StartDate'] = date('Y-m-d', strtotime($data['StartDate']));
		$data['EndDate'] = date('Y-m-d', strtotime($data['EndDate']));
		$this->db->where("id", $eventId);
		return $this->db->update('tbl_events',$data);
	}

	public function update_event_archived($vendorId, $eventId, $value)
	{
		$this->db->where("id", $eventId);
		$this->db->where("vendorId", $vendorId);
		$this->db->set('archived', $value);
		$this->db->update('tbl_events');
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function save_ticket($data)
	{
		$this->db->insert('tbl_event_tickets',$data);
		return $this->db->insert_id();
	}

	public function save_guest($data)
	{
		return $this->db->insert('tbl_guestlist',$data);
	}

	public function delete_guest($vendorId, $id)
	{
		$where = ['id' => $id, 'vendorId' => $vendorId];
		$this->db->delete('tbl_guestlist', $where);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function delete_multiple_guests($vendorId, $ids)
	{
		$this->db->where_in('id', $ids);
		$this->db->where('vendorId', $vendorId);
		$this->db->delete('tbl_guestlist');
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function get_guest_by_id($vendorId, $guestId)
	{
		$this->db->select('*');
		$this->db->from('tbl_guestlist');
		$this->db->where("id", $guestId);
		$this->db->where("vendorId", $vendorId);
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->first_row() : false;
	}

	public function get_guests_by_ids($vendorId, $guestIds)
	{
		$this->db->select('*');
		$this->db->from('tbl_guestlist');
		$this->db->where_in("id", $guestIds);
		$this->db->where("vendorId", $vendorId);
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->result() : [];
	}

	public function save_multiple_guests($data)
	{
		return $this->db->insert_batch('tbl_guestlist',$data);
	}

	public function save_ticket_options($data)
	{
		$ticketId = $data['ticketId'];
		$data['startDate'] = date('Y-m-d', strtotime($data['startDate']));
		$data['endDate'] = date('Y-m-d', strtotime($data['endDate']));
		$this->db->where('ticketId ', $ticketId);
		if($this->db->get('tbl_ticket_options')->num_rows() == 0){
			return $this->db->insert('tbl_ticket_options',$data);
		}
		$this->db->where('ticketId ', $ticketId);
		return $this->db->update('tbl_ticket_options',$data);
		
	}

	public function save_ticket_group($groupname,$quantity,$eventId)
	{
		$this->db->insert('tbl_ticket_groups',['groupname' => $groupname, 'groupQuantity' => $quantity, 'eventId' => $eventId]);
		return $this->db->insert_id();
		
	}

	public function get_ticket_options($ticketId)
	{
		$this->db->select('*');
		$this->db->from('tbl_ticket_options');
		$this->db->where('ticketId', $ticketId);
		$query = $this->db->get();
		$results = $query->result_array();
		if(isset($results[0])){
			return $results[0];
		}
		return '';
	}

	public function get_events($vendor_id)
	{
		date_default_timezone_set('Europe/Amsterdam');
        $current_timestamp = date('Y-m-d H:i:s');
		$today = date('Y-m-d');
		//$time = date('H:i:s');
		$this->db->trans_start();
		$this->db->select('*');
		$this->db->from('tbl_events');
		$this->db->where('vendorId', $vendor_id);
		$this->db->where('archived', '0');
		$this->db->where('( (showInSameDate="1" AND EndDate = "' . $today . '" ) OR concat_ws(" ", EndDate, EndTime) >= "'.$current_timestamp.'")', NULL, false);
		$this->db->order_by('StartDate');
		$query = $this->db->get();
		$this->db->trans_complete();
		return $query->result_array();
	} 

	public function get_event_by_id($vendor_id, $eventId, $checkDate = true)
	{
		date_default_timezone_set('Europe/Amsterdam');
        $current_timestamp = date('Y-m-d H:i:s');
		$today = date('Y-m-d');
		$this->db->trans_start();
		$this->db->select('*');
		$this->db->from('tbl_events');
		$this->db->where('vendorId', $vendor_id);
		$this->db->where('id', $eventId);
		//$this->db->where('concat_ws(" ", StartDate, StartTime)  >=', $date);
		if ($checkDate) {
			$this->db->where('( (showInSameDate="1" AND EndDate = "' . $today . '" ) OR concat_ws(" ", EndDate, EndTime) >= "'.$current_timestamp.'")', NULL, false);
		}
		
		$query = $this->db->get();
		$this->db->trans_complete();
		return $query->result_array();
	} 

	public function get_all_events($vendor_id)
	{
		
		$this->db->where('vendorId', $vendor_id);
		$query = $this->db->get('tbl_events');
		return $query->result_array();
	}

	public function get_event($vendor_id,$eventId)
	{
		$this->db->where('id', $eventId);
		$this->db->where('vendorId', $vendor_id);
		$query = $this->db->get('tbl_events');
		return $query->first_row();
	}

	public function get_ticket($ticketId)
	{
		$this->db->where('id', $ticketId);
		$query = $this->db->get('tbl_event_tickets');
		return $query->first_row();
	}

	public function get_tickets($vendor_id,$eventId)
	{
		$this->db->select('*,tbl_event_tickets.id as ticketId, tbl_ticket_groups.id as groupId');
		$this->db->from('tbl_event_tickets');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'left');
		$this->db->join('tbl_ticket_groups', 'tbl_ticket_groups.id = tbl_event_tickets.ticketGroupId', 'left');
		$this->db->join('tbl_ticket_options', 'tbl_ticket_options.ticketId = tbl_event_tickets.id', 'left');
		$this->db->where('vendorId', $vendor_id);
		$this->db->where('tbl_event_tickets.eventId', $eventId);
		$this->db->group_by('tbl_event_tickets.id');
		$this->db->order_by('tbl_ticket_groups.id, ticketOrder');
		$query = $this->db->get();
		$tickets = $query->result_array();
		$groups = $this->get_ticket_groups($eventId);
		$groupIds = [];
		foreach ($tickets as $key => $ticket) {
			$tickets[$key]['guestlistCount'] = $this->get_guestlist_count($ticket['ticketId']);
			$groupIds[] = $ticket['groupId'];
		}

		return $this->get_ticket_with_groups($tickets,$groups,$groupIds);
	}


	public function get_event_tickets($vendor_id,$eventId)
	{
		$dt = new DateTime('now', new DateTimeZone('Europe/Amsterdam'));
        $date = $dt->format('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->select('*,tbl_event_tickets.id as ticketId, tbl_ticket_groups.id as groupId, concat_ws(" ", tbl_ticket_options.startDate, tbl_ticket_options.startTime) as startTimestamp, concat_ws(" ", tbl_ticket_options.endDate, tbl_ticket_options.endTime) as endTimestamp');
		$this->db->from('tbl_event_tickets');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'left');
		$this->db->join('tbl_ticket_groups', 'tbl_ticket_groups.id = tbl_event_tickets.ticketGroupId', 'left');
		$this->db->join('tbl_ticket_options', 'tbl_ticket_options.ticketId = tbl_event_tickets.id', 'left');
		$this->db->where('ticketVisible', '1');
		$this->db->where('archived', '0');
		$this->db->where('vendorId', $vendor_id);
		$this->db->where('tbl_event_tickets.eventId', $eventId);
		$this->db->group_by('tbl_event_tickets.id');
		$this->db->order_by('tbl_ticket_groups.id, ticketOrder');
		
		$query = $this->db->get();
		$this->db->trans_complete();
		$results = $query->result_array();
		if(count($results) == 0){
			return $results;
		}
		$tickets = [];
		$soldoutTickets = [];
		$positionSoldoutAtBottom = 1;
		$nextFaseTickets = $this->verify_soldout_fase($eventId, $results);

		foreach($results as $result){
			$ticketFee = isset($result['nonSharedTicketFee']) ? number_format($result['nonSharedTicketFee'], 2, '.', '') : '0.00';
			$result['ticketFee'] = $ticketFee;
			$ticketId = $result['ticketId'];
			$tickets_used = $this->get_tickets_used($eventId);
			$ticket_used = isset($tickets_used[$ticketId]) ? $tickets_used[$ticketId] : 0;
			$ticket_available = intval($result['ticketQuantity']) - intval($ticket_used);
			$sold_out = false;
			$result['bundleMax'] = $this->get_ticket_bundle_max($result['ticketGroupId'], $result['groupQuantity']);

			if($this->_check_ticket_bundle_max($result['ticketGroupId'])){
				$sold_out = true;
				$result['soldOutWhenExpired'] = 'Sold Out';
			}

			if($result['ticketExpired'] == 'manually'){
				$startDt = new DateTime($result['startTimestamp'], new DateTimeZone('Europe/Amsterdam'));
				$startTimestamp = $startDt->format('Y-m-d H:i:s');
				$endDt = new DateTime($result['endTimestamp'], new DateTimeZone('Europe/Amsterdam'));
				$endTimestamp = $endDt->format('Y-m-d H:i:s');
				if($date < $startTimestamp){
					$sold_out = true;
					$result['soldOutWhenExpired'] = "<b style='color:#7855c4 !important;'>Sales starting at ". $startDt->format('d M Y - H:i').'</b>';
					//continue;
				}

				if($date > $endTimestamp){
					$sold_out = true;
				}

			}

			if($ticket_available <= 0){
				$sold_out = true;
			}

			if(isset($result['soldoutVisible']) && $result['soldoutVisible'] == 0 && $ticket_available <= 0){
				continue;
			}

			$previousFaseId = ($result['ticketExpired'] == 'manually') ? null : $result['previousFaseId'];

			if($previousFaseId != null && isset($nextFaseTickets[$previousFaseId]) && $nextFaseTickets[$previousFaseId]['soldout'] == false){
				continue;
			}

			

			$result['soldOut'] = $sold_out;
			$result['ticketAvailable'] = $ticket_available;
			$positionSoldoutAtBottom = $result['positionSoldoutAtBottom'];
			if($sold_out){
				$soldoutTickets[] = $result;
			} else {
				$tickets[] = $result;
			}
			
		}

		$tickets = ($positionSoldoutAtBottom == '1') ? array_merge($tickets, $soldoutTickets) : array_merge($soldoutTickets, $tickets);
		return $tickets;

	}


	public function get_ticket_by_id($vendor_id,$ticketId)
	{
		$this->db->trans_start();
		$this->db->select('
				tbl_event_tickets.ticketPrice,
				tbl_ticket_options.nonSharedTicketFee as ticketFee,
				tbl_event_tickets.ticketDescription,
				tbl_events.StartDate,
				tbl_events.StartTime,
				tbl_events.EndTime,
				numberofpersons,
				ticketType
			');
		$this->db->from('tbl_event_tickets');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'left');
		$this->db->join('tbl_ticket_options', 'tbl_ticket_options.ticketId = tbl_event_tickets.id', 'left');
		$this->db->where('vendorId', $vendor_id);
		$this->db->where('tbl_event_tickets.id', $ticketId);
		$this->db->group_by('tbl_event_tickets.id');
		$query = $this->db->get();
		$this->db->trans_complete();
		return $query->first_row();
	}

	public function get_ticket_with_groups($tickets, $groups, $groupIds)
	{
		$ticket_groups = [];
		foreach ($groups as $group) {
			if(in_array($group['id'],$groupIds)){continue;}
			$ticket_groups[] = [
				'ticketId' => '0',
				'ticketDescription' => 'null',
				'ticketDesign' => '',
				'ticketQuantity' => 0,
				'ticketPrice' => 0,
				'ticketCurrency' => '',
				'ticketVisible' => 0,
				'emailId' => 1,
				'ticketGroupId' => $group['id'],
				'groupId' => $group['id'],
				'groupname' =>  $group['groupname'],
				'groupQuantity' => $group['groupQuantity']
				
			];
		}
		$results = array_merge($tickets,$ticket_groups);
		return $results;
	}

	public function get_event_by_ticket($ticketId)
	{
		$this->db->select('eventname, StartTime, EndTime, StartDate, EndDate');
		$this->db->from('tbl_event_tickets');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'left');
		$this->db->where('tbl_event_tickets.id', $ticketId);
		$query = $this->db->get();
		return $query->first_row();
	}

	public function get_ticket_info($ticketId)
	{
		$this->db->select('*');
		$this->db->from('tbl_event_tickets');
		$this->db->join('tbl_ticket_options', 'tbl_ticket_options.ticketId = tbl_event_tickets.id', 'left');
		$this->db->join('tbl_ticket_groups', 'tbl_ticket_groups.id = tbl_event_tickets.ticketGroupId', 'left');
		$this->db->where('tbl_event_tickets.id', $ticketId);
		$query = $this->db->get();
		$result = $query->first_row();
		$ticket = $this->get_ticket_used($ticketId);
		$ticket_used = isset($ticket->ticket_used) ? $ticket->ticket_used : 0;
		$ticket_available = intval($result->ticketQuantity) - intval($ticket_used);
		$result->ticketAvailable = $ticket_available;
		$result->ticketFee = $result->nonSharedTicketFee;
		return $result;

	}


	public function get_ticket_groups($eventId)
	{
		$this->db->select('*');
		$this->db->from('tbl_ticket_groups');
		$this->db->where('eventId', $eventId);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function save_event_design($vendor_id, $eventId, $design){
		$this->db->set('shopDesign', $design);
		$this->db->where('vendorId', $vendor_id);
		$this->db->where('id', $eventId);
		return $this->db->update('tbl_events');
	}

	public function save_vendor_design($vendorId, $design){

		$this->db->where('vendorId', $vendorId);
		if($this->db->get('tbl_event_shop')->num_rows() == 0){
			$data = [
				'vendorId' => $vendorId,
				'shopDesign' => $design
			];
			return $this->db->insert('tbl_event_shop',$data);
		}
		$this->db->set('shopDesign', $design);
		$this->db->where('vendorId', $vendorId);
		return $this->db->update('tbl_event_shop');
	}

	public function update_email_template($id, $emailId){
		$this->db->set('emailId', $emailId);
		$this->db->where('id', $id);
		return $this->db->update('tbl_event_tickets');
	}

	public function update_group($id, $param, $value){
		$this->db->set($param, $value);
		$this->db->where('id', $id);
		return $this->db->update('tbl_ticket_groups');
	}

	public function update_ticket_group($tickets){
		foreach($tickets as $key => $ticket){
			$groupId = $key;
			$ids = explode(',', $ticket[0]);
			foreach($ids as $i => $id){
				$position = $ticket[1][$id];
				$this->db->set('ticketGroupId', $groupId);
				$this->db->set('ticketOrder', $position);
				$this->db->where('id', $id);
				$this->db->update('tbl_event_tickets');
			}
		}
		return ;
	}

	public function update_ticket($id, $param, $value){
		$this->db->set($param, $value);
		if($param == 'ticketCurrency'){
			$this->db->where('ticketId', $id);
			return $this->db->update('tbl_ticket_options');
		}
		$this->db->where('id', $id);
		return $this->db->update('tbl_event_tickets');
	}

	public function delete_ticket($ticketId){
		$this->db->where('id', $ticketId);
		$this->db->delete('tbl_event_tickets');
		$this->db->where('ticketId', $ticketId);
		return $this->db->delete('tbl_ticket_options');
	}

	public function delete_group($groupId){
		$this->db->where('id', $groupId);
		$this->db->delete('tbl_ticket_groups');
		$this->db->set('ticketGroupId', '0');
		$this->db->where('ticketGroupId', $groupId);
		return $this->db->update('tbl_event_tickets');
	}

	public function get_design($vendor_id){

		$this->db->select('shopDesign')
		->from('tbl_events')
		->where('vendorId',$vendor_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->first_row();
			return $result->shopDesign;
		}

		return false;
	}

	public function get_event_design($vendor_id, $eventId){

		$this->db->select('shopDesign')
		->from('tbl_events')
		->where('vendorId',$vendor_id)
		->where('id',$eventId);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->first_row();
			return $result->shopDesign;
		}

		return false;
	}

	public function get_vendor_design($vendor_id){

		$this->db->select('shopDesign')
		->from('tbl_event_shop')
		->where('vendorId',$vendor_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->first_row();
			return $result->shopDesign;
		}

		return false;
	}

	public function get_payment_methods($vendor_id){

		$this->db->select('paymentMethod, percent, amount, vendorCost')
		->from('tbl_shop_payment_methods')
		->where('vendorId',$vendor_id)
		->where('productGroup','E-Ticketing');
		$query = $this->db->get();
		$results = $query->result_array();
		$ticketing = [];
		foreach($results as $result){
			$ticketing[$result['paymentMethod']] = [
				'percent' => $result['percent'],
				'amount' => $result['amount'],
				'vendorCost' => $result['vendorCost']
			];
		}
		return $ticketing;
	}

	function get_active_payment_methods($vendor_id){

		$this->db->select('paymentMethod, percent, amount')
		->from('tbl_shop_payment_methods')
		->where(
			[
				'vendorId' => $vendor_id,
				'productGroup' => 'E-Ticketing',
				'active' => '1'
			]
		);
		$query = $this->db->get();
		$results = $query->result_array();
		$ticketing = [];
		foreach($results as $result){
			$ticketing[] = $result['paymentMethod'];
		}
		return $ticketing;
	}

	public function get_usershorturl($eventId)
	{
		$this->db->select('usershorturl');
		$this->db->from('tbl_events');
		$this->db->join('tbl_user', 'tbl_user.id = tbl_events.vendorId', 'left');
		$this->db->where('tbl_events.id', $eventId);
		$query = $this->db->get();
		if($query->num_rows() > 0 ){
			$result = $query->first_row();
			return $result->usershorturl;
		}

		return false;
	}

	function save_event_reservations($userInfo, $tickets = array(), $customer, $tag)
	{
		if(!isset($userInfo['email'])){ return; }

		$reservationIds = [];

		foreach($tickets as $ticket) {

			$quantityId = intval($ticket['quantity']);

			for ($i = 0; $i < $quantityId; $i++) {
				$insert = [
					'customer' => $customer,
					'eventid' => $ticket['id'],
					'eventdate' => date('Y-m-d', strtotime($ticket['startDate'])),
					'bookdatetime' => date('Y-m-d H:i:s'),
					'timefrom' => $ticket['startTime'],
					'timeto' => $ticket['endTime'],
					'price' => $ticket['price'],
					'ticketFee' => ($ticket['ticketFee'] != null) ? $ticket['ticketFee'] : 0,
					'numberofpersons' => ($ticket['numberofpersons'] != null && is_numeric($ticket['numberofpersons'])) ? $ticket['numberofpersons'] : 1,
					'name' => $userInfo['name'],
					'email' => $userInfo['email'],
					'age' => $userInfo['age'],
					'gender' => $userInfo['gender'],
					'mobilephone' => $userInfo['mobileNumber'],
					'Address' => $userInfo['address'],
					'zipcode' => $userInfo['zipcode'],
					'city' => $userInfo['city'],
					'country' => $userInfo['country'],
					'ticketDescription' => $ticket['descript'],
					'ticketType' => ($ticket['ticketType'] != null) ? $ticket['ticketType'] : 0,
					'paid' => '0',
					'tag' => $tag,
					'isTicket' => '1'
					
				];
				

				if(!$this->validateInsertArray($insert)){
					continue;
				}
				$reservationIds[] = $this->insertTicket($insert);
			}
		}

		return $reservationIds;
	}

	private function insertTicket(array $ticket): string
	{

		$set = '3456789abcdefghjkmnpqrstvwxyABCDEFGHJKLMNPQRSTVWXY';
		$ticket['reservationId'] = 'T-' . substr(str_shuffle($set), 0, 16);

		if (!$this->db->insert('tbl_bookandpay', $ticket)) {
			$this->insertTicket($ticket, true);
		}

		return $this->db->insert_id();
	}

	function save_guest_reservations($data, $ticketQuantity){
		$reservationIds = [];
		for($i = 0; $i < $ticketQuantity; $i++){
			$data['voucher'] = $this->generateNewVoucher();
			$reservationIds[] = $this->insertTicket($data);
		}
		return $reservationIds;
	}

	function update_reservation_amount($reservationId, $amount){
		$this->db->where('reservationId', $reservationId);
		$this->db->update('tbl_bookandpay',['amount' => $amount]);
		return true;
	}

	public function get_event_report($vendorId, $eventId, $sql='')
	{
		$query = $this->db->query("SELECT tbl_bookandpay.id, reservationId, reservationtime, price,numberofpersons,price as amount, name, age, gender, mobilephone, email, tbl_bookandpay.ticketDescription, ticketQuantity, TransactionID, tag
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND tbl_bookandpay.customer = ".$vendorId." AND tbl_events.id = ".$eventId." $sql
		ORDER BY reservationtime DESC");
		return $query->result_array();
	}

	public function get_events_report($vendorId, $sql='')
	{
		$query = $this->db->query("SELECT tbl_bookandpay.id, reservationId, reservationtime, price,numberofpersons, price as amount, name, age, gender, mobilephone, email, tbl_bookandpay.ticketDescription, eventname, TransactionID, tag
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND tbl_bookandpay.customer = ".$vendorId." $sql
		ORDER BY reservationtime DESC");
		return $query->result_array();
	}

	public function get_events_stats($vendorId, $sql='')
	{
		$query = $this->db->query("SELECT tbl_events.id as eventId, tbl_event_tickets.id, eventname, tbl_event_tickets.ticketDescription, (tbl_bookandpay.price+tbl_bookandpay.ticketFee) as amount, tbl_event_shop_tags.tag, paymentMethod
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		LEFT JOIN tbl_event_shop_tags ON tbl_bookandpay.tag = tbl_event_shop_tags.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND tbl_bookandpay.customer = ".$vendorId." $sql");
		$results = $query->result_array();
		
		$tickets = [];
		foreach($results as $key => $result){
			$eventId = $result['eventId'];
			$ticketId = $result['id'];
			$tag = empty($result['tag']) ? 'directly' : $result['tag'];
			$paymentMethod = empty($result['paymentMethod']) ? 'not saved' : $result['paymentMethod'];
			
			if(isset($tickets[$eventId])){
				$tickets[$eventId]['booking_number'] += 1;
				$tickets[$eventId]['amount'] += floatval($result['amount']);
			} else {
				$tickets[$eventId]['booking_number'] = 1;
				$tickets[$eventId]['amount'] = floatval($result['amount']);
	
			}

			
			if(isset($tickets['booking_number'][$ticketId])){
				$tickets['booking_number'][$ticketId] += 1;
				$tickets['amount'][$ticketId] += floatval($result['amount']);
			} else {
				$tickets['booking_number'][$ticketId] = 1;
				$tickets['amount'][$ticketId] = floatval($result['amount']);
	
			}

			$tickets[$eventId][$ticketId] = $result;

			

			if(isset($tickets['tag'][$eventId][$tag])){
				$tickets['tag'][$eventId][$tag]['booking_number'] += 1;
			} else {
				$tickets['tag'][$eventId][$tag]['booking_number'] = 1;
			}

			if(isset($tickets['tag'][$eventId][$paymentMethod])){
				$tickets['tag'][$eventId][$paymentMethod]['amount'] += 1;
			} else {
				$tickets['tag'][$eventId][$paymentMethod]['amount'] = 1;
			}

			
			
		}

		return $tickets;
	}

	public function get_tickets_gender($vendorId)
	{
		$query = $this->db->query("SELECT tbl_events.id as eventId, tbl_event_tickets.id, tbl_event_tickets.ticketDescription, eventname, gender, tbl_event_shop_tags.tag, TIMESTAMPDIFF(YEAR, age, CURDATE()) AS age
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		LEFT JOIN tbl_event_shop_tags ON tbl_bookandpay.tag = tbl_event_shop_tags.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND tbl_bookandpay.customer = ".$vendorId." 
		");
		$results = $query->result_array();
		$tickets = [];
		foreach($results as $result){
			$eventId = $result['eventId'];
			$tag = empty($result['tag']) ? 'directly' : $result['tag'];
			$ticketId = $result['id'];

			$tickets[$eventId][$ticketId]['ticketDescription'] = $result['ticketDescription'];
			$tickets[$eventId][$ticketId]['eventname'] = $result['eventname'];

			if(!isset($tickets['tag'][$eventId][$tag]['male_tag'])){
				$tickets['tag'][$eventId][$tag]['male_tag'] = 0;
			}

			if(!isset($tickets['tag'][$eventId][$tag]['female_tag'])){
				$tickets['tag'][$eventId][$tag]['female_tag'] = 0;
			}

			if(!isset($tickets[$eventId][$ticketId]['male'])){
				$tickets[$eventId][$ticketId]['male'] = 0;
			}

			if(!isset($tickets[$eventId][$ticketId]['female'])){
				$tickets[$eventId][$ticketId]['female'] = 0;
			}

			if($result['gender'] == 'male'){
				$tickets[$eventId][$ticketId]['male'] += 1;
				$tickets['tag'][$eventId][$tag]['male_tag'] += 1;
			} else if($result['gender'] == 'female'){
				$tickets[$eventId][$ticketId]['female'] += 1;
				$tickets['tag'][$eventId][$tag]['female_tag'] += 1;
			}


		}
		$tickets['avg_age']['male'] = $this->get_age_avg($vendorId, 'male');
		$tickets['avg_age']['female'] = $this->get_age_avg($vendorId, 'female');
		return $tickets;
	}

	public function get_financial_report($vendorId, $sql='')
	{
		$query = $this->db->query("SELECT tbl_bookandpay.id as bookandpay_id, reservationId, reservationtime, price, numberofpersons, ticketFee, name, age, gender, mobilephone, email, tbl_event_tickets.ticketDescription, eventname, tbl_bookandpay.tag, tbl_event_shop_tags.tag as tagName
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		LEFT JOIN tbl_event_shop_tags ON tbl_bookandpay.tag = tbl_event_shop_tags.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND tbl_bookandpay.customer = ".$vendorId." $sql
		ORDER BY reservationtime DESC");
		return $query->result_array();
	}


	public function get_booking_report_of_days($vendorId, $eventId, $sql='')
	{
		$query = $this->db->query("SELECT DATE(reservationtime) AS day_date,  eventdate, reservationtime, sum(tbl_bookandpay.id) AS tickets 
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.customer = ".$vendorId." AND tbl_bookandpay.ticketDescription <> '' AND paid='1' AND tbl_events.id = ".$eventId." $sql  GROUP BY day_date 
		ORDER BY day_date ASC");
		return $query->result_array();
	}

	public function get_booking_report_of_tickets($vendorId, $eventId, $sql='')
	{
		$query = $this->db->query("SELECT DATE(reservationtime) AS day_date, tbl_event_tickets.ticketDescription, COUNT(tbl_event_tickets.id) AS tickets
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.customer = ".$vendorId." AND tbl_bookandpay.ticketDescription <> '' AND paid='1' AND tbl_events.id = ".$eventId." $sql  GROUP BY tbl_event_tickets.id 
		ORDER BY tbl_bookandpay.reservationtime ASC");
		return $query->result_array();
	}

	public function get_clearing_event_stats($vendorId, $eventId) : array
	{
		$query = $this->db->query("SELECT tbl_events.id, COUNT(tbl_bookandpay.id) AS tickets_sold, SUM(tbl_bookandpay.price) as amount, SUM(tbl_bookandpay.ticketFee) as totalTicketFee, SUM(tbl_bookandpay.price+tbl_bookandpay.ticketFee) as totalAmount
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.customer = ".$vendorId." AND tbl_bookandpay.ticketDescription <> '' AND SpotId = '0' AND paid='1' AND tbl_events.id = ".$eventId."
		GROUP BY tbl_events.id");
		$stats = (array) $query->first_row();
		$stats['totalOrders'] = $this->get_total_event_orders($vendorId, $eventId);
		return $stats;

	} 

	public function get_total_event_orders($vendorId, $eventId) : int
	{
		$query = $this->db->query("SELECT tbl_bookandpay.id
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.customer = ".$vendorId." AND tbl_bookandpay.ticketDescription <> '' AND SpotId = '0' AND paid='1' AND tbl_events.id = ".$eventId."
		GROUP BY TransactionID");
		return $query->num_rows();
	} 

	public function get_payment_methods_stats($vendorId, $eventId)
	{
		$query = $this->db->query("SELECT tbl_bookandpay.id, paymentMethod, tbl_bookandpay.price
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.customer ='".$vendorId."' AND paymentMethod <> '' AND paid='1' AND tbl_events.id='".$eventId."' AND tbl_bookandpay.ticketDescription <> '' GROUP BY tbl_bookandpay.id");
		$results = $query->result_array();

		$paymentEngineFee = 0;
		$promoterPaid = 0;
		$paymentMethods = $this->get_payment_methods($vendorId);

		if(is_array($results) && count($results)){
			foreach($results as $result){
				$paymentMethodFee = $this->get_payment_methods_fee($paymentMethods, $result['paymentMethod']);
				$percentAmount = (floatval($paymentMethodFee['percent'])*floatval($result['price'])) / 100;
				$paymentEngineFee += $percentAmount + $paymentMethodFee['amount'];

				if($paymentMethodFee['vendorCost'] == '1'){
					$promoterPaid += $percentAmount + $paymentMethodFee['amount'];
				}

			}
		}

		$newData = [
			'paymentEngineFee' => $paymentEngineFee,
			'promoterPaid' => $promoterPaid
		];

		return $newData;
	}  

	public function get_reservations_stats_by_tags($vendorId)
	{
		$query = $this->db->query("SELECT tbl_events.eventname, tbl_bookandpay.price, tbl_event_shop_tags.tag
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		INNER JOIN tbl_event_shop_tags ON tbl_bookandpay.tag = tbl_event_shop_tags.id
		WHERE tbl_bookandpay.customer ='".$vendorId."' AND paid='1' AND tbl_bookandpay.ticketDescription <> '' 
		GROUP BY tbl_bookandpay.id");
		$results = $query->result_array();
		$reservations = [];
		if($query->num_rows() < 1){
			return $reservations;
		}
		
		foreach($results as $key => $result){
			$tag = $result['tag'];
			$event = $result['eventname'];

			$reservations['tags'][] = $tag;
			$reservations['events'][] = $event;
			
			if(!isset($reservations['sold_tickets'][$tag][$event])) {
				$reservations['sold_tickets'][$tag][$event] = 1;
				$reservations['amount'][$tag][$event] = floatval($result['price']);
				
			} else {
				$reservations['sold_tickets'][$tag][$event] += 1;
				$reservations['amount'][$tag][$event] += floatval($result['price']);
			}
			
			
			
		}

		return $reservations;

	}

	function get_tickets_report($vendor_id, $eventId, $days = true, $sql=''){
		if(!$days){
		    $results = $this->get_booking_report_of_tickets($vendor_id, $eventId, $sql);
			$newData = $this->_tickets_report($results);
			return $newData;

		}

		$results = $this->get_booking_report_of_days($vendor_id, $eventId, $sql);
		$tickets = [];
		$newData = [];
		$maxDays = 0;
		foreach($results as $key => $result){
			$reservationDate = $result['day_date'];
			$eventDate = $result['eventdate'];
			$dStart = new DateTime($reservationDate);
			$dEnd  = new DateTime($eventDate);
			$dDiff = $dStart->diff($dEnd);
			$days = abs($dDiff->format('%r%a'));
			if($days > $maxDays){
				$maxDays = $days;
			}
			$tickets[$days] = $result['tickets'];
		}
	
		for($i = $maxDays; $i > 0; $i--){
			
			$newData[] = [
				"days" => ($i == 1) ? $i.' day' : $i.' days',
				"tickets" => isset($tickets[$i]) ? (int) $tickets[$i] : 0,
			];
		}
		return $newData;
	}

	private function _tickets_report($results){
		$ticketTypes = [];
		$ticketsData = [];
		foreach($results as $key => $result){
			$ticketsData[$result['day_date']][$result['ticketDescription']] = intval($result['tickets']);

			$ticketTypes[] = $result['ticketDescription'];
		}

		$length = count($ticketTypes);
		$j = 0;
		$newData = [];
		foreach($ticketsData as $key => $data){
			$newData[$j]["days"] = $key;
			for($i=0;$i<$length; $i++){
				$ticketType = $ticketTypes[$i];
				$newData[$j][$ticketType] = isset($data[$ticketType]) ? intval($data[$ticketType]) : 0;
				
			}
			$j++;
		}

		return $newData;
	}

	function get_tickets_report_types($vendor_id, $eventId){
		$results = $this->get_booking_report_of_tickets($vendor_id, $eventId);
		$ticketTypes = [];
		foreach($results as $key => $result){

			$ticketTypes[] = $result['ticketDescription'];
		}

		return $ticketTypes;
	}




	public function get_all_event_tickets($vendor_id,$eventId)
	{
		$this->db->trans_start();
		$this->db->select('tbl_event_tickets.id as ticketId, ticketDescription');
		$this->db->from('tbl_event_tickets');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_event_tickets.eventId', 'left');
		$this->db->where('vendorId', $vendor_id);
		$this->db->where('tbl_event_tickets.eventId', $eventId);
		$query = $this->db->get();
		$this->db->trans_complete();
		return $query->result_array();
	}

	public function get_guestlist($eventId, $vendorId)
	{
		$this->db->select('tbl_guestlist.*, tbl_bookandpay.id as bookandpay_id');
		$this->db->from('tbl_guestlist');
		$this->db->join('tbl_bookandpay', 'tbl_bookandpay.TransactionID = tbl_guestlist.transactionId', 'left');
		$this->db->where('vendorId', $vendorId);
		$this->db->where('tbl_guestlist.eventId', $eventId);
		$this->db->group_by('tbl_guestlist.id');
		$query = $this->db->get();
		return $query->result_array();
	}

	private function get_guestlist_count($ticketId)
	{
		$this->db->select('sum(ticketQuantity) as count_ticket');
		$this->db->from('tbl_guestlist');
		$this->db->where('ticketId', $ticketId);
		$this->db->where('eventId<>', '0');
		$this->db->group_by('ticketId');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->first_row();
			return $result->count_ticket;
			
		}
		return 0;
	}

	public function get_guestlists($vendorId)
	{
		$this->db->select('tbl_guestlist.*');
		$this->db->from('tbl_guestlist');
		$this->db->join('tbl_events', 'tbl_events.id = tbl_guestlist.eventId', 'left');
		$this->db->where('tbl_events.vendorId', $vendorId);
		$query = $this->db->get();
		return $query->result_array();
	}

	private function get_tickets_used($eventId)
	{
		$this->db->trans_start();
		$query = $this->db->query("SELECT tbl_event_tickets.id, COUNT(tbl_bookandpay.id) AS ticket_used
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_events.id = ".$eventId." AND paid = 1 AND SpotId = '0' AND tbl_bookandpay.ticketDescription <> ''
		GROUP BY tbl_event_tickets.id");
		$this->db->trans_complete();
		$results = $query->result_array();
		$tickets = [];
		foreach($results as $result){
			$ticketId = $result['id'];
			$tickets[$ticketId] = $result['ticket_used'];
		}
		return $tickets;
	}

	private function get_ticket_used($eventId)
	{
		$this->db->trans_start();
		$query = $this->db->query("SELECT tbl_event_tickets.id, COUNT(tbl_bookandpay.eventid) AS ticket_used
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		WHERE tbl_event_tickets.id = ".$eventId." AND paid = 1
		GROUP BY tbl_bookandpay.eventid");
		$this->db->trans_complete();
		return $query->first_row();
	}

	public function get_vendor_cost($vendorId)
	{
		$this->db->trans_start();
		$this->db->select('paymentMethod, vendorCost');
		$this->db->from('tbl_shop_payment_methods');
		$this->db->where('vendorId', $vendorId);
		$this->db->where('productGroup', 'E-Ticketing');
		$query = $this->db->get();
		$this->db->trans_complete();
		$results = $query->result_array();
		$vendorCosts = [];
		foreach($results as $result){
			$paymentMethod = $result['paymentMethod'];
			$vendorCosts[$paymentMethod] = $result['vendorCost'];
		}
		return $vendorCosts;
	}

	private function verify_soldout_fase($eventId, $results){
		$dt = new DateTime('now', new DateTimeZone('Europe/Amsterdam'));
        $date = $dt->format('Y-m-d H:i:s');
		$tickets = [];
		foreach($results as $result){
			$ticketId = $result['ticketId'];
			$tickets_used = $this->get_tickets_used($eventId);
			$ticket_used = isset($tickets_used[$ticketId]) ? $tickets_used[$ticketId] : 0;
			$ticket_available = intval($result['ticketQuantity']) - intval($ticket_used);
			$tickets[$ticketId]['soldout'] = false;

			if($result['ticketExpired'] == 'manually'){
				$startDt = new DateTime($result['startTimestamp'], new DateTimeZone('Europe/Amsterdam'));
				$startTimestamp = $startDt->format('Y-m-d H:i:s');
				$endDt = new DateTime($result['endTimestamp'], new DateTimeZone('Europe/Amsterdam'));
				$endTimestamp = $endDt->format('Y-m-d H:i:s');
				if($date < $startTimestamp){
					continue;
				}

				if($date > $endTimestamp){
					$tickets[$ticketId]['soldout'] = true;
				}

			}

			if($ticket_available <= 0){
				$tickets[$ticketId]['soldout'] = true;
			}

			
			
		}

		return $tickets;

	}

	private function validateInsertArray($insert){
		if(!$this->validateInteger($insert['customer'])) { return false; }
		if(!$this->validateInteger($insert['eventid'])) { return false; }
		if(!$this->validateFloat($insert['price'])) { return false; }
		if(!$this->validateFloat($insert['ticketFee'])) { return false; }
		if(!$this->validateString($insert['name'])) { return false; }
		if(!$this->validateString($insert['email'])) { return false; }
		if(!$this->validateString($insert['city'])) { return false; }
		if(!$this->validateString($insert['ticketDescription'])) { return false; }
		return true;
	}

	private function validateFloat($value){
		return is_numeric($value);
	}

	private function validateInteger($value){
		return (ctype_digit(strval($value)));
	}

	private function validateString($value){
		return is_string($value);
	}

	public function get_shopsettings($vendorId)
	{
		$this->db->select('labels, showAddress, showCountry, showZipcode, showMobileNumber, showAge, googleAnalyticsCode, googleAdwordsConversionId, googleAdwordsConversionLabel, googleTagManagerCode, facebookPixelId, termsofuseFile, closedShopMessage');
		$this->db->where('vendorId', $vendorId);
		$query = $this->db->get('tbl_event_shop');
		return ($this->db->affected_rows()) ? $query->first_row() : null;
	}

	public function save_shopsettings($vendorId, $data)
	{
		$this->db->where('vendorId', $vendorId);
		if($this->db->get('tbl_event_shop')->num_rows() == 0){
			$data['vendorId'] = $vendorId;
			return $this->db->insert('tbl_event_shop',$data);
		}
		$this->db->where('vendorId', $vendorId);
		return $this->db->update('tbl_event_shop',$data);
		
	}

	public function updatePaymentMethod(array $reservationIds, string $paymentMethod): bool
	{
		$this->db->set('paymentMethod', $paymentMethod);
		$this->db->where_in('id', $reservationIds);
		return $this->db->update('tbl_bookandpay');
	}

	public function check_vendor_cost_paid($vendorId)
	{
		$this->db->trans_start();
		$this->db->select('COUNT(id) as unpaid_count');
		$this->db->from('tbl_shop_payment_methods');
		$this->db->where('vendorId', strval($vendorId));
		$this->db->where('vendorCost', '0');
		$this->db->where('productGroup', 'E-Ticketing');
		$query = $this->db->get();
		$this->db->trans_complete();
		$result = $query->first_row();
		if($result->unpaid_count > 0){
			return false;
		}

		return true;
	}

	public function save_event_tags($data)
	{
		$this->db->insert('tbl_event_shop_tags',$data);
		return $this->db->insert_id() ? true : false;
	}

	public function update_event_tags($data, $where)
	{
		$this->db->where($where);
		$this->db->update('tbl_event_shop_tags', $data);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function get_event_tags($where)
	{
		$this->db->where($where);
		$query = $this->db->get('tbl_event_shop_tags');
		return $query->result_array();
	}

	public function delete_event_tags($where)
	{
		$this->db->delete('tbl_event_shop_tags', $where);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function save_event_inputs($data)
	{
		$this->db->insert('tbl_event_inputs',$data);
		return $this->db->insert_id() ? true : false;
	}

	public function update_event_inputs($data, $where)
	{
		$this->db->where($where);
		$this->db->update('tbl_event_inputs', $data);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function get_event_inputs($where)
	{
		$this->db->where($where);
		$query = $this->db->get('tbl_event_inputs');
		return $query->result_array();
	}

	public function delete_event_inputs($where)
	{
		$this->db->delete('tbl_event_inputs', $where);
		return ($this->db->affected_rows() > 0) ? true : false;
	}


	public function get_ticket_bundle_max($groupId, $groupQuantity) : int
	{
		$query = $this->db->query("SELECT count(tbl_event_tickets.id) AS tickets, groupQuantity
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_ticket_groups ON tbl_ticket_groups.id = tbl_event_tickets.ticketGroupId 
		WHERE tbl_ticket_groups.id = ".$groupId." AND tbl_bookandpay.ticketDescription <> '' AND paid = 1
		GROUP BY tbl_ticket_groups.id");
		$result = $query->first_row();
		if(isset($result->groupQuantity)){
			$diff = intval($result->groupQuantity) - intval($result->tickets);
			return $diff;
		} else if(is_numeric($groupQuantity)){
			return $groupQuantity;
		}
		return 999;
	}


	private function _check_ticket_bundle_max($groupId) : bool
	{
		$query = $this->db->query("SELECT count(tbl_event_tickets.id) AS tickets, groupQuantity
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_ticket_groups ON tbl_ticket_groups.id = tbl_event_tickets.ticketGroupId 
		WHERE tbl_ticket_groups.id = ".$groupId." AND tbl_bookandpay.ticketDescription <> '' AND paid = 1
		GROUP BY tbl_ticket_groups.id");
		$result = $query->first_row();
		if(isset($result->tickets) && $result->tickets >= $result->groupQuantity){
			return true;
		}
		return false;
	}

	public function check_ticket_soldout($customer, $ticketId, $ticketQuantity, $maxTicketQuantity) : bool
    {
		//true => soldout
		//false => available tickets

		$dt = new DateTime( 'now');
		$current_timestamp = $dt->format('Y-m-d H:i:s');


        $this->db->select('COUNT(tbl_bookandpay.id) as sold_tickets');
        $this->db->from('tbl_bookandpay');
		$this->db->where('tbl_bookandpay.customer', $customer);
		$this->db->where('tbl_bookandpay.eventid', $ticketId);
		$this->db->where('SpotId', '0');
		$this->db->where('timeslotId', '0');
		$this->db->where('(paid="1" OR DATE_ADD(bookdatetime, INTERVAL 10 MINUTE) >= "'.$current_timestamp.'")', NULL, false);
		$this->db->join('tbl_event_tickets', 'tbl_event_tickets.id = tbl_bookandpay.eventid', 'left');
		
        $query = $this->db->get();
		$result = $query->first_row();

        if($query->num_rows() > 0) {
			$sold_tickets = intval($result->sold_tickets);
			$maxTicketQuantity = intval($maxTicketQuantity);
            $soldout = ($sold_tickets >= $maxTicketQuantity);
			$available_tickets = $maxTicketQuantity - $sold_tickets;
			$soldout = ($soldout === true) ? $soldout : ($ticketQuantity > $available_tickets);
			return $soldout;
        }

        return false;
	}

	public function get_scannedin_by_events($vendorId) : array
	{
		$query = $this->db->query("SELECT tbl_events.StartDate as eventDate, COUNT(tbl_bookandpay.id) as tickets, SUM(numberin) as scannedin
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND SpotId = '0' AND tbl_bookandpay.customer = ".$vendorId."
		GROUP BY tbl_events.id");
		$results = $query->result_array();
		$newData = [];

		foreach($results as $result){

			$newData[] = [
				"date" => $result['eventDate'],//$date,
				"tickets" => (int) $result['tickets'],
				"scanned" => (int) $result['scannedin']
			];

		}

		return $newData;
	}

	public function copy_event($vendorId, $eventId) : bool
	{
		$eventData = $this->get_event_by_id($vendorId, $eventId, false);
		if(is_array($eventData) && count($eventData) > 0){
			$eventData = $eventData[0];
			unset($eventData['id']);
			$createdEventId = $this->save_event($eventData);
			return $this->copy_tickets($eventId, $createdEventId);
		}
		return false;
	}

	public function copy_tickets($eventId, $createdEventId) : bool
	{
		$this->db->select('*');
		$this->db->from('tbl_event_tickets');
		$this->db->where('eventId', $eventId);
		$query = $this->db->get();
		$tickets = $query->result_array();
		if($query->num_rows() > 0){
			foreach($tickets as $ticket){
				$ticketId = $ticket['id'];
				$ticket['eventId'] = $createdEventId;
				unset($ticket['id']);
				$createdTicketId = $this->save_ticket($ticket);
				$ticket_options = $this->copy_ticket_options($ticketId, $createdTicketId);
			}
		}

		return true;
		
	}

	public function copy_ticket_options($ticketId, $createdTicketId) : bool
	{
		$this->db->select('*');
		$this->db->from('tbl_ticket_options');
		$this->db->where('ticketId', $ticketId);
		$query = $this->db->get();
		$ticket_options = (array) $query->first_row();
		if($query->num_rows() > 0){
			unset($ticket_options['id']);
			$ticket_options['ticketId'] = $createdTicketId;
			$this->save_ticket_options($ticket_options);
		}

		return true;
		
	}

	public function get_tags_ticket_sold_stats($vendorId, $eventId, $startDate, $endDate) : array
	{
		$query = $this->db->query("SELECT DATE(reservationtime) as reservationdate, COUNT(tbl_bookandpay.id) as sold_tickets, tbl_event_shop_tags.tag
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		LEFT JOIN tbl_event_shop_tags ON tbl_bookandpay.tag = tbl_event_shop_tags.id
		WHERE tbl_bookandpay.customer ='".$vendorId."' AND tbl_events.id = ".$eventId." AND paid='1' AND tbl_bookandpay.ticketDescription <> '' AND (reservationtime >= '" . $startDate . "' AND reservationtime <= '" . $endDate . "')
		GROUP BY reservationdate, tbl_event_shop_tags.id");

		if($query->num_rows() < 1) return [];

		$results = $query->result_array();
		
		$newData = [];
		$tags = [];

		foreach($results as $result){
			$tags[] = ($result['tag'] == null) ? 'basic' : $result['tag'];
		}

		$tags = array_unique($tags);

		
		foreach($results as $key => $result){
			$date = $result['reservationdate'];
			$tag = ($result['tag'] == null) ? 'No Tags' : $result['tag'];
			
			$exists = isset($newData[$date]);

			if(!$exists) {

			
				$newData[$date] = [
					"date" => $result['reservationdate']
				];
			} 
				$newData[$date][$tag] = floatval($result['sold_tickets']);
	
				foreach($tags as $key => $tag){
						
					if(!isset($newData[$date][$tag])) { 
						$newData[$date] = array_merge($newData[$date], array("$tag" => 0));
						//$data[$tag] = 0;
						//continue;
					}
				}
	
				
				
				
	
	
	
				
			}
	
	
			//$newData['tickets'] = $tickets;
	
			return $newData;

	} 

	public function get_tags_amount_stats($vendorId, $eventId, $startDate, $endDate) : array
	{
		$query = $this->db->query("SELECT DATE(reservationtime) as reservationdate, SUM(tbl_bookandpay.price) as amount, tbl_event_shop_tags.tag
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		LEFT JOIN tbl_event_shop_tags ON tbl_bookandpay.tag = tbl_event_shop_tags.id
		WHERE tbl_bookandpay.customer ='".$vendorId."' AND tbl_events.id = ".$eventId." AND paid='1' AND tbl_bookandpay.ticketDescription <> '' AND (reservationtime >= '" . $startDate . "' AND reservationtime <= '" . $endDate . "')
		GROUP BY reservationdate, tbl_event_shop_tags.id");

		if($query->num_rows() < 1) return [];

		$results = $query->result_array();
		
		$newData = [];
		$tags = [];

		foreach($results as $result){
			$tags[] = ($result['tag'] == null) ? 'No Tags' : $result['tag'];
		}

		$tags = array_unique($tags);

		
		foreach($results as $key => $result){
			$date = $result['reservationdate'];
			$tag = ($result['tag'] == null) ? 'basic' : $result['tag'];
			
			$exists = isset($newData[$date]);

			if(!$exists) {

			
			$newData[$date] = [
				"date" => $result['reservationdate']
			];
		} 
			$newData[$date][$tag] = floatval($result['amount']);

			foreach($tags as $key => $tag){
					
				if(!isset($newData[$date][$tag])) { 
					$newData[$date] = array_merge($newData[$date], array("$tag" => 0));
					//$data[$tag] = 0;
					//continue;
				}
			}

			
			
			



			
		}


		//$newData['tickets'] = $tickets;

		return $newData;

	}
	
	public function save_guest_to_bookandpay($vendorId, $guestId){
		$guest = $this->get_guest_by_id($vendorId, $guestId);
		
		if(!$guest) return false;
		$dt = new DateTime( 'now');
        $bookdatetime = $dt->format('Y-m-d H:i:s');
		$ticket = $this->get_ticket_by_id($vendorId, $guest->ticketId);

		$booking = [
			'customer' => $vendorId,
			'eventId' => $guest->ticketId,
			'eventdate' => date('Y-m-d', strtotime($ticket->StartDate)),
			'bookdatetime' => $bookdatetime,
			'timefrom' => $ticket->StartTime,
			'timeto' => $ticket->EndTime,
			'price' => $ticket->ticketPrice,
            'ticketFee' => ($ticket->ticketFee != null) ? $ticket->ticketFee : 0,
            'paid' => 3,
			'numberofpersons' => ($ticket->numberofpersons != null) ? $ticket->numberofpersons : 1,
			'name' => $guest->guestName,
			'email' => $guest->guestEmail,
			'ticketDescription' => $ticket->ticketDescription,
			'ticketType' => $ticket->ticketType,
            'guestlist' => 1,
            'TransactionID' => $guest->transactionId,
            'isTicket' => 1
        ];

		//var_dump($booking);

		return $this->save_guest_reservations($booking, $guest->ticketQuantity);
		
	}

	public function save_multiple_guests_to_bookandpay($vendorId, $guestIds){
		$guests = $this->get_guests_by_ids($vendorId, $guestIds);
		
		if(count($guests) < 1) return [];
		$dt = new DateTime( 'now');
        $bookdatetime = $dt->format('Y-m-d H:i:s');
		$bookandpay_ids = [];

		foreach($guests as $guest) {
			$ticket = $this->get_ticket_by_id($vendorId, $guest->ticketId);

			$booking = [
				'customer' => $vendorId,
				'eventId' => $guest->ticketId,
				'eventdate' => date('Y-m-d', strtotime($ticket->StartDate)),
				'bookdatetime' => $bookdatetime,
				'timefrom' => $ticket->StartTime,
				'timeto' => $ticket->EndTime,
				'price' => $ticket->ticketPrice,
				'ticketFee' => ($ticket->ticketFee != null) ? $ticket->ticketFee : 0,
				'paid' => 3,
				'numberofpersons' => ($ticket->numberofpersons != null) ? $ticket->numberofpersons : 1,
				'name' => $guest->guestName,
				'email' => $guest->guestEmail,
				'ticketDescription' => $ticket->ticketDescription,
				'ticketType' => $ticket->ticketType,
				'guestlist' => 1,
				'TransactionID' => $guest->transactionId,
				'isTicket' => 1
			];

			$ids = $this->save_guest_reservations($booking, $guest->ticketQuantity);
			foreach($ids as $id){
				$bookandpay_ids[] = $id;
			}
		}

		

		//var_dump($booking);

		return $bookandpay_ids;
		
	}

	private function generateNewVoucher() : string
	{
		$set = '3456789ABCDEFGHJKLMNPQRSTVWXY';
		$voucher = 'V-' . substr(str_shuffle($set), 0, 6);
        return $voucher;
	}

	private function get_age_avg($vendorId, $gender) : array
	{
		$query = $this->db->query("SELECT tbl_event_tickets.eventId, AVG(TIMESTAMPDIFF(YEAR, age, CURDATE())) AS age_avg, gender
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND age <> '' AND gender = '".$gender."' AND tbl_bookandpay.customer = '".$vendorId."'
		GROUP BY tbl_event_tickets.eventId
		");
		$results = $query->result_array();
		$tickets = [];
		if(is_array($results) && count($results)){
			foreach($results as $result){
				$eventId = $result['eventId'];
				$age = intval($result['age_avg']);
				if($age == 0){
					continue;
				}
				$tickets[$eventId] = intval($result['age_avg']);
			}
			
		}

		return $tickets;
	}

	private function get_payment_methods_fee($paymentMethods, $paymentMethodName){

		$paymentFee = [
			'percent' => 0,
			'amount' => 0,
			'vendorCost' => 0
		];
		
		foreach($paymentMethods as $key => $paymentMethod){
			if($key == $paymentMethodName){
				$paymentFee['percent'] = $paymentMethod['percent'];
				$paymentFee['amount'] = $paymentMethod['amount'];
				$paymentFee['vendorCost'] = $paymentMethod['vendorCost'];
				break;
			}
		}

		return $paymentFee;
	}


}
