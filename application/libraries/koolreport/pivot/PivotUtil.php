<?php
namespace koolreport\pivot;

use \koolreport\core\Utility as Util;

class PivotUtil
{
    protected $dataStore;
    protected $params;

    protected $measures;
    protected $rowDimension;
    protected $colDimension;
    protected $rowSort;
    protected $columnSort;
    protected $headerMap;
    protected $dataMap;
    protected $totalName;
    protected $hideTotalRow;
    protected $hideTotalColumn;
    protected $paging;

    protected $FieldsNodesIndexes;

    public function __construct(& $dataStore, $params)
    {
        $this->dataStore = & $dataStore;
        $this->params = $params;

        $this->rowDimension = Util::get($this->params, 'rowDimension', 'row');
        $this->colDimension = Util::get($this->params, 'colDimension', 'column');
        $this->rowSort = Util::get($this->params, 'rowSort', []);
        $this->columnSort = Util::get($this->params, 'columnSort', []);
        $this->headerMap = Util::get($this->params, 'headerMap',
            function ($v, $f) {return $v;});
        $this->dataMap = Util::get($this->params, 'dataMap', null);
        $this->map = Util::get($this->params, 'map', []);
        $this->cssClass = Util::get($this->params, 'cssClass', []);
        $this->excelStyle = Util::get($this->params, 'excelStyle', []);
        $this->totalName = Util::get($this->params, 'totalName', 'Total');
        $this->hideTotalRow = Util::get($this->params, 'hideTotalRow', false);
        $this->hideGrandTotalRow = Util::get(
            $this->params, 'hideGrandTotalRow', $this->hideTotalRow);
        $this->hideTotalColumn = Util::get($this->params, 'hideTotalColumn', false);
        $this->hideGrandTotalColumn = Util::get(
            $this->params, 'hideGrandTotalColumn', $this->hideTotalColumn);

        //Get the measure field and settings in format
        $measures = [];
        $mSettings = Util::get($this->params, 'measures', []);
        $meta = $dataStore->meta();
        $cMetas = $this->cMetas = $meta['columns'];
        foreach ($mSettings as $cKey => $cValue) {
            if (gettype($cValue) == 'array') {
                $measures[$cKey] = $cValue;
            } else {
                $measures[$cValue] = isset($cMetas[$cValue]) ? $cMetas[$cValue] : null;
            }
        }
        if (empty($measures)) {
            $aggregates = Util::get($meta, 'pivotAggregates', null);
            if ($aggregates) {
                foreach ($aggregates as $df => $operators)
                    foreach ($operators as $op) {
                        $f = $df . ' - ' . $op;
                        $measures[$f] = Util::get($cMetas, $f, []);
                    }
            } else {
                $dataStore->popStart();
                $row = $dataStore->pop();
                $columns = ! empty($row) ? array_keys($row) : [];
                foreach ($columns as $c) {
                    if ($cMetas[$c]['type'] !== 'dimension') {
                        $measures[$c] = $cMetas[$c];
                    }
                }
            }
        }
        // Util::prettyPrint($measures);
        $this->measures = $measures;
        $this->waitingFields = Util::get($this->params, 'waitingFields', []);
        $this->process();
    }

