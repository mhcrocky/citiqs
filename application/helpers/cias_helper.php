<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * This function is used to print the content of any data
 */
function pre($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * This function used to get the CI instance
 */
if (!function_exists('get_instance')) {

    function get_instance() {
        $CI = &get_instance();
    }

}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if (!function_exists('getHashedPassword')) {

    function getHashedPassword($plainPassword) {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }

}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if (!function_exists('verifyHashedPassword')) {

    function verifyHashedPassword($plainPassword, $hashedPassword) {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }

}

/**
 * This method used to get current browser agent
 */
if (!function_exists('getBrowserAgent')) {

    function getBrowserAgent() {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser()) {
            $agent = $CI->agent->browser() . ' ' . $CI->agent->version();
        } else if ($CI->agent->is_robot()) {
            $agent = $CI->agent->robot();
        } else if ($CI->agent->is_mobile()) {
            $agent = $CI->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }

}

if (!function_exists('setProtocol')) {

    function setProtocol() {
        $CI = &get_instance();

        $CI->load->library('email');

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://da01.tiqs.com',
            'smtp_port' => 465,
            'smtp_user' => 'noreply@tiqs.com', // change it to yours
            // 'smtp_user' => '<a href="mailto:noreply@tiqs.com" rel="nofollow">noreply@tiqs.com</a>', // change it to yours
            'smtp_pass' => 'N2ld2rt01@!', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

//        $config['protocol'] = PROTOCOL;
//        $config['mailpath'] = MAIL_PATH;
//        $config['smtp_host'] = SMTP_HOST;
//        $config['smtp_port'] = SMTP_PORT;
//        $config['smtp_user'] = SMTP_USER;
//        $config['smtp_pass'] = SMTP_PASS;
//        $config['charset'] = "utf-8";
//        $config['mailtype'] = "html";
//        $config['newline'] = "\r\n";
//
        $CI->email->initialize($config);

        return $CI;
    }

}

if (!function_exists('emailConfig')) {

    function emailConfig() {

        $CI->load->library('email');

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://da01.tiqs.com',
            'smtp_port' => 465,
            'smtp_user' => 'noreply@tiqs.com', // change it to yours
            // 'smtp_user' => '<a href="mailto:noreply@tiqs.com" rel="nofollow">noreply@tiqs.com</a>', // change it to yours
            'smtp_pass' => 'N2ld2rt01@!', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
//
//        $config['protocol'] = 'smtp';
//        $config['smtp_host'] = ;
//        $config['smtp_port'] = SMTP_PORT;
//        $config['mailpath'] = MAIL_PATH;
//        $config['charset'] = 'UTF-8';
//        $config['mailtype'] = "html";
//        $config['newline'] = "\r\n";
//        $config['wordwrap'] = TRUE;
    }

}

if (!function_exists('resetPasswordEmail')) {

    function resetPasswordEmail($detail) {
        $data["data"] = $detail;
        // pre($detail);
        // die;
        $CI = setProtocol();
        $CI->email->from('noreply@tiqs.com', 'tiqs');
        $CI->email->subject("TIQS Account Reset Password");
        $CI->email->message($CI->load->view('email/resetPassword', $data, TRUE));
        $CI->email->to($detail["email"]);
        $status = $CI->email->send();
        return $status;
    }

}

if (!function_exists('setFlashData')) {

    function setFlashData($status, $flashMsg) {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }

}

if (!function_exists('getSelectedDropdownValue')) {
    
    function getSelectedDropdownValue(string $value, string $value_from_database): string
    {
        return ($value === $value_from_database) ? ' selected="selected" ' : '';
    }

}

if (!function_exists('spliter')) {
    
    function spliter($value, $option) {
        $return_value = "";
        $str_arr = preg_split ("/\:/", $value); 
        if ($option === "H") {
            $return_value = $str_arr[0];
        } else if ($option === "M") {
            $return_value = $str_arr[1];
        }
        return $return_value;
    }

}
?>
