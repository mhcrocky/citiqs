<?php
/**
 * This file contains class to export data to Microsoft Excel
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

/*
    $report = new MyReport;
    $report->run()->exportToExcel(array(
        "dataStores" => array(
            'salesReport' => array(
                "columns"=>array(
                    0, 1, 2, 'column3', 'column4' //if not specifying, all columns are exported
                )
            )
        )
    ))->toBrowser("myreport.xlsx");

    

 */

namespace koolreport\excel;

use koolreport\core\Utility as Util;

trait ExcelExportable
{

    public function exportToExcel($params = [], $setting = [])
    {
        $exportHandler = new ExportHandler($this, $this->dataStores);
        //user ->{"property"} to avoid strict mode warning
        $this->{"excelExportHandler"} = $exportHandler;
        return $exportHandler->exportToExcel($params, $setting);
    }

}
