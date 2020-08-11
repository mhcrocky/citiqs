<?php

namespace koolreport\chartjs;
use \koolreport\core\Utility;

class PieChart extends Chart
{
    protected $type="pie";
    protected $showPercent = true;

    protected function onInit()
    {
        parent::onInit();
        $this->showPercent = Utility::get($this->params,"showPercent",true);
        $this->backgroundOpacity = Utility::get($this->params,"backgroundOpacity",0);
    }

    protected function processData()
    {
        $data = array();
        $columns = $this->getColumns();
        $columnKeys = array_keys($columns);
        
        $labels = array();
        $datasets = array();


        for($i=1;$i<count($columnKeys);$i++)
        {
            $cSettings = Utility::get($columns,$columnKeys[$i]);
            $dataset = array(
                "label"=> Utility::get($cSettings,"label",$columnKeys[$i]),
                "backgroundColor"=>array(),
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

        //Calculate sum
        $sum = array();
        for($i=1;$i<count($columnKeys);$i++)
        {
            $sum[$columnKeys[$i]] = $this->dataStore->sum($columnKeys[$i]);
        }
        $this->dataStore->popStart();
        while($row = $this->dataStore->pop())
        {
            $popIndex = $this->dataStore->getPopIndex();
            array_push($labels,$row[$columnKeys[0]]);
            for($i=1;$i<count($columnKeys);$i++)
            {
                $percent = number_format($row[$columnKeys[$i]]*100/$sum[$columnKeys[$i]],2);
                array_push($datasets[$i-1]["data"],$row[$columnKeys[$i]]);
                array_push($datasets[$i-1]["fdata"],$this->formatValue($row[$columnKeys[$i]],$columns[$columnKeys[$i]],$row).($this->showPercent?" ($percent%)":""));
                array_push($datasets[$i-1]["backgroundColor"],$this->getRgba($this->getColor($popIndex),$this->backgroundOpacity));
            }
        }
        $data["labels"] = $labels;
        $data["datasets"] = $datasets;
        return $data;
    }
}