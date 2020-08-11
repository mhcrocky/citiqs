# Introduction

`DrillDown` is a powerful report type in data analysis. It allows your data to summarize in highest level then break down to smaller one. All level break-down data can be visualized in charts or tables for your better understanding of data.

This package contains 3 different widgets: `DrillDown`, `CustomDrillDown` and `MultiView`.

# Installation

1. Unzip `drilldown.zip`
2. Copy `drilldown` folder into `koolreport\packages`
3. All done! Now you can use the package in your report.


# DrillDown Widget

`DrillDown` widget allows you to setup drill-down report easier than before. Compare to previous version, this version of drilldown is both simpler, faster and more flexible. Let get start with example of drilldown widget:

If in the former `DrillDown` we need to define common datasource for all levels, now it is much simpler that we can define separate datasource in each levels of drilldown.

By defining separate SQL statement in each levels of drilldown, we can make DrillDown run faster because drilldown does not need to load all data like before.

Also by defining SQL Query in each levels, we add flexibility in term of capability to add custom data for a specific level only. The flexibility in displaying drilldown level content is also improved by adding `"content"` property in which you can write your own content of drilldown level.


__Examples__

```
DrillDown::create(array(
    "name"=>"saleReportByLocation"
    "title"=>"Sale By Location",
    "levels"=>array(
        array(
            //Level 1: Show all countries and sales with column chart
            "title"=>"All Countries",
            "widget"=>array(ColumnChart::class,array(
                "dataSource"=>function($params,$scope)
                {
                    return $this->src("mydata")->query("
                        SELECT country, sum(sale_amount) as amount
                        FROM tbl_orders
                        GROUP BY country
                    ");
                }
            ))
        ),
        array(
            //Level 2: Show all states and sale amount in a selected country
            "title"=>function($params,$scope){
                return params["country"];
            },
            "widget"=>array(ColumnChart::class,array(
                "dataSource"=>function($params,$scope)
                {
                    return $this->src("mydata")->query("
                        SELECT state, sum(sale_amount) as amount
                        FROM tbl_orders
                        WHERE country=:country
                        GROUP BY state
                    ")->params(array(
                        ":country"=>$params["country"]
                    ));
                }
            ))
        ),
        array(
            //Level 3; Show all cities in selected state and country
            "title"=>function($params,$scope){
                return $params["state"];
            },
            "widget"=>array(Table::class,array(
                "dataSource"=>function($params,$scope)
                {
                    return $this->src("mydata")->query("
                        SELECT city, sum(sale_amount) as amount
                        FROM tbl_orders
                        WHERE
                            country = :country
                            AND
                            state = :state
                        GROUP BY city
                    ")->params(array(
                        ":country"=>$params["country"],
                        ":state"=>$params["state"],
                    ));
                }
            ))
        ),
    )
));
```
### Properties

|name|type|default|description|
|---|---|---|---|
|`name`|string||`*Required` Name of the drill down report|
or even process.|
|`levels`|array||`* Required` List of all levels for drill down report. See the __level properties__ for more detail of settings on each level.|
|`showLevelTitle`|bool|true|Whether title of each level is shown|
|`btnBack`|mixed|true|By default, the button Back will shown, give it value `false` you will off the Back button. This property can receive array() to customize cssClass and text of button `"btnBack"=>array("text"=>"Go Back","class"=>"btn btn-default btn-warning")`|
|`css`|mixed||Defined css for the most important elements in the widgets, see the __$css__ properties for more details.|
|`cssClass`|mixed||Defined css class for the most important elements in the widgets, see the __$cssClass__ properties for more details.|
|`title`|string||Title that is showed on top of drill-down report.|
|`scope`|array/function||Set the group of parameters which will be kept persistent during the ajax post back of drill-down.|
|`clientEvents`|array||Register client-event, see client-event for more details.|

### CSS Properties

|name|type|default|description|
|---|---|---|---|
|`panel`|string||Define css style for whole panel|
|`header`|string||Define css style for header of panel|
|`levelTitle`|string||Define css style for section that holds titles of level|
|`btnBack`|string||Add css style for Back button|
|`body`|string||Defined css style for body|

__Examples__

```
DrillDown::create(array(
    "css"=>array(
        "panel"=>"margin-top:15px;",
        "body"=>"padding:15px;"
        ...
    )
))
```


