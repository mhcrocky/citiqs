<?php

namespace koolreport\amazing;
use \koolreport\core\Utility;

class AmazingTheme extends \koolreport\core\Theme
{
    public function themeInfo()
    {
        return array(
            "name"=>"Amazing Theme",
            "version"=>"1.0.0",
            "base"=>"bs4",
            "cssClass"=>"amazing"
        );
    }
    protected function onInit()
    {
        $report = $this->getReport();
        if($report)
        {
            $report->registerEvent("OnResourceInit",function() use ($report){
                $coreFolderUrl = $report->getResourceManager()->publishAssetFolder(realpath(dirname(__FILE__)."/assets/core"));
                $fontawesomeFolderUrl = $report->getResourceManager()->publishAssetFolder(realpath(dirname(__FILE__)."/assets/fontawesome"));
                $simplelineFolderUrl = $report->getResourceManager()->publishAssetFolder(realpath(dirname(__FILE__)."/assets/simpleline"));
                $jqueryAssetUrl = $report->getResourceManager()->publishAssetFolder(realpath(dirname(__FILE__)."/../core/src/clients/jquery"));
                
                $resources = array(
                    "js"=>array(
                        $jqueryAssetUrl."/jquery.min.js",
                        array(
                            $coreFolderUrl."/bootstrap.bundle.min.js"
                        )
                    ),
                    "css"=>array(
                        $coreFolderUrl."/amazing.min.css",
                        $fontawesomeFolderUrl."/css/font-awesome.min.css",
                        $simplelineFolderUrl."/simple-line-icons.min.css",
                    )
                );
                $report->getResourceManager()->addScriptOnBegin("KoolReport.load.resources(".json_encode($resources).");");
            });    
        }
    }
    
    protected function allColorSchemes()
    {
        return array(
            "default"=>array(
                "#F98766",
                "#FF410D",
                "#80BD9D",
                "#87D857",
                "#8FAFC4",
                "#336A86",
                "#293132",
                "#753625",
                "#753625",
                "#753625",
                "#693C3C",
                "#45201A",
                "#4F5060",
                "#67819D",
                "#ADBD37",
                "#588133",
                "#003B45",
                "#06575B",
                "#66A4AC",
                "#66A4AC",
                "#2E4500",
                "#476A00",
                "#A2C423",
                "#7D4426",
            ),
            "more"=>array(
                "#011B1D",
                "#004445",
                "#2B7873",
                "#6FB98F",
                "#375D96",
                "#FA6541",
                "#FFBA00",
                "#3F671B",
                "#324750",
                "#86AB40",
                "#33665C",
                "#7DA2A1",
                "#4BB4F5",
                "#B6B8B5",
                "#203F49",
                "#B3C100",
                "#F3CC6F",
                "#DE7921",
                "#20948B",
                "#6AB086",
                "#8C230E",
                "#1D424B",
                "#9A4E0E",
                "#C89D0F",
            )
        );
    }

    protected function themeWidgets()
    {
        return array(
            'koolreport\inputs\Select2'=>array(
                'folder'=>'assets/inputs/select2',
                'js'=>array(),
                'css'=>array('select2.min.css'),
                'replacingJs'=>array(),
                'replacingCss'=>array(),
            ),
            'koolreport\drilldown\DrillDown'=>array(
                'folder'=>'assets/drilldown',
                'css'=>array('additional.css'),
            ),
            'koolreport\drilldown\LegacyDrillDown'=>array(
                'folder'=>'assets/drilldown',
                'css'=>array('additional.css'),
            ),
            'koolreport\drilldown\CustomDrillDown'=>array(
                'folder'=>'assets/drilldown',
                'css'=>array('additional.css'),
            ),
        );
    }
}