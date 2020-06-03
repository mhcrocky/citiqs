<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    require_once FCPATH . 'vendor/ariadnext/php-IDCHECKIO/autoload.php';

    Class Identity_helper
    {
        public static function checkIdentity(string $filepath): bool
        {
            idcheckio\Configuration::getDefaultConfiguration()->setUsername('appao@ariadnext.com'); // Sandbox
            idcheckio\Configuration::getDefaultConfiguration()->setPassword('!!uBGt7T4!9k');  // Sandbox
            idcheckio\Configuration::getDefaultConfiguration()->setHost('https://api-test.idcheck.io/rest');
            idcheckio\Configuration::getDefaultConfiguration()->setSSLVerification(false);    
            idcheckio\Configuration::getDefaultConfiguration()->setCurlConnectTimeout(60);
            idcheckio\Configuration::getDefaultConfiguration()->setCurlTimeout(60);

            $api_instance = new \idcheckio\api\AnalysisApi(); //Initializing analysis Api

            $async_mode = true; // bool | true to activate asynchrone mode
            $accept_language = "en"; // string | Accept language header

            $returnstatus = false;

            try {
                $CI =& get_instance();
                $body = new \idcheckio\model\ImageRequest();
                $base64 = base64_encode(file_get_contents($filepath));
                $body->setFrontImage($base64);
                //$body->setBackImage(base64_encode($backImageContent)); //optional if back image of id is using
                try {
                    $result = $api_instance->postImage($body, $async_mode, $accept_language);
                    // file_put_contents("/var/upload/test.txt",$result);
                    if ($result) {
                        if ($result['check_report_summary']['check']) {
                            $returnstatus = true;
                            foreach ($result['check_report_summary']['check'] as $check) {
                                if ($check['result'] != "OK") {
                                    $returnstatus = false;
                                    break;
                                }
                            }
                        }
                    }
                } catch (Exception $e) {
                    $CI->session->set_flashdata('error', 'Cannot check identification with API. Please, contact staff: ', $e->getMessage());
                }
            } catch (IOException $ioe) {
                $CI->session->set_flashdata('error', 'Cannot check identification (encode error). Please, contact staff: ', $ioe->getMessage());
            }

            return $returnstatus;
        }
    }