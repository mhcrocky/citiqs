<?php
/**
 * This file contains class to export big data to csv, ods and xlsx files
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 * 
 * 
 */

 /*
    $report = new MyReport;
    $report->run()->exportToCSV(array(
        "dataStores" => array(
            'salesReport' => array(
                'delimiter' => ';',
                "columns"=>array(
                    0, 1, 2, 'column3', 'column4', //if not specifying, all columns are exported
                )
            )
        )
    ))->toBrowser("myreport.csv");
 * 
 */


namespace koolreport\excel;
use \koolreport\core\Utility as Util;

trait BigSpreadsheetExportable
{
    public function exportToCSV($paramsOrView = [], $setting = [])
    {
        $exportHandler = new BigSpreadsheetExportHandler($this, $this->dataStores);
        //user ->{"property"} to avoid strict mode warning
        $this->{"excelExportHandler"} = $exportHandler;
        return $exportHandler
            ->exportToCSV($paramsOrView, $setting);
    }

    public function exportToODS($paramsOrView = [], $setting = [])
    {
        $exportHandler = new BigSpreadsheetExportHandler($this, $this->dataStores);
        //user ->{"property"} to avoid strict mode warning
        $this->{"excelExportHandler"} = $exportHandler;
        return $exportHandler
            ->exportToODS($paramsOrView, $setting);
    }

    public function exportToXLSX($paramsOrView = [], $setting = [])
    {
        $exportHandler = new BigSpreadsheetExportHandler($this, $this->dataStores);
        //user ->{"property"} to avoid strict mode warning
        $this->{"excelExportHandler"} = $exportHandler;
        return $exportHandler
            ->exportToXLSX($paramsOrView, $setting);
    }
    
}
