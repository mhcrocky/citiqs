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
        $url = Pay_helper::getPayUrl($arguments);
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
        redirect('success');        
        exit();
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

        if (intval($get['orderStatusId']) === $this->config->item('payNlSuccess')) {
            $this->shoporderpaynl_model->updatePayNl(['successPayment' => date('Y-m-d H:i:s')]);
            $this->shoporder_model->updatePaidStatus($this->shoporderpaynl_model, ['paid' => $this->config->item('orderPaid')]);
        }

        if ($vendorId == 1162) {
            $redirect = 'successth';
        } else {
            // $redirect = base_url() . 'success?' . $this->config->item('orderDataGetKey') . '=' . $order['orderRandomKey'] . '&orderid=' . $order['orderId'];
            $redirect = base_url() . 'success';
        }

        redirect($redirect);
        exit();
    }
}