    protected function sort(& $index, $sortInfo) 
    {
        $compareFunc = function ($a, $b) use ($sortInfo) {
            foreach ($sortInfo as $k => $v)
                $$k = $v;
            $cmp = 0;
            $parentNode = [];
            foreach ($fields as $field) {
                $parentNode[$field] = '{{all}}';
            }

            foreach ($fields as $field) {
                $value1 = $nodes[$a][$field];
                $value2 = $nodes[$b][$field];
                $node1 = $node2 = $parentNode;
                $node1[$field] = $value1;
                $node2[$field] = $value2;
                if ($value1 === $value2) {
                    $parentNode[$field] = $value1;
                    continue;
                } else if ($value1 === '{{all}}') {
                    return $sortTotalFirst ? -1 : 1;
                } else if ($value2 === '{{all}}') {
                    return $sortTotalFirst ? 1 : -1;
                } else {
                    $cmp = is_numeric($value1) && is_numeric($value2) ?
                    $value1 - $value2 : strcmp($value1, $value2);
                    $sortField = isset($sort[$field]) ? $sort[$field] : null;
                    if (is_string($sortField)) {
                        $cmp = $sortField === 'desc' ? -$cmp : $cmp;
                    } else if (is_callable($sortField)) {
                        $cmp = $sortField($value2, $value1);
                    }
                }
                if ($cmp !== 0) {
                    break;
                }

            }
            $dataCmp = $cmp;
            foreach ($dataFields as $field) {
                if (isset($sort[$field]) && $sort[$field] !== 'ignore') {
                    $dataSortField = $field;
                    $dataSortDirection = $sort[$field];
                    break;
                }
            }

            $index1 = $nameToIndex[implode(' - ', $node1)];
            $index2 = $nameToIndex[implode(' - ', $node2)];
            if (isset($dataSortField) &&
                isset($dimIndexToData[$index1][$dataSortField])) {
                $sortValue1 = isset($dimIndexToData[$index1]) ?
                    $dimIndexToData[$index1][$dataSortField] : 0;
                $sortValue2 = isset($dimIndexToData[$index2]) ?
                    $dimIndexToData[$index2][$dataSortField] : 0;
                $diff = $sortValue1 - $sortValue2;
                if ($dataSortDirection === 'asc') {
                    $dataCmp = $diff;
                } else if ($dataSortDirection === 'desc') {
                    $dataCmp = -$diff;
                } else if (is_callable($dataSortDirection)) {
                    $dataCmp = $dataSortDirection($sortValue1, $sortValue2);
                }
            }
            return $dataCmp;
        };
        
        usort($index, $compareFunc);
    }

    protected function computeNodesInfo($nodes, $fields, $indexes) 
    {
        $fieldInfo = array_fill_keys($fields, []);
        $nodesInfo = array_fill(0, count($nodes), $fieldInfo);
        // Util::prettyPrint($nodesInfo);
        $numChildren = array_fill_keys($fields, 1);
        $numLeaf = array_fill_keys($fields, 1);
        $childOrder = array_fill_keys($fields, 0);
        $nullNode = array_fill_keys($fields, null);
        $lastSameValueIndex = array_fill_keys($fields, $indexes[0]);
        array_push($indexes, count($indexes));
        $prevNode = $nullNode;
        //Loop through nodes already sorted by fields
        foreach ($indexes as $index) {
            $node = Util::get($nodes, $index, $nullNode);
            $seenTotalCell = false;
            //Loop through each field data of a node
            foreach ($fields as $j => $f) {
                $nodeF = Util::get($node, $f);
                $prevNodeF = Util::get($prevNode, $f);
                if ($nodeF !== $prevNodeF) {
                    $lsvi = $lastSameValueIndex[$f];
                    if ($nodes[$lsvi][$f] !== '{{all}}') {
                        $nodesInfo[$lsvi][$f]['numChildren'] = $numChildren[$f];
                        $nodesInfo[$lsvi][$f]['numLeaf'] = $numLeaf[$f];
                    }
                    $lastSameValueIndex[$f] = $index;
                    $numChildren[$f] = 1;
                    $numLeaf[$f] = 1;

                    $childOrder[$f] += 1;
                    $childOrders = '';
                    for ($k=0; $k<=$j; $k++) {
                        $childOrders .= ($childOrder[$fields[$k]]) . ".";
                    }
                    $childOrders = substr($childOrders, 0, -1); //remove last "."
                    $nodesInfo[$index][$f]['childOrder'] = $childOrders;
                } else {
                    $numChildren[$f] += 1;
                    $numLeaf[$f] += 1;
                }

                $nodesInfo[$index][$f]['value'] = $nodeF;

                if ($nodeF === '{{all}}') {
                    $nodesInfo[$index][$f]['total'] = true;
                    $nodesInfo[$index]['hasTotal'] = true;
                    $childOrder[$f] = 0;
                }

                if (! $seenTotalCell && $nodeF === '{{all}}') {
                    $seenTotalCell = true;
                    $nodesInfo[$index][$f]['numChildren'] = 1;
                    $nodesInfo[$index][$f]['numLeaf'] = 1;
                    $nodesInfo[$index][$f]['level'] = count($fields) - $j;
                    Util::init($nodesInfo[$index][$f], 'childOrder', 1);
                    $nodesInfo[$index]['fieldOrder'] = $j - 1;

                    $prevField = $j > 0 ? $fields[$j - 1] : '';
                    $parent = Util::get($node, $prevField, null);
                    $prevParent = Util::get($prevNode, $prevField, null);
                    if ($parent !== $prevParent) continue;
                    for ($k = 0; $k < $j; $k++) {
                        $prevF = $fields[$k];
                        $numLeaf[$prevF] -= 1;
                    }
                }

            }
            if (! $seenTotalCell) {
                $nodesInfo[$index]['fieldOrder'] = count($fields) - 1;
            }
            $prevNode = $node;
        }
        array_pop($indexes);
        
        // Util::prettyPrint($nodesInfo);
        return $nodesInfo;
    }

