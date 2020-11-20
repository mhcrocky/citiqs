# Introduction

`Sparklines` are great chart library to let you create tiny charts and graphs. Sometime we just need to see the trend or to get overview of data, we leave the details tp complete charts and graphs library such as Google Charts or Morris or D3. Tiny charts like `Sparklines` will enhance the look and feel of your php report.

# Installation

1. Unzip the zipped file
2. Copy `sparklines` folder into `koolreport\packages`

# Documentation

There are 6 types of Sparklines charts: `Bar`, `Pie`, `Box`, `Bullet`, `Line` and `Tristate`. Those chart has following common properties:

|name|type|default|description|
|---|---|---|---|
|`dataStore`|DataStore||Set the datastore from which chart will read|
|`column`|string||The column name in datastore from which chart will read|
|`data`|array||Directly set data for the sparkline chart if you do not want to use the `dataStore` and `column` property|
|`width`|string|"20px"|Set the width of chart|
|`height`|string|"20px"|Set the height of chart|
|`options`|array||Set extra options for specific chart|


## Bar chart

The `Bar` widget, as the name suggested, will create bar chart. Below code will use the column `amount` from `result` dataStore to create tiny bar chart.

```
<?php
Bar::create(array(
    "dataStore"=>$this->dataStore("result"),
    "column"=>"amount",
))
?>
```

### Set data directly

```
<?php
Bar::create(array(
    "data"=>array(5,7,5,10,8,12)
));
?>
```

### Set width and height

```
<?php
Bar::create(array(
    "data"=>array(5,7,5,10,8,12),
    "height"=>"50px",
    "options"=>array(
        "barWidth"=>"50px",
    )
));
?>
```

```
<?php
Pie::create(array(
    "data"=>array(5,7,5,10,8,12),
    "height"=>"50px",
    "width"=>"50px"
));
?>
```


### Set color for bar chart

```
<?php
Bar::create(array(
    "data"=>array(5,7,5,10,8,12)
    "options"=>array(
        "barColor"=>"green",
    )
));
?>
```

## Pie chart

```
<?php
Pie::create(array(
    "dataStore"=>$this->dataStore("result"),
    "column"=>"amount",
    "width"=>"30px",
    "height"=>"30px",
))
?>
```

## Line chart


```
<?php
Line::create(array(
    "dataStore"=>$this->dataStore("result"),
    "column"=>"amount",
))
?>
```

## Box chart


```
<?php
Box::create(array(
    "dataStore"=>$this->dataStore("result"),
    "column"=>"amount",
))
?>
```

## Bullet chart


```
<?php
Bullet::create(array(
    "dataStore"=>$this->dataStore("result"),
    "column"=>"amount",
))
?>
```

## Tristate chart

```
<?php
Tristate::create(array(
    "dataStore"=>$this->dataStore("result"),
    "column"=>"amount",
))
?>
```

# Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.