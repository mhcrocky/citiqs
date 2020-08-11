<?php
/**
 * This file contains class to export data to Microsoft Excel
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 * @Usage
    $pivotReader = new PivotReader($dataStore);
    $header = $pivotReader->getHeader(array(
        "row" => array()
    ));

    $header = $pivotReader->getHeader(array(
        "row" => array(
            "parent" => array()
        )
    ));

    $header = $pivotReader->getHeader(array(
        "row" => array(
            "parent" => array(
                "customerName" => "AV Stores, Co."
            )
        )
    ));

    $header = $pivotReader->getHeader(array(
        "row" => array(
            "dimension" => "row",
            "parent" => array(
                "customerName" => "AV Stores, Co."
            ),
            "sort" => array(
                'dollar_sales - sum' => 'desc',
            ),
        ),
        "column" => array(
            "dimension" => "column",
            "parent" => array(
                "orderYear" => "2004"
            ),
            "sort" => array(
                'orderMonth' => function($a, $b) {
                    return (int)$a < (int)$b;
                },
            ),
        ),
    ));

    $data = $pivotReader->getData(array(
        "row" => array(
            "dimension" => "row",
            "parent" => array(
                "customerName" => "AV Stores, Co."
            ),
            "sort" => array(
                'dollar_sales - sum' => 'desc',
            ),
        ),
        "column" => array(
            "dimension" => "column",
            "parent" => array(
                "orderYear" => "2004"
            ),
            "sort" => array(
                'orderMonth' => function($a, $b) {
                    return (int)$a < (int)$b;
                },
            ),
        ),
    ));

    $ds = $pivotReader->getDataStore(array(
        "row" => array(
            "dimension" => "row",
            "parent" => array(
                "customerName" => "AV Stores, Co."
            ),
            "sort" => array(
                'dollar_sales - sum' => 'desc',
            ),
        ),
        "column" => array(
            "dimension" => "column",
            "parent" => array(
                "orderYear" => "2004"
            ),
            "sort" => array(
                'orderMonth' => function($a, $b) {
                    return (int)$a < (int)$b;
                },
            ),
        ),
        "measures"=>array(
            "dollar_sales - sum", 
        ),
    ));
 * 
 */
namespace koolreport\pivot;
use \koolreport\core\Utility;

class PivotReader
{
    protected $dataStore;
    protected $params;
    protected $fni;
    
    public function __construct($dataStore, $params = null) {
        $this->dataStore = $dataStore;
        $this->params = $params;
    }

    protected function isChild($parent, $node) {
        foreach ($parent as $f => $v)
            if ($node[$f] !== $v)
                return false;
        $count = count($parent);
        $keys = array_keys($node);
        //$node is already descendant. Check if it is a direct child.
        if ($count+1 < count($keys) && 
            ($node[$keys[$count+1]] !== '{{all}}'))
            return false;
        return true;
    }

    protected function buildIndexes($params) {
        $newParams = array();
        foreach (array("row", "column") as $rc) {
            if (! isset($params[$rc]))
                continue;

            $dimension = Utility::get($params[$rc], "dimension", $rc);
            $sort = Utility::get($params[$rc], "sort", null);
            
            $newParams[$rc . "Dimension"] = $dimension;
            $newParams[$rc . "Sort"] = $sort;
            $newParams = array_merge($newParams, $params);
        }
        if ($newParams != $this->params) {
            $this->params = $newParams;
            $pivotUtil = new PivotUtil($this->dataStore, $newParams);
            $this->fni = $pivotUtil->getFieldsNodesIndexes();
        }
    }

    public function getHeader($params) {
        $this->buildIndexes($params);
        $fni = $this->fni;
        $header = array();
        $includeAll = Utility::get($params, "includeAll", false);
        foreach (array("row", "column") as $rc) {
            if (! isset($params[$rc]))
                continue;
            $header[$rc] = array();
            $parent = Utility::get($params[$rc], "parent", null);
            if (! isset($parent))
                continue;
            $fields = $rc === "row" ? $fni['rowFields'] : $fni['colFields'];
            $count = count($parent);
            if ($count >= count($fields))
                continue;
            $childField = $fields[$count];
            $header[$rc][$childField] = array();
            $indexes = $rc === "row" ? $fni['rowIndexes'] : $fni['colIndexes'];
            $nodes = $rc === "row" ? $fni['rowNodes'] : $fni['colNodes'];
            $getIndex = Utility::get($params, "getHeaderIndex", false);
            foreach ($indexes as $i) {
                $node = $nodes[$i];
                if ($this->isChild($parent, $node)) {
                    $v = $node[$childField];
                    if ($includeAll || $v !== "{{all}}") {
                        array_push($header[$rc][$childField], $getIndex ? $i : $v);
                    }
                }
            }
        }
        return $header;
    }

    public function getData($params) {
        $data = array();
        $params["getHeaderIndex"] = true;
        $headerIndexes = $this->getHeader($params);
        unset($params["getHeaderIndex"]);
        
        $rowIndexes = reset($headerIndexes["row"]);
        $columnIndexes = reset($headerIndexes["column"]);
        $fni = $this->fni;
        // $df = $fni['dataFields'][0];
        foreach ($rowIndexes as $r) {
            $row = array();
            foreach ($columnIndexes as $c) {
                $dataRow = isset($fni['indexToData'][$r][$c]) ? 
                $fni['indexToData'][$r][$c] : array();
                foreach ($fni['dataFields'] as $df)
                    array_push($row, isset($dataRow[$df]) ? $dataRow[$df] : 0);
            }
            array_push($data, $row);
        }
        return $data;
    }

    public function getDataStore($params) {
        $dataStore = new \koolreport\core\DataStore();

        $meta = array();
        $header = $this->getHeader($params);
        $rowField = key($header["row"]);
        $columnField = key($header["column"]);
        $rowHeader = reset($header["row"]);
        $columnHeader = reset($header["column"]);
        $meta[$rowField] = array("type" => "string");
        $measures = Utility::get($params, "measures", array());
        if (count($measures) > 1) {
            $columnHeader2 = array();
            foreach ($columnHeader as $header)
                foreach ($measures as $measure)
                    array_push($columnHeader2, $header . ' | ' . $measure);
        }   
        else
            $columnHeader2 = $columnHeader;
        // echo "columnHeader2="; print_r($columnHeader2); echo "<br>";
        foreach ($columnHeader2 as $h)
            $meta[$h] = array("type" => "number");
        $dataStore->meta(array("columns" => $meta));

        $data = $this->getData($params);
        // echo "data="; print_r($data); echo "<br>";
        $newData = array();
        foreach ($data as $i => $row) {
            $newRow = array($rowField => $rowHeader[$i]);
            foreach ($columnHeader2 as $c => $h)
                $newRow[$h] = $row[$c];
            array_push($newData, $newRow);
        }
        $dataStore->data($newData);

        return $dataStore;
    }

}