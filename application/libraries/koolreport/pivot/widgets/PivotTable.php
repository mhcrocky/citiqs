<?php
/* Usage
    PivotTable::create(array(
        'template' => 'PivotTable-Bun',
        "dataStore" => $dataStore,
        "rowDimension" => "row",
        "columnDimension" => "column",
        "measures"=>array(
            "dollar_sales - sum",
            'dollar_sales - count',
            'dollar_sales - avg',
        ),
        'rowSort' => array(
            // 'orderMonth' => function($a, $b) {
            // return (int)$a > (int)$b;
            // },
            // 'orderDay' => function($a, $b) {
            // return (int)$a > (int)$b;
            // },
            'dollar_sales - sum' => 'desc',
        ),
        'columnSort' => array(
            'orderMonth' => function ($a, $b) {
                return (int) $a < (int) $b;
            },
            // 'dollar_sales - sum' => 'desc',
            // 'orderYear' => 'desc',
        ),
        'rowCollapseLevels' => array(0, 1),
        'columnCollapseLevels' => array(0),
        'width' => '100%',
        // 'headerMap' => array(
        //     'dollar_sales - sum' => 'Sales (in USD)',
        //     'dollar_sales - count' => 'Number of Sales',
        // ),
        'headerMap' => function($v, $f) {
            if ($v === 'dollar_sales - sum')
                $v = 'Sales (in USD)';
            if ($v === 'dollar_sales - count')
                $v = 'Number of Sales';
            if ($f === 'orderYear')
                $v = 'Year ' . $v;
            return $v;
        },
        'map' => array(
            'rowField' => function($rowField, $fieldInfo) {
                return $rowField;
            },
            'columnField' => function($colField, $fieldInfo) {
                return $colField;
            },
            'dataField' => function($dataField, $fieldInfo) {
                $v = $dataField;
                if ($v === 'dollar_sales - sum')
                    $v = 'Sales (in USD)';
                else if ($v === 'dollar_sales - count')
                    $v = 'Number of Sales';
                return $v;
            },
            'waitingField' => function($waitingField, $fieldInfo) {
                return $waitingField;
            },
            'rowHeader' => function($rowHeader, $headerInfo) {
                $v = $rowHeader;
                if (isset($headerInfo['childOrder']))
                    $v = $headerInfo['childOrder'] . ". " . $v;
                return $v;
            },
            'columnHeader' => function($colHeader, $headerInfo) {
                $v = $colHeader;
                if ($headerInfo['fieldName'] === 'orderYear')
                    $v = 'Year-' . $v;
                else if ($headerInfo['fieldName'] === 'orderQuarter')
                    $v = 'Quarter-' . $v;
                if (isset($headerInfo['childOrder']))
                    $v = $headerInfo['childOrder'] . ". " . $v;
                return $v;
            },
            'dataCell' => function($value, $cellInfo) {
                $rfOrder = $cellInfo['row']['fieldOrder'];
                $cfOrder = $cellInfo['column']['fieldOrder'];
                $df = $cellInfo['fieldName'];
                $dfOrder = $cellInfo['fieldOrder'];
                // return "$rfOrder:$cfOrder:$df. $value";
                
                return $cellInfo['formattedValue'];
            },
        ),
        // 'dataMap' => function($v, $f) {return $v;},
        'cssClass' => array(
            'rowField' => function($rowField) {
                return $rowField;
            },
            'columnField' => function($colField) {
                return $colField;
            },
            'dataField' => function($dataField) {
                return $dataField;
            },
            'columnHeader' => function ($columnfield, $header) {
                return 'colHeader';
            },
            'rowHeader' => 'rowHeader',
            'dataCell' => function ($dataField, $value) {
                if ($dataField === 'dollar_sales - sum' && $value > 20000) {
                    return 'green';
                }
            },
        ),
        // 'hideSubtotalRow' => true,
        // 'hideSubtotalColumn' => true,
        'showDataHeaders' => true,
    ));
 **/

