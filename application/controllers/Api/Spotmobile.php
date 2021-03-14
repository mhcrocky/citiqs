<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class Spotmobile extends REST_Controller
    {

        function __construct()
        {
            parent::__construct();

            $this->load->model('user_model');
            $this->load->model('api_model');
            $this->load->helper('utility_helper');
            $this->load->config('custom');
            $this->load->library('language', array('controller' => $this->router->class));

        }

		public function index_get()
		{
			$data = "No function called like this";
			$this->response($data, REST_Controller::HTTP_OK);
		}

		public function index_post()
		{
			$data = "No function called like this";
			$this->response($data, REST_Controller::HTTP_OK);
		}

		public function spotinsert_post(): void
		{

			$header = getallheaders();
			$key = $header['X-Api-Key'];

			if ($this->api_model->userAuthentication($key)) {

				$api = $this->input->post(null, true);
//				$onesignalid= $this->user_model->checkOneSignalId($api['oneSignalId']);
//				$onoff=$this->user_model->checkOneSignalId($api['onoff']);
				$vendorid= $api['vendorId'];
				$qrcode=$api['QRCode'];
				$spot=$api['SPOT'];
				$printer=$api['printer'];
				$servicetype=$api['servicetype'];

				if (!empty($api)) {
					echo json_encode([
						'status' => '0',
						'message' => 'SPOT CREATED',
						'vendorId' => $vendorid,
						'QRCode' => $qrcode,
						'SPOT' => $spot,
						'printer' => $printer,
						'servicetype' => $servicetype
					]);
					// Here we look into the db if the spot exist if not we create the spot
					return;
				}

//				if ($onoffon==1) {
//					echo json_encode([
//						'status' => '0',
//						'message' => 'Messaging on',
//						'onesignalid' => $onesignalid,
//						'onoff' => $onoffon,
//					]);
//					return;
//				}

				// find playerid
				// delete playerid

				//

//				$this->user_model->manageAndSetUserOneSignal($user);
//
//				if ($this->user_model->id) {
//					$message = isset($this->user_model->created) ? 'User created' : 'User updated';
//					echo json_encode([
//						'status' => '1',
//						'message' => $message,
//						'userId' => $this->user_model->id
//					]);
//					return;
//				}
//				echo json_encode([
//					'status' => '0',
//					'message' => 'Action failed',
//				]);
				return;
			}

			echo json_encode([
				'status' => '0',
				'message' => 'Not allowed'
			]);

			return;
		}
    }