    protected function toFunction($funcOrArr, $default = '{identical}')
    {
        $func = function ($v, $info) use ($funcOrArr, $default) {
            if ($default === '{identical}') $default = $v;
            if (is_array($funcOrArr)) {
                return isset($funcOrArr[$v]) ? $funcOrArr[$v] : $default;
            } elseif (is_callable($funcOrArr)) {
                return $funcOrArr($v, $info);
            }
            return $default;
        };
        return $func;
    }

    protected function getMappedFieldsAttributes($dimension, $fields)
    {
        $field = $dimension !== 'dataHeader' ? $dimension . 'Field' : 'dataHeader';
        $fieldMap = Util::get($this->map, $field, []);
        if ($dimension === 'dataHeader' && empty($fieldMap)) {
            $fieldMap = Util::get($this->map, 'dataField', []);
        }
        $fieldMap = $this->toFunction($fieldMap);
        $classMap = Util::get($this->cssClass, $field, []);
        $classMap = $this->toFunction($classMap, "");
        $excelMap = Util::get($this->excelStyle, $field, []);
        $excelMap = $this->toFunction($excelMap, []);
        $fieldsInfo = [];
        foreach ($fields as $fi => $f) {
            $fieldsInfo[$f] = ['fieldOrder' => $fi];
        }
        $mappedFields = isset($fields[0]) && $fields[0] === 'root' ? [] : 
            array_combine($fields, array_map($fieldMap, $fields, $fieldsInfo));
        $fieldsClass = isset($fields[0]) && $fields[0] === 'root' ? [] : 
            array_combine($fields, array_map($classMap, $fields, $fieldsInfo));
        $fieldsExcelStyle = isset($fields[0]) && $fields[0] === 'root' ? [] : 
            array_combine($fields, array_map($excelMap, $fields, $fieldsInfo));
        return [$mappedFields, $fieldsClass, $fieldsExcelStyle];
    }

    protected function getNodesAttributes($dimension, $nodes, $nodesInfo)
    {
        $nodeMap = Util::get($this->map, $dimension . 'Header', []);
        $totalName = $this->totalName;
        $nodeMap = function ($v, $info) use ($nodeMap, $totalName) {
            if ($v === '{{all}}') {
                if (is_callable($totalName)) $totalName = $totalName($v, $info);
                return $totalName;
            }
            if (is_array($nodeMap)) {
                return isset($nodeMap[$v]) ? $nodeMap[$v] : $v;
            } elseif (is_callable($nodeMap)) {
                return $nodeMap($v, $info);
            }
            return $v;
        };
        $classMap = Util::get($this->cssClass, $dimension . 'Header', []);
        $classMap = $this->toFunction($classMap, "");
        $excelMap = Util::get($this->excelStyle, $dimension . 'Header', []);
        $excelMap = $this->toFunction($excelMap, []);
        $mappedNodes = [];
        $nodesClass = [];
        $nodesExcelStyle = [];
        foreach ($nodes as $i => $node) {
            $fields = array_keys($node);
            foreach ($fields as $fi => $f) {
                $nodeInfo[$f] = Util::get($nodesInfo, [$i, $f]);
                $nodeInfo[$f]['fieldName'] = $f;
                $nodeInfo[$f]['fieldOrder'] = $fi;
            }
            $mappedNodes[$i] = array_map($nodeMap, $node, $nodeInfo);
            $mappedNodes[$i] = array_combine($fields, $mappedNodes[$i]);
            $nodesClass[$i] = array_map($classMap, $node, $nodeInfo);
            $nodesClass[$i] = array_combine($fields, $nodesClass[$i]);
            $nodesExcelStyle[$i] = array_map($excelMap, $node, $nodeInfo);
            $nodesExcelStyle[$i] = array_combine($fields, $nodesExcelStyle[$i]);
        }
        return [$mappedNodes, $nodesClass, $nodesExcelStyle];
    }

