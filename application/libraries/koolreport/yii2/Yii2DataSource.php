<?php

namespace koolreport\yii2;

use \koolreport\datasources\PdoDataSource;
use \koolreport\core\Utility;
use Yii;

class Yii2DataSource extends PdoDataSource
{
    protected function onInit()
    {
        if(!Yii::$app->db->pdo)
        {
            Yii::$app->db->open();
        }
        $this->connection = Yii::$app->db->pdo;
    }
}