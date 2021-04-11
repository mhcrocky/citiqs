<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH .'/libraries/reservations_vendor/autoload.php';

use \koolreport\drilldown\DrillDown;
use \koolreport\widgets\google\ColumnChart;
use idcheckio\Configuration;


require APPPATH . "/reports/Pivot/ReservationsReport.php";
require APPPATH."/reports/Pivot/PivotReport.php";
require APPPATH . '/libraries/BaseControllerWeb.php';
require APPPATH . '/libraries/phpqrcode/qrlib.php';

class  Customer_panel extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('email_helper');
        $this->load->model('user_model');
        $this->load->model('bookandpayagendabooking_model');
        $this->load->model('bookandpayagenda_model');
        $this->load->model('bookandpayspot_model');
        $this->load->model('sendreservation_model');
        $this->load->model('bookandpay_model');
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
            'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js',
            'https://cdn.jsdelivr.net/npm/vue/dist/vue.js',
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
        //there should be at least one email template
        if(!$emails) {
            redirect('customer_panel/agenda');
        }
 
        $data = [
            'user' => $this->user_model,
            'spots' => $this->bookandpayspot_model->getSpotsByCustomer($this->user_model->id, $agendaId),
            'emails' => $emails,
            'spotsLabel' => $this->bookandpayspot_model->getSpotsLabel($this->user_model->id)
        ];
        if($agendaId){
            $data['agendas'] = $this->bookandpayagendabooking_model->getbookingspotagenda($this->user_model->id, $agendaId);
            $data['agendaId'] = $agendaId;
        } else {
            $data['agendas'] = $this->bookandpayagendabooking_model->getbookingagenda($this->user_model->id);
        }
		$this->global['pageTitle'] = 'TIQS : BOOKING2020';
        $this->loadViews("customer_panel/spots", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }

    public function time_slots($spotId = false)
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['js'] = [
            'https://cdn.jsdelivr.net/npm/vue/dist/vue.js',
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

        //there should be at least one email template
        if(!$emails) {
            redirect('customer_panel/agenda');
        }

        $data = [
            'user' => $this->user_model,
            'emails' => $emails,
            'agendaId' => isset($spot) ? $spot->agenda_id : ''
        ];

        if($spotId){
            $data['timeslots'] = $this->bookandpaytimeslots_model->getTimeSlotsByCustomer($this->user_model->id, $spotId);
            $data['spots'] = $this->bookandpayspot_model->getSpotsById($spotId);
        } else {
            $data['timeslots'] = $this->bookandpaytimeslots_model->getTimeSlotsByCustomer($this->user_model->id);
            $data['spots'] = $this->bookandpayspot_model->getSpotsByCustomer($this->user_model->id);
        }

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
            'timefrom' => urldecode($data['fromtime']),
            'timeto' =>  urldecode($data['totime']),
            'timeslot' => $data['timeslot'],
            'name' => $data['name'],
            'email' => urldecode($data['email']),
            'mobilephone' => $data['mobile'],
            'price' => ($data['price'] == '') ? $data['timeslot_price'] : $data['price'] ,
            'paid' => 2,
            'reservationset' => '1'
        ];

        // create new id for user of this session
        $result = $this->bookandpay_model->newbooking($newBooking);
        $this->emailReservation($result->reservationId, $data['emailId']);
    }


    public function emailReservation($id, $emailId)
	{
        
        $reservations = $this->bookandpay_model->getReservationsById($id);
        $eventdate = '';
        foreach ($reservations as $key => $reservation):
            $result = $this->sendreservation_model->getEventReservationData($reservation->reservationId);
            
            foreach ($result as $record) {
                $customer = $record->customer;
				$eventid = $record->eventid;
				$eventdate = $record->eventdate;
				$reservationId = $record->reservationId;
				$spotId = $record->SpotId;
				$price = $record->price;
				$Spotlabel = $record->Spotlabel;
				$numberofpersons = $record->numberofpersons;
				$name = $record->name;
				$email = $record->email;
				$mobile = $record->mobilephone;
				$reservationset = $record->reservationset;
				$fromtime = $record->timefrom;
				$totime = $record->timeto;
				$paid = $record->paid;
				$timeSlotId = $record->timeslot;
				$TransactionId = $record->TransactionID;
				$voucher = $record->voucher;
                $evenDescript = $record->ReservationDescription;
                
                    if ($paid = 1) {
                        
                        $qrtext = $reservationId;

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

                        $timeSlot = $this->bookandpaytimeslots_model->getTimeSlot($timeSlotId);

                        $spot = $this->bookandpayspot_model->getSpot($spotId);
                        $agenda = $this->bookandpayagenda_model->getBookingAgendaById($spot->agenda_id);

                        
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

                        
						if($emailId) {
                            $emailTemplate = $this->email_templates_model->get_emails_by_id($emailId);
                            
                            $mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$customer.'/'.$emailTemplate->template_file .'.'.$this->config->item('template_extension'));
                            $qrlink = $SERVERFILEPATH . $file_name1;
							if($mailtemplate) {
                                $mailtemplate = str_replace('[buyerName]', $name, $mailtemplate);
                                $mailtemplate = str_replace('[buyerEmail]', $email, $mailtemplate);
                                $mailtemplate = str_replace('[buyerMobile]', $mobile, $mailtemplate);
								$mailtemplate = str_replace('[customer]', $customer, $mailtemplate);
								$mailtemplate = str_replace('[eventDate]', date('d.m.Y', strtotime($eventdate)), $mailtemplate);
								$mailtemplate = str_replace('[reservationId]', $reservationId, $mailtemplate);
								$mailtemplate = str_replace('[spotId]', $spotId, $mailtemplate);
								$mailtemplate = str_replace('[price]', $price, $mailtemplate);
                                $mailtemplate = str_replace('[ticketPrice]', $price, $mailtemplate);
								$mailtemplate = str_replace('[spotLabel]', $Spotlabel, $mailtemplate);
                                $mailtemplate = str_replace('[ticketQuantity]', $numberofpersons, $mailtemplate);
								$mailtemplate = str_replace('[numberOfPersons]', $numberofpersons, $mailtemplate);
								$mailtemplate = str_replace('[startTime]', $fromtime, $mailtemplate);
								$mailtemplate = str_replace('[endTime]', $totime, $mailtemplate);
								$mailtemplate = str_replace('[timeSlot]', $timeSlotId, $mailtemplate);
								$mailtemplate = str_replace('[transactionId]', $TransactionId, $mailtemplate);
								$mailtemplate = str_replace('[voucher]', $voucher, $mailtemplate);
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
								$subject = ($emailTemplate->template_subject) ? strip_tags($emailTemplate->template_subject) : 'Your tiqs reservation(s)';
								$datachange['mailsend'] = 1;

                                //'dtstart' => '2021-10-16 9:00AM',
                                //'dtend' => '2022-1-16 9:00AM',
                                /*
                                $ics = new ICS(array(
                                    'organizer' => 'TIQS:malito:support@tiqs.com',
                                    'description' => strip_tags($evenDescript),
                                    'dtstart' => $eventdate .' '. $fromtime,
                                    'dtend' => $eventdate .' '. $totime,
                                    'summary' => strip_tags($evenDescript),
                                    'url' => base_url()
                                ));
                                */


                               // var_dump(date('Y-m-d H:m:s',strtotime($eventdate .' '. $fromtime)));
                               // var_dump(date('Y-m-d H:m:s',strtotime($eventdate .'T'. $totime)));

                              
                                //$icsContent = $ics->to_string();
                                
								Email_helper::sendEmail("pnroos@icloud.com", $subject, $mailtemplate, false);
								if(Email_helper::sendEmail($email, $subject, $mailtemplate, false)) {
                                    $this->sendreservation_model->editbookandpaymailsend($datachange, $reservationId);
                                    
                                }
                            
                        }
                    }
                }
            }
            endforeach;
        }

}

