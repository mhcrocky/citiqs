<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/SendyPHP.php';

class Home extends BaseControllerWeb {

	/**
	 * This is default constructor of the class
	 */
	public function __construct() {
		parent::__construct();
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$this->load->helper('url');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->load->library('form_validation');
		$this->load->model('category_model');
		$this->load->model('label_model');
		$this->load->model('user_model');
		$this->load->model('employee_model');
		$this->load->model('log_model');
		$this->load->model('uniquecode_model');
		$this->load->config('custom');
	}

	public function index() {
		$this->global['pageTitle'] = 'TIQS : HOME';
		$this->loadViews("home", $this->global, NULL, NULL);
	}

	public function upload()
	{
		$this->global['pageTitle'] = 'TIQS : UPLOAD FOUND IMAGE';
		$data = [];
		if ($this->uri->segment(2)) {
			$uniquenumber = $this->uri->segment(2);
			$data["employeeId"] = $this->employee_model->getEmployee(['id','expiration_time'], ['uniquenumber=' => $uniquenumber]);
			if (!count($data["employeeId"])){
				redirect(base_url()); // noaccess
			}
			if (intval($data['employeeId'][0]->expiration_time) < time()) {
				redirect(base_url()); // ASK MANAGER FOR NEW TIME FRAME...
			}
			$data["employeeId"] = reset($data["employeeId"])->id;
			$data['token'] = $uniquenumber;
		}

		if (isset($_SESSION['userId'])) {
			$data["userId"] = $_SESSION['userId'];
		} elseif ($this->uri->segment(3)) {
			$data["userId"] = $this->uri->segment(3);
		} else {
			$data["userId"] = '';
		}
		$data["categories"] = $this->category_model->getCategories();
		$data['otherCategoryId'] = $this->config->item('otherCategoryId');
		$this->loadViews("upload", $this->global, $data, NULL);		
	}

	public function insertLabel()
	{
		unset($_POST['submit']);
		$noRegisterUserRequest = false;

		$this->form_validation->set_rules('descript', 'Description', 'trim|required');
		$this->form_validation->set_rules('categoryId', 'Category id', 'trim|required');
		$this->form_validation->set_rules('dclw', 'Label dclw', 'trim|required|greater_than[0]');
		$this->form_validation->set_rules('dclh', 'Label dclh', 'trim|required|greater_than[0]');
		$this->form_validation->set_rules('dcll', 'Label dcll', 'trim|required|greater_than[0]');
		$this->form_validation->set_rules('dclwgt', 'Label dclwgt', 'trim|required|greater_than[0]');

		if (!$this->form_validation->run()) {			
			$this->session->set_flashdata('error', 'Process failed, try again');
			redirect(base_url() . "itemfound");
		}
		// set label data
		$data = $this->input->post(null,TRUE);
		$data['ipaddress'] = $this->input->ip_address();

		if ($data['token']) {
			$token = $data['token'];
			unset($data['token']);
		}
		if (!$data['userId']) {
			$data['userId'] = $this->config->item('tiqsId');
			$noRegisterUserRequest = true;
		} else {
			$data['userfoundId'] = $data['userId'];
		}

		//create unique tiqs data
		$this->uniquecode_model->insertAndSetCode();
		$data['code'] = $this->uniquecode_model->code;
		$data['image'] = time() . '_' . rand(0,99999) . '.' . File_helper::getFileExtension($_FILES['file']['name']);
		$_FILES['file']['name'] = $data['userId'] . '-' . $data['code'] . '-' . $data['image'];
		
		if (!File_helper::uploadLabel()) {
			$this->session->set_flashdata('error', 'Image upload failed, try again');
			redirect(base_url() . "itemfound");
		}

		//insert record in tbl_label
		if ($this->label_model->generateCodeAndInsertLabel($data)) {
			$message = !$noRegisterUserRequest ? 'Item data inserted and photo uploaded.' : 'Photo uploaded, register to finish the process.';
			$this->session->set_flashdata('success', $message);
			if (!$noRegisterUserRequest) {
				$redirect = base_url() . 'bagit/' . $data['code'] . '/' . $token . '/' . $data['userId'];
			} else {
				$redirect = base_url() . 'found/' . $data['code'];
			}
			redirect($redirect);
		} else {
			$this->session->set_flashdata('error', 'Process failed, try again');
			redirect(base_url() . "itemfound");
		}
		
	}

