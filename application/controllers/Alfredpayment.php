<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';


class Alfredpayment extends BaseControllerWeb
{

    public function __construct() {
        parent::__construct();
        
        $this->load->model('shoporder_model');

        $this->load->helper('pay_helper');
        $this->load->helper('utility_helper');
        $this->load->helper('validate_data_helper');

        $this->load->config('custom');

        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('session');
    }

    public function index()
	{
        die();
    }


    public function paymentEngine($paymentType): void
    {
        $vendor = Utility_helper::getSessionValue('vendor');
        $serviceId = $vendor['payNlServiceId'];
        $orderId = Utility_helper::getSessionValue('orderId');


        $order = $this->shoporder_model->setObjectId($orderId)->fetchOne();
        $order = reset($order);

        $arguments = Pay_helper::getArgumentsArray($order, $paymentType, $serviceId);
        $url = Pay_helper::getIdealUrl($arguments);

        $result = @file_get_contents($url);        
        $result = json_decode($result);

        if ($result->request->result == '1') {
            redirect($result->transaction->paymentURL);
            exit();
        }

        $this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
        $redirect = 'make_order?vendorid=' . $order['vendorId'] . '&spotid=' . $order['spotId'];
        redirect($redirect);
        exit();
    }

	public function ExchangePay(): void
	{
		$transactionid = $this->input->get('order_id');
    }

    public function successPayment($orderId): void
    {
        $orderId = intval($orderId);
        $order = $this->shoporder_model->setObjectId($orderId)->fetchOne();
        $order = reset($order);
        $get = $this->input->get(null, true);

        $statuscode = intval($get['orderStatusId']);
        $redirect = 'make_order?vendorid=' . $order['vendorId'] . '&spotid=' . $order['spotId'];
        $updateOrder = [
            'transactionId' => $get['orderId']
        ];

        if ($statuscode == 100) {
            $this->session->set_flashdata('success', 'Your order is paid');
            $updateOrder['paid'] = '1';
        } elseif ($statuscode < 0 ) {
            $this->session->set_flashdata('error', 'Order not paid');
        } elseif ($statuscode >= 0) {
            $this->session->set_flashdata('warning', 'Order not paid');
        } else {
            $this->session->set_flashdata('error', 'Payment error. Please, contact staff');
        }

        if (!$this->shoporder_model->setObjectFromArray($updateOrder)->update()) {
            $file = FCPATH . 'application/tiqs_logs/messages.txt';
            $message = 'Order with order id "' . $orderId . ' in tbl_shop_orders" and transaction_id ' . $get['orderId'] . 'not updated';
            Utility_helper::logMessage($file, $message);
        }

        redirect($redirect);
        exit();
    }
   
}
