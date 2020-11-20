<?php
/**
 * This file is wrapper class for C3JS ColumnChart
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */

namespace koolreport\d3;

use \koolreport\core\Utility;

/**
 * This file is wrapper class for C3JS ColumnChart
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class ColumnChart extends C3Chart
{
    protected $type = "bar";

    /**
     * Whether should stacked in column and bar chart
     */
    protected $stacked = false;
    /**
     * Whether show 2 axes
     */
    protected $dualAxis = false;
    
    /**
     * Contains number format settings for y axis
     */
    protected $yAxis;
    /**
     * Contain number format settings for y2 axis
     */
    protected $y2Axis;

    /**
     * Contain number format settings for x axis
     */
    protected $xAxis;

    /**
     * Init chart
     */
    protected function onInit()
    {
        parent::onInit();

        $this->stacked = Utility::get($this->params, "stacked", false);
        $this->dualAxis = Utility::get($this->params, "dualAxis", false);
        $this->yAxis = Utility::get($this->params, "yAxis");
        $this->y2Axis = Utility::get($this->params, "y2Axis");
        $this->xAxis = Utility::get($this->params, "xAxis");
    }

    /**
     * Extra settings for column charts
     *
     * @return array New settings
     */
    protected function getSettings()
    {
        $cKeys = array_keys($this->columns);
        $shortenDataStore = call_user_func_array(
            array($this->dataStore, "only"),
            $cKeys
        );
        $settings = array(
            "data"=>array(),
            "axis"=>array(),
        );

        //Save cKeys
        $settings["cKeys"] = $cKeys;

        // Determine the xColumns
        $xAxisType = null;
        $settings["axis"]["x"] = array();
        switch (Utility::get($this->columns[$cKeys[0]], "type")) {
            case "string":
                $xAxisType = "category";
            break;
            case "date":
                $defaultXFormat = "%Y-%m-%d";
                $xAxisType = "timeseries";
            break;
            case "datetime":
                $defaultXFormat = "%Y-%m-%d %H:%M:%S";
                $xAxisType = "timeseries";
            break;
            case "time":
                $defaultXFormat = "%H:%M:%S";
                $xAxisType = "timeseries";
            break;
        }

        if ($xAxisType) {
            $xKey = array_shift($cKeys);
            $settings["axis"]["x"]["type"] = $xAxisType;
            $settings["data"]["x"] = $xKey;
            $settings["data"]["keys"] = array(
                "x"=>$xKey,
                "value" => $cKeys
            );
            if ($xAxisType=="timeseries") {
                $settings["data"]["xFormat"] = Utility::get($this->columns[$xKey], "xFormat", $defaultXFormat);
                $xDisplayFormat = Utility::get($this->columns[$xKey], "xDisplayFormat");
                if ($xDisplayFormat) {
                    $settings["axis"]["x"]["tick"] = array(
                        "format"=>$xDisplayFormat
                    );
                }
            }
        } else {
            $column0 = $this->columns[$cKeys[0]];
            if (Utility::get($column0, "x")) {
                $settings["data"]["x"] = $cKeys[0];
            }
            $settings["data"]["keys"] = array(
                "value" => $cKeys
            );
        }

        //Default data
        $settings["data"]["json"] = $shortenDataStore->data();

        //Format values
        $cKeys = array_keys($this->columns);
        $settings["fv"] = array();
        foreach ($cKeys as $cKey) {
            $settings["fv"][$cKey] = array();
        }
        foreach ($shortenDataStore as $row) {
            foreach ($cKeys as $cKey) {
                array_push(
                    $settings["fv"][$cKey],
                    $this->formatValue($row[$cKey], $this->columns[$cKey], $row)
                );
            }
        }

        $settings["data"]["names"] = array();
        foreach ($this->columns as $cName => $cSettings) {
            if (isset($cSettings["label"])) {
                $settings["data"]["names"][$cName] = $cSettings["label"];
            }
        }


        if ($this->stacked) {
            if ($this->stacked === true) {
                $settings["data"]["groups"] = array($cKeys);
            } elseif (gettype($this->stacked)=="array") {
                $settings["data"]["groups"] = $this->stacked;
            }
        }




        //Tooltips
        $settings["tooltip"] = array(
            "format"=>array(
                "value"=>"function(value,radio,id,index){return $this->name.settings.fv[id][index];}"
            )
        );

        if ($this->dualAxis) {
            $settings["axis"] = isset($settings["axis"])?$settings["axis"]:array();
            $settings["axis"]["y2"] = array(
                "show"=>true,
            );
            $axes = array();
            foreach ($cKeys as $cKey) {
                $axis = Utility::get($this->columns[$cKey], "axis");
                if ($axis=="y2") {
                    $axes[$cKey] = "y2";
                }
            }
            if ($axes!==array()) {
                $settings["data"]["axes"] = $axes;
            }
        }

        if ($this->xAxis!==null) {
            $label = Utility::get($this->xAxis, "label");
            $decimals = Utility::get($this->xAxis, "decimals", 0);
            $thousandSep = Utility::get(
                $this->xAxis,
                "thousandSep",
                Utility::get($this->xAxis, "thousandSeparator", ",")
            );
            $decPoint = Utility::get(
                $this->xAxis,
                "decPoint",
                Utility::get($this->xAxis, "decimalPoint", ".")
            );
            $prefix = Utility::get($this->xAxis, "prefix", "");
            $suffix = Utility::get($this->xAxis, "suffix", "");
            
            if ($label) {
                $settings["axis"]["x"]["label"] = $label;
            }
            
            $settings["axis"]["x"]["tick"] = array(
                "format" => "function(){return KoolReport.d3.format($decimals,'$decPoint','$thousandSep','$prefix','$suffix');}()"
            );
        }
        
        if ($this->yAxis!==null) {
            $label = Utility::get($this->yAxis, "label");
            $decimals = Utility::get($this->yAxis, "decimals", 0);
            $thousandSep = Utility::get(
                $this->yAxis,
                "thousandSep",
                Utility::get($this->yAxis, "thousandSeparator", ",")
            );
            $decPoint = Utility::get(
                $this->yAxis,
                "decPoint",
                Utility::get($this->yAxis, "decimalPoint", ".")
            );
            $prefix = Utility::get($this->yAxis, "prefix", "");
            $suffix = Utility::get($this->yAxis, "suffix", "");
            $settings["axis"] = isset($settings["axis"]) ? $settings["axis"] : array();
            $settings["axis"]["y"] = isset($settings["axis"]["y"]) ? $settings["axis"]["y"] : array();
            
            if ($label) {
                $settings["axis"]["y"]["label"] = $label;
            }

            $settings["axis"]["y"]["tick"] = array(
                "format"=>"function(){return KoolReport.d3.format($decimals,'$decPoint','$thousandSep','$prefix','$suffix');}()"
            );
        }
        if ($this->y2Axis!==null) {
            $label = Utility::get($this->y2Axis, "label");
            $decimals = Utility::get($this->y2Axis, "decimals", 0);
            $thousandSep = Utility::get(
                $this->y2Axis,
                "thousandSep",
                Utility::get($this->y2Axis, "thousandSeparator", ",")
            );
            $decPoint = Utility::get(
                $this->y2Axis,
                "decPoint",
                Utility::get($this->y2Axis, "decimalPoint", ".")
            );
            $prefix = Utility::get($this->y2Axis, "prefix", "");
            $suffix = Utility::get($this->y2Axis, "suffix", "");
            $settings["axis"] = isset($settings["axis"]) ? $settings["axis"] : array();
            $settings["axis"]["y2"] = isset($settings["axis"]["y2"]) ? $settings["axis"]["y2"] : array();
            if ($label) {
                $settings["axis"]["y2"]["label"] = $label;
            }
            $settings["axis"]["y2"]["tick"] = array(
                "format"=>"function(){return KoolReport.d3.format($decimals,'$decPoint','$thousandSep','$prefix','$suffix');}()"
            );
        }
        return Utility::arrayMergeRecursive(parent::getSettings(), $settings);
    }
}
