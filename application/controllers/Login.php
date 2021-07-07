<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/SendyPHP.php';
require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/vendor/autoload.php';

class Login extends BaseControllerWeb
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('user_model');
		$this->load->model('businesstype_model');
		$this->load->model('objectspot_model');
		$this->load->model('shopvendor_model');
		$this->load->model('shopvendortime_model');
		$this->load->model('shopcategory_model');
		$this->load->model('shopprinters_model');
		$this->load->model('shopspot_model');
		$this->load->model('shopvendortemplate_model');
		$this->load->model('shopprodutctype_model');
		$this->load->model('shopproduct_model');
		$this->load->model('shopproductex_model');
		$this->load->model('shopproductaddons_model');
		$this->load->model('shopspotproduct_model');
		$this->load->model('shoppaymentmethods_model');

		$this->load->helper('google_helper');
		$this->load->helper('utility_helper');
		$this->load->helper('email_helper');
		$this->load->helper('perfex_helper');
		$this->load->helper('curl_helper');
		$this->load->helper('validate_data_helper');
		$this->load->helper('country_helper');
		$this->load->helper('pay_helper');
		$this->load->helper('jwt_helper');
		$this->load->helper('form');
		$this->load->library('google');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->config('custom');
	}

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$this->load->library('session');
		$this->isLoggedIn();
	}


	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn()
	{
		$isLoggedIn = $this->session->userdata('isLoggedIn');

		if (!isset($isLoggedIn) || !$isLoggedIn) {
			$this->global['pageTitle'] = 'TIQS : LOGIN';
			$this->loadViews("login", $this->global, NULL, NULL, 'headerpublic');
		} else {
			redirect('/loggedin');
		}
	}



	/**
	 * This function used to logged in user
	 */
	public function loginMe()
	{
//		die();
//		$email = trim($this->security->xss_clean($this->session->userdata('email')));
//		var_dump($email);
//		die();
		$code = strtolower($this->security->xss_clean($this->input->post('code')));
//		if(is_numeric(trim($this->security->xss_clean($this->session->userdata('email'))))){
//			var_dump(trim($this->security->xss_clean($this->session->userdata('email'))));
//			die();
//		}

		if (!empty($code)) {
			$email = trim($this->security->xss_clean($this->session->userdata('email')));
			$password = $this->security->xss_clean($this->session->userdata('password'));
//			if(is_numeric($email)){
//				var_dump($email);
//				die();
//			}
			$result = $this->login_model->loginMe($email, $password);

			if (!empty($result)) {
				$this->activate($result->userId, $code);
				unset($_SESSION['email'], $_SESSION['password']);
				$this->session->set_userdata('dropoffpoint', $result->IsDropOffPoint);
				$this->index();
			} else
				// need to go to code
				$this->global['pageTitle'] = 'TIQS : VERIFY CODE';
				$this->loadViews("code", $this->global, NULL, NULL, "headerpublic");

		}

		$this->load->library('form_validation');

//		echo var_dump(is_numeric($email));
//		die();

		// if (!is_numeric($email)) {
		//			$this->form_validation->set_rules('email', 'Email', 'valid_email|max_length[128]|trim');
		// }

		$this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$email = strtolower($this->security->xss_clean($this->input->post('email')));
			$password = $this->security->xss_clean($this->input->post('password'));

			if (is_numeric($email)) {
				$result = $this->login_model->loginMeId($email, $password);
			}else{
				$result = $this->login_model->loginMe($email, $password);
			}


			if (!empty($result)) {
				if (
					// insert object for lostAndFound and other moudles users
					$result->roleId === $this->config->item('owner') 
					&& intval($result->IsDropOffPoint) === $this->config->item('dropOfPointTrue')
				) {
					$this->user_model->setUniqueValue(intval($result->userId))->setWhereCondtition()->setUser();
				}
				$this->session->set_userdata('dropoffpoint', $result->IsDropOffPoint);
				if ($result->active == 0) {
					$this->load->library('form_validation');
					$this->form_validation->set_rules('code', 'code to activate your account, received by e-mail and/or SMS', 'required|max_length[32]');
					if ($this->form_validation->run() == FALSE) {
						$this->session->set_flashdata('warning', "code to activate your account, received by e-mail and/or SMS.");

						if (isset($_SESSION['error'])) {
							unset($_SESSION['error']);
						}

						$sessionArray = array(
							'email' => $email,
							'password' => $password
						);

						$this->session->set_userdata($sessionArray);
						$this->global['pageTitle'] = 'TIQS : VERIFY CODE';
						$this->loadViews("code", $this->global, NULL, NULL, "headerpublic");
						//	$this->load->view('code');
					}
				} else {
					$this->accountSettings($result);
					//redirect('/dashboard');
				}
			} else {
				$this->session->set_flashdata('error', 'Are you using the right credentials, or did you not register yet? Please try again or register. ');
				redirect('login');
				// $this->index();
			}
		}
	}

	public function loginEmployee()
	{
		

		$this->form_validation->set_rules('email', 'Email', 'valid_email|max_length[128]|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');


		if ($this->form_validation->run() == FALSE) {
			$this->index();
		}

		else
		{ // check login credentials at employee table

			$email = strtolower($this->security->xss_clean($this->input->post('email')));
			$password = $this->security->xss_clean($this->input->post('password'));

			$result = $this->login_model->loginEmployee($email, $password);
			$employeeId = $result->employeeId;

			// if empty than not known.

			if (empty($result)) {
				// go back
				$this->session->set_flashdata('error', 'Are you using the right credentials, or did you not register yet? Please try again or register. ');
				redirect('login');
				//	$this->index(); 
			} else {
				//
				$userId=$result->ownerId;
				$result = $this->user_model->getUserInfoById($userId);
				$lastlogin = $this->login_model->lastLoginInfo($result->userId);
				$sessionArray = array(
					'userId' => $result->userId,
					'role' => $result->roleId,
					'roleText' => $result->role,
					'name' => $result->name,
					'userShortUrl' => $result->usershorturl,
					'lastLogin' => $lastlogin > 'createdDtm',
					'isLoggedIn' => TRUE,
					'lat' => $result->lat,
					'lng' => $result->lng,
				);
				$sessionArray['activatePos'] = $this->shopvendor_model->setProperty('vendorId', intval($result->userId))->getProperty('activatePos');
				$this->load->model('employee_model');
				
				$MenuArray = $this->employee_model->getMenuOptionsByEmployee($employeeId);
				
				$sessionArray['menuOptions'] = $MenuArray;

				
				$this->session->set_userdata($sessionArray);


				unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
				$loginInfo = array("userId" => $result->userId, "sessionData" => json_encode($sessionArray), "machineIp" => $_SERVER['REMOTE_ADDR'], "userAgent" => getBrowserAgent(), "agentString" => $this->agent->agent_string(), "platform" => $this->agent->platform());
				$this->login_model->lastLogin($loginInfo);
				if ($result->roleId == "4") {
					redirect('/translate');
				} else {
					redirect('/loggedin');
				}
				//redirect('/dashboard');
			}
		}

	}

	public function loginCustomer()
	{
		$this->form_validation->set_rules('email', 'Email', 'valid_email|max_length[128]|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		}  else { // check login credentials at employee table

			$email = strtolower($this->security->xss_clean($this->input->post('email')));
			$password = $this->security->xss_clean($this->input->post('password'));
			$result = $this->login_model->loginMe($email, $password);

			if (empty($result)) {
				$this->session->set_flashdata('error', 'Are you using the right credentials, or did you not register yet? Please try again or register.');
				redirect('login');
			} elseif ($result->buyerConfirmed === '0') {
				$this->session->set_flashdata('error', 'Your TIQS account is not created. Please confirm create TIQS account it during next shop');
				redirect('login');
			} else {
                $sessionArray = array(
                    'buyerId' => intval($result->userId),
                    'isLoggedIn' => true,
                    'name' => $result->name,
                );
                $this->session->set_userdata($sessionArray);
                redirect('/loggedin');
			}
		}
	}

	public function logout()
	{
		session_destroy();
		unset($_SESSION['access_token']);
		$session_data = array(
			'sess_logged_in' => 0
		);
		$this->session->set_userdata($session_data);
	}

	public function loginMeAuto($email, $password)
	{
		// destrou sessions... for purpose of clean code
		//  $this->session->sess_destroy();
		if (isset($_SESSION['error'])) {
			unset($_SESSION['error']);
		}

		$result = $this->login_model->loginMe($email, $password);

		$this->session->set_userdata('dropoffpoint', $result->IsDropOffPoint);

		if (!empty($result)) {
			// is account active?
			if (!$result->active) {

				// $this->session->set_flashdata('msg', 'Your account needs to be activated.');
				$this->session->set_flashdata('message', "<div style='color:green;'>code to activate your account, received by e-mail and/or SMS.<div>");

				$this->load->library('form_validation');

				$this->form_validation->set_rules('login_email', 'Email', 'trim|required|valid_email');

				if ($this->form_validation->run() == FALSE) {
					$this->loginMe();
				} else {

					// $this->activate();
				}
			} else {
				$lastlogin = $this->login_model->lastLoginInfo($result->userId);

				$sessionArray = array('userId' => $result->userId,
					'role' => $result->roleId,
					'roleText' => $result->role,
					'name' => $result->name,
					'lastLogin' => $lastlogin > 'createdDtm',
					'isLoggedIn' => TRUE
				);

				$this->session->set_userdata($sessionArray);

				unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);

				$loginInfo = array("userId" => $result->userId, "sessionData" => json_encode($sessionArray), "machineIp" => $_SERVER['REMOTE_ADDR'], "userAgent" => getBrowserAgent(), "agentString" => $this->agent->agent_string(), "platform" => $this->agent->platform());

				$this->login_model->lastLogin($loginInfo);

				redirect('/loggedin');
				//redirect('/dashboard');
			}
		} else {
			$this->session->set_flashdata('error', 'Are you using the right credentials, or did you not register yet? Please try again or register.');
			$this->index();
		}
	}

	/**
	 * This function used to load forgot password view
	 */
	public function forgotPassword()
	{
		$isLoggedIn = $this->session->userdata('isLoggedIn');

		if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
			if (isset($_SESSION['error'])) {
				unset($_SESSION['error']);
			}
			$this->global['pageTitle'] = 'TIQS : REGISTER';
			$this->loadViews("forgotPassword", $this->global, NULL, NULL);
			// $this->load->view('forgotPassword');
		} else {
			redirect('/loggedin');
			// redirect('/dashboard');
		}
	}

	/**
	 * This function used to generate reset password request link
	 */
	function resetPasswordUser()
	{
		$status = '';
		$this->load->library('form_validation');
		$this->form_validation->set_rules('login_email', 'Email', 'trim|required|valid_email');

		if ($this->form_validation->run() == FALSE) {
			$this->forgotPassword();
		} else {
			$email = strtolower($this->security->xss_clean($this->input->post('login_email')));

			if ($this->login_model->checkEmailExist($email)) {
				$encoded_email = urlencode($email);
				$this->load->helper('string');
				$data['email'] = $email;
				$data['activation_id'] = random_string('alnum', 15);
				$data['createdDtm'] = date('Y-m-d H:i:s');
				$data['agent'] = getBrowserAgent();
				$data['client_ip'] = $this->input->ip_address();

				$save = $this->login_model->resetPasswordUser($data);

				if ($save) {
					$data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
					$userInfo = $this->login_model->getCustomerInfoByEmail($email);

					if (!empty($userInfo)) {
						$data1["name"] = $userInfo->name;
						$data1["email"] = $userInfo->email;
						$data1["message"] = "Reset Your Password";
					}

					$sendStatus = resetPasswordEmail($data1);

					if ($sendStatus) {
						$status = "send";
						setFlashData($status, "Reset password link sent successfully, please check your mail.");
					} else {
						$status = "notsend";
						setFlashData($status, "Email has failed, try again.");
					}
				} else {
					$status = 'unable';
					setFlashData($status, "It seems an error while sending your details, try again.");
				}
			} else {
				$status = 'invalid';
				setFlashData($status, "This email is not registered with us.");
			}
			if (isset($_SESSION['error'])) {
				unset($_SESSION['error']);
			}
			redirect('/forgotPassword');
		}
	}

	/**
	 * This function used to reset the password
	 * @param string $activation_id : This is unique id
	 * @param string $email : This is user email
	 */
	function resetPasswordConfirmUser($activation_id, $email)
	{
		// Get email and activation code from URL values at index 3-4
		$email = urldecode($email);

		// Check activation id in database
		$is_correct = $this->login_model->checkActivationDetails($email, $activation_id);

		$data['email'] = $email;
		$data['activation_code'] = $activation_id;
		//#####
		if ($is_correct == 1) {
			$this->global['pageTitle'] = 'TIQS : VERIFY CODE';
			$this->loadViews("newPassword", $data, NULL, "nofooter", "noheader");

//			$this->load->view('newPassword', $data);
		} else {
			redirect('/login');
		}
	}

	public function insertShopAndPerfexUser($userId): void
	{

		$userId = intval($userId);

		// first check is user with this id already exist in tbl_shop_venodros
		// no need for any action if exists
		if ($this->shopvendor_model->setProperty('vendorId', $userId)->isVendorExists()) return;

		// we have a new user

		// fetch user object
		$this->user_model->setUniqueValue($userId)->setWhereCondtition()->setUser();

		// insert initial printer
		$this->shopprinters_model->setProperty('macNumber', $userId)->setProperty('userId', $userId)->insertInitialPrinter();

		// insert initial spot
		$this->shopspot_model->setProperty('printerId', $this->shopprinters_model->id)->insertInitialSpot();

		// insert initail categories
		$drinksCategoryId = $this->shopcategory_model->setProperty('userId', $userId)->insertInitialCategory($this->config->item('initialDrinkCategory'));
		$foodCategoryId = $this->shopcategory_model->setProperty('userId', $userId)->insertInitialCategory($this->config->item('initialFoodCategory'));


		//insert initial product types
		$this->shopprodutctype_model->setProperty('vendorId', intval($this->user_model->id));
		$mainTypeId = $this->shopprodutctype_model->insertInitialTypes($this->config->item('initialMainType'), true);
		$addonTypeId = $this->shopprodutctype_model->insertInitialTypes($this->config->item('initialAddonType'), false);

		// insert main product for drink category
		$dirinkProductId = $this->shopproduct_model->setProperty('categoryId', $drinksCategoryId)->insertInitialProduct();
		$this
			->shopproductex_model
			->setProperty('productId', $dirinkProductId)
			->setProperty('productTypeId', $mainTypeId)
			->insertInitialProductExtended($this->config->item('initialDrinkProduct'));


		// insert main product for food category
		$foodProductId = $this->shopproduct_model->setProperty('categoryId', $foodCategoryId)->insertInitialProduct();
		$this
			->shopproductex_model
			->setProperty('productId', $foodProductId)
			->setProperty('productTypeId', $mainTypeId)
			->insertInitialProductExtended($this->config->item('initialFoodProduct'));

		// insert addon
		$foodAddonProductId = $this->shopproduct_model->setProperty('categoryId', $foodCategoryId)->insertInitialProduct();
		$this
			->shopproductex_model
			->setProperty('productId', $foodAddonProductId)
			->setProperty('productTypeId', $addonTypeId)
			->insertInitialProductExtended($this->config->item('initialFoodAddon'));

		$this
			->shopproductaddons_model
			->setProperty('productId', $foodProductId)
			->setProperty('addonProductId', $foodAddonProductId)
			->setProperty('productExtendedId', $this->shopproductex_model->id)
			->create();

		// insert spot products
		$this->shopspotproduct_model->insertSpotProducts($this->shopproduct_model, $this->shopspot_model->id, $userId);

		// insert shoplclient
		$this->shopvendor_model->setObjectFromArray(['vendorId' => $this->user_model->id])->create();

		// insert default design
		$this->shopvendortemplate_model->setProperty('vendorId', intval($this->user_model->id))->insertDefaultDesign();

		// insert vendor working times
		$this->shopvendortime_model->setProperty('vendorId', $this->user_model->id)->insertVendorTime();

		//insert payment methods
		$this->shoppaymentmethods_model->setProperty('vendorId', $userId)->insertVendorPaymentMethods();

		// insert user in perfex crm		
		Perfex_helper::apiCustomer($this->user_model);

	}

	function activate($userId, $code)
	{
		if ($this->shopvendor_model->setProperty('vendorId', $userId)->isVendorExists()) {
			setFlashData('success', 'Your account is already registered in application');
			redirect('/login');
		};

		$logincred = $this->login_model->activateaccount($userId, $code);
		$is_correct = $this->login_model->checkactivateaccount($userId, $code);

		if ($is_correct == 1) {
			$this->insertShopAndPerfexUser($userId);
			$status = 'success';
			$message = 'Verified your account successfully, you can login now with your credentials.';
			// vincent wants to login automatically
			// password is tored encrypted and therefore inpossible to decrypt and login.
			// $this->loginMeAuto($logincred->email, $logincred->password);
			setFlashData($status, $message);
			redirect('/login');
		} else {
			$status = 'error';
			$message = 'Verified account un-successful, have you already activated the account or check your activation code.';
			setFlashData($status, $message);
			$this->global['pageTitle'] = 'TIQS : VERIFY CODE';
			$this->loadViews("code", $this->global, NULL, NULL, "headerpublic");

		}
	}

	/**
	 * This function used to create new password for user
	 */
	function createPasswordUser()
	{
		$status = '';
		$message = '';
		$email = strtolower($this->security->xss_clean($this->input->post("email")));
		$activation_id = $this->security->xss_clean($this->input->post("activation_code"));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]|max_length[20]');

		if ($this->form_validation->run() == FALSE) {
			$this->resetPasswordConfirmUser($activation_id, urlencode($email));
		} else {
			$password = $this->security->xss_clean($this->input->post('password'));
			$cpassword = $this->security->xss_clean($this->input->post('cpassword'));
			// Check activation id in database
			$is_correct = $this->login_model->checkActivationDetails($email, $activation_id);

			if ($is_correct == 1) {
				$this->login_model->createPasswordUser($email, $password);
				$status = 'success';
				$message = 'Password reset successfully';
			} else {
				$status = 'error';
				$message = 'Password reset failed';
			}
			setFlashData($status, $message);
			redirect("/login");
		}
	}

	function actemail($email, $password)
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
			// $this->session->set_flashdata('success', 'New User created successfully');

			$config = [
				'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
				'api_key' => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
				'list_id' => 'ECFC3PrhFpKLqmt7ClrvXQ',
			];
			$sendy = new \SendyPHP\SendyPHP($config);
			$responseArray = $sendy->subscribe(
				array(
					'name' => 'Customer',
					'email' => $email,
					'Code' => $code,
					'Password' => $password,
					'Link_activation' => base_url() . "login/activate/" . $userId . "/" . $code
				)
			);

			// sending email with Sendy
			if ($responseArray['status'] == 'true' && $responseArray['message'] == 'Subscribed') {
				$this->session->set_flashdata('success', 'New user created successfully and activation code sent to your email');
			} else {
				$this->session->set_flashdata('error', 'New user created successfully but activation code could not be sent to your email. Contact staff and report this errormessage: ' . $responseArray['message']);
			}

			$this->loginMeAuto($email, $password);
		} else {
			$this->session->set_flashdata('error', 'User creation failed, try again');
			redirect("/login/register");
		}
	}

	function actemailhotel($email, $password)
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
			// $this->session->set_flashdata('success', 'New User created successfully');

			$config = [
				'installation_url' => 'https://tiqs.com/newsletters', // Your Sendy installation URL (without trailing slash).
				'api_key' => 'TtlB6UhkbYarYr4PwlR1', // Your API key. Available in Sendy Settings.
				'list_id' => 'Ac343FZnshyc3aHe2t64Ng',
			];
			$sendy = new \SendyPHP\SendyPHP($config);
			$responseArray = $sendy->subscribe(
				array(
					'name' => 'Customer',
					'email' => $email,
					'Code' => $code,
					'Password' => $password,
					'Link_activation' => base_url() . "login/activate/" . $userId . "/" . $code,
					'UserId' => $userId,
					'PageLink' => base_url() . "/location/" . $userId,
				)
			);

			// sending email with Sendy
			if ($responseArray['status'] == 'true' && $responseArray['message'] == 'Subscribed') {
				$this->session->set_flashdata('success', 'Hospitality account created successfully and activation code sent to your email');
			} else {
				$this->session->set_flashdata('error', 'Hospitality account created successfully but activation code could not be sent to the email. Contact staff and report this errormessage: ' . $responseArray['message']);
			}
			redirect("/newregisteredhotelinfo");
		} else {
			$this->session->set_flashdata('error', 'Hospitality account creation failed, try again');
			redirect("/login/registerbusiness");
		}
	}

	public function register()
	{
		redirect('registerbusiness');
		exit();
	}

	public function registerbusiness()
	{
		if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {
			redirect('profile');
		}

		$this->global['pageTitle'] = 'TIQS : REGISTERBUSINESS';

		$data = [
			'isDropOffPoint' => $this->config->item('dropOfPointTrue'),
			'roleId' => ROLE_MANAGER,
			'istype' => 9,
			'createdBy' => 0,
			'businessTypes' => $this->businesstype_model->getAll(),
			'countries' => Country_helper::getCountries(),
		];

		if (isset($_GET['business'])) {
			$data['businessTypeId'] = $this->input->get('business', true);
		}
		if (isset($_GET['ambasador'])) {
			$data['ambasadorId'] = $this->input->get('ambasador', true);
		}

		$this->loadViews("registerbusiness", $this->global, $data, 'footerweb', 'headerpubliclogin');
	}

	public function google()
	{
		$data['google_login_url'] = $this->google->get_login_url();
		header('Location:' . $data['google_login_url']);
	}

	public function oauth2callback()
	{
		$google_data = $this->google->validate();
		$sessionArray = array(
			'name' => $google_data['name'],
			'email' => $google_data['email'],
			'source' => 'google'
		);
		$this->session->set_userdata($sessionArray);
		$email = strtolower($this->security->xss_clean($this->session->userdata('email')));
		$source = $this->session->userdata('source');
		if ($this->user_model->isDuplicate($email)) {
			$result = $this->login_model->loginMe($email, $source);
			$this->session->set_userdata('dropoffpoint', $result->IsDropOffPoint);
			$lastlogin = $this->login_model->lastLoginInfo($result->userId);
			$sessionArray = array('userId' => $result->userId,
				'role' => $result->roleId,
				'roleText' => $result->role,
				'name' => $result->name,
				'lastLogin' => $lastlogin > 'createdDtm',
				'isLoggedIn' => TRUE
			);
			$this->session->set_userdata($sessionArray);
			unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
			$loginInfo = array("userId" => $result->userId,
				"sessionData" => json_encode($sessionArray),
				"machineIp" => $_SERVER['REMOTE_ADDR'],
				"userAgent" => getBrowserAgent(),
				"agentString" => $this->agent->agent_string(),
				"platform" => $this->agent->platform()
			);
			$this->login_model->lastLogin($loginInfo);
			redirect('/loggedin');
			//redirect('/dashboard');
		} else {
			redirect('register');
		}
	}

	public function insta()
	{
		$client_id = '8726c8959e9a4200bdb0786ebc336221';
		$client_secret = 'a48ffa42db3143e48f7483d64f21138c';
		$redirect_uri = 'https://prototype.maargga.com/lost/login/insta';
		$grant_type = 'authorization_code';

		if (isset($_GET['code'])) {
			$insta_param = [
				'client_id' => $client_id,
				'client_secret' => $client_secret,
				'redirect_uri' => $redirect_uri,
				'grant_type' => $grant_type,
				'code' => $_GET['code']
			];
			$curl = curl_init('https://api.instagram.com/oauth/access_token');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $insta_param);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
			$result = curl_exec($curl);
			$final = json_decode($result);
			curl_close($curl);

			$access_token = $final->access_token;
			$sessionArray = array(
				'full_name' => $final->user->full_name,
				'name' => $final->user->username,
				'source' => 'insta',
				'sess_logged_in' => 1,
				'isLoggedIn' => TRUE
			);
			$this->session->set_userdata($sessionArray);
			$username = strtolower($this->security->xss_clean($this->session->userdata('name')));
			$source = $this->session->userdata('source');
			if ($this->user_model->isDuplicateusername($username)) {
				$result = $this->login_model->loginMe($username, $source);
				$this->session->set_userdata('dropoffpoint', $result->IsDropOffPoint);
				$lastlogin = $this->login_model->lastLoginInfo($result->userId);
				$sessionArray = array('userId' => $result->userId,
					'role' => $result->roleId,
					'roleText' => $result->role,
					'name' => $result->name,
					'lastLogin' => $lastlogin > 'createdDtm',
					'isLoggedIn' => TRUE
				);
				$this->session->set_userdata($sessionArray);
				unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
				$loginInfo = array("userId" => $result->userId,
					"sessionData" => json_encode($sessionArray),
					"machineIp" => $_SERVER['REMOTE_ADDR'],
					"userAgent" => getBrowserAgent(),
					"agentString" => $this->agent->agent_string(),
					"platform" => $this->agent->platform()
				);
				$this->login_model->lastLogin($loginInfo);
				redirect('/loggedin');
				//redirect('/dashboard');
			} else {
				redirect('register');
			}
		} else {
			$url = 'https://api.instagram.com/oauth/authorize/?client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=basic';
			header('Location:' . $url);
		}
	}

	private function fbinit()
	{
		if (!session_id())
			session_start();

		$fb = new Facebook\Facebook([
			'app_id' => '2175769952520353',
			'app_secret' => '4676f8d1eb74eda3caf3ba9083817fac',
			'default_graph_version' => 'v2.10',
		]);
		return $fb;
	}

	public function facebook()
	{
		$fb = $this->fbinit();
		$helper = $fb->getRedirectLoginHelper();
		$permissions = ['email'];
		$loginUrl = $helper->getLoginUrl(base_url() . 'loginfbcallback', $permissions);
		header('Location:' . $loginUrl);
	}

	public function fbcallback()
	{

		$fb = $this->fbinit();
		$helper = $fb->getRedirectLoginHelper();

		$this->session->set_userdata('state', $_GET['state']);

		$app_id = "2175769952520353";
		$app_secret = "4676f8d1eb74eda3caf3ba9083817fac";
		$my_url = base_url() . 'loginfbcallback';

		$code = $_GET["code"];

		// If we get a code, it means that we have re-authed the user
		// and can get a valid access_token.
		if (isset($code)) {
			$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
				. $app_id . "&redirect_uri=" . urlencode($my_url)
				. "&client_secret=" . $app_secret
				. "&code=" . $code . "&display=popup";
			$response = file_get_contents($token_url);
			$params = json_decode($response);
			$accessToken = $params->access_token;
		}

		try {
			$response = $fb->get('/me?fields=id,name,email', $accessToken);
		} catch (Facebook\Exceptions\FacebookResponseException $e) {
			echo 'ERROR: Graph ' . $e->getMessage();
			exit;
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			echo 'ERROR: validation fails ' . $e->getMessage();
			exit;
		}

		/*

		  try {
		  if(!$this->session->userdata('token')){
		  $accessToken = $helper->getAccessToken();
		  $this->session->set_userdata('token',$accessToken);
		  }
		  else{
		  $accessToken = $this->session->userdata('token');
		  }
		  } catch(Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		  } catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		  }
		  try {
		  $response = $fb->get('/me?fields=id,name,email', $accessToken);
		  } catch(Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'ERROR: Graph ' . $e->getMessage();
		  exit;
		  } catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'ERROR: validation fails ' . $e->getMessage();
		  exit;
		  }
		 */

		$me = $response->getGraphUser();
		$sessionArray = array(
			'name' => $me->getName('name'),
			'email' => $me->getEmail(),
			'facebookid' => $me->getId(),
			'source' => 'facebook',
		);
		$this->session->set_userdata($sessionArray);

		redirect('/register');
	}


	public function registerbusinessAction()
	{
		$this->form_validation->set_rules('username', 'Full Name', 'trim|required|max_length[128]');
		// $this->form_validation->set_rules('usershorturl', 'User short url', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('first_name', 'Full Name', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('second_name', 'Full Name', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]|max_length[20]');
		$this->form_validation->set_rules('roleid','Role','trim|required|numeric');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[6]');
		$this->form_validation->set_rules('business_type_id', 'Business type id', 'required|numeric');
		$this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('city', 'City', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('country', 'Country', 'trim|required|max_length[128]');

		$hotel = Utility_helper::sanitizePost();
		$this->user_model->setUniqueValue($hotel['email'])->setWhereCondtition()->setUser();

		// vendor exists if inserted in tbl_user with roleid must be 2
		// in tbl_user we can have user with given email but with roleid 6 (buyer)
		if ($this->user_model->id && $this->user_model->roleid === $this->config->item('owner')) {
			if ($this->user_model->active !== '0') {
				$this->session->set_flashdata('error', $this->language->Line("registerbusiness-F1001OPA","We already know you, please reset password (forgot password) or use other e-mail address to (register)"));
			} else {
				$this->session->set_flashdata('error', $this->language->Line("registerbusiness-F1001231A","We already know you. Please activate your account. Check your email for activation link"));
			}
			unset($hotel['password']);
			unset($hotel['cpassword']);
			foreach($hotel as $key => $value) {
				set_cookie($key, $value, (60 * 60));
			}
			$failedRedirect = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : 'registerbusiness';
			redirect($failedRedirect);
			exit();
		}

		// $this->form_validation->set_rules('vat_number', 'Vat number', 'required|max_length[20]');
		if ($this->form_validation->run()) {
			unset($hotel['cpassword']);
			// now we check one more time is this new vendor, or we need to update existing user to a vendor
			if ($this->user_model->id) {
				$this->user_model->updateAndSetHotel($hotel)->sendActivationLink();
			} else {
				$this->user_model->insertAndSetHotel($hotel)->sendActivationLink();
			}
		}

		// we have a success if $this->user_model->roleid === $this->config->item('owner')
		if ($this->user_model->id && $this->user_model->roleid === $this->config->item('owner')) {
			$this->session->set_flashdata('success', $this->language->Line("registerbusiness-F1002A","Account created Successfully. In your given email we have send your activation link/code and credentials"));
			$redirect = base_url() . 'login';
			redirect($redirect);
		}

		// if failed
		unset($hotel['password']);
		unset($hotel['cpassword']);
		foreach($hotel as $key => $value) {
			set_cookie($key, $value, (60 * 60));
		}

		$this->session->set_flashdata('error', '20101 Process failed! Data given not valid');
		$failedRedirect = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : 'registerbusiness';
		redirect($failedRedirect);
	}

	private function accountSettings(object $result): void
	{
		$lastlogin = $this->login_model->lastLoginInfo($result->userId);
		$sessionArray = array(
			'userId' => $result->userId,
			'role' => $result->roleId,
			'roleText' => $result->role,
			'name' => $result->name,
			'userShortUrl' => $result->usershorturl,
			'lastLogin' => $lastlogin > 'createdDtm',
			'isLoggedIn' => TRUE,
			'lat' => $result->lat,
			'lng' => $result->lng,
			'businessTypeId' => $result->business_type_id
		);
		$sessionArray['activatePos'] = $this->shopvendor_model->setProperty('vendorId', intval($result->userId))->getProperty('activatePos');
		$sessionArray['payNlServiceIdSet'] = !is_null($this->shopvendor_model->setProperty('vendorId', intval($result->userId))->getProperty('paynlServiceId'));
		// $merchantId = $this->shopvendor_model->setProperty('vendorId', intval($result->userId))->getProperty('merchantId');
		if (
			$result->userId === $result->masterId
			&& !isset($sessionArray['masterAccounts'])
			&& !isset($sessionArray['masterAccountId'])
		) {
			$sessionArray['masterAccounts'] = $this->user_model->masterAccounts(intval($result->userId));
			$sessionArray['masterAccountId'] = $result->userId;
		}
		// if (!$sessionArray['payNlServiceIdSet'] && $merchantId) {
		// 	$sessionArray['payNlServiceIdSet'] = Pay_helper::getPayNlServiceId($merchantId, intval($result->userId));
		// }

		// $this->load->model('vendor_model');
		// $MenuArray = $this->vendor_model->getMenuOptionsByVendorId($result->userId);
		// $sessionArray['menuOptions'] = $MenuArray;


		$MenuArray = array(
			'all'
		);

		$sessionArray['menus'] = $MenuArray;

		$this->session->set_userdata($sessionArray);
		unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
		$loginInfo = array("userId" => $result->userId, "sessionData" => json_encode($sessionArray), "machineIp" => $_SERVER['REMOTE_ADDR'], "userAgent" => getBrowserAgent(), "agentString" => $this->agent->agent_string(), "platform" => $this->agent->platform());
		$this->login_model->lastLogin($loginInfo);

		($result->roleId == "4") ? redirect('/translate') : redirect('/loggedin');
	}

	public function switchAccount(): void
	{
		$id = $this->input->post('masterAccountId', true);
		$user = $this->login_model->loginMeById(intval($id));
		($user) ? $this->accountSettings($user) : redirect('logout');

		return;
	}

	public function registerAmbasador(): void
	{
		$data = [
			'email' => get_cookie($this->config->item('ambasadorCokkiePrefix') . 'email'),
			'firstName' => get_cookie($this->config->item('ambasadorCokkiePrefix') . 'firstName'),
			'lastName' => get_cookie($this->config->item('ambasadorCokkiePrefix') . 'lastName'),
		];


		$this->global['pageTitle'] = 'TIQS : REGISTER AMBASADOR';
		$this->loadViews("registerAmbasador", $this->global, $data, 'footerweb', 'headerpubliclogin');
		return;
	}

	public function ambasadorActivate($key): void
	{
		$ambasador = (array) Jwt_helper::decode($key);
		$staff = [
			'firstname' => $ambasador['firstName'] . ' ' . $ambasador['lastName'],
			'email' => $ambasador['email'],
			'password' => Utility_helper::getAndUnsetValue($ambasador, 'password')
		];
		$response = Perfex_helper::apiStaff($staff);

		if ($response && $response->status) {
			$this->session->set_flashdata('success', 'You became TIQS ambasdor');
		} else {
			foreach ($ambasador as $key => $value) {
				$name = $this->config->item('ambasadorCokkiePrefix') . $key;
				set_cookie([
					'name' => $name,
					'value' => $value,
					'expire' => 300,
					'httponly' => true
				]);
			}
			$message = is_null($response) ? 'Registration faied! Please check are you already our ambasador' : 'Registration faied! Please try again';
			$this->session->set_flashdata('error', $message);
		}

		redirect('alfred_ambasador');
		return;
	}


	public function buyerCreatePassword($code): void
	{
		$data = [
			'code' => $code
		];

		$this->global['pageTitle'] = 'TIQS : REGISTER';
		$this->load->view('buyerPassword', $data);
	}

	public function createBuyerPassword(): void
	{
		$post = $this->security->xss_clean($_POST);
		if ($post['password'] !== $post['cpassword']) {
			$this->session->set_flashdata('error', 'Password and repeat password does not mnatch');
			$redirect = base_url() . 'create_password' . DIRECTORY_SEPARATOR . $post['code'];
		} else {
			if ($this->user_model->createBuyerPassword($post['email'], $post['code'], $post['password'])) {
				$this->session->set_flashdata('success', 'Password created');
				$redirect = base_url() . 'login#customerLogin' ;
			} else {
				$this->session->set_flashdata('error', 'Failed. Please check your email');
				$redirect = base_url() . 'create_password' . DIRECTORY_SEPARATOR . $post['code'];
			}
		}

		redirect($redirect);
		return;
	}

	public function resendActivationLink(): void
	{
		$this->global['pageTitle'] = 'TIQS : RESEND ACTIVATION LINK';
		$this->loadViews("login/resendActivationLink", $this->global, NULL, NULL);
	}

	public function requestNewActivationLink(): void
	{
		$email = strtolower($this->security->xss_clean($this->input->post('login_email')));

		if (empty($email)) {
			setFlashData('fail','Email is requried');
		} elseif (!Validate_data_helper::validateEmail($email)) {
			setFlashData('fail','Email is not valid');
		} elseif (!$this->login_model->checkEmailExist($email)) {
			setFlashData('fail','This email is not registered with us.');
		} elseif (!$this->user_model->resendActivationLink($email)) {
			setFlashData('fail','Email did not send. Please try again');
		} else {
			setFlashData('success','Activate account email sent');
		}

		redirect('resend_activation_link');;
	}
}
