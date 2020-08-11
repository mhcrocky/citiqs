<?php 
require_once APPPATH . 'reports/Visitors.php';

$visitors = new Visitors([
    'vendorId' => $vendorId
]);
$visitors->run()->render();