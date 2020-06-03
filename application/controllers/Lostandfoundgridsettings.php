<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Lostandfoundgridsettings extends BaseControllerWeb {
    /**
     * This is default constructor of the class
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('lostandfoundgridsettings_model');
        $this->load->model('user_model');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->isLoggedIn();
    }

    public function index() {
        $userId = $this->session->userdata("userId");
        $data = [];        
        if ($this->checkIfUserSettingExists($userId)) {
        	if ($this->lostandfoundgridsettings_model->getUserSettingsExist($userId)){
            	$data['datasettings'] = $this->lostandfoundgridsettings_model->getUserSettingsById($userId);
        	} else {
				$data['datasettings'] = [
					'userId' => $userId,
					'backgroundcolor' => '#ffffff',
					'bordercolor' => '#e25f2a',
					'textcolor' => '#000000',
					'griditembackground' => '#ffffff',
					'buttonbackgroundcolor' => '#E25F2A',
					'buttontextcolor' => '#ffffff',
					'buttonborderradius' => '12',
					'griditemborderradius' => '12',
					'textsize' => '14',
					'showsearchbar' => '1',
				];
				$result = $this->lostandfoundgridsettings_model->addNewUserSetting($data['datasettings']);
				if ($result) {
					$this->session->set_flashdata('success', 'New lost and found grid created successfully');
				} else {
					$this->session->set_flashdata('error', 'New lost and found grid settiings creation failed');
				}
			}

        } else {
            $data['datasettings'] = [
                'userId' => $userId,
                'backgroundcolor' => '#ffffff',
                'bordercolor' => '#e25f2a',
                'textcolor' => '#000000',
                'griditembackground' => '#ffffff',
                'buttonbackgroundcolor' => '#E25F2A',
                'buttontextcolor' => '#ffffff',
                'buttonborderradius' => '12',
                'griditemborderradius' => '12',
                'textsize' => '14',
                'showsearchbar' => '1',
            ];
            $result = $this->lostandfoundgridsettings_model->addNewUserSetting($data['datasettings']);
            if ($result) {
                $this->session->set_flashdata('success', 'New lost and found grid created successfully');
            } else {
                $this->session->set_flashdata('error', 'New lost and found grid settiings creation failed');
            }
        }
        $data['encodeUserId'] = urlencode(base64_encode($userId));

        $this->global['pageTitle'] = 'tiqs : Grid setting';
        
        $this->loadViews("lostandfoundgridsettings", $this->global, $data, NULL);
    }

    public function addNewUserSetting() {
        $data = [];
        $this->global['pageTitle'] = 'tiqs: Add new user Settings';
        $this->loadViews("addNew", $this->global, $data, NULL);
    }

    public function UserSettings() {
        $datasettings = $this->input->post(NULL, TRUE);
        $response = 0;
        if ($datasettings) {
            $this->load->library('form_validation');
            foreach($datasettings as $key => $value) {
                $this->form_validation->set_rules($key, $key, 'required');
            }
            if ($this->form_validation->run() === TRUE) {
                $this->lostandfoundgridsettings_model->id = intval($this->uri->segment(3));
                $response = ($this->lostandfoundgridsettings_model->updateUserSettings($datasettings)) ? 1 : 0;
            }
        }
        echo $response;
    }

    public function employeeEdit($employeeId) {
        $this->global['pageTitle'] = 'tiqs: Edit Employee';
        $ownerId = $this->session->userdata("userId");
        // If appointment edit was submitted.
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('code', 'Unique Code', 'trim|required');
            if ($this->form_validation->run() !== FALSE) {
                $username = $this->security->xss_clean($this->input->post('username'));
                $code = $this->security->xss_clean($this->input->post('code'));
                $result = $this->checkIfEmployeeisDuplicate($username, $code, $ownerId, $employeeId);
                if (!$result) {
                    //Save the update to the appointment.
                    $employee = array(
                        "username" => $username,
                        "uniquenumber" => $code
                    );
                    $result = $this->employee_model->updateEmployee($employee, $employeeId);
                    if ($result >= 0) {
                        $this->session->set_flashdata('success', 'Employee successfully updated');
                    } else {
                        //Error occured while doing the update
                        $this->session->set_flashdata('error', 'An error occured! Try again.');
                    }
                } else {
                    //Duplicate found.
                    $this->session->set_flashdata('error', 'Employee already existing');
                }
                redirect(base_url() . "employeeEdit/" . $employeeId);
            } else {
                $this->loadViews("employeeEdit", $this->global, $data, NULL);
            }
        } else {
            // Get saved employee details and display them in edit page for edit.
            $emplyee = $this->employee_model->getEmployeeById($employeeId, $ownerId);
            if (empty($emplyee)) {
                redirect(base_url() . 'employee');
            } else {
                $data['emplyee'] = $emplyee;
                $this->loadViews("employeeEdit", $this->global, $data, NULL);
            }
        }
    }
    
    public function deleteEmployee() {
        $employeeId = $this->security->xss_clean($this->input->post('employeeid'));
        $result = $this->employee_model->deleteEmployeeById($employeeId);
        if ($result > 0) {
            echo(json_encode(array('status' => TRUE)));
        } else {
            echo(json_encode(array('status' => FALSE)));
        }
    }

    public function generateEmployeeCode() {
        echo bin2hex(openssl_random_pseudo_bytes(8));
    }

    private function checkIfUserSettingExists($Id) {
        $is_Exist = false;
        $result = $this->lostandfoundgridsettings_model->getUserSettingsById($Id);
        if (!empty($result)) {
            $is_Exist = true;
        }
        return $is_Exist;
    }

}
