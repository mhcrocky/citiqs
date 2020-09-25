<?php

// use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Voucher extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('utility_helper');
        $this->load->helper('validate_data_helper');
        
        $this->load->model('shopvoucher_model');
        $this->load->model('shopproduct_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }


 
    public function data_get()
    {
        $data = $this->input->get(null, true);
        $numOfCodes = isset($data['codes']) ? intval($data['codes']) : 0;

        // check numer of codes
        if ($numOfCodes <= 0) {
            $response = [
                'status' => "false",
                'message' => 'Number of voucher must be greater than 0',
            ];
            $this->set_response($response, 201);
            return;
        }

        // check amount and percent
        if (
                (isset($data['amount']) && isset($data['percent']))
                || (empty($data['amount']) && empty($data['percent']))
        ) {
            $response = [
                'status' => "false",
                'message' => 'Amount or percent must be set. Only one of them',
            ];
            $this->set_response($response, 201);
            return;
        }

        // check product id, is this product on products list of this vendor
        if (isset($data['productId'])) {
            $productId = intval($data['productId']);
            $vendorId = intval($data['vendorId']);
            if (!$this->shopproduct_model->checkProduct($productId, $vendorId)) {
                $response = [
                    'status' => "false",
                    'message' => 'Invalid product id. Product is not on products list of this vendor',
                ];
                $this->set_response($response, 201);
                return;
            }
        }

        $data['active'] = '1';
        $data['percentUsed'] = '0';

        $fileRelaitvePath = 'assets/csv/' . $data['vendorId'] . '_' . time() . '.csv';
        $fileLocation = base_url() . $fileRelaitvePath;
        $csvFile = FCPATH . $fileRelaitvePath;
        $csvFile = fopen($csvFile, 'w');
        $firstLine = null;       

        while ($numOfCodes > 0) {
            $data['code'] = Utility_helper::shuffleStringSmallCaps(6);

            if (!$this->shopvoucher_model->insertValidate($data)) {
                $response = [
                    'status' => "false",
                    'message' => 'Process failed',
                ];
                $this->set_response($response, 201);
                return;
            };

            if ($this->shopvoucher_model->setObjectFromArray($data)->create()) {
                if (is_null($firstLine)) {
                    $firstLine = array_keys($data);
                    fputcsv($csvFile, $firstLine, ';');
                }

                $dataToScv = array_values($data);
                fputcsv($csvFile, $dataToScv, ';');

                $numOfCodes--;
            }
        }

        fclose($csvFile);
        redirect($fileLocation);
    }


}
