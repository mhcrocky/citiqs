<?php
    $base  = "http://".$_SERVER['HTTP_HOST'];
    $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

    $config['base_url'] = $base;
    // echo $base;
    // die;