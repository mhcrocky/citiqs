<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class  Thuishavenagenda extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
		$this->load->model('bookandpay_model');
		$this->load->model('bookandpayagenda_model');
        $this->load->library('language', array('controller' => $this->router->class));
    }

    public function index($customer)
    {
    	if(empty($customer)){
    		$customer = '1';
		}

		$_SESSION['customer']=$customer;

		$data['agenda'] = $this->bookandpayagenda_model->getbookingagenda($customer);

//		var_dump($data);
//		print("<pre>".print_r($data,true)."</pre>");
//		die();

        $this->global['pageTitle'] = 'TIQS : TESTSCREEN';
		$this->loadViews("thuishaven-agenda", $this->global, $data, 'nofooter', 'noheader'); // payment screen
	}

}

