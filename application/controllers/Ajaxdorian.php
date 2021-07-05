<?php
declare(strict_types=1);

ini_set('memory_limit', '256M');

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ajaxdorian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('label_model');
        $this->load->model('user_model');
        $this->load->model('appointment_model');
        $this->load->model('uniquecode_model');
        $this->load->model('user_subscription_model');
        $this->load->model('dhl_model');
        $this->load->model('Bizdir_model');
        $this->load->model('floorplanareas_model');
        $this->load->model('floorplandetails_model');
        $this->load->model('shoporder_model');
        $this->load->model('shopspot_model');
        $this->load->model('shopcategory_model');
        $this->load->model('shopspotproduct_model');
        $this->load->model('shopproductex_model');
        $this->load->model('shopvendor_model');
        $this->load->model('shopvoucher_model');
        $this->load->model('shopsession_model');
        $this->load->model('email_templates_model');
        $this->load->model('email_templates_model');
        $this->load->model('bookandpay_model');
        $this->load->model('bookandpayagendabooking_model');
        $this->load->model('bookandpayspot_model');
        $this->load->model('bookandpaytimeslots_model');

        $this->load->helper('cookie');
        $this->load->helper('validation_helper');
        $this->load->helper('utility_helper');
        $this->load->helper('email_helper');
        $this->load->helper('google_helper');
        $this->load->helper('perfex_helper');
        $this->load->helper('curl_helper');
        $this->load->helper('dhl_helper');
        
        

        $this->load->library('session');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('form_validation');

        $this->load->config('custom');
    }

    
    public function getPlaceByLocation(){
        $location = $this->input->post('location');
        $range = $this->input->post('range');

//        var_dump($location);
//        die();

        set_cookie('location', $location, (365 * 24 * 60 * 60));
        set_cookie('range', $range, (365 * 24 * 60 * 60));
        $coordinates = Google_helper::getLatLong($location);
        $lat = $coordinates['lat'];
        $long = $coordinates['long'];
        $data['directories'] = $this->Bizdir_model->get_bizdir_by_location(floatval($lat),floatval($long),$range);
        $result = $this->load->view('bizdir/place_card', $data,true);
        if( isset($result) ) {
            return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
            ->set_output(json_encode($result));
        } else {
            return $this->output
			->set_content_type('application/json')
			->set_status_header(500)
			->set_output(json_encode(array(
                'text' => 'Not Found',
                'type' => 'Error 404'
            )));
        }
		
    }

    public function saveEmailTemplate  () {
        if (!$this->input->is_ajax_request()) return;
        $user_id = $this->input->post('user_id');
        $html = $this->input->post('html');
        $html = str_replace(base_url() . 'assets/images/qrcode_preview.png',"[QRlink]",$html);
        $dir = FCPATH.'assets/email_templates/'.$user_id;
		if (!is_dir($dir)) {
			mkdir($dir, 0777, TRUE);
		}

		$clear_name = mb_strtolower(preg_replace('/[^ a-z\d]/ui', '', $this->input->post('template_name')));
		$filename = $clear_name.time().'.html';
        $filepath = $dir.''.$filename;
        if (!write_file($filepath, $html) )
		{
			$msg = 'Unable to write the file';
			$status = 'error';
		} else {
            echo base_url("assets/email_templates/$filename");
        }
		
	}

	public function saveEmailTemplateSource () {
		if (!$this->input->is_ajax_request()) return;

		$user_id = $this->input->post('user_id');
        $html = $this->input->post('html');
        $html = str_replace(base_url() . 'assets/images/qrcode_preview.png',"[QRlink]",$html);

		$dir = FCPATH.'assets/email_templates/'.$user_id;
		if (!is_dir($dir)) {
			mkdir($dir, 0777, TRUE);
		}

		$clear_name = mb_strtolower(preg_replace('/[^ a-z\d]/ui', '', $this->input->post('template_name')));
		$filename = $clear_name.time().'.html';
        $filepath = $dir.'/'.$filename;
        

        if($this->email_templates_model->check_template_exists($this->input->post('template_name'),$user_id))
        {
            $template_id = $this->email_templates_model->get_emails_by_name($this->input->post('template_name'));
        } else {
            $template_id = $this->input->post('template_id');
        }

		if ($template_id && $template_id != 'false') {
			$email_template = $this->email_templates_model->get_emails_by_id($template_id);
            $filename = $email_template->template_file;
            $filepath = $dir.'/'.$filename;
		}

		$data = [
			'user_id' => $user_id,
			'template_file' => $filename,
			'template_name' => $this->input->post('template_name')
		];

		if (!write_file($filepath, $html) )
		{
			$msg = 'Unable to write the file';
			$status = 'error';
		}
		else
		{
			if ($template_id && $template_id != 'false') {
				$result = $this->email_templates_model->update_email_template($data, $template_id);
			} else {
				$result = $this->email_templates_model->add_email_template($data);
			}
			if ($result) {
				$msg = "Email saved";
				$status = 'success';
			} else {
				$msg = 'Email not saved in db';
				$status = 'error';
			}

		}

		echo json_encode(array('msg' => $msg, 'status' =>$status));
    }
    
    public function check_template_exists () {
        $userId = $this->session->userdata('userId');
		if($this->email_templates_model->check_template_exists($this->input->post('template_name'),$userId))
        {
            echo 'true';
        } else {
            echo 'false';
        }
    }
    
    public function delete_email_template () {
		$email_id = $this->input->post('email_id');

		if ($this->email_templates_model->deleteEmail($email_id)) {
			$msg = 'Email template deleted!';
			$status = 'success';
		} else {
			$msg = 'Something goes wrong!';
			$status = 'error';
		}
		echo json_encode(array('msg' => $msg, 'status' =>$status));
    }

    public function saveAgenda () {
        //if (!$this->input->is_ajax_request()) return;

        $agendaImgDeleted = $this->input->post("imgDeleted");
        $imgName = '';
        if($agendaImgDeleted == 1){
            unlink(FCPATH . 'assets/home/images/'. $this->input->post('oldImage'));
        } else {
            $imgName = $this->input->post('oldImage');
        }

        $config['upload_path']   = FCPATH . 'assets/home/images/';
        $config['allowed_types'] = 'jpg|png|jpeg|webp|bmp';
        $config['max_size']      = '102400'; // 102400 100mb
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('agendaImage')) {
            $errors   = $this->upload->display_errors('', '');
            //var_dump($errors);
        } else {
            $upload_data = $this->upload->data();;
			$imgName = $upload_data['file_name'];
            if(!empty($this->input->post('oldImage')) && $this->input->post('oldImage') != 'undefined'){
                unlink(FCPATH . 'assets/home/images/'. $this->input->post('oldImage'));
            }
            

        }


        $backgroundImgDeleted = $this->input->post("backgroundImgDeleted");
        $backgroundImgName = '';
        if($backgroundImgDeleted == 1){
            unlink(FCPATH . 'assets/home/images/'. $this->input->post('backgroundOldImage'));
        } else {
            $backgroundImgName = $this->input->post('backgroundOldImage');
        }

        $config['upload_path']   = FCPATH . 'assets/home/images/';
        $config['allowed_types'] = 'jpg|png|jpeg|webp|bmp';
        $config['max_size']      = '102400'; // 102400 100mb
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('backgroundImage')) {
            $errors   = $this->upload->display_errors('', '');
            //var_dump($errors);
        } else {
            $upload_data = $this->upload->data();;
			$backgroundImgName = $upload_data['file_name'];
            if(!empty($this->input->post('backgroundOldImage')) && $this->input->post('backgroundOldImage') != 'undefined' ){
                unlink(FCPATH . 'assets/home/images/'. $this->input->post('backgroundOldImage'));
            }
            

        }



        $agendData = [
            'ReservationDescription' => $this->input->post('ReservationDescription'),
            'ReservationDateTime' => date("Y-m-d H:i:s", strtotime($this->input->post('ReservationDateTime'))),
            'Background' => $this->input->post('Background'),
            'Customer' => $this->session->userdata('userId'),
            'email_id' => $this->input->post('email_id'),
            'online' => intval($this->input->post('online')),
            'agendaImage' => ($imgName == null || $imgName == 'undefined') ? '' : $imgName,
            'backgroundImage' => ($backgroundImgName == null || $backgroundImgName == 'undefined') ? '' : $backgroundImgName,
            'max_spots' => intval($this->input->post('max_spots')),
            'voucherId' => $this->input->post('voucherId')
        ];

        $agenda_id = $this->input->post('id');

        if ($agenda_id) {
            $this->bookandpayagendabooking_model->updateAgenda($agendData, $agenda_id);
        } else {
            $agenda_id = $this->bookandpayagendabooking_model->addAgenda($agendData);
            if(!empty($this->input->post('agendas')) && $this->input->post('agendas')  != 'null' && $this->input->post('agendas')  != null){
                
                $agendas = $this->input->post('agendas');
                $this->bookandpayagendabooking_model->copy_from_agenda($agendas,$agenda_id);
            } 
        }

        if ($agenda_id) {
            $agenda = $this->bookandpayagendabooking_model->getBookingAgendaById($agenda_id);
            $msg = 'Agenda saved!';
            $status = 'success';
            $data = $agenda;
        } else {
            $msg = 'Something goes wrong!';
            $status = 'error';
        }
        echo json_encode(array('msg' => $msg, 'status' =>$status, 'data' => $data));
    }

    public function deleteAgenda () {
        //if (!$this->input->is_ajax_request()) return;
        $agenda_id = $this->input->post('agenda_id');

        if ($this->bookandpayagendabooking_model->deleteAgenda($agenda_id)) {
            $msg = 'Agenda deleted!';
            $status = 'success';
        } else {
            $msg = 'Something goes wrong!';
            $status = 'error';
        }
        echo json_encode(array('msg' => $msg, 'status' =>$status));
    }

    public function saveTermsofuse () {
        $body = $this->input->post('content');
        if ($this->bookandpayagendabooking_model->updateTermsofuse($body)) {
            $msg = 'Terms of use updated successfully!';
            $status = 'success';
        } else {
            $msg = 'Something went wrong!';
            $status = 'error';
        }
        echo json_encode(array('msg' => $msg, 'status' =>$status));
    }


    public function saveAgendaSpot () {
        //if (!$this->input->is_ajax_request()) return;
        $imgChanged = $this->input->post("imgChanged");
        $imgDeleted = $this->input->post("imgDeleted");
        $imgName = '';
        if($imgDeleted == 1){
            unlink(FCPATH . 'assets/home/images/'. $this->input->post('oldImage'));
        } else if($imgChanged != 'true') {
            $imgName = $this->input->post('oldImage');
        }
        $config['upload_path']   = FCPATH . 'assets/home/images/';
        $config['allowed_types'] = 'jpg|png|jpeg|webp|bmp';
        $config['max_size']      = '102400'; // 102400 100mb
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $errors   = $this->upload->display_errors('', '');
            //var_dump($errors);
        } else {
            $upload_data = $this->upload->data();;
			$imgName = $upload_data['file_name'];
            if(!empty($this->input->post('oldImage')) && $this->input->post('oldImage') != 'undefined'){
                unlink(FCPATH . 'assets/home/images/'. $this->input->post('oldImage'));
            }
            

        } 

        $spotData = [
            'descript' => $this->input->post('descript'),
            'soldoutdescript' => $this->input->post('soldoutdescript'),
            'pricingdescript' => $this->input->post('pricingdescript'),
            'feedescript' => $this->input->post('feedescript'),
            'available_items' => $this->input->post('available_items'),
            'numberofpersons' => $this->input->post('numberofpersons'),
            'sort_order' => $this->input->post('sort_order'),
            'price' => $this->input->post('price'),
            'image' => ($imgName == null || $imgName == 'undefined') ? '' : $imgName,
            'maxBooking' => $this->input->post('maxBooking'),
            'background_color' => $this->input->post('background_color'),
            'send_to_email' => $this->input->post('send_to_email'),
            'spot_email' => $this->input->post('spot_email'),
            'agenda_id' => $this->input->post('agenda_id'),
            'email_id' => $this->input->post('email_id'),
            'spotLabelId' => $this->input->post('spotLabelId'),
            'voucherId' => $this->input->post('voucherId')
        ];

        $spot_id = $this->input->post('id');
        $max_spots = $this->bookandpayagendabooking_model->get_max_spots($spotData['agenda_id']);
        $spots_count = $this->bookandpayagendabooking_model->get_spot_count_by_agenda($spotData['agenda_id']);
        if($spots_count >= $max_spots){
            $msg = 'You have reached the maximum spots number!';
            $status = 'error';
            echo json_encode(array('msg' => $msg, 'status' =>$status, 'data' => ''));
            return ;
        }

        if ($spot_id) {
            $this->bookandpayspot_model->updateSpot($spotData, $spot_id);
        } else {
            $spotData['send_to_email'] = empty($spotData['send_to_email']) ? '0' : $spotData['send_to_email'];
            $spot_id = $this->bookandpayspot_model->addSpot($spotData);
            if(!empty($this->input->post('spots')) && $this->input->post('spots')  != 'null' && $this->input->post('spots')  != null){
                
                $oldspotIds = explode(',', $this->input->post('spots'));

                foreach($oldspotIds as $oldspotId){
                    $this->bookandpayagendabooking_model->copy_timeslots($oldspotId,$spot_id);
                }

            } 
        };

        $spot = $this->bookandpayspot_model->getSpot($spot_id);

        $data = '';

        if ($spot) {
            $msg = 'Spot saved!';
            $status = 'success';
            $data = $spot;
        } else {
            $msg = 'Something goes wrong!';
            $status = 'error';
        }
        echo json_encode(array('msg' => $msg, 'status' =>$status, 'data' => $data));
    }

    public function deleteSpot () {
        //if (!$this->input->is_ajax_request()) return;
        $spot_id = $this->input->post('id');

        if ($this->bookandpayspot_model->deleteSpot($spot_id)) {
            $msg = 'Spot deleted!';
            $status = 'success';
        } else {
            $msg = 'Something goes wrong!';
            $status = 'error';
        }
        echo json_encode(array('msg' => $msg, 'status' =>$status));
    }

    public function saveTimeSLot () {
        //if (!$this->input->is_ajax_request()) return;
        $duration = $this->convertToHoursMins($this->input->post('duration'));
        $overflow = $this->convertToHoursMins($this->input->post('overflow'));
        $spotData = [
            'timeslotdescript' => $this->input->post('timeslotdescript'),
            'available_items' => $this->input->post('available_items'),
            'fromtime' => date("H:i:s", strtotime($this->input->post('fromtime'))),
            'totime' => date("H:i:s", strtotime($this->input->post('totime'))),
            'multiple_timeslots' => $this->input->post('multiple_timeslots'),
            'duration' => $duration,
            'overflow' => $overflow,
            'price' => $this->input->post('price'),
            'reservationFee' => $this->input->post('reservationFee'),
            'spot_id' => $this->input->post('spot_id'),
            'email_id' => $this->input->post('email_id'),
            'voucherId' => $this->input->post('voucherId')
        ];

        $timeslot_id = $this->input->post('id');

        if ($timeslot_id) {
            $this->bookandpaytimeslots_model->updateTimeSLot($spotData, $timeslot_id);
        } else {
            $timeslot_id = $this->bookandpaytimeslots_model->addTimeSLot($spotData);
        };

        $timeslot = $this->bookandpaytimeslots_model->getTimeSLot($timeslot_id);
        $data = '';

        if ($timeslot) {
            $msg = 'Time Slot saved!';
            $status = 'success';
            $data = $timeslot;
        } else {
            $msg = 'Something goes wrong!';
            $status = 'error';
        }
        echo json_encode(array('msg' => $msg, 'status' =>$status, 'data' => $data));
    }

    function convertToHoursMins($time, $format = '%02d:%02d') {
        if(!is_numeric($time)){
            return $time;
        }
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    public function deleteTimeSlot () {
        //if (!$this->input->is_ajax_request()) return;
        $spot_id = $this->input->post('id');

        if ($this->bookandpaytimeslots_model->deleteTimeSLot($spot_id)) {
            $msg = 'Time Slot deleted!';
            $status = 'success';
        } else {
            $msg = 'Something goes wrong!';
            $status = 'error';
        }
        echo json_encode(array('msg' => $msg, 'status' =>$status));
    }

    public function testingemail()
	{
        $email = $this->input->post('email');
        $mailtemplate = $this->input->post('html');
        $customer = $this->session->userdata('userId');
		$eventid = 1;
		$reservationId = 1;
		$spotId = 1;
		$price = 60;
		$Spotlabel = 1;
		$numberofpersons = 4;
		$name = 'Test';
		$mobile = '0123456789';
		$reservationset = '1';
        $fromtime = '09:00 AM';
		$totime = '01:00 PM';
        $paid = 1;
        $timeSlotId = 1;
        $voucher = "TESTWALLET";
        $TransactionId = "TESTTRANSACTIONID";
        $qrlink = base_url()."assets/images/qrcode_preview.png";
                        
		$mailtemplate = str_replace('[customer]', $customer, $mailtemplate);
		$mailtemplate = str_replace('[eventdate]', date('d.m.yy'), $mailtemplate);
		$mailtemplate = str_replace('[reservationId]', $reservationId, $mailtemplate);
		$mailtemplate = str_replace('[SpotId]', $spotId, $mailtemplate);
		$mailtemplate = str_replace('[price]', $price, $mailtemplate);
		$mailtemplate = str_replace('[spotlabel]', $Spotlabel, $mailtemplate);
		$mailtemplate = str_replace('[numberofpersons]', $numberofpersons, $mailtemplate);
		$mailtemplate = str_replace('[name]', $name, $mailtemplate);
		$mailtemplate = str_replace('[email]', $email, $mailtemplate);
		$mailtemplate = str_replace('[mobile]', $mobile, $mailtemplate);
		$mailtemplate = str_replace('[fromtime]', $fromtime, $mailtemplate);
		$mailtemplate = str_replace('[totime]', $totime, $mailtemplate);
		$mailtemplate = str_replace('[timeslot]', $timeSlotId, $mailtemplate);
		$mailtemplate = str_replace('[TransactionId]', $TransactionId, $mailtemplate);
        $mailtemplate = str_replace('[WalletCode]', $voucher, $mailtemplate);
        $mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
		$mailtemplate = str_replace('Image', '', $mailtemplate);
        $mailtemplate = str_replace('Text', '', $mailtemplate);
        $mailtemplate = str_replace('Title', '', $mailtemplate);
        $mailtemplate = str_replace('QR Code', '', $mailtemplate);
        $mailtemplate = str_replace('Divider', '', $mailtemplate);
        $mailtemplate = str_replace('Button', '', $mailtemplate);
        $mailtemplate = str_replace('Social Links', '', $mailtemplate);
        $subject = 'Your test email';
//        $this->sendEmail("pnroos@icloud.com", $subject, $mailtemplate);
        if($this->sendEmail($email, $subject, $mailtemplate)) {
            echo 'success';
        }
                               
                                

    }

    public function sendEmail($email, $subject, $message)
	{
		$configemail = array(
			'protocol' => PROTOCOL,
			'smtp_host' => SMTP_HOST,
			'smtp_port' => SMTP_PORT,
			'smtp_user' => SMTP_USER, // change it to yours
			'smtp_pass' => SMTP_PASS, // change it to yours
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'smtp_crypto' => 'tls',
			'wordwrap' => TRUE,
			'newline' => "\r\n"
		);

		$config = $configemail;
		$CI =& get_instance();
		$CI->load->library('email', $config);
		$CI->email->set_header('X-SES-CONFIGURATION-SET', 'ConfigSet');
		$CI->email->set_newline("\r\n");
		$CI->email->from('support@tiqs.com');
		$CI->email->to($email);
		$CI->email->subject($subject);
		$CI->email->message($message);
		return $CI->email->send();
    }


    public function createEmailTemplate(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $userId = intval($this->session->userdata('userId'));
        $data['template_name'] = $this->input->post('templateName');
        $data['template_subject'] = $this->input->post('templateSubject');
        $data['template_type'] = $this->input->post('templateType');
        $html = $this->input->post('templateHtml');
        $data['user_id'] = $userId;
        $filename = str_replace(' ', '_', $data['template_name']);
        $filename .= '_' . time();
        $data['template_file'] = $filename;

        $dir = FCPATH.'assets/email_templates/'.$userId;
		if (!is_dir($dir)) {
			mkdir($dir, 0777, TRUE);
		}

        $this->load->config('custom');
        $filepath = $dir. '/' .$filename . '.' . $this->config->item('template_extension');

        if (!$this->saveTemplateHtml($filepath, $html))
		{
			$response = [
                'status' => '0',
                'messages' => ['Template not saved'],
            ];
		}
		else
		{
            $id = $this->email_templates_model->add_email_template($data);
            $response = [
                'status' => '1',
                'messages' => ['Template created'],
                'id' => $id,
                'ticketId' => $this->input->post('ticketId')
            ];

            
        }

        echo json_encode($response);
        return;
    }

    public function sendTestEmail(): void
    {
        if (!$this->input->is_ajax_request()) return;

        $email = $this->input->post('email', true);
        $templateHtml = $this->input->post('templateHtml');
        $subject = "This is test!";

        $this->load->helper('reservationsemail_helper');

        if (Reservationsemail_helper::sendEmail($email, $subject, $templateHtml)) {
            $response = [
                'status' => '1',
                'messages' => ['Email is sent successfully']
            ];
        } else {
            $response = [
                'status' => '0',
                'messages' => ['Email is not sent successfully']
            ];

        }

        echo json_encode($response);
        return;
    }

    public function checkPaidStatus(): string
    {
        $data= [];

        $orderRandomKey = $this->input->get('order') ? $this->input->get('order') : false;

        if(!$orderRandomKey){
            $data['status'] = 'error';
            $data['message'] = 'Something is wrong!';
            echo  json_encode($data);
            return '';
            
        }

        $orderData = $this->shopsession_model->setProperty('randomKey', $orderRandomKey)->getArrayOrderDetails();

        if(count($orderData) < 1){
            $data['status'] = 'error';
            $data['message'] = 'Something is wrong!';
            echo json_encode($data);
            return '';
        }

        if(!isset($orderData['transactionId'])){
            $data['status'] = 'false';
            //$data['message'] = $orderData;
            echo json_encode($data);
            return '';
        }


        $isPaid = $this->bookandpay_model->checkPaidStatus($orderData['transactionId']);

        if(!$isPaid){
            $data['status'] = 'false';
            $data['message'] = '2';
            echo json_encode($data);
            return '';
        }

        $data['status'] = 'true';
        $data['transactionId'] = $orderData['transactionId'];
        echo json_encode($data);

        return '';
    }

    private function saveTemplateHtml($path, $html): bool
    {
        if (file_put_contents($path, $html)) return true;
        return false;
    }

    public function upload_unlayer_image()
    {
        $config['upload_path']   = $this->config->item('unlayerUploadFolder');
        $config['allowed_types'] = 'jpg|png|jpeg|webp|bmp';
        $config['max_size']      = '102400'; // 102400 100mb
        $config['encrypt_name'] = TRUE;
        $file_name = '';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
            $errors   = $this->upload->display_errors('', '');
            var_dump($errors);
        } else {
            $upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];
  
        }

        $data['filelink'] = base_url() . $this->config->item('unlayerRelativeUploadFolder') . $file_name;

        echo json_encode($data);
    }
}
