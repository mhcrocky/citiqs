<?php
/* Usage
    PivotMatrix::create(array(
        "name" => "pivotMatrix1",
        'template' => 'PivotMatrix-Bun',
        'dataSource' => $this->dataStore('sales'),
        // "measures"=>array(
        //     "dollar_sales - sum", 
        // ),
        'rowSort' => array(
            'dollar_sales - sum' => 'desc',
            'productLine' => 'desc',
        ),
        'columnSort' => array(
            'orderMonth' => function($a, $b) {
                return (int)$a < (int)$b;
            },
        ),
        // 'columnExpandLevel' => 0,
        // 'rowExpandLevel' => 0,
        'width' => '100%',
        'height' => '800px',
        'headerMap' => function($v, $f) {
            switch ($v) {
                case 'dollar_sales - sum': return 'Total Sales';
                case 'dollar_sales - sum percent': return 'Sales Percentage';
                case 'dollar_sales - count': return 'Number of Sales';
                case 'dollar_sales - avg': return 'Average Sales';
                case 'orderYear': return 'Year';
                case 'orderMonth': return 'Month';
                case 'orderDay': return 'Day';
                case 'customerName': return 'Customer';
                case 'productLine': return 'Category';
                case 'productName': return 'Product';
            }
            $r = $v;
            if ($f === 'orderYear')
                $r = 'Year ' . $v;
            $map = array(
                '1' => 'January',
                '2' => 'February',
                '3' => 'March',
                '4' => 'April',
                '5' => 'May',
                '6' => 'June',
                '7' => 'July',
                '8' => 'August',
                '9' => 'September',
                '10' => 'October',
                '11' => 'November',
                '12' => 'December',
            );
            // if ($f === 'orderMonth')
            //     $r = "<a target='_blank' href='../../file_$v.pdf'>" . $map[$v] . "</a>";
            return $r;
        },
        'totalName' => 'All',
        'waitingFields' => array(
            'dollar_sales - count' => 'data', 
            'orderMonth' => 'label',
            'orderDay' => 'label',
            'productLine' => 'label',
            'productName' => 'label',
        ),
        'paging' => array(
            // 'size' => 925,
            // 'maxDisplayedPages' => 5,
            // 'sizeSelect' => array(5, 10, 20, 50, 100)
        ),
        'map' => array(
            // 'rowField' => function($rowField, $fieldInfo) {
            //     return $rowField;
            // },
            // 'columnField' => function($colField, $fieldInfo) {
            //     return $colField;
            // },
            'dataField' => function($dataField, $fieldInfo) {
                // Util::prettyPrint($fieldInfo);
                $v = $dataField;
                if ($v === 'dollar_sales - sum')
                    $v = 'Sales (in USD)';
                else if ($v === 'dollar_sales - count')
                    $v = 'Number of Sales';
                return $v;
            },
            // 'waitingField' => function($waitingField, $fieldInfo) {
            //     return $waitingField;
            // },
            'rowHeader' => function($rowHeader, $headerInfo) {
                // Util::prettyPrint($headerInfo);
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
                // Util::prettyPrint($cellInfo);
                $rfOrder = $cellInfo['row']['fieldOrder'];
                $cfOrder = $cellInfo['column']['fieldOrder'];
                $df = $cellInfo['fieldName'];
                $dfOrder = $cellInfo['fieldOrder'];
                // return "$rfOrder:$cfOrder:$df. $value";
                
                return $cellInfo['formattedValue'];
            },
        ),
        'cssClass' => array(
            'waitingField' => function($field) {
                return 'wf-' . $field;
            },
            'dataField' => function($field) {
                return 'df-' . $field;
            },
            'columnField' => function($field) {
                return 'cf-' . $field;
            },
            'rowField' => function($field) {
                return 'rf-' . $field;
            },
            'columnHeader' => function($field, $header) {
                return 'ch-' . $header;
            },
            'rowHeader' => function($field, $header) {
                return 'rh-' . $header;
            },
            'dataCell' => function($dataField, $value) {
                return 'dc-' . $value;
            },
        ),
        'clientEvents' => array(
            // 'afterFieldMove' => 'handleAfterFieldMove'
        ),
        // 'hideSubTotalRows' => true,
        'hideSubTotalColumns' => true,
        'showDataHeaders' => true,
    ));
 **/

