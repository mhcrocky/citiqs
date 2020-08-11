<?php
/**
 * This file contains trait for collumn processing, receive the user-defined columns and
 * mormalize them into a structure manner.
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */

namespace koolreport\d3;
use \koolreport\core\Utility;

trait ProcessColumns
{
    /**
     * Return list of columns
     *
     * @return array List of columns
     */
    protected function processColumns()
    {
        $columns_from_user = Utility::get($this->params, "columns");
        $columnsMeta = $this->dataStore->meta()["columns"];
        $columns = array();
        if ($columns_from_user == null) {
            $columns_from_user = array_keys($columnsMeta);
        }
        foreach ($columns_from_user as $cKey => $cSettings) {
            if (gettype($cSettings) == "array") {
                $columns[$cKey] = array_merge($columnsMeta[$cKey], $cSettings);
            } else {
                $columns[$cSettings] = $columnsMeta[$cSettings];
            }
        }
        return $columns;
    }
}