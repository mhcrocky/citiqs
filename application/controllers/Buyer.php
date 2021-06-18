<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';

    class Buyer extends BaseControllerWeb
    {

        public function __construct()
        {
            parent::__construct();

            $this->checkIsBuyer();

            $this->load->helper('utility_helper');

            $this->load->model('shoporder_model');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');

            $this->load->config('custom');
        }

        private function checkIsBuyer(): void
        {
            if (!$this->isBuyer()) redirect('logout');
        }

        public function index(): void
        {
            $this->global['pageTitle'] = 'TIQS : BUYER';

            $data = [];

            $this->loadViews('buyer/buyer', $this->global, $data, 'footerbusiness', 'headerbusiness');
        }

        public function buyerOrders(): void
        {
            $this->global['pageTitle'] = 'TIQS : BUYER ORDERS';

            var_dump($_SESSION);
            $orders = $this->shoporder_model->setProperty('buyerId',  $_SESSION['buyerId'])->getBuyerOrders();
            var_dump($orders);
            die();

            $data = [];

            $this->loadViews('buyer/buyerOrders', $this->global, $data, 'footerbusiness', 'headerbusiness');
        }

        public function buyerTickets(): void
        {
            $this->global['pageTitle'] = 'TIQS : BUYER TICKETS';

            $data = [];

            $this->loadViews('buyer/buyerTickets', $this->global, $data, 'footerbusiness', 'headerbusiness');
        }


        public function buyerReservations(): void
        {
            $this->global['pageTitle'] = 'TIQS : BUYER RESERVATIONS';

            $data = [];

            $this->loadViews('buyer/buyerReservations', $this->global, $data, 'footerbusiness', 'headerbusiness');
        }

    }
