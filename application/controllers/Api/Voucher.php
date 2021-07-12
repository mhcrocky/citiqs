<?php

// use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/phpqrcode/qrlib.php';
require APPPATH . 'libraries/REST_Controller.php';

class Voucher extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('utility_helper');
		$this->load->helper('email_helper');
        $this->load->helper('validate_data_helper');
        $this->load->model('vouchersend_model');
        $this->load->model('shopvoucher_model');
        $this->load->model('shopproduct_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function create_post()
    {
        $data = $this->input->post(null, true);
        $numOfCodes = isset($data['codes']) ? intval($data['codes']) : 0;
        $status = $data['status'];
        unset($data['codes']);
        unset($data['status']);
        if(empty($data['productId'])){
            unset($data['productId']);
        }
        $data_keys = array_keys($data);
        $voucher_fields = ['vendorId', 'percentUsed', 'expire'];
        $error = false;
        $error_message = '';

        foreach($voucher_fields as $voucher_field){
            if(!in_array('vendorId', $data_keys)) {
                $error = true;
                $error_message = 'Vendor ID is required!';
                break;
            }
            if(!in_array($voucher_field, $data_keys)){
                $error = true;
                $error_message = 'All fields are required!';
                break;
            }
        }
        

        if($error){
            $response = [
                'status' => "error",
                'message' => $error_message,
            ];
            $this->set_response($response, 400);
            return ;
        }

        $fileRelaitvePath = 'assets/csv/' . $data['vendorId'] . '_' . time() . '.csv';
        // $fileLocation = base_url() . $fileRelaitvePath;
        $csvFile = FCPATH . $fileRelaitvePath;
        $csvFile = fopen($csvFile, 'w');
        $firstLine = null;       
        $data['numberOfTimes'] = $numOfCodes;
        $data['startAmount'] = $data['amount'];
        // $dataMultiple = [];
        if($status != 'unique'){
            
            if ($this->shopvoucher_model->setObjectFromArray($data)->create()) {
                if (is_null($firstLine)) {
                    $firstLine = array_keys($data);
                    fputcsv($csvFile, $firstLine, ';');
                }

                $dataToScv = array_values($data);
                fputcsv($csvFile, $dataToScv, ';');

                $numOfCodes--;
                $response = [
                    'status' => "success",
                    'message' => "The voucher is created successfully!",
                ];
                $this->set_response($response, 201);
                fclose($csvFile);
                return;
            } else { 
                $response = [
                'status' => "error",
                'message' => "Something went wrong! Check is voucher code unique",
                ];
                $this->set_response($response, 400);
                return;
            }

        }

        $data['numberOfTimes'] = 1;

        while ($numOfCodes > 0) {
            $data['code'] = Utility_helper::shuffleStringSmallCaps(6);
            if ($this->shopvoucher_model->setObjectFromArray($data)->create()) {
                if (is_null($firstLine)) {
                    $firstLine = array_keys($data);
                    fputcsv($csvFile, $firstLine, ';');
                }

                $dataToScv = array_values($data);
                fputcsv($csvFile, $dataToScv, ';');

                $numOfCodes--;
            } else { 
                $response = [
                'status' => "error",
                'message' => "Something went wrong!",
                ];
                $this->set_response($response, 400);
                return;
            }
        }

        fclose($csvFile);

        $response = [
            'status' => "success",
            'message' => "The vouchers are created successfully!",
        ];

        $this->set_response($response, 201);
        return;
        
    }

    public function vouchers_get()
    {
        $vendorId = $this->session->userdata('userId');
        $what = ['*'];
		$where = ["vendorId" => $vendorId];
        $results = $this->shopvoucher_model->read($what,$where);
        $vouchers = ($results == null) ? [] : $results;
        echo json_encode($vouchers);
    }

    public function email_templates_get()
    {
        $vendorId = $this->session->userdata('userId');
        $this->load->model('email_templates_model');
		$emails = $this->email_templates_model->get_voucher_email_by_user($vendorId);
        echo json_encode($emails);
    }


    public function create_vouchersend_post()
    {
        $data = $this->input->post(null, true);
        $data['email'] = urldecode($data['email']);
        $what = ['*'];
		$where = ["id" => $data['voucherId']];
        $voucher = $this->shopvoucher_model->read($what,$where);
        $data['send'] = $this->emailSend($data['name'], $data['email'], $voucher[0], $data['voucherId']);
        if ($this->vouchersend_model->setObjectFromArray($data)->create()) {
            if($data['send'] == 1){
                $voucherused = intval($voucher[0]['voucherused'])+1;
                $this->shopvoucher_model->setProperty('voucherused', $voucherused)->customUpdate($where);
            }
            $response = [
                'status' => "success",
                'message' => "Voucher is sent successfully!",
            ];
    
            $this->set_response($response, 201);
            return;
        }


        $response = [
            'status' => "error",
            'message' => "Something went wrong!",
        ];

        $this->set_response($response, 201);
        return;


    }

    public function vouchersend_email_post()
    {
        $data = $this->input->post(null, true);
        $data['email'] = urldecode($data['email']);
        $what = ['*'];
		$where = ["id" => $data['voucherId']];
        $voucher = $this->shopvoucher_model->read($what,$where);
        $voucher = isset($voucher[0]) ? $voucher[0] : [];
        $send = $this->emailSend($data['name'], $data['email'], $voucher, $data['voucherId']);
        if ($send == 1) {
            if($data['send'] == 0){
                $updateWhere = ["id" => $data['id']];
                $this->vouchersend_model->setProperty('send', 1)->customUpdate($where);
            }
            $response = [
                'status' => "success",
                'message' => "Voucher is sent successfully!",
            ];
    
            $this->set_response($response, 201);
            return;
        }
        

        $response = [
            'status' => "error",
            'message' => "Something went wrong!",
        ];

        $this->set_response($response, 201);
        return;


    }

    public function multiple_create_vouchersend_post()
    {
        $data = $this->input->post(null, true);
        $email = urldecode($data['email']);
        $name = $data['name'];
        $voucherIds = json_decode($this->input->post('voucherIds'));
        $vendorId = $this->session->userdata('userId');
        $what = ['*'];
		$where = ["vendorId" => $vendorId, "voucherused < numberOfTimes"];
        $results = $this->shopvoucher_model->read($what,$where, [], "where_in", ['id', $voucherIds]);
        $vouchers = ($results == null) ? [] : $results;
        $mailsend = 0;
        if(count($vouchers)){
            foreach($vouchers as $voucher){
                $send = $this->emailSend($name, $email, $voucher, $voucher['id']);

                $vouchersendData = [
                    'name' => $name,
                    'email' => $email,
                    'send' => $send,
                    'voucherId' => $voucher['id']
                ];

                if ($this->vouchersend_model->setObjectFromArray($vouchersendData)->create()) {
                    if($send == 1){
                        $mailsend = 1;
                        $voucherused = intval($voucher['voucherused'])+1;
                        $whereVoucher = [
                            "vendorId" => $vendorId,
                            "id" => $voucher['id']
                        ];
                        $this->shopvoucher_model->setProperty('voucherused', $voucherused)->customUpdate($whereVoucher);
                    }
                    
                }
            }
        }
        
        if($mailsend == 1) {
            $response = [
                'status' => "success",
                'message' => "The vouchers are send successfully!",
            ];
    
            $this->set_response($response, 201);
            return;
        }


        $response = [
            'status' => "error",
            'message' => "Something went wrong!",
        ];

        $this->set_response($response, 201);
        return;
        


    }

    public function vouchersend_get()
    {
        $vendorId = $this->session->userdata('userId');
        $what = ['*'];
		$where = ["vendorId" => $vendorId];
        $join = [
			0 => [
				'tbl_shop_voucher',
				'tbl_vouchersend.voucherId = tbl_shop_voucher.id',
				'left',
			]
		];
		$what = ['tbl_vouchersend.id, numberOfTimes, name, email, send, datecreated, code, description, voucherId'];
		$where = ["tbl_shop_voucher.vendorId" => $vendorId];
			
        $results = $this->vouchersend_model->read($what,$where, $join, 'group_by', ['tbl_vouchersend.id']);

        $vouchersend = ($results == null) ? [] : $results;
        echo json_encode($vouchersend);
    }

    public function multiple_actions_post()
    {
        $vendorId = $this->session->userdata('userId');
        $action = $this->input->post('action');
        $ids = json_decode($this->input->post('ids'));
        $value = $this->input->post('value');
        $where = ["vendorId" => $vendorId];
        if($action == 'update_activated'){
            if($this->shopvoucher_model->setProperty('activated', $value)->multipleUpdate($ids, $where)){
                $response = [
                    'status' => "success",
                    'message' => "Updated successfully!",
                ];
                $this->set_response($response, 201);
                return ;
            }
            $response = [
                'status' => "error",
                'message' => "Something went wrong!",
            ];
            $this->set_response($response, 400);
            return ;
        } else if($action == 'update_emailId'){
            if($this->shopvoucher_model->setProperty('emailId', $value)->multipleUpdate($ids, $where)){
                $response = [
                    'status' => "success",
                    'message' => "Updated successfully!",
                ];
                $this->set_response($response, 201);
                return ;
            }
            $response = [
                'status' => "error",
                'message' => "Something went wrong!",
            ];
            $this->set_response($response, 400);
            return ;
        } else if($action == 'delete'){
            $where['voucherused'] = 0;
            if($this->shopvoucher_model->multipleDelete($ids, $where)){
                $response = [
                    'status' => "success",
                    'message' => "Deleted successfully!",
                ];
                $this->set_response($response, 201);
                return ;
            }
            $response = [
                'status' => "error",
                'message' => "Something went wrong!",
            ];
            $this->set_response($response, 400);
            return ;
        }

        return ;
    }

    public function voucher_activated_post()
    {
        $vendorId = $this->session->userdata('userId');
        $id = $this->input->post('id');
        $activated = $this->input->post('activated');
        $data = ['activated' => $activated];
		$where = ["id" => $id];
        if($this->shopvoucher_model->setProperty('activated', $activated)->customUpdate($where)){
            $response = [
                'status' => "success",
                'message' => "Updated successfully!",
            ];
            $this->set_response($response, 201);
            return ;
        }
        $response = [
            'status' => "error",
            'message' => "Something went wrong!",
        ];
        $this->set_response($response, 400);
        return ;
    }

    public function update_email_template_post()
    {
        $vendorId = $this->session->userdata('userId');
        $id = $this->input->post('id');
        $emailId = $this->input->post('emailId');
		$where = ["id" => $id, "vendorId" => $vendorId];
        if($this->shopvoucher_model->setProperty('emailId', $emailId)->customUpdate($where)){
            $response = [
                'status' => "success",
                'message' => "Updated successfully!",
            ];
            $this->set_response($response, 201);
            return ;
        }
        $response = [
            'status' => "error",
            'message' => "Something went wrong!",
        ];
        $this->set_response($response, 400);
        return ;
    }

    public function upload_csv_post()
    {
		$this->load->library('form_validation');
		$vendorId = $this->session->userdata('userId');

		$config['upload_path']   = FCPATH.'assets/csv';
        $config['allowed_types'] = 'csv';
        $config['max_size']      = '102400'; // 102400 100mb
		$config['file_name']     = $this->input->post('filename');
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('userfile')) {
			$errors   = $this->upload->display_errors('', '');
			var_dump($errors);
		} else {
		    $upload_data = $this->upload->data();
		    $file_name = $upload_data['file_name'];
			$i = 0;
			$file = fopen(FCPATH."assets/csv/".$file_name,"r");
			$key = 0;
			$data = [];
			$headers = [];
			$vouchers = [];
			$start_key = 0;

			while (($row = fgets($file)) !== FALSE) {
				//$data[] = $row;
				if ((strpos($row, ';') || strpos($row, ',')) !== false) {
					$results = (strpos($row, ';') !== false) ? explode(';',$row) : explode(',',$row);
					$voucher = [];
					foreach($results as $key => $result){
						if($i == 0){
							if($result == '' || empty($result)){ continue;}
							$headers[$key] = $result;
							$start_key = $key;
						} else {
							if(!isset($headers[$key])){ continue;}
							$voucher[$headers[$key]] = $result;
						}
		
					}
					$i++;
					$vouchers[] = $voucher;
				}
				
			}


			$count = count($headers);
			$headers[$count] = FCPATH."assets/csv/".$file_name;
			echo json_encode($headers);
			fclose($file);
			//unlink(FCPATH."assets/csv/".$file_name);

				
		}



		
	}

	public function import_csv_post()
    {
		$fields = $this->input->post(null, true);
        $vendorId = $this->session->userdata('userId');
		$file_path = urldecode($fields['csv_path']);
		unset($fields['csv_path']);
		$vouchers = [];
		$file = fopen($file_path, "r");
		$i = 0;

		while (($row = fgets($file)) !== FALSE) {
			
			if ((strpos($row, ';') || strpos($row, ',')) !== false) {
				$results = (strpos($row, ';') !== false) ? explode(';',$row) : explode(',',$row);

				$vouchers[] = [
                    'vendorId' => $vendorId,
					'code' => str_replace('"', '', $results[$fields['code']]),
					'description' => str_replace('"', '', $results[$fields['description']]),
					'amount' => str_replace('"', '', $results[$fields['amount']]),
					'percent' => str_replace('"', '', $results[$fields['percent']]),
					'percentUsed' => isset($results[$fields['percentUsed']]) ? str_replace('"', '', $results[$fields['percentUsed']]) : 0,
					'expire' => isset($results[$fields['expire']]) ? str_replace('"', '', $results[$fields['expire']]) : date('Y-m-d'),
					'active' => isset($results[$fields['active']]) ? str_replace('"', '', $results[$fields['active']]) : 0,
					'numberOfTimes' => isset($results[$fields['numberOfTimes']]) ? str_replace('"', '', $results[$fields['numberOfTimes']]) : 1,
					'activated' => isset($results[$fields['activated']]) ? str_replace('"', '', $results[$fields['activated']]) : 0,
					'productId' => isset($results[$fields['productId']]) ? str_replace('"', '', $results[$fields['productId']]) : '',
					'emailId' => isset($results[$fields['emailId']]) ? str_replace('"', '', $results[$fields['emailId']]) : ''
				];
			}
				
		}

		unlink($file_path);
		return $this->shopvoucher_model->multipleCreate($vouchers);
	}
 
    public function data_get()
    {
        $data = $this->input->get(null, true);
        $numOfCodes = isset($data['codes']) ? intval($data['codes']) : 0;

        // check numer of codes
        if ($numOfCodes <= 0) {
            $response = [
                'status' => "false",
                'message' => 'Number of voucher must be greater than 0',
            ];
            $this->set_response($response, 201);
            return;
        }

        // check amount and percent
        if (
                (isset($data['amount']) && isset($data['percent']))
                || (empty($data['amount']) && empty($data['percent']))
        ) {
            $response = [
                'status' => "false",
                'message' => 'Amount or percent must be set. Only one of them',
            ];
            $this->set_response($response, 201);
            return;
        }

        // check product id, is this product on products list of this vendor
        if (isset($data['productId'])) {
            $productId = intval($data['productId']);
            $vendorId = intval($data['vendorId']);
            if (!$this->shopproduct_model->checkProduct($productId, $vendorId)) {
                $response = [
                    'status' => "false",
                    'message' => 'Invalid product id. Product is not on products list of this vendor',
                ];
                $this->set_response($response, 201);
                return;
            }
        }

        $data['active'] = '1';
        $data['percentUsed'] = '0';

        $fileRelaitvePath = 'assets/csv/' . $data['vendorId'] . '_' . time() . '.csv';
        $fileLocation = base_url() . $fileRelaitvePath;
        $csvFile = FCPATH . $fileRelaitvePath;
        $csvFile = fopen($csvFile, 'w');
        $firstLine = null;       

        while ($numOfCodes > 0) {
            $data['code'] = Utility_helper::shuffleStringSmallCaps(6);

            if (!$this->shopvoucher_model->insertValidate($data)) {
                $response = [
                    'status' => "false",
                    'message' => 'Process failed',
                ];
                $this->set_response($response, 201);
                return;
            }; 

            if ($this->shopvoucher_model->setObjectFromArray($data)->create()) {
                if (is_null($firstLine)) {
                    $firstLine = array_keys($data);
                    fputcsv($csvFile, $firstLine, ';');
                }

                $dataToScv = array_values($data);
                fputcsv($csvFile, $dataToScv, ';');

                $numOfCodes--;
            }
        }

        fclose($csvFile);
        redirect($fileLocation);
    }


    private function emailSend($name, $email, $data, $voucherId)
	{
        $mailsend = 0;
        $qrtext = $data['code'];
        $voucherCode = $data['code'];
        $voucherDescription = $data['description'];
        $voucherAmount = $data['amount'];
        $voucherPercent = $data['percent'];
        $file = FCPATH . '/uploads/qrcodes/';
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
        QRcode::png($text, $file_name);

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

                        
		if($data['emailId']) {
            $this->load->model('email_templates_model');
            $emailTemplate = $this->email_templates_model->get_emails_by_id($data['emailId']);
            $this->config->load('custom');
            $mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$data['vendorId'].'/'.$emailTemplate->template_file .'.'.$this->config->item('template_extension'));
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
				$subject = strip_tags($emailTemplate->template_subject);
                $subject = str_replace('[Name]',$name, $subject);
				$subject = str_replace('[Email]', $email, $subject);
				$subject = str_replace('[voucherCode]', $voucherCode,$subject);
				$subject = str_replace('[voucherDescription]', $voucherDescription, $subject);
				$subject = str_replace('[voucherAmount]', $voucherAmount,$subject );
				$subject = str_replace('[voucherPercent]', $voucherPercent, $subject);
                $mailtemplate .= '<div style="width:100%;text-align:center;margin-top: 30px;">';
                $download_pdf_link = base_url() . "voucher/pdf/" . $voucherId . "/?name=" . urlencode($name) ."&email=". urlencode($email);
                $mailtemplate .= '<a href="'.$download_pdf_link.'" id="pdfDownload" style="background-color:#008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;">Download as PDF</a>';
                $mailtemplate .= '</div>';
				$mailsend = 1;
//				$this->sendEmail("pnroos@icloud.com", $subject, $mailtemplate);
				if(Email_helper::sendEmail($email, $subject, $mailtemplate, false)) {
                    $mailsend = 1;
                }
                            
            }
        }
            
        return $mailsend;
            

    }
    



