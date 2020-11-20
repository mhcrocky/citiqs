<?php

namespace koolreport\chartjs;
use \koolreport\core\Utility;

class BarChart extends Chart
{
    protected $type="horizontalBar";
    protected $stacked = false;

    protected function onInit()
    {
        parent::onInit();
        $this->stacked = Utility::get($this->params,"stacked",false);
    }

    protected function processOptions()
    {
        $options = $this->options;

        if($this->stacked)
        {
            $options["scales"] = Utility::get($options,"scales",array());
            $options["scales"]["yAxes"] = Utility::get($options["scales"],"yAxes",array(array()));
            foreach($options["scales"]["yAxes"] as &$axis)
            {
                $axis["stacked"] = true;
            }
            $options["scales"]["xAxes"] = Utility::get($options["scales"],"xAxes",array(array()));
            foreach($options["scales"]["xAxes"] as &$axis)
            {
                $axis["stacked"] = true;
            }
        }
        return $options;
    }

    protected function processData()
    {
        
        $columns = $this->getColumns();
        $columnKeys = array_keys($columns);
        
        $labels = array();
        $datasets = array();
        for($i=1;$i<count($columnKeys);$i++)
        {
            $cSettings = Utility::get($columns,$columnKeys[$i]);
            $dataset = array(
                "label"=> Utility::get($cSettings,"label",$columnKeys[$i]),
                "borderWidth"=>1,
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
                array_push($datasets[$i-1]["fdata"],$this->formatValue($row[$columnKeys[$i]],$columns[$columnKeys[$i]],$row));   
            }
        }
        $data = array();
        $data["labels"] = $labels;
        $data["datasets"] = $datasets;
        return $data;
    }
}