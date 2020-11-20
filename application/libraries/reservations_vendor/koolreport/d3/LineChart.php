<?php
/**
 * This file is wrapper class for C3JS LineChart
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
 * This file is wrapper class for C3JS LineChart
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class LineChart extends ColumnChart
{
    protected $type = "line";
    protected $connectNull = false;

    protected function onInit()
    {
        parent::onInit();
        $this->connectNull = Utility::get($this->params,"connectNull",false);
    }

    /**
     * Build settings
     * 
     */
    protected function getSettings()
    {
        $settings = array();
        if($this->connectNull===true)
        {
            $settings["line"] = array(
                "connectNull"=>true
            );
        }

        return Utility::arrayMergeRecursive(parent::getSettings(), $settings);
    }

}