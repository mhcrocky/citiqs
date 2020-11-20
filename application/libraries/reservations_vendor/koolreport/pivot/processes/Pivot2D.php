<?php

/**
 * This file contains process to turn data into pivot table
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#regular-license
 * @license https://www.koolreport.com/license#extended-license
 */
/* 
    ->pipe(new Pivot2D(array(
        "column"=>"orderYear, orderMonth",
        "row"=>"customerName, productLine, productName"
        "aggregates"=>array(
            "sum"=>"dollar_sales",
            "count"=>"dollar_sales",
            "avg"=>"dollar_sales",
            'sum percent' => 'dollar_sales',
            'count percent' => 'dollar_sales',
        )
    )))
  */

namespace koolreport\pivot\processes;

use \koolreport\core\Utility as Util;

class Pivot2D extends Pivot
{
    protected $fieldDelimiter;

    public function onInit()
    {
        if (!isset($this->params["dimensions"])) {
            $columns = Util::get($this->params, "column", array());
            $rows = Util::get($this->params, "row", array());
            $this->params["dimensions"] = ['column' => $columns, 'row' => $rows];
        }
        parent::OnInit();
        $this->fieldDelimiter = Util::get($this->params, "fieldDelimiter", ' -||- ');
        $dimensions = [
            'column' => $this->dimensions['column'],
            'row' => $this->dimensions['row'],
        ];
        $this->dimensions = $dimensions;
    }

    public function finalize()
    {
        $delimiter = $this->fieldDelimiter;
        $metaData = array('label' => 'string');
        $indexToName = $this->indexToNameD['column'];
        foreach ($indexToName as $i => $name) {
            $colName = implode($delimiter, $name);
            foreach ($this->aggregates as $af => $operators) {
                foreach ($operators as $op) {
                    $metaData[$colName . $delimiter .
                        $af . ' - ' . $op] = ['type' => 'number'];
                }
            }
        }
        $this->forwardMeta['columns'] = array_merge(
            $this->forwardMeta['columns'],
            $metaData
        );

        // if aggregate operator is average, divide total sum by total count
        foreach ($this->data as $dn => &$nodeValues) {
            foreach ($nodeValues as $af => &$datum) {
                if (isset($this->hasAvg[$af])) {
                    $datum['avg'] *= 1 / $this->count[$dn][$af];
                }
                if (isset($this->hasCountPercent[$af])) {
                    $datum['count percent'] *= 100 / $this->countAll[$af];
                }
                if (isset($this->hasSumPercent[$af])) {
                    $datum['sum percent'] *= 100 / $this->sumAll[$af];
                }
                foreach ($datum as $op => &$v) {
                    $customOperator = Util::get($this->customAggregates, $op, null);
                    if (isset($customOperator)) {
                        $func = Util::get($customOperator, '{finalValue}', null);
                        $v = is_callable($func) ?
                            $func($v, $af, $dn) : $v;
                    }
                }
            }
        }
        unset($nodeValues, $datum, $v);

        $rows = array();
        foreach ($this->data as $dn => $nodeValues) {
            $dataNode = $this->nameToNode[$dn];

            $indexToNameRow = $this->indexToNameD['row'];
            $nodeIndexRow = $dataNode[1];
            $nodeNameRow = implode($delimiter, $indexToNameRow[$nodeIndexRow]);
            Util::init($rows, $nodeNameRow, []);
            $rows[$nodeNameRow]['label'] = $nodeNameRow;

            $indexToNameCol = $this->indexToNameD['column'];
            $nodeIndexCol = $dataNode[0];
            $nodeNameCol = implode($delimiter, $indexToNameCol[$nodeIndexCol]);
            foreach ($nodeValues as $af => $datum) {
                foreach ($datum as $operator => $value) {
                    $rows[$nodeNameRow][$nodeNameCol . $delimiter .
                        $af . ' - ' . $operator] = $value;
                }
            }
        }
        $this->data = &$rows;
    }

    public function receiveMeta($metaData, $source)
    {
        $this->metaData = array_merge($this->metaData, $metaData);
        $cMetas = $this->metaData['columns'];
        foreach ($this->aggregates as $af => $operators) {
            foreach ($cMetas as $cName => $cMeta) {
                if ($cName !== $af) {
                    continue;
                }

                foreach ($operators as $op) {
                    $aggField = $af . ' - ' . $op;
                    if ($op === 'count') {
                        $cMetas[$aggField] = ['type' => 'number'];
                    } else if ($op === 'count percent' || $op === 'sum percent') {
                        $cMetas[$aggField] = [
                            'type' => 'number',
                            'decimals' => 2,
                            'suffix' => '%',
                        ];
                    } else {
                        $cMetas[$aggField] = $cMeta;
                    }
                }
            }
        }
        $this->forwardMeta = [
            'pivotId' => $this->pivotId,
            'pivotFormat' => 'pivot2D',
            'pivotRows' => $this->dimensions['row'],
            'pivotColumns' => $this->dimensions['column'],
            'pivotAggregates' => $this->aggregates,
            'pivotFieldDelimiter' => $this->fieldDelimiter,
            'pivotExpandTrees' => &$this->expandTrees,
            'columns' => $cMetas,
        ];
    }
}
