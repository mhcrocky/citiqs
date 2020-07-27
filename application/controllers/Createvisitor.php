<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/SendyPHP.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/vendor/autoload.php';

class  Createvisitor extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
		$this->load->model('createvisitor_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index()
    {
		$data = array();
		$this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->loadViews("createvisitor", $this->global, $data, 'nofooter', 'noheader');
    }

    public function registration() {

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
		$eventdate = strtolower($this->security->xss_clean($this->input->post('eventdate')));
		$name = $this->security->xss_clean($this->input->post('name'));
		$email = strtolower($this->security->xss_clean($this->input->post('email')));
		$mobile = strtolower($this->security->xss_clean($this->input->post('mobile')));

		// create a new record in the sales.
		$datanewbooking['eventdate'] = $eventdate;
		$datanewbooking['name'] = $name;
		$datanewbooking['email'] = $email;
		$datanewbooking['mobilephone'] = $mobile;

		$result= $this->createvisitor_model->newvisitor($datanewbooking);
		//		var_dump($result);

			$mailtemplate = file_get_contents(APPPATH . 'controllers/' . 'registration.eml');
			 $mailtemplate = str_replace('[eventdate]',date('d.m.yy',strtotime($eventdate)), $mailtemplate);
			 $mailtemplate = str_replace('[name]',$name                      , $mailtemplate);
			 $mailtemplate = str_replace('[email]',$email                    , $mailtemplate);
			 $mailtemplate = str_replace('[mobile]',$mobile                  , $mailtemplate);
			$subject = 'Tiqs registration';
			 $email="pnroos@icloud.com";
			return self::sendEmail($email, $subject, $mailtemplate);
			redirect('sendokregistration');
	}

	public static function sendEmail($email,$subject,$message)
	{
		$config = self::getConfig();
		$CI =& get_instance();
		$CI->load->library('email', $config);
		$CI->email->set_header('X-SES-CONFIGURATION-SET', 'ConfigSet');
		$CI->email->set_newline("\r\n");
		$CI->email->from('support@tiqs.com');
		$CI->email->to($email);
		$CI->email->subject($subject);
		$CI->email->message($message);
		$CI->email->send();
		redirect('sendokregistration');
	}

	private function sendyunsubscribe($email) {
		$config = [
			'installation_url' => 'https://tiqs.com/newsletters',
			'api_key' => 'TtlB6UhkbYarYr4PwlR1',
			'list_id' => 'EdH9trleYtp0JHdiS763X892AQ', // Pay success
		];

		$sendy = new \SendyPHP\SendyPHP($config);
		$responseArray = $sendy->delete($email);
		$config['list_id'] = 'JNTHyS90CBizZy1B763g4vIA'; // Pay error
		$sendy = new \SendyPHP\SendyPHP($config);
		$responseArray = $sendy->delete($email);

		$config['list_id'] = 'avmOrgRU2Tm5eeaDUaRUzA'; // Pay pending
		$sendy = new \SendyPHP\SendyPHP($config);
		$responseArray = $sendy->delete($email);
	}

	public static function getConfig()
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



}

