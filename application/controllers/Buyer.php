<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    include(APPPATH . '/libraries/koolreport/core/autoload.php');

    require APPPATH . '/libraries/BaseControllerWeb.php';
    
    use \koolreport\drilldown\DrillDown;
    use \koolreport\widgets\google\ColumnChart;
    use \koolreport\clients\Bootstrap4;
    use \koolreport\bootstrap3\Theme;

    class Buyer extends BaseControllerWeb
    {
        private $buyerId;

        public function __construct()
        {
            parent::__construct();

            $this->checkIsBuyer();

            $this->load->helper('utility_helper');

            $this->load->model('shoporder_model');
            $this->load->model('event_model');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');

            $this->load->config('custom');
            $buyerId = $this->session->userdata('buyerId');
        }

        private function checkIsBuyer(): void
        {
            if (!$this->isBuyer()) redirect('logout');
        }

        public function index(): void
        {
            $this->global['pageTitle'] = 'TIQS : BUYER';

            $data = [];

            $this->loadViews('buyer/buyer', $this->global, $data, 'footerbusiness', 'headerbusiness');
        }

        public function buyerOrders(): void
        {
            $this->global['pageTitle'] = 'TIQS : BUYER ORDERS';

            $this->loadViews('buyer/buyerOrders', $this->global, null, 'footerbusiness', 'headerbusiness');
        }

        public function buyerTickets(): void
        {
            $this->global['pageTitle'] = 'TIQS : BUYER TICKETS';
            $this->global['pageTitle'] = 'TIQS: Tags Graphs';
            $buyerId=$this->session->userdata('buyerId');
			$events = $this->event_model->get_events_by_buyer($buyerId);
            $data['events'] = $events;
            
            $data['graph'] = isset($events[0]) ? $this->get_tags_stats($events[0]['id'], true) : [];
            $this->loadViews('buyer/buyerTickets', $this->global, $data, 'footerbusiness', 'headerbusiness');
        }

        public function get_tags_stats($eventId = false, $dateRange = false)
        {

        	$buyerId=$this->session->userdata('buyerId');

            $issetEventId = ($eventId) ? true : false;
            $eventId = ($eventId) ? $eventId : $this->input->post('eventId');
            $dateRange = (!$dateRange) ? urldecode($this->input->post('dateRange')) : '1970-01-01 - 2100-01-01';
            $dateRange = explode(' - ', $dateRange);

            $GLOBALS['eventId'] = $eventId;
            $GLOBALS['startDate'] = $dateRange[0] . ' 00:00:00';
            $GLOBALS['endDate'] = $dateRange[1] . ' 23:59:59';

            $graph = DrillDown::create(array(
                "name" => "saleDrillDown",
                "title" => "Tags Stats",
                "levels" => array(
                    array(
                        "title" => "Tickets Sold",
                            "content" => function ($params, $scope) {
                                global $eventId;
                                global $startDate;
                                global $endDate;

                            $conditions = [
                                'eventId' => $eventId,
                                'startDate' => $startDate,
                                'endDate' => $endDate
                            ];

								$buyerId=$this->session->userdata('buyerId');

								$tags = $this->event_model->get_tags_ticket_sold_stats_for_buyer($buyerId, $eventId, $startDate, $endDate);

                            $columnArr['date'] = [
                                "type" => "string",
                                "label" => "Date",
                            ];

                            foreach($tags as $tag){
                                $keys = array_keys($tag);
                                foreach($keys as $key){
                                    if($key == 'date') { continue; }
                                    $tag = $key;
                                    $columnArr[$tag] = [
                                        "label" => $tag
                                    ];
                                }
                            
                            }

                            $tags = array_values($tags);


                        
                            ColumnChart::create(array(
                                "dataSource" => $tags, 
                                "columns" => $columnArr,
                                "clientEvents" => array(
                                    "itemSelect" => "function(params){
                                        saleDrillDown.next({conditions:" . json_encode($conditions) . "});
                                    }",
                                ),
                                "options"=>array(
                                    "isStacked"=>true
                                )
                            ));
                        }
                    ),

                    array(
                        "title" => function ($params, $scope) {
                            return "Amount";
                        },
                        "content" => function ($params, $scope) {

                            $conditions = $params['conditions'];
                            $eventId = $conditions['eventId'];
                            $startDate = $conditions['startDate'];
                            $endDate = $conditions['endDate'];

							$buyerId=$this->session->userdata('buyerId');

							$tags = $this->event_model->get_tags_amount_stats_for_buyer($buyerId, $eventId, $startDate, $endDate);

                            $tags = array_values($tags);

                            $columnArr['date'] = [
                                "type" => "string",
                                "label" => "Date",
                            ];

                            foreach($tags as $tag){
                                $keys = array_keys($tag);
                                foreach($keys as $key){
                                    if($key == 'date') { continue; }
                                    $tag = $key;
                                    $columnArr[$tag] = [
                                        "label" => $tag,
                                        "type"=>"number",
                                        "prefix"=>"€"
                                    ];
                                }
                            
                            }


                            ColumnChart::create(array(
                                "dataSource" => $tags, 
                                "columns" => $columnArr,
                                "clientEvents" => array(
                                    "itemSelect" => "function(params){
                                        saleDrillDown.next({date:params.selectedRow[0]});
                                    }",
                                ),
                                "options"=>array(
                                    "isStacked"=>true
                                )
                           
                            ));
                        }
                    ),

                ),
                "themeBase" => "bs4",
            ), true);

            if($issetEventId){
                return $graph;
            }

            echo json_encode($graph);
        }


        public function buyerReservations(): void
        {
            $this->global['pageTitle'] = 'TIQS : BUYER RESERVATIONS';

            $data = [];

            $this->loadViews('buyer/buyerReservations', $this->global, $data, 'footerbusiness', 'headerbusiness');
        }

    }
