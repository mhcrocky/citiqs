<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Ajaxbuyer extends CI_Controller
    {

        public function __construct()
        {
            parent::__construct();

            $this->checkIsBuyer();

            $this->load->helper('utility_helper');

            $this->load->model('shoporder_model');

            $this->load->config('custom');

            $this->load->library('language', array('controller' => $this->router->class));
        }

        private function checkIsBuyer(): void
        {
            if (empty($_SESSION['buyerId'])) exit();
        }

        private function outputData(array $rawData): void
        {
            $data = [
                'data' => $rawData 
            ];

            $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    
            $this
                ->output
                    ->set_status_header( 200 )
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output($data);
            return;
        }

        public function index(): void
        {
            die();
        }

        public function getBuyerOrders(): void
        {
            if (!$this->input->is_ajax_request()) return;

            $orders = $this->shoporder_model->setProperty('buyerId', $_SESSION['buyerId'])->getBuyerOrders();

            $this->outputData($orders);

            return;
        }

        public function fetchOrder($orderId): void
        {
            if (!$this->input->is_ajax_request()) return;

            $order = $this->shoporder_model->setObjectId(intval($orderId))->getOrderProducts();
            echo json_encode($order);

            return;
        }
    }
