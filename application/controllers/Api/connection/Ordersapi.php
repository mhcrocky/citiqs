<?php
    declare(strict_types=1);

    require_once FCPATH . 'application/controllers/Api/connection/Authentication.php';
    require_once FCPATH . 'application/controllers/Api/connection/Buyerapi.php';

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Ordersapi extends Authentication
    {

        public function __construct()
        {
            parent::__construct();

            // helpers
            $this->load->helper('connections_helper');
            $this->load->helper('error_messages_helper');
            $this->load->helper('utility_helper');
            $this->load->helper('sanitize_helper');

            // libaries
            $this->load->library('language', array('controller' => $this->router->class));
        }

        public function index(): void
        {
            return;
        }

        /**
         * data_post
         *
         * @see Authentication::vendorAuthentication()
         * @return void
         */
        public function order_post(): void
        {
            $vendor  = $this->vendorAuthentication();

            if (is_null($vendor)) return;

            $post = Sanitize_helper::sanitizePhpInput();

            if (empty($post)) {
                $response = [
                    'status' => 0,
                    'errorCode' => Error_messages_helper::$NO_DATA
                ];
                $response['message'] = Error_messages_helper::getErrorMessage($response['errorCode']);
                $this->response($response, 200);
                return;
            }

            die();

            // manage byuer
            $email = isset($post['byuer']['email']) ? $this->security->xss_clean($post['byuer']['email']) : '';
            $email = ['email' => $email];
            $url = base_url() . 'api/connection/buyer?email=email'; # . http_build_query($email);
            $headers = ['x-api-key: ' . $vendor['apiKey']];
            #var_dump(Connections_helper::sendGetRequest($url, ['x-api-key: '. $vendor['apiKey']]));

            $headers = ['x-api-key: ' . $vendor['apiKey']];
            $response = Connections_helper::sendGetRequest($url, $headers);

            var_dump($response);

            return;
        }

        private function getBuyer(array $post)
        {
            $email = isset($post['byuer']['email']) ? $this->security->xss_clean($post['byuer']['email']) : '';
            $email = ['email' => $email];
            $url = base_url() . 'api/connection/buyer?email=email'; # . http_build_query($email);
            $headers = ['x-api-key: ' . $vendor['apiKey']];
            #var_dump(Connections_helper::sendGetRequest($url, ['x-api-key: '. $vendor['apiKey']]));

            $headers = ['x-api-key: ' . $vendor['apiKey']];
            $response = Connections_helper::sendGetRequest($url, $headers);

            var_dump($response);

        }
    }
