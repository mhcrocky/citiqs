<?php
/**
 * This file contains Morris chart widget
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license
 */
namespace koolreport\morris_chart;
use \koolreport\core\Utility;

class Morris extends \koolreport\core\Widget
{
    protected $chartId;
    protected $type;
    protected $options;
    protected $width;
    protected $height;
    protected $title;
    protected $colorScheme;

    public function version()
    {
        return "2.0.0";
    }
    protected function resourceSettings()
    {
        return array(
            "library"=>array("raphael"),
            "folder"=>"assets",
            "js"=>array(
                "morris.min.js",
            ),
            "css"=>array(
                "morris.css",
            )
        );        
    }

    protected function onInit()
    {

        $this->useDataSource();
        $this->chartId = "morris_".Utility::getUniqueId();
        $this->columns = Utility::get($this->params,"columns",null);
        $this->options = Utility::get($this->params,"options",array());
        $this->width = Utility::get($this->params,"width","100%");
        $this->height = Utility::get($this->params,"height","400px");
        $this->title = Utility::get($this->params,"title");
        $this->type = Utility::getClassName($this);

        if(!$this->dataStore)
        {
            //Backward compatible with setting through "data"
			$data = Utility::get($this->params,"data");
			if(is_array($data))
			{
				if(count($data)>0)
				{
					$this->dataStore = new DataStore;
					$this->dataStore->data($data);
					$row = $data[0];
					$meta = array("columns"=>array());
					foreach($row as $cKey=>$cValue)
					{
						$meta["columns"][$cKey] = array(
							"type"=>Utility::guessType($cValue),
						);
					}
					$this->dataStore->meta($meta);	
				}
				else
				{
					$this->dataStore = new DataStore;
					$this->dataStore->data(array());
					$this->dataStore->meta(array("columns"=>array()));
				}	
			}
			if($this->dataStore==null)
			{
				throw new \Exception("[dataSource] is required");
				return;
			}
        }



        //Color Scheme
        $this->colorScheme = Utility::get($this->params,"colorScheme");
        if(!is_array($this->colorScheme))
        {
            $theme = $this->getReport()->getTheme(); 
            if($theme)
            {
                $theme->applyColorScheme($this->colorScheme);
            }
        }
        if(!is_array($this->colorScheme))
        {
            $this->colorScheme = null;
        }



        
        if($this->type=="Morris")
        {
            Utility::get($this->params,"type");
        }
    }

    protected function getColumnList()
    {
        $meta = $this->dataStore->meta();
        $columns=array();
        if($this->columns!=null)
        {
            foreach($this->columns as $cKey=>$cValue)
            {
                if(gettype($cValue)=="array")
                {
                    $columns[$cKey] = array_merge($meta["columns"][$cKey],$cValue);
                }
                else
                {
                    $columns[$cValue] = $meta["columns"][$cValue];
                }
            }
        }
        else
        {
            $this->dataStore->popStart();
            $row = $this->dataStore->pop();
            $keys = array_keys($row);
            foreach($keys as $ckey)
            {
                $columns[$ckey] = $meta["columns"][$ckey];
            }
        }
        return $columns;
    }

    protected function encode($json)
    {
        $str = json_encode($json);

        foreach($json as $key=>$value)
        {
            if(gettype($value)==="string" && strpos($value,"function")===0)
            {
                $str = str_replace("\"$key\":\"$value\"","\"$key\":$value",$str);
            }
        }
        return $str;
    }

    protected function roundNumber($value,$decimals)
    {
       return round($value*pow(10,$decimals))/pow(10,$decimals);
    }


    protected function prepareOptions()
    {
        return $this->options;
    }

    protected function onRender()
    {
        $this->template('Morris',array(
            "options"=>$this->prepareOptions(),
        ));
    }
}