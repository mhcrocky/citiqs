# Introduction

[MorrisJS](http://morrisjs.github.io/morris.js/index.html) is one of the best Chart and Graph libraries. MorrisJS is welknown of its simplicity in making a cool charts. As stated in the moto of the MorrisJS __*"good-looking charts shouldn't be difficult"*__, the authors stressed the difference between Morris and other chart libraries, the simplicity.

This package helps you to generate MorrisJS Chart in KoolReport much more simple.

# Installation

1. Download the zip file and unzip
2. Copy the folder `morris_chart` into the `koolreport\packages` folder

All done! Simple, isn't it?

# Documentation

MorrisJS has four(4) type of charts: `Line`, `Area`, `Bar` and `Donut`. In general, to create a chart you do:
```
<?php
    use \koolreport\morris_chart\Line;
?>
<?php
    Line::create(array(
        "dataStore"=>$this->dataStore('dataStore'),
        ...
        //other chart settings
    ));
?>
```

## Common properties

|Name           |type       |description                                                    |
|---------------|-----------|---------------------------------------------------------------|
|`dataStore`    |DataSore   | The data store that chart will get data from                  |
|`columns`      |array      | Array of columns that will be used in chart, for example `columns=>array('month','sale')`, the first column in chart is used to create x-axis in Line, Bar or Area. In Donut chart, first column will contain data of label. Other columns after the first are the data.|
|`colorScheme`  |array      | Contain the list of HTML color for each series of data. This properties is optional. If you do not set then it will follow the theme of report or the default color scheme of Morris chart|
|`options`      |mixed      | Contain any raw settings of each chart type, those settings defined here will be transfer directly to Morris to handle|

### How to format number in chart?

```
...
"columns"=>array(
    "month",
    "amount"=>array(
        "type"=>"number"
        "prefix"=>"$", //prefix number
        "suffix"=>"", //Suffix
        "decimals"=>2, // Number of decimals
        "thousandSeparator"=>",",
        "decimalPoint"=>".",
    )
)
...
```

### Where can I find extra properties to put into `options`?

If you working with `Line`, you can reference full list of properties [in here](http://morrisjs.github.io/morris.js/lines.html). Those listed properties can be put into `options` of `Line` chart.

In the same manner, below are the list of properties for other charts:

1. [Line & Area Charts](http://morrisjs.github.io/morris.js/lines.html)
2. [Bar Charts](http://morrisjs.github.io/morris.js/bars.html)
3. [Donut Charts](http://morrisjs.github.io/morris.js/donuts.html)


## Examples

### Line Chart

```
<?php
    Line::create(array(
        "dataStore"=>$this->dataStore('sale'),
        "columns"=>array(
            'month',
            'income'=>array(
                "label"=>"Income",
                "type"=>"number",
                "prefix"=>"$",
            ),
            'expense'=>array(
                "label"=>"Income",
                "type"=>"number",
                "prefix"=>"$",                
            )
        ),
        "options"=>array(
            //Extra settings for Line Chart
        ),
    ));
?>
```

### Area Chart

```
<?php
    Line::create(array(
        "dataStore"=>$this->dataStore('sale'),
        "columns"=>array(
            'month',
            'income'=>array(
                "label"=>"Income",
                "type"=>"number",
                "prefix"=>"$",
            ),
            'expense'=>array(
                "label"=>"Income",
                "type"=>"number",
                "prefix"=>"$",                
            )
        ),
        "options"=>array(
            //Extra settings for Area Chart
        ),
    ));
?>
```

### Bar Chart

```
<?php
    Bar::create(array(
        "dataStore"=>$this->dataStore('sale'),
        "columns"=>array(
            'month',
            'income'=>array(
                "label"=>"Income",
                "type"=>"number",
                "prefix"=>"$",
            ),
            'expense'=>array(
                "label"=>"Income",
                "type"=>"number",
                "prefix"=>"$",                
            )
        ),
        "options"=>array(
            //Extra settings for Area Chart
        ),
    ));
?>
```

### Donut Chart

```
<?php
    Donut::create(array(
        "dataStore"=>$this->dataStore('sale'),
        "columns"=>array(
            'month',
            'income'=>array(
                "label"=>"Income",
                "type"=>"number",
                "prefix"=>"$",
            ),
            'expense'=>array(
                "label"=>"Income",
                "type"=>"number",
                "prefix"=>"$",                
            )
        ),
        "options"=>array(
            //Extra settings for Area Chart
        ),
    ));
?>
```

### Extra settings for Donut charts

|Name               |type       |description                                    |
|-------------------|-----------|-----------------------------------------------|
|`showPercentage`   |bool       | Whether the donut chart will show percentage  |
|`decimals`         |number     | Set number of decimals                        |


## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.