<?php
/**
 * This file contains class the handle to file generated
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#regular-license
 * @license https://www.koolreport.com/license#extended-license
 */

namespace koolreport\excel;
use \koolreport\core\Utility as Util;
use \PhpOffice\PhpSpreadsheet as ps;

class ExportHandler
{
    protected $report;
    protected $useLocalTempFolder = false;
    protected $excelExport;
    protected $pivotExcelExport;
    protected $setting = [];
    protected $tablePositions = [];
    protected $sheetInfo = [
        'tablePositions' => [],
        'tableSheet' => [],
        'tableAutoId' => 0,
        'chartAutoId' => 0,
    ];
    protected $widgetParams = [];
    
    public function __construct($report, $dataStores)
    {
        $this->report = $report;
        $this->dataStores = $dataStores;
    }

    public function setting($params)
    {
        $this->setting = array_merge($this->setting, $params);
    }

    public function setWidgetParams($name, $params)
    {
        $this->widgetParams[$name] = $params;
    }

    public function getWidgetParams($name)
    {
        return Util::get($this->widgetParams, $name, null);
    }

    public function dataStore($name)
    {
        return $this->report->dataStore($name);
    }

    protected function getDataStoreType($dataStore) 
    {
        if (! $dataStore) {
            return 'table';
        }
        if (is_string($dataStore)) {
            return 'table';
        } elseif (is_array($dataStore)) {
            $meta = Util::get($dataStore, ['meta', 'columns'], []);
            $row = Util::get($dataStore, ['data', 0], []);
        } else {
            $meta = $dataStore->meta()['columns'];
            $dataStore->popStart();
            $row = $dataStore->pop();
            if (empty($row)) $row = [];
        }
        $colNames = ! empty($row) ? array_keys($row) : [];
        foreach ($colNames as $colName) {
            $type = Util::get($meta, [$colName, 'type'], '');
            if ($type === 'dimension')
                return 'pivottable';
        }
        return 'table';
    }

    protected function getExportClass($type) 
    {
        switch ($type) {
            case 'table':
                $export = '\koolreport\excel\Table';
                break;
            case 'chart':
                $export = '\koolreport\excel\Chart';
                break;
            case 'pivottable':
                $export = '\koolreport\excel\PivotTable';
                break;
            case 'text':
            default:
                $export = '\koolreport\excel\Text';
        }
        return $export;
    }

