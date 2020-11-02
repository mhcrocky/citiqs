<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Calculator extends BaseControllerWeb {

    
    public function __construct(){
        parent::__construct();
    }

    public function index() {
        $this->global['pageTitle'] = 'TIQS CALCULATOR';
        $this->loadViews("marketing/calculator", $this->global, '', 'footerpublicbizdir', 'noheaderbizdir');
    }

    public function saveCalc() {
        $data = array (
            'amount' => $this->input->post('amount'),
            'times_per_day' => $this->input->post('times_per_day'),
            'commission' => $this->input->post('commission'),
            'email' => $this->input->post('email'),
            'hardware_cost' => $this->input->post('hardware_cost'),
            'monthly_cost' => $this->input->post('monthly')
        );

        $this->load->model('Calculator_model');
        $this->Calculator_model->save($data);
        $this->sendEmailTemplate($data);
        
    }

    public function sendEmailTemplate($data = array()){
        $user_id = 1;
        $temp_name = 'calculateemail';
        $this->load->model('email_templates_model');
        $emailTemplate = $this->email_templates_model->get_emails_by_user_and_name($user_id,$temp_name);
        $email = $data['email'];
        $amount = $data['amount'];
        $times_per_day = $data['times_per_day'];
        $commission = $data['commission'];
        if($emailTemplate) {
            $mailtemplate = file_get_contents(APPPATH."../assets/email_templates/$user_id/$emailTemplate->template_file");
            $mailtemplate = str_replace('[amount]', $amount, $mailtemplate);
            $mailtemplate = str_replace('[times_per_day]', $times_per_day, $mailtemplate);
            $mailtemplate = str_replace('[commission]', $commission, $mailtemplate);
            $mailtemplate = str_replace('border: 1px', 'border: 0px', $mailtemplate);
            $mailtemplate = str_replace('border: 2px', 'border: 0px', $mailtemplate);
            $mailtemplate = str_replace('Image', '', $mailtemplate);
			$mailtemplate = str_replace('Text', '', $mailtemplate);
            $subject = 'Your tiqs calculation';
            $this->sendEmail($email, $subject, $mailtemplate);
        }
        
        
    }

    public function sendEmail($email, $subject, $message)
    {
        $configemail = array(
            'protocol' => PROTOCOL,
            'smtp_host' => SMTP_HOST,
            'smtp_port' => SMTP_PORT,
            'smtp_user' => SMTP_USER,
            'smtp_pass' => SMTP_PASS,
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'smtp_crypto' => 'tls',
            'wordwrap' => TRUE,
            'newline' => "\r\n"
        );

        $config = $configemail;
        $CI =& get_instance();
        $CI->load->library('email', $config);
        $CI->email->set_header('X-SES-CONFIGURATION-SET', 'ConfigSet');
        $CI->email->set_newline("\r\n");
        $CI->email->from('support@tiqs.com');
        $CI->email->to($email);
        $CI->email->subject($subject);
        $CI->email->message($message);
        return $CI->email->send();
    }

}
