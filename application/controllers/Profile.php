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

		$this->load->model('user_model');
		$this->load->model('businesstype_model');
		$this->load->model('shopvendor_model');
		$this->load->model('shopspottype_model');
		$this->load->model('shopvendortypes_model');
		$this->load->model('shopvendortime_model');

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

		$this->loadViews("profile", $this->global, $data, NULL, 'headerwebloginhotelProfile'); // Menu profilepage
	}

	public function updateVendorData($id): void
	{
		$this->shopvendor_model->id = intval($id);
		$post  = Utility_helper::sanitizePost();
		$vendorTypes = empty($post) ? [] : $post['vendorTypes'];

		$this->shopvendortypes_model->setProperty('vendorId', intval($post['vendorId']))->updateVendorTypes($vendorTypes);

		if ($this->shopvendor_model->setObjectFromArray($post['vendor'])->update()) {
			$_SESSION['activatePos'] = $post['vendor']['activatePos'];
			$this->session->set_flashdata('success', 'Data updated');
		} else {
			$this->session->set_flashdata('error', 'Update data failed');
		}

		redirect('profile');
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
		redirect('profile');
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
		redirect('profile');
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
		redirect('profile');
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
			var_dump($post);

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
		redirect('profile');
	}
}
