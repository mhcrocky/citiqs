<?php

namespace koolreport\inputs;

use \koolreport\core\Utility;

class Select2 extends InputControl
{
    use InputSelectData;
    protected $multiple;
    protected $placeholder;
    protected $data;
    protected $dataBind;
    protected $options;

    protected function resourceSettings()
    {
        return array(
            "library"=>array("jQuery"),
            "folder"=>"bower_components",
            "js"=>array("select2/js/select2.full.min.js"),
            "css"=>array("select2/css/select2.min.css"),
        );
    }
    

    protected function onInit()
    {
        parent::onInit();

        $this->multiple = Utility::get($this->params,"multiple",false);
        $this->placeholder = Utility::get($this->params,"placeholder");

        $this->defaultOption = Utility::get($this->params,"defaultOption",null);
        if($this->data==null)
        {
            $this->data = $this->getBindingData();
        }
        else 
        {
            $this->data = $this->parseDirectData($this->data);
        }
        if($this->defaultOption && $this->defaultOption!==array())
        {
            $this->data = array_merge($this->parseDirectData($this->defaultOption),$this->data);
        }
        
        if($this->multiple===true && $this->value===null)
        {
            $this->value = array();
        }
        $this->options = Utility::get($this->params,"options",array());

        $this->placeholder = Utility::get($this->params,"placeholder");
        if($this->placeholder!=null)
        {
            $this->options["placeholder"] = $this->placeholder;
        }
        
    }

    protected function onRender()
    {
        if($this->multiple)
        {
            $this->template('Select2m');
        }
        else
        {
            $this->template('Select2s');
        }
    }
}