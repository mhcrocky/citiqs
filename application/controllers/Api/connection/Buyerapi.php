<?php
    declare(strict_types=1);

    require_once APPPATH . 'controllers/Api/connection/Authentication.php';

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Buyerapi extends Authentication
    {

        public function __construct()
        {
            parent::__construct();

            // models
            $this->load->model('user_model');
            $this->load->model('userex_model');

            // helpers
            $this->load->helper('validate_data_helper');
            $this->load->helper('error_messages_helper');
            $this->load->helper('utility_helper');

            $this->load->config('custom');

            // libaries
            $this->load->library('language', array('controller' => $this->router->class));
        }

        public function index(): void
        {
            return;
        }

        /**
         * buyer_get
         *
         * Get buyer data
         *
         * @see Authentication::vendorAuthentication()
         * @return void
         */
        public function buyer_get(): void
        {
            $vendor  = $this->vendorAuthentication();

            if (is_null($vendor)) return;

            $email = $this->input->get('email', true);

            if (empty($email)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ERR_BUYER_EMAIL_NOT_SET);
                $this->response($response, 200);
                return;
            }

            if (!Validate_data_helper::validateEmail($email)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$INVALID_BUYER_EMAIL);
                $this->response($response, 200);
                return;
            }

            $this
                ->user_model
                ->setUniqueValue($email)
                ->setWhereCondtition()
                ->setUser();

            if (is_null($this->user_model->id)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$BUYER_NOT_EXISTS);
                $this->response($response, 200);
                return;
            }

            $response = [
                'status' => Connections_helper::$SUCCESS_STATUS,
                'data' => [
                    'buyer' => [
                        'email' => $this->user_model->email,
                        'firstName' => $this->user_model->first_name,
                        'secondName' => $this->user_model->second_name,
                        'mobile' => $this->user_model->mobile,
                        'address' => $this->user_model->address,
                        'addressAdditionalLine' => $this->user_model->addressa,
                        'zipcode' => $this->user_model->zipcode,
                        'city' => $this->user_model->city,
                        'country' => $this->user_model->country,
                        'requireNewsletter' => $this->user_model->newsletter,
                        'apiIdentifier' => $this->user_model->getApiIdentifier(),
                    ]
                ]
            ];

            // get user extended
            $user = $this->userex_model->setProperty('userId', $this->user_model->id)->getUserEx();
            if ($user) {
                unset($user['id']);
                unset($user['userId']);
                $response['data']['buyer']['buyerExtended'] = $user;
            }

            $this->response($response, 200);
            return;
        }

        /**
         * buyer_post
         *
         * Get buyer data
         *
         * @see Authentication::vendorAuthentication()
         * @return void
         */
        public function buyer_post(): void
        {
            $vendor = $this->vendorAuthentication();

            if (is_null($vendor)) return;

            $buyer = Utility_helper::sanitizePost();
            $requireMobile = intval($vendor['requireMobile']) ? true : false;
            $requireName = intval($vendor['requireMobile']) ? true : false;

            if (!empty($buyer['buyerExtended'])) {
                $buyerExtended = $buyer['buyerExtended'];
                unset($buyer['buyerExtended']);
            }

            if (!$this->checkBuyerData($buyer)) return;
            if (!$this->checkTrimBuyerData($buyer)) return;
            if (!$this->checkBuyerEmail($buyer)) return;
            if (!$this->checkBuyerMobile($buyer, $requireMobile)) return;
            if (!$this->checkBuyerName($buyer, $requireName)) return;

            $insertBuyer = $this->getInsertBuyerData($buyer);
            $this->user_model->manageAndSetBuyer($insertBuyer);

            if (is_null($this->user_model->id)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$BUYER_INSERT_FAILED);
                $this->response($response, 200);
                return;
            }

            $response = [
                'status' => Connections_helper::$SUCCESS_STATUS,
                'message' => 'Buyer inserted',
                'data' => [
                    'apiIdentifier' => $insertBuyer['apiIdentifier']
                ]
            ];

            if (isset($buyerExtended)) {
                $buyerExtended['userId'] = $this->user_model->id;
                $response['buyerExtended'] = ($this->userex_model->setObjectFromArray($buyerExtended)->create()) ? '1' : '0';
            }

            $this->user_model->resendActivationLink($buyer['email']);

            $this->response($response, 200);
            return;
        }

        /**
         * buyer_put
         *
         * Update buyer data
         *
         * @see Authentication::vendorAuthentication()
         * @return void
         */
        public function buyer_put($apiIdentifier): void
        {
            $vendor = $this->vendorAuthentication();

            if (is_null($vendor)) return;
            if (!$this->checkApiIdentifier($apiIdentifier)) return;

            $buyerData = Sanitize_helper::sanitizePhpInput();

            if (!$this->checkPutBuyerData($buyerData)) return;

            $updateBuyer = [];
            if (!$this->setUpdateBuyerData($buyerData, $updateBuyer)) return;

            if (!$this->user_model->apiUpdateUser($updateBuyer)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$BUYER_UPDATE_FAILED);
                $this->response($response, 200);
                return;
            };

            $response = [
                'status' => Connections_helper::$SUCCESS_STATUS,
                'message' => 'Buyer updated'
            ];
            $this->response($response, 200);
            return;
        }

        /**
         * buyerex_put
         *
         * Update buyer extended data
         *
         * @see Authentication::vendorAuthentication()
         * @return void
         */
        public function buyerex_put($apiIdentifier): void
        {
            $vendor = $this->vendorAuthentication();

            if (is_null($vendor)) return;

            $buyerExData = Sanitize_helper::sanitizePhpInput();
            if (empty($buyerExData)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_DATA_SENT);
                $this->response($response, 200);
                return;
            };
            $buyerExData = reset($buyerExData);

            if (!$this->checkApiIdentifier($apiIdentifier)) return;

            $update = $this->userex_model
                                        ->setProperty('userId', $this->user_model->id)
                                        ->setIdFromUserId()
                                        ->setObjectFromArray($buyerExData)
                                        ->update();

            if (!$update) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$BUYER_EX_UPDATE_FAILED);
                $this->response($response, 200);
                return;
            };

            $response = [
                'status' => Connections_helper::$SUCCESS_STATUS,
                'message' => 'Buyer extended updated'
            ];
            $this->response($response, 200);
            return;
        }

        private function getUpdateBuyerExData()
        {
            $buyerExData = Sanitize_helper::sanitizePhpInput();
            if (empty($buyerExData)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_DATA_SENT);
                $this->response($response, 200);
                exit;
            };
            return reset($buyerExData);
        }

        private function checkBuyerData(?array $buyer): bool
        {
            if (empty($buyer)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_BUYER_DATA);
                $this->response($response, 200);
                return false;
            }


            return true;
        }

        private function checkTrimBuyerData(?array &$buyer): bool
        {

            $update = false;
            foreach($buyer as $key => $value) {
                if (trim($value) && !$update) {
                    $update = true;
                }
                $buyer[$key] = trim($value);
            }
            if (!$update) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_BUYER_DATA);
                $this->response($response, 200);
            }

            return $update;
        }

        private function checkBuyerEmail(array $buyer): bool
        {
            if (empty($buyer['email'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ERR_BUYER_EMAIL_NOT_SET);
                $this->response($response, 200);
                return false;
            }
    
            $email = $buyer['email'];

            if (!Validate_data_helper::validateEmail($email)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$INVALID_BUYER_EMAIL);
                $this->response($response, 200);
                return false;
            }
    
            $this->user_model->setUniqueValue($email)->setWhereCondtition()->setUser();

            if ($this->user_model->id) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$BUYER_ALREADY_EXISTS);
                $this->response($response, 200);
                return false;
            }

            return true;    
        }

        private function checkBuyerMobile(array &$buyer, bool $requireMobile): bool
        {

            if ($requireMobile) {
                if(empty($buyer['mobile'])) {
                    $response = Connections_helper::getFailedResponse(Error_messages_helper::$BUYER_MOBILE_REQUIRED);
                    $this->response($response, 200);
                    return false;
                }

                if (!ctype_digit($buyer['mobile'])) {
                    $response = Connections_helper::getFailedResponse(Error_messages_helper::$BUYER_MOBILE_NOT_VALID);
                    $this->response($response, 200);
                    return false;
                }

                if (strlen($buyer['mobile']) < $this->config->item('minMobileLength')) {
                    $response = Connections_helper::getFailedResponse(Error_messages_helper::$MOBILE_UNALLOWED_LENGTH);
                    $this->response($response, 200);
                    return false;
                }

                return true;
            }

            return true;
        }

        private function checkBuyerName(array &$buyer, bool $requireName): bool
        {
            if ($requireName) {
                if(empty($buyer['first_name'])) {
                    $response = Connections_helper::getFailedResponse(Error_messages_helper::$BUYER_FIRST_NAME_REQUIRED);
                    $this->response($response, 200);
                    return false;
                }

                if (empty($buyer['second_name'])) {
                    $response = Connections_helper::getFailedResponse(Error_messages_helper::$BUYER_LAST_NAME_REQUIRED);
                    $this->response($response, 200);
                    return false;
                }

                return true;
            }

            return true;
        }

        private function checkApiIdentifier(string $apiIdentifier): bool
        {
            $this->user_model->apiIdentifier = $this->security->xss_clean($apiIdentifier);
            $user = $this->user_model->checkApiIdentifier();
            if (is_null($user)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NOT_EXISTING_BUYER_API_IDENTIFIER);
                $this->response($response, 200);
                return false;
            }

            if ($user['roleid'] !== $this->config->item('buyer')) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$BUYER_UPDATE_NOT_ALLOWED);
                $this->response($response, 200);
                return false;
            }
            $this->user_model->id = intval($user['id']);
            return true;
        }

        private function checkPutBuyerData(?array &$buyerData): bool
        {

            if (!$this->checkBuyerData($buyerData)) return false;

            $buyerData = reset($buyerData);
            if (!$this->checkTrimBuyerData($buyerData)) return false;

            return true;
        }

        private function getInsertBuyerData(array $buyer): array
        {
            $insertBuyer = [
                'email' => $buyer['email'],
                'apiIdentifier' => md5($buyer['email']),
                'roleid' => $this->config->item('buyer'),
                'usershorturl' => $this->config->item('buyershorturl'),
                'salesagent' => $this->config->item('defaultSalesAgentId'),
                'newsletter' => '0',
            ];

            $insertBuyer['mobile'] = isset($buyer['mobile']) ? $buyer['mobile'] : '';
            $insertBuyer['first_name'] = isset($buyer['first_name']) ? $buyer['first_name'] : '';
            $insertBuyer['second_name'] = isset($buyer['second_name']) ? $buyer['second_name'] : '';
            $insertBuyer['username'] = ($buyer['first_name'] && $buyer['second_name']) ? $buyer['first_name'] . ' ' . $buyer['second_name'] : 'no name ' . date('Y-m-d H:i:s');
            $insertBuyer['country'] = isset($buyer['country']) ? $buyer['country'] : '';
            $insertBuyer['city'] = isset($buyer['city']) ? $buyer['city'] : '';
            $insertBuyer['zipcode'] = isset($buyer['zipcode']) ? $buyer['zipcode'] : '';
            $insertBuyer['address'] = isset($buyer['address']) ? $buyer['address'] : '';
            $insertBuyer['addressa'] = isset($buyer['addressa']) ? $buyer['addressa'] : '';

            return $insertBuyer;
        }

        private function setUpdateBuyerData(array $buyerData, array &$updateBuyer): bool
        {

            if (!empty($buyerData['first_name'])) {
                $updateBuyer['first_name'] = $buyerData['first_name'];
            }
            if (!empty($buyerData['second_name'])) {
                $updateBuyer['second_name'] = $buyerData['second_name'];
            }
            if (!empty($buyerData['mobile'])) {
                if (!$this->checkBuyerMobile($buyerData, true)) return false;
                $updateBuyer['mobile'] = $buyerData['mobile'];
            }
            if (!empty($buyerData['country'])) {
                $updateBuyer['country'] = $buyerData['country'];
            }
            if (!empty($buyerData['city'])) {
                $updateBuyer['city'] = $buyerData['city'];
            }
            if (!empty($buyerData['zipcode'])) {
                $updateBuyer['zipcode'] = $buyerData['zipcode'];
            }
            if (!empty($buyerData['address'])) {
                $updateBuyer['address'] = $buyerData['address'];
            }
            if (!empty($buyerData['addressa'])) {
                $updateBuyer['addressa'] = $buyerData['addressa'];
            }
    
            if (!$this->checkBuyerData($updateBuyer)) return false;

            return true;    
        }

    }
