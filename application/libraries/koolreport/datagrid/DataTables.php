<?php

namespace koolreport\datagrid;

use \koolreport\core\Widget;
use \koolreport\core\Utility as Util;
use \koolreport\core\DataStore;

class DataTables extends Widget
{
    protected $name;
    protected $columns;
    protected $data;
    protected $options;
    protected $emptyValue;
    protected $showFooter;
    protected $clientEvents;
    protected $trueColKeys = [];

    public function version()
    {
        return "4.0.1";
    }

    protected function resourceSettings()
    {
        $resources = [];
        switch ($this->getThemeBase()) {
            case "bs4":
                $resources = array(
                    "library" => array("jQuery"),
                    "folder" => "DataTables",
                    "js" => array(
                        "datatables.min.js",
                        array(
                            "pagination/input.js",
                            "datatables.bs4.min.js"
                        )
                    ),
                    "css" => array("datatables.bs4.min.css")
                );
                break;
            case "bs3":
            default:
                $resources = array(
                    "library" => array("jQuery"),
                    "folder" => "DataTables",
                    "js" => array(
                        "datatables.min.js",
                        [
                            "pagination/input.js"
                        ]
                    ),
                    "css" => array("datatables.min.css")
                );
        }

        $pluginNameToFiles = array(
            "AutoFill" => array(
                "AutoFill-2.3.5/js/dataTables.autoFill.min.js"
            ),
            "Buttons" => array(
                "Buttons-1.6.2/js/dataTables.buttons.min.js",
                "Buttons-1.6.2/js/buttons.colVis.min.js",
                "Buttons-1.6.2/js/buttons.html5.min.js",
                "Buttons-1.6.2/js/buttons.print.min.js",
                "JSZip-2.5.0/jszip.min.js",
                "pdfmake-0.1.36/pdfmake.min.js",
                ["pdfmake-0.1.36/vfs_fonts.js"], //vfs_fonts must be loaded after pdfmake.min.js
            ),
            "ColReorder" => array(
                "ColReorder-1.5.2/js/dataTables.colReorder.min.js",
            ),
            "FixedColumns" => array(
                "FixedColumns-3.3.1/js/dataTables.fixedColumns.min.js",
            ),
            "FixedHeader" => array(
                "FixedHeader-3.1.7/js/dataTables.fixedHeader.min.js"
            ),
            "KeyTable" => array(
                "KeyTable-2.5.2/js/dataTables.keyTable.min.js"
            ),
            "Responsive" => array(
                "Responsive-2.2.4/js/dataTables.responsive.min.js"
            ),
            "RowGroup" => array(
                "RowGroup-1.1.2/js/dataTables.rowGroup.min.js"
            ),
            "RowReorder" => array(
                "RowReorder-1.2.7/js/dataTables.rowReorder.min.js"
            ),
            "Scroller" => array(
                "Scroller-2.0.2/js/dataTables.scroller.min.js"
            ),
            "SearchPanes" => array(
                "SearchPanes-1.1.0/js/dataTables.searchPanes.min.js"
            ),
            "Select" => array(
                "Select-1.3.1/js/dataTables.select.min.js"
            ),
        );

        $pluginJs = [];
        foreach ($this->plugins as $name) {
            if (isset($pluginNameToFiles[$name])) {
                foreach ($pluginNameToFiles[$name] as $jsfile) {
                    array_push($pluginJs, $jsfile);
                }
            }
        }
        $resources['js'][1] = array_merge($resources['js'][1], $pluginJs);

        return $resources;
    }

