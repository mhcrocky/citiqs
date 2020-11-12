<?php
class Businessreport_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
	}

	public function get_report($vendor_id)
	{
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id, date(tbl_shop_orders.updated) AS order_date, tbl_shop_products_extended.vatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.price,tbl_shop_order_extended.quantity,
tbl_shop_spot_types.type AS service_type,tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS AMOUNT,
((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
tbl_shop_products_extended.price * tbl_shop_order_extended.quantity-tbl_shop_products_extended.price * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.vatpercentage+100) AS VAT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId 
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' ");
		return $query->result_array();
	}


	public function get_current_year_amount($vendor_id)
	{
		$year = date("Y");
		$query = $this->db->query("SELECT tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS AMOUNT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId 
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND YEAR(tbl_shop_orders.updated) = '$year' ");
		$results = $query->result_array();
		$amount = 0;
		foreach($results as $result){
			$amount = $amount + floatval($result['AMOUNT']);
		}
		return number_format($amount, 2, '.', '');
	}

	public function get_types_total($vendor_id, $order_type)
	{
		$date = date('Y-m-d');
		$query = $this->db->query("SELECT tbl_shop_spot_types.type, tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS AMOUNT
FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId 
INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
INNER JOIN tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id 
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user  WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId
INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
INNER JOIN tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
WHERE vendor.id = ".$vendor_id." AND tbl_shop_orders.paid = '1' AND tbl_shop_spot_types.type = '$order_type' AND DATE(tbl_shop_orders.updated) = '$date' ");
		$amount = 0;
		$results = $query->result_array();
		foreach($results as $result){
			$amount = $amount + floatval($result['AMOUNT']);
		}
		return $amount;
	}

	public function get_local_total($vendor_id){
		return $this->get_types_total($vendor_id, 'local');
	}

	public function get_delivery_total($vendor_id){
		return $this->get_types_total($vendor_id, 'delivery');
	}

	public function get_pickup_total($vendor_id){
		return $this->get_types_total($vendor_id, 'pickup');
	}

	public function get_service_types(){
		$query = $this->db->get('tbl_shop_spot_types');
		return $query->result_array();
	}


}
