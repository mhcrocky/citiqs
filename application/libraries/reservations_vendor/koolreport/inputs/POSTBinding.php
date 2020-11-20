<?php
/**
 * This file contains trait to update params from $_POST[]
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

namespace koolreport\inputs;
trait POSTBinding
{
    protected function _updateParams()
    {
        $binds = $this->_parseParamsToInputs();
        foreach ($binds as $paramName=>$inputName) {
            if (isset($_POST[$inputName])) {
                $this->params[$paramName] = $_POST[$inputName];
            } else if (isset($_POST["__$inputName"])) {
                $this->params[$paramName] = json_decode($_POST["__$inputName"],true);
            }
        }
    }
}