    protected function onInit()
    {
        $this->useLanguage();
        $scope = Util::get($this->params, "scope", array());
        $this->scope = is_callable($scope) ? $scope() : $scope;
        $this->name = Util::get($this->params, "name");
        $this->columns = Util::get($this->params, "columns", array());
        $this->showFooter = Util::get($this->params, "showFooter", false);
        $this->clientEvents = Util::get($this->params, "clientEvents", false);
        $this->serverSide = Util::get($this->params, "serverSide", false);
        $this->method = strtoupper(Util::get($this->params, "method", 'get'));
        $this->submitType = $this->method === 'POST' ? $_POST : $_GET;
        $this->complexHeaders = strtoupper(Util::get($this->params, "complexHeaders", false));
        $this->headerSeparator = strtoupper(Util::get($this->params, "headerSeparator", ' - '));
        $this->searchOnEnter = Util::get($this->params, "searchOnEnter", false);
        $this->searchMode = strtolower(Util::get($this->params, "searchMode", "default"));
        $this->emptyValue = strtolower(Util::get($this->params, "emptyValue", "-"));
        $this->cssClass = Util::get($this->params, "cssClass", array());
        $this->attributes = Util::get($this->params, "attributes", array());
        $this->onBeforeInit = Util::get($this->params, "onBeforeInit");
        $this->defaultPlugins = Util::get($this->params, "defaultPlugins", [
            "AutoFill", "ColReorder", "RowGroup", "Select"
        ]);
        $this->plugins = Util::get($this->params, "plugins", []);
        $this->plugins = array_merge($this->plugins, $this->defaultPlugins);

        $this->useDataSource($this->scope);

        if (!$this->name) {
            $this->name = "datatables" . Util::getUniqueId();
        }

        if ($this->dataStore == null) {
            throw new \Exception("dataSource is required for DataTables");
            return;
        }


        $this->options = array(
            "searching" => false,
            "paging" => false,
        );


        if ($this->languageMap != null) {
            $this->options["language"] = $this->languageMap;
        }

        $this->options = array_merge(
            $this->options,
            Util::get($this->params, "options", array())
        );
    }


    protected function formatValue($value, $format, $row = null)
    {
        $formatValue = Util::get($format, "formatValue", null);

        if (is_string($formatValue)) {
            eval('$fv="' . str_replace('@value', '$value', $formatValue) . '";');
            return $fv;
        } else if (is_callable($formatValue)) {
            return $formatValue($value, $row);
        } else {
            return Util::format($value, $format);
        }
    }

