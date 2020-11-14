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
    	$report = new Vatreport([
			'vendorId' => $vendorId,
			'dateRange' => $dateRange
		]);
		$report->run()->exportToXLSX(array(
			"dataStore" => array(
				'alldata_orderlines')
			)
		)
			->toBrowser("myreport.xlsx");
	}

	function exportemails($vendorId)
	{
		$report = new Vatreport([
			'vendorId' => $vendorId,
			'dateRange' => $dateRangeEmails
		]);
		$report->run()->exportToXLSX(array(
			"dataStore" => array(
				'alldata_Emails' => array(
					"columns"=>array(
						0,1
					) )
			)
		))
			->toBrowser("myemails.xlsx");
	}

	function exportemails1($vendorId)
	{

		$report = new Vatreport([
			'vendorId' => $vendorId,
			'dateRange' => $dateRangeEmails
		]);
		$report->run()->exportToExcel('Vatreport')->toBrowser("myreport.xlsx");
	}

}
