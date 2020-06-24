<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    require_once FCPATH . 'application/libraries/SendyPHP.php';

    class Email_helper
    {

        public static function getSandyConfig(): array
        {
            return [
                'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
                'api_key'   => SANDY_API_KEY, // Your API key. Available in Sendy Settings.
                'list_id'   => SANDY_LIST_ID,  /// deze  ook anders waarom een account aanmaken voor een finder......
            ];
        }
        public static function getConfig(): array
        {
            return [
                'protocol' => PROTOCOL,
                'smtp_host' => SMTP_HOST,
                'smtp_port' => SMTP_PORT,
                'smtp_user' => SMTP_USER, // change it to yours
                'smtp_pass' => SMTP_PASS, // change it to yours
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
                'smtp_crypto' => 'tls',
                'wordwrap' => TRUE,
                'newline' => "\r\n"
            ];
        }
        
        public static function sendUserActivationEmail(object $user): bool
        {
            $config = self::getSandyConfig();
            $sendy = new \SendyPHP\SendyPHP($config);
            $responseArray = $sendy->subscribe([
                'name' => $user->username,
                'email' => $user->email,
                'Code' => $user->code,
                'Password' => $user->password,
                'Link_activation'=> base_url() . 'login/activate/' . $user->id . '/' . $user->code
            ]);
            return $responseArray['status'];
        }

        public static function sendItemFoundEmail($label): bool
        {
            $itemfoundmail = file_get_contents(APPPATH . 'controllers/' . 'itemfound.eml');            
            if ($label['claimerId']) {
                $itemfoundmail = str_replace('[Name]', $label['claimerUsername'], $itemfoundmail);
                $itemfoundmail = str_replace('[Email]', $label['claimerEmail'], $itemfoundmail);
                $email = $label['claimerEmail'];
            } elseif ($label['ownerDropOffPoint'] === '0' && $label['ownerId'] !== $label['finderId']) {                
                $itemfoundmail = str_replace('[Name]', $label['ownerUsername'], $itemfoundmail);
                $itemfoundmail = str_replace('[Email]', $label['ownerEmail'], $itemfoundmail);
                $email = $label['ownerEmail'];
            }
            if (isset($email)) {
                $itemfoundmail = str_replace('[Code]', $label['labelCode'], $itemfoundmail);
                $itemfoundmail = str_replace('[Description]', $label['labelDescription'], $itemfoundmail);
                $subject = 'Your items has been found';
                return self::sendEmail($email, $subject, $itemfoundmail);
            }
            return false;     
        }

        public static function sendEmployeeEmail(object $employee): bool
        {
            $link = base_url() . "itemfound/" . $employee->uniquenumber . "/" . $employee->ownerId;
            $message = '<p>This is your personal <a href="' . $link .'" target="_blank">link</a></p>';
            $subject = 'our personal link for found items registration';
            return self::sendEmail($employee->email, $subject, $message);
        }

        public static function sendTicketEmail(string $email, string $url): bool
        {
            $subject = 'Personal collection ticket document';


            $message  = 'Click on this <a href="'. $url .'" target="_blank">link</a> to get pdf document';
			$message .= '<p>Please be aware that you have made an appointment. Be on time, the LOST AND FOUND
			employee has multiple appointments in the same time period you have selected. Therefore being on
			time guarantees that you can be helped within this time period.</p>';
			$message .= '<p>LOST AND FOUND items can only be collected on this address. This addres can be a different
			address from where you lost the item or where you stayed.</p>';
			$message .= '<p>Follow the instructions of the LOST AND FOUND employee. To ensure the collection of your
			claimed item we The LOST AND FOUND employee needs to be sure that you are the rightfull
			claimer.</p>';
			$message .= '<p>The correct handling of the LOST AND FOUND and checking that the claim is correct, we apologize
			for any inconvenience.</p>';
			$message .= '<p>This is your collection ticket to show to the LOST AND FOUND department employee</p>';

            return self::sendEmail($email, $subject, $message);
        }
        
        public static function sendEmail(string $email, string $subject, string $message): bool
        {
            $config = self::getConfig();
            $CI =& get_instance();
            $CI->load->library('email', $config);
            $CI->email->set_header('X-SES-CONFIGURATION-SET', 'ConfigSet');
            $CI->email->set_newline("\r\n");
            $CI->email->from(EMAIL_FROM);
            $CI->email->to($email);
            $CI->email->subject($subject);
            $CI->email->message($message);
            return $CI->email->send(); 
        }

        public static function dhlSednErr(int $paymnetHistoryId, int $dhlCode): void
        {
            if ($dhlCode !== 0) {
                $config = self::getConfig();                
                $CI =& get_instance();
                $CI->load->config('custom');
                $email = $CI->config->item('tiqsEmail');
                $message = 'DHL error occurred. Check record in tbl_payment_history with id: ' . $paymnetHistoryId;
                self::sendEmail($email, 'Dhl error', $message);
            }
        }

        public static function sendOrderEmail(string $email, string $subject, string $message)
        {
            $configemail = array(
                'protocol' => PROTOCOL,
                'smtp_host' => SMTP_HOST,
                'smtp_port' => SMTP_PORT,
                'smtp_user' => SMTP_USER, // change it to yours
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
