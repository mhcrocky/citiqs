<?php

namespace koolreport\excel;

use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use \koolreport\core\Utility as Util;

class Widget extends \koolreport\core\Widget
{
    protected $namePrefix = "ExcelWidget";
    protected $type = 'widget';

    protected function setType()
    {
    }

    protected function onRender()
    {
        $this->useAutoName($this->namePrefix);
        $this->setType();
        $params = $this->params;
        $params['type'] = $this->type;
        $params['name'] = $this->name;
        $this->report->excelExportHandler->setWidgetParams($this->name, $params);
        $params = ['name' => $this->name];
        echo json_encode($params);
    }

    public static function getSheetRange($sheet, $content = [])
    {
        $highestRow = $sheet->getHighestDataRow(); // e.g. 10
        $highestColumn = $sheet->getHighestDataColumn(); // e.g 'F'
        $range = 'A' . $highestRow . ':' . $highestColumn . $highestRow;
        $data = $sheet->rangeToArray(
            $range, null, true, false);
        $emptySheet = true;
        foreach ($data as $rows) {
            foreach ($rows as $row) {
                if (!empty($row)) {
                    $emptySheet = false;
                    break;
                    break;
                }
            }
        }
        if (!$emptySheet) {
            $highestRow++;
        }

        $cell = "A" . ($highestRow);
        $contentAttrs = Util::get($content, 'attributes', []);

        $cell = Util::get($contentAttrs, 'cell', $cell);
        $range = "$cell:$cell";
        $range = Util::get($contentAttrs, 'range', $range);
        $range = explode(":", $range);

        return [$highestRow, $highestColumn, $range];
    }

    public static function getSpreadsheetStyleObj($spreadsheetStyle = [])
    {
        $styleBuilder = new StyleBuilder();

        $fontStyle = Util::get($spreadsheetStyle, 'font', []);
        if (Util::get($fontStyle, 'bold', false)) {
            $styleBuilder->setFontBold();
        }
        if (Util::get($fontStyle, 'italic', false)) {
            $styleBuilder->setFontItalic();
        }
        if (Util::get($fontStyle, 'underline', false)) {
            $styleBuilder->setFontUnderline();
        }
        if (Util::get($fontStyle, 'strikethrough', false)) {
            $styleBuilder->setFontStrikethrough();
        }
        $fontName = Util::get($fontStyle, 'name', false);
        if ($fontName) {
            $styleBuilder->setFontName($fontName);
        }
        $fontSize = Util::get($fontStyle, 'size', false);
        if ($fontSize) {
            $styleBuilder->setFontSize($fontSize);
        }
        $fontColor = Util::get($fontStyle, 'color', false);
        if ($fontColor) {
            $styleBuilder->setFontColor($fontColor);
        }

        $borderStyle = Util::get($spreadsheetStyle, 'border', []);
        $borderBuilder = new BorderBuilder();
        $style = Util::get($borderStyle, 'style', null);
        $width = Util::get($borderStyle, 'width', $style ? Border::WIDTH_MEDIUM : null);
        $color = Util::get($borderStyle, 'color', $width ? Color::BLACK : null);
        $hasBorder = false;
        if ($color) {
            $hasBorder = true;
            $style = $style ? $style : Border::STYLE_SOLID;
            $width = $width ? $width : Border::WIDTH_MEDIUM;
            $borderBuilder->setBorderTop($color, $width, $style)
                ->setBorderRight($color, $width, $style)
                ->setBorderBottom($color, $width, $style)
                ->setBorderLeft($color, $width, $style);
        }
        foreach (['top', 'right', 'bottom', 'left'] as $dir) {
            $borderStyleDir = Util::get($borderStyle, $dir, []);
            $style = Util::get($borderStyleDir, 'style', null);
            $width = Util::get($borderStyleDir, 'width', $style ? Border::WIDTH_MEDIUM : null);
            $color = Util::get($borderStyleDir, 'color', $width ? Color::BLACK : null);
            if ($color) {
                $hasBorder = true;
                $style = $style ? $style : Border::STYLE_SOLID;
                $width = $width ? $width : Border::WIDTH_MEDIUM;
                $borderBuilder->{"setBorder" . $dir}($color, $width, $style);
            }
        }
        $borderObj = $borderBuilder->build();
        if ($hasBorder) {
            $styleBuilder->setBorder($borderObj);
        }

        $bgColor = Util::get($spreadsheetStyle, 'backgroundColor', null);
        if ($bgColor) {
            $styleBuilder->setBackgroundColor($bgColor);
        }

        $styleBuilder->setShouldWrapText(Util::get($spreadsheetStyle, 'wrapText', false));

        $styleObj = $styleBuilder->build();
        return $styleObj;
    }
}
