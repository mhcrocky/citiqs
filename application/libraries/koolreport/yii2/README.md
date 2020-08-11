# Introduction

`koolreport/yii2` package helps to ease the KoolReport report created within Yii2 environment. It can help to automatically configure `assets` path and url. Furthermore, it provide `default` datasource configured with Yii2 database connection.

# Installation

## By downloading .zip file

1. [Download](https://www.koolreport.com/packages/yii2)
2. Unzip the zip file
3. Copy the folder `yii2` into `koolreport` folder so that look like below

```bash
koolreport
├── core
├── yii2
```

## By composer

```
composer require koolreport/yii2
```

# Documentation

## Step-by-step tutorial

#### Step 1: Create report and claim friendship with Laravel

1. First, you create folder `reports` inside root folder
2. Inside reports folder, create two files `MyReport.php` and `MyReport.view.php`
3. Adding `use \koolreport\yii2\Friendship` to your report like following

`MyReport.php`

```
<?php
namespace app\reports;

class MyReport extends \koolreport\KoolReport
{
    use \koolreport\yii2\Friendship;
    // By adding above statement, you have claim the friendship between two frameworks
    // As a result, this report will be able to accessed all databases of Yii2
    // There are no need to define the settings() function anymore
    // while you can do so if you have other datasources rather than those
    // defined in Laravel.
    

    function setup()
    {
        $this->src("default")
        ->query("SELECT * FROM offices")
        ->pipe($this->dataStore("offices"));        
    }
}
```

`MyReport.view.php`

```
<?php
use \koolreport\widgets\koolphp\Table;
?>
<html>
    <head>
    <title>My Report</title>
    </head>
    <body>
        <h1>It works</h1>
        <?php
        Table::create([
            "dataSource"=>$this->dataStore("offices")
        ]);
        ?>
    </body>
</html>
```

#### Step 2: Run report and display report

Now you have MyReport ready, in order to get report display inside Yii2, you will create MyReport's object in controller and pass that object to the view to render.


`HomeController.php`

```
<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    ...
    public function actionReport()
    {
        $report = new \app\reports\MyReport;
        $report->run();
        return $this->render('report',array(
            "report"=>$report
        ));
        
    }
}
```

`report.php`

```
<?php $report->render(); ?>
```

# Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.