### CssClass Properties

|name|type|default|description|
|---|---|---|---|
|`panel`|string||Define css class for panel|
|`header`|string||Define css class for header of panel|
|`levelTitle`|string||Define css class for section that holds titles of level|
|`btnBack`|string||Add css class for Back button|
|`body`|string||Defined css class for body|

__Examples__

```
DrillDown::create(array(
    "cssClass"=>array(
        "panel"=>"panel-success", // Showing green panel, in Bootstrap 4 you can use "bg-success"
        "btnBack"=>"btn-info",
        ...
    )
));
```
### Levels Properties

`"levels"` is an array containing definition of each levels. On each levels we have

|name|type|default|description|
|---|---|---|---|
|`title`|string/function||Define the level title, you may define a anynomous function here to return correct header, the function take `$params` and `$scope` as parameters. `$params` contains the most recent selection of users while `$scope` is persistent variable for drilldown|
|`widget`|array||Containing widget class name and widget parameters. _Note:_ The detasources of widget must be defined in function with `$params` and `$scope`|
|`content`|function||A function with `$params` and `$scope` as two parameters. Base on those parameters, you may generate any custom content for level.|

_Note:_ Either `"widget"` or `"content"` should be used. If both of them are defined, `"widget"` will be used to render. In case you are using the `"content"`, you have the power to control everything but you also need to write client events to call drilldown's `next()` function by yourself. If you are using `"widget"`, things are simpler as the DrillDown will try to fill the client events for you. It supports the most used widgets, `Table`, `Google Chart`, `ChartJs` and `DataGrid`.

__Below are two examples which has equivalent result__

```
DrillDown::create(array(
    "levels"=>array(
        array(
            "title"=>function($params,$scope)
            {
                return "This level title";
            }
            "widget"=>array(Table::class,array(
                "dataSource"=>function($params,$scope)
                {
                    return $this->src('data')
                    ->query("select * from employees where office=:office")
                    ->params(array(
                        ":office"=>$params["office"]
                    ))
                }
            ))
        )
    )
));
```

```
DrillDown::create(array(
    "name"=>"myDrillDown",
    "levels"=>array(
        array(
            "title"=>function($params,$scope)
            {
                return "This level title";
            }
            "content"=>function($params,$scope)
            {
                Table::create(array(
                    "dataSource"=>$this->src('data')
                    ->query("select * from employees where office = :office")
                    ->params(array(
                        ":office"=>$params["office"]
                    )),
                    "clientSide"=>array(
                        "rowClick"=>"function($params){
                            myDrillDown.next(emp_id:params.selectedRow['emp_id'])
                        }"
                    )
                ))
            }
        ),
        ...
    )
));
```



# LegacyDrillDown Widget


__Note:__ `LegacyDrillDown` is the old DrillDown Widget. If you have used the old drilldown report, rename the class to `LegacyDrillDown`.

`LegacyDrillDown` is an widget that allows you to setup an drill-down report in fastest and easiest way. All you need to do are:

1. Setup SQL Statement to withdraw data
2. Setup multi-levels of drill-down.
3. On each level of drill-down, choose chart type to visualize data


### Example

```
<?php 
LegacyDrillDown::create(array(
    "name"=>"saleReportByLocation",
    "title"=>"Sale By Location",
    //Define dataSource which is SQL statement to load all table
    "dataSource"=>(
        $this->src("mydata")->query("SELECT country, state, city, sale_amount FROM orders")
    ),
    //What we want to calculate
    "calculate"=>array(
        "sum"=>"sale_amount"
    ),
    "levels"=>array(
        //Level 1: Group all table by country, showing all countries with `sale_amount` by country.
        array(
            "groupBy"=>"country",
            "widget"=>array(ColumnChart::class,array(
                "columns"=>array("country","sale_amount")
            ))
            "title"=>"All countries",
        ),
        //Level 2: When user select a country, the widget shows `sale_amount` by state of that country
        array(
            "groupBy"=>"state",
            "widget"=>array(ColumnChart::class,array(
                "columns"=>array("state","sale_amount")
            )),
            "title"=>function($params)
            {
                return $params["country"];
            }
        ),
        //Level 3: When user continues to select a state, then widget will show  `sale_amount` by city of that state
        array(
            "groupBy"=>"city",
            "widget"=>array(Table::class,array(
                "columns"=>array("city","sale_amount")
            )),
            "title"=>function($params)
            {
                return $params["city"];
            }
        )
    )
));
?>
```

