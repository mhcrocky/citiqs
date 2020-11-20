<?php
/**
 * This file is wrapper class for C3JS GaugeChart
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
 * This file is wrapper class for C3JS GaugeChart
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class GaugeChart extends C3Chart
{
    protected $type = "gauge";
    
    protected $values;
    protected $min;
    protected $max;
    protected $label;
    protected $tooltip;

    

    protected function onInit()
    {
        $this->useAutoName("c3");
        $this->useDataSource();
        $this->values = Utility::get($this->params, "values");
        $this->min = Utility::get($this->params, "min", 0);
        $this->max = Utility::get($this->params, "max", 100);
        $this->label = Utility::get($this->params, "label");
        $this->tooltip = Utility::get($this->params, "tooltip");
        $this->clientEvents = Utility::get($this->params, "clientEvents", array());
    }


    /**
     * Build settings
     *
     */
    protected function getSettings()
    {
        $settings = array(
            "data"=>array(
                "columns"=>array()
            )
        );

        if ($this->dataStore) {
            $columns = $this->processColumns();
            $cKeys = array_keys($columns);
            if (count($cKeys)<2) {
                throw new \Exception("GaugeChart require at least 2 columns");
            }
            foreach ($this->dataStore as $row) {
                array_push($settings["data"]["columns"], array($row[$cKeys[0]],$row[$cKeys[1]]));
            }
            $settings["cKeys"] = array(
                array_shift($cKeys),
                array_shift($cKeys)
            );
        } else {
            foreach ($this->values as $k=>$v) {
                array_push($settings["data"]["columns"], array($k,$v));
            }
            $settings["cKeys"] = array("name","value");
        }
        
        $settings["gauge"] = array(
            "min"=>$this->min,
            "max"=>$this->max,
        );

        if ($this->label) {
            $show = Utility::get($this->label, "show", true);
            $settings["gauge"]["label"] = array(
                "show"=>$show,
            );
            if ($show) {
                $use = Utility::get($this->label, "use", "ratio");
                $decimals = Utility::get($this->label, "decimals", $use==="ratio"?1:0);
                $thousandSep = Utility::get(
                    $this->label,
                    "thousandSep",
                    Utility::get($this->label, "thousandSeparator", ",")
                );
                $decPoint = Utility::get(
                    $this->label,
                    "decPoint",
                    Utility::get($this->label, "decimalPoint", ".")
                );
                $prefix = Utility::get($this->label, "prefix", "");
                $suffix = Utility::get($this->label, "suffix", $use==="ratio"?"%":"");

                $value = ($use==="ratio")?"ratio*100":"value";

                $settings["gauge"]["label"]["format"] = "function(value,ratio){return KoolReport.d3.format($decimals,'$decPoint','$thousandSep','$prefix','$suffix')($value);}";
            }
        }

        if ($this->tooltip) {
            $show = Utility::get($this->tooltip, "show", true);
            $settings["tooltip"] = array(
                "show"=>$show
            );
            if ($show) {
                $use = Utility::get($this->tooltip, "use", "ratio");
                $decimals = Utility::get($this->tooltip, "decimals", $use==="ratio"?1:0);
                $thousandSep = Utility::get(
                    $this->tooltip,
                    "thousandSep",
                    Utility::get($this->tooltip, "thousandSeparator", ",")
                );
                $decPoint = Utility::get(
                    $this->tooltip,
                    "decPoint",
                    Utility::get($this->tooltip, "decimalPoint", ".")
                );
                $prefix = Utility::get($this->tooltip, "prefix", "");
                $suffix = Utility::get($this->tooltip, "suffix", $use==="ratio"?"%":"");
    
                $value = ($use==="ratio")?"ratio*100":"value";
    
                $settings["tooltip"]["format"] = array(
                    "value"=> "function(value,ratio,id,index){return KoolReport.d3.format($decimals,'$decPoint','$thousandSep','$prefix','$suffix')($value);}"
                );
            }
        }


        return Utility::arrayMergeRecursive(parent::getSettings(), $settings);
    }
}
