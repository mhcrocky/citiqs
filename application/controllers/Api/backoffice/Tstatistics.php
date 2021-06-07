<?php
require APPPATH . 'libraries/REST_Controller.php';
/**
 * Vendors class
 * 
 * Class is used for communication with perfex crm
 */

class Tstatistics extends REST_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model('shopvendor_model');
            $this->load->model('tickets_model_statistics');
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

        public function alltickets_get(): void
        {
            if (!$this->authentication()) return;

//			$vendor = $this->security->xss_clean($this->input->post('vendor'));
//			$from = $this->security->xss_clean($this->input->post('from'));
//			$to = $this->security->xss_clean($this->input->post('to'));
            $get = Utility_helper::sanitizeGet();
            $from = empty($get['from']) ? '' : str_replace('T', ' ', $get['from']);
            $to = empty($get['to']) ? '' : str_replace('T', ' ', $get['to']);



            $orders = $this->tickets_model_statistics->fetchTicketsForStatistics($from, $to);

//            if ($orders) {
//                $response = [
//                    'status' => '1',
//                    'data' => $orders
//                ];
//            } else {
//                $response = [
//                    'status' => '0',
//                    'messages' => 'No orders'
//                ];
//            }
            $this->set_response($orders, 200);
            return;
        }

		public function allreservations_get(): void
		{
			if (!$this->authentication()) return;

	//			$vendor = $this->security->xss_clean($this->input->post('vendor'));
	//			$from = $this->security->xss_clean($this->input->post('from'));
	//			$to = $this->security->xss_clean($this->input->post('to'));
			$get = Utility_helper::sanitizeGet();
			$from = empty($get['from']) ? '' : str_replace('T', ' ', $get['from']);
			$to = empty($get['to']) ? '' : str_replace('T', ' ', $get['to']);



			$orders = $this->tickets_model_statistics->fetchReservationsForStatistics($from, $to);

	//            if ($orders) {
	//                $response = [
	//                    'status' => '1',
	//                    'data' => $orders
	//                ];
	//            } else {
	//                $response = [
	//                    'status' => '0',
	//                    'messages' => 'No orders'
	//                ];
	//            }
			$this->set_response($orders, 200);
			return;
		}
    }
