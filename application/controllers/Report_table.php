<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . "/reports/Vatreport.php";
require APPPATH . '/libraries/BaseControllerWeb.php';

class Report_table extends BaseControllerWeb
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->isLoggedIn();
    }

    function index()
    {
        exit;
//         $report = new ReservationsReport;
//         $d = $report->run()->render(null, true);
    }

    function export($vendorId)
    {

//        $dateRange1 = $this->input->post('dateRange', true);
		$report = new Vatreport([
			'vendorId' => $vendorId,
			'dateRange' => $dateRange
        ]);
		$report->run()->exportToCSV(array(
			"dataStore" => array(
				'alldata_Orders' => array(
					"columns"=>array(
						0,1
					) )
				)
			))
		->toBrowser("myreport.csv");

    }

	function export2($vendorId)
	{
//		$report = new Vatreport();
		$report = new Vatreport([
			'vendorId' => $vendorId,
			'dateRange' => $dateRange
//			"start"=>$this->params["dateRange"][0],
//			"end"=>$this->params["dateRange"][1]
		]);
		$report->run()->exportToExcel('Vatreport')->toBrowser("myreport.xlsx");
	}

}
