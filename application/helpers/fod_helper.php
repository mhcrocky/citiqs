<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    Class Fod_helper
    {

        public static function isFodActive(int $venodrId, int $spotId): bool
        {
            // if ($venodrId != 43533) return true;
            $CI =& get_instance();
            $CI->load->model('shopvendorfod_model');

            if ($CI->shopvendorfod_model->isFodVendor($venodrId)) {
                $CI->load->model('shopspot_model');
                $CI->load->model('fodfdm_model');

                $printerId = $CI->shopspot_model->setObjectId($spotId)->getSpotPrinterId();
                $CI->fodfdm_model->printer_id = $printerId;

                $isPrinterActive = $CI->fodfdm_model->isActive();
                // if printer is null it is not fod printer return true
                return is_null($isPrinterActive) ? true : $isPrinterActive;
            }
            // NOT FOD user return true
            return true;
        }
        
    }