    public function exportToExcel($paramsOrView = [], $setting = [])
    {
        $spreadsheet = new ps\Spreadsheet();
        if (is_string($paramsOrView)) {
            $this->setting($setting);
            $view = $paramsOrView;
            $currentDir = dirname(Util::getClassPath($this->report));
            $tplPath1 = $currentDir."/".$view.".view.php";
            $tplPath2 = $currentDir."/".$view.".excel.php";
            if (is_file($tplPath2)) {
                $oldActiveReport = (isset($GLOBALS["__ACTIVE_KOOLREPORT__"])) 
                    ? $GLOBALS["__ACTIVE_KOOLREPORT__"] : null;
                $GLOBALS["__ACTIVE_KOOLREPORT__"] = $this->report;
                ob_start();
                include($tplPath2);
                $tplContent = ob_get_clean();
                if ($oldActiveReport === null) {
                    unset($GLOBALS["__ACTIVE_KOOLREPORT__"]);
                } else {
                    $GLOBALS["__ACTIVE_KOOLREPORT__"] = $oldActiveReport;
                }
            } elseif (is_file($tplPath1))  {
                $tplContent = $this->report->render($view, true);
            } else {
                throw new \Exception("Could not found excel export template 
                    file $tplPath1 or $tplPath2");
            }
            // $tplContent = str_replace('<', '&lt;', $tplContent);

            libxml_use_internal_errors(true);
            $doc = new \DomDocument();
            $doc->loadHTML($tplContent);
            $metas = $doc->getElementsByTagName("meta");

            $properties = $spreadsheet->getProperties();
            $metaNames = ['creator', 'title', 'description', 'subject', 'keywords', 'category'];
            foreach ($metas as $meta) {
                $nameProperty = $meta->getAttribute('name');
                if (! in_array($nameProperty, $metaNames)) continue;
                $value = $meta->getAttribute('content');
                $method = "set$nameProperty"; 
                $properties->{$method}($value);
            }

            $chartDataSheet = new ps\Worksheet\Worksheet($spreadsheet, 'chart_data');
            $spreadsheet->addSheet($chartDataSheet);
            if (Util::get($this->setting, 'hideChartDataSheet')) {
                $chartDataSheet->setSheetState(ps\Worksheet\Worksheet::SHEETSTATE_HIDDEN);
            }

            function isJson($string) {
                $firstChar = mb_substr($string, 0, 1);
                $lastChar = mb_substr($string, -1);
                if (($firstChar !== "{" && $firstChar !== "[") ||
                    ($lastChar !== "}" && $lastChar !== "]")) {
                    return false;
                }
                json_decode($string);
                $isJson = json_last_error() == JSON_ERROR_NONE;
                return $isJson;
            }
            $xpath = new \DomXPath($doc);
            $sheetXmls = $xpath->query("*/div");
            $i = 0;
            foreach ($sheetXmls as $sheetXml) {
                $sheetName = $sheetXml->getAttribute('sheet-name');
                $sheetName = ! empty($sheetName) ? $sheetName : "Sheet" . ($i+1);
                if ($i === 0) {
                    $sheet = $spreadsheet->getSheet(0);
                    $sheet->setTitle($sheetName);
                }
                else {
                    $sheet = new ps\Worksheet\Worksheet($spreadsheet, $sheetName);
                    $spreadsheet->addSheet($sheet, $i);
                }

                $contentXmls = $xpath->query("div", $sheetXml);
                foreach ($contentXmls as $contentXml) {
                    $contentStr = trim($contentXml->textContent);
                    // echo "contentStr=$contentStr"; exit;
                    $content = isJson($contentStr) ? 
                        json_decode($contentStr, true) : [
                            'type' => 'text',
                            'text' => $contentStr
                        ];
                    if (isset($content['name'])) {
                        $content = $this->getWidgetParams($content['name']);
                        // echo "content="; print_r($content); exit;
                    }
                    if (isset($content['dataSource'])) {
                        $content['dataSource'] = 
                            $this->report->dataStore($content['dataSource']);
                    } elseif (isset($content['excelDataSource'])) {
                        $content['dataSource'] = $content['excelDataSource'];
                    } 

                    $contentAttrs = [];
                    $attrs = $contentXml->attributes;
                    foreach ($attrs as $attr) {
                        $contentAttrs[$attr->nodeName] = $attr->nodeValue;
                    }
                    $content['attributes'] = $contentAttrs;

                    $type = Util::get($content, 'type', 'text');
                    $export = $this->getExportClass($type);
                    $export::saveContentToSheet(
                        $content, $sheet, $chartDataSheet, $this->sheetInfo);
                }
                $i++;
            }
        } elseif (is_array($paramsOrView)) {
            $this->setting = $params = $paramsOrView;
            $properties = Util::get($params,"properties",array());
            
            $spreadsheet->getProperties()
            ->setCreator(Util::get($properties,"creator","KoolReport"))
            ->setTitle(Util::get($properties,"title",""))
            ->setDescription(Util::get($properties,"description",""))
            ->setSubject(Util::get($properties,"subject",""))
            ->setKeywords(Util::get($properties,"keywords",""))
            ->setCategory(Util::get($properties,"category",""));

            $options = array();
            $dataStoreNames = Util::get($params,"dataStores",null);
            if (! isset($dataStoreNames) || ! is_array($dataStoreNames))
                $exportDataStores = $this->dataStores;
            else {
                $options = array();
                $exportDataStores = array();
                foreach ($dataStoreNames as $k => $v) {
                    if (isset($this->dataStores[$k])) {
                        $exportDataStores[$k] = $this->dataStores[$k];
                        $options[$k] = $v;
                    }
                    else if (isset($this->dataStores[$v]))
                        $exportDataStores[$v] = $this->dataStores[$v];
                }
            }
            $k=0;
            // print_r($exportDataStores); exit;
            foreach($exportDataStores as $name=>$dataStore) {
                if ($k==0) {
                    $sheet = $spreadsheet->getSheet(0);
                }
                else {
                    $sheet = new ps\Worksheet\Worksheet($spreadsheet, $name);
                    $spreadsheet->addSheet($sheet, $k);
                }
                $sheet->setTitle($name);
                $content = Util::get($options,$name,array());
                $content['dataSource'] = $dataStore;
                $type = $this->getDataStoreType($dataStore);
                $export = $this->getExportClass($type);
                $export::saveContentToSheet($content, $sheet, [], $this->sheetInfo);
                $k++;
            }
        } 
        // exit();
        
        $spreadsheet->setActiveSheetIndex(0);
        
        $tmpFilePath = $this->getTempFolder()."/".Util::getUniqueId().".xlsx";
        $objWriter = ps\IOFactory::createWriter($spreadsheet, "Xlsx");
        $objWriter->setPreCalculateFormulas(false);
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save($tmpFilePath);

        return new FileHandler($tmpFilePath);
    }

    public function exportToCSV($params = [], $setting = []) {
        $content = "";
        $options = array();
        if (is_string($params)) {
            $dsName = $params;
            $this->setting($setting);
            $exportDataStores = [$dsName => $this->report->datastore($dsName)];
            $options = [$dsName => $setting];
            $bom = Util::get($setting,"BOM",false);
        } elseif (is_array($params)) {
            $this->setting($params);
            $bom = Util::get($params,"BOM",false);
            $dataStoreNames = Util::get($params,"dataStores",null);
            if (is_string($dataStoreNames))
                $dataStoreNames = array_map('trim', explode(',', $dataStoreNames));
            if (! is_array($dataStoreNames))
                $exportDataStores = $this->dataStores;
            else {
                $options = array();
                $exportDataStores = array();
                foreach ($dataStoreNames as $k => $v) {
                    if (isset($this->dataStores[$k])) {
                        $exportDataStores[$k] = $this->dataStores[$k];
                        $options[$k] = $v;
                    }
                    else if (is_string($v) && isset($this->dataStores[$v]))
                        $exportDataStores[$v] = $this->dataStores[$v];

                        
                }
            }
        }
        foreach($exportDataStores as $name=>$ds) {
            $option = Util::get($options, $name, []);
            $colMetas = $ds->meta()['columns'];
            $optCols = Util::get($option, 'columns', array_keys($colMetas));
            $expColKeys = [];
            $expColLabels = [];
            $i = 0;
            foreach ($colMetas as $colKey => $colMeta) {
                $label = Util::get($colMeta, 'label', $colKey);
                foreach ($optCols as $col)
                    if ($col === $i || $col === $colKey || $col === $label) {
                        $expColKeys[] = $colKey;
                        $expColLabels[] = $label;
                    }
                $i++;
            }

            $delimiter = Util::get($option, 'fieldSeparator', ',');
            $delimiter = Util::get($option, 'delimiter', $delimiter);
            $delimiter = Util::get($option, 'fieldDelimiter', $delimiter);
            $showHeader = Util::get($option,"showHeader", true);
            if ($showHeader) $content .= implode($delimiter, $expColLabels) . "\n";

            $ds->popStart();
            while ($row = $ds->pop()) {
                foreach ($expColKeys as $colKey) {
                    $content .= Util::format($row[$colKey], $colMetas[$colKey])
                        . $delimiter;
                }
                $content = substr($content, 0, -1) . "\n";
            }
        }

        $tmpFilePath = $this->getTempFolder()."/".Util::getUniqueId().".csv";
        $file = fopen($tmpFilePath, 'w') or die('Cannot open file:  '.$tmpFilePath);
        fwrite($file, ($bom)?(chr(239).chr(187).chr(191).$content):($content));
        fclose($file);

        return new FileHandler($tmpFilePath);
    }

    protected function getTempFolder()
    {
        $this->useLocalTempFolder = Util::get($this->setting, "useLocalTempFolder", false);
        if($this->useLocalTempFolder)
        {
            // $path = dirname(__FILE__);
            $path = dirname($_SERVER['SCRIPT_FILENAME']);
            if(!is_dir(realpath($path)."/tmp"))
            {
                mkdir(realpath($path)."/tmp");
            }
            return realpath($path)."/tmp";
        }
        return sys_get_temp_dir();
    }

}