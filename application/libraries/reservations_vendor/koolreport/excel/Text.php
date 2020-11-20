<?php

namespace koolreport\excel;

use koolreport\core\Utility as Util;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class Text extends Widget
{
    protected $namePrefix = "ExcelText";
    protected $type = "text";

    public static function saveContentToSheet($content, $sheet
        , $chartDataSheet, &$sheetInfo = []) {
        list($highestRow, $highestColumn, $range) =
        self::getSheetRange($sheet, $content);
        if ($range[0] !== $range[1]) {
            $sheet->mergeCells($range[0] . ":" . $range[1]);
        }

        $sheet->setCellValue($range[0], (string) $content['text']);
        $contentAttrs = Util::get($content, 'attributes', []);
        $excelStyle = Util::get($contentAttrs, 'excelstyle', []);
        $excelStyle = Util::get($content, 'excelStyle', $excelStyle);
        if (is_string($excelStyle)) {
            $excelStyle = json_decode($excelStyle, true);
        }

        if (!empty($excelStyle)) {
            $defaultHeight = 12.75;
            $defaultFontSize = 11;
            $delta = $defaultHeight - $defaultFontSize;
            $fontSize = Util::get($excelStyle, ['font', 'size'], $defaultFontSize);
            $rowNum = preg_replace("/[^\d]*/", "", $range[0]);
            $sheet->getRowDimension($rowNum)->setRowHeight($fontSize + $fontSize / $defaultFontSize * $delta);
            $sheet->getStyle($range[0])->applyFromArray($excelStyle);
        }
    }

    public static function saveContentToSpreadsheet($content, $writer, &$sheetInfo = [])
    {
        $translation = Util::get($content, ['attributes', 'translation'], "0:0");
        $translation = explode(":", $translation);
        $colTrans = $translation[0];
        $rowTrans = $translation[1];
        for ($i = 0; $i < $rowTrans; $i++) {
            $emptyRow = WriterEntityFactory::createRowFromArray([]);
            $writer->addRow($emptyRow);
        }
        $values = [];
        for ($i = 0; $i < $colTrans; $i++) {
            $emptyCol = null;
            $values[] = WriterEntityFactory::createCell($emptyCol);
        }
        $spreadsheetStyle = Util::get($content, ['attributes', 'spreadsheetStyle'], []);
        $spreadsheetStyle = Util::get($content, 'spreadsheetStyle', $spreadsheetStyle);
        $styleObj = self::getSpreadsheetStyleObj($spreadsheetStyle);
        $values[] = WriterEntityFactory::createCell($content['text'], $styleObj);
        $rowFromValues = WriterEntityFactory::createRow($values);
        $writer->addRow($rowFromValues);
    }
}
