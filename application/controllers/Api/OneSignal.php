<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class OneSignal extends REST_Controller
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

        public function data_post()
        {
            $header = getallheaders();
            $key = $header['x-api-key'];

            if ($this->api_model->userAuthentication($key)) {
                $user = $this->input->post(null, true);


                //CHECK ONE SIGNAL ID
                if ($this->user_model->checkOneSignalId($user['oneSignalId'])) {
                    echo json_encode([
                        'status' => '0',
                        'message' => 'User with this one signal id already exist',
                    ]);
                    return;
                };

                // INSERT USER
                $user['roleId'] = $this->config->item('buyer');
                $user['salesagent'] = $this->config->item('defaultSalesAgentId');
                $user['usershorturl'] = 'api one signal';

                $this->user_model->manageAndSetUser($user);
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

