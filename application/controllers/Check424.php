<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/SendyPHP.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/vendor/autoload.php';

class Check424 extends BaseControllerWeb {

    public function __construct(){
        parent::__construct();

        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('language', array('controller' => $this->router->class));

        $this->load->helper('cookie');
        $this->load->helper('form');
        $this->load->helper('utility_helper');
        $this->load->helper('email_helper');
        $this->load->helper('validation_helper');
		$this->load->helper('date');

        $this->load->model('user_model');
        $this->load->model('label_model');
		$this->load->model('check424_model');
        $this->load->model('log_model');
        $this->load->model('user_subscription_model');
        $this->load->model('uniquecode_model');
        $this->load->model('category_model');
        $this->load->config('custom');
    }

    /**
     * Index Page for this controller.
     */
    public function index($code = "")
    {

		if ($code == ""){
			$result = null;
		} else {
			$result = $this->check424_model->Check424ById($code);
		}

		$this->global['pageTitle'] = 'TIQS : CHECK424';

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

			if($checkgood<6) {
				$data['code'] = '-2';
				$this->session->set_flashdata('error', 'Code "' . $code . '" indicates question answered with yes ! ');
				$this->loadViews("check424", $this->global, $data, "footerweb424", "headercheck424");
			}else{
				if (!$alertvalid) {
					$data['code'] = '-1';
					$this->session->set_flashdata('error', 'Code "' . $code . '" is not valid anymore!');
					$this->loadViews("check424", $this->global, $data, "footerweb424", "headercheck424");
				} else {
					$this->loadViews("check424", $this->global, $data, "footerweb424", "headercheck424");
				}
			}
		}

        else {

			$data['hoursleft'] = 0;
			$data['minutesleft'] = 0;
			$data['secondsleft'] = 0;
			$data['code'] = 0;
			$data['countdown'] =date('F j, Y, H:i:s', strtotime("+1 day", strtotime(now())));
			$data['datetimenow'] = date('F j, Y, H:i:s', strtotime(now()));
			$data['enddatetime']= date('Y-m-d', strtotime("+1 day", strtotime(now())));
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
