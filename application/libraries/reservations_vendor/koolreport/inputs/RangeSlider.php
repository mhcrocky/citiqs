<?php
/**
 * This file contains wrapper class for Select controls
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

namespace koolreport\inputs;
use \koolreport\core\Utility;

class RangeSlider extends InputControl
{

    protected $range;
    protected $handles;
    protected $rtl;
    protected $vertical;
    protected $scale;
    protected $format;
    protected $length;

    protected $step;
    protected $snap;
    protected $options;
    protected $connect;


    protected function resourceSettings()
    {
        return array(
            "folder"=>"bower_components",
            "js"=>array("nouislider/nouislider.min.js"),
            "css"=>array("nouislider/nouislider.min.css"),
        );
    }

    protected function onInit()
    {
        parent::onInit();

        $this->range = Utility::get($this->params,"range",array(
            "min"=>0,
            "max"=>100,
        ));

        $this->handles = Utility::get($this->params,"handles",1);
        $this->options = Utility::get($this->params,"options",array());
        $this->rtl = Utility::get($this->params,"rtl",false);
        $this->vertical = Utility::get($this->params,"vertical",false);
        $this->step = Utility::get($this->params,"step");
        $this->snap = Utility::get($this->params,"snap");
        $this->connect = Utility::get($this->params,"connect",true);
        $this->scale = Utility::get($this->params,"scale");
        $this->format = Utility::get($this->params,"format");
        $this->length = Utility::get($this->params,"length");


        $start = array();
        for($i=0;$i<$this->handles;$i++)
        {
            if($this->value!==null && isset($this->value[$i]))
            {
                $start[$i]=$this->value[$i];
            }
            else if(isset($this->range["min"]))
            {
                $start[$i] = $this->range["min"];
            }
        }
        $this->value = $start;
    }
    protected function onRender()
    {
        $options = array_merge($this->options,array(
            "start"=>$this->value,
            "range"=>$this->range,
        ));
        if($this->connect!==null)
        {
            $options["connect"] = $this->connect;
        }

        if($this->step!==null)
        {
            $options["step"] = $this->step;
        }
        if($this->snap!==null)
        {
            $options["snap"] = $this->snap;
        }
        if($this->rtl!=null)
        {
            $options["direction"] = "rtl";
        }
        if($this->vertical)
        {
            $options["orientation"] = "vertical";
        }
        if($this->scale)
        {
            $options["pips"] = array(
                "mode"=>"range",
                "density"=>$this->scale,
            );
        }
        $this->template('RangeSlider',array(
            "options"=>$options,
        ));
    }
}