<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/SendyPHP.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/vendor/autoload.php';

class Check424 extends BaseControllerWeb {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->helper('validate_data_helper');
		$this->load->helper('utility_helper');
		$this->load->helper('cookie');

		$this->load->model('shopcategory_model');
		$this->load->model('shopproduct_model');
		$this->load->model('shopproductex_model');
		$this->load->model('shoporder_model');
		$this->load->model('shoporderex_model');
		$this->load->model('user_model');
		$this->load->model('shopspot_model');
		$this->load->model('shopvendor_model');
		$this->load->model('shopvisitor_model');
		$this->load->model('check424_model');
		$this->load->model('shopvisitorreservtaion_model');
		$this->load->model('shophealth_model');

		$this->load->config('custom');

		$this->load->library('language', array('controller' => $this->router->class));
		$this->load->library('session');
    }


	public function index($vendorId = ''): void
	{
		$this->global['pageTitle'] = 'TIQS : REGISTER VISITOR';

		// if (isset($_SESSION['visitorReservationId'])) {
		// 	unset($_SESSION['visitorReservationId']);
		// }

		if (empty($vendorId)) {
			$data = [
				'vendors' => $this->shopvendor_model->getVendors(['payNlServiceId!=' => NULL])
			];
			$this->loadViews('check424/selectVendor', $this->global, $data, null, 'headerWarehousePublic');
		} else {
			$data = [
				'vendor' => $this->shopvendor_model->setProperty('vendorId', $vendorId)->getVendorData(),
			];
			$data['alreadyCheckIn'] = empty($_SESSION['visitorReservationId']) ? false : true;
			$this->loadViews('check424/registerVisitor', $this->global, $data, 'nofooter', 'noheader');
		}
		return;
	}

	public function registerVisitor(): void
	{
		$post = $this->input->post(null, true);
		$visitor = $post['visitor'];
		$redirectReferer = 'check424/' . $visitor['vendorId'];

		// check checkStatus
		if (!isset($post['checkStatus'])) {
			$this->session->set_flashdata('error', 'Process failed. Please select are you entering or leaving location');
			redirect($redirectReferer);
		}

		// insert or update visitor
		$visitor['created'] = date('Y-m-d H:i:s');
		if (!($this->shopvisitor_model->setObjectFromArray($visitor)->create() || $this->shopvisitor_model->setIdFromEmail()->update())) {
			$this->session->set_flashdata('error', 'Process failed. Please try again. All fields are mandatory');
			redirect($redirectReferer);
			exit();
		};

		set_cookie('firstName', $visitor['firstName'], (365 * 24 * 60 * 60));
		set_cookie('lastName', $visitor['lastName'], (365 * 24 * 60 * 60));
		set_cookie('userName', $visitor['firstName'] . ' ' .  $visitor['lastName'], (365 * 24 * 60 * 60));
		set_cookie('email', $visitor['email'], (365 * 24 * 60 * 60));
		set_cookie('mobile', $visitor['mobile'], (365 * 24 * 60 * 60));

		// insert reservation
		$check = [
			'visitorId' => $this->shopvisitor_model->id,
			'checkStatus' => $post['checkStatus'],
			'created' => date('Y-m-d H:i:s')
		];
		if (!$this->shopvisitorreservtaion_model->setObjectFromArray($check)->create()) {
			$this->session->set_flashdata('error', 'Process failed. Please try again');
			redirect($redirectReferer);
			exit();
		}

		// redirect visitor on checkout
		if ($post['checkStatus'] === '0') {
			$this->session->set_flashdata('success', 'Goodbye! Thanks for visiting us');
			set_cookie('visitorReservationId', null, -1);
			if (isset($_SESSION['visitorReservationId'])) {
				unset($_SESSION['visitorReservationId']);
			}
			redirect($redirectReferer);
			return;
		};

		// store visitorReservationId in session
		$_SESSION['visitorReservationId'] = $this->shopvisitorreservtaion_model->id;
		set_cookie('visitorReservationId', $this->shopvisitorreservtaion_model->id, (8 * 60 * 60));
		//  fetch vendor data to see does vendor require that user fill up health questionnaire	
		$vendor = $this->shopvendor_model->setProperty('vendorId', $visitor['vendorId'])->getVendorData();

		// redirect to questionnaire
		if ($vendor['healthCheck'] === '1' && $post['checkStatus'] === '1') {
			$_SESSION['visitor'] = $this->shopvisitor_model;
			$_SESSION['vendor'] = $vendor;
			redirect('questionnaire');
			return;
		}

		// redirect to make order
		$this->session->set_flashdata('success', 'Thank you for your registration');
		$makeOrder = base_url() . 'make_order?vendorid=' . $visitor['vendorId'];
		if (empty($_SESSION['comeFromAlfred'])) {
			redirect('success_reservation');
			return;
		}
		unset($_SESSION['comeFromAlfred']);
		redirect($makeOrder);
		return;
	}

	public function questionnaire(): void
	{
		$this->global['pageTitle'] = 'TIQS : QUESTIONNAIRE';
		$data = [
			'code' => '0'
		];

		$this->loadViews('check424/questionniare', $this->global, $data, 'footerweb424', 'headercheck424');
	}

	public function healthCheckAnswers(): void
	{
		$post = $this->input->post(null, true);

		if (count($post) === 6) {
			$post['pass'] = '1';
		} else {
			$post['pass'] = '0';
		}

		$post['vendorId'] = $_SESSION['vendor']['vendorId'];
		$post['reservationId'] = $_SESSION['visitorReservationId'];
		
		$this->shophealth_model->setObjectFromArray($post)->create();

		if ($post['pass'] === '1') {
			if (empty($_SESSION['comeFromAlfred'])) {
				redirect('success_reservation');
				return;
			}
			unset($_SESSION['comeFromAlfred']);
			// redirect to make order
			$this->session->set_flashdata('success', 'Thank you for your registration');
			$makeOrder = base_url() . 'make_order?vendorid=' . $post['vendorId'];
			redirect($makeOrder);
			return;
		} else {
			unset($_SESSION['visitorReservationId']);
			$this->session->set_flashdata('error', 'Reservation failed. Please take care for yourself');
			$redirectReferer = 'check424/' . $post['vendorId'];
			redirect($redirectReferer);
		}
		return;
	}


	/**
	 * Previous index page for this controller.
	 */
	public function checkhealt($code = '')
	{
		if ($code == ""){
			$result = null;
		} else {
			$result = null; #$this->check424_model->Check424ById($code);
		}

		if ($result) {

			$checkgood = $result->answer1+$result->answer2+$result->answer3+$result->answer4+$result->answer5+$result->answer6+$result->answer7+$result->answer8+$result->answer9;

			// Declare and define two dates
			$lastdatetime = $result->lastdatetime;
			$date1 = strtotime($result->lastdatetime);
			$date2 = now();

			$hourIn = date("'H:i:s", $date1);
			$hourOut = date("'H:i:s", $date2);

			// Formulate the Difference between two dates
			$diff = abs($date2 - $date1);
			$diff2 = abs($date1 - $date2);
			$diffhour = date("'H:i:s", $diff);
			$diffhour2 = date("'H:i:s", $diff2);

			// To get the year divide the resultant date into
			// total seconds in a year (365*60*60*24)
			$years = floor($diff / (365 * 60 * 60 * 24));


			// To get the month, subtract it with years and
			// divide the resultant date into
			// total seconds in a month (30*60*60*24)
			$months = floor(($diff - $years * 365 * 60 * 60 * 24)
				/ (30 * 60 * 60 * 24));


			// To get the day, subtract it with years and
			// months and divide the resultant date into
			// total seconds in a days (60*60*24)
			$days = floor(($diff - $years * 365 * 60 * 60 * 24 -
					$months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

			$daysleft = 1 - $days;


			$alertvalid = true;

			if ($daysleft<=0){
				$alertvalid = false;
			}

			// To get the hour, subtract it with years,
			// months & seconds and divide the resultant
			// date into total seconds in a hours (60*60)
			$hours = floor(($diff - $years * 365 * 60 * 60 * 24
					- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
				/ (60 * 60));
			$hoursleft = 23 - $hours;

			if ($hoursleft<=0){
				$alertvalid = false;
			}

			// To get the minutes, subtract it with years,
			// months, seconds and hours and divide the
			// resultant date into total seconds i.e. 60
			$minutes = floor(($diff - $years * 365 * 60 * 60 * 24
					- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
					- $hours * 60 * 60) / 60);
			$minutesleft = 59 - $minutes;

			// To get the minutes, subtract it with years,
			// months, seconds, hours and minutes
			$seconds = floor(($diff - $years * 365 * 60 * 60 * 24
				- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
				- $hours * 60 * 60 - $minutes * 60));

			$secondsleft = 60 - $seconds;

			$data['hoursleft'] = $hoursleft;
			$data['minutesleft'] = $minutesleft;
			$data['secondsleft'] = $secondsleft;
			$data['code'] = $code;
			$data['datetimenow'] = $this->getDatetimeNow();
			$data['countdown'] =date('F j, Y, H:i:s', strtotime("+1 day", strtotime($lastdatetime)));

			$data['enddatetime']= date('Y-m-d', strtotime("+1 day", strtotime($lastdatetime)));

			if ($checkgood < 6) {
				$data['code'] = '-2';
				$this->session->set_flashdata('error', 'Code "' . $code . '" indicates question answered with yes ! ');
				$this->loadViews("check424", $this->global, $data, "footerweb424", "headercheck424");
			} else {
				if (!$alertvalid) {
					$data['code'] = '-1';
					$this->session->set_flashdata('error', 'Code "' . $code . '" is not valid anymore!');
					$this->loadViews("check424", $this->global, $data, "footerweb424", "headercheck424");
				} else {
					$this->loadViews("check424", $this->global, $data, "footerweb424", "headercheck424");
				}
			}
		} else {
			$data['hoursleft'] = 0;
			$data['minutesleft'] = 0;
			$data['secondsleft'] = 0;
			$data['code'] = 0;
			$data['countdown'] = date('Y-m-d H:i:s');
			$data['datetimenow'] = date('Y-m-d H:i:s');
			$data['enddatetime']= date('Y-m-d H:i:s');
			// new one
			$data['code'] = '0';
			$this->loadViews("check424", $this->global, $data, "footerweb424", "headercheck424" );
		}
	}

	function getDatetimeNow() {
		$tz_object = new DateTimeZone('Europe/Amsterdam');
		$datetime = new DateTime();
		$datetime->setTimezone($tz_object);
		return $datetime->format('F j, Y, H:i:s');
	}

	function JSDatetimeNow($JSDatetime) {
		$tz_object = new DateTimeZone('Europe/Amsterdam');
		$datetime = new DateTime($JSDatetime);
		$datetime->setTimezone($tz_object);
		return $datetime->format('F j, Y, H:i:s');
	}

	public function cqrcode()
	{

		$code = strtolower($this->security->xss_clean($this->input->post('code')));
		$labelinfo = array(
			'answer1' => strtolower($this->security->xss_clean($this->input->post('question1'))),
			'answer2' => strtolower($this->security->xss_clean($this->input->post('question2'))),
			'answer3' => strtolower($this->security->xss_clean($this->input->post('question3'))),
			'answer4' => strtolower($this->security->xss_clean($this->input->post('question4'))),
			'answer5' => strtolower($this->security->xss_clean($this->input->post('question5'))),
			'answer6' => strtolower($this->security->xss_clean($this->input->post('question6'))),
			'answer7' => strtolower($this->security->xss_clean($this->input->post('question7'))),
			'answer8' => strtolower($this->security->xss_clean($this->input->post('question8'))),
			'answer9' => strtolower($this->security->xss_clean($this->input->post('question9')))
		);


		//		$checkgood = $result->answer1+$result->answer2+$result->answer3+$result->answer4+$result->answer5+$result->answer6+$result->answer7+$result->answer8+$result->answer9;
		//		if($checkgood <6){
		//
		//			$data['code'] = '-2';
		//			$this->global['pageTitle'] = 'TIQS : C-QRCode';
		//			$this->loadViews("check424", $this->global, $data, "footerweb424", "headercheck424");
		//
		//		}

		$result = $this->check424_model->Store424($labelinfo);

		if(!isset($result))
		{
			// we are fucked....start again
			redirect("check424/0");
		}

		$checkgood = $result->answer1+$result->answer2+$result->answer3+$result->answer4+$result->answer5+$result->answer6+$result->answer7+$result->answer8+$result->answer9;
		if($checkgood <6){

			$data['code'] = '-2';
			$this->global['pageTitle'] = 'TIQS : C-QRCode';
			$this->loadViews("check424", $this->global, $data, "footerweb424", "headercheck424");
		}


		$qrtext = $result->code;

		switch (strtolower($_SERVER['HTTP_HOST'])) {
			case 'tiqs.com':
				$file = '/home/tiqs/domains/tiqs.com/public_html/spot/uploads/covid/qrcodes/' ;
				break;
			case '127.0.0.1':
				$file = '/Users/peterroos/www/spot/uploads/covid/qrcodes/';
				break;
			default:
				break;
		}

		$SERVERFILEPATH = $file;
		$text = "https://tiqs.com/spot/check424/".$qrtext;
		$folder = $SERVERFILEPATH;
		$file_name1 = $qrtext . ".png";
		$file_name = $folder.$file_name1;

		QRcode::png($text,$file_name);
		switch (strtolower($_SERVER['HTTP_HOST'])) {
			case 'tiqs.com':
				$SERVERFILEPATH = 'https://tiqs.com/spot/uploads/covid/qrcodes/';
				break;
			case '127.0.0.1':
				$SERVERFILEPATH = 'http://127.0.0.1/spot/uploads/covid/qrcodes/';
				break;
			default:
				break;
		}

		$qrlink = $SERVERFILEPATH.$file_name1;

		$data['SERVERFILEPATH'] = $SERVERFILEPATH ;
		$data['file_name1'] = $file_name1 ;
		$data['code'] = $qrtext ;
		$data['qrlink'] = $qrlink ;
		$data['enddatetime'] = $result->lastdatetime;
		$strendtime =strtotime( $result->lastdatetime);
		$data['countdown'] =date('F j, Y, H:i:s', strtotime("+1 day", strtotime($result->lastdatetime)))  ;
		$data['datetimenow'] = $this->getDatetimeNow();
		$data['enddatetime']= date('Y-m-d', strtotime("+1 day", strtotime(now())));

		$this->global['pageTitle'] = 'TIQS : C-QRCode';
		$this->loadViews("check424qrcode", $this->global, $data, "footerweb424", "headercheck424");

	}

	public function check424email()
	{

		$email = strtolower($this->security->xss_clean($this->input->post('email')));
		$code = strtolower($this->security->xss_clean($this->input->post('code')));
		$qrcodeurl = $this->input->post('qrlink');

		$config = [
			'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
			'api_key'   => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
			'list_id'   => 'Y763tURtX7OejH3MXT7634LepQ',
		];

		$this->sendyunsubscribe($email);

		$sendy = new \SendyPHP\SendyPHP($config);
		$responseArray = $sendy->subscribe(
			array(
				'name' => 'COVID-19 Questionnaire',
				'email' => $email,
				'Qrcodeurl' => $qrcodeurl
			));

		$this->index( "$code");
	}

	private function sendyunsubscribe($email) {
		$config = [
			'installation_url' => 'https://tiqs.com/newsletters',
			'api_key' => 'TtlB6UhkbYarYr4PwlR1',
			'list_id' => 'Y763tURtX7OejH3MXT7634LepQ', // Pay success
		];

		$sendy = new \SendyPHP\SendyPHP($config);
		$responseArray = $sendy->delete($email);

	}

}

?>

