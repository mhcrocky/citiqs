<?php
class Comparison_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function getOrderId()
	{

		$this->db->select('tbl_shop_orders.old_order');
        $this->db->from('tbl_shop_orders');
        $this->db->join('tbl_shop_order_extended', 'tbl_shop_order_extended.orderId = tbl_shop_orders.id', 'left');
		$this->db->join('tbl_shop_products_extended', 'tbl_shop_products_extended.id = tbl_shop_order_extended.productsExtendedId', 'left');
		$this->db->join('tbl_shop_products', 'tbl_shop_products.id = tbl_shop_products_extended.productId', 'left');
        $this->db->join('tbl_shop_categories', 'tbl_shop_categories.id = tbl_shop_products.categoryId', 'left');
		$this->db->where('tbl_shop_categories.userId', '1162');
		$this->db->group_by('tbl_shop_orders.old_order');

		$query = $this->db->get();
        if ($query) {
			$results = $query->result_array();
			$orderIds = [];
			foreach($results as $result){
				$orderIds[] = $result['old_order'];
			}
			return $orderIds;
        }

		return false;
	}

	public function getPriceByOrderId()
	{

		$this->db->select('tbl_shop_orders.old_order, tbl_shop_orders.amount, tbl_shop_orders.serviceFee');
        $this->db->from('tbl_shop_orders');
        $this->db->join('tbl_shop_order_extended', 'tbl_shop_order_extended.orderId = tbl_shop_orders.id', 'left');
		$this->db->join('tbl_shop_products_extended', 'tbl_shop_products_extended.id = tbl_shop_order_extended.productsExtendedId', 'left');
		$this->db->join('tbl_shop_products', 'tbl_shop_products.id = tbl_shop_products_extended.productId', 'left');
        $this->db->join('tbl_shop_categories', 'tbl_shop_categories.id = tbl_shop_products.categoryId', 'left');
		$this->db->where('tbl_shop_categories.userId', '1162');
		$this->db->where('tbl_shop_orders.old_order is NOT NULL', NULL, FALSE);
		$this->db->group_by('tbl_shop_orders.old_order');
		$query = $this->db->get();
        if ($query) {
			$results = $query->result_array();
			$orders = [];
			foreach($results as $key => $result){
				$orders[$key]['order_id'] = $result['old_order'];
				$price = $result['amount'] + $result['serviceFee'];
				if(strpos($price, '.') !== false){
					$orders[$key]['price'] = floatval($price);
				} else {
					$orders[$key]['price'] = intval($price);
				}
			}
			return $orders;
        }

		return false;
	}
}
