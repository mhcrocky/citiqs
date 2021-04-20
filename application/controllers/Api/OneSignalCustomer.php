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
			$this->load->model('notification_model');
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

                $email = $user['emailBuyer'];
                $vendorId = $user['vendorId'];
				$AppId = $user['appId'];
				$PlayerId = $user['playerId'];

				// CHECK ONE SIGNAL ID
				// Now we need to check the other table.... playerId this is unique in every way...

				// We need to check 2 processes.
				// Does user exist? (tbl_user)
				// Does user app register exist (tbl_user_notification)

//				echo var_dump($user);
//				return;

                $result = $this->notification_model->checkOneSignalIdUser($user);

//				echo var_dump($user);
//				echo var_dump($result);
//				return;

				if (empty($result)) {
					$this->user_model->manageAndSetUserOneSignal($user);
					if ($this->user_model->id) {
						// create user in the app table for multiple apps. tbl_user_notification
//						$result = $this->notification_model->checkOneSignalId($user);
						if (empty($result)){
							$result = $this->notification_model->addOneSignalId($user);
							echo json_encode([
								'status' => '1',
								'message' => 'Added'
							]);
							return;
						}
					}
				}
				else {
					// check if user tbl_user_notification exist
					// if not than add
					// addOneSignalId (function in Notification_model)
					// Check with !
					$result = $this->notification_model->checkOneSignalId($user);
					if (empty($result)){
						$result = $this->notification_model->addOneSignalId($user);
						echo json_encode([
							'status' => '1',
							'message' => 'Added'
						]);
						return;
					}
				}

            }

//            var_dump($result);
//            var_dump($user);
//            die();

            echo json_encode([
                'status' => '0',
                'message' => 'Not allowed'
            ]);

        	return;
        }
    }