    protected function getDataAttributes($indexToData, $rowNodesInfo, $colNodesInfo)
    {
        $cMetas = $this->dataStore->meta()['columns'];
        $cellMap = Util::get($this->map, 'dataCell', function($v, $info) use ($cMetas) {
            $df = $info['fieldName'];
            return Util::format($v, Util::get($cMetas, $df, []));
        });
        $cellMap = $this->toFunction($cellMap);
        $classMap = Util::get($this->cssClass, 'dataCell', []);
        $classMap = $this->toFunction($classMap, "");
        $excelMap = Util::get($this->excelStyle, 'dataCell', []);
        $excelMap = $this->toFunction($excelMap, []);
        $dataFields = $this->dataFields;
        $indexToMappedData = [];
        $indexToDataClass = [];
        $indexToDataExcelStyle = [];
        
        // Util::prettyPrint($indexToData); exit;
        foreach ($indexToData as $ri => $cis) {
            $rowNodeInfo = $rowNodesInfo[$ri];
            $indexToMappedData[$ri] = [];
            $indexToDataClass[$ri] = [];
            $indexToDataExcelStyle[$ri] = [];
            foreach ($cis as $ci => $dataNode) {
                $colNodeInfo = $colNodesInfo[$ci];
                $nodeInfo = [
                    'row' => $rowNodeInfo,
                    'column' => $colNodeInfo
                ];
                $node = array_slice($dataNode, 0, count($dataFields));
                $cellInfo = [];
                foreach ($dataFields as $di => $df) {
                    $cellInfo[$df] = $nodeInfo;
                    $cellInfo[$df]['rowIndex'] = $ri;
                    $cellInfo[$df]['columnIndex'] = $ci;
                    $cellInfo[$df]['indexToData'] = & $indexToData;
                    $cellInfo[$df]['fieldName'] = $df;
                    $cellInfo[$df]['fieldOrder'] = $di;
                    $cellInfo[$df]['formattedValue'] = 
                        Util::format(Util::get($node, $df, null), 
                            Util::get($cMetas, $df, []));
                }
                $mappedNode = array_map($cellMap, $node, $cellInfo);
                $indexToMappedData[$ri][$ci] = array_combine($dataFields, $mappedNode);
                $nodeClass = array_map($classMap, $node, $cellInfo);
                $indexToDataClass[$ri][$ci] = array_combine($dataFields, $nodeClass);
                $nodeExcelStyle = array_map($excelMap, $node, $cellInfo);
                $indexToDataExcelStyle[$ri][$ci] = 
                    array_combine($dataFields, $nodeExcelStyle);
            }
        }
        
        return [$indexToMappedData, $indexToDataClass, $indexToDataExcelStyle];
    }

    protected function nodeNamesToNodes($nodeNames, $fields, $fieldDelimiter)
    {
        $nodes = [];
        foreach ($nodeNames as $name) {
            $name = explode($fieldDelimiter, $name);
            $node = [];
            foreach ($fields as $i => $f) {
                $node[$f] = $name[$i];
            }
            $name = implode($fieldDelimiter, $node);
            $nodes[$name] = $node;
        }
        $nodes = array_values($nodes);
        return $nodes;
    }

