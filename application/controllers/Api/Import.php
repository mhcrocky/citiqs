<?php
    declare(strict_types=1);

    ini_set('max_execution_time', '3600');

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';

    class Import extends REST_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model('shopimport_model');
            $this->load->model('shoppaynlcsv_model');
            $this->load->helper('utility_helper');
            $this->load->helper('validate_data_helper');

            $this->load->library('language', array('controller' => $this->router->class));
        }

        public function data_get(): void
        {
            $data = $this->input->get(null, true);

            $import = $this
                        ->shopimport_model
                        ->setProperty('vendorId', $data['vendorid'])
                        ->setShopVendor()
                        ->setDatabaseCredantations($data)
                        ->setConnection()
                        ->setMainProductTypeId()
                        ->setVendorCategoryId()
                        ->setVendorPrinterId()
                        ->setVendorSpotId()
                        ->import();

            echo ($import) ? 'Import succes' : 'Import failed';

            die();
        }

        public function importnew_get(): void
        {
            $data = $this->input->get(null, true);

            $import = $this
                        ->shopimport_model
                        ->setProperty('vendorId', $data['vendorid'])
                        ->setShopVendor()
                        ->setDatabaseCredantations($data)
                        ->setConnection()
                        ->setMainProductTypeId()
                        ->setVendorCategoryId()
                        ->setVendorPrinterId()
                        ->setVendorSpotId()
                        ->importNew();

            echo ($import) ? 'Import succes' : 'Import failed';

            die();
        }

        public function csv_get()
        {
            $folder = FCPATH . 'assets/paynlCsv/';

            $files = scandir($folder);
            $count = 0;
            
            foreach ($files as $file) {
                if (strpos($file, '.csv') !== false)  {
                    $path = $folder . $file;                
                    $contents = file($path);
                    $query = '';
                    foreach($contents as $line) {
                        
                        if (strpos($line, 'STATSID') === false) {
                            $data = str_getcsv($line, ';');
                            if (is_numeric($data[16])) {
                                $count++;
                                $paymentType = $data[11];
                                $transactionId = $data[14];
                                $created = $data[1];
                                $oldId = $data[16];
                                $amount = floatval(str_replace(',', '.', $data[26]));

                                $query .= '(';
                                $query .= '"' . $file . '",';
                                $query .= '"' . $paymentType . '",';
                                $query .= '"' . $transactionId . '",';
                                $query .= '"' . $created . '",';
                                $query .= '"' . $oldId . '",';
                                $query .= $amount;
                                $query .= '),';
                            }                            
                        }
                    }
                    if ($query) {
                        $executeQuery  = 'INSERT INTO tbl_shop_paynl_csv ';
                        $executeQuery .= '(csvFile, paymentType, transactionId, created, oldId, amount) ';
                        $executeQuery .= 'VALUES  ';
                        $executeQuery .= $query;
                        $executeQuery = rtrim($query, ',');
                        $executeQuery .= ';';
                        $this->db->query($executeQuery);
                    }

                    
                }
            }

            $this->shoppaynlcsv_model->updateStorno();
            var_dump($count);
        }

        // public function csvslow_get()
        // {
        //     $folder = FCPATH . '/assets/paynlCsv/';
        //     // $files = scandir($folder);
            
        //     foreach ($files as $file) {
        //         if (strpos($file, '.csv') !== false)  {
        //             $file = $folder . $file;
        //             $document = '01.csv';
        //             $file = $folder . $document;
                    
        //             $contents = file($file);
        //             foreach($contents as $line) {
        //                 if (strpos($line, 'STATSID') === false) {
        //                     $data = str_getcsv($line, ';');
        //                     if (is_numeric($data[16])) {
        //                         $insert = [
        //                             'csvFile' => $document,
        //                             'paymentType' => $data[11],
        //                             'transactionId' => $data[14],
        //                             'created' => $data[1],
        //                             'oldId' => $data[16],
        //                             'amount' => floatval(str_replace(',', '.', $data[26])),
        //                         ];
        //                         $this->shoppaynlcsv_model->setObjectFromArray($insert)->create();
        //                     }
        //                 }
        //             }
        //         }
        //     }

        //     $this->shoppaynlcsv_model->updateStorno();
        // }
    }
