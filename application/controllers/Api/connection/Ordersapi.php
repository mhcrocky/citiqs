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
            $this->load->helper('validate_data_helper');

            $this->load->config('custom');
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

            if (!$this->validatePostData($post)) return;

            if (!$this->validateBasicOrderData($post, $vendor)) return;

            if (!$this->manageBuyerData($post, $vendor)) return;

            return;
        }

        private function validatePostData(?array $order): bool
        {
            if (empty($order)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_ORDER_DATA);
                $this->response($response, 200);
                return false;
            }

            return true;
        }

        // handle order data

        private function validateBasicOrderData(array $post, array $vendor): bool
        {
            if (!isset($post[0]['order'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$INVALID_ORDER_DATA);
                $this->response($response, 200);
                return false;
            }

            $order = $post[0]['order'];


            if (!$this->checkServiceType($order, $vendor['typeData'])) return false;

            if (!$this->checkIsPaidStatus($order)) return false;

            if (!$this->checkAmount($order)) return false;

            if (!$this->checkWaiterTip($order)) return false;

            if (!$this->checkTime($order)) return false;

            if (!$this->checkOrderRemark($order)) return false;

            return true;
        }

        private function checkServiceType(array $order, array $vendorTypes): bool
        {
            if (!isset($order['serviceType'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$SERVICE_TYPE_NOT_SET);
                $this->response($response, 200);
                return false;
            }

            $serviceType = $order['serviceType'];
            // check is servvice type DELIVERY or PICKUP
            if (!($serviceType === $this->config->item('deliveryTypeString') || $serviceType === $this->config->item('pickupTypeString'))) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$INVALID_SERVICE_TYPE);
                $this->response($response, 200);
                return false;
            }

            // check is order service type approved by vendor
            $orderTypeId = $this->config->item('serviceTypes')[$serviceType];
            foreach ($vendorTypes as $type) {
                if ($type['active'] === '0' && $orderTypeId === intval($type['typeId'])) {
                    $response = Connections_helper::getFailedResponse(Error_messages_helper::$TYPE_NOT_ALLOWED_BY_VENDOR);
                    $this->response($response, 200);
                    return false;
                }
            }

            return true;
        }

        private function checkIsPaidStatus(array $order): bool
        {
            if (!isset($order['isPaid'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ISPAID_STATUS_NOT_SET);
                $this->response($response, 200);
                return false;
            }

            $isPaid = $order['isPaid'];

            if (!($isPaid === $this->config->item('orderPaid') || $isPaid === $this->config->item('orderNotPaid'))) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$INVALID_ISPAID_STATUS);
                $this->response($response, 200);
                return false;
            }

            return true;
        }

        private function checkAmount(array $order): bool
        {
            if (!isset($order['amount'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ORDER_AMOUNT_NOT_SET);
                $this->response($response, 200);
                return false;
            }

            $amount = $order['amount'];
            if (!Validate_data_helper::validateNumber($amount)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ORDER_AMOUNT_INVALID_FORMAT);
                $this->response($response, 200);
                return false;
            }

            $amount = floatval($amount);
            if ($amount <= 0) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ORDER_AMOUNT_NOT_POSITIVE);
                $this->response($response, 200);
                return false;
            }

            return true;
        }

        private function checkWaiterTip(array $order): bool
        {
            if (!isset($order['waiterTip'])) return true;
            $waiterTip = $order['waiterTip'];
            if (!Validate_data_helper::validateNumber($waiterTip)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$WAITERTIP_AMOUNT_INVALID_FORMAT);
                $this->response($response, 200);
                return false;
            }

            $waiterTip = floatval($waiterTip);

            if ($waiterTip <= 0) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$WAITERTIP_AMOUNT_NOT_POSITIVE);
                $this->response($response, 200);
                return false;
            }

            return true;
        }

        private function checkTime(array $order): bool
        {
            if (!isset($order['time'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ORDER_TIME_NOT_SET);
                $this->response($response, 200);
                return false;
            }

            if (!Validate_data_helper::validateDate($order['time'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ORDER_INVALID_TIME);
                $this->response($response, 200);
                return false;
            }

            return true;
        }

        private function checkOrderRemark(array $order): bool
        {
            if (!isset($order['remark'])) return true;
            $remark = $order['remark'];
            if (!is_string($remark)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$INVALID_ORDER_REMARK);
                $this->response($response, 200);
                return false;
            }

            return true;
        }

        // handle buyer data
        private function manageBuyerData(array $post, array $vendor): bool
        {
            if (!isset($post[0]['buyer'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ORDER_BUYER_NOT_SET);
                $this->response($response, 200);
                return false;
            }

            $buyer = $post[0]['buyer'];

            if (empty($buyer['email'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ERR_BUYER_EMAIL_NOT_SET);
                $this->response($response, 200);
                return false;
            }

            $headers = ['x-api-key: ' . $vendor['apiKey']];

            $getRseponse = $this->buyerApiGetResponse($buyer['email'], $headers);

            if ($getRseponse->status === Connections_helper::$FAILED_STATUS) {
                if ($getRseponse->errorCode === Error_messages_helper::$BUYER_NOT_EXISTS) {
                    $postResponse = $this->buyerApiPostResponse($buyer, $headers);
                    if ($postResponse->status === Connections_helper::$FAILED_STATUS) {
                        $response = Connections_helper::getFailedResponse($postResponse->errorCode);
                        $this->response($response, 200);
                        return false;
                    }
                    return true;
                }
                $response = Connections_helper::getFailedResponse($getRseponse->errorCode);
                $this->response($response, 200);
                return false;
            }

            $updateResponse = $this->buyerApiPutResponse($buyer, $headers, $getRseponse->data->buyer->apiIdentifier);
            if ($updateResponse->status === Connections_helper::$FAILED_STATUS) {
                $response = Connections_helper::getFailedResponse($updateResponse->errorCode);
                $this->response($response, 200);
                return false;
            }

            return true;
        }

        private function buyerApiGetResponse(string $email, array $headers): object
        {
            $getUrl = base_url() . 'api/connection/buyer?email=' . trim($email);
            $response = Connections_helper::sendGetRequest($getUrl, $headers);
            if (is_null($response)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_DATA_RETURN);
            }
            return $response;
        }

        private function buyerApiPostResponse(array $buyer, array $headers): object
        {
            $postUrl = base_url() . 'api/connection/buyer';
            $response = Connections_helper::sendPostRequest($postUrl, $buyer, $headers);
            if (is_null($response)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_DATA_RETURN);
            }
            return $response;
        }

        private function buyerApiPutResponse(array $buyer, array $headers, string $userApiIdentifier): object
        {
            $putUrl = base_url() . 'api/connection/buyer/' . $userApiIdentifier;
            $response = Connections_helper::sendPutRequest($putUrl, json_encode([$buyer]), $headers);
            if (is_null($response)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_DATA_RETURN);
            }
            return $response;
        }

    }
