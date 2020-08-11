<?php
require_once "../load.koolreport.php";
require_once "Report.php";

$report = new Report;
$report->run()->render();
