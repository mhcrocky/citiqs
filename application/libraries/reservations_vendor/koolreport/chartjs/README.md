# Introduction

`ChartJS` package contains wrapped widget class for great chart library [ChartJS](http://www.chartjs.org/). ChartJS library is very beautiful and rich in features. It is capable of replacing the Google Chart library. Not like Google Charts, `ChartJS` package can be used without internet so that is the greatest advantage of this package.

#### [View demo](https://www.koolreport.com/examples/#chartjs)

# Installation

1. Unzip the `chartjs.zip`
2. Copy the `chartjs` into `koolreport/packages`
2. All done!

# Documentation

## Namespace

All the charts of package are under the namespace `\koolreport\chartjs`. You can directly use the class like this to create chart:

```
\koolreport\chartjs\LineChart::create(array(
    ...
));
```

or you can use `use` statement on top of page to declare the library before use


```
<?php
    use \koolreport\chartjs\LineChart;
?>

...
<?php
LineChart::create(array(
    ...
));
?>
```

## BarChart/ColumnChart

`BarChart` and `ColumnChart` is basically the same except for the chart direction. Their settings and usage are pretty much the same. All settings in examples below can be used for both types of chart.

![php bar chart](https://www.koolreport.com/assets/images/editor/c4/barchart.png)

![php column chart](https://www.koolreport.com/assets/images/editor/c4/columnchart.png)

#### Example

```
<?php
ColumnChart::create(array(
    "dataSource"=>$this->dataStore("category_amount"),
    "title"=>"Sale Amount On Each Category"
    "columns"=>array(
        "category",
        "amount"=>array(
            "label"=>"Amount",
            "type"=>"number",
            "prefix"=>'$',
        )
    ),
))
?>
```

In above example, we use datastore `category_amount` as the dataSource for ColumnChart. We set the `title` for the chart to "Sale Amount On Each Category". We specify columns from datastore to be used for drawing chart. The first column `category` will be acted as label for xAxis while `amount` will be value for yAxis. We add extra settings for `amount` columns to make dollar sign appear in front of number.

We may add more data column to `columns`, for each added columns, new chart series will be added.

#### Chart settings

|name|type|default|description|
|---|---|---|---|
|`name`|||Specify name of chart, it is optional|
|`dataSource`|||`*required` Specify the source for chart, accept DataStore, DataSource, Process and even array data in table or associate format.|
|`columns`|array/mixed||Specify the list of columns will be used to draw chart|
|`options`|array||Specify extra options for charts, see extra options section for more details.|
|`plugins`|array||Specify multiple plugins for charts.|
|`title`|string||Title of the charts|
|`backgroundOpacity`|number|0.5|Specify opacity of bar background|
|`stacked`|boolean|false|Specify if the series of chart will be stacked.|

#### Data column settings

|name|type|default|description|
|---|---|---|---|
|`label`|string||Set label for column|
|`type`|string||Type of columns `number`,`string`,`datetime`|
|`prefix`|string||Set prefix for value, for example `$`|
|`suffix`|string||Set suffix for value|
|`formatValue`|string/function||Accept string or function. For eaxmple: `"formatValue"=>"@value USD"` or `"formatValue"=>function($value){return $value." USD";}`|
|`decimals`|number||The number of number after decimal points|
|`thousandSeparator`|string|`,`|Specify how thousand is seperated|
|`decimalPoint`|string|`.`|Specify decimal point|
|`config`|array||Contain special settings of chart js config for series, see below ChartJs configuration for column for more details|


#### ChartJs config for column
|name|type|default|description|
|---|---|---|---|
|`borderColor`|string/array||The color of the bar border. We may specify an array of colors if we want different color for each bar in the series|
|`backgroundColor`|string/array||The fill color of the bar. We may input an array of colors if we want different color for each bar in the series|
|`borderWidth`|number/array||The stroke width of the bar in pixels.|
|`borderSkipped`|string||Which edge to skip drawing the border for. `bottom`, `top`, `left`, `right`|
|`hoverBackgroundColor`|string/array||The fill colour of the bars when hovered.|
|`hoverBorderColor`|string/array||The stroke colour of the bars when hovered.|
|`hoverBorderWidth`|string/array||The stroke width of the bars when hovered.|
|`xAxisID`|string||The ID of the x axis to plot this dataset on. If not specified, this defaults to the ID of the first found x axis|
|`yAxisID`string|||The ID of the y axis to plot this dataset on. If not specified, this defaults to the ID of the first found y axis.|


__Example for column settings:__

```
ColumnChart::create(array(
    "dataSource"=>$this->dataStore("category_amount"),
    "title"=>"Sale Amount On Each Category"
    "columns"=>array(
        "category",
        "amount"=>array(
            "label"=>"Amount",
            "type"=>"number",
            "prefix"=>'$',
            "config"=>array(
                "borderColor"=>"#aaaaaa",
                "backgroundColor"=>"#dddddd",
                "borderWidth"=>2,
            )
        )
    ),
))
?>
```

#### Some extra options

Below are some extra options for BarChart and Columns. This below settings are put under `options` property.

|name|type|default|description|
|---|---|---|---|
|`barPercentage`|number|0.9|Percent (0-1) of the available width each bar should be within the category width. 1.0 will take the whole category width and put the bars right next to each other.|
|`categoryPercentage`|number|0.8|Percent (0-1) of the available width each category should be within the sample width. |
|`barThickness`|number||Manually set width of each bar in pixels. If not set, the base sample widths are calculated automatically so that they take the full available widths without overlap. Then, the bars are sized using barPercentage and categoryPercentage.|
|`maxBarThickness`|||Set this to ensure that bars are not sized thicker than this.

#### Stacked chart

To enabled `stacked` feature, you simply do:

```
<?php
ColumnChart::create(array(
    ...
    "stacked"=>true
))
?>
```


## LineChart/AreaChart

`LineChart` and `AreaChart` are quite the same in term of settings so we group them together.

![php line chart](https://www.koolreport.com/assets/images/editor/c4/linechart.png)

![php area chart](https://www.koolreport.com/assets/images/editor/c4/areachart.png)


#### Example

```
<?php 
LineChart::create(array(
    "dataSource"=>$this->dataStore("category_amount"),
    "columns"=>array(
        "category",
        "amount"=>array(
            "label"=>"Amount"
            "type"=>"number",
            "prefix"=>"$",
        )
    )
))
?>
```

Above example show miminum settings to setup a line chart. We use 2 columns from datasource which are "category' and "amount" to draw chart.

Note that: we may add extra column and the extra column will represent another series on the chart. The first column is used for xAxis labeling.

#### Settings

|name|type|default|description|
|---|---|---|---|
|`name`|string||Set name for chart. It is optional|
|`title`|string||Title of the chart|
|`dataSource`|mixed||Set the data source for chart, accepting DataStore, DataSource, Process object and even array in table or associate format|
|`columns`|array||List of columns used to draw chart|
|`options`|array||Extra options for line chart or area chart, please view options section for more details|
|`backgroundOpacity`|number|0.5|Set the opacity for background|

#### Properties of a column

Except for the first column, the next column in the `columns` list will represent a series of data on the chart. We may have further settings for each column. Below are properties we can set for column.

__Example__

```
<?php 
LineChart::create(array(
    "dataSource"=>$this->dataStore("category_amount"),
    "columns"=>array(
        "category",
        "amount"=>array(
            "label"=>"Amount"
            "type"=>"number",
            "prefix"=>"$",
            "decimals"=>2,
        )
    )
))
?>
```

|name|type|default|description|
|---|---|---|---|
|`label`|string||Set label for column|
|`type`|string||Type of columns `number`,`string`,`datetime`|
|`prefix`|string||Set prefix for value, for example `$`|
|`suffix`|string||Set suffix for value|
|`formatValue`|string/function||Accept string or function. For eaxmple: `"formatValue"=>"@value USD"` or `"formatValue"=>function($value){return $value." USD";}`|
|`decimals`|number||The number of number after decimal points|
|`thousandSeparator`|string|`,`|Specify how thousand is seperated|
|`decimalPoint`|string|`.`|Specify decimal point|
|`config`|array||Contain special settings of chart js config for series, see below ChartJs configuration for column for more details|

#### Config for column

This is optional but we can have many further options/configs for the chart. Below are the properties that you can put under the `config`.

```
<?php 
LineChart::create(array(
    "dataSource"=>$this->dataStore("category_amount"),
    "columns"=>array(
        "category",
        "amount"=>array(
            "label"=>"Amount"
            "type"=>"number",
            "prefix"=>"$",
            "config"=>array(
                "steppedLine"=>true
            )
        )
    )
))
?>
```

|name|type|default|description|
|---|---|---|---|
|`backgroundColor`|string||The fill color under the line.|
|`borderColor`|string||The color of the line|
|`borderWidth`|number||The width of the line in pixels.|
|`borderDash`|number[]||Length and spacing of dashes. |
|`borderDashOffset`|number||Offset for line dashes|
|`borderCapStyle`|string||Cap style of the line.|
|`borderJoinStyle`|string||Line joint style. |
|`cubicInterpolationMode`|string||Algorithm used to interpolate a smooth curve from the discrete data points. |
|`fill`|boolean/string||How to fill the area under the line.|
|`lineTension`|number||Bezier curve tension of the line. Set to 0 to draw straightlines. This option is ignored if monotone cubic interpolation is used.|
|`pointBackgroundColor`|number/number[]||The fill color for points.|
|`pointBorderColor`|string/string[]||The border color for points.|
|`pointBorderWidth`|number/array||The width of the point border in pixels.|
|`pointRadius`|number/array||The radius of the point shape. If set to 0, the point is not rendered.|
|`pointStyle`|string/array||Style of the point.|
|`pointHitRadius`|number/array||The pixel size of the non-displayed point that reacts to mouse events.d|
|`pointHoverBackgroundColor`|string/array||Point background color when hovered.|
|`pointHoverBorderColor`|string/array||Point border color when hovered.|
|`pointHoverBorderWidth`|numner/array||Border width of point when hovered.|
|`pointHoverRadius`|number/array||The radius of the point when hovered.|
|`showLine`|boolean||If false, the line is not drawn for this dataset.|
|`spanGaps`|boolean||If true, lines will be drawn between points with no or null data. If false, points with NaN data will create a break in the line|
|`steppedLine`|boolean/string||If the line is shown as a stepped line. Value: `true`, `false`, `"before"`, `"after"`. If the `steppedLine` value is set to anything other than false, `lineTension` will be ignored.|


## PieChart / DonutChart / PolarChart

`PieChart`, `DonutChart` and `PolarChart` are great way to represent percentage of each components of a whole. They are quite similar and share the same settings.

![php pie chart](https://www.koolreport.com/assets/images/editor/c4/piechart.png)

![php donut chart](https://www.koolreport.com/assets/images/editor/c4/donutchart.png)

![php polar chart](https://www.koolreport.com/assets/images/editor/c4/polarchart.png)


__Example__

```
PieChart::create(array(
    "dataSource"=>$this->dataStore("category_amount")
    "columns"=>array("category","amount")
))
```

With the minimum settings above, we had a PieChart to show percent of each category contributing to the whole sum of amount.

#### Settings

|name|type|default|description|
|---|---|---|---|
|`name`|string||Set name for chart. It is optional|
|`title`|string||Title of the chart|
|`dataSource`|mixed||Set the data source for chart, accepting DataStore, DataSource, Process object and even array in table or associate format|
|`columns`|array||List of columns used to draw chart|
|`options`|array||Extra options for line chart or area chart, please view options section for more details|

#### Column settings

In PieChart and DonutChart, the first column data will be used for labeling and the next columns are used for data. Each data column can have extra settings

__Example:__

```
PieChart::create(array(
    "dataSource"=>$this->dataStore("category_amount"),
    "columns"=>array(
        "category",
        "amount"=>array(
            "label"=>"Amount",
            "type"=>"number",
            "prefix"=>"$",
        )
    )
))
```

|name|type|default|description|
|---|---|---|---|
|`label`|string||Set label for column|
|`type`|string||Type of columns `number`,`string`,`datetime`|
|`prefix`|string||Set prefix for value, for example `$`|
|`suffix`|string||Set suffix for value|
|`formatValue`|string/function||Accept string or function. For eaxmple: `"formatValue"=>"@value USD"` or `"formatValue"=>function($value){return $value." USD";}`|
|`decimals`|number||The number of number after decimal points|
|`thousandSeparator`|string|`,`|Specify how thousand is seperated|
|`decimalPoint`|string|`.`|Specify decimal point|
|`config`|array||Contain special settings of chart js config for series, see below ChartJs configuration for column for more details|

#### Config for column

There are several extra settings for column under the `config` property of column. Those are optional.

```
PieChart::create(array(
    "dataSource"=>$this->dataStore("category_amount"),
    "columns"=>array(
        "category",
        "amount"=>array(
            "label"=>"Amount",
            "type"=>"number",
            "prefix"=>"$",
            "config"=>array(
                "backgroundColor"=>"#dddddd",
            )
        )
    )
))
```

|name|type|default|description|
|---|---|---|---|
|`backgroundColor`|string[]||The fill color of the arcs in the dataset.|
|`borderColor`|string[]||The border color of the arcs in the dataset.|
|`borderWidth`|number[]||The border width of the arcs in the dataset.|
|`hoverBackgroundColor`|string[]||The fill colour of the arcs when hovered.|
|`hoverBorderColor`|string[]||The stroke colour of the arcs when hovered.|
|`hoverBorderWidth`|number[]||The stroke width of the arcs when hovered.|


## RadarChart

![php radar chart](https://www.koolreport.com/assets/images/editor/c4/radarchart.png)

To construct a `RadarChart` is very simple. Below is a minimum settings to construct a `RadarChart`

```
RadarChart::create(array(
    "dataSource"=>$this->dataStore("category_amount"),
    "columns"=>array("category","amount")
));
```

With just 4 lines of code above, we have specify data source for radar chart and point out columns to use drawing chart. The `category` column will act as chart label while `amount` column will provide detail data. The successive columns will add more series of data to charts.

#### Settings

|name|type|default|description|
|---|---|---|---|
|`name`|string||Set name for chart. It is optional|
|`title`|string||Title of the chart|
|`dataSource`|mixed||Set the data source for chart, accepting DataStore, DataSource, Process object and even array in table or associate format|
|`columns`|array||List of columns used to draw chart|
|`options`|array||Extra options for line chart or area chart, please view options section for more details|
|`backgroundOpacity`|number|0.5|Set the opacity for background|

#### Column settings

Each columns may have extra settings

```
RadarChart::create(array(
    "dataSource"=>$this->dataStore("category_amount"),
    "columns"=>array(
        "category",
        "amount"=>array(
            "type"=>"number",
            "prefix"=>"$",
        )
    )
));
```

|name|type|default|description|
|---|---|---|---|
|`label`|string||Set label for column|
|`type`|string||Type of columns `number`,`string`,`datetime`|
|`prefix`|string||Set prefix for value, for example `$`|
|`suffix`|string||Set suffix for value|
|`formatValue`|string/function||Accept string or function. For eaxmple: `"formatValue"=>"@value USD"` or `"formatValue"=>function($value){return $value." USD";}`|
|`decimals`|number||The number of number after decimal points|
|`thousandSeparator`|string|`,`|Specify how thousand is seperated|
|`decimalPoint`|string|`.`|Specify decimal point|
|`config`|array||Contain special settings of chart js config for series, see below ChartJs configuration for column for more details|

#### Config of column

The `config` property can be used to set further configuration for the series of RadarChart

```
RadarChart::create(array(
    "dataSource"=>$this->dataStore("category_amount"),
    "columns"=>array(
        "category",
        "amount"=>array(
            "type"=>"number",
            "prefix"=>"$",
            "config"=>array(
                "backgroundColor"=>"#dddddd",
                "borderColor"=>"#aaaaaa",
            )
        )
    )
));
```
|name|type|default|description|
|---|---|---|---|
|`backgroundColor`|string||The fill color under the line.|
|`borderColor`|string||The color of the line.|
|`borderWidth`|number||The width of the line in pixels.|
|`borderDash`|number[]||Length and spacing of dashes|
|`borderDashOffset`|number||Offset for line dashes.|
|`borderCapStyle`|string||Cap style of the line|
|`borderJoinStyle`|string||Line joint style.|
|`fill`|boolean/string||How to fill the area under the line.|
|`lineTension`|number||Bezier curve tension of the line. Set to 0 to draw straightlines.|
|`pointBackgroundColor`|string/string[]||The fill color for points.|
|`pointBorderColor`|string/string[]||The border color for points.|
|`pointBorderWidth`|number/number[]||The width of the point border in pixels.|
|`pointRadius`|number/number[]||	The radius of the point shape. If set to 0, the point is not rendered.|
|`pointStyle`|string/string[]||Style of the point. Values: `'circle'`, `'cross'`, `'crossRot'`, `'dash'`, `'line'`, `'rect'`, `'rectRounded'`, `'rectRot'`, `'star'`, `'triangle'` |
|`pointHitRadius`|number/number[]||The pixel size of the non-displayed point that reacts to mouse events.|
|`pointHoverBackgroundColor`|string/string[]||Point background color when hovered.|
|`pointHoverBorderColor`|string/string[]||Point border color when hovered.|
|`pointHoverBorderWidth`|number/number[]||Border width of point when hovered.|
|`pointHoverRadius`|number/number[]||The radius of the point when hovered.|

#### Turn off scale

If you do not want `RadarChart` to show the scale, you may off the scale:

```
RadarChart::create(array(
    ...
    "options"=>array(
        "scale"=>array(
            "display"=>false,
        )
    )
));
```

## ScatterChart/BubbleChart

`ScatterChart` and `BubbleChart` are sharing the same settings. They are similar but there is a major different. While `ScatterChart` care about the location of the point of chart with `(x,y)` the `BubbleChart` also care about the size of the point. The `BubbleChart` has 3 value `(x,y,v)`. The `v` value determined the size of points.

![php scatter chart](https://www.koolreport.com/assets/images/editor/c4/scatterchart.png)

![php bubble chart](https://www.koolreport.com/assets/images/editor/c4/bubblechart.png)


```
ScatterChart::create(array(
    "title"=>"Age and number of phone owned",
    "dataSource"=>array(
        array("age"=>12,"#phone"=>2),
        array("age"=>18,"#phone"=>3),
        array("age"=>21,"#phone"=>5),
        array("age"=>21,"#phone"=>3),
    ),
    "series"=>array(
        array("age","#phone")
    )
));
```

```
ScatterChart::create(array(
    "title"=>"Weight, Height and Number of Phone"
    "dataSource"=>array(
        array("weight"=>89,"height"=>169,"#phone"=>2),
        array("weight"=>75,"height"=>174,"#phone"=>2),
        array("weight"=>72,"height"=>176,"#phone"=>2),
        array("weight"=>78,"height"=>180,"#phone"=>2),
    ),
    "series"=>array(
        array("weight","height",#phone")
    )
));
```

#### Settings

|name|type|default|description|
|---|---|---|---|
|`name`|string||Set name for chart. It is optional|
|`title`|string||Title of the chart|
|`dataSource`|mixed||Set the data source for chart, accepting DataStore, DataSource, Process object and even array in table or associate format|
|`series`|array||List of series, each series is an array containing column name and settings|
|`options`|array||Extra options for line chart or area chart, please view options section for more details|
|`backgroundOpacity`|number|0.5|Set the opacity for background|
|`scale`|number|1|For BubbleChart only, this property set the scale for bubble to fit the size of chart. Please change this to make the point suitable for the size of your chart|



#### Series property

Property `series` contains list of columns for `ScatterChart` and `BubbleChart`. ScatterChart will requires 2 columns while BubbleChart requires 3 columns. The adding array at the end will contains settings for the series. 

```
ScatterChart::create(array(
    "series"=>array("age","#phone",array(
        "label"=>"Age vs Phone",
    ))
));
```

```
BubbleChart::create(array(
    "series"=>array("age","#phone",array(
        "label"=>"Height, weight vs Phone",
    ))
));
```

|name|type|default|description|
|---|---|---|---|
|`label`|string||Label of the series|
|`backgroundColor`|string||Background of the point|
|`borderColor`|string||Border of the point|
|`borderWidth`|number||Size of point's border|
|`pointStyle`|string|`circle`|Style of points.Values: `'circle'`, `'cross'`, `'crossRot'`, `'dash'`, `'line'`, `'rect'`, `'rectRounded'`, `'rectRot'`, `'star'`, `'triangle'` |
|`radius`|number||Size of the point|
|`hoverBackgroundColor`|string||Background of point when hovered|
|`hoverBorderColor`|string||Border color of point when hovered|
|`hoverBorderWidth`|number||Border width of the point when hovered|
|`hoverRadius`|number||Radius of point when hovered|
|`hitRadius`|number||Additional radius for hit detection|
|`scale`|number||Scale for the series|


# Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.