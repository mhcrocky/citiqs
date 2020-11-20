<?php
/**
 * This file contains class to handle CheckBoxList
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

namespace koolreport\inputs;

use \koolreport\core\Utility;

class CheckBoxList extends InputControl
{
    use InputSelectData;
    protected $dataBind;
    protected $display;
    protected $defaultOption;

    protected function resourceSettings()
    {
        return array(
            "library"=>array("jQuery"),
            "folder"=>"bower_components",
            "js"=>array("cinputs/checkboxlist.js"),
            "css"=>array(),
        );
    }
    
    protected function onInit()
    {
        parent::onInit();
        if ($this->value==null) {
            $this->value = array();
        }
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
