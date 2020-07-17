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
            // update order transactionId
            $this
                ->shoporder_model
                    ->setObjectFromArray(['transactionId'=> $result->transaction->transactionId])
                    ->update();
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
        $statuscode = intval($this->input->get('orderStatusId'));

        if ($statuscode === 100) {
            $update = $this
                        ->shoporder_model
                            ->setProperty('transactionId', $transactionid)
                            ->updatePaidStatus(['paid' => '1']);
            echo('TRUE| '. $transactionid);
        } else {
            echo('TRUE| NO INFO ');
        }
    }

    public function successPayment(): void
    {
        $get = $this->input->get(null, true);
        $statuscode = intval($get['orderStatusId']);
        $order = $this
                    ->shoporder_model
                        ->setProperty('transactionId', $get['orderId'])
                        ->setOrderIdFromTransactionId()
                        ->fetchOne();
        $order = reset($order);
        $redirect = 'make_order?vendorid=' . $order['vendorId'] . '&spotid=' . $order['spotId'];

        if ($statuscode == 100) {
            $this->shoporder_model->updatePaidStatus(['paid' => '1']);
            $this->session->set_flashdata('success', 'Your order is paid');
        } elseif ($statuscode < 0 ) {
            $this->session->set_flashdata('error', 'Order not paid');
        } elseif ($statuscode >= 0) {
            $this->session->set_flashdata('warning', 'Order not paid');
        } else {
            $this->session->set_flashdata('error', 'Payment error. Please, contact staff');
        }

        redirect($redirect);
        exit();
    }
}
