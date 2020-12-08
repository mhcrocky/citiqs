<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Orderscopy extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('shopprinters_model');
		$this->load->model('shoporder_model');
		$this->load->model('shoporderex_model');
		$this->load->model('shopvendor_model');
		$this->load->model('shopvendorfod_model');

		$this->load->helper('utility_helper');
		$this->load->helper('validate_data_helper');
		$this->load->helper('sanitize_helper');
		$this->load->helper('email_helper');
		$this->load->helper('curl_helper');
		$this->load->helper('orderprint_helper');

		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
	}

	public function data_get($orderId)
	{
		$paidConditions = 'AND  tbl_shop_orders.paid = "1"';
		$order = $this->shoporder_model->setObjectId(intval($orderId))->fetchOrdersForPrintcopy($paidConditions);

		if (!$order) return;

		$order = reset($order);
		$orderImageRelativePath = 'receipts' . DIRECTORY_SEPARATOR . $order['orderId'].'-email' . '.png';
		$orderImageFullPath = FCPATH . $orderImageRelativePath;	
		$orderImageUrl = base_url() . $orderImageRelativePath;

		if (!file_exists($orderImageFullPath)) {
			Orderprint_helper::saveOrderImage($order);
		}

		$this->orderCopyAtcions($order, $orderImageFullPath, $orderImageUrl);
	}

	private function orderCopyAtcions(array $order, string $orderImageFullPath, string $orderImageUrl): void
	{
		if ($order['paymentType'] === $this->config->item('prePaid') || $order['paymentType'] === $this->config->item('postPaid')) {
			if ($order['waiterReceipt'] === '0') {
				$email = $order['receiptEmail'];
				header('Content-type: image/png');
				echo file_get_contents($orderImageUrl);
			} else {
				if ($order['customerReceipt'] === '0') {
					if (strpos($order['buyerEmail'], 'anonymus_') !== false && strpos($order['buyerEmail'], '@tiqs.com') !== false) {
						$email = $order['receiptEmail'];
					} else {
						$email = $order['buyerEmail'];
					}
					if ($order['receiptOnlyToWaiter'] !== '1') {
						header('Content-type: image/png');
						echo file_get_contents($orderImageUrl);
					}
				}
			}
		} else {
			if (strpos($order['buyerEmail'], 'anonymus_') !== false && strpos($order['buyerEmail'], '@tiqs.com') !== false) {
				$email = $order['receiptEmail'];
			} else {
				$email = $order['buyerEmail'];
			}
		}

		// SEND EMAIL
		$sendEmail = $this->shopvendor_model->setProperty('vendorId', $order['vendorId'])->sendEmailWithReceipt();
		if (!empty($email) && $sendEmail) {
			$subject= "tiqs-Order : ". $order['orderId'];
			Email_helper::sendOrderEmail($email, $subject, '', $orderImageFullPath);
		}
	}
}