//    private function sendEmail($email, $subject, $message)
//	{
//		$configemail = array(
//			'protocol' => PROTOCOL,
//			'smtp_host' => SMTP_HOST,
//			'smtp_port' => SMTP_PORT,
//			'smtp_user' => SMTP_USER, // change it to yours
//			'smtp_pass' => SMTP_PASS, // change it to yours
//			'mailtype' => 'html',
//			'charset' => 'iso-8859-1',
//			'smtp_crypto' => 'tls',
//			'wordwrap' => TRUE,
//			'newline' => "\r\n"
//		);
//
//		$config = $configemail;
//		$CI =& get_instance();
//		$CI->load->library('email', $config);
//		$CI->email->set_header('X-SES-CONFIGURATION-SET', 'ConfigSet');
//		$CI->email->set_newline("\r\n");
//		$CI->email->from('support@tiqs.com');
//		$CI->email->to($email);
//		$CI->email->subject($subject);
//		$CI->email->message($message);
//		return $CI->email->send();
//    }

    public function createAndSendVoucher_post(): void
    {
        $data = $this->input->post(null, true);
        $data['email'] = urldecode($data['email']);
        $what = ['*'];
        $voucherIds = [];
        $response = [];

        (is_array($data['voucherId'])) ? $voucherIds = $data['voucherId'] : array_push($voucherIds, $data['voucherId']);

        foreach($voucherIds as $voucherId ) {
            $where = ["id" => $voucherId];
            $voucher = $this->shopvoucher_model->read($what,$where);
            $data['send'] = $this->emailSend($data['name'], $data['email'], $voucher, $voucherId);
            $data['voucherId'] = $voucherId;
            if ($this->vouchersend_model->setObjectFromArray($data)->create()) {
                if($data['send'] == 1){
                    $voucherused = intval($voucher[0]['voucherused'])+1;
                    $this->shopvoucher_model->setProperty('voucherused', $voucherused)->customUpdate($where);
                    if (empty($response['success'])) {
                        $response['success'] = [
                            'status' => '1',
                            'messages' => ['Voucher(s) sent'],
                            'ids' => []
                        ];
                    }
                    array_push($response['success']['ids'], $voucherId);
                } else {
                    if (empty($response['failed'])) {
                        $response['failed'] = [
                            'status' => 0,
                            'messages' => []
                        ];
                    }
                    $message = 'Voucher with id "' . $voucherId . '" is not sent to given email';
                    array_push($response['failed']['messages'], $message);
                }                
            }
        }

		

        echo json_encode($response);
        return;
    }

}
