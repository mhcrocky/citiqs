<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('my_money_format'))
{
    function my_money_format($locale,$value) {
        if ($locale == 'de_DE'){
            $currency = 'EUR';
            return str_replace ('.', ',', number_format($value, 2)).' '.$currency;
        }
    }
}