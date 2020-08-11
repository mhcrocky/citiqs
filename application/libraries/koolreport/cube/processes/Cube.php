<?php
/**
 * This file contains process to turn data into cross-tab table
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#regular-license
 * @license https://www.koolreport.com/license#extended-license
 */

/* Usage
 * ->pipe(new Cube(array(
      "row" => "customerName",
      "column" => "orderQuarter",
      "sum" => "dollar_sales"
    )))
 * */
namespace koolreport\cube\processes;

use \koolreport\core\Utility as Util;

require_once "SuperCube.php";

class Cube extends SuperCube
{
    // public function onInit() 
    // {
    //     parent::onInit();

    //     reset($this->aggregates);
    //     $firstOperator = key($this->aggregates);
    //     $firstFields = current($this->aggregates);
    //     $firstField = current($firstFields);
    //     $operator = $firstOperator; $field = $firstField;
    //     $this->aggregates = array($operator => array($field));
    //     $this->hasAvg = array();
    //     $this->hasCountPercent = array();
    //     $this->hasSumPercent = array();
        
    //     if ($operator === 'avg')
    //         $this->hasAvg[$field] = true;
    //     if ($operator === 'count percent')
    //         $this->hasCountPercent[$field] = true;
    //     if ($operator === 'sum percent')
    //         $this->hasSumPercent[$field] = true;
    // }

    function buildAggColName($cf, $colNode, $af, $operator) 
    {
        return $colNode;
    }
}