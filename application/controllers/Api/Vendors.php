<?php
require APPPATH . 'libraries/REST_Controller.php';
/**
 * Vendors class
 * 
 * Class is used for communication with perfex crm
 */

class Vendors extends REST_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model('shopvendor_model');
            $this->load->model('shoporder_model');
            $this->load->model('api_model');
            $this->load->helper('utility_helper');
            $this->load->helper('validate_data_helper');

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

        public function orders_post(): void
        {
            if (!$this->authentication()) return;

            $post = Utility_helper::sanitizePost();
            if (!$this->validatePostForOrderUpdate($post)) return;
            $vendorId = intval($post['alfredId']);
            $invoiceId = intval($post['invoiceId']);
            $orderIds = $this->shoporder_model->fetchVendorOrderIds($vendorId, $post['from'], $post['to']);

            if (is_null($orderIds)) {
                $response = [
                    'status' => '0',
                    'messages' => 'No orders to update'
                ];
                $this->set_response($response, 200);
                return;
            } 

            $orderIds= array_map(function ($el) {
                return $el['id'];
            }, $orderIds);

            $update = $this->shoporder_model->updateOrderWithInvoiceId($orderIds, $invoiceId);
            $response['status'] = $update ? '1' : '0';

            $this->set_response($response, 200);
            return;

        }

        private function validatePostForOrderUpdate(array $post): bool
        {
            if (empty($post['alfredId']) || !Validate_data_helper::validateInteger($post['alfredId'])) {
                $response = [
                    'status' => '0',
                    'messages' => 'Invalid vendor id'
                ];
                $this->set_response($response, 200);
                return false;
            }

            if (empty($post['invoiceId']) || !Validate_data_helper::validateInteger($post['invoiceId'])) {
                $response = [
                    'status' => '0',
                    'messages' => 'Invalid invoice id'
                ];
                $this->set_response($response, 200);
                return false;
            }

            if (empty($post['from']) || !Validate_data_helper::validateDate($post['from'])) {
                $response = [
                    'status' => '0',
                    'messages' => 'Date from is required'
                ];
                $this->set_response($response, 200);
                return false;
            }

            if (empty($post['to'])|| !Validate_data_helper::validateDate($post['to'])) {
                $response = [
                    'status' => '0',
                    'messages' => 'Date to is required'
                ];
                $this->set_response($response, 200);
                return false;
            }

            if ($post['from'] > $post['to']) {
                $response = [
                    'status' => '0',
                    'messages' => 'Date from can not be bigger than date to'
                ];
                $this->set_response($response, 200);
                return false;
            }

            return true;
        }

    }
