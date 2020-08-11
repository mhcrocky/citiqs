<?php
/**
 * This file contain trait to make KoolReport able to export
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#regular-license
 * @license https://www.koolreport.com/license#extended-license
 */

/* 
 * 
 * To use the ExportPDF
 * 
 * class MyReport extends \koolreport\KoolReport
 * {
 *      use \koolreport\export\Export;
 * 
 * }
 * 
 * $report = new MyReport;
 * $report->run();
 * $report->export()->pdf(array(
        "chromeBinary" => "C:\Program Files (x86)\Google\Chrome\Application\chrome",
        "format"=>"A4",
        "orientation"=>"portrait"
    ))->toBrowser('file.pdf');
 * 
 * 
 */

namespace koolreport\export;

trait Exportable
{
    public function export($view=null)
    {
        return new Handler($this,$view);
        //This function load the view to return a View object
    }    
}
