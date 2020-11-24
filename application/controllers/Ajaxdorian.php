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
        $agendData = [
            'ReservationDescription' => $this->input->post('ReservationDescription'),
            'ReservationDateTime' => date("Y-m-d H:i:s", strtotime($this->input->post('ReservationDateTime'))),
            'Background' => $this->input->post('Background'),
            'Customer' => $this->session->userdata('userId'),
            'email_id' => $this->input->post('email_id'),
            'online' => intval($this->input->post('online'))
        ];

        $agenda_id = $this->input->post('id');

        if ($agenda_id) {
            $this->bookandpayagendabooking_model->updateAgenda($agendData, $agenda_id);
        } else {
            $agenda_id = $this->bookandpayagendabooking_model->addAgenda($agendData);
            if(!empty($this->input->post('agendas'))){
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
        $spotData = [
            'descript' => $this->input->post('descript'),
            'soldoutdescript' => $this->input->post('soldoutdescript'),
            'pricingdescript' => $this->input->post('pricingdescript'),
            'feedescript' => $this->input->post('feedescript'),
            'available_items' => $this->input->post('available_items'),
            'numberofpersons' => $this->input->post('numberofpersons'),
            'sort_order' => $this->input->post('sort_order'),
            'price' => $this->input->post('price'),
            'image' => $this->input->post('image'),
            'agenda_id' => $this->input->post('agenda_id'),
            'email_id' => $this->input->post('email_id'),
        ];

        $spot_id = $this->input->post('id');

        if ($spot_id) {
            $this->bookandpayspot_model->updateSpot($spotData, $spot_id);
        } else {
            $spot_id = $this->bookandpayspot_model->addSpot($spotData);
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
        $spotData = [
            'timeslotdescript' => $this->input->post('timeslotdescript'),
            'available_items' => $this->input->post('available_items'),
            'fromtime' => date("H:i:s", strtotime($this->input->post('fromtime'))),
            'totime' => date("H:i:s", strtotime($this->input->post('totime'))),
            'price' => $this->input->post('price'),
            'spot_id' => $this->input->post('spot_id'),
            'email_id' => $this->input->post('email_id')
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
}
