<?php
require APPPATH . 'libraries/REST_Controller.php';

class Vendors extends REST_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model('shopvendor_model');
            $this->load->model('shoporder_model');
            $this->load->model('api_model');
			$this->load->helper('utility_helper');

            $this->load->library('language', array('controller' => $this->router->class));
        }

        private function authentication(): bool
        {
            $header = getallheaders();

            if (!empty($header['X-Api-Key']) && $this->api_model->userAuthentication($header['X-Api-Key'])) return true;

            $response = [
                'status' => '0',
                'message' => 'Authentication failed'
            ];

            $this->response($response, 403);
            return false;

        }

        public function data_get(): void
        {
            if (!$this->authentication()) return;

            $where = [
                'tbl_shop_vendors.payNlServiceId!=' => null,
            ];
            $vendors = $this->shopvendor_model->getVendors($where);
            $this->set_response($vendors, 200);

            return;
        }

        public function orders_get(): void
        {
            if (!$this->authentication()) return;

            $get = Utility_helper::sanitizeGet();
            $vendorId = intval($get['vendor']);
            $from = empty($get['from']) ? '' : $get['from'];
            $to = empty($get['to']) ? '' : $get['to'];

            $orders = $this->shoporder_model->fetchUnpaidVendorOrders($vendorId, true, $from, $to);

            if ($orders) {
                $response = [
                    'status' => '1',
                    'data' => $orders
                ];
            } else {
                $response = [
                    'status' => '0',
                    'messages' => 'No orders'
                ];
            }
            $this->set_response($response, 200);
            return;
        }
    }