namespace koolreport\pivot\widgets;

use \koolreport\core\Utility as Util;
use \koolreport\core\Widget;
use \koolreport\pivot\PivotUtil;

class PivotTable extends Widget
{
    protected $name;

    protected $dataStore;
    protected $emptyValue;
    protected $totalName;
    protected $rowCollapseLevels;
    protected $colCollapseLevels;
    protected $width;
    protected $cssClass;

    public function version()
    {
        return "6.1.2";
    }

    protected function resourceSettings()
    {
        return array(
            "library"=>array("font-awesome"),
            "folder"=>"assets",
            "js"=>array(
                "PivotTable.js",
            ),
            "css"=>array(
                "PivotTable.css",
            )
        );
    }

    protected function onInit()
    {
        $this->name = Util::get($this->params, 'id', null);
        $this->name = Util::get($this->params, 'name', $this->name);
        $this->useAutoName("pivotTable_");

        $this->useDataSource();
        $this->template = Util::get($this->params, 'template', 'PivotTable');
        $this->emptyValue = Util::get($this->params, 'emptyValue', '-');
        $this->totalName = Util::get($this->params, 'totalName', 'Total');
        $this->rowCollapseLevels = Util::get($this->params, 'rowCollapseLevels', array());
        $this->colCollapseLevels = Util::get($this->params, 'columnCollapseLevels', array());
        $this->width = Util::get($this->params, 'width', null);
        $this->cssClass = Util::get($this->params, 'cssClass', array());
        $this->hideSubTotalRows = Util::get($this->params, 'hideSubtotalRows', 
            Util::get($this->params, 'hideSubtotalRow', 
            Util::get($this->params, 'hideSubTotalRows', false)));
        $this->hideSubTotalColumns = Util::get($this->params, 'hideSubtotalColumns', 
            Util::get($this->params, 'hideSubtotalColumn', 
            Util::get($this->params, 'hideSubTotalColumns', false)));
        $this->hideGrandTotalRow = Util::get($this->params, 'hideGrandTotalRow', false);
        $this->hideGrandTotalColumn = Util::get($this->params, 'hideGrandTotalColumn', false);
        $this->showDataHeaders = Util::get($this->params, 'showDataHeaders', false);
        $this->selectable = Util::get($this->params, 'selectable', false);
        $this->clientEvents = Util::get($this->params, 'clientEvents', []);
    }

    protected function onRender()
    {
        if (!$this->dataStore) {
            return array();
        }

        $dataStore = $this->dataStore;
        $meta = $dataStore->meta()['columns'];

        $pivotUtil = new PivotUtil($this->dataStore, $this->params);
        $FieldsNodesIndexes = $pivotUtil->getFieldsNodesIndexes();

        $this->paging = Util::get($this->params, 'paging', array());
        $paging = $this->paging;
        $pageSize = Util::get($this->paging, 'size', 10);
        $pageSizeSelect = Util::get($this->paging, 'sizeSelect', array(5, 10, 20, 50, 100));

        // Util::prettyPrint($meta);
        // Util::prettyPrint($dataStore->data());
        // Util::prettyPrint($FieldsNodesIndexes);
        $this->template($this->template, array_merge(
            array(
                'uniqueId' => $this->name,
                'totalName' => $this->totalName,
                'emptyValue' => $this->emptyValue,
                'rowCollapseLevels' => $this->rowCollapseLevels,
                'colCollapseLevels' => $this->colCollapseLevels,
                'width' => $this->width,
                'pageSize' => $pageSize,
                'pageSizeSelect' => $pageSizeSelect,
                'cssClass' => $this->cssClass,
                'hideSubTotalRows' => $this->hideSubTotalRows,
                'hideSubTotalColumns' => $this->hideSubTotalColumns,
                'hideGrandTotalRow' => $this->hideGrandTotalRow,
                'hideGrandTotalColumn' => $this->hideGrandTotalColumn,
            ),
            $FieldsNodesIndexes
        ));
    }
}
