<?php
declare(strict_types=1);

if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';



class  Paysuccesslink extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('shoporder_model');
        $this->load->model('shopposorder_model');
        $this->load->model('shopsession_model');

        $this->load->helper('url');
        $this->load->helper('utility_helper');

        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index()
    {
        $data = [];

        $this->getOrderData($data);
        $this->global['pageTitle'] = 'TIQS : SUCCESS';
        $this->loadViews("paysuccesslink/success", $this->global, $data, 'nofooter', 'noheader');
    }

    public function pending()
    {
        $data = [
            'paynlInfo' => 'Payment has not been finalized and could still be paid'
        ];

        $this->getOrderData($data);
        $this->global['pageTitle'] = 'TIQS : PENDING';
        $this->loadViews("paysuccesslink/notPaid", $this->global, $data, 'nofooter', 'noheader');
    }

    public function authorised()
    {
        $data = [
            'paynlInfo' => 'Put the payment in the "reservation" status.'
        ];

        $this->getOrderData($data);
        $this->global['pageTitle'] = 'TIQS : AUTHORISED';
        $this->loadViews("paysuccesslink/notPaid", $this->global, $data, 'nofooter', 'noheader');
    }

    public function verify()
    {
        $data = [
            'paynlInfo' => 'Payment can be completed after manual confirmation from admin'
        ];

        $this->getOrderData($data);
        $this->global['pageTitle'] = 'TIQS : VERIFY';
        $this->loadViews("paysuccesslink/notPaid", $this->global, $data, 'nofooter', 'noheader');
    }

    public function cancel()
    {
        $data = [
            'paynlInfo' => 'Payment was canceled by the user'
        ];

        $this->getOrderData($data);
        $this->global['pageTitle'] = 'TIQS : CANCEL';
        $this->loadViews("paysuccesslink/notPaid", $this->global, $data, 'nofooter', 'noheader');
    }

    public function denied()
    {
        $data = [
            'paynlInfo' => 'Payment is denied'
        ];

        $this->getOrderData($data);
        $this->global['pageTitle'] = 'TIQS : DENIED';
        $this->loadViews("paysuccesslink/notPaid", $this->global, $data, 'nofooter', 'noheader');
    }

    private function getOrderData(array &$data): void
    {
        $get = Utility_helper::sanitizeGet();
        $orderId = ( isset($get['orderid']) && is_numeric($get['orderid']) ) ? intval($get['orderid']) : null;
        $orderRandomKey = !empty($get[$this->config->item('orderDataGetKey')]) ? $get[$this->config->item('orderDataGetKey')] : null;

        if ($orderId && $orderRandomKey) {
            $order = $this->shoporder_model->setObjectId($orderId)->fetchOne();
            if (is_null($order) || $order[0]['orderRandomKey'] !== $get[$this->config->item('orderDataGetKey')]) {
                redirect('places');
            }
            $order = reset($order);
            $data['order'] = $order;
            $data['orderDataGetKey'] = $this->config->item('orderDataGetKey');
            $this->chekckIsPosOrder($data, $order['orderRandomKey']);
        }
        return;
    }

    private function chekckIsPosOrder(array &$data, string $ranodmKey): void
    {
        $orderData = $this->shopsession_model->setProperty('randomKey', $ranodmKey)->getArrayOrderDetails();
        $data['pos'] = intval($orderData['pos']);
        if ($data['pos']) {            
            $data['spotId'] = $orderData['spotId'];
            $data['orderRandomKey'] = $ranodmKey;
            if ($data['order']['orderPaidStatus'] === '1') {
                Utility_helper::redirectToPos($data, $this->config->item('posSuccessLink'));
            } else {
                Utility_helper::redirectToPos($data, $this->config->item('posPaymentFailedLink'));
            }
            
        }
    }
}
