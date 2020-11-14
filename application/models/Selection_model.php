<?php
class Selection_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_buyers($vendorId)
	{
		
		$query = $this->db->query("SELECT buyer.id AS buyerId,buyer.email AS buyerEmail,buyer.username AS buyerUserName,buyer.mobile AS buyerMobile,buyer.oneSignalId AS buyerOneSignalId FROM tbl_shop_orders INNER JOIN tbl_shop_order_extended
ON tbl_shop_orders.id = tbl_shop_order_extended.orderId INNER JOIN tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
INNER JOIN tbl_shop_products ON tbl_shop_products_extended.productId = tbl_shop_products.id INNER JOIN tbl_shop_categories
ON tbl_shop_products.categoryId = tbl_shop_categories.id INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 2) AS vendor ON vendor.id = tbl_shop_categories.userId
INNER JOIN (SELECT * FROM tbl_user WHERE roleid = 6 OR roleid = 2) AS buyer ON buyer.id = tbl_shop_orders.buyerId INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id WHERE vendor.id = $vendorId AND tbl_shop_orders.paid = '1' 
GROUP BY buyer.id");
		
		
		return $query->result_array();
	}
}
