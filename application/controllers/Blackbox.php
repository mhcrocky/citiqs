<?php
require APPPATH . '/libraries/BaseControllerWeb.php';

class Blackbox extends BaseControllerWeb
{
    public function __construct()
    {
        parent::__construct();

     
        $this->load->model('employee_model');
        $this->load->model('shopemployee_model');

        $this->load->config('custom');

        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index($uniqueNumber, $ownerId): void
    {
        
        $employe = $this->employee_model->getEmployee(['*'], ['uniquenumber=' => $uniqueNumber]);
        $urlIn = base_url() . 'in' . DIRECTORY_SEPARATOR . $uniqueNumber . DIRECTORY_SEPARATOR . $ownerId;
        $urlOut = base_url() . 'out' . DIRECTORY_SEPARATOR . $uniqueNumber . DIRECTORY_SEPARATOR . $ownerId;
        $data = [
            'urlIn' => $urlIn,
            'urlOut' => $urlOut,
        ];

        $this->global['pageTitle'] = 'TIQS : IN AND OUT';
        $this->loadViews('blackbox/login', $this->global, $data, null, 'headerWarehousePublic');
        return;
    }

    public function actionIn($uniqueNumber, $ownerId): void
    {
        $employee = $this->getEmployee($uniqueNumber, intval($ownerId), $this->config->item('employeeIn'));

        $employee ? $this->insertEmployee($employee) : $this->session->set_flashdata('error', 'Invalid data! Please check employee expiration time');
        $redirect = base_url() . 'inandout' . DIRECTORY_SEPARATOR . $uniqueNumber . DIRECTORY_SEPARATOR . $ownerId;
        redirect($redirect);
    }

    public function actionOut($uniqueNumber, $ownerId): void
    {
        $employee = $this->getEmployee($uniqueNumber, intval($ownerId), $this->config->item('employeeOut'));

        $employee ? $this->insertEmployee($employee) : $this->session->set_flashdata('error', 'Invalid data');

        $redirect = base_url() . 'inandout' . DIRECTORY_SEPARATOR . $uniqueNumber . DIRECTORY_SEPARATOR . $ownerId;
        redirect($redirect);
    }

    private function getEmployee(string $uniqueNumber, int $ownerId, string $action): ?array
    {
        $employee = $this->employee_model->getEmployee(['*'], ['uniquenumber=' => $uniqueNumber, 'ownerid=' => $ownerId, 'expiration_time>' => time()]);

        if (empty($employee)) return null;

        $employee = reset($employee);
        return [
            'employeeId' => $employee->id,            
            'inOutEmployee' => $action,
            'inOutDateTime' => date('Y-m-d H:i:s'),
            'processed' => '0'
        ];
    }

    private function insertEmployee(array $employee): void
    {
        $action = $this->shopemployee_model->setObjectFromArray($employee)->create();
        if ($action) {
            $this->session->set_flashdata('success', 'Action success');
        } else {
            $this->session->set_flashdata('error', 'Action failed');
        }
        return;
    }
}
