<?php

namespace koolreport\excel;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use koolreport\core\Utility as Util;
use \PhpOffice\PhpSpreadsheet as ps;
use \PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Table extends Widget
{
    protected $namePrefix = "ExcelTable";
    protected $type = 'table';

    public static function saveContentToSheet($content, $sheet
        , $chartDataSheet, &$sheetInfo = []) {
        list($highestRow, $highestColumn, $range) =
        self::getSheetRange($sheet, $content);
        $dataSource = Util::get($content, 'dataSource', new \koolreport\core\DataStore());
        $option = $content;
        // $option['startRow'] = $highestRow;
        $pos = Coordinate::coordinateFromString($range[1]);
        $option['startColumn'] = Coordinate::columnIndexFromString($pos[0]);
        $option['startRow'] = $pos[1];
        // if ($range[1] === 'E10') {print_r($option['startColumn']); exit; }
        $tableAutoName = 'table_' . $sheetInfo['tableAutoId']++;
        $tableName = Util::get($content, 'name', $tableAutoName);
        $sheetInfo['tablePositions'][$tableAutoName]
        = $sheetInfo['tablePositions'][$tableName]
        = self::saveDataStoreToSheet($dataSource, $sheet, $option);
        $sheetInfo['tableSheet'][$tableAutoName]
        = $sheetInfo['tableSheet'][$tableName]
        = $sheet->getTitle();
    }

    public static function saveContentToSpreadsheet($content, $writer, &$sheetInfo = [])
    {
        $dataSource = Util::get($content, 'dataSource', new \koolreport\core\DataStore());
        $translation = Util::get($content, ['attributes', 'translation'], "0:0");
        $translation = explode(":", $translation);
        $colTrans = $translation[0];
        $rowTrans = $translation[1];
        for ($i = 0; $i < $rowTrans; $i++) {
            $emptyRow = WriterEntityFactory::createRowFromArray([]);
            $writer->addRow($emptyRow);
        }
        $option = $content;
        $option['startColumn'] = $colTrans;
        $sheetInfo['highestRow'] = self::saveDataStoreToSpreadsheet(
            $dataSource, $writer, $option);
    }

    public static function getFormatted($value, $type, $meta)
    {
        $formatCode = "";
        $isDateTime = false;
        switch ($type) {
            case "number":
                $decimals = Util::get($meta, "decimals", 0);
                $dec_point = Util::get($meta, "dec_point", ".");
                $thousand_sep = Util::get($meta, "thousand_sep", ",");
                $prefix = Util::get($meta, "prefix", "");
                $suffix = Util::get($meta, "suffix", "");
                $zeros = ""; for ($i=0; $i<$decimals; $i++) $zeros .= "0";
                if ($decimals > 0) $zeros = ".$zeros";
                $formatCode = "\"{$prefix}\"#,##0{$zeros}\"{$suffix}\"";
                break;
            case "datetime":
                $datetimeFormat = Util::get($meta, "format", "Y-m-d H:i:s");
                $defaultFormat = 'YYYY-MM-DD HH:MM:SS';
                $isDateTime = true;
                break;
            case "date":
                $datetimeFormat = Util::get($meta, "format", "Y-m-d");
                $defaultFormat = 'YYYY-MM-DD';
                $isDateTime = true;
                break;
            case "time":
                $datetimeFormat = Util::get($meta, "format", "H:i:s");
                $defaultFormat = 'HH:MM:SS';
                $isDateTime = true;
                break;
            default:
                $value = Util::format($value, $meta);
                break;
        }
        if ($isDateTime) {
            $formatCode = Util::get($meta, "displayFormat", $defaultFormat);
            if ($date = \DateTime::createFromFormat($datetimeFormat, $value)) {
                $value = $date;
            }
            $value = ps\Shared\Date::PHPToExcel($value);
        }

        return [$value, $formatCode];
    }

    public static function saveDataStoreToSheet($ds, $sheet, $option)
    {
        $filtering = Util::get($option, 'filtering', null);
        $sorting = Util::get($option, 'sorting', null);
        $paging = Util::get($option, 'paging', null);
        if (!empty($filtering)) {
            $ds = $ds->filter($filtering);
        }
        if (!empty($sorting)) {
            $ds = $ds->sort($sorting);
        }
        if (!empty($paging)) {
            $ds = $ds->paging($paging[0], $paging[1]);
        }

        // $data = $ds->data();
        $meta = $ds->meta();
        $headersExcelStyle = Util::get($option, 'headersExcelStyle', []);
        $columnsExcelStyle = Util::get($option, 'columnsExcelStyle', []);
        $excelStyle = Util::get($option, 'excelStyle', []);
        $map = Util::get($option, 'map', []);

        $showHeader = Util::get($option, 'showHeader', true);
        $showBottomHeader = Util::get($option, 'showBottomHeader', false);
        $showFooter = Util::get($option, 'showFooter', false);

        $colMetas = $meta['columns'];
        $optCols = Util::get($option, 'columns', array_keys($colMetas));
        $expColKeys = [];

        $startCol = Util::get($option, 'startColumn', 1);
        $startRow = Util::get($option, 'startRow', 1);

        $rowOrder = $startRow;
        $maxlength = array();

        $headers = [];
        $expColOrder = $startCol;
        foreach ($optCols as $col) {
            $colKeys = array_keys($colMetas);
            $colLabels = array_filter($colMetas, function ($cMeta) use ($col) {
                $label = Util::get($cMeta, 'label', null);
                if ($label === $col) {
                    return true;
                } else {
                    return false;
                }

            });
            if (isset($colMetas[$col])) {
                $colKey = $col;
            } else if (!empty($colLabels)) {
                $colKey = array_keys($colLabels)[0];
            } else if (isset($colKeys[$col])) {
                $colKey = $colKeys[$col];
            } else {
                continue;
            }

            $label = Util::get($colMetas, 'label', $colKey);
            $maxlength[] = strlen($label);
            $expColKeys[] = $colKey;
        }
        
        if ($showHeader) {
            $expColOrder = $startCol;
            foreach ($expColKeys as $colKey) {
                $colMeta = $colMetas[$colKey];
                $label = Util::get($colMeta, 'label', $colKey);
                $type = Util::get($colMeta, 'type', 'string');
                $headerMap = Util::get($map, 'header', []);
                $headerStyle = Util::get($headersExcelStyle, $colKey, []);
                $headerStyle = Util::get(
                    $excelStyle, 'header', $headerStyle);

                $alignment = $type === 'number' ?
                ps\Style\Alignment::HORIZONTAL_RIGHT : ps\Style\Alignment::HORIZONTAL_LEFT;
                $cell = Coordinate::stringFromColumnIndex($expColOrder)
                    . $rowOrder;
                $sheet->setCellValue($cell, Util::map($headerMap, $colKey, $label));
                $style = $sheet->getStyle($cell);
                $style->getAlignment()
                    ->setHorizontal($alignment);
                $style->getFont()->setBold(true);
                $style->applyFromArray(Util::map($headerStyle, $colKey, []));

                $expColOrder++;
            }

            $rowOrder++;
        }

        $ds->popStart();
        while ($row = $ds->pop()) {
            $expColOrder = $startCol;
            foreach ($expColKeys as $i => $colKey) {
                $colMeta = Util::get($colMetas, $colKey, []);
                $cellStyle = Util::get($columnsExcelStyle, $colKey, []);
                $cellStyle = Util::get($excelStyle, 'cell', $cellStyle);
                $cellMap = Util::get($map, 'cell', []);
                $value = Util::get($row, $colKey);
                $value = Util::map($cellMap, [$colKey, $value, $row], $value);
                $type = Util::get($colMeta, 'type', 'string');

                list($value, $formatCode) = self::getFormatted($value, $type, $colMeta);

                // echo "value=$value <br>";
                // echo "formatCode=$formatCode <br>";
                // \PhpOffice\PhpSpreadsheet\Shared\StringHelper::setDecimalSeparator( ',' );
                // \PhpOffice\PhpSpreadsheet\Shared\StringHelper::setThousandsSeparator( '.' );
                // \PhpOffice\PhpSpreadsheet\Settings::setLocale('fr');
                // exit;

                $cell = Coordinate::stringFromColumnIndex($expColOrder)
                    . $rowOrder;
                $sheet->setCellValue($cell, $value);

                $style = $sheet->getStyle($cell);
                if (!empty($formatCode)) {
                    $style->getNumberFormat()->setFormatCode($formatCode);
                }

                // echo $sheet->getCell($cell)->getFormattedValue(); exit;

                $alignment = $type === 'number' ? ps\Style\Alignment::HORIZONTAL_RIGHT
                : ps\Style\Alignment::HORIZONTAL_LEFT;
                $style->getAlignment()
                    ->setHorizontal($alignment);

                $style->applyFromArray(
                    Util::map($cellStyle, [$colKey, $value, $row], []));

                if ($maxlength[$i] < strlen($value)) {
                    $maxlength[$i] = strlen($value);
                }
                $expColOrder++;
            }
            $rowOrder++;
        }

        if ($showFooter) {
            $expColOrder = $startCol;
            foreach ($expColKeys as $colKey) {
                $colMeta = $colMetas[$colKey];
                $footerValue = "";
                $method = strtolower(Util::get($colMeta, "footer"));
                if (in_array($method, ["sum", "avg", "min", "max", "mode"])) {
                    $footerValue = Util::formatValue(
                        $ds->$method($colKey), $colMeta);
                }
                $footerText = Util::get($colMeta, "footerText");
                if ($footerText !== null) {
                    $footerValue = str_replace("@value", $footerValue, $footerText);
                }
                $type = gettype($footerValue);
                $type = Util::get($colMeta, 'type', $type);
                $alignment = $type === 'number' ?
                ps\Style\Alignment::HORIZONTAL_RIGHT : ps\Style\Alignment::HORIZONTAL_LEFT;

                $footerMap = Util::get($map, 'footer', []);

                list($footerValue, $formatCode) =
                self::getFormatted($footerValue, $type, $colMeta);

                $cell = Coordinate::stringFromColumnIndex($expColOrder)
                    . $rowOrder;
                $sheet->setCellValue(
                    $cell, Util::map($footerMap, [$colKey, $footerValue], $footerValue));

                $style = $sheet->getStyle($cell);
                $style->getAlignment()
                    ->setHorizontal($alignment);
                $footerStyle = Util::get($excelStyle, 'footer', []);
                $style->applyFromArray(
                    Util::map($footerStyle, [$colKey, $footerValue], []));

                $expColOrder++;
            }
            $rowOrder++;
        }

        if ($showBottomHeader) {
            $expColOrder = $startCol;
            foreach ($expColKeys as $colKey) {
                $colMeta = $colMetas[$colKey];
                $label = Util::get($colMeta, 'label', $colKey);
                $type = Util::get($colMeta, 'type', 'string');
                $headerStyle = Util::get($headersExcelStyle, $colKey, []);
                $headerStyle = Util::get($excelStyle, 'bottomHeader', $headerStyle);
                $bottomHeaderMap = Util::get($map, 'bottomHeader', []);

                $alignment = $type === 'number' ?
                ps\Style\Alignment::HORIZONTAL_RIGHT : ps\Style\Alignment::HORIZONTAL_LEFT;
                $cell = Coordinate::stringFromColumnIndex($expColOrder)
                    . $rowOrder;
                $sheet->setCellValue($cell, Util::map($bottomHeaderMap, $colKey, $label));
                $style = $sheet->getStyle($cell);
                if (!empty($formatCode)) {
                    $style->getNumberFormat()->setFormatCode($formatCode);
                }
                $style->getAlignment()
                    ->setHorizontal($alignment);
                $style->getFont()->setBold(true);
                $style->applyFromArray(Util::map($headerStyle, $colKey, []));

                $maxlength[] = strlen($label);

                $expColOrder++;
            }
            $rowOrder++;
        }

        // $sheet->calculateColumnWidths();
        for ($i = 0; $i < sizeof($maxlength); $i++) {
            $col = Coordinate::stringFromColumnIndex($i + 1);
            // $sheet->getColumnDimension($col)->setWidth($maxlength[$i] + 2);
            // $titlecolwidth = $sheet->getColumnDimension($col)->getWidth();
            // $sheet->getColumnDimension($col)->setAutoSize(false);
            // $sheet->getColumnDimension($col)->setWidth($titlecolwidth);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            'topLeft' => ($startCol) . ":" . ($startRow),
            'bottomRight' => ($startCol + count($expColKeys) - 1) . ":" . ($rowOrder - 1),
        ];
    }

    public static function saveDataStoreToSpreadsheet($ds, $writer, $option)
    {
        $filtering = Util::get($option, 'filtering', null);
        $sorting = Util::get($option, 'sorting', null);
        $paging = Util::get($option, 'paging', null);
        if (!empty($filtering)) {
            $ds = $ds->filter($filtering);
        }
        if (!empty($sorting)) {
            $ds = $ds->sort($sorting);
        }
        if (!empty($paging)) {
            $ds = $ds->paging($paging[0], $paging[1]);
        }

        // $data = $ds->data();
        $meta = $ds->meta();
        $spreadsheetStyle = Util::get($option, 'spreadsheetStyle', []);
        $map = Util::get($option, 'map', []);

        $showHeader = Util::get($option, 'showHeader', true);
        $showBottomHeader = Util::get($option, 'showBottomHeader', false);
        $showFooter = Util::get($option, 'showFooter', false);

        $colMetas = $meta['columns'];
        $optCols = Util::get($option, 'columns', array_keys($colMetas));
        $expColKeys = [];

        $startCol = Util::get($option, 'startColumn', 1);

        $headers = [];
        $expColOrder = $startCol;
        foreach ($optCols as $col) {
            $colKeys = array_keys($colMetas);
            $colLabels = array_filter($colMetas, function ($cMeta) use ($col) {
                $label = Util::get($cMeta, 'label', null);
                if ($label === $col) {
                    return true;
                } else {
                    return false;
                }

            });
            if (isset($colMetas[$col])) {
                $colKey = $col;
            } else if (!empty($colLabels)) {
                $colKey = array_keys($colLabels)[0];
            } else if (isset($colKeys[$col])) {
                $colKey = $colKeys[$col];
            } else {
                continue;
            }

            $label = Util::get($colMetas, 'label', $colKey);
            $maxlength[] = strlen($label);
            $expColKeys[] = $colKey;
        }

        if ($showHeader) {
            $headerMap = Util::get($map, 'header', []);
            $headerStyle = Util::get($spreadsheetStyle, 'header', []);
            $expColOrder = $startCol;
            $cellValues = array_fill(0, $startCol, WriterEntityFactory::createCell(null));
            foreach ($expColKeys as $colKey) {
                $colMeta = $colMetas[$colKey];
                $label = Util::get($colMeta, 'label', $colKey);
                $colHeaderStyle = Util::map($headerStyle, $colKey, []);
                Util::init($colHeaderStyle, ['font', 'bold'], true);
                $styleObj = self::getSpreadsheetStyleObj($colHeaderStyle);

                $headerValue = Util::map($headerMap, $colKey, $label);
                $cellValues[] = WriterEntityFactory::createCell($headerValue, $styleObj);

                $expColOrder++;
            }
            $rowFromValues = WriterEntityFactory::createRow($cellValues);
            $writer->addRow($rowFromValues);
        }

        $ds->popStart();
        $cellMap = Util::get($map, 'cell', []);
        $cellStyle = Util::get($spreadsheetStyle, 'cell', []);
        while ($row = $ds->pop()) {
            $expColOrder = $startCol;
            $cellValues = array_fill(0, $startCol, WriterEntityFactory::createCell(null));
            foreach ($expColKeys as $i => $colKey) {
                $value = Util::get($row, $colKey);
                $value = Util::map($cellMap, [$colKey, $value, $row], $value);
                $styleObj = self::getSpreadsheetStyleObj(
                    Util::map($cellStyle, [$colKey, $value, $row], [])
                );
                $cellValues[] = WriterEntityFactory::createCell($value, $styleObj);

                $expColOrder++;
            }
            $rowFromValues = WriterEntityFactory::createRow($cellValues);
            $writer->addRow($rowFromValues);
        }

        if ($showFooter) {
            $footerMap = Util::get($map, 'footer', []);
            $footerStyle = Util::get($spreadsheetStyle, 'footer', []);
            $expColOrder = $startCol;
            $cellValues = array_fill(0, $startCol, WriterEntityFactory::createCell(null));
            foreach ($expColKeys as $colKey) {
                $colMeta = $colMetas[$colKey];
                $footerValue = "";
                $method = strtolower(Util::get($colMeta, "footer"));
                if (in_array($method, ["sum", "avg", "min", "max", "mode"])) {
                    $footerValue = Util::formatValue(
                        $ds->$method($colKey), $colMeta);
                }
                $footerText = Util::get($colMeta, "footerText");
                if ($footerText !== null) {
                    $footerValue = str_replace("@value", $footerValue, $footerText);
                }
                $footerValue = Util::map($footerMap, [$colKey, $footerValue], $footerValue);

                $styleObj = self::getSpreadsheetStyleObj(
                    Util::map($footerStyle, [$colKey, $footerValue], [])
                );
                $cellValues[] = WriterEntityFactory::createCell($footerValue, $styleObj);

                $expColOrder++;
            }
            $rowFromValues = WriterEntityFactory::createRow($cellValues);
            $writer->addRow($rowFromValues);
        }

        if ($showBottomHeader) {
            $bottomHeaderMap = Util::get($map, 'bottomHeader', []);
            $bottomHeaderStyle = Util::get($spreadsheetStyle, 'bottomHeader', []);
            $expColOrder = $startCol;
            $cellValues = array_fill(0, $startCol, WriterEntityFactory::createCell(null));
            foreach ($expColKeys as $colKey) {
                $colMeta = $colMetas[$colKey];
                $label = Util::get($colMeta, 'label', $colKey);

                $colBottomHeaderStyle = Util::map($bottomHeaderStyle, $colKey, []);
                Util::init($colBottomHeaderStyle, ['font', 'bold'], true);
                $styleObj = self::getSpreadsheetStyleObj($colBottomHeaderStyle);

                $bottomHeaderValue = Util::map($bottomHeaderMap, $colKey, $label);
                $cellValues[] = WriterEntityFactory::createCell($bottomHeaderValue, $styleObj);

                $expColOrder++;
            }
            $rowFromValues = WriterEntityFactory::createRow($cellValues);
            $writer->addRow($rowFromValues);
        }

        return 0;
    }
}
