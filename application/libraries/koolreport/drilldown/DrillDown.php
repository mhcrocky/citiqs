<?php

namespace koolreport\drilldown;

use \koolreport\core\Widget;
use \koolreport\core\Utility;

class DrillDown extends Widget
{
    protected $name;
    protected $levels;
    protected $title;
    protected $scope;
    protected $partialRender = false;

    protected $btnBack;
    protected $showLevelTitle;
    protected $css; //{"panel","header","title","btnBack","levelTitle","body"}
    protected $cssClass;//{"panel","header","title","btnBack","levelTitle","body"}
    protected $clientEvents;
    protected $currentLevel;

    public function version()
    {
        return "3.1.0";
    }
    protected function resourceSettings()
    {
        switch($this->getThemeBase())
        {
            case "bs4":
                return array(
                    "library"=>array("jQuery"),
                    "folder"=>"clients",
                    "js"=>array("DrillDown.js"),
                    "css"=>array("DrillDown.css"),
                );
            case "bs3":
            default:
                return array(
                    "library"=>array("jQuery"),
                    "folder"=>"clients",
                    "css"=>array("DrillDown.css"),
                    "js"=>array("DrillDown.js")
                );
        }
    }

    protected function onInit()
    {
        $this->name = Utility::get($this->params,"name");
        if(!$this->name)
        {
            throw new \Exception("[name] property is required in EasyDrillDown");
        }
        $this->levels = Utility::get($this->params,"levels",array());
        if($this->levels==array())
        {
            throw new \Exception("Please define [level] for DrillDown");
        }
        
        $this->currentLevel = Utility::get($this->params,"currentLevel",array(0,array()));
        
        $this->title = Utility::get($this->params,"title","DrillDown");
        $scope = Utility::get($this->params,"scope",array());
        $this->scope = is_callable($scope)?$scope():$scope;
        $this->partialRender = Utility::get($this->params,"partialRender",false);

        $this->POSTParamsBinding();

        $this->clientEvents = Utility::get($this->params,"clientEvents",array());
        $this->btnBack = Utility::get($this->params,"btnBack",true);
        $this->css = Utility::get($this->params,"css");
        $this->cssClass = Utility::get($this->params,"cssClass");
        $this->showLevelTitle = Utility::get($this->params,"showLevelTitle",true);
    }

    protected function POSTParamsBinding()
    {
        $post = Utility::get($_POST,$this->name);
        if($post)
        {

            $this->currentLevel = Utility::get($post,"currentLevel",array(0,array()));
            $this->partialRender = Utility::get($post,"partialRender",false);
            $this->scope = Utility::get($post,"scope",$this->scope);
        }
    }

    protected function fillClientEvents($widgetClass,&$widgetParams)
    {
        $widgetParams["clientEvents"] = Utility::get($widgetParams,"clientEvents",array());
        if(strpos($widgetClass,'\widgets\google')!==false)
        {
            if(!isset($widgetParams["clientEvents"]["itemSelect"]))
            {
                $widgetParams["clientEvents"]["itemSelect"] = "function(params){
                    $this->name.next(params.selectedRow);
                }";    
            }            
            $widgetParams["width"] = Utility::get($widgetParams,"width","100%");
        }
        else if(strpos($widgetClass,'\koolphp\Table')!==false)
        {
            if(!isset($widgetParams["clientEvents"]["rowClick"]))
            {
                $widgetParams["clientEvents"]["rowClick"] = "function(params){
                    $this->name.next(params.rowData);
                }";    
            }
        }
        else if(strpos($widgetClass,'koolreport\chartjs')!==false)
        {
            if(!isset($widgetParams["clientEvents"]["itemSelect"]))
            {
                $widgetParams["clientEvents"]["itemSelect"] = "function(params){
                    $this->name.next(params.selectedRow);
                }";
            }
            if(!isset($widgetParams["title"]))
            {
                $widgetParams["options"] = Utility::get($widgetParams,"options",array());
                $widgetParams["options"]["title"] = Utility::get($widgetParams,"title",array(
                    "display"=>false,
                    "text"=>"No title",
                ));
            }
            $widgetParams["width"] = Utility::get($widgetParams,"width","100%");
        }
        else if(strpos($widgetClass,'koolreport\d3')!==false)
        {
            if(!isset($widgetParams["clientEvents"]["itemSelect"]))
            {
                $widgetParams["clientEvents"]["itemSelect"] = "function(params){
                    $this->name.next(params.selectedRow);
                }";
            }
        }
    }

    protected function renderCurrentLevel()
    {
        $levelIndex = Utility::get($this->currentLevel,0,0);
        $levelParams = Utility::get($this->currentLevel,1,array());
        $title = $this->levels[$levelIndex]["title"];
        if(!is_string($title) && is_callable($title))
        {
            $title = $title($levelParams,$this->scope);
        }
        echo "<level-title>$title</level-title>";
        $widgetModel = Utility::get($this->levels[$levelIndex],"widget");
        if($widgetModel)
        {
            $widgetClass = Utility::get($widgetModel,0);
            $widgetParams = Utility::get($widgetModel,1);
            if($widgetClass && $widgetParams)
            {
                $dataSource = Utility::get($widgetParams,"dataSource");
                if($dataSource && is_callable($dataSource))
                {
                    $widgetParams["dataSource"] = $dataSource($levelParams,$this->scope);
                    if($levelIndex<count($this->levels)-1)
                    {
                        $this->fillClientEvents($widgetClass,$widgetParams);
                    }
                    $widgetClass::create($widgetParams);
                }
                else
                {
                    throw new \Exception("Datasource of widget must be in functions to receive params and scope"); 
                }
            }
            else
            {
                throw new \Exception("Please define widget name and params");
            }
        }
        else
        {
            $content = Utility::get($this->levels[$levelIndex],"content");
            if(is_callable($content))
            {
                $this->levels[$levelIndex]["content"]($levelParams,$this->scope);
            }
            else
            {
                throw new \Exception("The [content] or [widget] property is missing or not a function");
            }    
        }
    }

    protected function onRender()
    {
        if($this->partialRender) {
            echo "<drilldown-partial>";
            $this->renderCurrentLevel();
            echo "</drilldown-partial>";
        }
        else
        {
            $this->template(array(
                "levelIndex"=>0,
                "options"=>array(
                    "totalLevels"=>count($this->levels),
                    "levelIndex"=>Utility::get($this->currentLevel,0,0),
                    "currentLevel"=>$this->currentLevel,
                    "scope"=>$this->scope,
                ),
            ));    
        }
    }
}