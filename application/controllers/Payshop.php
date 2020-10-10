<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';

    class Payshop extends BaseControllerWeb
    {

        public function __construct()
        {
            parent::__construct();

            $this->load->helper('utility_helper');
            $this->load->model('shoporder_model');
            $this->load->config('custom');

            // $this->load->library('language', array('controller' => $this->router->class));
        }

        public function index(): void
        {
            die();
        }

        public function payOrder(): void
        {
            // get and unset $_SESSION['orderId']
            $this->shoporder_model->id = Utility_helper::getSessionValue('orderId');
            // get and unset $_SESSION['spotId']
            $spotId = Utility_helper::getSessionValue('spotId');
            // redirect
            $makeOrderRedirect = 'make_order?spotid=' . $spotId;

            if (is_null($this->shoporder_model->id)) {
                $this->session->set_flashdata('error', '(2010) Order not made! Please try again');
                redirect($makeOrderRedirect);
                exit();
            }

            // fetch and check order
            $order = $this->shoporder_model->fetchOne();

            if (!$order) {
                $this->session->set_flashdata('error', '(2020) Order not made! Please try again');
                redirect($makeOrderRedirect);
                exit();
            }
            $order = reset($order);

            // check is order paid
            if (intval($order['orderPaidStatus'])) {
                $this->session->set_flashdata('success', 'Order is paid');
                redirect($makeOrderRedirect);
                exit();
            }
            var_dump($order);
        }
    }
    
