<?php

namespace koolreport\yii2;
use Yii;
use \koolreport\core\Utility;

trait Friendship
{
    public function __constructFriendship()
    {
        $webUrl = Yii::$app->getUrlManager()->getBaseUrl();//pointing to web
        $webPath = Yii::getAlias('@webroot');//path to web

        //assets folder
        $assets = Utility::get($this->reportSettings, "assets");
        if ($assets == null) {
            $webPath = str_replace("\\", "/", $webPath);
            if (!is_dir($webPath . "/koolreport_assets")) {
                mkdir($webPath . "/koolreport_assets", 0755);
            }
            $assets = array(
                "url" => $webUrl . "/koolreport_assets",
                "path" => $webPath . "/koolreport_assets",
            );
            $this->reportSettings["assets"] = $assets;
        }

        //datasource

        $dbSources = array(
            "default"=>array(
                "class"=>Yii2DataSource::class
            )
        );
        $dataSources = Utility::get($this->reportSettings, "dataSources", array());
        $this->reportSettings["dataSources"] = array_merge($dbSources, $dataSources);
    }
}