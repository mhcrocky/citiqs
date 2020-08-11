<?php
/**
 * This file contains Card widget of amazing Theme
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
namespace koolreport\amazing;

use \koolreport\core\Utility;
use \koolreport\chartjs\LineChart;
use \koolreport\chartjs\AreaChart;
use \koolreport\chartjs\ColumnChart;

/**
 * This file contains Card widget of amazing Theme
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class DualChartCard extends ChartCard
{
    protected $secondChartType;
    protected $secondChartColumns;
    protected $secondChartDataStore;

    protected $infoText;

    /**
     * OnInit
     * 
     * @return null
     */
    protected function onInit()
    {
        parent::onInit();

        if(!$this->indicatorMethod)
        {
            $this->indicatorMethod = "percentChange";
        }

        $secondChart = Utility::get($this->params, "secondChart", array());
        $this->secondChartType = Utility::get($secondChart, "type", "column");
        $columns = Utility::get($secondChart, "columns", array());
        $this->secondChartColumns = array();
        foreach ($columns as $cKey=>$cValue) {
            if (gettype($cValue)=="array") {
                $this->secondChartColumns[$cKey] = $cValue;
            } else {
                $this->secondChartColumns[$cValue] = array();
            }
        }
        $chartDataSource = Utility::get($secondChart, "dataSource");
        $this->secondChartDataStore = $this->standardizeDataSource(
            $chartDataSource,
            array()
        );

        $this->infoText = Utility::get($this->params,"infoText");
    }
}