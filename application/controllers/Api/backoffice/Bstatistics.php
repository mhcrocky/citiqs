<?php
require APPPATH . 'libraries/REST_Controller.php';
/**
 * Vendors class
 * 
 * Class is used for communication with perfex crm
 */

class Bstatistics extends REST_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model('shopvendor_model');
            $this->load->model('shoporder_model_statistics');
            $this->load->model('user_model');
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

        public function allorders_get(): void
        {
            if (!$this->authentication()) return;

//			$vendor = $this->security->xss_clean($this->input->post('vendor'));
//			$from = $this->security->xss_clean($this->input->post('from'));
//			$to = $this->security->xss_clean($this->input->post('to'));
            $get = Utility_helper::sanitizeGet();
            $from = empty($get['from']) ? '' : str_replace('T', ' ', $get['from']);
            $to = empty($get['to']) ? '' : str_replace('T', ' ', $get['to']);

            $orders = $this->shoporder_model_statistics->fetchOrdersForStatistics($from, $to);

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
            $orderIds = $this->shoporder_model_statistics->fetchVendorOrderIds($vendorId, $post['from'], $post['to']);

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

            $response['status'] = '1';

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

        public function vendor_put($vendorId): void
        {
            if (!$this->authentication()) return;

            $parsedJson = file_get_contents("php://input");
            $parsedJson = json_decode($parsedJson, true);
            $parsedJson = reset($parsedJson);
            $vendorId = intval($vendorId);

            if ($this->user_model->setUniqueValue($vendorId)->setWhereCondtition()->updateUserImproved($parsedJson)) {

                $this->activateNewAccount($parsedJson, $vendorId);

                $response = [
                    'status' => '1',
                    'message' => 'User updated'
                ];
            } else {
                $response = [
                    'status' => '0',
                    'message' => 'User did not update'
                ];
            }

            $this->set_response($response, 200);
        }

        private function activateNewAccount(array $parsedJson, int $vendorId): void
        {
            // actvate new user account
            if (
                isset($parsedJson['active'])
                && $parsedJson['active'] === '1'
                && !$this->shopvendor_model->setProperty('vendorId', $vendorId)->isVendorExists()
            ) {
                $activateUrl = base_url() . 'login' . DIRECTORY_SEPARATOR . 'insertShopAndPerfexUser' . DIRECTORY_SEPARATOR . $vendorId;
                file_get_contents($activateUrl);
            }
        }

        public function users_get(): void
        {
            if (!$this->authentication()) return;

            $users = $this->user_model->getVendors();
            $this->set_response($users, 200);

            return;
        }

        public function usersQR_get(): void
        {
            if (!$this->authentication()) return;

            $users = $this->user_model->getVendorsQR();
            $this->set_response($users, 200);

            return;
        }
    }
