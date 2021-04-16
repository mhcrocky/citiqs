<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class OneSignalCustomer extends REST_Controller
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

			// A customer can have multiple apps. From VEndors..
			// - Lunchroom
			// - thuishaven
			//
			// Each app has its own app-ID and Player ID
			// So this needs to be seperately stored in new table.
			// user_notificationIds
			// Table structure
			// id (user, corresponding id from userid table). Unique
			// VendorId
			// App-ID
			// PLayer ID
			//
			// When the user is going to be informed the right vendor -> app id'' need to correspondent with the app.
			//

			$header = getallheaders();
			$key = $header['X-Api-Key'];

            if ($this->api_model->userAuthentication($key)) {
                $user = $this->input->post(null, true);

                $vendorId = $user['VendorId'];
				$AppId = $user['AppId'];
				$PlayerId = $user['PLayerId'];

				// CHECK ONE SIGNAL ID
				// Now we need to check the other table.... playerId this is unique in every way...

                $result = $this->notification_model->checkOneSignalId($user);

				if ($result) {
                    echo json_encode([
                        'status' => '1',
                        'message' => 'User with this one signal id already exist',
						'userid' => $result['id']
                    ]);
                    return;
                }
                // INSERT USER
                $user['roleId'] = $this->config->item('buyer');
                $user['salesagent'] = $this->config->item('defaultSalesAgentId');
                $user['usershorturl'] = 'api one signal';
                $this->user_model->manageAndSetUserOneSignal($user);

                if ($this->user_model->id) {
                    $message = isset($this->user_model->created) ? 'User created' : 'User updated';
                    echo json_encode([
                        'status' => '1',
                        'message' => $message,
                        'userId' => $this->user_model->id
                    ]);
                    return;
                }
                echo json_encode([
                    'status' => '0',
                    'message' => 'Action failed',
                ]);
                return;
            }

            echo json_encode([
                'status' => '0',
                'message' => 'Not allowed'
            ]);

        	return;
        }
    }
