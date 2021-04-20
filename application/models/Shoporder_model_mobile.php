<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shoporder_model_mobile extends CI_Model {

	public function returnOrders($userId) {

		$sql=	"SELECT
					tbl_shop_orders.id AS orderId,
					vendor.id AS VendorId,
       				tbl_shop_orders.pStatus AS pStatus
				FROM
					`tbl_shop_orders` 
				INNER JOIN
					`tbl_shop_order_extended` ON `tbl_shop_orders`.`id` = `tbl_shop_order_extended`.`orderId` 
				INNER JOIN
					`tbl_shop_products_extended` ON `tbl_shop_order_extended`.`productsExtendedId` = `tbl_shop_products_extended`.`id` 
				INNER JOIN
					`tbl_shop_products` ON `tbl_shop_products_extended`.`productId` = `tbl_shop_products`.`id` 
				INNER JOIN
					`tbl_shop_categories` ON `tbl_shop_products`.`categoryId` = `tbl_shop_categories`.`id` 
				INNER JOIN
					( SELECT * FROM tbl_user  WHERE roleid = 2 ) vendor  ON `vendor`.`id` = `tbl_shop_categories`.`userId` 
				INNER JOIN
					( SELECT * FROM tbl_user WHERE roleid = 6 OR roleid = 2 ) buyer  ON `buyer`.`id` = `tbl_shop_orders`.`buyerId` 
				INNER JOIN
					`tbl_shop_spots`  ON `tbl_shop_orders`.`spotId` = `tbl_shop_spots`.`id` 
				WHERE
					vendor.id = " . $this->db->escape($userId) . "
					AND tbl_shop_orders.paid = '1'
					AND tbl_shop_orders.pStatus !=  '3' 
					AND date(tbl_shop_orders.created) >= date('2020/12/28')
				GROUP BY
					tbl_shop_orders.id";
		$query = $this->db->query($sql);
		$result= $query->num_rows();

		return $query->result();
	}

	public function getUserByIdAndApiKey($userId, $apiKey) {
		$this->db->select('userid, apikey, access');
		$this->db->from('tbl_APIkeys');
		$this->db->where('userid', $userId);
		$this->db->where('apikey', $apiKey);
		$query = $this->db->get();
		return $query->row();
	}

	public function getUserNameById($userId) {
		$this->db->select('username');
		$this->db->from('tbl_user');
		$this->db->where('id', $userId);
		$query = $this->db->get();
		return $query->row();
	}

	public function getItemByDescription($description, $userId) {
		$this->db->select('code, descript, categoryid, image');
		$this->db->from('tbl_label');
		$this->db->where('userid', $userId);
		$this->db->like('descript', $description);
		$query = $this->db->get();
		return $query->result();
	}

	public function userAuthentication(string $apiKey): bool
	{
		$this->db->select('id');
		$this->db->from('tbl_APIkeys');
		$this->db->where('apikey', $apiKey);
		$result = $this->db->get();
		return $result->result() ? true : false;
	}

	public function getDeliveryOrders($buyerId){
		$this->db->select('*')
			->from('tbl_shop_orders')
			->where(array('buyerId' => $buyerId,'serviceTypeId' => 2));
		$result = $this->db->get();
		return $result->result_array();
	}

	public function getOrder($orderId){
		$this->db->select('*')
			->from('tbl_shop_orders')
			->where(array('id' => $orderId));
		$result = $this->db->get();
		return $result->result_array();
	}

}
