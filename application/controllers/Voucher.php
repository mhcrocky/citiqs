<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Voucher extends BaseControllerWeb
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'TIQS: Vouchers List';
		$vendorId = $this->session->userdata('userId');
        $data['vendorId'] = $vendorId;
		$this->load->model('shopproduct_model');
		$data['templateName'] = '';

		$join = [
			0 => [
				'tbl_shop_products_extended',
				'tbl_shop_products_extended.productId = tbl_shop_products.id',
				'left',
			],
			1 => [
				'tbl_shop_categories',
				'tbl_shop_categories.id = tbl_shop_products.categoryId',
				'left',
			]
		];
		$what = ['tbl_shop_products.id' ,'tbl_shop_products_extended.name'];
		$where = [
			 "userId" => $vendorId,
			 "tbl_shop_products_extended.name<>" => null
			];
			
		$data['products'] = $this->shopproduct_model->read($what,$where, $join, 'group_by', ['tbl_shop_products.id']);
		$this->loadViews("voucher/index", $this->global, $data, 'footerbusiness', 'headerbusiness'); 
	}

	public function create(){
		$this->global['pageTitle'] = 'TIQS: Create Vouchers';
		$vendorId = $this->session->userdata('userId');
        $data['vendorId'] = $vendorId;
		$this->load->model('shopproduct_model');
		$join = [
			0 => [
				'tbl_shop_products_extended',
				'tbl_shop_products_extended.productId = tbl_shop_products.id',
				'left',
			],
			1 => [
				'tbl_shop_categories',
				'tbl_shop_categories.id = tbl_shop_products.categoryId',
				'left',
			]
		];
		$what = ['tbl_shop_products.id' ,'tbl_shop_products_extended.name'];
		$where = [
			 "userId" => $vendorId,
			 "tbl_shop_products_extended.name<>" => null
			];
			
		$data['products'] = $this->shopproduct_model->read($what,$where, $join, 'group_by', ['tbl_shop_products.id']);
		$this->loadViews("voucher/create", $this->global, $data, 'footerbusiness', 'headerbusiness'); 
	}

	public function listTemplates(): void
    {
        $vendorId = $this->session->userdata('userId');
		$this->load->model('email_templates_model');

        $data = [
            'templates' => $this->email_templates_model->get_voucher_email_by_user($vendorId),
            'updateTemplate' => base_url() . 'update_template' . DIRECTORY_SEPARATOR,
        ];

            $this->global['pageTitle'] = 'TIQS : LIST TEMPLATE';
            $this->loadViews('templates/listTemplates', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

}