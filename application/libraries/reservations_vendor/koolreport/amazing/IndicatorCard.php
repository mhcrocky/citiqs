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
class IndicatorCard extends SimpleCard
{
    protected $baseValue;
    protected $indicatorMethod;
    protected $indicatorTitle;
    protected $indicatorFormat;
    protected $indicatorThreshold;

    /**
     * OnInit
     *
     * @return null
     */
    protected function onInit()
    {
        parent::onInit();
        $this->baseValue = Utility::get($this->params, "baseValue");
        $this->baseValue = $this->processScalar($this->baseValue);

        $indicator = Utility::get($this->params, "indicator", array());

        $this->indicatorMethod = Utility::get($indicator, "method");
        $this->indicatorTitle = Utility::get($indicator, "title");
        $this->indicatorThreshold = Utility::get($indicator, "threshold", 0);

        $format = Utility::get($this->params, "format", array());
        $this->indicatorFormat = array_merge(
            array(
                "decimals"=>2,
                "suffix"=>"%",
            ),
            Utility::get(
                $format,
                "indicator", 
                array()
            )
        );
    }


    /**
     * Return the percentage increase or decrease to previous Value
     *
     * @return float The percentage increase/decrease
     */
    protected function calculateIndicator($value, $baseValue, $indicatorMethod)
    {
        if ($indicatorMethod == "percentChange") {
            if ($baseValue !== null && $baseValue !== 0) {
                return ($value - $baseValue) * 100 / $baseValue;
            }
        } else if ($indicatorMethod == "percentComplete") {
            if ($baseValue !== null && $baseValue !== 0) {
                return $value * 100 / $baseValue;
            } 
        } else if ($indicatorMethod=="different") {
            return $value - $baseValue;
        } else if (is_callable($indicatorMethod)) {
            return $indicatorMethod($value, $baseValue);
        }
        return false;
    }
}