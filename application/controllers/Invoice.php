<?php
declare(strict_types=1);

if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/BaseControllerWeb.php';

Class Invoice extends BaseControllerWeb
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');

        $this->load->model('subscription_model');

        $this->load->config('custom');
        $this->load->library('language', array('controller' => $this->router->class));

        $this->isLoggedIn();
    }

    public function index(): void
    {
        redirect(base_url() . 'invoice/pay');
        return;
    }

    public function pay(): void
    {
        $this->global['pageTitle'] = 'Pay invoice';
        $user = $this->user_model->getUserInfoById($_SESSION['userId']);
        $subscriptionWhat = ['id', 'short_description', 'description', 'ROUND(amount, 2) AS amount', 'active', 'tiqssendcom', 'backOfficeItemId', 'type'];
        $subscriptionWhere = ['id='=> $this->uri->segment(4)];
        $data = [
            'user_id' => $_SESSION['userId'],
            'label_user_id' => $this->config->item('tiqsId'),
            'reciver_id' => $this->config->item('tiqsId'),
            'bagsCategoryId' => $this->config->item('bagsCategoryId'),
            'dclw' => $this->config->item('freePackageDclw'),
            'dcll' => $this->config->item('freePackageDcll'),
            'dclh' => $this->config->item('freePackageDclh'),
            'dclwgt' => $this->config->item('freePackageDclwgt'),
            'label_type_id' => $this->config->item('labelSubscription'),
            'type' => $this->uri->segment(3),
            'subscription' => $this->subscription_model->select($subscriptionWhat, $subscriptionWhere)[0],

        ];
        $this->loadViews("sendbags", $this->global, $data, NULL);

        return;
    }
}
