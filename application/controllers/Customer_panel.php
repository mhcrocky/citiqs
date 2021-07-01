<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH .'/libraries/reservations_vendor/autoload.php';

use \koolreport\drilldown\DrillDown;
use \koolreport\widgets\google\ColumnChart;
use idcheckio\Configuration;


require APPPATH . "/reports/Pivot/ReservationsReport.php";
require APPPATH."/reports/Pivot/PivotReport.php";
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
        $this->load->helper('reservationsemail_helper');
        $this->load->model('user_model');
        $this->load->model('bookandpayagendabooking_model');
        $this->load->model('bookandpayagenda_model');
        $this->load->model('bookandpayspot_model');
        $this->load->model('sendreservation_model');
        $this->load->model('bookandpay_model');
        $this->load->model('bookandpaytimeslots_model');
        $this->load->model('email_templates_model');
        $this->load->model('shopvoucher_model');

        $this->load->helper('utility_helper');
        $this->isLoggedIn();
    }

    public function index () {
        redirect(base_url() . "customer_panel/agenda");
    }

    public function agenda()
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['js'] = [
            'https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.js',
            'https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.js',
            'https://cdn.jsdelivr.net/npm/vue@2.6.14',
            base_url().'assets/bower_components/bootstrap-colorselector/bootstrap-colorselector.min.js',
            'https://unpkg.com/vuejs-datepicker',
            'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js',
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.umd.min.js',
            'https://cdn.tiny.cloud/1/pcevs107srjcf31ixiyph3zij2nlhhl6fd10hxmer5lyzgsu/tinymce/4/tinymce.min.js',
            base_url() . 'assets/home/js/templates.js',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            //base_url().'assets/vue/vue_dev.js',
        ];

        $this->global['css'] = [
            base_url().'assets/bower_components/bootstrap-colorselector/bootstrap-colorselector.min.css',
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.css',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
        ];

        $this->global['page'] = 'agenda';

        $emails = $this->email_templates_model->get_emails_by_user($this->user_model->id);
        $what = ['tbl_shop_voucher.id' ,'tbl_shop_voucher.description', 'tbl_email_templates.template_name'];
        $join = [
			0 => [
				'tbl_email_templates',
				'tbl_email_templates.id = tbl_shop_voucher.emailId',
				'right'
			]
		];
		$where = [
            "tbl_shop_voucher.vendorId" => $this->user_model->id,
            "tbl_shop_voucher.productGroup" => $this->config->item('reservations')
        ];
        $vouchers = $this->shopvoucher_model->read($what,$where,$join, 'group_by', ['tbl_shop_voucher.id']);
        $vouchers = ($vouchers == null) ? [] : $vouchers;

        $data = [
            'user' => $this->user_model,
            'agendas' => $this->bookandpayagendabooking_model->getbookingagendaall($this->user_model->id),
            'emails' => $emails,
            'vouchers' => $vouchers
        ]; 

		$this->global['pageTitle'] = 'TIQS : RESERVATIONS';
        $this->loadViews("customer_panel/agenda", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function spots($agendaId = false)
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['js'] = [
            'https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.js',
            'https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.js',
            'https://cdn.jsdelivr.net/npm/vue@2.6.14',
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.umd.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js',
            'https://cdn.tiny.cloud/1/pcevs107srjcf31ixiyph3zij2nlhhl6fd10hxmer5lyzgsu/tinymce/4/tinymce.min.js',
            base_url() . 'assets/home/js/templates.js',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            'https://unpkg.com/izitoast@1.4.0/dist/js/iziToast.js'
        ];

        $this->global['css'] = [
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.css',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            'https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css'
        ];

        $this->global['page'] = 'spots';

        $emails = $this->email_templates_model->get_emails_by_user($this->user_model->id);

        $what = ['tbl_shop_voucher.id' ,'tbl_shop_voucher.description', 'tbl_email_templates.template_name'];
        $join = [
			0 => [
				'tbl_email_templates',
				'tbl_email_templates.id = tbl_shop_voucher.emailId',
				'right'
			]
		];
		$where = [
            "tbl_shop_voucher.vendorId" => $this->user_model->id,
            "tbl_shop_voucher.productGroup" => $this->config->item('reservations')
        ];
        $vouchers = $this->shopvoucher_model->read($what,$where,$join, 'group_by', ['tbl_shop_voucher.id']);
        $vouchers = ($vouchers == null) ? [] : $vouchers;


        //there should be at least one email template
        if(!$emails) {
            redirect('customer_panel/agenda');
        }
 
        $data = [
            'user' => $this->user_model,
            'spots' => $this->bookandpayspot_model->getSpotsByCustomer($this->user_model->id, $agendaId),
            'emails' => $emails,
            'spotsLabel' => $this->bookandpayspot_model->getSpotsLabel($this->user_model->id),
            'vouchers' => $vouchers
        ];
        if($agendaId){
            $data['agendas'] = $this->bookandpayagendabooking_model->getbookingspotagenda($this->user_model->id, $agendaId);
            $data['agendaId'] = $agendaId;
        } else {
            $data['agendas'] = $this->bookandpayagendabooking_model->getbookingagenda($this->user_model->id);
        }
		$this->global['pageTitle'] = 'TIQS : RESERVATIONS';
        $this->loadViews("customer_panel/spots", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function time_slots($spotId = false)
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['js'] = [
            'https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.js',
            'https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.js',
            'https://cdn.jsdelivr.net/npm/vue@2.6.14',
            'https://unpkg.com/vuejs-datepicker',
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.umd.min.js',
            'https://unpkg.com/moment@2.18.1/min/moment.min.js',
            'https://unpkg.com/pc-bootstrap4-datetimepicker@4.17.50/build/js/bootstrap-datetimepicker.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js',
            'https://cdn.jsdelivr.net/npm/vue-bootstrap-datetimepicker@5',
            'https://cdn.tiny.cloud/1/pcevs107srjcf31ixiyph3zij2nlhhl6fd10hxmer5lyzgsu/tinymce/4/tinymce.min.js',
            base_url() . 'assets/home/js/templates.js'
        ];

        $this->global['css'] = [
            'https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.css',
            'https://unpkg.com/pc-bootstrap4-datetimepicker@4.17.50/build/css/bootstrap-datetimepicker.min.css'        ];

        $this->global['page'] = 'timeslots';

        $emails = $this->email_templates_model->get_emails_by_user($this->user_model->id);
        $spot = $this->bookandpayspot_model->getSpot($spotId);
        $what = ['tbl_shop_voucher.id' ,'tbl_shop_voucher.description', 'tbl_email_templates.template_name'];
        $join = [
			0 => [
				'tbl_email_templates',
				'tbl_email_templates.id = tbl_shop_voucher.emailId',
				'right'
			]
		];
		$where = [
            "tbl_shop_voucher.vendorId" => $this->user_model->id,
            "tbl_shop_voucher.productGroup" => $this->config->item('reservations')
        ];
        $vouchers = $this->shopvoucher_model->read($what,$where,$join, 'group_by', ['tbl_shop_voucher.id']);
        $vouchers = ($vouchers == null) ? [] : $vouchers;

        //there should be at least one email template
        if(!$emails) {
            redirect('customer_panel/agenda');
        }

        $data = [
            'user' => $this->user_model,
            'emails' => $emails,
            'agendaId' => isset($spot) ? $spot->agenda_id : '',
            'vouchers' => $vouchers
        ];

        if($spotId){
            $data['timeslots'] = $this->bookandpaytimeslots_model->getTimeSlotsByCustomer($this->user_model->id, $spotId);
            $data['spots'] = $this->bookandpayspot_model->getSpotsById($spotId);
        } else {
            $data['timeslots'] = $this->bookandpaytimeslots_model->getTimeSlotsByCustomer($this->user_model->id);
            $data['spots'] = $this->bookandpayspot_model->getSpotsByCustomer($this->user_model->id);
        }

		$this->global['pageTitle'] = 'TIQS : RESERVATIONS';
        $this->loadViews("customer_panel/time_slots", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    function reservations_export()
    {
        $report = new ReservationsReport;
        $report->run();
        $report->exportToExcel('ReservationsReport')->toBrowser("ReservationsReportExcel.xlsx");
    }

    /**
     * This function used to load the first screen of the user
     */
    public function reservations()
    {
        $this->global['page'] = 'reservations_report';
        $this->global['pageTitle'] = 'Reservations Report';
        $data = [];

        $data['from'] = $this->input->post('from');
        $data['to'] = $this->input->post('to');

        $this->loadViews("customer_panel/reservations_report", $this->global, $data, 'footerbusiness', 'headerbusiness' );
    }

    function pivot()
	{
		$this->global['page'] = 'pivot';
		$this->global['pageTitle'] = 'pivot';
		$data = [];
		$this->loadViews("customer_panel/pivot", $this->global, $data, 'footerbusiness', 'headerbusiness' );
		// $report = new PivotReport;
		// $report->run()->render();
    }
    
	function pivot_export(){
		$report = new PivotReport;
		$report->run();
		$report->exportToExcel('PivotReport')->toBrowser("PivotReportExcel.xlsx");
    }
    
    public function report()
    {
        $this->global['page'] = 'report';
        $this->global['pageTitle'] = 'report';
        $data = [];

        $bookandpay = $this->bookandpayagendabooking_model->get_bookandpay_data();
        $data['bookandpay'] =  $bookandpay ? $bookandpay : [];
        $data['graphs'] = DrillDown::create(array(
            "name" => "saleDrillDown",
            "title" => "Sale Report",
            "levels" => array(
                array(
                    "title" => "Agenda",
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->bookandpayagendabooking_model->get_agenda($this->session->userdata('userId'))), 
                            "columns" => array(
                                "date" => array(
                                    "type" => "string",
                                    "label" => "Date",
                                ),
                                "numberofpersons" => array(
                                    "label" => "Vistor",
                                )
                            ),
                            "clientEvents" => array(
                                "itemSelect" => "function(params){
                                    saleDrillDown.next({date:params.selectedRow[0]});
                                }",
                            )
                        ));
                    }
                ),

                array(
                    "title" => function ($params, $scope) {
                        return "Spot " . $params["date"];
                    },
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->bookandpayagendabooking_model->get_spot_bydate2($params["date"])),
                            "columns" => array(
                                "spot_id" => array(
                                    "type" => "string",
                                    "label" => "Spot",
                                    "formatValue" => function ($value, $row) {
                                        return $row["image"];
                                    },
                                ),
                                "numberofpersons" => array(
                                    "label" => "Vistor",
                                )
                            ),
                            "clientEvents" => array(
                                "itemSelect" => "function(params){
                                    saleDrillDown.next({spot_id:params.selectedRow[0]});
                                }",
                            )
                        ));
                    }
                ),
                array(
                    "title" => function ($params, $scope) {
                        return "Slot " . $params["spot_id"];
                    },
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->bookandpayagendabooking_model->get_slot_byspotidDate($params["spot_id"], $params["date"])),
                            "columns" => array(
                                "timediff" => array(
                                    "type" => "string",
                                    "label" => "Time",
                                ),
                                "numberofpersons" => array(
                                    "label" => "Vistor",
                                )
                            ),
                        ));
                    }
                ),

            ),
            "themeBase" => "bs4",
        ), true);
        $data['allcolumnarray'] = array(
            array("customer", "Customer"),
            array("eventid", "event Id"),
            array("reservationId", "reservation ID"),
            array("bookdatetime", "Book datetime"),
            array("SpotId", "Spot ID"),
            array("price", "Price"),
            array("numberofpersons", "Number of Persons"),
            array("email", "Email"),
            array("mobilephone", "Mobile Phone"),
            array("reservationset", "Reservation Set"),
            array("reservationtime", "Reservation Time"),
            array("timefrom", "Time From"),
            array("timeto", "Time To"),
            array("paid", "Paid"),
            array("timeslot", "Time Slot"),
            array("voucher", "Voucher"),
            array("TransactionID", "Transaction ID"),
            array("bookingsequenceId", "Booking Sequence ID"),
            array("bookingsequenceamount", "Booking Sequence Amount"),
            array("numberin", "Number in"),
            array("mailsend", "Mail Send"),
        );

        $this->loadViews("customer_panel/report2", $this->global, $data, 'footerbusiness', 'headerbusiness' );
    }

    public function booking_tickets()
    {
        $data['pageTitle'] = 'Booking & Tickets';
        $this->load->model('bookandpayagenda_model');
       

        $data['bookings_graphs'] = DrillDown::create(array(
            "name" => "saleDrillDown",
            "title" => "Reservation Report",
            "levels" => array(
                array(
                    "title" => "Agenda",
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->bookandpayagendabooking_model->get_agenda($this->session->userdata('userId'))), 
                            "columns" => array(
                                "date" => array(
                                    "type" => "string",
                                    "label" => "Date",
                                ),
                                "numberofpersons" => array(
                                    "label" => "Bookings",
                                ),
								"max" => array(
									"label" => "Maximum",
						)
                            ),
                            "clientEvents" => array(
                                "itemSelect" => "function(params){
                                    saleDrillDown.next({date:params.selectedRow[0]});
                                }",
                            )
                        ));
                    }
                ),

                array(
                    "title" => function ($params, $scope) {
                        return "Spot " . $params["date"];
                    },
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->bookandpayagendabooking_model->get_spot_bydate2($params["date"],$this->session->userdata('userId'))),
                            "columns" => array(
                                "spot_id" => array(
                                    "type" => "string",
                                    "label" => "Spot",
                                    "formatValue" => function ($value, $row) {
                                        return $row["image"];
                                    },
                                ),
                                "numberofpersons" => array(
                                    "label" => "Booking",
                                ),
                                "max_items" => array(
                                    "label" => "Maximum",
                                ),
                            ),
                            "clientEvents" => array(
                                "itemSelect" => "function(params){
                                    saleDrillDown.next({spot_id:params.selectedRow[0]});
                                }",
                            )
                        ));
                    }
                ),
                array(
                    "title" => function ($params, $scope) {
                        return "Slot " . $params["spot_id"];
                    },
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->bookandpayagendabooking_model->get_bookings_byspotidDate($params["spot_id"], $params["date"], $this->session->userdata('userId'))),
                            "columns" => array(
                                "timediff" => array(
                                    "type" => "string",
                                    "label" => "Time"
                                ),
                                "matched" => array(
                                    "label" => "From Prev Timeslot",

                                ),
                                "numberofpersons" => array(
                                    "label" => "Bookings"
                                ),
                                "max_items" => array(
                                    "label" => "Maximum",
                                    
                                ),
                                
                            ),
                            "yAxis"=>array(
                                "decimals"=>2,
                                "decPoint"=>",",
                                "thousandSep"=>",",
                                "prefix"=>"",
                                "suffix"=>""
                            ),
                            "options"=>array(
                                "isStacked"=>true
                            ),
                        ));
                    }
                ),

            ),
           
        ), true);

        $data['scan_graphs'] = DrillDown::create(array(
            "name" => "scanDrillDown",
            "title" => "Scan Report",
            "levels" => array(
                array(
                    "title" => "Agenda",
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->bookandpayagendabooking_model->get_agenda($this->session->userdata('userId'))), 
                            "columns" => array(
                                "date" => array(
                                    "type" => "string",
                                    "label" => "Date",
                                ),
                                "numberofpersons" => array(
                                    "label" => "Bookings",
                                ),
                                "scanned" => array(
                                    "label" => "Scanned in",
                                ),
                            ),
                            "clientEvents" => array(
                                "itemSelect" => "function(params){
                                    scanDrillDown.next({date:params.selectedRow[0]});
                                }",
                            ),
                            "colorScheme"=>array(
                                "#3366cc",
                                "#ffff00",
                                "#c2b9b0",
                                "#7e685a",
                                "#afd275"
                            )
                        ));
                    }
                ),

                array(
                    "title" => function ($params, $scope) {
                        return "Spot " . $params["date"];
                    },
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->bookandpayagendabooking_model->get_spot_bydate2($params["date"],$this->session->userdata('userId'))),
                            "columns" => array(
                                "spot_id" => array(
                                    "type" => "string",
                                    "label" => "Spot",
                                    "formatValue" => function ($value, $row) {
                                        return $row["image"];
                                    },
                                ),
                                "numberofpersons" => array(
                                    "label" => "Booking",
                                ),
                                "scanned" => array(
                                    "label" => "Scanned In",
                                ),
                            ),
                            "clientEvents" => array(
                                "itemSelect" => "function(params){
                                    scanDrillDown.next({spot_id:params.selectedRow[0]});
                                }",
                            ),
                            "colorScheme"=>array(
                                "#3366cc",
                                "#ffff00",
                                "#c2b9b0",
                                "#7e685a",
                                "#afd275"
                            )
                        ));
                    }
                ),
                array(
                    "title" => function ($params, $scope) {
                        return "Slot " . $params["spot_id"];
                    },
                    "content" => function ($params, $scope) {
                        ColumnChart::create(array(
                            "dataSource" => ($this->bookandpayagendabooking_model->get_bookings_byspotidDate($params["spot_id"], $params["date"], $this->session->userdata('userId'))),
                            "columns" => array(
                                "timediff" => array(
                                    "type" => "string",
                                    "label" => "Time"
                                ),
                                "total_persons" => array(
                                    "label" => "Bookings"
                                ),
                                "scanned" => array(
                                    "label" => "Scanned In",
                                ),
                                
                            ),
                            "colorScheme"=>array(
                                "#3366cc",
                                "#ffff00",
                                "#c2b9b0",
                                "#7e685a",
                                "#afd275"
                            )
                        ));
                    }
                ),

            ),
            
        ), true);

        $this->loadViews('customer_panel/bookings_tickets', $data, 'dashboard', 'footerbusiness', 'headerbusiness' );    
    }

    function settings()
    {
        $this->global['pageTitle'] = 'Reservations Report';
        $data['termsofuse'] = $this->bookandpayagendabooking_model->getTermsofuse();
        $this->loadViews('customer_panel/settings', $this->global,  $data, 'footerbusiness', 'headerbusiness' ); 
    }

    public function listTemplates(): void
    {
        $vendorId = $this->session->userdata('userId');
		$this->load->model('email_templates_model');

        $data = [
            'templates' => $this->email_templates_model->get_emails_by_user($vendorId),
            'updateTemplate' => base_url() . 'update_template' . DIRECTORY_SEPARATOR,
        ];
            $this->global['pageTitle'] = 'TIQS : LIST TEMPLATE';
            $this->loadViews('templates/listTemplates', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
    }

    public function get_email_template()
    {
        $id = $this->input->post("id");
        $this->load->model('shoptemplates_model');
        $this->shoptemplates_model->setObjectId(intval($id))->setObject();
        $templateContent = file_get_contents($this->shoptemplates_model->getTemplateFile());
        $template_subject = $this->shoptemplates_model->read(['template_subject'],['id' => $id])[0]['template_subject'];
        echo json_encode(['templateContent' => $templateContent, 'template_subject' => $template_subject]);

    }

    public function spots_order()
    {
        $spots = json_decode($this->input->post('spots'));
		
        foreach($spots as $key => $spot){
            if($spot == ''){continue;}
            $this->bookandpayspot_model->updateSpotOrder($key,$spot);
        }
    }

    public function manual_reservations()
    {
        $vendorId = $this->session->userdata('userId');
        $data['agendas'] = $this->bookandpayagendabooking_model->get_agenda_spot_timeslot($vendorId);
        $data['emails'] = $this->email_templates_model->get_emails_by_user($vendorId);
        $this->global['pageTitle'] = 'TIQS : BOOK RESERVATION';
        $this->loadViews("customer_panel/manual_reservations", $this->global, $data, 'footerbusiness', 'headerbusiness');

    }

    public function get_reservations()
    {
        $vendorId = $this->session->userdata('userId');
        $reservations = $this->bookandpayagendabooking_model->get_manual_reservations($vendorId);
        echo json_encode($reservations);
    }

    public function get_spots()
    {
        $vendorId = $this->session->userdata('userId');
        $agenda_id = $this->input->post('agenda_id');
        $spots = $this->bookandpayagendabooking_model->getSpotsByCustomer($vendorId, $agenda_id);
        echo json_encode($spots);
    }

    public function get_timeslots()
    {
        $vendorId = $this->session->userdata('userId');
        $spot_id = $this->input->post('spot_id');
        $timeslots = $this->bookandpayagendabooking_model->getTimeSlotsByCustomer($vendorId, $spot_id);
        $multiple_timeslots = [];
        
        if(is_array($timeslots) && count($timeslots)){

            foreach($timeslots as $key => $timeslot){
                if($timeslot['multiple_timeslots'] == 1){
                    unset($timeslots[$key]);
                    $fromtime = explode(':',$timeslot['fromtime']);
                    $totime = explode(':', $timeslot['totime']);
                    $duration = explode(':', $timeslot['duration']);
                    $overflow = explode(':', $timeslot['overflow']);
            
                    $time_diff = ($totime[0]*60 - $fromtime[0]*60) + ($totime[1] - $fromtime[1]);
                    $time_duration = ($duration[0]*60 + $overflow[0]*60) + ($duration[1] + $overflow[1]);
                    $time_div = intval($time_diff/$time_duration);
                    $start_time = '';
                    $end_time = '';
                    for($i=0; $i < $time_div; $i++):
                        
                        if($i == 0){
                            $start_time = self::explode_time($timeslot['fromtime']);
                            $end_time = $start_time + self::explode_time($timeslot['duration']);
                        } else {
                            $start_time = $end_time + self::explode_time($timeslot['overflow']);
                            $end_time = $start_time + self::explode_time($timeslot['duration']);
                        }
                        

                        $multiple_timeslots[] = [
                            'timeslot_id' => $timeslot['timeslot_id'],
                            'timeslot_price' => $timeslot['timeslot_price'],
                            'available_items' => $timeslot['available_items'],
                            'fromtime' => self::second_to_hhmm($start_time),
                            'totime' => self::second_to_hhmm($end_time)
                        ];

                    endfor;
                }
            }


        }

        if(count($multiple_timeslots) > 0){
            $timeslots = array_merge($timeslots, $multiple_timeslots);
        }

        echo json_encode($timeslots);

    }

    public function book_reservation(){
        $vendorId = $this->session->userdata('userId');
        $data = $this->input->post(null, true);
        $newBooking = [
            'customer' => $vendorId,
            'eventid' => $data['agenda_id'],
            'eventdate' => date("Y-m-d", strtotime(urldecode($data['event_date']))),
            'SpotId' => $data['spot_id'],
            'Spotlabel' => $data['spot_label'],
            'timefrom' => urldecode($data['fromtime']),
            'timeto' =>  urldecode($data['totime']),
            'timeslotId' => $data['timeslot'],
            'name' => $data['name'],
            'email' => urldecode($data['email']),
            'mobilephone' => $data['mobile'],
            'price' => ($data['price'] == '') ? $data['timeslot_price'] : $data['price'] ,
            'paid' => 2,
            'reservationset' => '1'
        ];

        //check if is sold out
        $isSoldout = $this->check_if_soldout($newBooking['timeslotId'], $newBooking['timefrom'], $newBooking['timeto'], $data['available_items']);

        // create new id for user of this session
        $result = $this->bookandpay_model->newbooking($newBooking);

        if ($data['addVoucher'] === '1') {
            $this->bookandpay_model->newvoucher($result->reservationId);
            $this->shopvoucher_model->createReservationVoucher($this->bookandpay_model, $result->reservationId, 'reservationId');
        }

        $response = [
            'status' => 'error',
            'message' =>'Something went wrong!',
        ];

        if($this->emailReservation($result->reservationId, $data['emailId'])){

            if($isSoldout){
                $response = [
                    'status' => 'warning',
                    'messages' => [
                        'The reservation is send successfully',
                        'The selected timeslot is soldout!',
                    ],
                ];
            } else {
                $response = [
                    'status' => 'success',
                    'message' =>'The reservation is send successfully',
                ];
            }
        }
        
        echo json_encode($response);
    }


    public function emailReservation($id, $emailId) : bool
	{
        
        $reservations = $this->bookandpay_model->getReservationsById($id);
        return Reservationsemail_helper::sendEmailReservation($reservations, true);
       
    }

    public function financial_report() : void
    {
        $this->global['pageTitle'] = 'TIQS : FINANCIAL REPORT';
        $vendorId = $this->session->userdata('userId');
        $data['vouchers'] = $this->bookandpay_model->get_vouchers($vendorId);
        $this->loadViews('customer_panel/financial_report', $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function get_financial_report()
    {
        $vendorId = $this->session->userdata('userId');
        $sql = ($this->input->post('sql') == 'AND%20()') ? "" : rawurldecode($this->input->post('sql'));
        $report = $this->bookandpay_model->get_financial_report($vendorId, $sql);
        echo json_encode($report);
    }

    public function resend_reservation()
	{
        $transactionId = $this->input->post('transactionId');
        $reservationId = $this->input->post('reservationId');
        $sendToSupport = ($this->input->post('sendTo') == 1) ? true : false;
        $reservations = $this->bookandpay_model->getReservationsByIds([$reservationId]);

        if (Reservationsemail_helper::sendEmailReservation($reservations, true, true, $sendToSupport)) {
            $this->shopvoucher_model->createReservationVoucher($this->bookandpay_model, $transactionId);
        }

        return;
    }

    public function check_if_soldout($timeslotId, $fromtime, $totime, $availableItems) : bool
    {
        $spotReserved = $this->bookandpay_model->getBookingCountByTimeSlot($timeslotId, $fromtime, $totime);
        if($spotReserved >= $availableItems){
            return true;
        }
        return false;
    }

    private static function explode_time($time)
    {
        $time = explode(':', $time);
        $time = $time[0]*3600+$time[1]*60;
        return $time;
    }

    private static function second_to_hhmm($time)
    {
        $hour = floor($time/3600);
        $min = strval(floor(($time%3600)/60));
        if($min <= 9){
            $min = '0'.$min;
        }
        $time = $hour . ':' . $min . ':' . '00'; 
        return $time;
    }

}

