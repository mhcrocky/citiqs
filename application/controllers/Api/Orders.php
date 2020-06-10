<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class Orders extends REST_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model('shopprinters_model');
            $this->load->model('shoporder_model');

            $this->load->helper('utility_helper');
            $this->load->helper('validate_data_helper');
            $this->load->library('language', array('controller' => $this->router->class));
        }

        public function data_get()
        {
            $get = $this->input->get(null, true);

            if(!$get['mac']) return;
             
            $this->shopprinters_model->macNumber = $get['mac'];

            $ordersToPrint = $this->shopprinters_model->fetchOrdersForPrint();

            if (!$ordersToPrint) return;

            $ordersToPrint = Utility_helper::resetArrayByKeyMultiple($ordersToPrint, 'orderId');

            // var_dump($ordersToPrint);
            foreach ($ordersToPrint as $orderId => $order) {
                
                var_dump($order);


                // UNCOMMENT UPDATE ORDER PRINT STATUS
                // $this
                //     ->shoporder_model
                //     ->setObjectId(intval($orderId))
                //     ->setObjectFromArray(['printStatus' => '1'])
                //     ->update();
            }

        }
    }
