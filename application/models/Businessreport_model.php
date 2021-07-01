<?php
class Businessreport_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
	}

	public function get_local_report($vendor_id, $sql='')
	{
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id, tbl_shop_orders.voucherAmount AS voucherAmount, tbl_shop_orders.paymentType AS paymenttype, tbl_shop_orders.created AS order_date, tbl_shop_products_extended.vatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.price,
tbl_shop_order_extended.quantity,tbl_shop_orders.waiterTip,tbl_user.username, tbl_user.email,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee - (tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
(tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100) AS EXVATSERVICE,tbl_shop_orders.serviceFee,
tbl_shop_products_extended.price * tbl_shop_order_extended.quantity-tbl_shop_products_extended.price * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.vatpercentage+100) AS VAT,
tbl_shop_voucher.code AS voucherCode, tbl_shop_categories.id AS categoryId, tbl_shop_categories.category AS productCategory
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId 
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
INNER JOIN tbl_user ON  tbl_shop_orders.buyerId = tbl_user.id
INNER JOIN tbl_shop_vendors ON  tbl_shop_vendors.vendorId = tbl_shop_categories.userId 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
LEFT JOIN tbl_shop_voucher ON tbl_shop_voucher.id = tbl_shop_orders.voucherId
WHERE vendor.id = '$vendor_id' AND tbl_shop_orders.paid = '1' AND serviceTypeId = '1' $sql");
		return $query->result_array();
	}


	public function get_delivery_report($vendor_id, $sql=''){
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id, tbl_shop_orders.voucherAmount AS voucherAmount, tbl_shop_orders.paymentType AS paymenttype, tbl_shop_orders.created AS order_date,tbl_shop_products_extended.deliveryVatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.deliveryPrice AS price,
tbl_shop_order_extended.quantity,tbl_shop_orders.waiterTip,tbl_user.username, tbl_user.email,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)  AS EXVATSERVICE,tbl_shop_orders.serviceFee,
(tbl_shop_orders.serviceFee - (tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
((tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.deliveryVatpercentage+100)
AS EXVAT,tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity-tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.deliveryVatpercentage+100) AS VAT,
tbl_shop_voucher.code AS voucherCode, tbl_shop_categories.id AS categoryId, tbl_shop_categories.category AS productCategory
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
INNER JOIN tbl_user ON  tbl_shop_orders.buyerId = tbl_user.id
INNER JOIN tbl_shop_vendors ON  tbl_shop_vendors.vendorId = tbl_shop_categories.userId 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
LEFT JOIN tbl_shop_voucher ON tbl_shop_voucher.id = tbl_shop_orders.voucherId
WHERE vendor.id = '$vendor_id' AND tbl_shop_orders.paid = '1' AND serviceTypeId = '2' $sql");
      return $query->result_array();
	}


	public function get_pickup_report($vendor_id, $sql=''){
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id, tbl_shop_orders.voucherAmount AS voucherAmount, tbl_shop_orders.paymentType AS paymenttype, tbl_shop_orders.created AS order_date,tbl_shop_products_extended.pickupVatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.pickupPrice AS price,
tbl_shop_order_extended.quantity,tbl_shop_orders.waiterTip,tbl_user.username, tbl_user.email,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100) AS EXVATSERVICE,tbl_shop_orders.serviceFee,
(tbl_shop_orders.serviceFee - (tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
((tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.pickupVatpercentage+100) AS EXVAT,
tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity-tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.pickupVatpercentage+100) AS VAT,
tbl_shop_voucher.code AS voucherCode, tbl_shop_categories.id AS categoryId, tbl_shop_categories.category AS productCategory
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
INNER JOIN tbl_user ON  tbl_shop_orders.buyerId = tbl_user.id
INNER JOIN tbl_shop_vendors ON  tbl_shop_vendors.vendorId = tbl_shop_categories.userId 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
LEFT JOIN tbl_shop_voucher ON tbl_shop_voucher.id = tbl_shop_orders.voucherId
WHERE vendor.id = '$vendor_id' AND tbl_shop_orders.paid = '1' AND serviceTypeId = '3' $sql");
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
AND tbl_shop_orders.created >= $min_date AND tbl_shop_orders.created <= $max_date $sql GROUP BY hour ORDER BY hour");
		return $query->result_array();
	}

	public function booking_report($vendor_id, $min_date, $max_date)
	{
		$query = $this->db->query("SELECT DATE(reservationtime) AS created, sum(numberofpersons) AS tickets
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND tbl_bookandpay.customer = ".$vendor_id."
		 AND reservationtime >= $min_date AND reservationtime <= $max_date GROUP BY created");
		$results = $query->result_array();
		$tickets = 0;
		foreach($results as $result){
			$tickets += intval($result['tickets']);
		}
		return $tickets;
	}

	public function booking_report_of_week($vendor_id, $min_date, $max_date)
	{
		$query = $this->db->query("SELECT DATE_FORMAT(reservationtime ,'%a') AS day_of_week, sum(numberofpersons) AS AMOUNT 
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND tbl_bookandpay.customer = ".$vendor_id." AND reservationtime >= $min_date AND reservationtime <= $max_date GROUP BY day_of_week ORDER BY day_of_week");
		return $query->result_array();
	}

	public function booking_report_of_month($vendor_id, $min_date, $max_date)
	{
		$query = $this->db->query("SELECT DATE_FORMAT(reservationtime ,'%M') AS month, sum(numberofpersons) AS AMOUNT
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND tbl_bookandpay.customer = ".$vendor_id." AND reservationtime >= $min_date AND reservationtime <= $max_date GROUP BY month ORDER BY month");
		return $query->result_array();
	}

	public function booking_report_of_quarter($vendor_id, $min_date, $max_date)
	{
		$query = $this->db->query("SELECT year(reservationtime) AS year,quarter(reservationtime) AS quarter, sum(numberofpersons) AS AMOUNT 
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND tbl_bookandpay.customer = ".$vendor_id." AND reservationtime >= $min_date AND reservationtime <= $max_date GROUP BY year ORDER BY year");
		return $query->result_array();
	}

	public function booking_report_of_day($vendor_id, $min_date, $max_date)
	{
		$query = $this->db->query("SELECT DATE(reservationtime) AS day_date, sum(numberofpersons) AS AMOUNT 
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND tbl_bookandpay.customer = ".$vendor_id." AND reservationtime >= $min_date AND reservationtime <= $max_date GROUP BY day_date ORDER BY day_date");
		return $query->result_array();
	}

	public function booking_report_of_hour($vendor_id, $min_date, $max_date)
	{
        $query = $this->db->query("SELECT DATE_FORMAT(reservationtime ,'%H:00') AS hour, sum(numberofpersons) AS AMOUNT
		FROM tbl_bookandpay INNER JOIN tbl_event_tickets ON tbl_bookandpay.eventid = tbl_event_tickets.id 
		INNER JOIN tbl_events ON tbl_event_tickets.eventId = tbl_events.id
		WHERE tbl_bookandpay.paid = '1' AND tbl_bookandpay.ticketDescription <> '' AND tbl_bookandpay.customer = ".$vendor_id." AND reservationtime >= $min_date AND reservationtime <= $max_date GROUP BY hour ORDER BY hour");
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
		$booking = $this->booking_report($vendor_id, $min_date, $max_date);
		$min_date = str_replace("-","/",$min_date);
		$min_date = str_replace("'","",$min_date);
		$max_date = str_replace("-","/",$max_date);
		$max_date = str_replace("'","",$max_date);
		$newData[0] = [
			"date" => $min_date . ' - ' . $max_date,
			"pickup" => $data["pickup"],
			"delivery" => $data["delivery"],
			"local" => $data["local"],
			"invoice" => 0,
			"booking" => $booking
		];
		return $newData;
	}

	function get_week_report($vendor_id,$min_date, $max_date, $sql=''){
		$local_results = $this->date_range_report_of_week($vendor_id, $min_date, $max_date, 'local', $sql);
		$delivery_results = $this->date_range_report_of_week($vendor_id, $min_date, $max_date, 'delivery', $sql);
		$pickup_results = $this->date_range_report_of_week($vendor_id, $min_date, $max_date, 'pickup', $sql);
		$booking_results = $this->booking_report_of_week($vendor_id, $min_date, $max_date);
		$local = [];
		$delivery = [];
		$pickup = [];
		$booking = [];
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
		foreach($booking_results as $booking_result){
			$day = $booking_result['day_of_week'];
			$booking[$day] = $booking_result['AMOUNT'];
		}

		foreach($weekdays as $key => $weekday){
			$newData[$key] = [
				"date" => $weekday,
				"pickup" => isset($pickup[$weekday]) ? floatval($pickup[$weekday]) : 0,
				"delivery" => isset($delivery[$weekday]) ? floatval($delivery[$weekday]) : 0,
				"local" => isset($local[$weekday]) ? floatval($local[$weekday]) : 0,
				"invoice" => 0,
				"booking" => isset($booking[$weekday]) ? floatval($booking[$weekday]) : 0,
			];
		}
		return $newData;
	}

	function get_month_report($vendor_id,$min_date, $max_date, $sql=''){
		$local_results = $this->date_range_report_of_month($vendor_id, $min_date, $max_date, 'local', $sql);
		$delivery_results = $this->date_range_report_of_month($vendor_id, $min_date, $max_date, 'delivery', $sql);
		$pickup_results = $this->date_range_report_of_month($vendor_id, $min_date, $max_date, 'pickup', $sql);
		$booking_results = $this->booking_report_of_month($vendor_id, $min_date, $max_date);
		$local = [];
		$delivery = [];
		$pickup = [];
		$booking = [];
		$newData = [];
		$months_data = [];
		$context = stream_context_create([
            "http" => [
                "header" => "authtoken:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidGlxc3dlYiIsIm5hbWUiOiJ0aXFzd2ViIiwicGFzc3dvcmQiOm51bGwsIkFQSV9USU1FIjoxNTgyNTQ2NTc1fQ.q7ssJqcwsXhuNVDyspGYh_KV7_JsbwS8vq2TT9R-MGk"
                ]
        ]);
        $data = file_get_contents("http://tiqs.com/backoffice/admin/api/invoice/data/".$vendor_id, false, $context );
        $results = json_decode($data);
		$invoice = [];
		$min = explode(" ", $min_date)[0];
		$min = str_replace("'", "", $min);
		$max = explode(" ", $max_date)[0];
		$max = str_replace("'", "", $max);
        foreach($results as $result){

            if(strtotime(date($result->date)) >= strtotime(date($min)) && strtotime(date($result->date)) <= strtotime(date($max)) ){
				$arr_date = explode("-", $result->date);
                $month = $arr_date[1] - 1;
                if(isset($invoice[$month])){
                    $invoice[$month] = $invoice[$month] + $result->total;
                } else {
                    $invoice[$month] = $result->total;
				}
				
                
            }

		}
		//var_dump($results);
		
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
		foreach($booking_results as $booking_result){
			$months_data[] = $booking_result['month'];
			$month = $booking_result['month'];
			$booking[$month] = $booking_result['AMOUNT'];
		}

		$diff = array_diff($months,$months_data);

		foreach($months as $key => $month){
			
			$newData[$key] = [
				"date" => $month,
				"pickup" => isset($pickup[$month]) ? floatval($pickup[$month]) : 0,
				"delivery" => isset($delivery[$month]) ? floatval($delivery[$month]) : 0,
				"local" => isset($local[$month]) ? floatval($local[$month]) : 0,
				"invoice" => isset($invoice[$key]) ? floatval(-1*($invoice[$key])) : 0,
				"booking" => isset($booking[$month]) ? floatval($booking[$month]) : 0
			];
		}
		return $newData;
	}

	function get_hour_report($vendor_id,$min_date, $max_date, $sql=''){
		$local_results = $this->date_range_report_of_hour($vendor_id, $min_date, $max_date, 'local', $sql);
		$delivery_results = $this->date_range_report_of_hour($vendor_id, $min_date, $max_date, 'delivery', $sql);
		$pickup_results = $this->date_range_report_of_hour($vendor_id, $min_date, $max_date, 'pickup', $sql);
		$booking_results = $this->booking_report_of_hour($vendor_id, $min_date, $max_date);
		$local = [];
		$delivery = [];
		$pickup = [];
		$booking = [];
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
		foreach($booking_results as $booking_result){
			$hours_data[] = $booking_result['hour'];
			$hour = $booking_result['hour'];
			$booking[$hour] = $booking_result['AMOUNT'];
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
				"local" => isset($local[$hour]) ? floatval($local[$hour]) : 0,
				"invoice" => 0,
				"booking" => isset($booking[$hour]) ? floatval($booking[$hour]) : 0
			];
		}
		return $newData;
	}

	function get_quarter_report($vendor_id,$min_date, $max_date, $sql=''){
		$local_results = $this->date_range_report_of_quarter($vendor_id, $min_date, $max_date, 'local', $sql);
		$delivery_results = $this->date_range_report_of_quarter($vendor_id, $min_date, $max_date, 'delivery', $sql);
		$pickup_results = $this->date_range_report_of_quarter($vendor_id, $min_date, $max_date, 'pickup', $sql);
		$booking_results = $this->booking_report_of_quarter($vendor_id, $min_date, $max_date);
		$local = [];
		$delivery = [];
		$pickup = [];
		$booking = [];
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
		foreach($booking_results as $booking_result){
			$quarters[] = $booking_result['quarter'].'-'.$booking_result['year'];
			$quarter = $booking_result['quarter'].'-'.$booking_result['year'];
			$booking[$quarter] = $booking_result['AMOUNT'];
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
				"local" => isset($local[$quarter]) ? floatval($local[$quarter]) : 0,
				"invoice" => 0,
				"booking" => isset($booking[$quarter]) ? floatval($booking[$quarter]) : 0
			];
		}
		return $newData;
	}

	function get_day_report($vendor_id,$min_date, $max_date, $sql=''){
		$local_results = $this->date_range_report_of_day($vendor_id, $min_date, $max_date, 'local', $sql);
		$delivery_results = $this->date_range_report_of_day($vendor_id, $min_date, $max_date, 'delivery', $sql);
		$pickup_results = $this->date_range_report_of_day($vendor_id, $min_date, $max_date, 'pickup', $sql);
		$booking_results = $this->booking_report_of_day($vendor_id, $min_date, $max_date);
		$local = [];
		$delivery = [];
		$pickup = [];
		$booking = [];
		$newData = [];
		$days = [];
		/*
		$context = stream_context_create([
            "http" => [
                "header" => "authtoken:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidGlxc3dlYiIsIm5hbWUiOiJ0aXFzd2ViIiwicGFzc3dvcmQiOm51bGwsIkFQSV9USU1FIjoxNTgyNTQ2NTc1fQ.q7ssJqcwsXhuNVDyspGYh_KV7_JsbwS8vq2TT9R-MGk"
                ]
        ]);
        $data = file_get_contents("http://tiqs.com/backoffice/admin/api/invoice/data/".$vendor_id, false, $context );
        $results = json_decode($data);
		$invoice = [];
		$min = explode(" ", $min_date)[0];
		$min = str_replace("'", "", $min);
		$max = explode(" ", $max_date)[0];
		$max = str_replace("'", "", $max);
        foreach($results as $result){

            if(strtotime(date($result->date)) >= strtotime(date($min)) && strtotime(date($result->date)) <= strtotime(date($max)) ){
				$days[] = $result->date;
				$day = $result->date;
                if(isset($invoice[$day])){
                    $invoice[$day] = $invoice[$day] + $result->total;
                } else {
                    $invoice[$day] = $result->total;
				}
				
                
            }

		}
		*/

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

		foreach($booking_results as $booking_result){
			$days[] = $booking_result['day_date'];
			$day = $booking_result['day_date'];
			$booking[$day] = $booking_result['AMOUNT'];
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
				"local" => isset($local[$day]) ? floatval($local[$day]) : 0,
				"invoice" => 0, //isset($invoice[$key]) ? floatval($invoice[$key]) : 0
				"booking" => isset($booking[$day]) ? floatval($booking[$day]) : 0

			];
		}
		return $newData;
	}

	public function get_report_of($vendor_id,$min_date, $max_date, $selected, $sql='',$specific = ''){
		$specific = lcfirst($specific);
		if($specific == 'booking') {
			$results = booking_report_of_day($vendor_id, $min_date, $max_date);
			$days = [];
			$newData = [];
			foreach($results as $key => $result){
				$day = $result['day_date'];
				$newData[$key] = [
					'date' => $day,
					'pickup' => 0,
					'delivery' => 0,
					'local' => 0,
					'invoice' => 0,
					'booking' => intval($result['AMOUNT'])
				];
			}
			return $newData;
	
		}
		else if($specific == 'pickup') {
			$results = $this->date_range_report_of_day($vendor_id, $min_date, $max_date, 'pickup', $sql);
			$days = [];
			$newData = [];
			foreach($results as $key => $result){
				$day = $result['day_date'];
				$newData[$key] = [
					'date' => $day,
					'pickup' => intval($result['pickupAMOUNT']),
					'delivery' => 0,
					'local' => 0,
					'invoice' => 0,
					'booking' => 0
				];
			}
			return $newData;
		}
		else if($specific == 'delivery') {
			$results = $this->date_range_report_of_day($vendor_id, $min_date, $max_date, 'delivery', $sql);
			$days = [];
			$newData = [];
			foreach($results as $key => $result){
				$day = $result['day_date'];
				$newData[$key] = [
					'date' => '',
					'pickup' => 0,
					'delivery' => intval($result['deliveryAMOUNT']),
					'local' => 0,
					'invoice' => 0,
					'booking' => 0
				];
			}
			
			return $newData;
		}
		else if($specific == 'local') {
			$results = $this->date_range_report_of_day($vendor_id, $min_date, $max_date, 'local', $sql);
			$days = [];
			$newData = [];
			foreach($results as $key => $result){
				$day = $result['day_date'];
				$newData[$key] = [
					'date' => $day,
					'pickup' => 0,
					'delivery' => 0,
					'local' => intval($result['AMOUNT']),
					'invoice' => 0,
					'booking' => 0
				];
			}
			return $newData;
		}


		if($selected == 'month') {return $this->get_month_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'day') {return $this->get_day_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'quarter') {return $this->get_quarter_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'hour') {return $this->get_hour_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'week') {return $this->get_week_report($vendor_id,$min_date, $max_date, $sql);}
		else {return $this->get_total_report($vendor_id,$min_date, $max_date, $sql);}
		
	}

	public function get_label_report_of($vendor_id,$min_date, $max_date, $selected, $sql='',$labels){
		$results = '';
		if($selected == 'month') { $results = $this->get_month_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'day') { $results = $this->get_day_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'quarter') { $results = $this->get_quarter_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'hour') { $results = $this->get_hour_report($vendor_id,$min_date, $max_date, $sql);}
		else if($selected == 'week') { $results =  $this->get_week_report($vendor_id,$min_date, $max_date, $sql);}
		else { $results = $this->get_total_report($vendor_id,$min_date, $max_date, $sql);}

		$newData = [];
		$labels = array_values($labels);
		foreach($results as $key => $result){
			$newData[$key] = [
				'date' => $result['date'],
				'pickup' => (in_array('pickup', $labels)) ? intval($result['pickup']) : 0,
				'delivery' => (in_array('delivery', $labels)) ? intval($result['delivery']) : 0,
				'local' => (in_array('local', $labels)) ? intval($result['local']) : 0,
				'invoice' => (in_array('invoice', $labels)) ? intval($result['invoice']) : 0,
				'booking' => (in_array('booking', $labels)) ? intval($result['booking']) : 0
			];
		}
		return $newData;
		
	}

}

