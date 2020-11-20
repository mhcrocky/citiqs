<?php
/**
 * This file is wrapper class for Waterfall
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

/**
 * This file is wrapper class for Waterfall
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class Waterfall extends \koolreport\core\Widget
{
    use ProcessColumns;
    use FormatValue;

    protected $title;
    protected $columns;
    protected $width;
    protected $height;
    protected $colors;
    protected $margin;

    protected $yAxis;

    protected $summary;

    protected $clientEvents;


    /**
     * On init
     */
    protected function onInit()
    {
        $this->useAutoName("wf");
        $this->useDataSource();

        if ($this->dataStore == null) {
            throw new \Exception("[dataSource] is required");
        }

        $this->columns = $this->processColumns();
        $this->clientEvents = Utility::get($this->params,"clientEvents",array()); 
        $this->title = Utility::get($this->params,"title");
        $this->width = Utility::get($this->params, "width", "100%");
        $this->height = Utility::get($this->params, "width", "400px");
        $this->margin = Utility::get($this->params, "margin", array());
        $this->colors = Utility::get($this->params, "colors", array());
        $this->yAxis = Utility::get($this->params, "yAxis");
        $this->summary = Utility::get($this->params, "summary", array(
            "Total"=>"end"
        ));
    }

    /**
     * Return the resource settings for table
     *
     * @return array The resource settings of table widget
     */
    protected function resourceSettings()
    {
        return array(
            "folder" => "clients",
            "js" => array(
                "d3/d3.v5.min.js",
                "d3/utility.js",
                "waterfall/waterfall.js",
            ),
            "css" => array(
                "waterfall/waterfall.css",
            ),
        );
    }


    /**
     * return the settings
     */
    protected function getSettings()
    {
        $settings = array();
        $allKeys = array_keys($this->columns);
        
        if (count($allKeys)<2) {
            throw new \Exception("Waterfall needs at least two columns");
        }

        $cKeys = array(
            $allKeys[0],$allKeys[1]
        );
        $settings["cKeys"] = $cKeys;

        $data = array();
        foreach ($this->dataStore as $row) {
            array_push($data, array(
                "name"=>$row[$cKeys[0]],
                "value"=>(float)$row[$cKeys[1]],
            ));
        }
        $settings["data"] = $data;

        $summary = array();
        foreach ($this->summary as $k=>$v) {
            array_push($summary, [$k,$v]);
        }
        $settings["summary"] = $summary;

        //yAxis
        if ($this->yAxis) {
            if (isset($this->yAxis["format"])) {
                $settings["yAxis"]["format"] = $this->yAxis["format"];
            } else {
                $decimals = Utility::get($this->yAxis, "decimals", 0);
                $thousandSep = Utility::get(
                    $this->yAxis,
                    "thousandSep",
                    Utility::get($this->yAxis, "thousandSeparator", ",")
                );
                $decPoint = Utility::get(
                    $this->yAxis,
                    "decPoint",
                    Utility::get($this->yAxis, "decimalPoint", ".")
                );
                $prefix = Utility::get($this->yAxis, "prefix", "");
                $suffix = Utility::get($this->yAxis, "suffix", "");
                $settings["yAxis"] = array(
                    "format"=>"function(){return KoolReport.d3.format($decimals,'$decPoint','$thousandSep','$prefix','$suffix');}()"
                );
            }
        }

        //label
        $valueSettings = $this->columns[$cKeys[1]];
        if($valueSettings)
        {
            if(isset($valueSettings["format"]))
            {
                $settings["label"] = array(
                    "format"=> $valueSettings["format"]
                );
            }
            else
            {
                $decimals = Utility::get($valueSettings, "decimals", 0);
                $thousandSep = Utility::get(
                    $valueSettings,
                    "thousandSep",
                    Utility::get($valueSettings, "thousandSeparator", ",")
                );
                $decPoint = Utility::get(
                    $valueSettings,
                    "decPoint",
                    Utility::get($valueSettings, "decimalPoint", ".")
                );
                $prefix = Utility::get($valueSettings, "prefix", "");
                $suffix = Utility::get($valueSettings, "suffix", "");
                $settings["label"] = array(
                    "format"=>"function(){return KoolReport.d3.format($decimals,'$decPoint','$thousandSep','$prefix','$suffix');}()"
                );        
            }
        }

        $settings["colors"]= array(
            "darkolivegreen",
            "crimson",
            "steelblue",
            "darkred"
        );

        for($i=0;$i<count($this->colors);$i++)
        {
            $settings["colors"][$i] = $this->colors[$i];
        }
        
        //Margin
        $settings["margin"] = array(
            "top"=>Utility::get($this->margin, "top", 80),
            "right"=>Utility::get($this->margin, "right", 20),
            "bottom"=>Utility::get($this->margin, "bottom", 30),
            "left"=>Utility::get($this->margin, "left", 50),
        );

        if($this->title)
        {
            $settings["title"] = $this->title;
        }

        return $settings;
    }

    /**
     * On rendering
     */
    protected function onRender()
    {
        $this->template(
            array("settings" => $this->getSettings())
        );
    }
}
