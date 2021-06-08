<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/phpqrcode/qrlib.php';

class Employee extends BaseControllerWeb {

    /**
     * This is default constructor of the class
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('email_helper');
        $this->load->model('employee_model');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('form_validation');
        $this->isLoggedIn();
    } 

    public function index() {
        $ownerId = $this->session->userdata("userId");
        $data = [
            'employees' => $this->employee_model->getOwnerEmployees($ownerId),
            'menuOptions' => $this->employee_model->getMenuOptions(),
            'employeeMenuOptions' => $this->employee_model->getMenuOptionsByVendor($ownerId),
            'ownerId' => $_SESSION['userId'],
            'time' => time(),
        ];

        $this->global['pageTitle'] = 'TIQS : ACCESS';
        $this->loadViews("employeenew", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function addNewEmployee() {
        $data = ['baseUrl' => base_url()];
        $this->global['pageTitle'] = 'tiqs: Add New Employee';
        $this->loadViews("employeenew", $this->global, $data, NULL);
    }

    public function save_menu_options() {
        $vendorId = $this->session->userdata("userId");
        $menuOptions = json_decode($this->input->post('menuOptionsId'));
        $userId = $this->input->post('userId');
        $output = $this->employee_model->saveMenuOptionsByEmployee($vendorId, $userId, $menuOptions);
        echo $output;
    }

    private function checkEmployeeData(array $employee, int $id = 0): bool
    {
        $this->employee_model->setProperty('ownerId', intval($_SESSION['userId']));
        if ($id) {
            $this->employee_model->setObjectId($id);
        }

        if (!$this->employee_model->checkIsPropertyFree('email', $employee['email'])) {
            $this->session->set_flashdata('error', 'Employee with this email already exists');
            return false;
        }

        if (!$this->employee_model->checkIsPropertyFree('INSZnumber', $employee['INSZnumber'])) {
            $this->session->set_flashdata('error', 'Employee with this INSZ number already exists');
            return false;
        }

        if (!$this->employee_model->checkIsPropertyFree('posPin', $employee['posPin'])) {
            $this->session->set_flashdata('error', 'Employee with this POS pin already exists');
            return false;
        }

        return true;
    }

    public function addNewEmployeeSetup()
    {
        $employee = $this->security->xss_clean($_POST);
        $employee['validitytime'] =  time() + 3600 * 8; //Code valid for 8 hours.
        $employee["expiration_time"] = $this->getExpiryTime($employee['expiration_time_value'], $employee['expiration_time_type']);
        $employee['uniquenumber'] = time() . '_' . rand(0,99999);
        $employee['ownerId'] = $_SESSION['userId'];

        $redirect = base_url() . 'employee';

        if (!$this->checkEmployeeData($employee)) {
            redirect($redirect);
        }

        if ($this->employee_model->addNewEmployeeImproved($employee)) {
            $this->session->set_flashdata('success', 'New employee created successfully');
        } else {
            $this->session->set_flashdata('error', 'New employee creation failed');
        }

        redirect($redirect);
    }

    public function validexpirytype($date) {
        if (!in_array($date, ["minutes", "hours", "days", "months"])) {
            $this->form_validation->set_message('validexpirytype', 'Expiry time type must be minutes, hours, days or months');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function employeeEdit($employeeId)
    {
        $employee = $this->security->xss_clean($_POST);
        $employee['uniquenumber'] = time() . '_' . rand(0,99999);
        $employee['expiration_time'] = $this->getExpiryTime($employee['expiration_time_value'], $employee['expiration_time_type']);
        $employee['ownerId'] = $_SESSION['ownerId'];

        $redirect = base_url() . 'employee';

        if (!$this->checkEmployeeData($employee, intval($employeeId))) {
            redirect($redirect);
        }

        if ($this->employee_model->updateEmployeeImproved($employee)) {
            $this->session->set_flashdata('success', 'Employee successfully updated');
        } else {
            $this->session->set_flashdata('error', 'Employee update failed');
        }

        redirect($redirect);
    }

    public function emailnottaken($employeeId) {
        $email = $this->security->xss_clean($this->input->post('email'));
        $ownerId = $this->session->userdata("userId");
        $found = $this->employee_model->getEmployeeIdByEmail($email, $ownerId);
        if (empty($found)) {
            return TRUE;
        } else if ($found[0]->id == $employeeId) {//Same employee updating his email.
            return TRUE;
        } else {//Duplicate email
            $this->form_validation->set_message('emailnottaken', 'This email is already taken');
            return FALSE;
        }
    }

    public function deleteEmployee()
    {
        if (filter_var($this->uri->segment(3), FILTER_VALIDATE_INT)) {
            $result = $this->employee_model->deleteEmployeeById($this->uri->segment(3));
        }
        echo (isset($result) && $result) ? json_encode(['status' => 1]) : json_encode(['status' => 0]);
    }



    public function emailEmployee()
    {
        $employeeId = $this->security->xss_clean($this->input->post('employeeid'));
        $ownerid = $this->session->userdata("userId");
        $employee = $this->employee_model->getEmployeeById($employeeId, $ownerid);
        if (empty($employee)) {
            echo(json_encode(array('status' => 0)));
        } else {
            $employee = reset($employee);            
            if (!Email_helper::sendBlackBoxEmail($employee)) {
                echo(json_encode(array('status' => 0)));
            } else {
                echo(json_encode(array('status' => 1)));
            }
        }
    }

    public function generateEmployeeCode() {
        echo $this->generateUniqueToken(8);
    }

    public static function generateEmployeeQRCode($qrtext) : string
    {
		$path = FCPATH . 'uploads/qrcodes/employee/';

        if(!is_dir($path)){
            mkdir($path);
        }

		$file_name = $qrtext . ".png";
		$file_path = $path . $file_name;
        if(!file_exists($file_path)){
            QRcode::png($qrtext, $file_path, QR_ECLEVEL_H, 10);
        }
        $qrlink = base_url() . 'uploads/qrcodes/employee/' . $file_name;
        return $qrlink;
    }

    private function checkIfEmployeeisDuplicate($username, $code, $ownerId, $employeeId) {
        $is_duplicate = false;
        $result = $this->employee_model->getEmployeeById($username, $code, $ownerId);
        if (!empty($result)) {
            if ($result[0]->id != $employeeId) {
                $is_duplicate = true;
            }
        }
        return $is_duplicate;
    }

    private function getExpiryTime($expirytime, $date) {
        switch ($date) {
            case "minutes":
                $expiry = time() + 60 * (int) $expirytime;
                break;
            case "hours":
                $expiry = time() + 3600 * (int) $expirytime;
                break;
            case "days":
                $expiry = time() + 3600 * 24 * (int) $expirytime;
                break;
            case "months":
                $expiry = time() + 3600 * 24 * 30 * (int) $expirytime;
                break;
            default:
                $expiry = "";
                break;
        }
        return $expiry;
    }


}
