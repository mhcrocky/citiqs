<?php
/**
 * This file contains trait to update params from $_GET[]
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

namespace koolreport\inputs;
trait GETBinding
{
    protected function _updateParams()
    {
        $binds = $this->_parseParamsToInputs();
        foreach($binds as $paramName=>$inputName)
        {
            if(isset($_GET[$inputName]))
            {
                $this->params[$paramName] = $_GET[$inputName];
            }
        }
    }
}