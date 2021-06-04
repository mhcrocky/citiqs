<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . '/libraries/BaseControllerWeb.php';

class Voucher extends BaseControllerWeb
{
	public function __construct()
	{
		parent::__construct();
		$this->load->config('custom');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'TIQS: Vouchers List';
		$vendorId = $this->session->userdata('userId');
        $data['vendorId'] = $vendorId;
		$this->load->model('shopproduct_model');
		$this->load->model('email_templates_model');
		$data['emails'] = $this->email_templates_model->get_voucher_email_by_user($vendorId);
		
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
		$data['productGroups'] = $this->config->item('productGroups');

		$this->loadViews("voucher/index", $this->global, $data, 'footerbusiness', 'headerbusiness'); 
	}

	public function send(){
		$this->global['pageTitle'] = 'TIQS: Voucher Send';
		$vendorId = $this->session->userdata('userId');
        $data['vendorId'] = $vendorId;
		$this->load->model('shopvoucher_model');
		$this->load->model('email_templates_model');
		
		$what = ['*'];
		$where = ["vendorId" => $vendorId, "active" => '1'];
        $data['vouchers'] = $this->shopvoucher_model->read($what,$where, [], "where", ["voucherused < numberOfTimes"]);
		$this->loadViews("voucher/send", $this->global, $data, 'footerbusiness', 'headerbusiness'); 
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
            'updateTemplate' => base_url() . 'voucher/update_template' . DIRECTORY_SEPARATOR,
        ];

        $this->global['pageTitle'] = 'TIQS : LIST TEMPLATE';
        $this->loadViews('voucher/templates/listTemplates', $this->global, $data, 'footerbusiness', 'headerbusiness');
        return;
    }

	public function updateTemplate($id): void
    {
        $data = [
            'vendorId' => intval($_SESSION['userId']),
            'tiqsId' => $this->config->item('tiqsId'),
        ];
		$this->setEmailTemplateUpdate($data, intval($id));

		$this->global['pageTitle'] = 'TIQS : UPDATE TEMPLATE';
        $this->loadViews('voucher/templates/updateTemplate', $this->global, $data, 'footerbusiness', 'headerbusiness');
        return;
    }

	public function translate_lang(){
		$text = $this->input->post('text');
		echo $this->language->tline($text);
	}

	private function setEmailTemplateUpdate(array &$data, int $id): void
    {
		$this->load->model('shoptemplates_model');
        $this->shoptemplates_model->setObjectId($id)->setObject();
        // to check id
        $data['emailTemplates'] = $this->config->item('emailTemplates');
        $data['templateId'] = $id;
        $data['templateName'] = $this->shoptemplates_model->template_name;
        $data['templateSubject'] = $this->shoptemplates_model->template_subject;
        $data['templateType'] = $this->shoptemplates_model->template_type;
        $data['templateContent'] = file_get_contents($this->shoptemplates_model->getTemplateFile());
        $data['emailTemplatesEdit'] = true;
        $data['landingPagesEdit'] = false;

        return;
    }


	public function download_email_pdf($voucherId)
	{
		$this->load->model('shopvoucher_model');
        $what = ['*'];
		$where = ["id" => $voucherId];
        $data = $this->shopvoucher_model->read($what,$where);
		$name = urldecode($this->input->get('name'));
		$email = urldecode($this->input->get('email'));
        $qrtext = $data[0]['code'];
        $voucherCode = $data[0]['code'];
        $voucherDescription = $data[0]['description'];
        $voucherAmount = $data[0]['amount'];
        $voucherPercent = $data[0]['percent'];
        switch (strtolower($_SERVER['HTTP_HOST'])) {
            case 'tiqs.com':
				$file = '/home/tiqs/domains/tiqs.com/public_html/alfred/uploads/qrcodes/';
				break;
			case '127.0.0.1':
				$file = 'C:/wamp64/www/alfred/alfred/uploads/qrcodes/';
				break;
			default:
				break;
		}

		$SERVERFILEPATH = $file;
		$text = $qrtext;
		$folder = $SERVERFILEPATH;
		$file_name1 = $qrtext . ".png";
		$file_name = $folder . $file_name1;

        switch (strtolower($_SERVER['HTTP_HOST'])) {
			case 'tiqs.com':
				$SERVERFILEPATH = 'https://tiqs.com/alfred/uploads/qrcodes/';
				break;
			case '127.0.0.1':
				$SERVERFILEPATH = 'http://127.0.0.1/alfred/alfred/uploads/qrcodes/';
				break;
			default:
				break;
        }
                        
		switch (strtolower($_SERVER['HTTP_HOST'])) {
			case 'tiqs.com':
				$SERVERFILEPATH = 'https://tiqs.com/alfred/uploads/qrcodes/';
				break;
			case '127.0.0.1':
				$SERVERFILEPATH = 'http://127.0.0.1/alfred/alfred/uploads/qrcodes/';
				break;
			default:
				break;
        }

                        
		if($data[0]['emailId']) {
            $this->load->model('email_templates_model');
            $emailTemplate = $this->email_templates_model->get_emails_by_id($data[0]['emailId']);
            $this->config->load('custom');
            $mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$data[0]['vendorId'].'/'.$emailTemplate->template_file .'.'.$this->config->item('template_extension'));
            $qrlink = $SERVERFILEPATH . $file_name1;
			if($mailtemplate) {
                $dt = new DateTime('now');
                $date = $dt->format('Y.m.d');
                $mailtemplate = str_replace('[currentDate]', $name, $mailtemplate);
                $mailtemplate = str_replace('[Name]', $name, $mailtemplate);
				$mailtemplate = str_replace('[Email]', $email, $mailtemplate);
				$mailtemplate = str_replace('[voucherCode]', $voucherCode, $mailtemplate);
				$mailtemplate = str_replace('[voucherDescription]', $voucherDescription, $mailtemplate);
				$mailtemplate = str_replace('[voucherAmount]', $voucherAmount, $mailtemplate);
				$mailtemplate = str_replace('[voucherPercent]', $voucherPercent, $mailtemplate);
				$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
				
				$data['mailtemplate'] = $mailtemplate;
                $this->load->view('generate_pdf', $data);


                            
            }
        }
            

    }

}