<?php

namespace koolreport\inputs;
use \koolreport\core\Utility;

trait InputSelectData
{
    protected function getBindingData()
    {
        $data = array();
        if($this->dataStore!=null)
        {

            $textColumn = null;
            $valueColumn = null;
            $this->dataBind = Utility::get($this->params,"dataBind",null);
            
            if($this->dataBind==null)
            {
                $this->dataStore->popStart();
                $row = $this->dataStore->pop();
                if($row)
                {
                    $keys = array_keys($row);
                    $textColumn = $keys[0];
                    $valueColumn = $keys[0];
                }    
            }
            else
            {
                if(gettype($this->dataBind)=="string")
                {
                    $textColumn = $this->dataBind;
                    $valueColumn = $this->dataBind;
                }
                else if(gettype($this->dataBind)=="array")
                {
                    $textColumn = Utility::get($this->dataBind,"text",null);
                    $valueColumn = Utility::get($this->dataBind,"value",$textColumn);
                }
            }

            $this->dataStore->popStart();
            while($row = $this->dataStore->pop())
            {
                array_push($data,array(
                    "text"=>$row[$textColumn],
                    "value"=>$row[$valueColumn],
                ));
            }
        }
        return $data;
    }
    protected function parseDirectData($data)
    {
        $result = array();
        foreach($data as $text=>$value)
        {
            if(gettype($text)==="integer")
            {
                array_push($result,array(
                    "text"=>$value,
                    "value"=>$value,
                ));
            }
            else
            {
                array_push($result,array(
                    "text"=>$text,
                    "value"=>$value,
                ));
            }
        }
        return $result;
    }
}