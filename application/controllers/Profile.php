<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Profile extends BaseControllerWeb
{
	/**
	 * This is default constructor of the class
	 */
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
		$this->load->model('subscription_model');		
		$this->load->model('user_subscription_model');
		$this->load->model('label_model');
		$this->load->model('shopvendor_model');
		
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));

		$this->isLoggedIn();
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
		];

		$this->loadViews("profile", $this->global, $data, NULL, 'headerwebloginhotelProfile'); // Menu profilepage
	}

	public function updateVendorData($id): void
	{
		$this->shopvendor_model->id = intval($id);

		if ($this->shopvendor_model->setObjectFromArray($_POST)->update()) {
			$this->session->set_flashdata('success', 'Data updated');
		} else {
			$this->session->set_flashdata('error', 'Update data failed');
		}

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



}
