<?php 
require_once APPPATH . 'reports/Dayreport.php';

$dailyturnover = new Dayreport([
    'vendorId' => $vendorId
]);
$dailyturnover->run()->render();

require_once APPPATH . 'reports/Visitors.php';

