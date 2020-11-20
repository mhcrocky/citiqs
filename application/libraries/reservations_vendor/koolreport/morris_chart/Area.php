<?php
/**
 * This file contains Area chart widget
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license
 */
namespace koolreport\morris_chart;
use \koolreport\core\Utility;

class Area extends Morris
{
    protected function prepareOptions()
    {
        $columns = $this->getColumnList();
        
        $xKey = null;
        $yKeys = array();
        $labels = array();
        $preUnits = null;
        $postUnits = null;
        foreach($columns as $cKey=>$cSettings)
        {
            if($xKey==null)
            {
                $xKey = $cKey;
            }
            else
            {
                array_push($yKeys,$cKey);
                array_push($labels,Utility::get($cSettings,"label",$cKey));
                if($preUnits===null && Utility::get($cSettings,"prefix"))
                {
                    $preUnits = Utility::get($cSettings,"prefix");
                }
                if($postUnits===null && Utility::get($cSettings,"suffix"))
                {
                    $postUnits = Utility::get($cSettings,"suffix");
                }                
            }
        }
        $data = array();
        $this->dataStore->popStart();
        while($row = $this->dataStore->pop())
        {
            $gRow = array();
            foreach($columns as $cKey=>$cSettings)
            {
                $type = Utility::get($cSettings,"type","unknown");
                if($type=="number")
                {
                    $decimals = Utility::get($cSettings,"decimals");
                    if($decimals!==null)
                    {
                        $gRow[$cKey] = $this->roundNumber($row[$cKey],$decimals);
                    }
                    else
                    {
                        $gRow[$cKey] = $row[$cKey];    
                    }
                }
                else
                {
                    $gRow[$cKey] = Utility::format($row[$cKey],$cSettings);
                }
            }
            array_push($data,$gRow);
        }

        $options = array(
            "element"=>$this->chartId,
            "data"=>$data,
            "xkey"=>$xKey,
            "ykeys"=>$yKeys,
            "labels"=>$labels,
            "resize"=>true,
            "parseTime" => false
        );
        if($preUnits!==null)
            $options["preUnits"] = $preUnits;
        if($postUnits!==null)
            $options["postUnits"] = $postUnits;
        if($this->colorScheme!==null)
        {
            $options["lineColors"] = $this->colorScheme;
        }
        

        return array_merge($options,$this->options);
    }
}