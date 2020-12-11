<?php
class Comparison_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function getOrderId($vendorId)
	{

		$this->db->select('tbl_shop_orders.id');
        $this->db->from('tbl_shop_orders');
        $this->db->join('tbl_shop_order_extended', 'tbl_shop_order_extended.orderId = tbl_shop_orders.id', 'left');
		$this->db->join('tbl_shop_products_extended', 'tbl_shop_products_extended.id = tbl_shop_order_extended.productsExtendedId', 'left');
		$this->db->join('tbl_shop_products', 'tbl_shop_products.id = tbl_shop_products_extended.productId', 'left');
        $this->db->join('tbl_shop_categories', 'tbl_shop_categories.id = tbl_shop_products.categoryId', 'left');
        $this->db->where('tbl_shop_categories.userId', $vendorId);

		$query = $this->db->get();
        if ($query) {
			$results = $query->result_array();
			$orderIds = [];
			foreach($results as $result){
				$orderIds[] = $result['id'];
			}
			return $orderIds;
        }

		return false;
	}
}
