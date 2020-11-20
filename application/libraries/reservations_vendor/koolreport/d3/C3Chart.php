<?php
/**
 * This file is wrapper class for C3JS Chart
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
 * This file is wrapper class for C3JS Chart
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class C3Chart extends Widget
{
    protected $type;
    protected $columns;
    protected $options;
    protected $clientEvents;

    protected $width;
    protected $height;
    protected $colorScheme;

    use ProcessColumns;
    use FormatValue;

    /**
     * Return version of D3
     * 
     * @return string Version of D3
     */
    public function version()
    {
        return "1.5.0";
    }

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
        $this->options = Utility::get($this->params, "options", array());
        $this->clientEvents = Utility::get($this->params, "clientEvents",array());

        $this->width = Utility::get($this->params, "width");
        $this->height = Utility::get($this->params, "height");

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
                "c3/c3.min.js",
                "c3/c3chart.js",
            ),
            "css" => array(
                "c3/c3.min.css",
            ),
        );
    }


    /**
     * Get settings for C3
     *
     * @return array Settings for c3
     */
    protected function getSettings()
    {

        $settings = array();

        $settings["bindto"] = "#$this->name";

        if ($this->width || $this->height) {
            $settings["size"] = array();
            if ($this->width) {
                $settings["size"]["width"] = $this->width;
            }
            if ($this->height) {
                $settings["size"]["height"] = $this->height;
            }
        }

        if ($this->type != null) {
            $settings["data"]["type"] = $this->type;
        }

        //Colortheme

        if($this->colorScheme)
        {
            $settings["color"] = array(
                "pattern"=>$this->colorScheme
            );
        }


        //Client events
        // $settings["clientEvents"] = array();
        // if ($this->clientEvents) {
        //     foreach ($this->clientEvents as $name => $handler) {
        //         $settings["clientEvents"][strtolower($name)] = $handler;
        //     }
        // }

        return $settings;
    }

    /**
     * On Render
     *
     * @return null
     */
    protected function onRender()
    {
        $settings = $this->getSettings();
        $settings = Utility::arrayMergeRecursive($settings, $this->options);
        $this->template(
            'C3Chart',
            array("settings" => $settings)
        );
    }
}
