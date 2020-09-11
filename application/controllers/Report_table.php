<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("./vendor/autoload.php");

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

    function export()
    {
		$report = new Vatreport;
		$report->run()->exportToXLSX(array(
			"dataStore" => array(
				'alldata_Orders' )
				)
			)
		->toBrowser("myreport.xlsx");

    }

	function export2()
	{
		$report = new Vatreport;
		$report->run()->exportToExcel('alldata_Orders')->toBrowser("myreport.xlsx");
	}

}
