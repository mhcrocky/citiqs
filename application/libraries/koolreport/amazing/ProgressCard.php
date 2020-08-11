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
class ProgressCard extends IndicatorCard
{
    protected $infoText;
    /**
     * OnInit
     * 
     * @return null
     */
    protected function onInit()
    {
        parent::onInit();
        $this->infoText = Utility::get($this->params, "infoText");
        
        $this->indicatorMethod = $this->indicatorMethod ? 
            $this->indicatorMethod : "percentComplete";
        $this->indicatorTitle = $this->indicatorTitle ?
            $this->indicatorTitle : "Complete {indicatorValue} of {baseValue}";

    }
}