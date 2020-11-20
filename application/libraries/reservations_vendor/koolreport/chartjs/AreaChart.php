<?php

namespace koolreport\chartjs;
use \koolreport\core\Utility;

class AreaChart extends Chart
{
    protected $type = "line";
    protected function processData()
    {

        $labels = array();
        $datasets = array();

        $columns = $this->getColumns();
        $columnKeys = array_keys($columns);
        for($i=1;$i<count($columnKeys);$i++)
        {
            $cSettings = Utility::get($columns,$columnKeys[$i]);
            $dataset = array(
                "label"=> Utility::get($cSettings,"label",$columnKeys[$i]),
                "borderColor"=>$this->getColor($i-1),
                "backgroundColor"=>$this->getRgba($this->getColor($i-1),$this->backgroundOpacity),
                "data"=>array(),
                "fdata"=>array(),
            );
            $config = Utility::get($cSettings,"config");
            if($config!==null)
            {
                $dataset = array_merge($dataset,$config);
            }           
            array_push($datasets,$dataset);
        }

        $this->dataStore->popStart();
        while($row = $this->dataStore->pop())
        {
            array_push($labels,$row[$columnKeys[0]]);
            for($i=1;$i<count($columnKeys);$i++)
            {
                array_push($datasets[$i-1]["data"],$row[$columnKeys[$i]]);
                array_push($datasets[$i-1]["fdata"],Utility::format($row[$columnKeys[$i]],$columns[$columnKeys[$i]]));   
            }
        }
        $data = array(
            "labels"=>$labels,
            "datasets"=>$datasets,
        );
        return $data;
    }
}