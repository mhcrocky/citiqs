<?php
/**
 * This file contains class to export data to Microsoft Excel
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

trait CSVExportable
{
    public function exportToCSV($params = [], $exportOption = [])
    {
        return (new ExportHandler($this, $this->dataStores))
            ->exportToCSV($params, $exportOption);
    }

    
}
