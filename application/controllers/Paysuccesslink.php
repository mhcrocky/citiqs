<?php
declare(strict_types=1);

if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';



class  Paysuccesslink extends BaseControllerWeb
{
    private $vendorLanguage = '';
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
        $this->load->model('shoplandingpages_model');

        $this->load->helper('url');
        $this->load->helper('utility_helper');
        $this->load->helper('landingpage_helper');
        $this->load->helper('language_helper');

        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    private function getLandingPage(array &$data, string $landingPage): void
    {
        if (empty($data['order'])) return;

        $vendorId = intval($data['order']['vendorId']);
        $landingPage = $this
                    ->shoplandingpages_model
                    ->setProperty('vendorId', $vendorId)
                    ->setProperty('landingPage', $landingPage)
                    ->setProperty('productGroup', $this->config->item('storeAndPos'))
                    ->getLandingPage();

        if (is_null($landingPage)) return;

        if ($landingPage['landingType'] === $this->config->item('urlLanding')) {
            redirect($landingPage['value']);
        }

        $data['landingPage'] = Landingpage_helper::getTemplateString($data['order'], $landingPage['value']);
        
        return;
    }

    private function setVendorLanguage(int $vendorId): void
    {
        $this->vendorLanguage = Language_helper::getLanguage($vendorId);
    }

    public function loadViewOrTemplate(array $data, string $defaultTemplate): void
    {
        $view = empty($data['landingPage']) ?  $defaultTemplate : $this->config->item('landingPageView');

        $this->loadViews($view, $this->global, $data, 'nofooter', 'noheader', $this->vendorLanguage);
    }

    public function index()
    {
        $data = [];

        $this->global['pageTitle'] = 'TIQS : SUCCESS';

        $this->getOrderData($data);
        $this->getLandingPage($data, $this->config->item('successLandingPage'));
        $this->loadViewOrTemplate($data, 'paysuccesslink/success');
    }

    public function pending()
    {
        $data = [
            'paynlInfo' => 'Payment has not been finalized and could still be paid'
        ];

        $this->global['pageTitle'] = 'TIQS : PENDING';

        $this->getOrderData($data);
        $this->getLandingPage($data, $this->config->item('pendingLandingPage'));
        $this->loadViewOrTemplate($data, 'paysuccesslink/pending');


    }

    public function authorised()
    {
        $data = [
            'paynlInfo' => 'Put the payment in the "reservation" status.'
        ];

        $this->global['pageTitle'] = 'TIQS : AUTHORISED';

        $this->getOrderData($data);
        $this->getLandingPage($data, $this->config->item('authorisedLandingPage'));
        $this->loadViewOrTemplate($data, 'paysuccesslink/notPaid');
    }

    public function verify()
    {
        $data = [
            'paynlInfo' => 'Payment can be completed after manual confirmation from admin'
        ];

        $this->global['pageTitle'] = 'TIQS : VERIFY';

        $this->getOrderData($data);
        $this->getLandingPage($data, $this->config->item('verifyLandingPage'));
        $this->loadViewOrTemplate($data, 'paysuccesslink/notPaid');
    }

    public function cancel()
    {
        $data = [
            'paynlInfo' => 'Payment was canceled by the user'
        ];

        $this->global['pageTitle'] = 'TIQS : CANCEL';

        $this->getOrderData($data);
        $this->getLandingPage($data, $this->config->item('cancelLandingPage'));
        $this->loadViewOrTemplate($data, 'paysuccesslink/notPaid');
    }

    public function denied()
    {
        $data = [
            'paynlInfo' => 'Payment is denied'
        ];

        $this->global['pageTitle'] = 'TIQS : DENIED';

        $this->getOrderData($data);
        $this->getLandingPage($data, $this->config->item('deniedLandingPage'));
        $this->loadViewOrTemplate($data, 'paysuccesslink/notPaid');
    }

    public function pinCanceled()
    {
        $data = [
            'paynlInfo' => 'Pin payment canceled'
        ];

        $this->global['pageTitle'] = 'TIQS :  PIN CANCELED';

        $this->getOrderData($data);
        $this->getLandingPage($data, $this->config->item('pinCanceledLandingPage'));
        $this->loadViewOrTemplate($data, 'paysuccesslink/notPaid');
    }

    private function getOrderData(array &$data): void
    {
        $get = Utility_helper::sanitizeGet();
        $orderId = ( isset($get['orderid']) && is_numeric($get['orderid']) ) ? intval($get['orderid']) : null;
        // $orderRandomKey = !empty($get[$this->config->item('orderDataGetKey')]) ? $get[$this->config->item('orderDataGetKey')] : null;
        
        $data['backSuccess'] = 'places';
        $data['backFailed'] = 'places';;

        if ($orderId) {
            $order = $this->shoporder_model->setObjectId($orderId)->fetchOne();
            $data['order'] = reset($order);

            $this->setGlobalVendor(intval($data['order']['vendorId']), $data);
            $this->setBackAndFailedUrl($data);
        }
        
        // if ($orderRandomKey && isset($order) && $order['orderRandomKey'] !== $get[$this->config->item('orderDataGetKey')]) {
        //     redirect('places');
        // }

        // var_dump($data);
        // die();
        return;
    }

    private function setGlobalVendor(int $vendorId, array &$data): void
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
        $data['analytics'] = $this->global['vendor'];

        $this->setVendorLanguage($vendorId);
    }

    private function setBackAndFailedUrl(array &$data): void
    {
        $baseUrl = base_url();
        if ($data['order']['isPos'] === '1') {
            $data['backSuccess'] = $baseUrl . 'pos?spotid=' . $data['order']['spotId'];
            $data['backFailed'] = $baseUrl . 'pos?spotid=' . $data['order']['spotId'];
        } else {
            $data['backSuccess'] = $baseUrl . 'make_order?vendorid=' . $data['order']['vendorId'] . '&spotid=' . $data['order']['spotId'];
            $data['backFailed']  = $baseUrl . 'make_order';
            $data['backFailed'] .= '?vendorid=' . $data['order']['vendorId'];
            $data['backFailed'] .= '&spotid=' . $data['order']['spotId'];
            $data['backFailed'] .= '&' . $this->config->item('orderDataGetKey') . '=' . $data['order']['orderRandomKey'];
            $data['changePamyentMethod'] = $baseUrl . 'pay_order?' . $this->config->item('orderDataGetKey') . '=' . $data['order']['orderRandomKey'];
        }
    }
}
