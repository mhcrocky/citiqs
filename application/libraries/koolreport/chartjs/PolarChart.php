<?php 

namespace koolreport\chartjs;
use \koolreport\core\Utility;

class PolarChart extends Chart
{
    protected $type = "polar";
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

        $this->dataStore->popStart();
        while($row = $this->dataStore->pop())
        {
            $popIndex = $this->dataStore->getPopIndex();
            array_push($labels,$row[$columnKeys[0]]);
            for($i=1;$i<count($columnKeys);$i++)
            {
                array_push($datasets[$i-1]["data"],$row[$columnKeys[$i]]);
                array_push($datasets[$i-1]["fdata"],$this->formatValue($row[$columnKeys[$i]],$columns[$columnKeys[$i]],$row));
                array_push($datasets[$i-1]["backgroundColor"],$this->getRgba($this->getColor($popIndex),$this->backgroundOpacity));
            }
        }
        $data["labels"] = $labels;
        $data["datasets"] = $datasets;
        return $data;
    }    
}