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
			$this->load->model('qr_model');
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
				$vendorId= $api['vendorId'];
				$qrcode=$api['QRCode'];
				$spot=$api['SPOT'];
				$printer=$api['printer'];
				$servicetype=$api['servicetype'];

				if (!empty($api)) {
					echo json_encode([
						'status' => '0',
						'message' => 'SPOT CREATED',
						'vendorId' => $vendorId,
						'QRCode' => $qrcode,
						'SPOT' => $spot,
						'printer' => $printer,
						'servicetype' => $servicetype,
					]);
					// Here we look into the db if the spot exist if not we create the spot
					$result = $this->qr_model->getQRcodeByCode($qrcode);
//					echo var_dump($result);

					if (empty($result)){
						echo json_encode([
							'status' => '0',
							'message' => 'QRCode not by tiqs.'
						]);
					}

//					var_dump($result->vendorId);
//					var_dump($vendorId);

					if($result->vendorId === '0') {
						$data['vendorId']=$vendorId;
						$result = $this->qr_model->updateQRCodes($data,$qrcode);
					}

					// STEP 1
					// is the record allready filled with vendorId
					// is the vendorId the same?
					// if not DO NOTHING -> ERROR you cannot change the STICKERS OWNER

					// STEP 2
					// DOES THE SPOT EXIST?
					// IF SPOT NOT EXITS
					// MAKE SPOT and USE PRINTER

					// STEP 3
					// UPDATE tbl_qrcodes


					return;
				}


				return;
			}

			echo json_encode([
				'status' => '0',
				'message' => 'Not allowed'
			]);

			return;
		}
    }

