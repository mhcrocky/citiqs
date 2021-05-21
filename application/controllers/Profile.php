<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Profile extends BaseControllerWeb
{
	/**
	 * This is default constructor of the class
	 */
	protected $userId;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('country_helper');
		$this->load->helper('utility_helper');
		$this->load->helper('validate_data_helper');
		$this->load->helper('uploadfile_helper');
		$this->load->helper('pay_helper');

		$this->load->model('user_model');
		$this->load->model('businesstype_model');
		$this->load->model('shopvendor_model');
		$this->load->model('shopspottype_model');
		$this->load->model('shopvendortypes_model');
		$this->load->model('shopvendortime_model');
		$this->load->model('api_model');
		$this->load->model('shopreport_model');

		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));

		$this->isLoggedIn();
		$this->userId = $this->session->userdata('userId');
	}

	public function index()
	{
		$active="details";
		$this->global['pageTitle'] = $active == "details" ? 'tiqs : My Profile' : 'tiqs : Change Password';
		$this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();

		$subscriptionWhat = ['id', 'short_description', 'description', 'ROUND(amount, 2) AS amount', 'active', 'tiqssendcom', 'backOfficeItemId', 'type'];
		$data = [
			'user' => $this->user_model,
			'active' => $active,
			'countries' => Country_helper::getCountries(),
			'action' => 'profileUpdate',
			'businessTypes' => $this->businesstype_model->getAll(),
			'vendor' =>	$this->shopvendor_model->setProperty('vendorId', $this->userId)->getVendorData(),
			'workingTime' => $this->shopvendortime_model->setProperty('vendorId', $this->userId)->fetchWorkingTime(),
			'dayOfWeeks' => $this->config->item('weekDays'),
		];
		// var_dump($data['vendor']);
		// die();
		if ($data['workingTime']) {
			$data['workingTime'] = Utility_helper::resetArrayByKeyMultiple($data['workingTime'], 'day');
		}

		$this->loadViews("profile/index", $this->global, $data, NULL, 'headerwebloginhotelProfile'); // Menu profilepage
	}


	public function address()
	{
		$this->global['pageTitle'] = 'TIQS: Address';
		$this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
		$subscriptionWhat = ['id', 'short_description', 'description', 'ROUND(amount, 2) AS amount', 'active', 'tiqssendcom', 'backOfficeItemId', 'type'];
		$data = [
			'user' => $this->user_model,
			'countries' => Country_helper::getCountries(),
			'action' => 'profileUpdate',
			'businessTypes' => $this->businesstype_model->getAll(),
			'vendor' =>	$this->shopvendor_model->setProperty('vendorId', $this->userId)->getVendorData(),
		];

		$this->loadViews("profile/address", $this->global, $data, 'footerbusiness', 'headerbusiness'); // Menu profilepage
	}


	public function changePassword()
	{
		$this->global['pageTitle'] = 'TIQS: CHANGE PASSWORD';
		$this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
		$subscriptionWhat = ['id', 'short_description', 'description', 'ROUND(amount, 2) AS amount', 'active', 'tiqssendcom', 'backOfficeItemId', 'type'];
		$data = [
			'user' => $this->user_model
		];

		$this->loadViews("profile/changepassword", $this->global, $data, 'footerbusiness', 'headerbusiness'); // Menu profilepage
	}


	public function paymentsettings()
	{
		$active="details";
		$this->global['pageTitle'] = 'TIQS: PAYMENT SETTINGS';
		$this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();

		$subscriptionWhat = ['id', 'short_description', 'description', 'ROUND(amount, 2) AS amount', 'active', 'tiqssendcom', 'backOfficeItemId', 'type'];
		$data = [
			'user' => $this->user_model,
			'active' => $active,
			'action' => 'profileUpdate',
			'businessTypes' => $this->businesstype_model->getAll(),
			'vendor' =>	$this->shopvendor_model->setProperty('vendorId', $this->userId)->getVendorData(),
			'taxRates' => $this->config->item('countriesTaxes')[$this->user_model->country]['taxRates']
		];

		$this->loadViews("profile/paymentsettings", $this->global, $data, 'footerbusiness', 'headerbusiness'); // Menu profilepage
	}


	public function shopsettings()
	{
		$active="details";
		$this->global['pageTitle'] = 'TIQS: SHOP SETTINGS';
		$this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();

		$subscriptionWhat = ['id', 'short_description', 'description', 'ROUND(amount, 2) AS amount', 'active', 'tiqssendcom', 'backOfficeItemId', 'type'];
		$data = [
			'user' => $this->user_model,
			'active' => $active,
			'action' => 'profileUpdate',
			'businessTypes' => $this->businesstype_model->getAll(),
			'vendor' =>	$this->shopvendor_model->setProperty('vendorId', $this->userId)->getVendorData(),
			'oldView' => $this->config->item('oldMakeOrderView'),
			'newView' => $this->config->item('newMakeOrderView'),
			'view2021' => $this->config->item('view2021'),
		];

		$this->loadViews("profile/shopsettings", $this->global, $data, 'footerbusiness', 'headerbusiness'); // Menu profilepage
	}


	public function logo()
	{
		$this->global['pageTitle'] = 'TIQS: LOGO';
		$this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();

		$subscriptionWhat = ['id', 'short_description', 'description', 'ROUND(amount, 2) AS amount', 'active', 'tiqssendcom', 'backOfficeItemId', 'type'];
		$data = [
			'user' => $this->user_model,
			'vendor' =>	$this->shopvendor_model->setProperty('vendorId', $this->userId)->getVendorData()
		];
	

		$this->loadViews("profile/logo", $this->global, $data, 'footerbusiness', 'headerbusiness'); // Menu profilepage
	}


	public function termsofuse()
	{
		$this->global['pageTitle'] = 'TIQS: TERMS OF USE';
		$this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();

		$subscriptionWhat = ['id', 'short_description', 'description', 'ROUND(amount, 2) AS amount', 'active', 'tiqssendcom', 'backOfficeItemId', 'type'];
		$data = [
			'user' => $this->user_model,
			'vendor' =>	$this->shopvendor_model->setProperty('vendorId', $this->userId)->getVendorData()
		];

		$this->loadViews("profile/termsofuse", $this->global, $data, 'footerbusiness', 'headerbusiness'); // Menu profilepage
	}


	public function openandclose()
	{
		$this->global['pageTitle'] = 'TIQS: OPEN AND CLOSE';
		$this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();

		$subscriptionWhat = ['id', 'short_description', 'description', 'ROUND(amount, 2) AS amount', 'active', 'tiqssendcom', 'backOfficeItemId', 'type'];
		$data = [
			'user' => $this->user_model,
			'vendor' =>	$this->shopvendor_model->setProperty('vendorId', $this->userId)->getVendorData(),
			'workingTime' => $this->shopvendortime_model->setProperty('vendorId', $this->userId)->fetchWorkingTime(),
			'dayOfWeeks' => $this->config->item('weekDays'),
		];
		
		
		if ($data['workingTime']) {
			$data['workingTime'] = Utility_helper::resetArrayByKeyMultiple($data['workingTime'], 'day');
		}

		$this->loadViews("profile/openandclose", $this->global, $data, 'footerbusiness', 'headerbusiness'); // Menu profilepage
	}


	public function updateVendorData($id): void
	{
		$this->shopvendor_model->id = intval($id);
		$post  = Utility_helper::sanitizePost();
		if(isset($post['vendorTypes'])){
			$vendorTypes = empty($post) ? [] : $post['vendorTypes'];
			$this->shopvendortypes_model->setProperty('vendorId', intval($post['vendorId']))->updateVendorTypes($vendorTypes);
		}

		//
		if(isset($post['vendor'])){
			if ($this->shopvendor_model->setObjectFromArray($post['vendor'])->update()) {
				if (isset($post['vendor']['activatePos'])) {
					$_SESSION['activatePos'] = $post['vendor']['activatePos'];
				}
				$this->session->set_flashdata('success', 'Data updated');
			} else {
				$this->session->set_flashdata('error', 'Update data failed');
			}
		}
		
		if(isset($post['paymentsettings'])){
			redirect('paymentsettings');
		} else if(isset($post['shopsettings'])){
			redirect('shopsettings');
		}

		redirect('termsofuse');
		exit();
	}


    public function updateVendorLogo($userId): void
    {
		$folder = $this->config->item('uploadLogoFolder');
		$logo = $userId . '_' . strval(time()) . '.' . Uploadfile_helper::getFileExtension($_FILES['logo']['name']);
		$constraints = [
			'allowed_types'=> 'png'
		];
		$_FILES['logo']['name'] = $logo;

		if (
			Uploadfile_helper::uploadFiles($folder, $constraints)
			&& $this->user_model->editUser(['logo' => $logo], $userId)
		) {
			$this->session->set_flashdata('success', 'Logo uploaded');
		} else {
			$this->session->set_flashdata('error', 'Upload logo failed');
		}
		redirect('logo');
		exit();
	}

	public function uploadDefaultProductsImage($id): void
    {
		$folder = $this->config->item('defaultProductsImages');
		$defaultProductsImage = $id . '_' . strval(time()) . '.' . Uploadfile_helper::getFileExtension($_FILES['defaultProductsImage']['name']);
		$constraints = [
			'allowed_types'=> 'png'
		];
		$_FILES['defaultProductsImage']['name'] = $defaultProductsImage;
		$uploadImage = Uploadfile_helper::uploadFiles($folder, $constraints);
		$updateVendor = $this
							->shopvendor_model
								->setObjectId(intval($id))
								->setProperty('defaultProductsImage', $defaultProductsImage)
								->update();

		if ($uploadImage && $updateVendor) {
			$this->session->set_flashdata('success', 'Default products image uploaded');
		} else {
			$this->session->set_flashdata('error', 'Upload of default product image failed');
		}
		redirect('logo');
		exit();
	}

	public function updateVendorTime($vendorId): void
	{
		$post = $this->input->post(null, true);		

		$this->shopvendortime_model->setProperty('vendorId', $vendorId)->deleteVenodrTimes();

		foreach ($post as $day => $value) {			
			if (count($value['timeFrom']) === count($value['timeTo'])) {
				$insert = array_map(function($from, $to) use($day, $vendorId) {
					if ($from && $to) {
						return [
							'vendorId'	=> $vendorId,
							'day'		=> $day,
							'timeFrom'	=> $from,
							'timeTo'	=> $to,
						];
					}					
				}, $value['timeFrom'], $value['timeTo'] );

				$insert = array_filter($insert, function($data) {
					if (!empty($data)) return $data;
				});

				if (!empty($insert)) {
					if (!$this->shopvendortime_model->multipleCreate($insert)) {
						$this->session->set_flashdata('error', 'Time update failed');
						redirect('profile');
						return;
					};
				}

				
			}
		}

		$this->session->set_flashdata('success', 'Time updated');
		redirect('openandclose');
		return;
	}

	public function setNonWorkingTime($id): void
	{
		$post = Utility_helper::sanitizePost();

		if (!$post['nonWorkFrom'] || !$post['nonWorkTo']) {
			$this->session->set_flashdata('error', 'Date from and date to are required');
		} elseif ($post['nonWorkFrom'] < date('Y-m-d')) {

			$this->session->set_flashdata('error', 'Date from can not be before today');
		} elseif ($post['nonWorkFrom'] > $post['nonWorkTo']) {
			$this->session->set_flashdata('error', 'Date to can not be before date from');
		} else {
			$update = $this
						->shopvendor_model
							->setObjectId(intval($id))
							->setProperty('nonWorkFrom', $post['nonWorkFrom'])
							->setProperty('nonWorkTo', $post['nonWorkTo'])
							->update();
			if ($update) {
				$this->session->set_flashdata('success', 'Non working period set');
			} else {
				$this->session->set_flashdata('error', 'Non working period did not set');
			}
			
		}


		#die();
		redirect('openandclose');
	}

	public function userApi(): void
	{
		$userId = intval($this->userId);
		$apiUsers = $this->api_model->setProperty('userid', $userId)->getUsers();

		if (is_null($apiUsers)) {
			$name = strval($this->user_model->getUserProperty($userId, 'username'));
			$apiUser = $this->api_model->insertApiUser($userId, $name);
			array_push($apiUsers, $apiUser);
		}

		$data = [
			'apiUsers' => $apiUsers,
			'userId' => $userId,
		];

		$this->global['pageTitle'] = 'TIQS: API';
		$this->loadViews("profile/api", $this->global, $data, 'footerbusiness', 'headerbusiness'); // Menu profilepage
	}

	public function addNewApiUser(): void
	{
		$post = Utility_helper::sanitizePost();
		$userId = intval($post['userId']);
		$name = $post['name'];

		$apiUser = $this->api_model->insertApiUser($userId, $name);

		if (empty($apiUser)) {
			$this->session->set_flashdata('error', 'Process failed');
		} else {
			$this->session->set_flashdata('success', 'Api user created');
		}

		redirect('userapi');
	}

	public function paynlMerchant(): void
	{
		$userId = intval($_SESSION['userId']);
		$data['paynlDocumentStatusDesc'] = $this->config->item('paynlDocumentStatusDesc');
		$merchantId = $this->shopvendor_model->setProperty('vendorId', $userId)->getProperty('merchantId');

		if ($merchantId) {
			$data['merchant'] = Pay_helper::getMerchant($merchantId);
		}

		$this->global['pageTitle'] = 'TIQS: PAYNL MERCHANT';
		$this->loadViews("profile/paynlMerchant", $this->global, $data, 'footerbusiness', 'headerbusiness');
	}

	public function resetTimes(): void
	{
		$this->global['pageTitle'] = 'TIQS: RESET TIMES';
		$this->loadViews('profile/resetTimes', $this->global, null, 'footerbusiness', 'headerbusiness');
	}

	public function reportsSettings(): void
	{
		$data = [
			'xReport' => $this->config->item('x_report'),
			'zReport' => $this->config->item('z_report'),
			'reportPeriods' => $this->config->item('reportPeriods'),
			'weekDays' => $this->config->item('weekDays'),
			'report' => $this->shopreport_model->setProperty('vendorId', $_SESSION['userId'])->getVendorReport(),
			'weekPeriod' => $this->config->item('weekPeriod'),
			'monthPeriod' => $this->config->item('monthPeriod'),
		];

		$this->global['pageTitle'] = 'TIQS: REPORTS SETTINGS';
		$this->loadViews('profile/reportsSettings', $this->global, $data, 'footerbusiness', 'headerbusiness');
	}
}
