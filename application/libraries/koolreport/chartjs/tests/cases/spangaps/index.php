<?php
require_once "../../../../core/autoload.php";
require_once "Report.php";

$report = new Report;
$report->run()->render();
