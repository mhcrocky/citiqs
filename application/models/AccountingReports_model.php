<?php
class AccountingReports_model extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
	}

	public function get_local_report($vendor_id)
	{
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id,tbl_shop_orders.export_ID, tbl_shop_orders.created AS order_date, tbl_shop_products_extended.vatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.price,
tbl_shop_order_extended.quantity,tbl_shop_orders.waiterTip,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee)*(tbl_shop_vendors.serviceFeeTax/100) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
(tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100) AS EXVATSERVICE,tbl_shop_orders.serviceFee,
tbl_shop_products_extended.price * tbl_shop_order_extended.quantity-tbl_shop_products_extended.price * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.vatpercentage+100) AS VAT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
INNER JOIN tbl_shop_vendors ON  tbl_shop_vendors.vendorId = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = '$vendor_id' AND tbl_shop_orders.paid = '1' AND serviceTypeId = '1'");
		return $query->result_array();
	}


	public function get_delivery_report($vendor_id)
	{
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id,tbl_shop_orders.export_ID, tbl_shop_orders.created AS order_date,tbl_shop_products_extended.deliveryVatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.deliveryPrice AS price,
tbl_shop_order_extended.quantity,tbl_shop_orders.waiterTip,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)  AS EXVATSERVICE,tbl_shop_orders.serviceFee,
(tbl_shop_orders.serviceFee)*(tbl_shop_vendors.serviceFeeTax/100) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
((tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.deliveryVatpercentage+100)
AS EXVAT,tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity-tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.deliveryVatpercentage+100) AS VAT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
INNER JOIN tbl_shop_vendors ON  tbl_shop_vendors.vendorId = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = '$vendor_id' AND tbl_shop_orders.paid = '1' AND serviceTypeId = '2'");
		return $query->result_array();
	}


	public function get_pickup_report($vendor_id)
	{
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id,tbl_shop_orders.export_ID, tbl_shop_orders.created AS order_date,tbl_shop_products_extended.pickupVatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.pickupPrice AS price,
tbl_shop_order_extended.quantity,tbl_shop_orders.waiterTip,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100) AS EXVATSERVICE,tbl_shop_orders.serviceFee,
(tbl_shop_orders.serviceFee)*(tbl_shop_vendors.serviceFeeTax/100) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
((tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.pickupVatpercentage+100) AS EXVAT,
tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity-tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.pickupVatpercentage+100) AS VAT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
INNER JOIN tbl_shop_vendors ON  tbl_shop_vendors.vendorId = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = '$vendor_id' AND tbl_shop_orders.paid = '1' AND serviceTypeId = '3'");
		return $query->result_array();
	}


	public function day_total($vendor_id, $order_type)
	{
		$date = date('Y-m-d');
		$query = $this->db->query("SELECT tbl_shop_spot_types.type, tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS AMOUNT,
tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS deliveryAMOUNT,tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS pickupAMOUNT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = " . $vendor_id . " AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' AND DATE(tbl_shop_orders.created) = '$date' ");
		return $query->result_array();
	}

	public function this_week_total($vendor_id, $order_type)
	{
		$date = date('Y-m-d');
		$query = $this->db->query("SELECT tbl_shop_spot_types.type, tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS AMOUNT,
tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS deliveryAMOUNT,tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS pickupAMOUNT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = " . $vendor_id . " AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' AND tbl_shop_orders.created > DATE_SUB(now(), INTERVAL 7 DAY)");
		return $query->result_array();
	}

	public function last_week_total($vendor_id, $order_type)
	{
		$date = date('Y-m-d');
		$query = $this->db->query("SELECT tbl_shop_spot_types.type, tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS AMOUNT,
tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS deliveryAMOUNT,tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS pickupAMOUNT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = " . $vendor_id . " AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' AND tbl_shop_orders.created > DATE_SUB(now(), INTERVAL 14 DAY) AND tbl_shop_orders.created <= DATE_SUB(now(), INTERVAL 7 DAY)");
		return $query->result_array();
	}


	public function date_range_total($vendor_id, $min_date, $max_date, $order_type)
	{
		$query = $this->db->query("SELECT tbl_shop_spot_types.type, tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS AMOUNT,
tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS deliveryAMOUNT,tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS pickupAMOUNT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = " . $vendor_id . " AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type'
AND tbl_shop_orders.created >= $min_date AND tbl_shop_orders.created <= $max_date");
		return $query->result_array();
	}


	public function get_date_range_totals($vendor_id, $min_date, $max_date)
	{
		$local_results = $this->date_range_total($vendor_id, $min_date, $max_date, 'local');
		$delivery_results = $this->date_range_total($vendor_id, $min_date, $max_date, 'delivery');
		$pickup_results = $this->date_range_total($vendor_id, $min_date, $max_date, 'pickup');
		$local_total = 0;
		$delivery_total = 0;
		$pickup_total = 0;
		foreach ($local_results as $local_result) {
			$local_total = $local_total + floatval($local_result['AMOUNT']);
		}
		foreach ($delivery_results as $delivery_result) {
			$delivery_total = $delivery_total + floatval($delivery_result['deliveryAMOUNT']);
		}
		foreach ($pickup_results as $pickup_result) {
			$pickup_total = $pickup_total + floatval($pickup_result['pickupAMOUNT']);
		}
		$total = $local_total + $delivery_total + $pickup_total;
		$totals = array(
			'total' => $total,
			'local' => $local_total,
			'delivery' => $delivery_total,
			'pickup' => $pickup_total
		);
		return $totals;
	}

	public function get_day_totals($vendor_id)
	{
		$local_results = $this->day_total($vendor_id, 'local');
		$delivery_results = $this->day_total($vendor_id, 'delivery');
		$pickup_results = $this->day_total($vendor_id, 'pickup');
		$local_total = 0;
		$delivery_total = 0;
		$pickup_total = 0;
		foreach ($local_results as $local_result) {
			$local_total = $local_total + floatval($local_result['AMOUNT']);
		}
		foreach ($delivery_results as $delivery_result) {
			$delivery_total = $delivery_total + floatval($delivery_result['deliveryAMOUNT']);
		}
		foreach ($pickup_results as $pickup_result) {
			$pickup_total = $pickup_total + floatval($pickup_result['pickupAMOUNT']);
		}
		$total = $local_total + $delivery_total + $pickup_total;
		$totals = array(
			'total' => $total,
			'local' => $local_total,
			'delivery' => $delivery_total,
			'pickup' => $pickup_total
		);
		return $totals;
	}

	public function get_this_week_totals($vendor_id)
	{
		$local_results = $this->this_week_total($vendor_id, 'local');
		$delivery_results = $this->this_week_total($vendor_id, 'delivery');
		$pickup_results = $this->this_week_total($vendor_id, 'pickup');
		$local_total = 0;
		$delivery_total = 0;
		$pickup_total = 0;
		foreach ($local_results as $local_result) {
			$local_total = $local_total + floatval($local_result['AMOUNT']);
		}
		foreach ($delivery_results as $delivery_result) {
			$delivery_total = $delivery_total + floatval($delivery_result['deliveryAMOUNT']);
		}
		foreach ($pickup_results as $pickup_result) {
			$pickup_total = $pickup_total + floatval($pickup_result['pickupAMOUNT']);
		}
		$total = $local_total + $delivery_total + $pickup_total;
		$totals = array(
			'total' => $total,
			'local' => $local_total,
			'delivery' => $delivery_total,
			'pickup' => $pickup_total
		);
		return $totals;
	}


	public function get_last_week_compare($vendor_id)
	{
		$local_results = $this->last_week_total($vendor_id, 'local');
		$delivery_results = $this->last_week_total($vendor_id, 'delivery');
		$pickup_results = $this->last_week_total($vendor_id, 'pickup');
		$local_total = 0;
		$delivery_total = 0;
		$pickup_total = 0;
		foreach ($local_results as $local_result) {
			$local_total = $local_total + floatval($local_result['AMOUNT']);
		}
		foreach ($delivery_results as $delivery_result) {
			$delivery_total = $delivery_total + floatval($delivery_result['deliveryAMOUNT']);
		}
		foreach ($pickup_results as $pickup_result) {
			$pickup_total = $pickup_total + floatval($pickup_result['pickupAMOUNT']);
		}
		$total = $local_total + $delivery_total + $pickup_total;
		$this_week = $this->get_this_week_totals($vendor_id);
		$perc_total = intVal(($this_week['total'] - $total) / ($this->division($this_week['total'])) * 100);
		$perc_local = intVal(($this_week['local'] - $local_total) / ($this->division($this_week['local'])) * 100);
		$perc_delivery = intVal(($this_week['delivery'] - $delivery_total) / ($this->division($this_week['delivery'])) * 100);
		$perc_pickup = intVal(($this_week['pickup'] - $pickup_total) / ($this->division($this_week['pickup'])) * 100);

		$perc_totals = array(
			'total' => $perc_total,
			'local' => $perc_local,
			'delivery' => $perc_delivery,
			'pickup' => $perc_pickup
		);
		return $perc_totals;
	}

	public function division($value)
	{
		if ($value == 0) {
			return 1;
		}
		return $value;
	}

	public function get_service_types()
	{
		$query = $this->db->get('tbl_shop_spot_types');
		return $query->result_array();
	}

	function sortWidgets($userId)
	{
		$sort = $this->input->post('sort') ?? '';
		$row_sort = $this->input->post('row_sort') ?? '';
		$sortExists = $this->db->select('*')->from('tbl_widgets')->where('user_id', $userId)->get();
		if ($sortExists->num_rows() > 0) {
			if (!empty($sort)) {
				$this->db->set('sort', $sort);
			} else {
				$this->db->set('row_sort', $row_sort);
			}
			$this->db->where('user_id', $userId);
			return $this->db->update('tbl_widgets');
		}
		$data = array(
			'sort' => $sort,
			'row_sort' => $row_sort,
			'user_id' => $userId
		);
		return $this->db->insert('tbl_widgets', $data);
	}

	function sortedWidgets($userId)
	{
		// $query = $this->db->select('*')->from('tbl_widgets')->where('user_id',$userId)->get();
		// if($query->num_rows() > 0){
		// 	return $query->result_array()[0];
		// }
		$data = ['sort' => '', 'row_sort' => ''];
		return $data;
	}
}
