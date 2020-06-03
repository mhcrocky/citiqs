<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/SendyPHP.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/vendor/autoload.php';


class  Resendreservations extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
		$this->load->model('bookandpay_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index()
    {
		$data = array();
		$this->global['pageTitle'] = 'TIQS : BOOKINGS';
        $this->loadViews("resendreservation", $this->global, $data, 'nofooter', 'noheader');
    }

	public function resend()
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');

		$email = strtolower($this->security->xss_clean($this->input->post('email')));
		$eventdate = strtolower($this->security->xss_clean($this->input->post('eventdate')));
		$id = strtolower($this->security->xss_clean($this->input->post('reservationrecord')));


		$evendate = date('yy-m-d', strtotime($eventdate));

//		var_dump($eventdate);
//		var_dump($email);
//		die();

		$result = $this->bookandpay_model->getReservationByMail($email, $eventdate, $id);

//		var_dump($result);
//
//		print("<pre>".print_r($result,true)."</pre>");

		if(empty($result)){
			///
			redirect('resendreservations');
		}

		$qrtext = $result->reservationId;

		switch (strtolower($_SERVER['HTTP_HOST'])) {
			case 'tiqs.com':
				$file = '/home/tiqs/domains/tiqs.com/public_html/spot/uploads/thuishaven/qrcodes/' ;
				break;
			case '127.0.0.1':
				$file = '/Users/peterroos/www/spot/uploads/thuishaven/qrcodes/';
				break;
			default:
				break;
		}

		$SERVERFILEPATH = $file;
		$text = $qrtext;
		$folder = $SERVERFILEPATH;
		$file_name1 = $qrtext . ".png";
		$file_name = $folder.$file_name1;

		QRcode::png($text,$file_name);
		switch (strtolower($_SERVER['HTTP_HOST'])) {
			case 'tiqs.com':
				$SERVERFILEPATH = 'https://tiqs.com/spot/uploads/thuishaven/qrcodes/';
				break;
			case '127.0.0.1':
				$SERVERFILEPATH = 'http://127.0.0.1/spot/uploads/thuishaven/qrcodes/';
				break;
			default:
				break;
		}

		$qrlink = $SERVERFILEPATH.$file_name1;
		$email = $result->email;
		$name= $result->name;
		$qrcode= $result->reservationId;
		$voucher = $result->voucher;
		$mobile = $result->mobilephone;
		$fromtime = $result->timefrom;
		$totime = $result->timeto;
		$spotlabel = $result->Spotlabel;
		$numberofperons = $result->numberofpersons;
		$eventdate = $result->eventdate;

		$config = [
			'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
			'api_key'   => 'TtlB6UhkbYarYr4PwlR1' // Your API key. Available in Sendy Settings.
		];

		$config['list_id'] ='EdH9trleYtp0JHdiS763X892AQ';

		$this->sendyunsubscribe($email);

		$sendy = new \SendyPHP\SendyPHP($config);
		$responseArray = $sendy->subscribe(
			array(
				'name' => $name,
				'email' => $email,
				'Qrcodeurl' => $qrlink,
				'Voucher' => $voucher,
				'Mobile' => $mobile,
				'Fromtime' => $fromtime,
				'Totime' => $totime,
				'Spotlabel'	=> $spotlabel,
				'Maxpersons' => $numberofperons,
				'Eventdate' => $eventdate
			));

//		redirect('resendreservation/resend');
		$data = array();
		$this->global['pageTitle'] = 'TIQS : THANKS';
		$this->loadViews("resendsuccess", $this->global, $data, 'nofooter', "noheader");

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


}

