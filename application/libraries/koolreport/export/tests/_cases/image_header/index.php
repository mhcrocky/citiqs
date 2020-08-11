<?php

require_once "Report.php";

$report = new Report;
$report->run()->export("Report")->pdf(array(
    "format"=>"A4",
    "orientation"=>"landscape",
    "zoom"=>2
))->toBrowser("image_header.pdf",true);