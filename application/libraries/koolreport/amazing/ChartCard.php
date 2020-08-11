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
class ChartCard extends IndicatorCard
{
    protected $chartType;
    protected $chartColumns;
    protected $chartDataStore;
    /**
     * OnInit
     * 
     * @return null
     */
    protected function onInit()
    {
        parent::onInit();
        $chart = Utility::get($this->params, "chart", array());
        $this->chartType = Utility::get($chart, "type", "area");
        $columns = Utility::get($chart, "columns", array());
        $this->chartColumns = array();
        foreach ($columns as $cKey=>$cValue) {
            if (gettype($cValue)=="array") {
                $this->chartColumns[$cKey] = $cValue;
            } else {
                $this->chartColumns[$cValue] = array();
            }
        }
        $chartDataSource = Utility::get($chart, "dataSource");
        $this->chartDataStore = $this->standardizeDataSource(
            $chartDataSource,
            array()
        );
    }
    
    /**
     * Draw chart
     * 
     * @return string Chart Html
     */
    protected function drawChart($type,$dataStore,$columns,$height,$color,$backgroundColor="transparent")
    {
        if ($columns==array()) {
            $firstRow = $dataStore->get(0);
            $keys = array_keys($firstRow);
            if (count($keys)>1) {
                $columns = array(
                    $keys[0]=>array(),
                    $keys[1]=>array(),
                );
            }
        }

        $keys = array_keys($columns);
        
        if (count($keys)<2) {
            return null;
        }
        
        if (!isset($columns[$keys[1]]["config"])) {
            $columns[$keys[1]]["config"] = array();
        }
        switch($type)
        {
        case "line":
            $columns[$keys[1]]["config"]["backgroundColor"] = $this->getPresetBackgroundColor();
            return LineChart::html(array(
                "dataSource"=>$dataStore,
                "columns"=>$columns,
                "colorScheme"=>array($color),
                "height"=>$height,
                "options"=>array(
                    "maintainAspectRatio"=>false,
                    "legend"=>array(
                        "display"=>false,
                    ),
                    "scales"=>array(
                        "xAxes"=>array(
                            array(
                                "gridLines"=>array(
                                    "color"=>"transparent",
                                    "zeroLineColor"=>"transparent"
                                ),
                                "ticks"=>array(
                                    "fontSize"=>2,
                                    "fontColor"=>"transparent"
                                )
                            )
                        ),
                        "yAxes"=>array(
                            array(
                                "display"=>false,
                                "ticks"=>array(
                                    "display"=>false,
                                    "min"=>min($dataStore->pluck($keys[1]))-5,
                                    "max"=>max($dataStore->pluck($keys[1]))+5,
                                )
                            )
                        )
                    ),
                    "elements"=>array(
                        "line"=>array(
                            "borderWidth"=>1,
                        ),
                        "point"=>array(
                            "radius"=>2,
                            "hitRadius"=>4,
                            "hoverRadius"=>2,
                        )
                    )
                )
            ));
            break;
        case "area":
            $columns[$keys[1]]["config"]["backgroundColor"] = $backgroundColor;
            $columns[$keys[1]]["config"]["borderColor"] = $color;

            return AreaChart::html(array(
                "dataSource"=>$dataStore,
                "columns"=>$columns,
                "colorScheme"=>array($color),
                "height"=>$height,
                "options"=>array(
                    "maintainAspectRatio"=>false,
                    "legend"=>array(
                        "display"=>false,
                    ),
                    "scales"=>array(
                        "xAxes"=>array(
                            array(
                                "display"=>false,
                            )
                        ),
                        "yAxes"=>array(
                            array(
                                "display"=>false,
                            )
                        )
                    ),
                    "elements"=>array(
                        "line"=>array(
                            "borderWidth"=>2,
                        ),
                        "point"=>array(
                            "radius"=>0,
                            "hitRadius"=>10,
                            "hoverRadius"=>4,
                        )
                    )
                )
            ));
            break;
        case "column":
            $columns[$keys[1]]["config"]["backgroundColor"] = $color;
            $columns[$keys[1]]["config"]["borderColor"] = "transparent";
            return ColumnChart::html(array(
                "dataSource"=>$dataStore,
                "columns"=>$columns,
                "colorScheme"=>array($color),
                "height"=>$height,
                "options"=>array(
                    "maintainAspectRatio"=>false,
                    "legend"=>array(
                        "display"=>false,
                    ),
                    "scales"=>array(
                        "xAxes"=>array(
                            array(
                                "display"=>false,
                                "barPercentage"=> 0.7
                            )
                        ),
                        "yAxes"=>array(
                            array(
                                "display"=>false,
                            )
                        )
                    ),
                )
            ));
            break;
        }
        return null;
    }

}