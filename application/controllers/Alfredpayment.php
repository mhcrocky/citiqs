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
        //		echo var_dump($paymentType);
        //		echo var_dump($paymentOptionSubId);
        //		die();

        $orderId = intval($orderId);
        $order = $this->shoporder_model->setObjectId($orderId)->fetchOne();
        $order = reset($order);
        $vendorId = intval($order['vendorId']);
        $serviceId = $this->shopvendor_model->setProperty('vendorId', $vendorId)->getProperty('payNlServiceId');

        $result = Pay_helper::payOrder($vendorId, $order, $serviceId, $paymentType, $paymentOptionSubId);

        if ($result && $result->request->result === '1') {
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
        $result = null;
        $this->failedRedirect($orderId, $result);
        return;
    }

    private function failedRedirect(int $orderId, ?object $result): void
    {
        $orderRandomKey = $this->shoporder_model->setObjectId($orderId)->getProperty('orderRandomKey');
        if ($orderRandomKey) {
            if ($result) {
                $message = $this->returnErrMessage($result->request->errorId);
                $this->session->set_flashdata('error', $message);
            }
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
            $message = 'Payment error!  Please try again '.$payNlErrorId;
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

            if ($this->shoporder_model->updatePaidStatus($this->shoporderpaynl_model, ['paid' => $this->config->item('orderPaid')])) {
                $this->shoporder_model->emailReceipt();
                $this->shoporder_model->sendNotifcation();
            }
            echo('TRUE| '. $transactionid.'-status-'.$action.'-date-'.date('Y-m-d H:i:s'));
        } else {
			echo('TRUE| NOT FIND '. $transactionid.'-status-'.$action.'-date-'.date('Y-m-d H:i:s'));
        }
    }

    public function successPayment(): void
    {
        $get = Utility_helper::sanitizeGet();
        $getUrlPart = '';

        $this->shoporderpaynl_model->setProperty('transactionId', $get['orderId'])->setAlfredOrderId();

        if ($this->shoporderpaynl_model->orderId) {
            $orderId = intval($this->shoporderpaynl_model->orderId);
            $order = $this->shoporder_model->setObjectId($orderId)->fetchOne();
            $order = reset($order);
            $getUrlPart =  '?' . $this->config->item('orderDataGetKey') . '=' . $order['orderRandomKey'] . '&orderid=' . $order['orderId'];
        }

        // $this->logPaynlGetResponse($get);

        if ($get['orderStatusId'] === $this->config->item('payNlSuccess')) {
            // need to do something with the facebook pixel.
            if (ENVIRONMENT === 'development' && $this->shoporderpaynl_model->orderId) {
                $this->shoporderpaynl_model->updatePayNl(['successPayment' => date('Y-m-d H:i:s')]);
                $this->shoporder_model->updatePaidStatus($this->shoporderpaynl_model, ['paid' => $this->config->item('orderPaid')]);
                $this->shoporder_model->emailReceipt();
            }
            $redirect = base_url() . 'success' . $getUrlPart;
        } elseif (in_array($get['orderStatusId'], $this->config->item('payNlPending'))) {
            $redirect = base_url() . 'pending' . $getUrlPart;
        } elseif ($get['orderStatusId'] === $this->config->item('payNlAuthorised')) {
            $redirect = base_url() . 'authorised' . $getUrlPart;
        } elseif ($get['orderStatusId'] === $this->config->item('payNlVerify')) {
            $redirect = base_url() . 'verify' . $getUrlPart;
        } elseif ($get['orderStatusId'] === $this->config->item('payNlCancel')) {
            $redirect = base_url() . 'cancel' . $getUrlPart;
        } elseif ($get['orderStatusId'] === $this->config->item('payNlDenied')) {
            $redirect = base_url() . 'denied' . $getUrlPart;
        } else {
            $redirect = base_url() . 'cancel' . $getUrlPart;
        }

        redirect($redirect);
        exit();
    }

    // private function logPaynlGetResponse(array $get):void
    // {
    //     $file = FCPATH . 'application/tiqs_logs/payment_logs_shop.txt';
    //     $message = http_build_query($get);
    //     Utility_helper::logMessage($file, $message);
    //     return;
    // }
}
