<?php
declare(strict_types=1);

if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Paylinkreservations extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('bookandpay_model');
        $this->load->model('shopvendor_model');
        $this->load->model('shoplandingpages_model');
        $this->load->model('user_model');

        $this->load->helper('url');
        $this->load->helper('utility_helper');
        $this->load->helper('landingpage_helper');

        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    private function getLandingPage(array &$data, string $landingPage): void
    {
        if (empty($data)) return;

        $vendorId = intval($data['reservations'][0]->customer);
        $landingPage = $this
                    ->shoplandingpages_model
                    ->setProperty('vendorId', $vendorId)
                    ->setProperty('landingPage', $landingPage)
                    ->setProperty('productGroup', $this->config->item('reservations'))
                    ->getLandingPage();

        if (is_null($landingPage)) return;

        if ($landingPage['landingType'] === $this->config->item('urlLanding')) {
            redirect($landingPage['value']);
        }

        $data['landingPage'] = Landingpage_helper::getTicketingTemplateString($data['reservations'], $landingPage['value']); // change tempaltin
        return;
    }

    public function loadViewOrTemplate(array $data, string $defaultTemplate): void
    {
        $view = empty($data['landingPage']) ?  $defaultTemplate : $this->config->item('landingPageView');

        $this->loadViews($view, $this->global, $data, 'nofooter', 'noheader');
    }

    public function index()
    {
        $data = [];

        $this->global['pageTitle'] = 'TIQS : SUCCESS';

        $this->getReservationsData($data);
        $this->getLandingPage($data, $this->config->item('successLandingPage'));
        $this->loadViewOrTemplate($data, 'paylinkticketing/success');
    }

    public function pending()
    {
        $data = [
            'paynlInfo' => 'Payment has not been finalized and could still be processed'
        ];

        $this->global['pageTitle'] = 'TIQS : PENDING';

        $this->getReservationsData($data);
        $this->getLandingPage($data, $this->config->item('pendingLandingPage'));
        $this->loadViewOrTemplate($data, 'paylinkticketing/pending');


    }

    public function authorised()
    {
        $data = [
            'paynlInfo' => 'Put the payment in the "reservation" status.'
        ];

        $this->global['pageTitle'] = 'TIQS : AUTHORISED';

        $this->getReservationsData($data);
        $this->getLandingPage($data, $this->config->item('authorisedLandingPage'));
        $this->loadViewOrTemplate($data, 'paylinkticketing/notPaid');
    }

    public function verify()
    {
        $data = [
            'paynlInfo' => 'Payment can be completed after manual confirmation from admin'
        ];

        $this->global['pageTitle'] = 'TIQS : VERIFY';

        $this->getReservationsData($data);
        $this->getLandingPage($data, $this->config->item('verifyLandingPage'));
        $this->loadViewOrTemplate($data, 'paylinkticketing/notPaid');
    }

    public function cancel()
    {
        $data = [
            'paynlInfo' => 'Payment was canceled by the user'
        ];

        $this->global['pageTitle'] = 'TIQS : CANCEL';

        $this->getReservationsData($data);
        $this->getLandingPage($data, $this->config->item('cancelLandingPage'));
        $this->loadViewOrTemplate($data, 'paylinkticketing/notPaid');
    }

    public function denied()
    {
        $data = [
            'paynlInfo' => 'Payment is denied'
        ];

        $this->global['pageTitle'] = 'TIQS : DENIED';

        $this->getReservationsData($data);
        $this->getLandingPage($data, $this->config->item('deniedLandingPage'));
        $this->loadViewOrTemplate($data, 'paylinkticketing/notPaid');
    }

    public function pinCanceled()
    {
        $data = [
            'paynlInfo' => 'Pin payment canceled'
        ];

        $this->global['pageTitle'] = 'TIQS :  PIN CANCELED';

        $this->getReservationsData($data);
        $this->getLandingPage($data, $this->config->item('pinCanceledLandingPage'));
        $this->loadViewOrTemplate($data, 'paylinkticketing/notPaid');
    }

    private function getReservationsData(array &$data): void
    {
        $get = Utility_helper::sanitizeGet();
        $transactionId = ( isset($get['orderid']) ) ? intval($get['orderid']) : null;
        
        
        $data['backSuccess'] = 'places';
        $data['backFailed'] = 'places';

        if ($transactionId) {
            $reservations = $this->bookandpay_model->getReservationsByTransactionId($transactionId);
            $vendorId = intval($reservations[0]->customer);
            $data['usershorturl'] = $this->user_model->getUserShortUrlById($vendorId);
            $data['reservations'] = $reservations;

            $this->setGlobalVendor(intval($data['reservations'][0]->customer));
            //$this->setBackAndFailedUrl($data);
        }
        
        // if ($orderRandomKey && isset($order) && $order['orderRandomKey'] !== $get[$this->config->item('orderDataGetKey')]) {
        //     redirect('places');
        // }

        // var_dump($data);
        // die();
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

    /*
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
    */
}
