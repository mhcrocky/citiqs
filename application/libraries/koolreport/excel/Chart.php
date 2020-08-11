<?php

namespace koolreport\excel;

use \koolreport\core\Utility as Util;
use \PhpOffice\PhpSpreadsheet as ps;
use \PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use \PhpOffice\PhpSpreadsheet\Chart\Chart as PHPOfficeChart;
use \PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use \PhpOffice\PhpSpreadsheet\Chart\Legend;
use \PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use \PhpOffice\PhpSpreadsheet\Chart\Title;
use \PhpOffice\PhpSpreadsheet\Chart\Layout;
use \PhpOffice\PhpSpreadsheet\Chart\Axis;

class Chart extends Widget
{
    protected $type = "chart";

    public static $mapChartTypes = [
        'AreaChart' => DataSeries::TYPE_AREACHART,
        'AreaChart3D' => DataSeries::TYPE_AREACHART_3D,
        'BarChart' => DataSeries::TYPE_BARCHART,
        'BarChart3D' => DataSeries::TYPE_BARCHART_3D,
        'BubbleChart' => DataSeries::TYPE_BUBBLECHART,
        'CandleChart' => DataSeries::TYPE_CANDLECHART,
        'DonutChart' => DataSeries::TYPE_DONUTCHART,
        'DoughnutChart' => DataSeries::TYPE_DOUGHNUTCHART,
        'LineChart' => DataSeries::TYPE_LINECHART,
        'LineChart3D' => DataSeries::TYPE_LINECHART_3D,
        'PieChart' => DataSeries::TYPE_PIECHART,
        'PieChart3D' => DataSeries::TYPE_PIECHART_3D,
        'RadarChart' => DataSeries::TYPE_RADARCHART,
        'ScatterChart' => DataSeries::TYPE_SCATTERCHART,
        'StockChart' => DataSeries::TYPE_STOCKCHART,
        'SurfaceChart' => DataSeries::TYPE_SURFACECHART,
        'SurfaceChart3D' => DataSeries::TYPE_SURFACECHART_3D,
    ];

    protected function setType()
    {
        $this->params['chartType'] = Util::getClassName($this);
    }

    public static function saveContentToSheet($content, $sheet
        , $chartDataSheet, & $sheetInfo = [])
    {
        list($highestRow, $highestColumn, $range) = 
            self::getSheetRange($sheet, $content);
        $dataSource = Util::get($content, 'dataSource', new \koolreport\core\DataStore());
        if (is_string($dataSource)) {
            $positions = $sheetInfo['tablePositions'][$dataSource];
            $dataSheet = $sheetInfo['tableSheet'][$dataSource];
        } else {
            $chartDataHighestRow = $chartDataSheet->getHighestDataRow() + 1; // e.g. 10
            $option = $content;
            $option['startRow'] = $chartDataHighestRow;
            $positions = Table::saveDataStoreToSheet(
                $dataSource, $chartDataSheet, $option, $sheetInfo);
            $dataSheet = 'chart_data';
        }

        $bottomRight = $positions['bottomRight'];
        $bottomRight = explode(":", $bottomRight);
        $bottomRightCol = $bottomRight[0]; $bottomRightRow = $bottomRight[1]; 
        $topLeft = $positions['topLeft'];
        $topLeft = explode(":", $topLeft);
        $topLeftCol = $topLeft[0]; $topLeftRow = $topLeft[1]; 

        // echo "position = $topLeftCol:$topLeftRow - $bottomRightCol:$bottomRightRow * ";
        // $startCell = 'A' . $chartDataHighestRow;
        // $chartDataSheet->fromArray([
        //     ['test', 2010, 2011, 2012],
        //     ['Q1', 12, 15, 21],
        //     ['Q2', 56, 73, 86],
        //     ['Q3', 52, 61, 69],
        //     ['Q4', 30, 32, 20],
        // ], null, $startCell);
        
        // $dataSeriesLabels = [
        //     new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, ''{$dataSheet}'!$B$1', null, 1), //	2010
        //     new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, ''{$dataSheet}'!$C$1', null, 1), //	2011
        //     new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, ''{$dataSheet}'!$D$1', null, 1), //	2012
        // ];

        // $dataSeriesValues = [
        //     new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, '('{$dataSheet}'!$B$2,Worksheet!$B$5)', null, 4),
        //     new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, ''{$dataSheet}'!$C$2:$C$5', null, 4),
        //     new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, ''{$dataSheet}'!$D$2:$D$5', null, 4),
        // ];

        // $xAxisTickValues = [
        //     new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, ''{$dataSheet}'!$A$2:$A$5', null, 4), //	Q1 to Q4
        // ];

        $dataSeriesLabels = [];
        $dataSeriesValues = [];
        for ($i = $topLeftCol + 1; $i <= $bottomRightCol; $i++) {
            $labelCellPos = "$" . Coordinate::stringFromColumnIndex($i)
                . "$" . $topLeftRow;
            $labelSeriesValue = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'{$dataSheet}'!$labelCellPos", null, 1);
            $dataSeriesLabels[] = $labelSeriesValue;

            $valueCellPos1 = "$" . Coordinate::stringFromColumnIndex($i)
                . "$" . ($topLeftRow + 1);
            $valueCellPos2 = "$" . Coordinate::stringFromColumnIndex($i)
                . "$" . ($bottomRightRow);
            $valueSeriesValue = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, "'{$dataSheet}'!$valueCellPos1:$valueCellPos2", null, 1);
            $dataSeriesValues[] = $valueSeriesValue;
        }
        
