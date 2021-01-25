<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Booking_events extends BaseControllerWeb
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('event_model');
        $this->load->library('language', array('controller' => $this->router->class));
    } 

    public function index($shortUrl = false)
    {
        $this->load->model('user_model');
        $this->session->unset_userdata('customer');
        $this->global['pageTitle'] = 'TIQS: Shop';
        $customer = $this->user_model->getUserInfoByShortUrl($shortUrl);
        
        if (!$shortUrl) {
            redirect('https://tiqs.com/info');
        }

        if(!$customer){
            redirect('https://tiqs.com/info');
        }

        if($this->session->userdata('shortUrl') != $shortUrl){
            $this->session->unset_userdata('tickets');
            $this->session->unset_userdata('exp_time');
        }

        $this->session->set_userdata('customer', $customer->id);
        $this->session->set_userdata('shortUrl', $shortUrl);
        $design = $this->event_model->get_design($customer->id);
        if(isset($design[0])){
            $this->global['design'] = unserialize($design[0]['shopDesign']);
        }
        $data['events'] = $this->event_model->get_events($customer->id);
        $this->loadViews("events/shop", $this->global, $data, 'footerShop', 'headerShop');

    }

    public function tickets($eventId)
    {
        if(!$this->input->post('isAjax')){ 
            redirect('events/shop/'. $this->session->userdata('shortUrl'));
            return; 
        }
        $vendor_id = $this->session->userdata('customer');
        $this->session->unset_userdata("event_date");
        $this->global['pageTitle'] = 'TIQS: Step Two';
        $design = $this->event_model->get_design($vendor_id);
        $this->global['design'] = unserialize($design[0]['shopDesign']);
        $event = $this->event_model->get_event($vendor_id,$eventId);
        $event_start =  date_create($event->StartDate . " " . $event->StartTime);
        $event_end = date_create($event->EndDate . " " . $event->EndTime);
        $event_date = date_format($event_start, "d M Y H:i") . " - ". date_format($event_end, "d M Y H:i");
        $this->session->set_userdata("event_date",$event_date);
        $this->session->set_userdata("startDate",$event->StartDate);
        $this->session->set_userdata("startTime",$event->StartTime);
        $this->session->set_userdata("endDate",$event->EndDate);
        $this->session->set_userdata("endTime",$event->EndTime);
        $this->session->set_userdata("eventImage",$event->eventImage);
        $data = [
            'tickets' => $this->event_model->get_tickets($vendor_id,$eventId),
            'eventId' => $eventId,
            'eventName' => $event->eventname,
            'eventImage' => $event->eventImage
        ];
        $result = $this->load->view("events/tickets", $data,true);
				if( isset($result) ) {
					return $this->output
					->set_content_type('application/json')
					->set_status_header(200)
					->set_output(json_encode($result));
				}
        $this->loadViews("events/tickets", $this->global, $data, 'footerShop', 'headerShop');

    }

    public function your_tickets()
    {
        $this->global['pageTitle'] = 'TIQS: Your Tickets';
        $vendor_id = $this->session->userdata('customer');
        $results = $this->input->post(null, true);
        if(count($results) > 0){
            $total = 0;
            $quantities = $results['quantity'];
            $id = $results['id'];
            $descript = $results['descript'];
            $price = $results['price'];
            $tickets = [];
 
            foreach($quantities as $key => $quantity){
                if($quantity == '0'){ continue; }
                $amount = floatval($price[$key])*floatval($quantity);
                $total = $total + $amount;
                    $tickets[$id[$key]] = [
                        'id' => $id[$key],
                        'descript' => $descript[$key],
                        'quantity' => $quantity,
                        'price' => $price[$key],
                        'amount' => $amount,
                        'startDate' => $this->session->userdata("startDate"),
                        'startTime' => $this->session->userdata("startTime"),
                        'endDate' => $this->session->userdata("endDate"),
                        'endTime' => $this->session->userdata("endTime")
                    ];
            }
            if($this->session->tempdata('tickets')){
                $old_tickets = $this->session->tempdata('tickets');
                $tickets1 = $this->check_diff_multi($tickets, $old_tickets);
                $tickets2 = $this->check_diff_multi($old_tickets, $tickets);
                $tickets = $tickets1 + $tickets2;
                //$tickets = $this->unique_multidim_array($tickets, 'id');
            }
            
            $this->session->set_tempdata('tickets', $tickets, 600);
            $current_time = date($results['current_time']);
            $newTime = date("Y-m-d H:i:s",strtotime("$current_time +10 minutes"));
            $this->session->set_tempdata('exp_time', $newTime, 600);
            $total = number_format($total, 2, '.', '');
            $this->session->set_tempdata('total', $total, 600);
        }
        if(!$this->session->tempdata('tickets')){
            $this->session->set_flashdata('expired', 'Session Expired!');
            redirect('events/shop/'. $this->session->userdata('shortUrl'));
        }
   
        $this->loadViews("events/your_tickets", $this->global, '', 'footerShop', 'headerShop');

    }

    public function update_quantity()
    {
        $vendor_id = $this->session->userdata('customer');
        $results = $this->input->post(null, true);
        var_dump($results);
        if(count($results) > 0){
            $total = 0;
            $quantities = $results['quantity'];
            $id = $results['id'];
            $descript = $results['descript'];
            $price = $results['price'];
            $time = (int)($results['exp_sec']/1000);
            $time = $time - 2;
            $tickets = $this->session->userdata('tickets');
            foreach($quantities as $key => $quantity){
                if($quantity == '0'){ continue; }
                $amount = floatval($price[$key])*floatval($quantity);
                $total = $total + $amount;
                unset($tickets[$id[$key]]);
                
                $tickets[$id[$key]] = [
                        'id' => $id[$key],
                        'descript' => $descript[$key],
                        'quantity' => $quantity,
                        'price' => $price[$key],
                        'amount' => $amount,
                        'startDate' => $this->session->userdata("startDate"),
                        'startTime' => $this->session->userdata("startTime"),
                        'endDate' => $this->session->userdata("endDate"),
                        'endTime' => $this->session->userdata("endTime")
                    ];
            }
            $this->session->unset_userdata('tickets');
            $this->session->unset_tempdata('tickets');
        }
        $this->session->set_tempdata('tickets', $tickets, $time);
        redirect('events/your_tickets');

    }

    public function pay()
    {
        $this->global['pageTitle'] = 'TIQS: Pay';
        if(!$this->session->tempdata('tickets')){
            $this->session->set_flashdata('expired', 'Session Expired!');
            redirect('events/shop/'. $this->session->userdata('shortUrl'));
        }
        $this->loadViews("events/pay", $this->global, '', 'footerShop', 'headerShop');
    }

    public function selectpayment()
    {
        $userInfo = $this->input->post(null, true);
        $tickets = $this->session->userdata('tickets');
        $this->session->unset_userdata('tickets');
        $this->session->unset_userdata('exp_time');
        $customer = $this->session->userdata('customer');
        $this->event_model->save_event_reservations($userInfo,$tickets, $customer);
        $this->global['pageTitle'] = 'TIQS: Select Payment';
        $this->session->set_userdata('userInfo', $userInfo);
        $this->loadViews("events/selectpayment", $this->global, '', 'footerShop', 'headerShop');
    }


    public function delete_ticket()
    {
        $tickets = $this->session->tempdata('tickets');
        $ticketId = $this->input->post('id');
        $time = (int)($this->input->post('current_time')/1000);
        $time = $time - 2;
        unset($tickets[$ticketId]);
        if(count($tickets) > 0) {
            echo true;
        } else {
            echo false;
        }
        $this->session->unset_userdata('tickets');
        $this->session->unset_tempdata('tickets');
        $this->session->set_tempdata('tickets', $tickets, $time);
        return ;
    }


    function check_diff_multi($array1, $array2){
        $result = array();
        foreach($array1 as $key => $val) {
             if(isset($array2[$key])){
               if(is_array($val) && $array2[$key]){
                   $result[$key] = $this->check_diff_multi($val, $array2[$key]);
               }
           } else {
               $result[$key] = $val;
           }
        }
    
        return $result;
    }



}