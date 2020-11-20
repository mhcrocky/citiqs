<?php
/**
 * This file is wrapper class for C3JS DonutChart
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
 * This file is wrapper class for C3JS DonutChart
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class DonutChart extends PieChart
{
    protected $type = "donut";
    protected $title;

    /**
     * OnInit
     *
     * @return null
     */
    protected function onInit()
    {
        parent::onInit();
        $this->title = Utility::get($this->params, "title");
    }

    /**
     * Extra settings for column charts
     *
     */
    protected function getSettings()
    {
        $settings = array();
        $parent_settings = parent::getSettings();

        //Copy the pie settings to donut settings
        $settings["donut"] = isset($parent_settings["pie"])?$parent_settings["pie"]:array();
        unset($parent_settings["pie"]);

        if ($this->title) {
            $settings["donut"]["title"] = $this->title;
        }

        return Utility::arrayMergeRecursive($parent_settings, $settings);
    }

}