### Properties

|name|type|default|description|
|---|---|---|---|
|`name`|string||`*Required` Name of the drill down report|
|`dataSource`|mixed||`*Required` DataSource accepts data in form of __DataStore__, __array__, or even process.|
|`dataStore`|mixed||This can be used alternatively to `dataSource`|
|`calculate`|array||`*Required` Define what we want to summarize in form of `"{method}"=>"{columnName}"`. The method supports `"sum"`, `"avg"`, `"min"`, `"max"`|
|`levels`|array||`* Required` List of all levels for drill down report. See the __level properties__ for more detail of settings on each level.|
|`showLevelTitle`|bool|true|Whether title of each level is shown|
|`btnBack`|mixed|true|By default, the button Back will shown, give it value `false` you will off the Back button. This property can receive array() to customize cssClass and text of button `"btnBack"=>array("text"=>"Go Back","class"=>"btn btn-default btn-warning")`|
|`css`|mixed||Defined css for the most important elements in the widgets, see the __$css__ properties for more details.|
|`panelStyle`|string|"default"|Set the panel style, accept value `"default"`, `"danger"`, `"success"`, `"info"`|
|`title`|string||Title that is showed on top of drill-down report.|
|`scope`|array/function||Set the group of parameters which will be kept persistent during the ajax post back of drill-down.|
|`clientEvents`|array||Register client-event, see client-event for more details.|

### Css Properties

|name|type|default|description|
|---|---|---|---|
|`panel`|string||Define css style for top panel|
|`levelTitle`|string||Define css style for section that holds titles of level|
|`btnBack`|string||Add css style for Back button|
|`body`|string||Defined css style for body|

__Examples__

```
<?php
LegacyDrillDown::create(array(
    ...
    "css"=>array(
        "btnBack"=>"font-style:italic";
        "body"=>"height:300px;"
    )
));
?>
```

### Level properties

As we have seen from example on the top of page, `levels` property is an array of each level. Before are the settings of a level

|name|type|default|description|
|---|---|---|---|
|`groupBy`|string||`*Required` contain the column name which drill down will group by on each level|
|`title`|string, function||Set the title information for each level, it accepts static string or a function to generate dynamic title for level. The function will receive a parameter as array containing all previous selection of users|
|`widget`|array||Contain the class name of widget that you want to use and its settings. You may use virtually all kind of widgets here. It could be `Table` or `GoogleChart` or any kinds of widgets available for KoolReport. Please see example of top for more details.|

### Client events

`LegacyDrillDown` support following events:

|name|description|
|---|---|
|`nexting`|Fired when drill-down is preparing to go to next level. Return `false` to cancel action.|
|`nexted`|Fired when drill-down went to next level successfully.|
|`backing`|Fired when drill-down is going to go back to previous level. Return `false` to cancel action.|
|`backed`|Fired when drill-down went back to previous level|
|`changed`|Fired when drill-down changed level|

__Example__

```
<?php
LegacyDrillDown::create(array(
    ...
    "clientEvents"=>array(
        "nexting"=>"function(params){
            return false;//Cancel action
        }",
        "nexted"=>"function(params){
            console.log('Nexted to'+params.level);
        }",
    );
));
?>
```


# CustomDrillDown

`CustomDrillDown` extends the capability to the max. It does not limit the number of charts in a level, you can show any custom content inside a level of drilldown. Due to flexibility, `CustomDrillDown` is a little more complicated to handle than normal drilldown above. To summarize the comparison between `CustomDrillDown` and `DrillDown`

1. CustomDrillDown is faster than DrillDown since CustomDrillDown use the SubReport technology.
2. When callback, only subreport of CustomDrillDown runs so it is more efficient while DrillDown will run the whole main report so it is less efficient.
3. In CustomDrillDown, you need to setup subreport and connecting them with parameters while in DrillDown, you do not need to, we handle all for you.
4. In sum, DrillDown vs CustomDrillDown is the trade-off between the convenience and the powerfulness, the easiness and the complexity.

