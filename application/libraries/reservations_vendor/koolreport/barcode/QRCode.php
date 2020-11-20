<?php
/**
 * This file contains QRCode widget class 
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license
 */


/*
  Usage
  
  QRCode::create(array(
    "format" => "svg", //"png", "jpg"
    "value"=>"Test QRCode",
    "size"=>150,
    "foregroundColor"=>array(0, 0, 0),
    "backgroundColor"=>array(255, 255, 255),
  ));
*/

namespace koolreport\barcode;
use \koolreport\core\Widget;
use \koolreport\core\Utility;

class QRCode extends Widget
{
  protected $format;
  protected $value;
  protected $size;
  protected $foregroundColor;
  protected $backgroundColor;
  public function version()
  {
    return "1.3.1";
  }
  protected function onInit()
  {
    $this->format = strtoupper(Utility::get($this->params, "format", "jpg"));
    $this->value = Utility::get($this->params, "value", "");
    $this->size = Utility::get($this->params, "size", 150);
    $this->foregroundColor = Utility::get($this->params, "foregroundColor", array(0, 0, 0));
    $this->backgroundColor = Utility::get($this->params, "backgroundColor", array(255, 255, 255));
  }

  protected function onRender()
  {
    $qrCode = new \Endroid\QrCode\QrCode($this->value);
    $qrCode->setSize($this->size);
    $f = $this->foregroundColor;
    $b = $this->backgroundColor;
    $qrCode->setForegroundColor(['r' => $f[0], 'g' => $f[1], 'b' => $f[2]]);
    $qrCode->setBackgroundColor(['r' => $b[0], 'g' => $b[1], 'b' => $b[2]]);
    $format = $this->format;
    if ($format === "SVG") {
      $svg = new \Endroid\QrCode\Writer\SvgWriter();
      echo $svg->writeString($qrCode);
    }
    else if ($format === "PNG" || $format === "JPG")
      echo "<img src='data:image/$format;base64," . base64_encode($qrCode->writeString()) . "'>";
    ;
  }    
}