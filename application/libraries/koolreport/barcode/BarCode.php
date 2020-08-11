<?php
/**
 * This file contains BarCode widget class 
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license
 */

/*
  Usage

  BarCode::create(array(
    "format"=>"html", //"svg", "png", "jpg"
    "value"=>"081231723897",
    "type"=>"TYPE_CODE_128",
    "widthFactor"=>2,
    "height"=>30,
    "color"=>"black", //"black" for html and svg, array(0, 0, 0) for jpg and png
  ));
*/



namespace koolreport\barcode;
use \koolreport\core\Widget;
use \koolreport\core\Utility;
use \Picqer\Barcode\BarcodeGeneratorHTML;
use \Picqer\Barcode\BarcodeGeneratorSVG;
use \Picqer\Barcode\BarcodeGeneratorPNG;
use \Picqer\Barcode\BarcodeGeneratorJPG;

class BarCode extends Widget
{
    protected $format;
    protected $value;
    protected $type;
    protected $widthFactor;
    protected $height;
    protected $color;

    public function version()
    {
      return "1.2.0";
    }

    protected function onInit()
    {
      $this->format = strtoupper(Utility::get($this->params, "format", "jpg"));
      $this->value = Utility::get($this->params, "value", "");
      $this->type = Utility::get($this->params, "type", "TYPE_CODE_128");
      $this->widthFactor = Utility::get($this->params, "widthFactor", 2);
      $this->height = Utility::get($this->params, "height", 30);
      $this->color = Utility::get($this->params, "color", 
        $this->format === "HTML" || $this->format === "SVG" ? "black" : array(0, 0, 0));
    }

    protected function onRender()
    {
      $format = $this->format;
      $barcodeClass = "\Picqer\Barcode\BarcodeGenerator$format";
      $generator = new $barcodeClass();
      $barcode = $generator->getBarcode(
        $this->value, 
        constant("\Picqer\Barcode\BarcodeGenerator::" . $this->type),
        $this->widthFactor,
        $this->height,
        $this->color
      );
      if ($format === "HTML" || $format === "SVG")
        echo $barcode;
      else if ($format === "PNG" || $format === "JPG")
        echo "<img src='data:image/$format;base64," . base64_encode($barcode) . "'>";
    }    
}