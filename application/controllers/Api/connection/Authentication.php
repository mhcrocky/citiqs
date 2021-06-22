<?php
    declare(strict_types=1);

    require_once APPPATH . 'libraries/REST_Controller.php';

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Authentication extends REST_Controller
    {

        public function __construct()
        {
            parent::__construct();

            // models
            $this->load->model('api_model');
            $this->load->model('shopvendor_model');
            $this->load->model('shopcategory_model');
            $this->load->model('shopprinters_model');
            $this->load->model('shopspot_model');
            $this->load->model('shopprodutctype_model');

            // helpers
            $this->load->helper('connections_helper');
            $this->load->helper('sanitize_helper');
            $this->load->helper('error_messages_helper');

            // libaries
            $this->load->library('language', array('controller' => $this->router->class));
        }

        public function index(): void
        {
            return;
        }

        /**
         * vendorAuthentication
         *
         * Method authenticates vendor.
         *
         * @access public
         * @return array|null
         */
        public function vendorAuthentication(): ?array
        {
            $header = getallheaders();

            // if 'X-Api-Key' is not set in the request header
            if (empty($header['X-Api-Key'])) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$AUTHENTICATION_KEY_NOT_SET);
                $this->response($response, 401);
                return null;
            }

            $userData = $this->api_model->setProperty('apikey', $header['X-Api-Key'])->getUser();

            // if 'X-Api-Key' doesnt't exists
            if (empty($userData)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$INVALID_AUTHENTICATION_KEY);
                $this->response($response, 403);
                return null;
            }

            // if access status is not equal '1'
            if ($userData['access'] !== '1') {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ACCESS_DENIED);
                $this->response($response, 403);
                return null;
            }

            $vendorId = intval($userData['userid']);
            $vendor = $this->shopvendor_model->setProperty('vendorId', $vendorId)->getVendorData();
            $vendor['apiKey'] = $userData['apikey'];
            $vendor['apiKeyId'] = $userData['id'];
            $vendor['apiName'] = $userData['name'];
            // if something, somewhere goes wrong
            if (!$vendor) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$ERROR_VENDOR_AUTHENTICATION);
                $this->response($response, 403);
                return null;
            }

            $this->getVendorApiFeatures($vendor);

            // Method returns array with vendor's properties if everything is OK
            return $vendor;
        }

        private function getVendorApiFeatures(array &$vendor): void
        {
            $vendorId = $vendor['vendorId'];

            $categoryId = $this->shopcategory_model->setProperty('userId', $vendorId)->getApiCategoryId();
            $printerId = $this->shopprinters_model->setProperty('userId', $vendorId)->getApiPrinterId();

            $this->shopspot_model->setProperty('printerId', $printerId);
            $deliverySpotId = $this->shopspot_model->getApiDeliverySpotId();
            $pickUpSpotId = $this->shopspot_model->getApiPickupSpotId();

            $this->shopprodutctype_model->setProperty('vendorId', $vendorId);
            $mainProductTypeId = $this->shopprodutctype_model->manageMainTypeId();
            $sideDishesProductTypeId = $this->shopprodutctype_model->getApiSideDishesTypeId();

            $vendor['apiFeatures'] = [
                'categoryId' => $categoryId,
                'printerId' => $printerId,
                'deliverySpotId' => $deliverySpotId,
                'pickUpSpotId' => $pickUpSpotId,
                'mainProductTypeId' => $mainProductTypeId,
                'sideDishesProductTypeId' => $sideDishesProductTypeId,
            ];

            return;
        }

    }
