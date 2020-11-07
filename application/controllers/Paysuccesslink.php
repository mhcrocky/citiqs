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
        $this->load->model('shoporder_model');
        $this->load->helper('url');
        $this->load->helper('utility_helper');
        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index()
    {
        $get = Utility_helper::sanitizeGet();
        $orderId = $get['orderid'];

        $order = $this->shoporder_model->setObjectId($orderId)->fetchOne();
        $order = reset($order);

        if ($order['orderRandomKey'] !== $get[$this->config->item('orderDataGetKey')]) {
            redirect(base_url());
        }

        $data = [
            'order' => $order,
            'paid' => $this->config->item('orderPaid'),
        ];

        $this->global['pageTitle'] = 'TIQS : SUCCESS';
        $this->loadViews("paysuccesslink", $this->global, $data, 'nofooter', 'noheader');
    }
}
