<?php
/**
 * This file contains trait to bind params to inputs and set default values
 * for params.
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */


namespace koolreport\inputs;

trait Bindable
{
    public function __constructBindable()
    {
        $this->registerEvent("OnInit",function(){
            if(method_exists($this,"_updateParams"))
            {
                $this->_updateParams();
            }
            if(method_exists($this,"defaultParamValues"))
            {
                $defaultList = $this->defaultParamValues();
                foreach($defaultList as $paramName=>$defaultValue)
                {
                    if(!isset($this->params[$paramName]))
                    {
                        $this->params[$paramName] = $defaultValue;
                    }
                }
            }
        });
    }

    public function _parseParamsToInputs()
    {
        if(method_exists($this,"bindParamsToInputs"))
        {
            $binds = array();
            foreach($this->bindParamsToInputs() as $paramName=>$inputName)
            {
                if(gettype($paramName)=="integer")
                {
                    $paramName = $inputName;
                }
                $binds[$paramName] = $inputName;
            }
            return $binds;
        }
        return array();
    }
    public function _getParams()
    {
        return $this->params;
    }

}