<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Customer_panel extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('bookandpayagendabooking_model');
        $this->load->model('bookandpayspot_model');
        $this->load->model('bookandpaytimeslots_model');
        $this->load->model('email_templates_model');
        $this->isLoggedIn();
    }

    public function index () {
        redirect(base_url() . "customer_panel/agenda");
    }

    public function agenda()
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['js'] = [
            base_url().'assets/bower_components/bootstrap-colorselector/bootstrap-colorselector.min.js',
            'https://unpkg.com/vuejs-datepicker',
            'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js',
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.umd.min.js',
            //base_url().'assets/vue/vue_dev.js',
        ];

        $this->global['css'] = [
            base_url().'assets/bower_components/bootstrap-colorselector/bootstrap-colorselector.min.css',
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.css'
        ];

        $this->global['page'] = 'agenda';

        $emails = $this->email_templates_model->get_emails_by_user($this->user_model->id);
        $data = [
            'user' => $this->user_model,
            'agendas' => $this->bookandpayagendabooking_model->getbookingagendaall($this->user_model->id),
            'emails' => $emails
        ]; 

		$this->global['pageTitle'] = 'TIQS : BOOKING2020';
        $this->loadViews("customer_panel/agenda", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function spots($agendaId = false)
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['js'] = [
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.umd.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js'
        ];

        $this->global['css'] = [
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.css'
        ];

        $this->global['page'] = 'spots';

        $emails = $this->email_templates_model->get_emails_by_user($this->user_model->id);
        //there should be at least one email template
        if(!$emails) {
            redirect('customer_panel/agenda');
        }

        $data = [
            'user' => $this->user_model,
            'agendas' => $this->bookandpayagendabooking_model->getbookingagenda($this->user_model->id),
            'spots' => $this->bookandpayspot_model->getSpotsByCustomer($this->user_model->id, $agendaId),
            'emails' => $emails
        ];
		$this->global['pageTitle'] = 'TIQS : BOOKING2020';
        $this->loadViews("customer_panel/spots", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function time_slots($spotId = false)
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['js'] = [
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.umd.min.js',
            'https://unpkg.com/moment@2.18.1/min/moment.min.js',
            'https://unpkg.com/pc-bootstrap4-datetimepicker@4.17.50/build/js/bootstrap-datetimepicker.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js',
            'https://cdn.jsdelivr.net/npm/vue-bootstrap-datetimepicker@5'
        ];

        $this->global['css'] = [
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.css',
            'https://unpkg.com/pc-bootstrap4-datetimepicker@4.17.50/build/css/bootstrap-datetimepicker.min.css'
        ];

        $this->global['page'] = 'timeslots';

        $emails = $this->email_templates_model->get_emails_by_user($this->user_model->id);
        //there should be at least one email template
        if(!$emails) {
            redirect('customer_panel/agenda');
        }

        $spots = $this->bookandpayspot_model->getSpotsByCustomer($this->user_model->id);
        $data = [
            'user' => $this->user_model,
            'timeslots' => $this->bookandpaytimeslots_model->getTimeSlotsByCustomer($this->user_model->id, $spotId),
            'spots' => $spots,
            'emails' => $emails,
            'agendaId' => isset($spots[0]) ? $spots[0]->agenda_id : ''
        ];

		$this->global['pageTitle'] = 'TIQS : BOOKING2020';
        $this->loadViews("customer_panel/time_slots", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }
}