	public function uploadcheckemail($email){
		$this->session->set_userdata('emailupload', $email);
		$this->uploadcheck();
	}

	public function uploadcheck()
	{
		$email = $this->session->userdata('emailupload');
		$email = urldecode($email);

		// we need to know the owner id first!!!
		// so we need to have you registered first?
		// we save the input and than we redirect with the right unique number
		/*
		 * We need to save in a session the parameters set.
		 * or in a cookie....
		 * for safety reasoin better to do in a session.
		 * We have to have a user id........
		 * otherwise we cannot store the label......
		 * can we?
		 * the picture needs to be stored .... some where
		 */

//		$email is send from the login...
//		check here if the email is known
//		if the email is not known
//		we need to make a new account for now
//		We can create an account only based on the e-mail.
//		Check or create user....while making picture....
//
		$this->global['pageTitle'] = 'TIQS : UPLOAD NEW ITEM';

		if ($this->user_model->isDuplicate($email)) {
			$userInfo = $this->user_model->getUserInfoByMail($email);
			$userId = $userInfo->userId;
		}

		else { // wanneer de user nog niet bestaat.
			$name='Unknown';
			$set = '3456789abcdefghjkmnpqrstvwxyABCDEFGHJKLMNPQRSTVWXY';
			$password = substr(str_shuffle($set), 0, 12);
			$roleId=3; // role user 2= vendor 1=administrator 3=employee
			$userId=0;  // created by = 9 = register online by the system.
			$selector=9;
			$userInfo = array('email'=>$email,
				'password'=>getHashedPassword($password),
				'roleId'=>$roleId,
				'username' => 'Unknown',
				'createdBy'=>$userId,
				'createdDtm'=>date('Y-m-d H:i:s' ),
				'istype'=>$selector
			);

			$result = $this->user_model->registernew($userInfo);

			if($result > 0) {
//				$lostInfo = array('userId'=>$result,
//					'code'=>$code,
//					'descript'=>'TIQS image',
//					'ipaddress'=>$this->input->ip_address(),
//					'createdDtm'=>date('Y-m-d H:i:s' ),
//					'lost'=>0,
//					'categoryid'=>0);
				$config = [
					'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
					'api_key'   => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
					'list_id'   => 'M1vvllc9SH763o71IlYvPl8A',
				];
				$sendy = new \SendyPHP\SendyPHP($config);
				$responseArray = $sendy->subscribe(
					array(
						'name' => ($name == 'Unknown') ? 'Customer' : $name,
						'email' => $email
					)
				);
				$this->actemail(($name == 'Unknown') ? 'Customer' : $name, $email, $password);
			}
			else {
				$this->session->set_flashdata('error', 'User creation failed');
				$code = $this->session->userdata('code');
				unset($_SESSION['code']);
				redirect("/check/" . $code);
			}
		}

		$data["categories"] = $this->category_model->getCategories();
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('category', 'Category', 'trim|required');
			if ($this->form_validation->run() == false) {
				$this->loadViews("uploadcheck", $this->global, $data, NULL);
			} else {
				$filename = $_FILES['file']['name'];
				$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
				$valid_formats = array("jpg", "jpeg", "png");
				if (empty($filename)) {
					//No file uploaded.
					$this->session->set_flashdata('error', 'No picture uploaded');
					$this->loadViews("uploadcheck", $this->global, $data, NULL);
				} else if (!in_array($ext, $valid_formats)) {
					$this->session->set_flashdata('error', 'Invalid photo format');
					$this->loadViews("uploadcheck", $this->global, $data, NULL);
				} else {
					$this->db->select('mode');
					$this->db->from('tbl_maintenance');
					$query = $this->db->get();
					if (!empty($query->row())) {
						$this->session->set_flashdata('error', 'We are currently doing some maintenance. Please, try again in 15 minutes');
						$this->loadViews("uploadcheck", $this->global, $data, NULL);
					} else {
						$uploaddir = FCPATH . 'uploads/LabelImages/';
						$description = $this->security->xss_clean($this->input->post('description'));
						$category = $this->security->xss_clean($this->input->post('category'));
						$categoryid = $this->category_model->getCategoryId($category);
						$code = $this->label_model->generateCode();
						$labelInfo = array(
    						'userId' => $userId,
							'code'=> $code,							
							'descript' => $description,
							'categoryid' => $categoryid->id,
							'ipaddress' => $this->input->ip_address(),
							'createdDtm' => date('Y-m-d H:i:s'),
							'lost' => 0);
						
						$path = $uploaddir . $userId . "-" . $code . '-';
						if (move_uploaded_file($_FILES['file']['tmp_name'], $path . $_FILES['file']['name'])) {
							$fname = strval(time());
							$new_name = $path . $fname . '.' . $ext;
							$this->watermark_text($path . $_FILES['file']['name'], $new_name, $ext, $code);
							redirect(base_url() . "check/" . $code);
						} else {
							$this->session->set_flashdata('error', 'Photo not uploaded, try again');
							$this->loadViews("uploadcheck", $this->global, $data, NULL);
						}
					}
				}
			}
	}

