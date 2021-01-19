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

            // models
            $this->load->model('shopproductex_model');
            $this->load->model('user_model');
            $this->load->model('shoporder_model');
            $this->load->model('shoporder_model');
            $this->load->model('shoporderex_model');

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

            if (!$this->manageProductData($post, $vendor)) return;

            if (!$this->insertOrder($post, $vendor)) return;

            $response = [
                'status' => Connections_helper::$SUCCESS_STATUS,
                'message' => 'Order inserted',
            ];

            $apiIdentifier = md5(strval($this->shoporder_model->id) . Utility_helper::shuffleBigStringRandom(32));
            if ($this->shoporder_model->setProperty('apiIdentifier', $apiIdentifier)->update()) {
                $response['data'] = [
                    'apiIdentifier' => $apiIdentifier
                ];
            }

            $this->response($response, 200);
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
                $response = (object) $response;
            }
            return $response;
        }

        private function buyerApiPostResponse(array $buyer, array $headers): object
        {
            $postUrl = base_url() . 'api/connection/buyer';
            $response = Connections_helper::sendPostRequest($postUrl, $buyer, $headers);
            if (is_null($response)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_DATA_RETURN);
                $response = (object) $response;
            }
            return $response;
        }

        private function buyerApiPutResponse(array $buyer, array $headers, string $userApiIdentifier): object
        {
            $putUrl = base_url() . 'api/connection/buyer/' . $userApiIdentifier;
            $response = Connections_helper::sendPutRequest($putUrl, json_encode([$buyer]), $headers);
            if (is_null($response)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_DATA_RETURN);
                $response = (object) $response;
            }
            return $response;
        }

        // handle products

        private function manageProductData(array &$post, array $vendor): bool
        {
            if (!isset($post[0]['products'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$PRODUCTS_NOT_SET);
                $this->response($response, 200);
                return false;
            }

            $serviceType = $post[0]['order']['serviceType'];
            $serviceTypeId = $this->config->item('serviceTypes')[$serviceType];

            foreach ($post[0]['products'] as $key => $product) {
                if (!$this->validateProduct($product)) return false;
                if (!$this->setProductExId($post[0]['products'][$key], $vendor['apiFeatures'], $serviceTypeId)) return false;
                if (isset($product[$this->config->item('side_dishes')])) {
                    foreach ($post[0]['products'][$key][$this->config->item('side_dishes')] as $kkey => $dish) {
                        if (!$this->validateProduct($dish)) return false;
                        if (!$this->setProductExId($post[0]['products'][$key][$this->config->item('side_dishes')][$kkey], $vendor['apiFeatures'], $serviceTypeId)) return false;
                    }
                }
            }

            return true;
        }

        private function validateProduct(array $product): bool
        {
            if (empty($product['name'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$PRODUCT_NAME_NOT_SET);
                $this->response($response, 200);
                return false;
            }

            if (!Validate_data_helper::validateString($product['name']) || !is_string($product['name'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$PRODUCT_NAME_INVALID_FORMAT);
                $this->response($response, 200);
                return false;
            }

            if (empty($product['price'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$PRODUCT_PRICE_NOT_SET);
                $this->response($response, 200);
                return false;
            }

            if (!Validate_data_helper::validateNumber($product['price'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$PRODUCT_PRICE_INVALID_FORMAT);
                $this->response($response, 200);
                return false;
            }

            if (floatval($product['price']) <= 0) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$PRODUCT_PRICE_VALUE);
                $this->response($response, 200);
                return false;
            }

            if (empty($product['quantity'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$PRODUCT_QUANTITY_NOT_SET);
                $this->response($response, 200);
                return false;
            }

            if (isset($product['remark']) && !is_string($product['remark'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$PRODUCT_REMARK_INVALID);
                $this->response($response, 200);
                return false;
            }

            if (!Validate_data_helper::validateInteger($product['quantity'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$PRODUCT_QUANTITY_INVALID_FORMAT);
                $this->response($response, 200);
                return false;
            }

            if (intval($product['quantity']) <= 0) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$PRODUCT_QUANTITY_VALUE);
                $this->response($response, 200);
                return false;
            }

            return true;
        }

        private function setProductExId(array &$product, array $apiFeatures, int $serviceTypeId): bool
        {
            $product['productExId'] = $this->shopproductex_model->manageApiProduct($product, $apiFeatures, $serviceTypeId);
            if (is_null($product['productExId'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ORDER_INSERT_FAILED_ON_PRODUCT_INSERT);
                $this->response($response, 200);
                return false;
            }
            return true;
        }

        private function insertOrder(array $post, array $vendor): bool
        {
            $order = $post[0]['order'];
            $buyer  = $post[0]['buyer'];
            $products = $post[0]['products'];
            

            if (!$this->setServiceFee($order, $vendor)) return false;
            if (!$this->setBuyerId($order, $buyer)) return false;

            // insert order in tbl_shop_orders
            $insertOrder = $this->getInsertOrderArray($order, $vendor);

            $this->shoporder_model->setObjectFromArray($insertOrder)->create();
            if (!$this->shoporder_model->id) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ORDER_FAILED_ON_INSERT_IN_DB);
                $this->response($response, 200);
                return false;
            }

            // insert order ex
            foreach ($products as $product) {
                if (!$this->insertOrderExtended($this->shoporder_model, $product)) return false;
                if (isset($product[$this->config->item('side_dishes')])) {
                    $sideDishes = $product[$this->config->item('side_dishes')];
                    $countSideDishes = 1;
                    foreach ($sideDishes as $dish) {
                        if (!$this->insertOrderExtended($this->shoporder_model, $dish, 0, $countSideDishes)) return false;
                        $countSideDishes++;
                    }
                }
            }

            return true;
        }

        private function setServiceFee(array &$order, array $vendor): bool
        {
            if ($order['serviceType'] === $this->config->item('deliveryTypeString')) {
                if (!$vendor['deliveryServiceFeePercent'] || !$vendor['deliveryServiceFeeAmount']) {
                    $response = Connections_helper::getFailedResponse(Error_messages_helper::$VENDOR_DELIVERY_SERVICE_FEE_NOT_SET);
                    $this->response($response, 200);
                    return false;
                }
                $serviceFee = $vendor['deliveryServiceFeePercent'];
                $serviceFeeAmount = $vendor['deliveryServiceFeeAmount'];
            }

            if ($order['serviceType'] === $this->config->item('pickupTypeString')) {
                if (!$vendor['pickupServiceFeePercent'] || !$vendor['pickupServiceFeeAmount']) {
                    $response = Connections_helper::getFailedResponse(Error_messages_helper::$VENDOR_PICKUP_SERVICE_FEE_NOT_SET);
                    $this->response($response, 200);
                    return false;
                }
                $serviceFee = $vendor['pickupServiceFeePercent'];
                $serviceFeeAmount = $vendor['pickupServiceFeeAmount'];
            }

            $order['serviceFee'] = round((floatval($order['amount']) * $serviceFee / 100),2);
            if ($order['serviceFee'] > $serviceFeeAmount) $order['serviceFee'] = $serviceFeeAmount;

            return true;
        }

        private function setBuyerId(array &$order, array $buyer): bool
        {
            $this->user_model->setUniqueValue(trim($buyer['email']))->setWhereCondtition()->setUser('id');
            $order['buyerId'] = $this->user_model->id;
            return true;
        }

        private function getInsertOrderArray(array $order, array $vendor): array
        {
            $insertOrder = [
                'buyerId' => $order['buyerId'],
                'amount' => $order['amount'],
                'serviceFee' => $order['serviceFee'],
                'paid' => $order['isPaid'],
                'created' => $order['time'],
                'apiKeyId' => $vendor['apiKeyId'],
                'paymentType' => $vendor['apiName']
            ];

            $insertOrder['waiterTip'] = isset($order['waiterTip']) ? $order['waiterTip'] : 0;
            $insertOrder['serviceTypeId'] = $this->config->item('serviceTypes')[$order['serviceType']];
            $insertOrder['remarks'] = isset($order['remark']) ? $order['remark'] : '';
            
            if ($insertOrder['serviceTypeId'] === $this->config->item('deliveryType')) {
                $insertOrder['spotId'] = $vendor['apiFeatures']['deliverySpotId'];
            }
            if ($insertOrder['serviceTypeId'] === $this->config->item('pickupType')) {
                $insertOrder['spotId'] = $vendor['apiFeatures']['pickUpSpotId'];
            }

            return $insertOrder;
        }

        private function insertOrderExtended(object $shoporderModel, array $product, int $mainIndex = 1, int $subMainIndex = 0): bool
        {
            $orderEx = [
                'orderId' => $shoporderModel->id,
                'productsExtendedId' => $product['productExId'],
                'quantity' => $product['quantity'],
                'mainPrductOrderIndex' => $mainIndex,
                'subMainPrductOrderIndex' => $subMainIndex
            ];

            if (!$this->shoporderex_model->setObjectFromArray($orderEx)->create()) {
                $this->shoporderex_model->orderId = $shoporderModel->id;
                $this->shoporderex_model->deleteOrderDetails();
                $shoporderModel->delete();
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ORDER_FAILED_ON_INSERT_ORDEREX);
                $this->response($response, 200);
                return false;
            }
            return true;
        }

    }