Below is a tutorial to setup a basic CustomDrillDown:

#### __Step 1:__ Create CountrySale report

The CountrySale report is created in the same way you create a single report. In this CountrySale report, we summarize sale by country and display all countries. When user select a country, it called DrillDown next() function to pass the selection parameters to the next level.

```
<?php
class CountrySale extends \koolreport\KoolReport
{
    protected function settings()
    {
        return array(
            "dataSources"=>array(
                "mydatabase"=>array(
                    "connectionString"=>"mysql:host=localhost;dbname=mydata",
                    "username"=>"root",
                    "password"=>"",
                    "charset"=>"utf8"
                )
            )
        );
    }

    protected function setup()
    {
        $this->src("mydatabase")
        ->query("SELECT country, sum(amount) AS sale_amount FROM orders GROUP BY country")
        ->pipe($this-dataStore("sale_by_country"));
    }
}
```

```
<?php 
    //CountrySale.view.php
    use \koolreport\widgets\google\ColumnChart;
    $drilldown = $this->params["@drilldown"]
?>

<level-title>All Countries</level-title>

<?php
ColumnChart::create(array(
    "dataSource"=>$this->dataStore("sale_by_country"),
    "clientEvents"=>array(
        "itemSelect"=>"function(params){
            $drilldown.next({country:params.selectedRow[0]});
        }"
    )
))
?>
```

#### __Step 2:__ Create StateSale report

The StateSale report is created in the same way that you create a single report. StateSale report will receive a parameter called "country" which is the selected country from user. It will summarize the sale_amount by state in that country.

```
<?php
class StateSale extends \koolreport\KoolReport
{
    protected function settings()
    {
        return array(
            "dataSources"=>array(
                "mydatabase"=>array(
                    "connectionString"=>"mysql:host=localhost;dbname=mydata",
                    "username"=>"root",
                    "password"=>"",
                    "charset"=>"utf8"
                )
            )
        );
    }

    protected function setup()
    {
        $this->src("mydatabase")
        ->query("
            SELECT 
                state, sum(amount) AS sale_amount 
            FROM orders
            WHERE
                country=:country
            GROUP BY state
        ")
        ->params(array(
            ":country"=>$this->params["country"]
        ))
        ->pipe($this-dataStore("sale_by_state"));
    }
}
```

```
<?php 
    //CountrySale.view.php
    use \koolreport\widgets\google\ColumnChart;
    $drilldown = $this->params["@drilldown"]
?>

<level-title>States of <?php echo $this->params["country"]; ?></level-title>

<?php
ColumnChart::create(array(
    "dataSource"=>$this->dataStore("sale_by_state"),
))
?>
```

#### __Step 3:__ Create MainReport

The MainReport defines the CountrySale and StateSale as subreports and create CustomDrillDown at the view.

```
<?php
class MainReport extends \koolreport\KoolReport
{
    use \koolreport\clients\Bootstrap;
    protected function settings()
    {
        return array(
            "subReports"=>array(
                "countrysale"=>CountrySale::class,
                "statesale"=>StateSale::class
            )
        );
    }

    protected function setup()
    {
    }
}
```

```
<?php 
    //MainReport.view.php
    use \koolreport\drilldown\CustomDrillDown;
?>

<html>
    <head>
        <title> Sale By Location</title>
    </head>
    <body>
        <?php
        CustomDrillDown::create(array(
            "name"=>"locationSale"
            "title"=>"Sale By Location",
            "subReports"=>array("countrysale","statesale"),
        ))
        ?>
        ```
    </body>
