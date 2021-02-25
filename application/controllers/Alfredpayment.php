<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';


class Alfredpayment extends BaseControllerWeb
{

    public function __construct() {
        parent::__construct();
        

        $this->load->model('shoporder_model');
        $this->load->model('shoporderpaynl_model');
        $this->load->model('shopvendor_model');

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
    

    public function paymentEngine($paymentType, $paymentOptionSubId, $orderId): void
    {

        $orderId = intval($orderId);
        $order = $this->shoporder_model->setObjectId($orderId)->fetchOne();
        $order = reset($order);
        $vendorId = intval($order['vendorId']);
        $serviceId = $this->shopvendor_model->setProperty('vendorId', $vendorId)->getProperty('payNlServiceId');
        $arguments = Pay_helper::getArgumentsArray($vendorId, $order, $serviceId, $paymentType, $paymentOptionSubId);
        $url = Pay_helper::getPayNlUrl($arguments, $this->config->item('orderPayNlNamespace'), $this->config->item('orderPayNlFunction'), $this->config->item('orderPayNlVersion'));
        $result = @file_get_contents($url);
        $result = json_decode($result);

        if ($result->request->result === '1') {
            $this
                ->shoporderpaynl_model
                    ->setObjectFromArray([
                        'orderId' => $orderId,
                        'transactionId' => $result->transaction->transactionId,
                        'requestSuccess' => date('Y-m-d H:i:s')
                    ])
                    ->create();
            redirect($result->transaction->paymentURL);
            exit();
        }
        $this->failedRedirect($orderId, $result);
        return;
    }

    private function failedRedirect(int $orderId, object $result): void
    {
        $orderRandomKey = $this->shoporder_model->setObjectId($orderId)->getProperty('orderRandomKey');
        if ($orderRandomKey) {
            $message = $this->returnErrMessage($result->request->errorId);
            $this->session->set_flashdata('error', $message);
            $redirect = base_url() . 'pay_order?' . $this->config->item('orderDataGetKey') . '=' . $orderRandomKey;
        } else {
            $redirect = base_url();
        }
        redirect($redirect);
        exit;
    }

    private function returnErrMessage(string $payNlErrorId): string
    {
        if ($payNlErrorId === $this->config->item('paymentTypeErr')) {
            $message = 'Payment error! Please choose another method';
        } else {
            $message = 'Payment error!  Please try again';
        }
        return $message;
    }

	public function ExchangePay():void
	{
        $get = $this->input->get(null, true);
        $transactionid = $this->input->get('order_id'); 
        $action = $this->input->get('action', true);

        if ($get['action'] === 'new_ppt') {

            $this
                ->shoporderpaynl_model
                    ->setProperty('transactionId', $get['order_id'])
                    ->updatePayNl([
                        'payNlResponse' => serialize($get),
                        'exchangePay' => date('Y-m-d H:i:s')
                    ]);

            $this->shoporder_model->updatePaidStatus($this->shoporderpaynl_model, ['paid' => $this->config->item('orderPaid')]);

            echo('TRUE| '. $transactionid.'-status-'.$action.'-date-'.date('Y-m-d H:i:s'));
        } else {
			echo('TRUE| NOT FIND '. $transactionid.'-status-'.$action.'-date-'.date('Y-m-d H:i:s'));
        }
    }

    public function successPayment(): void
    {
        $get = Utility_helper::sanitizeGet();

        $this->shoporderpaynl_model->setProperty('transactionId', $get['orderId'])->setAlfredOrderId();

        $orderId = intval($this->shoporderpaynl_model->orderId);
        $order = $this->shoporder_model->setObjectId($orderId)->fetchOne();
        $order = reset($order);
        $vendorId = intval($order['vendorId']);

        if ($get['orderStatusId'] === $this->config->item('payNlSuccess')) {
        	// need to do something with the facebook pixel.

            $this->shoporderpaynl_model->updatePayNl(['successPayment' => date('Y-m-d H:i:s')]);
            $this->shoporder_model->updatePaidStatus($this->shoporderpaynl_model, ['paid' => $this->config->item('orderPaid')]);
            if ($vendorId == 1162) {
                $redirect = 'successth';
            } else {
                $redirect = base_url() . 'success?' . $this->config->item('orderDataGetKey') . '=' . $order['orderRandomKey'] . '&orderid=' . $order['orderId'];
            }
        } elseif ($get['orderStatusId'] === $this->config->item('payNlPending')) {
            $redirect = base_url() . 'pending?' . $this->config->item('orderDataGetKey') . '=' . $order['orderRandomKey'] . '&orderid=' . $order['orderId'];
        } elseif ($get['orderStatusId'] === $this->config->item('payNlAuthorised')) {
            $redirect = base_url() . 'authorised?' . $this->config->item('orderDataGetKey') . '=' . $order['orderRandomKey'] . '&orderid=' . $order['orderId'];
        } elseif ($get['orderStatusId'] === $this->config->item('payNlVerify')) {
            $redirect = base_url() . 'verify?' . $this->config->item('orderDataGetKey') . '=' . $order['orderRandomKey'] . '&orderid=' . $order['orderId'];
        } elseif ($get['orderStatusId'] === $this->config->item('payNlCancel')) {
            $redirect = base_url() . 'cancel?' . $this->config->item('orderDataGetKey') . '=' . $order['orderRandomKey'] . '&orderid=' . $order['orderId'];
        } elseif ($get['orderStatusId'] === $this->config->item('payNlDenied')) {
            $redirect = base_url() . 'denied?' . $this->config->item('orderDataGetKey') . '=' . $order['orderRandomKey'] . '&orderid=' . $order['orderId'];
        }

        redirect($redirect);
        exit();
    }
}