    protected function computeIndexes()
    {
        $dataStore = & $this->dataStore;
        $meta = $this->dataStore->meta();
        $pivotFormat = Util::get($meta, 'pivotFormat', 'pivot');
        $cMetas = $this->cMetas;
        if ($pivotFormat === 'pivot2D' && $dataStore->count() > 0) {
            $rowNodes = $colNodes = [];
            $rowIndexToData = [];
            $colIndexToData = [];
            $indexToData = [];
            $rowFields = ! empty($meta['pivotRows']) ? $meta['pivotRows'] :  ['root'];
            $colFields = ! empty($meta['pivotColumns']) ? $meta['pivotColumns'] :  ['root'];     
            $fieldDelimiter = $meta['pivotFieldDelimiter'];
            // Util::prettyPrint($rowFields);
            // Util::prettyPrint($colFields);
            // if (! empty($this->measures)) {
                $dataFields = $this->dataFields = array_keys($this->measures);
            // } else {
            //     $dataFields = [];
            //     foreach ($meta['pivotAggregates'] as $df => $operators)
            //         foreach ($operators as $op)
            //             array_push($dataFields, $df . ' - ' . $op);
            // }

            $dataStore->popStart();
            while ($dataRow = $dataStore->pop()) {
                // Util::prettyPrint($dataRow);
                if (empty($colNodes)) {
                    $nodeNames = array_slice(array_keys($dataRow), 1);
                    // echo 'nodeNames = '; Util::prettyPrint($nodeNames);
                    $colNodes = $this->nodeNamesToNodes(
                        $nodeNames, $colFields, $fieldDelimiter);
                }
                array_push($rowNodes, $dataRow['label']);
                $rowIndex = count($rowNodes) - 1;
                foreach ($colNodes as $colIndex => $colNode) {
                    $newDataRow = [];
                    $colNode = implode($fieldDelimiter, $colNode);
                    foreach ($dataFields as $df) {
                        if (isset($dataRow[$colNode . $fieldDelimiter . $df]))
                            $newDataRow[$df] = $dataRow[$colNode . $fieldDelimiter . $df];
                                // Util::get(
                                // $dataRow, $colNode . $fieldDelimiter . $df, null);
                    }
                    // Util::prettyPrint($newDataRow);
                    if ($colIndex === 0) {
                        $rowIndexToData[$rowIndex] = $newDataRow;
                    }
                    if ($rowIndex === 0) {
                        $colIndexToData[$colIndex] = $newDataRow;
                    }
                    $indexToData[$rowIndex][$colIndex] = $newDataRow;
                }
            }
            // Util::prettyPrint($rowNodes);
            $rowNodes = $this->nodeNamesToNodes($rowNodes, $rowFields, $fieldDelimiter);
            $nameToIndexRow = [];
            foreach ($rowNodes as $i => $node) {
                $nameToIndexRow[implode(' - ', $node)] = $i;
            }
            $nameToIndexCol = [];
            foreach ($colNodes as $i => $node) {
                $nameToIndexCol[implode(' - ', $node)] = $i;
            }
            // Util::prettyPrint($colNodes);
            // Util::prettyPrint($indexToData); exit;
        } else {
            $rowDimension = isset($cMetas[$this->rowDimension]) ?
                $this->rowDimension : null;
            $colDimension = isset($cMetas[$this->colDimension]) ?
                $this->colDimension : null;

            $rowNodes = isset($rowDimension) ?
                $cMetas[$rowDimension]['index'] : null;
            $colNodes = isset($colDimension) ?
                $cMetas[$colDimension]['index'] : null;
            if (empty($rowNodes) || empty($rowNodes[0])) {
                $rowNodes = array(array('root' => '{{all}}'));
            }
            if (empty($colNodes) || empty($colNodes[0])) {
                $colNodes = array(array('root' => '{{all}}'));
            }

            // $rowFields = array_keys($rowNodes[0]);
            // $colFields = array_keys($colNodes[0]);
            $rowFields = ! empty($meta['pivotRows']) ? $meta['pivotRows'] :  ['root'];
            $colFields = ! empty($meta['pivotColumns']) ? $meta['pivotColumns'] :  ['root'];
            $dataFields = $this->dataFields = array_keys($this->measures);

            $nameToIndexRow = [];
            foreach ($rowNodes as $i => $node) {
                $nameToIndexRow[implode(' - ', $node)] = $i;
            }

            $nameToIndexCol = [];
            foreach ($colNodes as $i => $node) {
                $nameToIndexCol[implode(' - ', $node)] = $i;
            }

            $rowIndexToData = [];
            $colIndexToData = [];
            $indexToData = [];
            
            $dataStore->popStart();
            while ($dataRow = $dataStore->pop()) {
                $rowIndex = (int) Util::get($dataRow, $rowDimension, 0);
                $colIndex = (int) Util::get($dataRow, $colDimension, 0);
                if (isset($rowDimension) && $colIndex === 0) {
                    $rowIndexToData[$rowIndex] = $dataRow;
                }

                if (isset($colDimension) && $rowIndex === 0) {
                    $colIndexToData[$colIndex] = $dataRow;
                }

                $indexToData[$rowIndex][$colIndex] = $dataRow;
            }
            for ($i = 0; $i < count($rowNodes); $i++)
                for ($j = 0; $j < count($colNodes); $j++)
                    Util::init($indexToData, [$i, $j], []);
            // Util::prettyPrint($indexToData); exit;
            // echo 'dataFields = '; Util::prettyPrint($dataFields);
        }
        // echo 'colNodes = '; Util::prettyPrint($colNodes);
        return [$rowFields, $colFields, $dataFields, $rowNodes, $colNodes, 
            $nameToIndexRow, $nameToIndexCol, $rowIndexToData, $colIndexToData, $indexToData];
    }

