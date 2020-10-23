<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * Autoload required classes.
     */
    spl_autoload_register(function(string $class) {
        
        $class = explode('\\', $class);
        $classPath = APPPATH . '/libraries/php-jwt-master/src/' . $class[2] . '.php';
        if (file_exists($classPath)) {
            require_once $classPath;
        }
    });