        $cellPos1 = "$" . Coordinate::stringFromColumnIndex($topLeftCol)
            . "$" . ($topLeftRow + 1);
        $cellPos2 = "$" . Coordinate::stringFromColumnIndex($topLeftCol)
            . "$" . ($bottomRightRow);
        $xAxisTickValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'{$dataSheet}'!$cellPos1:$cellPos2", null, 4), 
        ];

        //	Build the dataseries
        $chartType = Util::get($content, 'chartType', 'BarChart');
        $stacked = Util::get($content, 'stacked', false);
        $direction = Util::get($content, 'direction', 'vertical');
        $groupableCharts = ['AreaChart', 'AreaChart3D', 'BarChart', 'BarChart3D', 
            'LineChart', 'LineChart3D'];
        $plotGrouping = in_array($chartType, $groupableCharts) ?
            ($stacked ? DataSeries::GROUPING_STACKED : DataSeries::GROUPING_STANDARD) : null;
        $series = new DataSeries(
            self::$mapChartTypes[$chartType], // plotType
            $plotGrouping,
            range(0, count($dataSeriesValues) - 1), // plotOrder
            $dataSeriesLabels, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues,        // plotValues
            $direction === 'horizontal' ? DataSeries::DIRECTION_HORIZONTAL
                : DataSeries::DIRECTION_VERTICAL
        );

        $layout = new Layout();
        $layout->setShowVal(Util::get($content, ['layout', 'showValue']));
        $layout->setShowPercent(Util::get($content, ['layout', 'showPercent']));
        $layout->setShowSerName(Util::get($content, ['layout', 'showSerName']));
        $layout->setShowLeaderLines(Util::get($content, ['layout', 'showLeaderLines']));
        $layout->setShowBubbleSize(Util::get($content, ['layout', 'showBubbleSize']));
        $layout->setShowCatName(Util::get($content, ['layout', 'showCatName']));
        $layout->setShowLegendKey(Util::get($content, ['layout', 'showLegendKey']));
        
        $plotArea = new PlotArea($layout, [$series]);
        $legend = new Legend(Util::get($content, ['legend', 'position'], 'r'), null, false); //'r', 'l', 't', 'b', 'tr'

        $title = new Title(Util::get($content, 'title', ''));
        $xAxisLabel = new Title(Util::get($content, 'xAxisTitle', null));
        $yAxisLabel = new Title(Util::get($content, 'yAxisTitle', null));

        $yaxis = new Axis();
        // $xaxis->setAxisOptionsProperties('low', 0, 'autoZero', null, 'in', 'out', 0, 40, 5, 0);
        $yaxis->setAxisOptionsProperties(
            Util::get($content, ['yAxis', 'axis_labels'], 'nextTo')
            , Util::get($content, ['yAxis', 'horizontal_crosses_value'])
            , Util::get($content, ['yAxis', 'horizontal_crosses'])
            , Util::get($content, ['yAxis', 'axis_orientation'])
            , Util::get($content, ['yAxis', 'major_tmt'])
            , Util::get($content, ['yAxis', 'minor_tmt'])
            , Util::get($content, ['yAxis', 'minimum'])
            , Util::get($content, ['yAxis', 'maximum'])
            , Util::get($content, ['yAxis', 'major_unit'])
            , Util::get($content, ['yAxis', 'minor_unit'])
        );
        $xaxis = new Axis();
        $xaxis->setAxisOptionsProperties(
            Util::get($content, ['xAxis', 'axis_labels'], 'nextTo')
            , Util::get($content, ['xAxis', 'horizontal_crosses_value'])
            , Util::get($content, ['xAxis', 'horizontal_crosses'])
            , Util::get($content, ['xAxis', 'axis_orientation'])
            , Util::get($content, ['xAxis', 'major_tmt'])
            , Util::get($content, ['xAxis', 'minor_tmt'])
            , Util::get($content, ['xAxis', 'minimum'])
            , Util::get($content, ['xAxis', 'maximum'])
            , Util::get($content, ['xAxis', 'major_unit'])
            , Util::get($content, ['xAxis', 'minor_unit'])
        );

        //	Create the chart
        $chartName = Util::get($content, 'name', 'chart_' . $sheetInfo['chartAutoId']++);
        $chart = new PHPOfficeChart(
            $chartName, // name
            $title, // title
            $legend, // legend
            $plotArea, // plotArea
            true, // plotVisibleOnly
            0, // displayBlanksAs
            $xAxisLabel, // xAxisLabel
            $yAxisLabel,  // yAxisLabel
            $yaxis, 
            $xaxis
        );
        $defaultChartWidth = 7;
        $defaultChartHeight = 12;
        if ($range[0] === $range[1]) {
            $pos = Coordinate::coordinateFromString($range[1]);
            $newCol = Coordinate::columnIndexFromString($pos[0]) + $defaultChartWidth;
            $range[1] = Coordinate::stringFromColumnIndex($newCol)
                . ($pos[1] + $defaultChartHeight);
        }
        $chart->setTopLeftPosition($range[0]);
        $chart->setBottomRightPosition($range[1]);

        $sheet->addChart($chart);
    }
}