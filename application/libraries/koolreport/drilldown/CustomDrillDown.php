<?php

namespace koolreport\drilldown;
use \koolreport\core\Widget;
use \koolreport\core\Utility;

class CustomDrillDown extends Widget
{
    protected $name;
    protected $subReports;
    protected $css;
    protected $cssClass;
    protected $scope;
    protected $btnBack;
    protected $showLevelTitle;
    protected $title;
    protected $clientEvents;
    
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
                    "js"=>array("CustomDrillDown.js"),
                    "css"=>array("CustomDrillDown.css"),
                );
            case "bs3":
            default:
                return array(
                    "library"=>array("jQuery"),
                    "folder"=>"clients",
                    "js"=>array("CustomDrillDown.js"),
                    "css"=>array("CustomDrillDown.css"),
                );
        }
    }

    protected function onInit()
    {
        $this->useAutoName("drilldown");

        $this->subReports = Utility::get($this->params,"subReports",array());
        if(!$this->subReports)
        {
            throw new \Exception("You need to define list of subReports in $this->name DrillDown widget");
        }
        $scope = Utility::get($this->params,"scope",array());
        //Accept function for scope
        $this->scope = is_callable($scope)?$scope():$scope;

        $this->btnBack = Utility::get($this->params,"btnBack",true);
        $this->title = Utility::get($this->params,"title","Drill-down report");
        $this->showLevelTitle = Utility::get($this->params,"showLevelTitle",true);
        $this->css = Utility::get($this->params,"css");
        $this->cssClass = Utility::get($this->params,"cssClass");
        $this->clientEvents = Utility::get($this->params,"clientEvents",array());
    }


    protected function onRender()
    {
        $options = array(
            "subReports"=>$this->subReports,
            "scope"=>$this->scope,
        );
        $this->template(array(
            "options"=>$options,
        ));
    }
}