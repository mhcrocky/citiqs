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
        $this->load->library('language', array('controller' => $this->router->class));
    }


 
    public function data_get()
    {
        $data = $this->input->get(null, true);
        $numOfCodes = intval($data['codes']);

        if ($numOfCodes <= 0) return;

        $data['active'] = '1';
        $data['percentUsed'] = '0';

        $fileRelaitvePath = 'assets/csv/' . $data['vendorId'] . '_' . time() . '.csv';
        $fileLocation = base_url() . $fileRelaitvePath;
        $csvFile = FCPATH . $fileRelaitvePath;
        $csvFile = fopen($csvFile, 'w');
        $firstLine = null;       


        while ($numOfCodes > 0) {
            $data['code'] = Utility_helper::shuffleString(5);

            if (!$this->shopvoucher_model->insertValidate($data)) die('Invalid data');

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
