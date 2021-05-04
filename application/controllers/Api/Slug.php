<?php
    declare(strict_types=1);

    require APPPATH . 'libraries/REST_Controller.php';

    Class Slug extends REST_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model('slug_model');
            $this->load->model('api_model');

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

            $this->set_response($response, 403);
            return false;
        }

        public function data_get(): void
        {
            if (!$this->authentication()) return;

            $where = [
                'tbl_app_routes.vendorId != ' => '0',
            ];

            $data = $this->slug_model->getSlugs($where);

            $this->set_response($data, 200);

            return;
        }

        public function data_post(): void
        {
            if (!$this->authentication()) return;

            $post = $this->security->xss_clean($_POST);
            $create = $this->slug_model->setObjectFromArray($post)->create();

            if ($create) {
                $response = [
                    'status' => '1',
                    'message' => 'success',
                ];
            } else {
                $response = [
                    'status' => '0',
                    'message' => 'failed',
                ];
            }

            $this->set_response($response, 200);
            return;
        }

        public function data_put($slugId): void
        {
            if (!$this->authentication()) return;

            $post = file_get_contents("php://input");
            $post = json_decode($post, true);
            $post = reset($post);
            $slugId = intval($slugId);

            $update = $this->slug_model->setObjectId($slugId)->setObjectFromArray($post)->update();

            if ($update) {
                $response = [
                    'status' => '1',
                    'message' => 'success',
                ];
            } else {
                $response = [
                    'status' => '0',
                    'message' => 'failed',
                ];
            }

            $this->set_response($response, 200);
            return;
        }

        public function data_delete($slugId): void
        {
            if (!$this->authentication()) return;

            $slugId = intval($slugId);

            $delete = $this->slug_model->setObjectId($slugId)->delete();

            if ($delete) {
                $response = [
                    'status' => '1',
                    'message' => 'success',
                ];
            } else {
                $response = [
                    'status' => '0',
                    'message' => 'failed',
                ];
            }

            $this->set_response($response, 200);
            return;
        }

    }
