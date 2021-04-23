<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include(APPPATH . '/libraries/koolreport/core/autoload.php');

require APPPATH . '/libraries/BaseControllerWeb.php';

use \koolreport\drilldown\DrillDown;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\clients\Bootstrap;


class Finance extends BaseControllerWeb
{
	private $vendor_id;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('clearings_model');
		$this->load->helper('country_helper');
		$this->load->library('language', array('controller' => $this->router->class));
		$this->isLoggedIn();
		$this->vendor_id = $this->session->userdata("userId");
	}

	public function index()
	{ 
		$data['title'] = 'invoices';
		$this->global['pageTitle'] = 'TIQS: Invoices';
		$this->loadViews("finance/reports", $this->global, $data, 'footerbusiness', 'headerbusiness');
	}

	public function get_marketing_data(){
		$context = stream_context_create([
            "http" => [
                "header" => "authtoken:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidGlxc3dlYiIsIm5hbWUiOiJ0aXFzd2ViIiwicGFzc3dvcmQiOm51bGwsIkFQSV9USU1FIjoxNTgyNTQ2NTc1fQ.q7ssJqcwsXhuNVDyspGYh_KV7_JsbwS8vq2TT9R-MGk"
                ]
            ]);
            $data = file_get_contents("https://tiqs.com/backoffice/admin/api/invoice/data/".$this->vendor_id, false, $context );
            echo $data;
	}

	public function clearing()
	{
		$data['title'] = 'clearing';
		$this->global['pageTitle'] = 'TIQS: Clearing';
		$this->loadViews("finance/clearing", $this->global, $data, 'footerbusiness', 'headerbusiness');
	}

	public function get_clearings()
	{
		$data = $this->clearings_model->get_clearings($this->vendor_id);
		echo json_encode($data);
	}


}
