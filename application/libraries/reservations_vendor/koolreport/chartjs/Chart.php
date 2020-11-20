<?php

namespace koolreport\chartjs;

use \koolreport\core\Utility;
use \koolreport\core\Widget;

class Chart extends Widget
{
    protected $type;

    protected $columns;
    protected $options;
    protected $width;
    protected $height;
    protected $title;
    protected $backgroundOpacity = 0.5;
    protected $clientEvents;
    protected $colorScheme;
    protected $plugins;

    public function version()
    {
        return "2.5.0";
    }

    protected function resourceSettings()
    {
        $maps = array(
            "annotation"=>array(
                "chartjs-plugin-annotation.min.js"
            ),
            "datalabels"=>array(
                "chartjs-plugin-datalabels.min.js"
            ),
            "draggable"=>array(
                "chartjs-plugin-draggable.min.js"
            ),
            "stacked100"=>array(
                array("chartjs-plugin-stacked100.js")
            ),
            "waterfall"=>array(
                "chartjs-plugin-waterfall.min.js"
            ),
            "zoom"=>array(
                "chartjs-plugin-zoom.min.js"
            ),
            "barFunnel"=>array(
                "Chart.BarFunnel.min.js"
            ),
            "linearGauge"=>array(
                "Chart.LinearGauge.js"
            ),
            "smith"=>array(
                "Chart.Smith.js"
            )
        );

        $js = array("Chart.bundle.min.js", "chartjs.js");
        if($this->plugins)
        {
            foreach($this->plugins as $name)
            {
                if(isset($maps[$name]))
                {
                    foreach($maps[$name] as $jsfile)
                    {
                        array_push($js,$jsfile);
                    }
                }
            }
        }
        return array(
            "folder" => "clients",
            "js" => $js
            //"css"=>array("Chart.min.css") // Use for CSP strict mode
        );
    }

    protected function onInit()
    {
        $this->useAutoName("chartjs");
        $this->useDataSource();

        if ($this->type == null) {
            $this->type = Utility::get($this->params, "type");
        }
        if ($this->type == null) {
            throw new \Exception("No chart type defined");
        }

        $this->columns = Utility::get($this->params, "columns");
        $this->options = Utility::get($this->params, "options", array());
        $this->plugins = Utility::get($this->params, "plugins", array());
        $this->width = Utility::get($this->params, "width");
        $this->height = Utility::get($this->params, "height");
        $this->title = Utility::get($this->params, "title");
        $this->backgroundOpacity = Utility::get($this->params, "backgroundOpacity", 0.5);
        $this->clientEvents = Utility::get($this->params, "clientEvents", array());

        //Color Scheme
        $this->colorScheme = Utility::get($this->params, "colorScheme");
        if (!is_array($this->colorScheme)) {
            $theme = $this->getReport()->getTheme();
            if ($theme) {
                $theme->applyColorScheme($this->colorScheme);
            }
        }
        if (!is_array($this->colorScheme)) {
            $this->colorScheme = $this->getDefaultScheme();
        }

        if ($this->title) {
            $this->options["title"] = Utility::get($this->options, "title", array());

            $this->options["title"] = array_merge($this->options["title"], array(
                "text" => $this->title,
                "display" => true,
            ));
        }
    }

    protected function getColumns()
    {
        $columnsMeta = $this->dataStore->meta()["columns"];
        $columns = array();
        if ($this->columns == null) {
            $this->columns = array_keys($columnsMeta);
        }
        foreach ($this->columns as $cKey => $cSettings) {
            if (gettype($cSettings) == "array") {
                $columns[$cKey] = array_merge($columnsMeta[$cKey], $cSettings);
            } else {
                $columns[$cSettings] = $columnsMeta[$cSettings];
            }
        }
        return $columns;
    }

    protected function processData()
    {
        //Overrite at decendence
        return array();
    }

    protected function processOptions()
    {
        return $this->options;
    }

    protected function registerPlugins()
    {
        $mapVaribles = array(
            "datalabels"=>"ChartDataLabels",
        );
        $list = array();
        foreach($this->plugins as $name)
        {
            if(isset($mapVaribles[$name]))
            {
                array_push($list,$mapVaribles[$name]);
            }
        }
        return "function(){return [".implode(",",$list)."];}()";
    }

    protected function getDefaultScheme()
    {
        return array(
            "#3366CC",
            "#DC3912",
            "#FF9900",
            "#109618",
            "#990099",
            "#3B3EAC",
            "#0099C6",
            "#DD4477",
            "#66AA00",
            "#B82E2E",
            "#316395",
            "#994499",
            "#22AA99",
            "#AAAA11",
            "#6633CC",
            "#E67300",
            "#8B0707",
            "#329262",
            "#5574A6",
            "#3B3EAC",
            "#ff6384",
            "#ff9f40",
            "#ffcd56",
            "#4bc0c0",
            "#36a2eb",
            "#9966ff",
            "#c9cbcf",
        );
    }
    protected function getColor($index)
    {
        return $this->colorScheme[$index % count($this->colorScheme)];
    }

    protected function getRgba($color, $opacity = 0.5)
    {
        list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
        $alpha = 1 - $opacity;
        return "rgba($r,$g,$b,$alpha)";
    }

    protected function formatValue($value, $format, $row = null)
    {
        $formatValue = Utility::get($format, "formatValue", null);

        if (is_string($formatValue)) {
            eval('$fv="' . str_replace('@value', '$value', $formatValue) . '";');
            return $fv;
        } else if (is_callable($formatValue)) {
            return $formatValue($value, $row);
        } else {
            return Utility::format($value, $format);
        }
    }

    protected function onRender()
    {
        if ($this->dataStore->countData() > 0) {
            $settings = array();
            $settings["type"] = $this->type;
            $settings["data"] = $this->processData();
            $settings["options"] = $this->processOptions();
            $settings["cKeys"] = array_keys($this->getColumns());
            if($this->plugins) {
                $settings["plugins"] = $this->registerPlugins();
            }
        
            $this->template("Chart", array(
                "settings" => $settings,
            ));
        } else {
            $this->template("NoData");
        }
    }
}
