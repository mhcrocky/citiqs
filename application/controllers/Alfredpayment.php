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
    

    public function paymentEngine($paymentType, $paymentOptionSubId): void
    {
        if (empty($_SESSION['orderId']) || empty($_SESSION['vendor'])) {
            $redirect = empty($_SESSION['vendor']) ? base_url() : 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'];
            redirect($redirect);
            exit();
        }
        
        $vendor = $_SESSION['vendor'];
        $serviceId = $vendor['payNlServiceId'];
        $orderId = Utility_helper::getSessionValue('orderId');
        $order = $this->shoporder_model->setObjectId($orderId)->fetchOne();
        $order = reset($order);
        $arguments = Pay_helper::getArgumentsArray($vendor['vendorId'], $order, $serviceId, $paymentType, $paymentOptionSubId);

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

        $this->session->set_flashdata('error', 'Payment engine error. Please, contact staff');
        $redirect = 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $order['spotId'];
        redirect($redirect);
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
                        'exchangePay' => date('Y-m-d')
                    ]);

            $this->shoporder_model->updatePaidStatus($this->shoporderpaynl_model, ['paid' => '1']);

            echo('TRUE| '. $transactionid.'-status-'.$action.'-date-'.date('Y-m-d H:i:s'));
        } else {
			echo('TRUE| NOT FIND '. $transactionid.'-status-'.$action.'-date-'.date('Y-m-d H:i:s'));
        }
    }

    public function successPayment(): void
    {
        $redirect = 'make_order?vendorid=' . $_SESSION['vendor']['vendorId'] . '&spotid=' . $_SESSION['spotId'];

        $lastpageforvendorId = $_SESSION['vendor']['vendorId'];

		unset($_SESSION['order']);
		unset($_SESSION['postOrder']);
		unset($_SESSION['spotId']);
		unset($_SESSION['vendor']);

        $get = $this->input->get(null, true);
        $statuscode = intval($get['orderStatusId']);

        if ($statuscode === 100) {
            $this->shoporderpaynl_model->setProperty('transactionId', $get['orderId'])->updatePayNl(['successPayment' => date('Y-m-d H:i:s')]);
            $this->shoporder_model->updatePaidStatus($this->shoporderpaynl_model, ['paid' => '1']);

            $this->session->set_flashdata('success', 'Your order is paid');

            if ($lastpageforvendorId == 1162) {
				$redirect = 'successth';
			} else {
                // var_dump($lastpageforvendorId);
                // die();
				$redirect = 'success';
			}
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