    protected function process()
    {
        if (! $this->dataStore) {
            return [];
        }
        $cMetas = $this->cMetas;
        list($rowFields, $colFields, $dataFields, $rowNodes, $colNodes, 
            $nameToIndexRow, $nameToIndexCol, $rowIndexToData, $colIndexToData, $indexToData)
                = $this->computeIndexes();
        // Util::prettyPrint($colFields);

        $numNodes = count($rowNodes);
        if ($numNodes === 0) $numNodes = 1;
        $rowIndexes = $rowIndexesBun = range(0, $numNodes - 1);
        $numNodes = count($colNodes);
        if ($numNodes === 0) $numNodes = 1;
        $colIndexes = range(0, $numNodes - 1);
        $rowSortInfo = [
            'nodes' => $rowNodes,
            'fields' => $rowFields,
            'nameToIndex' => $nameToIndexRow, 
            'dimIndexToData' => $rowIndexToData, 
            'sort' => $this->rowSort, 
            'dataFields' => $dataFields,
            'sortTotalFirst' => false
        ];
        $this->sort($rowIndexes, $rowSortInfo);
        $rowSortInfo['sortTotalFirst'] = true;
        $this->sort($rowIndexesBun, $rowSortInfo);
        
        //Push the grand total index to the end instead of the beginning
        // $grandTotalIndex = array_shift($rowIndexesBun);
        // array_push($rowIndexesBun, $grandTotalIndex);
        
        $colSortInfo = [
            'nodes' => $colNodes,
            'fields' => $colFields,
            'nameToIndex' => $nameToIndexCol, 
            'dimIndexToData' => $colIndexToData, 
            'sort' => $this->columnSort, 
            'dataFields' => $dataFields,
            'sortTotalFirst' => false
        ];
        $this->sort($colIndexes, $colSortInfo);

        $rowNodesInfo = $this->computeNodesInfo($rowNodes, $rowFields, $rowIndexes);
            
        $rowNodesInfoBun = $this->computeNodesInfo($rowNodes, $rowFields, $rowIndexesBun);
            
        $colNodesInfo = $this->computeNodesInfo($colNodes, $colFields, $colIndexes);

        if ($this->hideGrandTotalRow) {
            array_pop($rowIndexes); //remove grand total row node
            array_shift($rowIndexesBun); //remove grand total row node
        }
        
        if ($this->hideGrandTotalColumn) {
            array_pop($colIndexes); //remove grand total column node
        }
        
        $numDf = count($dataFields) > 0 ? count($dataFields) : 1;
        foreach ($colNodesInfo as $i => $mark) {
            foreach ($mark as $f => $fInfo) {
                if (! isset($fInfo['numChildren'])) continue;
                $colNodesInfo[$i][$f]['numChildren'] *= $numDf;
                $colNodesInfo[$i][$f]['numLeaf'] *= $numDf;
            }
        }

        $totalName = $this->totalName;
        $headerMap = $this->headerMap;
        $headerMap = function ($v, $f) use ($headerMap, $totalName) {
            if ($v === '{{all}}') {
                return $totalName;
            }
            if (is_array($headerMap)) {
                return isset($headerMap[$v]) ? $headerMap[$v] : $v;
            }
            return $headerMap($v, $f);
        };
        
        $mappedRowNodes = $mappedRowNodesBun = [];
        foreach ($rowNodes as $i => $node) {
            $mappedRowNodes[$i] = $mappedRowNodesBun[$i] = array_combine($rowFields,
                array_map($headerMap, $node, $rowFields));
        }
        $mappedColNodes = [];
        foreach ($colNodes as $i => $node) {
            $mappedColNodes[$i] = array_combine($colFields,
                array_map($headerMap, $node, $colFields));
        }
        $waitingFields = array_keys($this->waitingFields);
        $mappedDataHeaders = $mappedDataFields = array_combine($dataFields,
            array_map($headerMap, $dataFields, [], []));
        $mappedColFields = $colFields[0] !== 'root' ? array_combine($colFields,
            array_map($headerMap, $colFields, [], [])) : [];
        $mappedRowFields = $rowFields[0] !== 'root' ? array_combine($rowFields,
            array_map($headerMap, $rowFields, [], [])) : [];
        $mappedWaitingFields = array_combine($waitingFields,
            array_map($headerMap, $waitingFields, [], []));

        list($mappedFields, $rowFieldsClass, $rowFieldsExcelStyle) = 
            $this->getMappedFieldsAttributes('row', $rowFields);
        if (isset($this->map['rowField'])) $mappedRowFields = $mappedFields;
        list($mappedFields, $colFieldsClass, $colFieldsExcelStyle) = 
            $this->getMappedFieldsAttributes('column', $colFields);
        if (isset($this->map['columnField'])) $mappedColFields = $mappedFields;
        list($mappedFields, $dataFieldsClass, $dataFieldsExcelStyle) = 
            $this->getMappedFieldsAttributes('data', $dataFields);
        if (isset($this->map['dataField'])) $mappedDataFields = $mappedFields;
        list($mappedFields, $waitingFieldsClass, $waitingFieldsExcelStyle) = 
            $this->getMappedFieldsAttributes('waiting', $waitingFields);
        if (isset($this->map['waitingField'])) $mappedWaitingFields = $mappedFields;
        list($mappedFields, $dataHeadersClass, $dataHeadersExcelStyle) = 
            $this->getMappedFieldsAttributes('dataHeader', $dataFields);
        if (isset($this->map['dataHeader'])) $mappedDataHeaders = $mappedFields;

        list($mappedNodes, $rowNodesClass, $rowNodesExcelStyle) = 
            $this->getNodesAttributes('row', $rowNodes, $rowNodesInfo);
        if (isset($this->map['rowHeader'])) $mappedRowNodes = $mappedNodes;
        list($mappedNodes, $rowNodesClassBun, $rowNodesExcelStyleBun) = 
            $this->getNodesAttributes('row', $rowNodes, $rowNodesInfoBun);
        if (isset($this->map['rowHeader'])) $mappedRowNodesBun = $mappedNodes;
        list($mappedNodes, $colNodesClass, $colNodesExcelStyle) = 
            $this->getNodesAttributes('column', $colNodes, $colNodesInfo);
        if (isset($this->map['columnHeader'])) $mappedColNodes = $mappedNodes;

        $dataMap = $this->dataMap;
        if (is_array($dataMap)) {
            $dataMap = function ($v) use ($dataMap) {
                return isset($dataMap[$v]) ? $dataMap[$v] : $v;
            };
        }
        $indexToMappedData = $indexToData;
        // print_r($cMetas); echo "<br>";
        foreach ($indexToMappedData as $ri => $cis) {
            foreach ($cis as $ci => $d) {
                if (is_callable($dataMap)) {
                    $indexToMappedData[$ri][$ci] = array_combine(array_keys($d),
                        array_map($dataMap, $d, array_keys($d)));
                } else {
                    foreach ($d as $df => $v) {
                        // print_r($indexToMappedData[$ri][$ci][$df]); echo " ** ";
                        $indexToMappedData[$ri][$ci][$df] = Util::format($v,
                            Util::get($this->measures, $df, Util::get($cMetas, $df, [])));
                    }
                }
            }
        }  
        // print_r($indexToData); echo "<br>";  
        list($mappedData, $indexToDataClass, $indexToDataExcelStyle) = 
            $this->getDataAttributes($indexToData, $rowNodesInfo, $colNodesInfo);
        if (isset($this->map['dataCell'])) $indexToMappedData = $mappedData;    


        $waitingFieldsType = array_values($this->waitingFields);
        $dataFieldsType = array_fill(0, count($dataFields), 'data');
        $columnFieldsType = array_fill(0, count($colFields), 'column');
        $rowFieldsType = array_fill(0, count($rowFields), 'row');

        $waitingFieldsSort = array_fill(0, count($this->waitingFields), 'noSort');
        $dataFieldsSort = array_fill(0, count($dataFields), 'noSort');
        $columnFieldsSort = array_fill(0, count($colFields), 'noSort');
        $rowFieldsSort = array_fill(0, count($rowFields), 'noSort');
        $colSortDataField = null;
        foreach ($this->columnSort as $field => $dir) {
            foreach ($dataFields as $i => $dataField) {
                if ($dataField === $field && ($dir === 'asc' || $dir === 'desc')) {
                    $dataFieldsSort[$i] .= ' columnsort' . $dir;
                    $colSortDataField = $field;
                }
            }

        }
        $rowSortDataField = null;
        foreach ($this->rowSort as $field => $dir) {
            foreach ($dataFields as $i => $dataField) {
                if ($dataField === $field && ($dir === 'asc' || $dir === 'desc')) {
                    $dataFieldsSort[$i] .= ' rowsort' . $dir;
                    $rowSortDataField = $field;
                }
            }
        }
        if (! $colSortDataField) {
            foreach ($this->columnSort as $field => $dir) {
                foreach ($colFields as $i => $colField) {
                    if ($colField == $field && ($dir === 'asc' || $dir === 'desc')) {
                        $columnFieldsSort[$i] = 'columnsort' . $dir;
                    }
                }
            }
        }
        if (! $rowSortDataField) {
            foreach ($this->rowSort as $field => $dir) {
                foreach ($rowFields as $i => $rowField) {
                    if ($rowField === $field && ($dir === 'asc' || $dir === 'desc')) {
                        $rowFieldsSort[$i] = 'rowsort' . $dir;
                    }
                }
            }
        }

        // echo "dataFieldsClass="; print_r($dataFieldsClass); echo "<br>";
        $numRow = count($rowNodes);
        $this->FieldsNodesIndexes = array(
            'waitingFields' => $waitingFields,
            'dataFields' => $dataFields,
            'colFields' => $colFields,
            'rowFields' => $rowFields,
            'waitingFieldsType' => $waitingFieldsType,
            'dataFieldsType' => $dataFieldsType,
            'columnFieldsType' => $columnFieldsType,
            'rowFieldsType' => $rowFieldsType,
            'waitingFieldsSort' => $waitingFieldsSort,
            'dataFieldsSort' => $dataFieldsSort,
            'columnFieldsSort' => $columnFieldsSort,
            'rowFieldsSort' => $rowFieldsSort,

            'mappedDataFields' => $mappedDataFields,
            'mappedDataHeaders' => $mappedDataHeaders,
            'mappedColFields' => $mappedColFields,
            'mappedRowFields' => $mappedRowFields,
            'mappedWaitingFields' => $mappedWaitingFields,

            'colNodes' => $colNodes,
            'rowNodes' => $rowNodes,
            'mappedColNodes' => $mappedColNodes,
            'mappedRowNodes' => $mappedRowNodes,
            'mappedRowNodesBun' => $mappedRowNodesBun,

            'colIndexes' => $colIndexes,
            'rowIndexes' => $rowIndexes,
            'rowIndexesBun' => $rowIndexesBun,
            'colNodesInfo' => $colNodesInfo,
            'rowNodesInfo' => $rowNodesInfo,
            'rowNodesInfoBun' => $rowNodesInfoBun,

            'indexToMappedData' => $indexToMappedData,
            'indexToData' => $indexToData,

            'indexToDataClass' => $indexToDataClass,
            'rowNodesClass' => $rowNodesClass,
            'rowNodesClassBun' => $rowNodesClassBun,
            'colNodesClass' => $colNodesClass,
            'rowFieldsClass' => $rowFieldsClass,
            'columnFieldsClass' => $colFieldsClass,
            'dataFieldsClass' => $dataFieldsClass,
            'dataHeadersClass' => $dataHeadersClass,
            'waitingFieldsClass' => $waitingFieldsClass,

            'indexToDataExcelStyle' => $indexToDataExcelStyle,
            'rowNodesExcelStyle' => $rowNodesExcelStyle,
            'rowNodesExcelStyleBun' => $rowNodesExcelStyleBun,
            'colNodesExcelStyle' => $colNodesExcelStyle,
            'rowFieldsExcelStyle' => $rowFieldsExcelStyle,
            'columnFieldsExcelStyle' => $colFieldsExcelStyle,
            'dataFieldsExcelStyle' => $dataFieldsExcelStyle,
            'dataHeadersExcelStyle' => $dataHeadersExcelStyle,
            'waitingFieldsExcelStyle' => $waitingFieldsExcelStyle,

            'numRow' => $numRow,
        );
    }

    public function getFieldsNodesIndexes()
    {
        return $this->FieldsNodesIndexes;
    }
}
