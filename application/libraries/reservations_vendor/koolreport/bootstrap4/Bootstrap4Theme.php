<?php

namespace koolreport\bootstrap4;

class Bootstrap4Theme extends \koolreport\core\Theme
{
    public function themeInfo()
    {
        return array(
            "name"=>"Bootstrap 4 Theme",
            "version"=>"4.1.13",
            "base"=>"bs4",
            "cssClass"=>"bs4"
        );
    }
    protected function onInit()
    {
        $report = $this->getReport();
        if($report)
        {
            $report->registerEvent("OnResourceInit",function() use ($report){
                $coreFolderUrl = $report->getResourceManager()->publishAssetFolder(realpath(dirname(__FILE__)."/assets/core"));                
                $jqueryAssetUrl = $report->getResourceManager()->publishAssetFolder(realpath(dirname(__FILE__)."/../core/src/clients/jquery"));
                $resources = array(
                    "js"=>array(
                        $jqueryAssetUrl."/jquery.min.js",
                        array(
                            $coreFolderUrl."/js/bootstrap.bundle.min.js"
                        )
                    ),
                    "css"=>array(
                        $coreFolderUrl."/css/bootstrap.min.css",
                    )
                );
                $report->getResourceManager()->addScriptOnBegin("KoolReport.load.resources(".json_encode($resources).");");
            });    
        }
    }
}