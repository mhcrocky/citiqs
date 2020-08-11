<?php
/**
 * This file contains Donut chart widget
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license
 */
namespace koolreport\morris_chart;
use \koolreport\core\Utility;

class Donut extends Morris
{
	protected $showPercentage = false;
	protected $decimals = 0;

	protected function onInit()
	{
		parent::onInit();
		$this->showPercentage = Utility::get($this->params,"showPercentage",false);
		$this->decimals = Utility::get($this->params,"decimals");
	}

    protected function prepareOptions()
    {
		$columns = $this->getColumnList();
		
		$labelKey = null;
		$valueKey = null;

		foreach($columns as $cKey=>$cSettings)
		{
			if($labelKey===null)
			{
				$labelKey = $cKey;
			}
			else if($valueKey===null)
			{
				$valueKey = $cKey;
			}
			else
			{
				break;
			}
		}
        $data = array();
        $total = 0;
		$this->dataStore->popStart();
        while($row = $this->dataStore->pop())
		{
			$gRow = array(
				"label"=>Utility::format($row[$labelKey],$columns[$labelKey]),
				"value"=>$row[$valueKey]
			);
			$total+=$row[$valueKey];
			array_push($data,$gRow);
		}
		if($this->showPercentage)
		{
			
			for($i=0;$i<count($data);$i++)
			{
				$value = $data[$i]["value"]*100/$total;
				$data[$i]["value"] = $this->roundNumber($value,($this->decimals!==null)?$this->decimals:0);
			}
		}
		else
		{
			$decimals = Utility::get($columns[$valueKey],"decimals");
			if($decimals===null)
			{
				$decimals = $this->decimals;
			}
			if($decimals!==null)
			{
				for($i=0;$i<count($data);$i++)
				{
					$data[$i]["value"] = $this->roundNumber($data[$i]["value"],$decimals);
				}			
			}
		}

		$options = array(
			"resize"=>true,
			"element"=>$this->chartId,
			"data"=>$data,
		);

		if($this->colorScheme)
		{
			$options["colors"] = $this->colorScheme;
		}
		

		if($this->showPercentage)
		{
			$options["formatter"]="function(y,data){return y+'%'}";
		}
		else
		{
			$prefix = Utility::get($columns[$valueKey],"prefix","");
			$suffix = Utility::get($columns[$valueKey],"suffix","");
			$options["formatter"]="function(y,data){return '$prefix'+y+'$suffix'}";
		}
		return array_merge($options,$this->options);
    } 
}