namespace koolreport\pivot\widgets;
use \koolreport\pivot\PivotUtil;
use \koolreport\core\Widget;
use \koolreport\core\Utility as Util;

class PivotMatrix extends Widget
{
    private static $instanceId = 0;
    protected $name;
    protected $width;
    protected $height;
    protected $emptyValue;
    protected $totalName;
    protected $rowCollapseLevels;
    protected $colCollapseLevels;
    protected $waitingFields;
    protected $scope;

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
                "PivotMatrix.js",
            ),
            "css"=>array(
                "PivotMatrix.css",
                "animate.min.css",
            )
        );        
    }
	
	protected function onInit()
	{
        $this->name = Util::get($this->params, 'id', null);
        $this->name = Util::get($this->params, 'name', $this->name);
        $this->useAutoName("pivotMatrix_");
        $this->pivotMatrixId = "krpm_" . $this->name;
        $this->useDataSource();

		$this->template = Util::get($this->params, 'template', 'PivotMatrix');
		$this->width = Util::get($this->params, 'width', 'auto');
		$this->height = Util::get($this->params, 'height', 'auto');
		$this->emptyValue = Util::get($this->params, 'emptyValue', '-');
		$this->totalName = Util::get($this->params,'totalName','Total');
		$this->rowCollapseLevels = Util::get($this->params,'rowCollapseLevels',array());
		$this->colCollapseLevels = Util::get($this->params,'columnCollapseLevels',array());
		$this->clientEvents = Util::get($this->params,'clientEvents',array());
		$this->rowSort = Util::get($this->params,'rowSort',array());
		$this->columnSort = Util::get($this->params,'columnSort',array());
		// echo "columnSort = "; print_r($this->columnSort); echo "<br>";
		$this->scope = Util::get($this->params,'scope',array());
		$this->columnWidth = Util::get($this->params,'columnWidth','90px');
        $this->cssClass = Util::get($this->params,'cssClass',array());
        $this->hideSubTotalRows = Util::get($this->params, 'hideSubtotalRows', 
            Util::get($this->params, 'hideSubtotalRow', 
            Util::get($this->params, 'hideSubTotalRows', false)));
        $this->hideSubTotalColumns = Util::get($this->params, 'hideSubtotalColumns', 
            Util::get($this->params, 'hideSubtotalColumn', 
            Util::get($this->params, 'hideSubTotalColumns', false)));
        $this->hideGrandTotalRow = Util::get($this->params, 'hideGrandTotalRow', false);
        $this->hideGrandTotalColumn = Util::get($this->params, 'hideGrandTotalColumn', false);
        $this->showDataHeaders = Util::get($this->params, 'showDataHeaders', false);
	}
  
	protected function onRender()
	{
		if (! $this->dataStore) return array();
        $dataStore = $this->dataStore;
        $meta = $dataStore->meta()['columns'];

        $paging = null;
        if (isset($this->params['paging'])) {
            $paging = $this->params['paging'];
            if (! is_array($paging)) $paging = array();
            $paging = array_merge(array(
                'page' => 1,
                'size' => 10,
                'maxDisplayedPages' => 5,
                'sizeSelect' => array(5, 10, 20, 50, 100)
            ), $paging);
        }
        $page = Util::get($paging, 'page', null);
        $pageSize = Util::get($paging, 'size', null);

        $scrollTopPercentage = $scrollLeftPercentage = 0;

        $isUpdate = false;
        // function jsonToArray($string) {
        //     $arr = json_decode($string, true);
        //     return json_last_error() == JSON_ERROR_NONE ? $arr : [];
        // }
        // $input = jsonToArray(file_get_contents('php://input'));
        if (isset($_POST['koolPivotUpdate'])) {
        // if (isset($input['koolPivotUpdate'])) {
            $config = json_decode($_POST['koolPivotConfig'], true); 
            // $config = $input['koolPivotConfig']; 
            if ($config['pivotMatrixId'] == $this->pivotMatrixId) {
                $isUpdate = true;
            }
        }
        if ($isUpdate) {
            $this->params['measures'] = $config['dataFields'];
            $waitingFields = $config['waitingFields'];
            $waitingFieldsType = $config['waitingFieldsType'];
            $fs = array();
            foreach ($waitingFields as $i => $field)
                $fs[$field] = $waitingFieldsType[$i];
            $this->params['waitingFields'] = $fs;
            $viewstate = json_decode($_POST['koolPivotViewstate'], true);
            // $viewstate = $input['koolPivotViewstate'];
            $paging = $viewstate["paging"];
            $scrollTopPercentage = $viewstate["scrollTopPercentage"];
            $scrollLeftPercentage = $viewstate["scrollLeftPercentage"];

			if (empty($config['rowSort'])) 
				$config['rowSort'] = [];
			if (empty($this->rowSort)) 
				$this->rowSort = [];
			foreach ($config['rowSort'] as $field => $sortField)	
				if (! empty($sortField)) {
					$this->rowSort[$field]  = $sortField;
				}
			$this->params['rowSort'] = $this->rowSort;
			
			if (empty($config['columnSort'])) 
				$config['columnSort'] = [];
			if (empty($this->columnSort)) 
				$this->columnSort = [];
			foreach ($config['columnSort'] as $field => $sortField)	
				if (! empty($sortField)) {
					$this->columnSort[$field]  = $sortField;
				}
			$this->params['columnSort'] = $this->columnSort;
			
            $this->columnWidth = $config['columnWidth'];
        }
        $pivotUtil = new PivotUtil($this->dataStore, $this->params);
        $FieldsNodesIndexes = $pivotUtil->getFieldsNodesIndexes();

        $meta = $this->dataStore->meta();
        $expandTree = $meta['pivotExpandTrees'];

        echo "<pivotmatrix id='$this->pivotMatrixId'>";
        $this->template($this->template, array_merge(
            array(
                'uniqueId' => $this->name,
                'width' => $this->width,
                'height' => $this->height,
                'totalName' => $this->totalName,
                'emptyValue' => $this->emptyValue,
                'rowCollapseLevels' => $this->rowCollapseLevels,
                'columnCollapseLevels' => $this->colCollapseLevels,
                'isUpdate' => $isUpdate,
                'clientEvents' => $this->clientEvents,
                'cssClass' => $this->cssClass,
                'hideSubTotalRows' => $this->hideSubTotalRows,
                'hideSubTotalColumns' => $this->hideSubTotalColumns,
                'hideGrandTotalRow' => $this->hideGrandTotalRow,
                'hideGrandTotalColumn' => $this->hideGrandTotalColumn,
                'config' => array(
                    'pivotId' => $meta['pivotId'],
                    'pivotRows' => $meta['pivotRows'],
                    'pivotColumns' => $meta['pivotColumns'],
                    'expandTrees' => $expandTree,
                    'pivotMatrixId' => $this->pivotMatrixId,
                    'waitingFields' => $FieldsNodesIndexes['waitingFields'],
                    'dataFields' => $FieldsNodesIndexes['dataFields'],
                    'columnFields' => $FieldsNodesIndexes['colFields'],
                    'rowFields' => $FieldsNodesIndexes['rowFields'],
                    'waitingFieldsType' => $FieldsNodesIndexes['waitingFieldsType'],
                    'dataFieldsType' => $FieldsNodesIndexes['dataFieldsType'],
                    'columnFieldsType' => $FieldsNodesIndexes['columnFieldsType'],
                    'rowFieldsType' => $FieldsNodesIndexes['rowFieldsType'],
                    'waitingFieldsSort' => $FieldsNodesIndexes['waitingFieldsSort'],
                    'dataFieldsSort' => $FieldsNodesIndexes['dataFieldsSort'],
                    'columnFieldsSort' => $FieldsNodesIndexes['columnFieldsSort'],
                    'rowFieldsSort' => $FieldsNodesIndexes['rowFieldsSort'],
                    'rowSort' => $this->rowSort,
                    'columnSort' => $this->columnSort,
                    'columnWidth' => $this->columnWidth,
                ),
                'viewstate' => array(
                    'paging' => $paging,
                    'scrollTopPercentage' => $scrollTopPercentage,
                    'scrollLeftPercentage' => $scrollLeftPercentage,
                ),
                'scope' => $this->scope
            ),
            $FieldsNodesIndexes
        ));
        echo "</pivotmatrix>";
        if ($isUpdate && isset($_POST['partialRender'])) {
            exit;
        } 
        // if ($isUpdate && isset($input['partialRender'])) exit;
	}	
}