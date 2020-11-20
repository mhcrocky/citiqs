<?php
/**
 * This file contains wrapper class for Textbox
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

namespace koolreport\inputs;
use \koolreport\core\Utility;

class TextArea extends InputControl
{
    protected function resourceSettings()
    {
        return array(
            "library"=>array("jQuery"),
        );
    }
}