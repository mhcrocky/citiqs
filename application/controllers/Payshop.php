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
            $this->load->helper('paynl_helper');
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

            // TIQS TO DO  REMOVE THIS LINE
            $this->shoporder_model->id = 7;

            if (is_null($this->shoporder_model->id)) {
                $this->session->set_flashdata('error', 'Order not made! Please try again');
                redirect('make_order');
                exit();
            }

            // fetch and check order
            $order = $this->shoporder_model->fetchOne();
            if (!$order) {
                $this->session->set_flashdata('error', 'Order not made! Please try again');
                redirect('make_order');
                exit();
            }
            $order = reset($order);

            // check is order paid
            if (intval($order['orderPaidStatus'])) {
                $this->session->set_flashdata('success', 'Order is paid');
                redirect('make_order');
                exit();
            }

        }
    }
    
