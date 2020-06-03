<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Validation_helper
    {
        public static function validateAppointment(): ?array
        {
            $CI =& get_instance();
            $CI->load->library('form_validation');

            $CI->form_validation->set_rules('date', 'Date', 'required');
            $CI->form_validation->set_rules('timefrom', 'From time', 'required');
            $CI->form_validation->set_rules('timeto', 'To time', 'required');

            if ($CI->form_validation->run()) {
                return $CI->input->post(null, true);
            };
            return null;
        }

        public static function validateInsertUser(array &$user): bool
        {
            $CI =& get_instance();
            $CI->load->helper('validate_data_helper');

            if (
                !isset($user['email']) || !isset($user['emailverify']) || !isset($user['mobile'])
                || !isset($user['username']) || !isset($user['address']) || !isset($user['zipcode']) 
                || !isset($user['city']) || !isset($user['country'])|| !isset($user['IsDropOffPoint']) 
                || !isset($user['roleId'])
            ) return false;

            if ($user['email'] !== $user['emailverify']) return false;
            if (!Validate_data_helper::validateEmail($user['email'])) return false;
            if (!Validate_data_helper::validateString($user['mobile'])) return false;            
            if (!Validate_data_helper::validateString($user['username'])) return false;
            if (!Validate_data_helper::validateString($user['address'])) return false;
            if (!Validate_data_helper::validateString($user['zipcode'])) return false;
            if (!Validate_data_helper::validateString($user['city'])) return false;
            if (!Validate_data_helper::validateString($user['country'])) return false;
            if (!Validate_data_helper::validateInteger($user['roleId'])) return false;            
            if (!($user['IsDropOffPoint'] === '0' || $user['IsDropOffPoint'] === '1')) return false;

            unset($user['emailverify']);

            return true;
        }


        public static function validateInsertLabel(array &$label): bool
        {
            $CI =& get_instance();
            $CI->load->helper('validate_data_helper');

            if (
                !isset($label['userId']) || !isset($label['userfoundId']) || !isset($label['code'])
                || !isset($label['descript']) || !isset($label['categoryid']) || !isset($label['lost'])
                || !isset($label['dclw']) || !isset($label['dcll']) || !isset($label['dclh'])
                || !isset($label['dclwgt']) || !isset($label['ipaddress']) 
            ) return false;

            if (!Validate_data_helper::validateInteger($label['userId'])) return false;
            if (!Validate_data_helper::validateInteger($label['userfoundId'])) return false;
            if (!Validate_data_helper::validateString($label['code'])) return false;
            if (!Validate_data_helper::validateInteger($label['categoryid'])) return false;
            if (!Validate_data_helper::validateString($label['descript'])) return false; 
            if (!Validate_data_helper::validateInteger($label['lost'])) return false;
            if (!Validate_data_helper::validateFloat($label['dclw'])) return false;
            if (!Validate_data_helper::validateFloat($label['dcll'])) return false;
            if (!Validate_data_helper::validateFloat($label['dclh'])) return false;
            if (!Validate_data_helper::validateFloat($label['dclwgt'])) return false;
            if (!Validate_data_helper::validateString($label['ipaddress'])) return false;

            return true;
        }
    }