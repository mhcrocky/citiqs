<?php
/**
 * This file contains base class for all controls
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

namespace koolreport\inputs;
use \koolreport\core\Widget;
use \koolreport\core\Utility;

class InputControl extends Widget
{
    protected $name;
    protected $data;
    protected $value;
    protected $attributes;
    protected $clientEvents;
    
    public function version()
    {
        return "5.5.1";
    }
    protected function onInit()
    {
        $this->name = Utility::get($this->params,"name",null);
        if($this->name===null)
        {
            throw new \Exception("[name] property is missing");
        }
        $this->useDataSource();
        $this->data = Utility::get($this->params,"data",null);
        $this->attributes = Utility::get($this->params,"attributes",array());
        $this->clientEvents = Utility::get($this->params,"clientEvents",array());

        $report = $this->getReport();
        if(method_exists($report,"_parseParamsToInputs"))
        {
            //If the inptus control is used inside a report with Bindable then
            //we will load value from the binding parameters
            $binds = $report->_parseParamsToInputs();
            $reportParams = $report->_getParams();
            foreach($binds as $paramName=>$inputName)
            {
                if($inputName==$this->name)
                {
                    $this->value = Utility::get($reportParams,$paramName,null);
                }
            }
        }
        if($this->value===null)
        {
            $this->value = Utility::get($this->params,"value");
        }
    }
}