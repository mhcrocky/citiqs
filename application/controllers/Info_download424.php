<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class info_download424 extends BaseControllerWeb
{
	/**
	 * This is default constructor of the class
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('curl_helper');
		$this->load->library('form_validation');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->load->config('custom');
	}

	public function index()
	{
		$this->global['pageTitle'] = 'TIQS : CONTACT';
		$data = [
			'status' => $this->config->item('apiLeadStatus'),
			'source' => $this->config->item('apiLeadSource'),
		];
		// $this->loadViews("contactform", $this->global, $data, NULL);
		$this->loadViews("info_download424", $this->global, $data, NULL);
	}

	public function actiondownloadpdf()
	{
//		$this->form_validation->set_rules('source','Source','trim|required|numeric');
//		$this->form_validation->set_rules('status','Status','trim|required|numeric');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
		$this->form_validation->set_rules('name','Name','trim|required');
//		$this->form_validation->set_rules('user_message','Description','trim|required|max_length[128]');

		if ($this->form_validation->run()) {
			// here the consumer is placed in the leads database.
			// we also need to place this in sendy.
			//
			$url = PERFEX_API . '/leads/data';
			$headers = ['authtoken:' . PERFEX_API_KEY];
			$post = $this->input->post(null, true);
			$post['source']= 1;
			$post['status']= 2;

			$response = Curl_helper::sendCurlPostRequest($url, $post, $headers);
			// first test without interface of CRM
			header("Content-Type: application/octet-stream");

			// Depending on the selected language in the form
			// make here the folder...

			switch (strtolower($_SERVER['HTTP_HOST'])) {
				case 'tiqs.com':
					$file = '/home/tiqs/domains/tiqs.com/public_html/spot/assets/home/documents/' ;
					break;
				case '127.0.0.1':
					$file = '/Users/peterroos/www/spot/assets/home/documents/';
					break;
				default:
					break;
			}

			$lang = strtoupper($this->session->userdata('site_lang_selected'));
			$filename = "tiqs-business-".$lang.".pdf";

			if (!file_exists($file . $filename )){
				$filename = "tiqs-business-EN.pdf";
			}

			$filename = "covid-8-a4.pdf";
			// maak hier een lus van voor het downloaden van alle files....

			$file1 =$file . $filename ;

			header('Content-Type: application/pdf');
			header("Content-Description: File Transfer");
			header("Content-Length: " . filesize($file));
			header('Content-Disposition: attachment; filename="' . $filename . '"');

			flush(); // This doesn't really matter.

			$fp1 = fopen($file1, "r");
			while (!feof($fp1)) {
				echo fread($fp1, 65536);
				flush(); // This is essential for large downloads
			}
			fclose($fp1);

//			$filename = "covid-2-a4.pdf";
//			// maak hier een lus van voor het downloaden van alle files....
//
//			$file2 =$file . $filename ;
//
//			header('Content-Type: application/pdf');
//			header("Content-Description: File Transfer");
//			header("Content-Length: " . filesize($file));
//			header('Content-Disposition: attachment; filename="' . $filename . '"');
//
//			flush(); // This doesn't really matter.
//
//			$fp2 = fopen($file2, "r");
//			while (!feof($fp2)) {
//				echo fread($fp2, 65536);
//				flush(); // This is essential for large downloads
//			}
//			fclose($fp2);


			if ($response->status && $response->message === 'Lead add successful.') {
				$this->session->set_flashdata('success', 'Thank you for your message. We shall response on it as soon as possible.');
			} else {
				$this->session->set_flashdata('success', 'Welcome back!');
			}
		} else {
			$this->session->set_flashdata('error', 'Message didn\'t sent. Please check your data.');
		}
		redirect("info_business424");
	}
}


