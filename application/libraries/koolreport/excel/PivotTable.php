<?php

namespace koolreport\excel;

use \koolreport\core\Utility as Util;
use \PhpOffice\PhpSpreadsheet as ps;
use \PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class PivotTable extends Widget
{
    protected $namePrefix = "ExcelPivotTable";
    protected $type = "pivottable";

    public static function saveContentToSheet($content, $sheet
        , $chartDataSheet, & $sheetInfo = [])
    {
        list($highestRow, $highestColumn, $range) = 
            self::getSheetRange($sheet, $content);
        $option = $content;
        // $option['startRow'] = $highestRow;
        $pos = Coordinate::coordinateFromString($range[1]);
        $option['startCol'] = $pos[0];
        $option['startRow'] = $pos[1];
        $dataSource = Util::get($content, 'dataSource', new \koolreport\core\DataStore());
        self::saveDataStoreToSheet($dataSource, $sheet, $option);
    }

    public static function saveDataStoreToSheet($dataStore, $sheet, $option)
    {
        $totalName = Util::get($option, 'totalName', 'Total');
        $emptyValue = Util::get($option, 'emptyValue', '-');
        $hideSubTotalRows = Util::get($option, 'hideSubTotalRows', false);
        $hideSubTotalColumns = Util::get($option, 'hideSubTotalColumns', false);
        $hideTotalRow = Util::get($option, 'hideTotalRow', false);
        $hideGrandTotalRow = Util::get($option, 'hideGrandTotalRow', $hideTotalRow);
        $hideTotalColumn = Util::get($option, 'hideTotalColumn', false);
        $hideGrandTotalColumn = Util::get($option, 'hideGrandTotalColumn', $hideTotalColumn);
        $showDataHeaders = Util::get($option, 'showDataHeaders', false);
        $excelStyle = Util::get($option, 'excelStyle', []);
        $colMetas = $dataStore->meta()['columns'];
        // echo "colMetas = "; print_r($colMetas); echo " <br> ";

        $pivotUtil = new \koolreport\pivot\PivotUtil($dataStore, $option);
        $fni = $pivotUtil->getFieldsNodesIndexes();
        $rowNodes = $fni['mappedRowNodes'];
        $colNodes = $fni['mappedColNodes'];
        $rowIndexes = $fni['rowIndexes'];
        $colIndexes = $fni['colIndexes'];
        $rowNodesInfo = $fni['rowNodesInfo'];
        $colNodesInfo = $fni['colNodesInfo'];
        $colFields = array_values($fni['colFields']);
        $rowFields = array_values($fni['rowFields']);
        $dataFields = array_values($fni['dataFields']);
        $mappedDataFields = $fni['mappedDataFields'];
        $mappedDataHeaders = $fni['mappedDataHeaders'];
        $indexToMappedData = $fni['indexToMappedData'];
        $rowNodesExcelStyle = $fni['rowNodesExcelStyle'];
        $colNodesExcelStyle = $fni['colNodesExcelStyle'];
        $dataHeadersExcelStyle = $fni['dataHeadersExcelStyle'];
        // print_r($colNodesExcelStyle); exit;
        $indexToDataExcelStyle = $fni['indexToDataExcelStyle'];
        // print_r($indexToDataExcelStyle); exit;

        $startCol = Util::get($option, 'startColumn', 1);
        $startRow = Util::get($option, 'startRow', 1);

        $cell = ps\Cell\Coordinate::stringFromColumnIndex($startCol) . ($startRow);
        $colspan = count($rowFields) - 1;
        $rowspan = count($colFields) - 1 + ($showDataHeaders ? 1 : 0);
        $endCell = ps\Cell\Coordinate::stringFromColumnIndex(
            $startCol + $colspan) . ($startRow + $rowspan);
        $sheet->setCellValue($cell, implode(' | ', $mappedDataFields));
        $sheet->mergeCells($cell . ":" . $endCell);
        $style = $sheet->getStyle($cell);
        $dFieldStyle = Util::get($excelStyle, 'dataField', []);
        $dFieldStyle = Util::map($dFieldStyle, [$dataFields], []);
        $style->applyFromArray($dFieldStyle);
        $style->getAlignment()->setHorizontal(
            ps\Style\Alignment::HORIZONTAL_CENTER);
        $style->getAlignment()->setVertical(
            ps\Style\Alignment::VERTICAL_TOP);

        // print_r($colIndexes); exit;
        $showColData = [];
        foreach ($colFields as $i => $f) {
            foreach ($colIndexes as $c => $j) {
                $nodeMark = $colNodesInfo[$j];
                $showColHeader = isset($nodeMark[$f]['numChildren']);
                $isTotal = isset($nodeMark[$f]['total']);
                $isSubTotal = $isTotal && $i > 0;
                $isGrandTotal = $isTotal && $i === 0;
                if (! isset($showColData[$c])) $showColData[$c] = true;
                if ($showColHeader && $hideSubTotalColumns && $isSubTotal)
                    $showColData[$c] = false;
                if ($showColHeader && $hideGrandTotalColumn && $isGrandTotal) 
                    $showColData[$c] = false;
            }
        }
        // print_r($showColData); exit;

        foreach ($colFields as $i => $f) {
            foreach ($colIndexes as $c => $j) {
                $node = $colNodes[$j];
                $nodeMark = $colNodesInfo[$j];
                $nodeExcelStyle = $colNodesExcelStyle[$j];
                // print_r($nodeExcelStyle); exit;
                $showColHeader = isset($nodeMark[$f]['numChildren']);
                if ($showColHeader && $showColData[$c]) {
                    $isTotal = isset($nodeMark[$f]['total']);
                    $numSlippedColumns = 0;
                    for ($n=0; $n<$c; $n++)
                        if (! $showColData[$n])
                            $numSlippedColumns += count($dataFields);
                    $row = $startRow + $i;
                    $col = $startCol + count($rowFields) 
                        + $c * count($dataFields) - $numSlippedColumns;
                    $rowspan = $isTotal ? $nodeMark[$f]['level'] : 1;
                    $colspan = $hideSubTotalColumns ? 
                        $nodeMark[$f]['numLeaf'] : $nodeMark[$f]['numChildren'];
                    $endRow = $row + $rowspan - 1;
                    $endCol = $col + $colspan - 1;
                    $cell = ps\Cell\Coordinate::stringFromColumnIndex($col) . $row;
                    $endCell = ps\Cell\Coordinate::stringFromColumnIndex($endCol) . $endRow;
                    $sheet->mergeCells($cell . ":" . $endCell);

                    $value = $node[$f];
                    $sheet->getCell($cell)->setValue($value);
                    $style = $sheet->getStyle($cell);
                    $style->getAlignment()->setHorizontal(
                        ps\Style\Alignment::HORIZONTAL_CENTER);
                    $style->getAlignment()->setVertical(
                        ps\Style\Alignment::VERTICAL_TOP);
                    $excelStyle = Util::get($nodeExcelStyle, $f, []);
                    // print_r($excelStyle); exit;
                    $style->applyFromArray($excelStyle);
                }
            }
        }

        if ($showDataHeaders) {
            $row = $startRow + count($colFields);
            $col = $startCol + count($rowFields); 
            foreach ($colIndexes as $c => $j) {
                if (! $showColData[$c]) continue;
                foreach($dataFields as $di => $df) {
                    $cell = ps\Cell\Coordinate::stringFromColumnIndex($col) . $row;
                    $mappedDH = $mappedDataHeaders[$df];
                    $sheet->getCell($cell)->setValue($mappedDH);
                    $style = $sheet->getStyle($cell);
                    $excelStyle = Util::get($dataHeadersExcelStyle, $df, []);
                    $style->applyFromArray($excelStyle);
                    $col++;
                }
            }
            $startRow++;
        }

        $maxLength = array_fill(0, count($rowFields), 0);
        $numSkippedRows = 0;
        foreach ($rowIndexes as $r => $i) {
            $node = $rowNodes[$i];
            $nodeMark = $rowNodesInfo[$i];
            $nodeExcelStyle = $rowNodesExcelStyle[$i];
            $showRowData = true;
            foreach ($rowFields as $j => $f) {
                $showRowHeader = isset($nodeMark[$f]['numChildren']);
                $isTotal = isset($nodeMark[$f]['total']);
                $isSubTotal = $isTotal && $j > 0;
                $isGrandTotal = $isTotal && $j === 0;
                if ($showRowHeader && $hideSubTotalRows && $isSubTotal) 
                    $showRowData = false;
                if ($showRowHeader && $hideGrandTotalRow && $isGrandTotal) 
                    $showRowData = false;
                if ($showRowHeader && ! $showRowData) $numSkippedRows++;
                if ($showRowHeader && $showRowData) {
                    $row = $startRow + count($colFields) + $r - $numSkippedRows;
                    $col = $startCol + $j;
                    $rowspan = $nodeMark[$f]['numChildren'];
                    if ($hideSubTotalRows && $rowspan > 1) $rowspan--;
                    $colspan = $isTotal ? $nodeMark[$f]['level'] : 1;
                    $endRow = $row + $rowspan - 1;
                    $endCol = $col + $colspan - 1;
                    $cell = ps\Cell\Coordinate::stringFromColumnIndex($col) . $row;
                    $endCell = ps\Cell\Coordinate::stringFromColumnIndex($endCol) . $endRow;
                    $sheet->mergeCells($cell . ":" . $endCell);

                    $value = $node[$f];
                    $sheet->getCell($cell)->setValue($value);
                    $style = $sheet->getStyle($cell);
                    $style->getAlignment()->setVertical(
                        ps\Style\Alignment::VERTICAL_CENTER);
                    $excelStyle = Util::get($nodeExcelStyle, $f, []);
                    $style->applyFromArray($excelStyle);
                    if ($maxLength[$j] < strlen($value)) {
                        $maxLength[$j] = strlen($value);
                    }
                }
            }

            if (! $showRowData) continue;

            foreach ($colIndexes as $c => $j) {
                if (! $showColData[$c]) continue;
                
                $numSlippedColumns = 0;
                for ($n=0; $n<$c; $n++)
                    if (! $showColData[$n])
                        $numSlippedColumns += count($dataFields);
                $mappedDataRow = Util::get($indexToMappedData, [$i, $j], []);
                $dataRowExcelStyle = Util::get($indexToDataExcelStyle, [$i, $j], []);
                // print_r($indexToDataExcelStyle[$i][$j]); exit;
                // echo "$i - $j "; print_r($dataRowExcelStyle); exit;
                foreach ($dataFields as $k => $df) {
                    $col = $startCol + count($rowFields) + $c * count($dataFields) 
                        + $k - $numSlippedColumns;
                    $col = ps\Cell\Coordinate::stringFromColumnIndex($col);
                    $row = $startRow + count($colFields) + $r - $numSkippedRows;
                    $cell = $col . $row;
                    if (isset($mappedDataRow[$df])) {
                        $value = $mappedDataRow[$df];
                        $colMeta = Util::get($colMetas, $df, 'string');
                        $type = Util::get($colMeta, 'type', 'string');
                        $format = $colMeta;
                        $formatCode = "";
                        switch ($type) {
                            case "number":
                                $decimals = Util::get($format,"decimals",0);
                                $dec_point = Util::get($format,"dec_point",".");
                                $thousand_sep = Util::get($format,"thousand_sep",",");
                                $prefix = Util::get($format,"prefix","");
                                $suffix = Util::get($format,"suffix","");
                                $formatCode = "\"{$prefix}\"#{$thousand_sep}##0{$dec_point}00\"{$suffix}\"";
                                break;
                            default:
                                $value = Util::format($value, $format);
                                break;
                        }
                    } else {
                        $value = $emptyValue;
                    }
                    $sheet->getCell($cell)->setValue($value);
                    $style = $sheet->getStyle($cell);
                    if (! empty($formatCode)) {
                        $style->getNumberFormat()->setFormatCode($formatCode);
                    }
                    $style->getAlignment()->setHorizontal(
                        ps\Style\Alignment::HORIZONTAL_RIGHT);
                    $excelStyle = Util::get($dataRowExcelStyle, $df, []);
                    $style->applyFromArray($excelStyle);
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        }

        for ($i = 0; $i < sizeof($maxLength); $i++) {
            $col = ps\Cell\Coordinate::stringFromColumnIndex($startCol + $i);
            // $sheet->getColumnDimension($col)->setWidth($maxLength[$i]);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}