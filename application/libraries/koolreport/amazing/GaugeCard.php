<?php
/**
 * This file contains Card widget of amazing Theme
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
namespace koolreport\amazing;

use \koolreport\core\Utility;


/**
 * This file contains Card widget of amazing Theme
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class GaugeCard extends IndicatorCard
{
    protected $gauge;

    /**
     * OnInit
     *
     * @return null
     */
    protected function onInit()
    {
        parent::onInit();
        if (!$this->baseValue) {
            throw new \Exception("baseValue must be set");
        }
        $this->minValue = Utility::get($this->params, "minValue", 0);
        $this->maxValue = Utility::get($this->params, "maxValue", 100);
        $this->showValue = Utility::get($this->params, "showValue", true);
		$this->showBaseValue = Utility::get($this->params, "showBaseValue", false);
        $this->indicatorMethod = $this->indicatorMethod ? 
            $this->indicatorMethod : "percentComplete";

        if (!$this->preset) {
            $this->preset = "primary";
        }

        $default_gauge = array(
            "colorStart" => $this->getPresetBackgroundColor(),
            "colorStop" => $this->getPresetBackgroundColor(),
        );
        $this->gauge = array_merge(
            $default_gauge,
            Utility::get($this->params, "gauge", array())
        );
    }

    /**
     * Return the resource settings for table
     * 
     * @return array The resource settings of table widget
     */
    protected function resourceSettings()
    {
        return array(
            "folder" => "assets/gaugecard",
            "js" => array("gauge.min.js"),
            "css" => array("gauge.min.css"),
        );
    }}