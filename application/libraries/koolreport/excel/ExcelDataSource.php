<?php
/**
 * This file contains class to pull data from Microsoft Excel
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

/*
 * The ExcelDataSource will load the Excel data, breaking down to columns and try to determine
 * the type for the columns, the precision contain number of rows to run to determine
 * the meta data for columns.
 *
 * $firstRowData: is the first row data, usually is false, first row is column name
 * if the firstRowData is true, name column as column 1, column 2
 *
class MyReport extends \koolreport\KoolReport
{
    public function settings()
    {
        return array(
            "dataSources"=>array(
                "sale_source"=>array(
                    "class"=>"\koolreport\excel\ExcelDataSource",
                    "filePath"=>"../data/my_file.xlsx",
                    "charset"=>"utf8",
                    "firstRowData"=>false,//Set true if first row is data and not the header,
                    "sheetName"=>"sheet1", // (version >= 2.1.0)
                    "sheetIndex"=>0, // (version >= 2.1.0)
                )
            )
        );
    }

    public function setup()
    {
        $this->src('sale_source')
        ->pipe(...)
    }
}
 *
 */
namespace koolreport\excel;

use \koolreport\core\DataSource;
use \koolreport\core\Utility as Util;
use \PhpOffice\PhpSpreadsheet as ps;

class ExcelDataSource extends DataSource
{
    protected $filePath;
    protected $charset;
    protected $firstRowData;
    protected $sheetName;
    protected $sheetIndex;

    protected function onInit()
    {
        $this->filePath = Util::get($this->params, "filePath");
        $this->charset = Util::get($this->params, "charset", "utf8");
        $this->firstRowData = Util::get($this->params, "firstRowData", false);
        $this->sheetName = Util::get($this->params, "sheetName", null);
        $this->sheetIndex = Util::get($this->params, "sheetIndex", null);
    }

    protected function guessType($value)
    {
        $map = array(
            "float" => "number",
            "double" => "number",
            "int" => "number",
            "integer" => "number",
            "bool" => "number",
            "numeric" => "number",
            "string" => "string",
        );

        $type = strtolower(gettype($value));
        foreach ($map as $key => $value) {
            if (strpos($type, $key) !== false) {
                return $value;
            }
        }
        return "unknown";
    }

    public function start()
    {
        $inputFileType = ps\IOFactory::identify($this->filePath);
        $excelReader = ps\IOFactory::createReader($inputFileType);
        if (isset($this->sheetName)) {
            $excelReader->setLoadSheetsOnly($this->sheetName);
        } else if (isset($this->sheetIndex)) {
            $sheetNames = $excelReader->listWorksheetNames($this->filePath);
            $excelReader->setLoadSheetsOnly($sheetNames[$this->sheetIndex]);
        }
        $excelObj = $excelReader->load($this->filePath);

        $sheet = $excelObj->getSheet(0);
        $highestRowIndex = $sheet->getHighestDataRow(); // e.g. 10
        $highestColumn = $sheet->getHighestDataColumn(); // e.g 'F'
        $highestColumnIndex = ps\Cell\Coordinate::columnIndexFromString(
            $highestColumn); // e.g. 5

        $metaData = null;
        for ($row = 1; $row <= $highestRowIndex; ++$row) {
            $dataRow = [];
            for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                $cell = $sheet->getCellByColumnAndRow($col, $row);
                $value = $cell->getValue();
                if (ps\Shared\Date::isDateTime($cell)) {
                    $value = ps\Shared\Date::excelToDateTimeObject($value); 
                    $value = $value->format('d/m/Y');
                }
                $dataRow[] = $value;
            }
            // print_r($dataRow); echo '<br>';
            
            if ($row === 1) {
                if (!$this->firstRowData) {
                    $columnNames = $dataRow;
                    continue;
                }
                else {
                    $columnNames = array();
                    for ($i = 0; $i < $highestColumnIndex; $i++) {
                        $columnNames[] = "Column $i";
                    }
                }
            }
            if ($metaData === null) {
                $cMetas = [];
                foreach ($columnNames as $i => $cName) {
                    while (isset($cMetas[$cName])) {
                        $cName .= '_1';
                        $columnNames[$i] = $cName;
                    }
                    $cMetas[$cName] = array(
                        "type" => $this->guessType(Util::get($dataRow, $i, ''))
                    );
                }
                $metaData = array("columns" => $cMetas);
                $this->sendMeta($metaData, $this);
                $this->startInput(null);
            }
            $dataRow = array_combine($columnNames, $dataRow);
            $this->next($dataRow, $this);
        }
        $this->endInput(null);
    }
}