	private function actemail($name, $email, $password)
	{
		//generate simple random code
		$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 5);
		$result = $this->user_model->checkUserExists($email);
		if (!empty($result)) {
			//getUserInfoByMail
			$userId = $result->userid;
			$data['code'] = $code;
			$data['active'] = false;
			$this->user_model->editUser($data, $userId);
			// $this->session->set_flashdata('success', 'New user created successfully');

			$config = [
				'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
				'api_key' => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
				'list_id' => 'ECFC3PrhFpKLqmt7ClrvXQ',
			];
			$sendy = new \SendyPHP\SendyPHP($config);
			$responseArray = $sendy->subscribe(
				array(
					'name' => $name,
					'email' => $email,
					'Code' => $code,
					'Password' => $password,
					'Pay_link' => base_url() . "pay/1/" . urlencode($email),
					'Link_activation' => base_url() . "login/activate/" . $userId . "/" . $code
				)
			);

			// sending email with Sendy
			if ($responseArray['status'] == 'true' && $responseArray['message'] == 'Subscribed') {
				$this->session->set_flashdata('success', 'New user created successfully and activation code sent to your email');
			} else {
				$this->session->set_flashdata('error', 'New user created successfully but activation code could not be sent to your email. Contact staff and report this errormessage: ' . $responseArray['message']);
				$this->log_model->log('E', __FILE__, __LINE__, $responseArray['message'], $email, '');
			}

		} else {
			$this->session->set_flashdata('error', 'User creation failed, try it again');
			$code = $this->session->userdata('code');
			unset($_SESSION['code']);
			redirect("/check/" . $code);
		}
	}

	private function watermark_text($oldimage_name, $new_image_name, $ext, $code) {
		$font_path = FCPATH . 'assets/fonts/OpenSans-Bold.ttf';

		$font_size = 30; // in pixels
		$water_mark_text_2 = $code; // Watermark Text
		//global $font_path, $font_size, $water_mark_text_2;
		list($owidth, $oheight) = getimagesize($oldimage_name);
		$width = $owidth;
		$height = $oheight;
		$image = imagecreatetruecolor($width, $height);
		if ($ext == 'png') {
			$image_src = imagecreatefrompng($oldimage_name);
			imagejpeg($image_src, $oldimage_name, 100);
		}
		$image_src = imagecreatefromjpeg($oldimage_name);
		imagecopyresampled($image, $image_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
		$blue = imagecolorallocate($image, 79, 166, 185);
		imagettftext($image, $font_size, 0, 0, $height - 30, $blue, $font_path, $water_mark_text_2);
		// imagettftext($image, $font_size, 0, 68, 190, $blue, $font_path, $water_mark_text_2);
		// imagettftext is an in-built function.you can change variables for relocating position of watermark
		if ($ext == 'png')
			$new_image_name = str_replace("png", "jpg", $new_image_name);

		imagejpeg($image, $new_image_name, 100);
		imagedestroy($image);
		unlink($oldimage_name);
		return true;
	}

	public function info(){
		phpinfo();
	}

}
