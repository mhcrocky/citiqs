<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shoporder_model_finanza extends CI_Model {

	public function returnOrders($userId) {

		$sql=	"SELECT
					tbl_shop_orders.id AS orderId,
					vendor.id AS VendorId,
       				tbl_shop_orders.pStatus AS pStatus,
       				tbl_shop_orders.createdOrder AS orderCreated,
       				tbl_shop_orders.amount AS totalAmount
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

	public function returnInfoOrders($userId) {

		$sql=	"SELECT
							tbl_shop_orders.id AS orderId,
							tbl_shop_orders.amount AS orderAmount,
							tbl_shop_orders.paid AS orderPaidStatus,
							tbl_shop_orders.created AS createdAt,
							tbl_shop_categories.category AS category,
							tbl_shop_orders.serviceTypeId AS service,
							buyer.id AS buyerId,
							buyer.email AS buyerEmail,
							buyer.username AS buyerUserName,
							vendor.username AS vendorUserName,
							tbl_shop_order_extended.quantity AS productQuantity,
							tbl_shop_products_extended.`name` AS productName,
							tbl_shop_products_extended.price AS productPrice,
							tbl_shop_products_extended.vatpercentage AS productVat,
							tbl_shop_products_extended.deliveryPrice AS deliveryproductPrice,
							tbl_shop_products_extended.deliveryVatpercentage AS deliveryproductVat,
							tbl_shop_products_extended.pickupPrice AS pickupproductPrice,
							tbl_shop_products_extended.pickupVatpercentage AS pickupproductVat,
							
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
							((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
							
							tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS deliveryproductlinetotal,
							((tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.deliveryVatpercentage+100) AS deliveryEXVAT,
							
							tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS pickupproductlinetotal,
							((tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.pickupVatpercentage+100) AS pickupEXVAT,
							tbl_shop_orders.serviceFee AS servicefee
							FROM
							`tbl_shop_orders`
							INNER JOIN
							`tbl_shop_order_extended`
							ON `tbl_shop_orders`.`id` = `tbl_shop_order_extended`.`orderId`
							INNER JOIN
							`tbl_shop_products_extended`
							ON `tbl_shop_order_extended`.`productsExtendedId` = `tbl_shop_products_extended`.`id`
							INNER JOIN
							`tbl_shop_products`
							ON `tbl_shop_products_extended`.`productId` = `tbl_shop_products`.`id`
							INNER JOIN
							`tbl_shop_categories`
							ON `tbl_shop_products`.`categoryId` = `tbl_shop_categories`.`id`
							INNER JOIN
							(
							SELECT *
							FROM
							tbl_user
							WHERE
							roleid = 2
							)
							vendor
							ON `vendor`.`id` = `tbl_shop_categories`.`userId`
							INNER JOIN
							(
							SELECT *
							FROM
							tbl_user
							WHERE
							roleid = 6
							OR roleid = 2
							)
							buyer
							ON `buyer`.`id` = `tbl_shop_orders`.`buyerId`
							INNER JOIN
							`tbl_shop_spots`
							ON `tbl_shop_orders`.`spotId` = `tbl_shop_spots`.`id`
							WHERE
							vendor.id = 43533 AND
							tbl_shop_orders.paid = '1'  
							ORDER BY
							tbl_shop_categories.category ASC";
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
