<?php
/**
 * This file contains function formatValue
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */

namespace koolreport\d3;
use \koolreport\core\Utility;

trait FormatValue
{
    /**
     * Converting the type
     *
     * @param string $type Type of data
     *
     * @return string New type
     */
    protected function formatValue($value, $format, $row = null)
    {
        $formatValue = Utility::get($format, "formatValue", null);

        if (is_string($formatValue)) {
            eval('$fv="' . str_replace('@value', '$value', $formatValue) . '";');
            return $fv;
        } else if (is_callable($formatValue)) {
            return $formatValue($value, $row);
        } else {
            return Utility::format($value, $format);
        }
    }

}