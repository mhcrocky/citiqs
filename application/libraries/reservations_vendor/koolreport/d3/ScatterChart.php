<?php
/**
 * This file is wrapper class for C3JS ScatterChart
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
 * This file is wrapper class for C3JS ScatterChart
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class ScatterChart extends C3Chart
{
    protected $type = "scatter";
    protected $series;

    protected $xAxis;
    protected $yAxis;

    protected function onInit()
    {
        $this->series = Utility::get($this->params, "series", array());
        $this->xAxis = Utility::get($this->params, "xAxis");
        $this->yAxis = Utility::get($this->params, "yAxis");

        $columns = array();
        foreach ($this->series as $seri) {
            if (count($seri)>1) {
                $allkeys = array_keys($seri);
                $keys = array();
                for ($i=0;$i<2;$i++) {
                    if(gettype($seri[$allkeys[$i]])=="array")
                    {
                        $columns[$allkeys[$i]] = $seri[$allkeys[$i]];
                    } else {
                        array_push($columns,$seri[$allkeys[$i]]);
                    }                    
                }
            }
        }
        $this->params["columns"] = $columns;
        parent::onInit();

    }

    /**
     * Build settings
     *
     */
    protected function getSettings()
    {
        $settings = array(
            "data"=>array(),
            "axis"=>array(),
        );
        $cKeys = array();
        $xs = array();
        foreach ($this->series as $seri) {
            if (count($seri)>1) {
                $allkeys = array_keys($seri);
                $keys = array();
                for ($i=0;$i<2;$i++) {
                    array_push($keys, gettype($seri[$allkeys[$i]])=="array"?$allkeys[$i]: $seri[$allkeys[$i]]);
                }
                $xs[$keys[1]] = $keys[0];
                array_push($cKeys,$keys[0]);
                array_push($cKeys,$keys[1]);
            }
        }
        $settings["cKeys"] = $cKeys;

        $settings["data"]["xs"] = $xs;
        
        $settings["data"]["names"] = array();
        foreach ($cKeys as $cKey) {
            $settings["data"]["names"][$cKey] = isset($this->columns[$cKey]["label"])?$this->columns[$cKey]["label"]:$cKey;
        }

        $columns = array();
        foreach ($cKeys as $cKey) {
            $column = array_merge(array($cKey), $this->dataStore->pluck($cKey));
            array_push($columns, $column);
        }
        $settings["data"]["columns"] = $columns;


        if ($this->xAxis!==null) {
            $settings["axis"]["x"] = array();
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
            $settings["axis"]["y"] = array();
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

            if ($label) {
                $settings["axis"]["y"]["label"] = $label;
            }

            $settings["axis"]["y"]["tick"] = array(
                "format" => "function(){return KoolReport.d3.format($decimals,'$decPoint','$thousandSep','$prefix','$suffix');}()"
            );
        }

        
        return Utility::arrayMergeRecursive(parent::getSettings(), $settings);
    }
}
