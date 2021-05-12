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

		#Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/track_printer.txt', ' WE ARE IN ORDER COPY');
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

		$this->orderCopyAtcions($order, $orderImageUrl);
	}

	private function orderCopyAtcions(array $order, string $orderImageUrl): void
	{
		#Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/track_printer.txt', ' WE ARE CALLING ORDER COPY ACTION');
		if (
			$order['paymentType'] === $this->config->item('prePaid')
			|| $order['paymentType'] === $this->config->item('postPaid')
			|| $order['paymentType'] === $this->config->item('voucherPayment')
		) {
			#Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/track_printer.txt', 'ORDER COPY ACTION CONDITIONS ARE TRUE');
			if ($order['waiterReceipt'] === '0') {
				#Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/track_printer.txt', 'PRINTING WAITER RECEIPT');
				$content = file_get_contents($orderImageUrl);
				if ($content) {
					#Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/track_printer.txt', 'WE HAVE SOMETHING TO ECHO ');
					header('Content-type: image/png');
					echo $content;
				} else {
					#Utility_helper::logMessage(FCPATH . 'application/tiqs_logs/track_printer.txt', 'NOTHING TO ECHO ');
				}
				
			} else {
				if ($order['customerReceipt'] === '0') {
					if ($order['receiptOnlyToWaiter'] !== '1') {
						header('Content-type: image/png');
						echo file_get_contents($orderImageUrl);
					}
				}
			}
		}
	}

	public function receipt_get($orderId): void
	{
		$orderImageRelativePath = 'receipts' . DIRECTORY_SEPARATOR . $orderId . '-email' . '.png';
		$orderImageFullPath = FCPATH . $orderImageRelativePath;

		if (!file_exists($orderImageFullPath)) {
			$paidConditions = 'AND  tbl_shop_orders.paid = "1"';
			$order = $this->shoporder_model->setObjectId(intval($orderId))->fetchOrdersForPrintcopy($paidConditions);
			if (!$order) return;
			$order = reset($order);
			Orderprint_helper::saveOrderImage($order);
		}

		$orderImageUrl = base_url() . $orderImageRelativePath;
		header('Content-type: image/png');
		echo file_get_contents($orderImageUrl);
		return;
	}

}
