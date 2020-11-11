<?php
class Businessreport_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('utility_helper');
	}

	public function get_report($vendor_id)
	{
		$query = $this->db->query("SELECT tbl_shop_orders.id AS order_id, tbl_shop_products_extended.vatpercentage AS productVat,tbl_shop_products_extended.`name` AS productName,tbl_shop_products_extended.price,tbl_shop_order_extended.quantity,
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


	public function get_service_types(){
		$query = $this->db->get('tbl_shop_spot_types');
		return $query->result_array();
	}


}
