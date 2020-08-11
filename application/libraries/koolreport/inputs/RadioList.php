<?php
/**
 * This file contains wrapper class for radio list
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

namespace koolreport\inputs;

use \koolreport\core\Utility;

class RadioList extends InputControl
{
    use InputSelectData;
    protected $display;
    protected $defaultOption;
    
    protected function resourceSettings()
    {
        return array(
            "library"=>array("jQuery"),
            "folder"=>"bower_components",
            "js"=>array("cinputs/radiolist.js"),
        );
    }

    protected function onInit()
    {
        parent::onInit();
        $this->display = Utility::get($this->params, "display", "vertical");//horizontal
        if ($this->data==null) {
            $this->data = $this->getBindingData();
        } else {
            $this->data = $this->parseDirectData($this->data);
        }
        $this->defaultOption = Utility::get($this->params, "defaultOption", null);
        if ($this->defaultOption) {
            $this->data = array_merge($this->parseDirectData($this->defaultOption), $this->data);
        }
    }
}