</html>
```

As result of above settings, now you have a drilldown report that will show all countries with the sales achived in each country. When user selects a particular country, the drilldown will show the sale_amount by each states in that country. Awesome, is it?

Each levels of drill-down report is handled by a sub report which virtually you can customize the interface in the way you want. All you need to do is to call next() function of drill down, sending all selected values then wait for drilldown to move to next level.


### Properties

|name|type|default|description|
|---|---|---|---|
|`name`|string||`*Required` Name of drill down|
|`title`|string||Title that is showed on top of drill-down report.|
|`subReports`|array||`*Required` List of sub report name in level order|
|`showLevelTitle`|bool|true|Whether title of each level is shown|
|`btnBack`|mixed|true|By default, the button Back will shown, give it value `false` you will off the Back button. This property can receive array() to customize cssClass and text of button `"btnBack"=>array("text"=>"Go Back","class"=>"btn btn-default btn-warning")`|
|`css`|mixed||Defined css for the most important elements in the widgets, see the __$css__ properties for more details.|
|`panelStyle`|string|"default"|Set the panel style, accept value `"default"`, `"danger"`, `"success"`, `"info"`|
|`scope`|array/function||Any params you want to included for sub report in form of associated array. You also may use a function and return associate array|
|`clientEvents`|array||Register client-event, please see the Client Events for more details|

### Css Properties

|name|type|default|description|
|---|---|---|---|
|`panel`|string||Define css style for top panel|
|`levelTitle`|string||Define css style for section that holds titles of level|
|`btnBack`|string||Add css style for Back button|
|`body`|string||Defined css style for body|

### Client events

`CustomDrillDown` support following events:

|name|description|
|---|---|
|`nexting`|Fired when CustomDrillDown is preparing to go to next level. Return `false` to cancel action.|
|`nexted`|Fired when CustomDrillDown went to next level successfully.|
|`backing`|Fired when CustomDrillDown is going to go back to previous level. Return `false` to cancel action.|
|`backed`|Fired when CustomDrillDown went back to previous level|
|`changed`|Fired when CustomDrillDown changed level|

__Example__

```
<?php
CustomDrillDown::create(array(
    ...
    "clientEvents"=>array(
        "nexting"=>"function(params){
            return false;//Cancel action
        }",
        "nexted"=>"function(params){
            console.log('Nexted to'+params.level);
        }",
    );
));
?>
```



# MultiView

`MultiView` has another name called drill-through report. It let you see the same data but in different angles, different charts so that you can understand data better. In `MultiView` we setup several views, each view holds a different chart. All the views shares the same datasource.

### Example

```
<?php
    MultiView::create(array(
        "name"=>"multiviewer",
        "dataSource"=>$this->dataStore("data"),
        "views"=>array(
            array(
                "handler"=>"<i class='fa fa-bar-chart'></i>",
                "widget"=>array(BarChart::class,array(
                    "name"=>"mychart",
                    "columns"=>array("year","amount")
                ))
            ),
            array(
                "handler"=>"<i class='fa fa-table'></i>",
                "widget"=>array(Table::class,array(
                    "columns"=>array("year","amount")
                ))
            ), 
        ),
    ));
    ?>           
```

As we can see in the example, we setup a `MultiView` called __multiviewer__ with a datasource. We setup two views, one holds a BarChart and another one holds a Table. User can switch between the between views by using the handler.

### Properties

|name|type|default|description|
|---|---|---|---|
|`name`|string||`*Required` Name of the MultiView|
|`title`|string||The title of MultiView that will appears on the top|
|`template`|string|"panel"|Set the template of the MultiView, default value is "panel".|
|`options`|array||Holding the options available to specific template, please see more details at __options properties__.|
|`views`|array||An array of views and its settings, each views will have `handler` and `widget` property. The `handler` will hold the text of handler and the `widget` define which widget to show in the view together with its settings. Please see above example.|
|`clientEvents`|array||Register client events, please view Client Events for more details|


### Client events

`DrillDown` support following events:

|name|description|
|---|---|
|`changing`|Fired when multiview is going to change view. Return `false` to cancel action.|
|`changed`|Fired when multiview changed index|

__Example__

```
<?php
MultiView::create(array(
    ...
    "clientEvents"=>array(
        "changing"=>"function(params){
            return false;//Cancel action
        }",
        "changed"=>"function(params){
            console.log('Change to'+params.index);
        }",
    );
));
?>
```


# DrillThrough

`DrillThrough` is another name of `MultiView` widget. If you want to use the name `DrillThrough` for better understanding rather than `MultiView`, you can do so.


# Showcases

1. [DrillDown](https://www.koolreport.com/examples/reports/drilldown/drilldown/index.php)
2. [CustomDrillDown](https://www.koolreport.com/examples/reports/drilldown/customdrilldown/index.php)
3. [MultiView/DrillThrough](https://www.koolreport.com/examples/reports/drilldown/multiview/index.php)

# Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.
