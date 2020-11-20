<?php

namespace koolreport\chartjs;
use \koolreport\core\Utility;

class ScatterChart extends Chart
{
    protected $type="scatter";
    protected $series;

    protected function onInit()
    {
        parent::onInit();
        $this->series = Utility::get($this->params,"series",array());
    }


    protected function processData()
    {
        $datasets = array();
        foreach($this->series as $i=>$series)
        {
            $columnKeys = array();
            $dataset = array(
                "label"=>"Series $i",
                "borderColor"=>$this->getColor($i),
                "backgroundColor"=>$this->getRgba($this->getColor($i),$this->backgroundOpacity),
            );
            foreach($series as $item)
            {
                
                if(gettype($item)=="string")
                {
                    array_push($columnKeys,$item);
                }
                elseif(gettype($item)=="array")
                {
                    $dataset = array_merge($dataset,$item);
                }
            }
            $dataset["data"] = array();
            $this->dataStore->popStart();
            while($row = $this->dataStore->pop())
            {
                array_push($dataset["data"],array(
                    "x"=>$row[$columnKeys[0]],
                    "y"=>$row[$columnKeys[1]],
                ));
            }
            array_push($datasets,$dataset);
        }
        return array(
            "datasets"=>$datasets,
        );
    }
}