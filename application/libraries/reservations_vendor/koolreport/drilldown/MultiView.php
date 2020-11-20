<?php

namespace koolreport\drilldown;

use \koolreport\core\Widget;
use \koolreport\core\Utility;

class MultiView extends Widget
{
    protected $title;
    protected $views;
    protected $template;
    protected $viewIndex;
    protected $clientEvents;
    protected $css;//"panel","header","title","body","handler","content"
    protected $cssClass; //"panel","header","title","body","handler","content"

    public function version()
    {
        return "3.0.0";
    }
        
    protected function resourceSettings()
    {

        switch($this->getThemeBase())
        {
            case "bs4":
                return array(
                    "library"=>array("jQuery","font-awesome"),
                    "folder"=>"clients",
                    "js"=>array("MultiView.js"),
                    "css"=>array("MultiView.css")
                );
            case "bs3":
            default:
                return array(
                    "library"=>array("jQuery","font-awesome"),
                    "folder"=>"clients",
                    "js"=>array("MultiView.js"),
                    "css"=>array("MultiView.css"),
                );
        }
    }

    protected function onInit()
    {
        if($this->name==null)
        {
            throw new \Exception("[name] property is required for MultiView widget");
        }
        $this->useDataSource();
        if($this->dataStore==null)
        {
            throw new \Exception("[dataSource] property is required for MultiView widget");
        }
        $this->title = Utility::get($this->params,"title","MultiView");
        $this->template = strtolower(Utility::get($this->params,"template","panel"));
        $this->views = Utility::get($this->params,"views",array());
        $this->viewIndex = Utility::get($this->params,"viewIndex",0);
        $this->clientEvents = Utility::get($this->params,"clientEvents",array());
        $this->css = Utility::get($this->params,"css");
        $this->cssClass = Utility::get($this->params,"cssClass");

        foreach($this->views as $view)
        {
            if(!isset($view["widget"]))
            {
                throw new \Exception("[widget] is required in views of MultiView");
            }
            if(!isset($view["handler"]))
            {
                throw new \Exception("[handler] is required in views of MultiView");
            }            
        }
    }

    protected function getViewWidget($view)
    {
        $widgetClass = $view["widget"][0];
        $widgetParams = $view["widget"][1];
        
        if(strpos($widgetClass,'\widgets\google'))
        {
            $widgetParams["width"] = "100%";
        }
        else if(strpos($widgetClass,'\koolphp\Table'))
        {
            // Be continue after getting table to return the associate array of selected row
        }

        if(!isset($widgetParams["dataSource"]) && !isset($widgetParams["dataStore"]))
        {
            $widgetParams["dataSource"] = $this->dataStore;
        }
        return new $widgetClass($widgetParams);
    }

    protected function onRender()
    {
        $widgets = array();
        $widgetNames = array();
        foreach($this->views as $view)
        {
            $widget = $this->getViewWidget($view);
            array_push($widgetNames,$widget->getName());
            array_push($widgets,$widget);
        }

        $this->template("MultiView.".$this->template,array(
            "settings"=>array(
                "totalViews"=>count($this->views),
                "viewIndex"=>$this->viewIndex,
                "widgetNames"=>$widgetNames,
            ),
            "widgets"=>$widgets,
        ));
    }
}