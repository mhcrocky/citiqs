<?php
    declare(strict_types=1);

    defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . 'libraries/REST_Controller.php';
    
    class Cronjobs extends REST_Controller
    {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('shopprinterrequest_model');
            
            $this->load->helper('utility_helper');
            $this->load->helper('validate_data_helper');
            $this->load->helper('queue_helper');

            $this->load->config('custom');
            $this->load->library('language', array('controller' => $this->router->class));
        }

		public function index_delete()
		{
			return;
        }

        public function cleanPrinterRequests_get(): void
        {
            $where = [
                'conected<' => date('Y-m-d H:i:s', strtotime ( '-1 day' , strtotime(date('Y-m-d H:i:s'))) )
            ];

            $this->shopprinterrequest_model->customDelete($where);
        }

        public function release_queue_get($buyers = '1'): void
        {
        	return;
            // redirect 100 buyers from queue to alfred
            $buyers = intval($buyers);
            var_dump(Queue_helper::releaseQueue($buyers));
        }

        
    }