    protected function buildComplexHeaders($showColumnKeys)
    {
        $sep = $this->headerSeparator;
        $headerRows = [];
        //Create empty header rows array
        foreach ($showColumnKeys as $cKey) {
            $cKey = explode($sep, $cKey);
            if (count($headerRows) < count($cKey)) {
                $aHeaderRow = [];
                array_push($headerRows, $aHeaderRow);
            }
        }
        $numRow = count($headerRows);
        //Fill in header row values from column names
        foreach ($showColumnKeys as $cKey) {
            $cKey = explode($sep, $cKey);
            for ($i = 0; $i < $numRow; $i++) {
                $header = Util::get($cKey, $i, null);
                array_push($headerRows[$i], [
                    'text' => $header
                ]);
            }
        }
        $lastSameHeaderIndexes = [];
        $lastNotNullHeaderIndexes = [];
        // Util::prettyPrint($headerRows); 
        $newHeaderRows = $headerRows;
        foreach ($headerRows as $rowIndex => $aHeaderRow) {
            foreach ($aHeaderRow as $colIndex => $header) {
                $currentText = $header['text'];
                if (!isset($currentText)) {
                    if ($rowIndex === 0) continue;
                    $lastNotNull = $lastNotNullHeaderIndexes[$colIndex];
                    $rowspan = (int) Util::init(
                        $newHeaderRows,
                        [$lastNotNull, $colIndex, 'rowspan'],
                        1
                    );
                    $newHeaderRows[$lastNotNull][$colIndex]['rowspan'] = $rowspan + 1;
                } else {
                    $lastNotNullHeaderIndexes[$colIndex] = $rowIndex;
                    if (!isset($lastSameHeaderIndexes[$rowIndex])) {
                        $lastSameHeaderIndexes[$rowIndex] = $colIndex;
                        continue;
                    };
                    $lastIndex = $lastSameHeaderIndexes[$rowIndex];
                    $lastSameHeader = $aHeaderRow[$lastIndex]['text'];

                    // echo "$currentText - $lastSameHeader <br>";
                    $isEqual = ($currentText === $lastSameHeader);
                    $isSameParents = true;
                    for ($k = $rowIndex - 1; $k > -1; $k--) {
                        $currentParent = $headerRows[$k][$colIndex]['text'];
                        $lastParent = $headerRows[$k][$lastIndex]['text'];
                        // echo "$currentParent - $lastParent <br>";
                        if ($currentParent !== $lastParent) {
                            $isSameParents = false;
                            break;
                        }
                    }
                    // echo "isEqual = $isEqual<br>";
                    // echo "isSameParents = $isSameParents<br>";

                    if (!$isEqual || !$isSameParents) {
                        $lastSameHeaderIndexes[$rowIndex] = $colIndex;
                    } else if ($colIndex < count($aHeaderRow) - 1) {
                        // echo "is equal and same parent <br>";
                        $colspan = (int) Util::init(
                            $newHeaderRows,
                            [$rowIndex, $lastIndex, 'colspan'],
                            1
                        );
                        // echo "i=$rowIndex lastIndex=$lastIndex colspan=$colspan<br>";
                        $newHeaderRows[$rowIndex][$lastIndex]['colspan'] = $colspan + 1;
                        $newHeaderRows[$rowIndex][$colIndex]['text'] = null;
                    } else {
                        $colspan = (int) Util::init(
                            $newHeaderRows,
                            [$rowIndex, $lastIndex, 'colspan'],
                            1
                        );
                        $newHeaderRows[$rowIndex][$lastIndex]['colspan'] = $colspan + 1;
                        $newHeaderRows[$rowIndex][$colIndex]['text'] = null;
                    }
                }
            }
        }
        // Util::prettyPrint($headerRows);  
        return $newHeaderRows;
    }

