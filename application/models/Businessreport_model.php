<?php
class Businessreport_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
	}

	public function get_local_report($vendor_id)
	{
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id, tbl_shop_orders.created AS order_date, tbl_shop_products_extended.vatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.price,
tbl_shop_order_extended.quantity,tbl_shop_orders.waiterTip,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee - (tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
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


	public function get_delivery_report($vendor_id){
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id, tbl_shop_orders.created AS order_date,tbl_shop_products_extended.deliveryVatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.deliveryPrice AS price,
tbl_shop_order_extended.quantity,tbl_shop_orders.waiterTip,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)  AS EXVATSERVICE,tbl_shop_orders.serviceFee,
(tbl_shop_orders.serviceFee - (tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
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


	public function get_pickup_report($vendor_id){
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id, tbl_shop_orders.created AS order_date,tbl_shop_products_extended.pickupVatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.pickupPrice AS price,
tbl_shop_order_extended.quantity,tbl_shop_orders.waiterTip,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100) AS EXVATSERVICE,tbl_shop_orders.serviceFee,
(tbl_shop_orders.serviceFee - (tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
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
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' AND DATE(tbl_shop_orders.created) = '$date' ");
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
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' AND tbl_shop_orders.created > DATE_SUB(now(), INTERVAL 7 DAY)");
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
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' AND tbl_shop_orders.created > DATE_SUB(now(), INTERVAL 14 DAY) AND tbl_shop_orders.created <= DATE_SUB(now(), INTERVAL 7 DAY)");
		return $query->result_array();
	}


	public function date_range_total($vendor_id, $min_date, $max_date, $order_type, $sql='')
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
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' 
AND tbl_shop_orders.created >= $min_date AND tbl_shop_orders.created <= $max_date $sql");
		return $query->result_array();
	}


	public function get_day_orders($vendor_id)
	{
		$date = date('Y-m-d');
		$query = $this->db->query("SELECT tbl_shop_orders.id
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND DATE(tbl_shop_orders.created) = '$date' 
GROUP BY tbl_shop_orders.id");
		$result = $query->result_array();
		return count($result);
	}

	public function get_this_week_orders($vendor_id)
	{
		$query = $this->db->query("SELECT tbl_shop_orders.id
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND tbl_shop_orders.created > DATE_SUB(now(), INTERVAL 7 DAY)
GROUP BY tbl_shop_orders.id");
		$result = $query->result_array();
		return count($result);
	}

	public function get_last_week_orders($vendor_id)
	{
		$query = $this->db->query("SELECT tbl_shop_orders.id
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' 
AND tbl_shop_orders.created > DATE_SUB(now(), INTERVAL 14 DAY) AND tbl_shop_orders.created <= DATE_SUB(now(), INTERVAL 7 DAY)
GROUP BY tbl_shop_orders.id");
		$result = $query->result_array();
		return count($result);
	}

	public function get_date_range_orders($vendor_id, $min_date, $max_date)
	{
		$query = $this->db->query("SELECT tbl_shop_orders.id
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId 
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1'
AND tbl_shop_orders.created >= $min_date AND tbl_shop_orders.created <= $max_date
GROUP BY tbl_shop_orders.id");
		$result = $query->result_array();
		return count($result);
	}

	public function date_range_report_of_week($vendor_id, $min_date, $max_date, $order_type, $sql='')
	{
		$query = $this->db->query("SELECT DATE_FORMAT(tbl_shop_orders.created ,'%a') AS day_of_week, tbl_shop_spot_types.type, COALESCE(sum(tbl_shop_products_extended.price * tbl_shop_order_extended.quantity),0) AS AMOUNT,
COALESCE(sum(tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity),0) AS deliveryAMOUNT,COALESCE(sum(tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity),0) AS pickupAMOUNT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId 
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' 
AND tbl_shop_orders.created >= $min_date AND tbl_shop_orders.created <= $max_date $sql GROUP BY day_of_week ORDER BY day_of_week");
		return $query->result_array();
	}

	public function date_range_report_of_month($vendor_id, $min_date, $max_date, $order_type, $sql='')
	{
		$query = $this->db->query("SELECT DATE_FORMAT(tbl_shop_orders.created, '%M') AS month, tbl_shop_spot_types.type, sum(tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) AS AMOUNT,
sum(tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) AS deliveryAMOUNT,sum(tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) AS pickupAMOUNT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId 
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' 
AND tbl_shop_orders.created >= $min_date AND tbl_shop_orders.created <= $max_date $sql GROUP BY month ORDER BY tbl_shop_orders.created");
		return $query->result_array();
	}

	public function date_range_report_of_quarter($vendor_id, $min_date, $max_date, $order_type, $sql='')
	{
		$query = $this->db->query("SELECT year(created) as year, quarter(created) as quarter, tbl_shop_spot_types.type, sum(tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) AS AMOUNT,
sum(tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) AS deliveryAMOUNT,sum(tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) AS pickupAMOUNT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId 
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' 
AND tbl_shop_orders.created >= $min_date AND tbl_shop_orders.created <= $max_date $sql GROUP BY year, quarter ORDER BY  year, quarter");
		return $query->result_array();
	}

	public function date_range_report_of_day($vendor_id, $min_date, $max_date, $order_type, $sql='')
	{
		$query = $this->db->query("SELECT DATE(tbl_shop_orders.created) AS day_date, tbl_shop_spot_types.type, sum(tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) AS AMOUNT,
sum(tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) AS deliveryAMOUNT,sum(tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) AS pickupAMOUNT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId 
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' 
AND tbl_shop_orders.created >= $min_date AND tbl_shop_orders.created <= $max_date $sql GROUP BY day_date");
		return $query->result_array();
	}

	public function date_range_report_of_hour($vendor_id, $min_date, $max_date, $order_type, $sql='')
	{
		$query = $this->db->query("SELECT DATE_FORMAT(tbl_shop_orders.created, '%H:00') AS hour, tbl_shop_spot_types.type, sum(tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) AS AMOUNT,
sum(tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) AS deliveryAMOUNT,sum(tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) AS pickupAMOUNT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId 
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' 
AND tbl_shop_orders.created >= $min_date AND tbl_shop_orders.created <= $max_date ".$query." GROUP BY hour ORDER BY hour");
		return $query->result_array();
	}

	public function get_date_range_totals($vendor_id, $min_date, $max_date, $sql=''){
		$local_results = $this->date_range_total($vendor_id, $min_date, $max_date, 'local', $sql);
		$delivery_results = $this->date_range_total($vendor_id, $min_date, $max_date, 'delivery', $sql);
		$pickup_results = $this->date_range_total($vendor_id, $min_date, $max_date, 'pickup', $sql);
		$local_total = 0;
		$delivery_total = 0;
		$pickup_total = 0;
		foreach($local_results as $local_result){
			$local_total = $local_total + floatval($local_result['AMOUNT']);
		}
		foreach($delivery_results as $delivery_result){
			$delivery_total = $delivery_total + floatval($delivery_result['deliveryAMOUNT']);
		}
		foreach($pickup_results as $pickup_result){
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

	public function get_day_totals($vendor_id){
		$local_results = $this->day_total($vendor_id, 'local');
		$delivery_results = $this->day_total($vendor_id, 'delivery');
		$pickup_results = $this->day_total($vendor_id, 'pickup');
		$local_total = 0;
		$delivery_total = 0;
		$pickup_total = 0;
		foreach($local_results as $local_result){
			$local_total = $local_total + floatval($local_result['AMOUNT']);
		}
		foreach($delivery_results as $delivery_result){
			$delivery_total = $delivery_total + floatval($delivery_result['deliveryAMOUNT']);
		}
		foreach($pickup_results as $pickup_result){
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

	public function get_this_week_totals($vendor_id){
		$local_results = $this->this_week_total($vendor_id, 'local');
		$delivery_results = $this->this_week_total($vendor_id, 'delivery');
		$pickup_results = $this->this_week_total($vendor_id, 'pickup');
		$local_total = 0;
		$delivery_total = 0;
		$pickup_total = 0;
		foreach($local_results as $local_result){
			$local_total = $local_total + floatval($local_result['AMOUNT']);
		}
		foreach($delivery_results as $delivery_result){
			$delivery_total = $delivery_total + floatval($delivery_result['deliveryAMOUNT']);
		}
		foreach($pickup_results as $pickup_result){
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


	public function get_last_week_compare($vendor_id){
		$local_results = $this->last_week_total($vendor_id, 'local');
		$delivery_results = $this->last_week_total($vendor_id, 'delivery');
		$pickup_results = $this->last_week_total($vendor_id, 'pickup');
		$local_total = 0;
		$delivery_total = 0;
		$pickup_total = 0;
		foreach($local_results as $local_result){
			$local_total = $local_total + floatval($local_result['AMOUNT']);
		}
		foreach($delivery_results as $delivery_result){
			$delivery_total = $delivery_total + floatval($delivery_result['deliveryAMOUNT']);
		}
		foreach($pickup_results as $pickup_result){
			$pickup_total = $pickup_total + floatval($pickup_result['pickupAMOUNT']);
		}
		$total = $local_total + $delivery_total + $pickup_total;
		$this_week = $this->get_this_week_totals($vendor_id);
		$perc_total = intVal(($this_week['total'] - $total)/($this->division($this_week['total']))*100);
		$perc_local = intVal(($this_week['local'] - $local_total)/($this->division($this_week['local']))*100);
		$perc_delivery = intVal(($this_week['delivery'] - $delivery_total)/($this->division($this_week['delivery']))*100);
		$perc_pickup = intVal(($this_week['pickup'] - $pickup_total)/($this->division($this_week['pickup']))*100);

		$perc_totals = array(
			'total' => $perc_total,
			'local' => $perc_local,
			'delivery' => $perc_delivery,
			'pickup' => $perc_pickup 
		);
		return $perc_totals;
	}

	public function division($value){
		if($value == 0) {
			return 1;
		}
		return $value;
	}

	public function get_service_types(){
		$query = $this->db->get('tbl_shop_spot_types');
		return $query->result_array();
	}

	function sortWidgets($userId){
		$sort = $this->input->post('sort') ?? '';
		$row_sort = $this->input->post('row_sort') ?? '';
        $sortExists = $this->db->select('*')->from('tbl_widgets')->where('user_id',$userId)->get();
        if($sortExists->num_rows() > 0){
			if(!empty($sort)){
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

    function sortedWidgets($userId){
		$query = $this->db->select('*')->from('tbl_widgets')->where('user_id',$userId)->get();
		if($query->num_rows() > 0){
			return $query->result_array()[0];
		}
		$data = ['sort'=>'','row_sort'=>''];
		return $data;
	}
	
	function get_total_report($vendor_id,$min_date, $max_date, $query=''){
		$data = $this->get_date_range_totals($vendor_id, $min_date, $max_date, $query);
		$min_date = str_replace("-","/",$min_date);
		$min_date = str_replace("'","",$min_date);
		$max_date = str_replace("-","/",$max_date);
		$max_date = str_replace("'","",$max_date);
		$newData[0] = [
			"date" => $min_date . ' - ' . $max_date,
			"pickup" => $data["pickup"],
			"delivery" => $data["delivery"],
			"local" => $data["local"]
		];
		return $newData;
	}

	function get_week_report($vendor_id,$min_date, $max_date, $sql=''){
		$local_results = $this->date_range_report_of_week($vendor_id, $min_date, $max_date, 'local', $sql);
		$delivery_results = $this->date_range_report_of_week($vendor_id, $min_date, $max_date, 'delivery', $sql);
		$pickup_results = $this->date_range_report_of_week($vendor_id, $min_date, $max_date, 'pickup', $sql);
		$local = [];
		$delivery = [];
		$pickup = [];
		$newData = [];
		$weekdays = ['Mon','Tue','Wed','Fri','Sat','Sun'];
		foreach($local_results as $local_result){
			$day = $local_result['day_of_week'];
			$local[$day] = $local_result['AMOUNT'];
		}
		foreach($delivery_results as $delivery_result){
			$day = $delivery_result['day_of_week'];
			$delivery[$day] = $delivery_result['deliveryAMOUNT'];
		}
		foreach($pickup_results as $pickup_result){
			$day = $pickup_result['day_of_week'];
			$pickup[$day] = $pickup_result['pickupAMOUNT'];
		}

		foreach($weekdays as $key => $weekday){
			$newData[$key] = [
				"date" => $weekday,
				"pickup" => isset($pickup[$weekday]) ? floatval($pickup[$weekday]) : 0,
				"delivery" => isset($delivery[$weekday]) ? floatval($delivery[$weekday]) : 0,
				"local" => isset($local[$weekday]) ? floatval($local[$weekday]) : 0
			];
		}
		return $newData;
	}

	function get_month_report($vendor_id,$min_date, $max_date, $sql=''){
		$local_results = $this->date_range_report_of_month($vendor_id, $min_date, $max_date, 'local', $sql);
		$delivery_results = $this->date_range_report_of_month($vendor_id, $min_date, $max_date, 'delivery', $sql);
		$pickup_results = $this->date_range_report_of_month($vendor_id, $min_date, $max_date, 'pickup', $sql);
		$local = [];
		$delivery = [];
		$pickup = [];
		$newData = [];
		$months_data = [];
		$months = ['January','February','March','April','May','June','July','August', 'September', 'October', 'November','December'];
		foreach($local_results as $local_result){
			$months_data[] = $local_result['month'];
			$month = $local_result['month'];
			$local[$month] = $local_result['AMOUNT'];
		}
		foreach($delivery_results as $delivery_result){
			$months_data[] = $delivery_result['month'];
			$month = $delivery_result['month'];
			$delivery[$month] = $delivery_result['deliveryAMOUNT'];
		}
		foreach($pickup_results as $pickup_result){
			$months_data[] = $pickup_result['month'];
			$month = $pickup_result['month'];
			$pickup[$month] = $pickup_result['pickupAMOUNT'];
		}

		$diff = array_diff($months,$months_data);
		
		foreach($months as $key => $month){
			
			$newData[$key] = [
				"date" => $month,
				"pickup" => isset($pickup[$month]) ? floatval($pickup[$month]) : 0,
				"delivery" => isset($delivery[$month]) ? floatval($delivery[$month]) : 0,
				"local" => isset($local[$month]) ? floatval($local[$month]) : 0
			];
		}
		return $newData;
	}

	function get_hour_report($vendor_id,$min_date, $max_date, $sql=''){
		$local_results = $this->date_range_report_of_hour($vendor_id, $min_date, $max_date, 'local', $sql);
		$delivery_results = $this->date_range_report_of_hour($vendor_id, $min_date, $max_date, 'delivery', $sql);
		$pickup_results = $this->date_range_report_of_hour($vendor_id, $min_date, $max_date, 'pickup', $sql);
		$local = [];
		$delivery = [];
		$pickup = [];
		$newData = [];
		$hours = [];
		$hours_data = [];
		for($i=0;$i<24; $i++){
			if($i<10){
				$hour = '0'.$i.':00';
			} else {
				$hour = $i.':00';
			}
			$hours[] = $hour;
		}
		foreach($local_results as $local_result){
			$hours_data[] = $local_result['hour'];
			$hour = $local_result['hour'];
			$local[$hour] = $local_result['AMOUNT'];
		}
		foreach($delivery_results as $delivery_result){
			$hours_data[] = $delivery_result['hour'];
			$hour = $delivery_result['month'];
			$delivery[$hour] = $delivery_result['deliveryAMOUNT'];
		}
		foreach($pickup_results as $pickup_result){
			$hours_data[] = $pickup_result['hour'];
			$hour = $pickup_result['hour'];
			$pickup[$hour] = $pickup_result['pickupAMOUNT'];
		}

		$diff = array_diff($hours,$hours_data);
		
		foreach($hours as $key => $hour){
			if(in_array($hour,$diff)){
				continue;
			}
			if($hour == '23:00'){
				$hours[$key+1] = '23:59';
			}
			$newData[$key] = [
				"date" => $hour. ' - ' . $hours[$key+1],
				"pickup" => isset($pickup[$hour]) ? floatval($pickup[$hour]) : 0,
				"delivery" => isset($delivery[$hour]) ? floatval($delivery[$hour]) : 0,
				"local" => isset($local[$hour]) ? floatval($local[$hour]) : 0
			];
		}
		return $newData;
	}

	function get_quarter_report($vendor_id,$min_date, $max_date, $sql=''){
		$local_results = $this->date_range_report_of_quarter($vendor_id, $min_date, $max_date, 'local', $sql);
		$delivery_results = $this->date_range_report_of_quarter($vendor_id, $min_date, $max_date, 'delivery', $sql);
		$pickup_results = $this->date_range_report_of_quarter($vendor_id, $min_date, $max_date, 'pickup', $sql);
		$local = [];
		$delivery = [];
		$pickup = [];
		$newData = [];
		$quarters = [];
		

		foreach($local_results as $local_result){
			$quarters[] = $local_result['quarter'].'-'.$local_result['year'];
			$quarter = $local_result['quarter'].'-'.$local_result['year'];
			$local[$quarter] = $local_result['AMOUNT'];
		}
		foreach($delivery_results as $delivery_result){
			$quarters[] =  $delivery_result['quarter'].'-'.$delivery_result['year'];
			$quarter = $delivery_result['quarter'].'-'.$delivery_result['year'];
			$delivery[$quarter] = $delivery_result['deliveryAMOUNT'];
		}
		foreach($pickup_results as $pickup_result){
			$quarters[] = $pickup_result['quarter'].'-'.$pickup_result['year'];
			$quarter = $pickup_result['quarter'].'-'.$pickup_result['year'];
			$pickup[$quarter] = $pickup_result['pickupAMOUNT'];
		}

		$quarters = array_unique(array_values($quarters));
		function date_sort($a, $b) {
			return strtotime($a) - strtotime($b);
		}
		usort($quarters, "date_sort");
		
		foreach($quarters as $key => $quarter){
			$newData[$key] = [
				"date" => 'Q'.$quarter,
				"pickup" => isset($pickup[$quarter]) ? floatval($pickup[$quarter]) : 0,
				"delivery" => isset($delivery[$quarter]) ? floatval($delivery[$quarter]) : 0,
				"local" => isset($local[$quarter]) ? floatval($local[$quarter]) : 0
			];
		}
		return $newData;
	}

	function get_day_report($vendor_id,$min_date, $max_date, $sql=''){
		$local_results = $this->date_range_report_of_day($vendor_id, $min_date, $max_date, 'local', $sql);
		$delivery_results = $this->date_range_report_of_day($vendor_id, $min_date, $max_date, 'delivery', $sql);
		$pickup_results = $this->date_range_report_of_day($vendor_id, $min_date, $max_date, 'pickup', $sql);
		$local = [];
		$delivery = [];
		$pickup = [];
		$newData = [];
		$days = [];
		foreach($local_results as $local_result){
			$days[] = $local_result['day_date'];
			$day = $local_result['day_date'];
			$local[$day] = $local_result['AMOUNT'];
		}
		foreach($delivery_results as $delivery_result){
			$days[] = $delivery_result['day_date'];
			$day = $delivery_result['day_date'];
			$delivery[$day] = $delivery_result['deliveryAMOUNT'];
		}
		foreach($pickup_results as $pickup_result){
			$days[] = $pickup_result['day_date'];
			$day = $pickup_result['day_date'];
			$pickup[$day] = $pickup_result['pickupAMOUNT'];
		}

		$days = array_unique(array_values($days));
		function date_sort($a, $b) {
			return strtotime($a) - strtotime($b);
		}
		usort($days, "date_sort");
		
		foreach($days as $key => $day){
			$newData[$key] = [
				"date" => $day,
				"pickup" => isset($pickup[$day]) ? floatval($pickup[$day]) : 0,
				"delivery" => isset($delivery[$day]) ? floatval($delivery[$day]) : 0,
				"local" => isset($local[$day]) ? floatval($local[$day]) : 0
			];
		}
		return $newData;
	}

	public function get_report_of($vendor_id,$min_date, $max_date, $selected, $sql=''){
		if($selected == 'month') {return $this->get_month_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'day') {return $this->get_day_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'quarter') {return $this->get_quarter_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'hour') {return $this->get_hour_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'week') {return $this->get_week_report($vendor_id,$min_date, $max_date, $sql);}
		else {return $this->get_total_report($vendor_id,$min_date, $max_date, $sql);}

	}

}
