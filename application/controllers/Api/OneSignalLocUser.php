<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class OneSignalLocUser extends REST_Controller
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

		public function data_post(): void
		{
			$header = getallheaders();
			$key = $header['X-Api-Key'];

            if ($this->api_model->userAuthentication($key)) {
				$user = $this->input->post(null, true);

//				var_dump($user['email']);
//				die();

				//CHECK ONE SIGNAL ID
				if ($this->user_model->checkOneSignalId($user['oneSignalId'])) {
					echo json_encode([
						'status' => '0',
						'message' => 'https://tiqs.com/alfred/assets/home/images/win2.png',
						'url' => 'https://etiqs.com/lunchroomzondag/1/1',
						'code' => '3345'
					]);

					// http://etiqs.com/domains/etiqs.com/public_html/yourshop/1/RGifIakAE3MQwRbVV9OA1HREGgRwqCqnFwZh
					return;}
				else{
					echo json_encode([
						'status' => '0',
						'message' => 'https://tiqs.com/alfred/assets/home/images/win2.png',
						'url' => 'https://tiqs.com/alfred/registerbusiness',
						'code' => '3345'
					]);
				return;}

			}

            echo json_encode([
                'status' => '0',
                'message' => 'Not allowed'
            ]);

        return;
        }
    }

