<div style="margin-top: 3%;" class="main-content-inner">
<?php
//require APPPATH."/reports/Pivot/PivotReport.php";
$report = new PivotReport;
$report->run()->render();
?>
</div>