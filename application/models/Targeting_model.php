<?php
class Targeting_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
	}

	public function get_local_report($vendor_id, $sql='')
	{
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id, tbl_shop_orders.created AS order_date, tbl_shop_products_extended.vatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.price,
tbl_shop_order_extended.quantity,tbl_shop_orders.waiterTip,tbl_user.username, tbl_user.email, tbl_shop_orders.buyerId,tbl_shop_categories.userId,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee - (tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
(tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100) AS EXVATSERVICE,tbl_shop_orders.serviceFee,
tbl_shop_products_extended.price * tbl_shop_order_extended.quantity-tbl_shop_products_extended.price * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.vatpercentage+100) AS VAT
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
WHERE vendor.id = '$vendor_id' AND tbl_shop_orders.paid = '1' AND serviceTypeId = '1' $sql");
		return $query->result_array();
	}


	public function get_delivery_report($vendor_id, $sql=''){
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id, tbl_shop_orders.created AS order_date,tbl_shop_products_extended.deliveryVatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.deliveryPrice AS price,
tbl_shop_order_extended.quantity,tbl_shop_orders.waiterTip,tbl_user.username, tbl_user.email, tbl_shop_orders.buyerId,tbl_shop_categories.userId,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)  AS EXVATSERVICE,tbl_shop_orders.serviceFee,
(tbl_shop_orders.serviceFee - (tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
((tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.deliveryVatpercentage+100)
AS EXVAT,tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity-tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.deliveryVatpercentage+100) AS VAT
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
WHERE vendor.id = '$vendor_id' AND tbl_shop_orders.paid = '1' AND serviceTypeId = '2' $sql");
      return $query->result_array();
	}


	public function get_pickup_report($vendor_id, $sql=''){
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id, tbl_shop_orders.created AS order_date,tbl_shop_products_extended.pickupVatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.pickupPrice AS price,
tbl_shop_order_extended.quantity, tbl_shop_orders.waiterTip, tbl_user.username, tbl_user.email, tbl_shop_orders.buyerId,tbl_shop_categories.userId,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS AMOUNT,
(tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100) AS EXVATSERVICE,tbl_shop_orders.serviceFee,
(tbl_shop_orders.serviceFee - (tbl_shop_orders.serviceFee*100)/(tbl_shop_vendors.serviceFeeTax+100)) AS VATSERVICE,tbl_shop_vendors.serviceFeeTax,
((tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.pickupVatpercentage+100) AS EXVAT,
tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity-tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.pickupVatpercentage+100) AS VAT
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
WHERE vendor.id = '$vendor_id' AND tbl_shop_orders.paid = '1' AND serviceTypeId = '3' $sql");
      return $query->result_array();
	}

	public function save_results($data){
		return $this->db->insert('tbl_target_result', $data); 
	}


}