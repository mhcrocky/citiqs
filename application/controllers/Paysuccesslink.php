<?php
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
        $this->load->helper('url');
        $this->load->helper('utility_helper');
        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index()
    {
        $this->global['pageTitle'] = 'TIQS : SUCCESS';
        $baseUrl = base_url();

        if (!isset($_SESSION['redirect'])) {
            $_SESSION['redirect'] = $baseUrl . 'make_order?vendorid=' . $_SESSION['orderVendorId'] . '&spotid=' . $_SESSION['spot']['spotId'];
        }

        if (isset($_SESSION['iframe'])) {
            unset($_SESSION['iframe']);
            $_SESSION['iframeRedirect'] = $baseUrl . 'make_order?vendorid=' . $_SESSION['orderVendorId'];
        }

        if (
            empty($_SESSION['orderId'])
            || empty($_SESSION['postOrder'])
            || empty($_SESSION['spot'])
            || empty($_SESSION['orderStatusCode'])
        ) {
            $this->goBack();
        }

        $data = [
        	'odredId' => $_SESSION['orderId'],
            'amount' => floatval($_SESSION['postOrder']['order']['amount']),
            'waiterTip' => floatval($_SESSION['postOrder']['order']['waiterTip']),
            'spotName' => $_SESSION['spot']['spotName'],
            'orderStatusCode' => $_SESSION['orderStatusCode'],
            'successCode' => $this->config->item('payNlSuccess'),
        ];

        Utility_helper::unsetPaymentSession();
        $this->loadViews("paysuccesslink", $this->global, $data, 'nofooter', 'noheader');
    }

    public function goBack(): void
    {
        $redirect = Utility_helper::getSessionValue('redirect');
        redirect($redirect);
    }
}
