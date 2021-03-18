<?php
    declare(strict_types=1);

    require_once APPPATH . 'controllers/Api/connection/Authentication.php';

    defined('BASEPATH') OR exit('No direct script access allowed');

    class ShopProductsApi extends Authentication
    {

        public function __construct()
        {
            parent::__construct();

            // models
            $this->load->model('shopspot_model');

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
         * product_get
         *
         * Get products data
         *
         * @see Authentication::vendorAuthentication()
         * @return void
         */
        public function product_get(): void
        {
            $vendor  = $this->vendorAuthentication();

            if (is_null($vendor)) return;            

            $spotId =  intval($this->input->get('spot', true));
            $selectedType =  strval($this->input->get('type', true));

            if (!$this->checkSpotId($spotId, $vendor['vendorId'])) return;
            if (!$this->checkType($selectedType, $vendor['vendorId'], $vendor['typeData'])) return;



            

            

            // $this->response($response, 200);
            return;
        }

        private function checkSpotId(int $spotId, int $vendorId): bool
        {
            if (empty($spotId)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_SPOT_ID);
                $this->response($response, 200);
                return false;
            }

            if (!Validate_data_helper::validatePositiveInteger($spotId)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$SPOT_ID_MUST_BE_POSITIVE_NUMBER);
                $this->response($response, 200);
                return false;
            }

            if (!$this->shopspot_model->setObjectId($spotId)->checkIsVendorSpot($vendorId)) {
                $response = Connections_helper::getFailedResponse(Error_messages_helper::$NOT_VENDOR_SPOT);
                $this->response($response, 200);
                return false;
            }

            return true;
        }

        // private function checkType(string $selectedType, int $vendorId, array $vendorTypes): bool
        // {
        //     if (empty($selectedType)) {
        //         $response = Connections_helper::getFailedResponse(Error_messages_helper::$NO_TYPE);
        //         $this->response($response, 200);
        //         return false;
        //     }

        //     $appServiceTypes = $this->config->item('serviceTypes');

        //     if (!in_array(strtoupper($selectedType), array_keys($appServiceTypes))) {
        //         $response = Connections_helper::getFailedResponse(Error_messages_helper::$INVALID_TYPE);
        //         $this->response($response, 200);
        //         return false;
        //     }

        //     // check is order service type approved by vendor
        //     $orderTypeId = $appServiceTypes[strtoupper($selectedType)];            
        //     foreach ($vendorTypes as $type) {
        //         if ($type['active'] === '0' && $orderTypeId === intval($type['typeId'])) {
        //             $response = Connections_helper::getFailedResponse(Error_messages_helper::$TYPE_NOT_ALLOWED_BY_VENDOR);
        //             $this->response($response, 200);
        //             return false;
        //         }
        //     }

        //     return true;
        // }
    }
