<?php
/**
 * This file contains class to pull data from big csv, ods and xlsx files
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

/*
class MyReport extends \koolreport\KoolReport
{
    public function settings()
    {
        return array(
            "dataSources"=>array(
                "sale_source"=>array(
                    "class"=>"\koolreport\excel\BigDataSource",
                    "filePath"=>"../data/bigdata.xlsx",
                    "fileType"=>"xlsx", //"xlsx", "ods" or "csv". Only needed if file extension is different from its type
                    "charset"=>"utf8", //"UTF-16LE", etc
                    "firstRowData"=>false, //Set true if first row is data and not the header,
                    "fieldDelimiter"=>";",
                    "sheetName"=>"sheet1", 
                    "sheetIndex"=>0,
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
 */
namespace koolreport\excel;

use \koolreport\core\DataSource;
use \koolreport\core\Utility as Util;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class BigSpreadsheetDataSource extends DataSource
{
    public function start()
    {
        $filePath = Util::get($this->params, "filePath");
        $fileType = Util::get($this->params, 'fileType', null);
        $charset = Util::get($this->params, "charset", null);
        $firstRowData = Util::get($this->params, "firstRowData", false);
        $sheetName = Util::get($this->params, "sheetName", null);
        $sheetIndex = Util::get($this->params, "sheetIndex", null);
        $fieldSeparator = Util::get($this->params, "fieldSeparator", ",");
        $fieldDelimiter = Util::get($this->params, "fieldDelimiter", $fieldSeparator);

        $method = $fileType === 'xlsx' ? 'createXLSXReader'
            : ($fileType === 'ods' ? 'createODSReader'
            : ($fileType === 'csv' ? 'createCSVReader'
            : 'createReaderFromFile'));
        $reader = ReaderEntityFactory::{$method}($filePath);
        if (method_exists($reader, 'setFieldDelimiter'))
            $reader->setFieldDelimiter($fieldDelimiter);
        if (method_exists($reader, 'setShouldFormatDates')) 
            $reader->setShouldFormatDates(true);
        if (method_exists($reader, 'setEncoding') && isset($charset)) {
            $reader->setEncoding($charset);
        }
        $reader->open($filePath);
        $metaSent = false;
        $cMetas = [];
        $cNames = [];
        $firstRow = null;
        foreach ($reader->getSheetIterator() as $sheet) {
            if (isset($sheetName) && $sheetName !== $sheet->getName()) 
                continue;
            if (! isset($sheetName) && isset($sheetIndex) && 
                $sheetIndex !== $sheet->getIndex() + 1) 
                continue;
            foreach ($sheet->getRowIterator() as $i => $row) {
                $rowArr = $row->toArray();
                if (! isset($firstRow)) {
                    $firstRow = $rowArr;
                    foreach ($firstRow as $i => $value) {
                        $cName = $firstRowData ? "Column $i" : $value;
                        $cNames[$i] = $cName;
                    }
                    if (! $firstRowData) continue;
                } 
                if (! $metaSent) {
                    foreach ($firstRow as $i => $value) {
                        $type = is_numeric($value) ? 'number' : 'string';
                        $cMetas[$cNames[$i]] = ['type' => $type];
                    }
                    $meta = ['columns' => $cMetas];
                    $this->sendMeta($meta, $this);   
                    $metaSent = true;
                    $this->startInput(null);
                    if ($firstRowData) {
                        $firstRow = array_combine($cNames, $firstRow);
                        $this->next($firstRow, $this);
                        continue;
                    }
                }
                foreach ($cNames as $i => $cName) {
                    $rowArr[$cName] = Util::get($rowArr, $i);
                    unset($rowArr[$i]);
                }
                // $rowArr = array_combine($cNames, $rowArr);
                $this->next($rowArr, $this);
            }
        }
        if (! $metaSent) {
            foreach ($cNames as $cName) $cMetas[$cName] = [];
            $meta = ['columns' => $cMetas];
            $this->sendMeta($meta, $this);   
            $this->startInput(null);
        }
        $reader->close();
        $this->endInput(null);
    }
}
