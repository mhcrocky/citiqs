<?php
/**
 * This file is wrapper class for D3 FunnelChart
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */

namespace koolreport\d3;

use \koolreport\core\DataStore;
use \koolreport\core\Utility;
use \koolreport\core\Widget;

/**
 * This file is wrapper class for D3 FunnelChart
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class FunnelChart extends Widget
{
    protected $columns;
    protected $clientEvents;

    protected $width;
    protected $height;
    protected $colorScheme;

    use ProcessColumns;

    /**
     * Return the resource settings for table
     *
     * @return array The resource settings of table widget
     */
    protected function onInit()
    {
        $this->useAutoName("c3");
        $this->useDataSource();

        if ($this->dataStore == null) {
            throw new \Exception("[dataSource] is required");
        }

        $this->columns = $this->processColumns();
        
        $this->clientEvents = Utility::get($this->params, "clientEvents",array());
        $this->width = Utility::get($this->params, "width");
        $this->height = Utility::get($this->params, "height",240);
    
    
        //Color Scheme
        $this->colorScheme = Utility::get($this->params, "colorScheme");
        if (!is_array($this->colorScheme)) {
            $theme = $this->getReport()->getTheme();
            if ($theme) {
                $theme->applyColorScheme($this->colorScheme);
            }
        }
        if (!is_array($this->colorScheme)) {
            $this->colorScheme = null;
        }
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
                "funnel/funnel.min.js",
                "funnel/funnelchart.js",
            )
        );
    }

    /**
     * Converting the type
     *
     * @param string $type Type of data
     *
     * @return string New type
     */
    protected function formatValue($value, $format, $row = null)
    {
        $formatValue = Utility::get($format, "formatValue", null);

        if (is_string($formatValue)) {
            eval('$fv="' . str_replace('@value', '$value', $formatValue) . '";');
            return $fv;
        } elseif (is_callable($formatValue)) {
            return $formatValue($value, $row);
        } else {
            return Utility::format($value, $format);
        }
    }

    /**
     * Get settings for C3
     *
     * @return array Settings for c3
     */
    protected function getSettings()
    {
        $settings = array(
            "chart"=>Utility::arrayMergeRecursive(array(
                "animate"=>true,
                "bottomPinch"=>1,
            ),Utility::get($this->params,"chart",array())),

            "block"=>Utility::arrayMergeRecursive(array(
                "dynamicHeight"=>true,
                "minHeight"=>25,
                "highlight"=>true,
                "fill"=>array(
                    "type"=>"gradient",
                )
            ),Utility::get($this->params,"block",array())),

            "label"=>Utility::arrayMergeRecursive(array(
                "enabled"=>true,
                "fontFamily"=>"Arial",
            ),Utility::get($this->params,"label",array())),

            "tooltip"=>Utility::arrayMergeRecursive(array(
                "enabled"=>false
            ),Utility::get($this->params,"tooltip",array())),
        );


        if ($this->width) {
            $settings["chart"]["width"] = $this->width;
        }
        if ($this->height) {
            $settings["chart"]["height"] = $this->height;
        }

        
        //Colortheme
        if($this->colorScheme)
        {
            $colorScheme = json_encode($this->colorScheme);
            $settings["block"] = array(
                "fill"=>array(
                    "scale"=>"function(){
                        return $colorScheme;
                    }()"
                )
            );
        }

        $allKeys = array_keys($this->columns);
        if (count($allKeys)<2) {
            throw new \Exception("Funnel chart needs 2 colunmns, first one is label and second one is value.");
        }

        $settings["cKeys"] = array(
            array_shift($allKeys),
            array_shift($allKeys)
        );
        return $settings;
    }

    /**
     * Get data
     */
    protected function getData()
    {
        $data = array();
        $allKeys = array_keys($this->columns);
        if (count($allKeys)<2) {
            throw new \Exception("Funnel chart needs 2 colunmns, first one is label and second one is value.");
        }

        $cKeys = array();
        for ($i=0;$i<2;$i++) {
            array_push($cKeys, array_shift($allKeys));
        }

        foreach($this->dataStore as $row)
        {
            array_push($data,array(
                "label"=>$row[$cKeys[0]],
                "value"=>$row[$cKeys[1]]
            ));
        }
        return $data;
    }

    /**
     * On Render
     *
     * @return null
     */
    protected function onRender()
    {
        $this->template(array(
            "settings" => $this->getSettings(),
            "data"=>$this->getData(),
        ));
    }
}
