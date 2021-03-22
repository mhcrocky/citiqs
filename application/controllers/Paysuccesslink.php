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
        $this->load->model('shopvendorfod_model');
        $this->load->model('shopvendor_model');

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

    public function pinCanceled()
    {
        $data = [
            'paynlInfo' => 'Pin payment canceled'
        ];

        $this->getOrderData($data);
        $this->global['pageTitle'] = 'TIQS : PIN CANCELED';
        $this->loadViews("paysuccesslink/notPaid", $this->global, $data, 'nofooter', 'noheader');
    }

    private function getOrderData(array &$data): void
    {
        $get = Utility_helper::sanitizeGet();
        $orderId = ( isset($get['orderid']) && is_numeric($get['orderid']) ) ? intval($get['orderid']) : null;
        $orderRandomKey = !empty($get[$this->config->item('orderDataGetKey')]) ? $get[$this->config->item('orderDataGetKey')] : null;
        
        $data['backSuccess'] = 'places';
        $data['backFailed'] = 'places';;

        if ($orderId) {
            $order = $this->shoporder_model->setObjectId($orderId)->fetchOne();
            $data['order'] = reset($order);

            $this->setGlobalVendor(intval($data['order']['vendorId']));
            $this->setBackAndFailedUrl($data);
        }
        
        if ($orderRandomKey && isset($order) && $order['orderRandomKey'] !== $get[$this->config->item('orderDataGetKey')]) {
            redirect('places');
        }

        return;
    }

    private function setGlobalVendor(int $vendorId): void
    {
        $this->global['vendor'] = $this->shopvendor_model
                                    ->setProperty('vendorId', $vendorId)
                                    ->getProperties([
                                        'googleAnalyticsCode',
                                        'googleAdwordsConversionId',
                                        'googleAdwordsConversionLabel',
                                        'googleTagManagerCode',
                                        'facebookPixelId'
                                    ]);
    }

    private function setBackAndFailedUrl(array &$data): void
    {
        if ($data['order']['isPos'] === '1') {
            $data['backSuccess'] = base_url() . 'pos?spotid=' . $data['order']['spotId'];
            $data['backFailed'] = base_url() . 'pos?spotid=' . $data['order']['spotId'];
        } else {
            $data['backSuccess'] = base_url() . 'make_order?vendorid=' . $data['order']['vendorId'] . '&spotid=' . $data['order']['spotId']; 
            $data['backFailed']  = base_url() . 'make_order';
            $data['backFailed'] .= '?vendorid=' . $data['order']['vendorId'];
            $data['backFailed'] .= '&spotid=' . $data['order']['spotId'];
            $data['backFailed'] .= '&' . $this->config->item('orderDataGetKey') . '=' . $data['order']['orderRandomKey'];
        }
    }
}
