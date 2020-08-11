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

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use \koolreport\core\Utility as Util;

class BigSpreadsheetExportHandler
{
    protected $report;
    protected $useLocalTempFolder = false;
    protected $excelExport;
    protected $pivotExcelExport;
    protected $setting = [];
    protected $sheetInfo = [];

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

    protected function getDataStoreType($dataStore)
    {
        if (!$dataStore) {
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
        }
        $colNames = array_keys($row);
        foreach ($colNames as $colName) {
            $type = Util::get($meta, [$colName, 'type'], '');
            if ($type === 'dimension') {
                return 'pivottable';
            }

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

    protected function exportToSpreadsheet($type = 'csv', $paramsOrView = [], $setting = [])
    {
        if (is_string($paramsOrView)) {
            $this->setting($setting);
        } elseif (is_array($paramsOrView)) {
            $this->setting($paramsOrView);
        }
        $writer = WriterEntityFactory::createWriter($type);
        if ($type === 'csv') {
            $bom = Util::get($this->setting, 'BOM', false);
            $writer->setShouldAddBOM($bom);
            $fieldDelimiter = Util::get($this->setting, 'fieldSeparator', ',');
            $fieldDelimiter = Util::get($this->setting, 'delimiter', $fieldDelimiter);
            $fieldDelimiter = Util::get($this->setting, 'fieldDelimiter', $fieldDelimiter);
            $writer->setFieldDelimiter($fieldDelimiter);
        }
        $tempFolder = $this->getTempFolder();
        // $writer->setTempFolder($tempFolder);
        $tmpFilePath = $tempFolder . "/" . Util::getUniqueId() . $type;
        $writer->openToFile($tmpFilePath);
        if (is_string($paramsOrView)) {
            $view = $paramsOrView;
            $currentDir = dirname(Util::getClassPath($this->report));
            $tplPath = $currentDir . "/" . $view . ".view.php";
            if (is_file($tplPath)) {
                $tplContent = $this->report->render($view, true);
            } else {
                throw new \Exception("Could not found excel export template
                    file $tplPath");
            }
            // $tplContent = str_replace('<', '&lt;', $tplContent);

            libxml_use_internal_errors(true);
            $doc = new \DomDocument();
            $doc->loadHTML($tplContent);

            // error_reporting(0);
            function isJson($string)
            {
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
                if (method_exists($writer, 'getCurrentSheet')) {
                    $sheetName = $sheetXml->getAttribute('sheet-name');
                    $sheetName = !empty($sheetName) ? $sheetName : "Sheet" . ($i + 1);
                    $sheet = $i === 0 ?
                    $writer->getCurrentSheet() : $writer->addNewSheetAndMakeItCurrent();
                    $sheet->setName($sheetName);
                }

                $contentXmls = $xpath->query("div", $sheetXml);
                foreach ($contentXmls as $contentXml) {
                    $contentStr = trim($contentXml->textContent);
                    // echo "contentStr=$contentStr"; exit;
                    $content = isJson($contentStr) ?
                    json_decode($contentStr, true) : [
                        'type' => 'text',
                        'text' => $contentStr,
                    ];
                    if (isset($content['name'])) {
                        $content = $this->getWidgetParams($content['name']);
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
                    if ($type !== 'text' && $type !== 'table') {
                        continue;
                    }

                    $exportClass = $this->getExportClass($type);
                    $exportClass::saveContentToSpreadsheet($content, $writer, $this->sheetInfo);
                }
                $i++;
            }
        } elseif (is_array($paramsOrView)) {
            $options = [];
            $dataStoreNames = Util::get($paramsOrView, "dataStores", null);
            if (!isset($dataStoreNames) || !is_array($dataStoreNames)) {
                $exportDataStores = $this->dataStores;
            } else {
                $exportDataStores = [];
                foreach ($dataStoreNames as $k => $v) {
                    if (isset($this->dataStores[$k])) {
                        $exportDataStores[$k] = $this->dataStores[$k];
                        $options[$k] = $v;
                    } else if (isset($this->dataStores[$v])) {
                        $exportDataStores[$v] = $this->dataStores[$v];
                    }

                }
            }
            $k = 0;
            foreach ($exportDataStores as $name => $dataStore) {
                if (method_exists($writer, 'getCurrentSheet')) {
                    $sheet = $k === 0 ?
                    $writer->getCurrentSheet() : $writer->addNewSheetAndMakeItCurrent();
                    $sheet->setName($name);
                }
                $content = Util::get($options, $name, array());
                $content['dataSource'] = $dataStore;
                $type = $this->getDataStoreType($dataStore);
                if ($type !== 'text' && $type !== 'table') {
                    continue;
                }

                $exportClass = $this->getExportClass($type);
                $exportClass::saveContentToSpreadsheet($content, $writer, $this->sheetInfo);
                $k++;
            }
        }
        // exit();
        $writer->close();
        return new FileHandler($tmpFilePath);
    }

    public function exportToXLSX($paramsOrView = [], $setting = [])
    {
        return $this->exportToSpreadsheet('xlsx', $paramsOrView, $setting);
    }

    public function exportToCSV($paramsOrView = [], $setting = [])
    {

        return $this->exportToSpreadsheet('csv', $paramsOrView, $setting);
    }

    public function exportToODS($paramsOrView = [], $setting = [])
    {
        return $this->exportToSpreadsheet('ods', $paramsOrView, $setting);
    }

    protected function getTempFolder()
    {
        $this->useLocalTempFolder = Util::get($this->setting, "useLocalTempFolder", false);
        if ($this->useLocalTempFolder) {
            // $path = dirname(__FILE__);
            $path = dirname($_SERVER['SCRIPT_FILENAME']);
            if (!is_dir(realpath($path) . "/tmp")) {
                mkdir(realpath($path) . "/tmp");
            }
            return realpath($path) . "/tmp";
        }
        return sys_get_temp_dir();
    }

}
