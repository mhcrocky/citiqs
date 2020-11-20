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
        $this->load->model('Bookandpayagenda_model');
        $data['bookings_graphs'] = DrillDown::create(array(
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

        $this->loadViews('dashboard/index', $data, 'dashboard', 'footerbusiness', 'headerbusiness' );    
    }
}