    protected function onRender()
    {
        $meta = $this->dataStore->meta();
        // echo "dt data="; print_r($this->dataStore->data());
        // echo "dt meta="; print_r($meta);
        if (!isset($meta['columns'])) $meta['columns'] = [];
        $cMetas = $meta["columns"];

        $showColumnKeys = array();
        if ($this->columns == array()) {
            $this->dataStore->popStart();
            $row = $this->dataStore->pop();
            if ($row) {
                $showColumnKeys = array_keys($row);
            } else {
                $showColumnKeys = array_keys($cMetas);
            }
        } else {
            foreach ($this->columns as $cKey => $cValue) {
                if (gettype($cValue) == "array") {
                    if ($cKey === "#") {
                        $cMetas[$cKey] = array(
                            "type" => "number",
                            "label" => "#",
                            "start" => 1,
                        );
                    }
                    if (!isset($cMetas[$cKey])) $cMetas[$cKey] = [];
                    $cMetas[$cKey] =  array_merge($cMetas[$cKey], $cValue);
                    if (!in_array($cKey, $showColumnKeys)) {
                        array_push($showColumnKeys, $cKey);
                    }
                } else {
                    if ($cValue === "#") {
                        $cMetas[$cValue] = array(
                            "type" => "number",
                            "label" => "#",
                            "start" => 1,
                        );
                    }
                    if (!in_array($cValue, $showColumnKeys)) {
                        array_push($showColumnKeys, $cValue);
                    }
                }
            }
        }
        $meta["columns"] = $cMetas;
        // Util::prettyPrint($showColumnKeys);
        // Util::prettyPrint($this->dataStore->data());
        // Util::prettyPrint($meta);

        if ($this->serverSide) {
            $columnsData = [];
            foreach ($showColumnKeys as $colKey)
                $columnsData[] = ['data' => $colKey];
            $scopeJson = json_encode($this->scope);
            $this->options = array_merge($this->options, [
                'serverSide' => true,
                'ajax' => [
                    'url' => '',
                    'data' => "function(d) {
                        d.id = '{$this->name}';
                        d.scope = {$scopeJson};
                    }",
                    'type' => "{$this->method}",
                    'dataFilter' => "function(data) {
                        var markStart = \"<dt-ajax id='dt_$this->name'>\";
                        var markEnd = '</dt-ajax>';
                        var start = data.indexOf(markStart);
                        var end = data.indexOf(markEnd);
                        var s = data.substring(start + markStart.length, end);
                        return s;
                    }",
                ],
                "columns" => $columnsData
            ]);
        }

        $headerRows = [];
        if ($this->complexHeaders) {
            $headerRows = $this->buildComplexHeaders($showColumnKeys);
            // Util::prettyPrint($headerRows);
        }

        $this->template("DataTables", array(
            "showColumnKeys" => $showColumnKeys,
            "headerRows" => $headerRows,
            "meta" => $meta,
        ));
    }

    protected function onFurtherProcessRequest($node)
    {
        if (!$this->serverSide) {
            return $node;
        }
        function getFinalSources($node)
        {
            $finalSources = [];
            $sources = [];
            $index = 0;
            while ($source = $node->previous($index)) {
                $sources[] = $source;
                $index++;
            }
            if (empty($sources)) {
                return [$node];
            }
            foreach ($sources as $source) {
                $finalSources = array_merge(
                    $finalSources,
                    getFinalSources($source)
                );
            }
            return $finalSources;
        }
        function setEnded($node, $bool)
        {
            $node->setEnded($bool);
            $index = 0;
            while ($source = $node->previous($index)) {
                setEnded($source, $bool);
                $index++;
            }
        }
        // $queryParams = $this->parseRequest($this->name, $this->method);
        $finalSources = getFinalSources($node);

        if (empty($this->columns)) {
            $queryParams = [
                'start' => 0,
                'length' => 1
            ];
            $dataStore = new \koolreport\core\DataStore();
            foreach ($finalSources as $finalSource) {
                if (method_exists($finalSource, 'queryProcessing')) {
                    $finalSource->queryProcessing($queryParams);
                    $dataStore = $node->pipe($dataStore);
                    $dataStore->requestDataSending();
                    setEnded($node, false);
                }
            }
            // $dataStore->popStart();
            // $row = $dataStore->pop();
            // if($row) {
            //     $this->trueColKeys = array_keys($row);
            // } else {
            // 	$this->trueColKeys = [];
            // }
            $this->trueColKeys = array_keys($dataStore->meta()["columns"]);
        } else {
            $this->trueColKeys = array_keys($this->columns);
        }

        foreach ($finalSources as $finalSource) {
            if (method_exists($finalSource, 'queryProcessing')) {
                $queryParams = $this->parseRequest($finalSource, $this->name, $this->method);
                $finalSource->queryProcessing($queryParams);
            }
        }
        return $node;
    }

    protected function getSearchAllSql(
        $datasource,
        $columns,
        $searchAllString,
        &$queryParams
    ) {
        $strToSql = function ($datasource, $columns, $searchStr, $searchOrder)
        use (&$queryParams) {
            $trueColKeys = $this->trueColKeys;
            $phrases = [];
            $searchStr = preg_replace_callback('/"([^"]*)"/', function ($matches)
            use (&$phrases) {
                if (!empty($matches[1])) {
                    array_push($phrases, $matches[1]);
                }
                return "";
            }, $searchStr);
            $searchStr = preg_replace_callback('/([^\s\t]*)/', function ($matches)
            use (&$phrases) {
                if (!empty($matches[1])) {
                    array_push($phrases, $matches[1]);
                }
                return "";
            }, $searchStr);
            $sql = "1=1 ";
            foreach ($phrases as $i => $phrase) {
                $sql .= " AND (0=1 ";
                foreach ($columns as $col) {
                    $colKey = $col['data'];
                    if (!in_array($colKey, $trueColKeys)) continue;
                    $paramName = ":{$colKey}_search_all_{$searchOrder}_$i";
                    $sql .= " OR {$colKey} like $paramName";
                    $queryParams['searchParams'][$paramName] = "%{$phrase}%";
                }
                $sql .= ")";
            }
            return $sql;
        };
        if ($this->searchMode === "or") {
            $searchAllString = preg_replace('/^\s*or\s+/i', '', $searchAllString);
            $searchAllString = preg_replace('/\s+or\s*$/i', '', $searchAllString);
            $searchAllString = preg_replace('/^\s*or\s+/i', '', $searchAllString);
            $searchStrings = preg_split('/\sor\s/i', $searchAllString);
            $searchAllSql = "1=1 ";
            foreach ($searchStrings as $searchOrder => $searchStr) {
                $searchSql = $strToSql($datasource, $columns, $searchStr, $searchOrder);
                $searchAllSql .= ($searchOrder == 0 ? " AND " : " OR ") . "($searchSql)";
            }
        } else {
            $searchAllSql = $strToSql($datasource, $columns, $searchAllString, 0);
        }
        return $searchAllSql;
    }

    protected function parseRequest($datasource, $dtId, $method = 'get')
    {
        $trueColKeys = $this->trueColKeys;
        $queryParams = [
            'start' => 0,
            'length' => 1,
            'searchParams' => [],
        ];
        $request = strtolower($method) === 'post' ? $_POST : $_GET;
        $id = Util::get($request, 'id', null);
        if ($id == $dtId) {
            $searchSql = "1=1";
            $columns = Util::get($request, 'columns', []);
            $searchColsSql = "1=1";
            foreach ($columns as $col) {
                // echo "col="; print_r($col);
                $colKey = $col['data'];
                if (!in_array($colKey, $trueColKeys)) continue;
                $colSearchVal = Util::get($col, ['search', 'value'], null);
                if (empty($colSearchVal)) continue;
                $paramName = ":{$colKey}_search";
                $searchColsSql .= " AND $colKey like $paramName";
                $queryParams['searchParams'][$paramName] = "%{$colSearchVal}%";
            }
            $searchSql .= " AND ($searchColsSql)";

            $searchAll = Util::get($request, 'search', []);
            $searchAllString = Util::get($searchAll, 'value', null);
            $searchAllSql = $this->getSearchAllSql(
                $datasource,
                $columns,
                $searchAllString,
                $queryParams
            );

            $searchSql .= " AND ($searchAllSql)";
            $queryParams['search'] = $searchSql;

            $orders = Util::get($request, 'order', []);
            $orderSql = "";
            foreach ($orders as $order) {
                $colKey = $columns[$order['column']]['data'];
                if (!in_array($colKey, $trueColKeys)) continue;
                $dir = strtolower($order['dir']);
                if ($dir !== "asc"  && $dir !== "desc") continue;
                $orderSql .= $colKey . " " . $dir . ",";
            }
            if (!empty($orderSql)) {
                $orderSql = substr($orderSql, 0, -1);
                $queryParams['order'] = $orderSql;
            }

            $start = (int) Util::get($request, 'start', 0);
            $length = (int) Util::get($request, 'length', 1);
            $queryParams['start'] = $start;
            $queryParams['length'] = $length;

            $queryParams['countTotal'] = true;
            $queryParams['countFilter'] = true;
        }
        // echo 'parseRequest queryParams='; print_r($queryParams); 
        return $queryParams;
    }

    /**
     * Render javascript code to implement user's custom script 
     * just before init DataTables
     * 
     * @return null
     */
    protected function clientSideBeforeInit()
    {
        if ($this->onBeforeInit != null) {
            echo "(" . $this->onBeforeInit . ")();";
        }
    }
}
