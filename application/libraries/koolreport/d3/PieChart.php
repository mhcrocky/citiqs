<?php
/**
 * This file is wrapper class for C3JS PieChart
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
 * This file is wrapper class for C3JS PieChart
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class PieChart extends C3Chart
{
    protected $type = "pie";
    protected $label;
    protected $tooltip;

    /**
     * Init chart
     */
    protected function onInit()
    {
        parent::onInit();

        $this->label = Utility::get($this->params, "label");
        $this->tooltip = Utility::get($this->params,"tooltip");
    }

    /**
     * Extra settings for column charts
     *
     */
    protected function getSettings()
    {

        $settings = array();
        $cKeys = array_keys($this->columns);

        $dataColumns = array();
        foreach ($this->dataStore as $row) {
            $dataCol = array();
            foreach ($cKeys as $i => $key) {
                array_push($dataCol, $row[$key]);
            }
            array_push($dataColumns, $dataCol);
        }
        $settings["data"] = array(
            "columns" => $dataColumns
        );

        $settings["cKeys"] = $cKeys;

        //Label
        if($this->label)
        {
            $show = Utility::get($this->label,"show",true);
            $settings["pie"] = array(
                "label"=>array(
                    "show"=>$show,
                )
            );
            if($show)
            {
                $use = Utility::get($this->label,"use","ratio");
                $decimals = Utility::get($this->label,"decimals",$use==="ratio"?1:0);
                $thousandSep = Utility::get($this->label,"thousandSep",
                                    Utility::get($this->label,"thousandSeparator",","));
                $decPoint = Utility::get($this->label,"decPoint",
                                    Utility::get($this->label,"decimalPoint","."));    
                $prefix = Utility::get($this->label,"prefix","");
                $suffix = Utility::get($this->label,"suffix",$use==="ratio"?"%":"");

                $value = ($use==="ratio")?"ratio*100":"value";

                $settings["pie"]["label"]["format"] = "function(value,ratio,id){return KoolReport.d3.format($decimals,'$decPoint','$thousandSep','$prefix','$suffix')($value);}";
            }
        }

        //Tooltips
        if($this->tooltip)
        {
            $show = Utility::get($this->tooltip,"show",true);
            $settings["tooltip"] = array(
                "show"=>$show
            );
            if($show)
            {
                $use = Utility::get($this->tooltip,"use","ratio");
                $decimals = Utility::get($this->tooltip,"decimals",$use==="ratio"?1:0);
                $thousandSep = Utility::get($this->tooltip,"thousandSep",
                                    Utility::get($this->tooltip,"thousandSeparator",","));
                $decPoint = Utility::get($this->tooltip,"decPoint",
                                    Utility::get($this->tooltip,"decimalPoint","."));    
                $prefix = Utility::get($this->tooltip,"prefix","");
                $suffix = Utility::get($this->tooltip,"suffix",$use==="ratio"?"%":"");
    
                $value = ($use==="ratio")?"ratio*100":"value";
    
                $settings["tooltip"]["format"] = array(
                    "value"=> "function(value,ratio,id,index){return KoolReport.d3.format($decimals,'$decPoint','$thousandSep','$prefix','$suffix')($value);}"
                );    
            } 
        }


        return Utility::arrayMergeRecursive(parent::getSettings(), $settings);
    }

}
