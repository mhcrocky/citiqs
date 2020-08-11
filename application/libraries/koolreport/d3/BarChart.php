<?php
/**
 * This file is wrapper class for C3JS BarChart
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

/**
 * This file is wrapper class for C3JS BarChart
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class BarChart extends ColumnChart
{
    /**
     * Extra settings for column charts
     * 
     */
    protected function getSettings()
    {
        $settings = array(
            "axis"=>array(
                "rotated"=>true
            )
        );
        return Utility::arrayMergeRecursive(parent::getSettings(), $settings);
    }

}