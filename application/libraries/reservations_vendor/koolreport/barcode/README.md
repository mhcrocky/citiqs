# Introduction

The `Barcode` package allows you to create various type of barcodes and qrcodes in multiple format like jpg, png and svg.

# Installation

1. Download and unzip the zipped file.
2. Copy the folder `barcode` into `koolreport/packages` folder
3. Reference to the BarCode and QRCode widgets by the classname `\koolreport\barcode\BarCode` and `\koolreport\barcode\QRCode`

# Documentation

## Quickstart

In your view, you could use the `BarCode` and `QRCode` widgets like following:

```
<?php
  //MyReport.view.php
  use \koolreport\barcode\BarCode;
  use \koolreport\barcode\QRCode;
?>
...
  <?php
  BarCode::create(array(
    "format" => "html", //"svg", "png", "jpg"
    "value" => "081231723897",
    "type" => "TYPE_CODE_128",
    "widthFactor" => 2,
    "height" => 30,
    "color" => "black", //"{{color string}}" for html and svg, array(R, G, B) for jpg and png
  ));
  ?>

...

  <?php
  QRCode::create(array(
    "format" => "svg", //"png", "jpg"
    "value" => "Test QRCode",
    "size" => 150,
    "foregroundColor" => array(0, 0, 0),
    "backgroundColor" => array(255, 255, 255),
  ));
  ?>
```

## BarCode

### Properties

|name|type|default|description|
|---|---|---|---|
|`format`|string|"jpg"|This property defines the output format of barcodes. We have 4 formats: html (using divs and background color), svg (vector image), jpg and png.|
|`value`|string|""|This is the value of barcode|
|`type`|string|"TYPE_CODE_128"|This property is for various types of barcode. List of support barcode type is below.|
|`widthFactor`|number|"2px"|This is the width of each bar in pixel|
|`height`|number|30|This set the height of barcodes.|
|`color`|string/array||A color string for html and svg formats; an array of (r, g, b) values for jpg and png formats.|

### List of types

|Supported types of BarCodes|||
|---|---|---|
|TYPE_CODE_39|TYPE_CODE_39_CHECKSUM|TYPE_CODE_39_CHECKSUM|
|TYPE_CODE_39E|TYPE_CODE_39E_CHECKSUM|TYPE_CODE_93|
|TYPE_STANDARD_2_5|TYPE_STANDARD_2_5_CHECKSUM|TYPE_INTERLEAVED_2_5|
|TYPE_INTERLEAVED_2_5_CHECKSUM|TYPE_CODE_128|TYPE_CODE_128_A|
|TYPE_CODE_128_B|TYPE_CODE_128_C|TYPE_EAN_2|
|TYPE_EAN_5|TYPE_EAN_8|TYPE_EAN_13|
|TYPE_UPC_A|TYPE_UPC_E|TYPE_MSI|
|TYPE_MSI_CHECKSUM|TYPE_POSTNET|TYPE_PLANET|
|TYPE_RMS4CC|TYPE_KIX|TYPE_IMB|
|TYPE_CODABAR|TYPE_CODE_11|TYPE_PHARMA_CODE|
|TYPE_PHARMA_CODE_TWO_TRACKS|||


## QRCode

### Properties

|name|type|default|description|
|---|---|---|---|
|`format`|string|"jpg"|This property defines the output format of qrcodes. We have 3 formats: svg, jpg and png.|
|`value`|string|""|This is the value of qrcode.|
|`size`|number|150|Set the size in px of qrcodes.|
|`foregroundColor`|array|array(0,0,0)|An array of (r, g, b) values for the foreground color of qrcodes.|
|`backgroundColor`|array|array(255, 255, 255)|An array of (r, g, b) values for the background color of qrcodes.|

# Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.