# Introduction

The `koolreport\inputs` package will add capability of setting custom parameters to your reports. It supports:

1. Common inputs: TextBox, CheckBoxList, RadioList, Select, MultiSelect
2. Advanced inputs: DateRangePicker, DateTimePicker
3. Support data binding to data sources
4. Support state persistent with report's parameters.

# Installation

1. Download the package zip file
2. Unzip
3. Copy the `inputs` folder into `koolreport\packages`
4. Done!

# Changelog

#### Version 3.3.0

1. Make use of default `dataSource` from Widgets.
2. Improve the resource loading.
3. DateRangePicker: Use default language settings provided by Widget
4. Widget: Able to set language map directly in array form.


#### Version 3.0.0

1. Add new `clientEvents` for all controls to handle events at client-side
2. Add `TextArea` input control.
3. Fix the `placeholder` settings for Select2


#### Version 2.7.0

1. Change `defaultOption` input format.
2. Make all select type controls have the same binding options
3. Add defaultOptions to `RadioList` and `CheckBoxList`

#### Version 2.5.0

1. Add ability to set format for RangeSlider
2. Fix bug for MultiSelect

#### Version 2.0.0

1. Select2
2. RangeSlider
3. BSelect

#### Version 1.0.0

1. CheckBoxList
2. DateRangePicker
3. RadioList
4. DateTimePicker
5. MultiSelect
6. Select
7. TextBox

# Documentation

### Initiate params binding
To start using the `inputs` packages, you need to add the followings to your report:

```
<?php

class MyReport extends \koolreport\KoolReport
{
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;

    ...
}
```

The `\koolreport\inputs\Bindable` will help to set up default parameter's values and bind the them to the inputs that we later use in the view of report.

The `\koolreport\inputs\POSTBinding` will help to update report's parameter from __$_POST__. If you are using GET method, you will change to `\koolreport\inputs\GETBinding`.

### Setup default values

The default values of params are important for the first load of report.

```
<?php

class MyReport extends \koolreport\KoolReport
{
    ...
    protected function defaultParamValues()
    {
        return array(
            "dateRange"=>array('2017-07-01','2017-07-31'),
            "customer"=>"John Lennon",
        );
    }
    ...
}
```

As you can see in above example, we have two params in our report which are `dateRange` and `customer`. The values on the right are default values.

### Binding parameters with inputs

Now let say in the view of report, you have some input controls and you want to bind its value to the params of report. You will add the function `bindParamsToInputs()` to your report

```
<?php

class MyReport extends \koolreport\KoolReport
{
    ...
    protected function bindParamsToInputs()
    {
        return array(
            "dateRange"=>"dateRangeInput",
            "customer"=>"customerInput",
        );
    }
    ...
}
```

The function `bindParamsToInputs()` will return an associate array with `key` is the name of params and `value` is the name of input controls. In above example we bind `dateRangeInput` to param `dateRange` and `customerInput` to param `customer`.

If the parameter's name and input's name are the same. You can write short hand like this:

```
<?php

class MyReport extends \koolreport\KoolReport
{
    ...
    protected function bindParamsToInputs()
    {
        return array(
            "dateRange", // The param's name and input's name are both `dateRange`
            "customer" // The param's name and input's name are both `customer`
        );
    }
    ...
}
```

### Put things together

What you need to setup param binding in your reports:

```
<?php

class MyReport extends \koolreport\KoolReport
{

    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;    

    protected function defaultParamValues()
    {
        return array(
            "dateRange"=>array('2017-07-01','2017-07-31'),
            "customer"=>"John Lennon",
        );
    }

    protected function bindParamsToInputs()
    {
        return array(
            "dateRange"=>"dateRangeInput",
            "customer"=>"customerInput",
        );
    }
    ...
}
```

## Input Controls

Now we move to setup the input controls in the view of report. All the input controls put into the view __must have an unique name__. This is important because it helps report knows which controls to bind params to.

All the input controls should be put inside a <form>

```
<form method="post">
    <?php TextBox::create(array("name"=>"customer")) ?>
    ...
</form>
```

### TextBox

#### Minimum setting

```
<?php
\koolreport\inputs\TextBox::create({
    "name"=>"customer",
});
?>
```

#### Other properties:
|Name|type|default|description|
|----|----|-------|-----------|
|name|string||`*Required` Name of the controls|
|value|string||Value of the textbox, this value will be override by the binded params|
|attributes|array|null|An associate array contains settings for inputs, see example below|

#### Client events

TextBox supports all client events such as `focus`, `blur`, `keypress`, `keyup`, `keydown`, `mouseover`, `mouseout`.

#### Full example:

```
<?php
\koolreport\inputs\TextBox::create({
    "name"=>"customer",
    "value"=>"John Lennon",
    "attributes"=>array(
        "class"=>"form-control"
    ),
    "clientEvents"=>array(
        "focus"=>"function(){
            console.log('focus');
        }",
    )
});
?>
```

### TextArea

#### Minimum setting

```
<?php
TextArea::create({
    "name"=>"desciption",
});
?>
```

#### Other properties:
|Name|type|default|description|
|----|----|-------|-----------|
|name|string||`*Required` Name of the controls|
|value|string||Value of the textarea, this value will be override by the binded params|
|attributes|array|null|An associate array contains settings for inputs, see example below|

#### Client events

TextArea supports all client events such as `focus`, `blur`, `keypress`, `keyup`, `keydown`, `mouseover`, `mouseout`.

#### Full example:

```
<?php
TextArea::create({
    "name"=>"customer",
    "value"=>"John Lennon",
    "attributes"=>array(
        "rows"=>5,
        "class"=>"form-control"
    ),
    "clientEvents"=>array(
        "focus"=>"function(){
            console.log('focus');
        }",
    )
});
?>
```


### RadioList

#### Get started

```
<?php
\koolreport\inputs\RadioList::create({
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customers")
    "dataBind"=>"customerName",
});
?>
```

In above example, we bind RadioList to the column `customerName` in dataStore `customers`. As a result, we will have a list of radio buttons with customer name to select from.

#### Different text and value

Above example, both value and text of radio will be "customerName". However we can have different value and text. For example, select customerName and get the customerId as value.

```
<?php
\koolreport\inputs\RadioList::create({
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customers")
    "dataBind"=>array("text"=>"customerName","value"=>"customerId"),
});
?>
```

#### Make the radios horizontal align

By default, the RadioList will organize radios in vertical, but you can make it horizontal:

```
<?php
\koolreport\inputs\RadioList::create({
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customers")
    "dataBind"=>"customerName",
    "display"=>"horizontal",
});
?>
```

#### Not binding data

If you do not want to bind data with dataStore, you can manually enter options:

```
<?php
\koolreport\inputs\RadioList::create({
    "name"=>"customer",
    "data"=>array(
        "John Doe"=>"1",
        "Jane Doe"=>"2",
        "Whatever Doe"=>"3",
    )
});
?>
```

#### Default option

Sometime you need a default option, you do:

```
<?php
\koolreport\inputs\RadioList::create({
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customers")
    "dataBind"=>"customerName",
    "defaultOption"=>array("None"=>"none"),
});
?>
```

#### Client events

`RadioList` support `change` events happen when user changes the selection.

```
<?php
\koolreport\inputs\RadioList::create({
    ...
    "clientEvents"=>array(
        "change"=>"function(s){
            console.log(s.text);
            console.log(s.value);
        }",
    )
});
?>
```



### CheckBoxList

CheckBoxList shows list of checkbox for user to select.

```
<?php
\koolreport\inputs\CheckBoxList::create({
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customer"),
    "dataBind"=>"customerName"
});
?>
```

In above example, we bind the CheckBoxList to the "customerName" column in the "customer" dataStore. As a result, CheckBoxList will show list of checkbox with customer name.

### Values

Values received from CheckBoxList is an `array()` containing the list of selected values.

### Set different text and value

```
<?php
\koolreport\inputs\CheckBoxList::create({
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customer"),
    "dataBind"=>array("text"=>"customerName","value"=>"customerId")
});
?>
```

### Make CheckBoxList display horizontally

By default, the CheckBoxList display checkbox vertically but you can make it horizontally.

```
<?php
\koolreport\inputs\CheckBoxList::create({
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customer"),
    "dataBind"=>"customerName",
    "display"=>"horizontal"
});
?>
```

### Not use data binding

If we do not need data binding, we can manually enter data.

```
<?php
\koolreport\inputs\CheckBoxList::create({
    "name"=>"customer",
    "data"=>array(
        "John Doe"=>"1",
        "Jane Doe"=>"2",
        "Whatever Doe"=>"3",
    )    
});
?>
```

#### Default option

Sometime you need a default option, you do:

```
<?php
\koolreport\inputs\CheckBoxList::create({
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customers")
    "dataBind"=>"customerName",
    "defaultOption"=>array("None"=>"none"),
});
?>
```

#### Client events

`CheckBoxList` support `change` events happen when user changes his selection. The parameters in callback function will contain `value` which is the array of user's selections.

```
<?php
\koolreport\inputs\RadioList::create({
    ...
    "clientEvents"=>array(
        "change"=>"function(params){
            for(i in params.value)
            {
                console.log(params.value[i]);
            }
        }",
    )
});
?>
```


### Select

#### Data binding

In below example, the `Select` data will be bound to the "customerName" column of dataStore "customer".

```
<?php
\koolreport\inputs\Select::create(array(
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customer"),
    "dataBind"=>"customerName",
));
?>
```

#### Bind text and value

Sometime you need the text and value be different, you can bind text and value to two different columns of dataStore.

```
<?php
\koolreport\inputs\Select::create(array(
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customer"),
    "dataBind"=>array("text"=>"customerName","value"=>"customerId"),
));
?>
```

#### Adding default option

Sometime you will need to add default option at the beginning of the select, you can use the option `defaultOption`. The defaultOption will be an associate array `array(text=>value)`.

```
<?php
\koolreport\inputs\Select::create(array(
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customer"),
    "dataBind"=>array("text"=>"customerName","value"=>"customerId"),
    "defaultOption"=>array("--"=>""),
));
?>
```

#### Not use data-binding

If you have pre-defined set of options, you may not need to use data binding. You can set options with `data` properties

```
<?php
\koolreport\inputs\Select::create(array(
    "name"=>"customer",
    "data"=>array(
        "John Doe"=>"1",
        "Jane Doe"=>"2",
        "Whatever Doe"=>"3",
    )    
));
?>
```

### Setting css class

You can easily set the css class or css style with `attributes` property.

```
<?php
\koolreport\inputs\Select::create(array(
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customer"),
    "dataBind"=>array("text"=>"customerName","value"=>"customerId"),
    "attributes"=>array(
        "class"=>"form-control",
        "style"=>"margin-top:10px;"
    )
));
?>
```

#### Client Events

TextBox supports all client events such as `focus`, `blur`, `change`, `mouseover`, `mouseout`.

```
<?php
\koolreport\inputs\Select::create(array(
    ...
    "clientEvents"=>array(
        "change"=>"function(){
            console.log($(this).val());
        }",
    )
));
?>
```


### MultiSelect

`MultiSelect` is actually `Select` but have ability to select multiple options at once. You can also set the `size` which is how many options to be visible.

```
<?php
\koolreport\inputs\MultiSelect::create(array(
    "name"=>"customer",
    "dataStore"=>$this->dataStore("customer"),
    "dataBind"=>array("text"=>"customerName","value"=>"customerId"),
    "attributes"=>array(
        "size"=>10,
    )
));
?>
```

The `value` returned from MultiSelect is an `array()` containing list of selected values.


#### Client Events

TextBox supports all client events such as `focus`, `blur`, `change`, `mouseover`, `mouseout`.

```
<?php
\koolreport\inputs\Select::create(array(
    ...
    "clientEvents"=>array(
        "change"=>"function(){
            console.log($(this).val());
        }",
    )
));
?>
```


### DateRangePicker

`DateRangePicker` helps us to pick a range of dates.

```
<?php
DateRangePicker::create(array(
    "name"=>"dateRange",
));
?>
```

#### Set locale

DateRangePicker has ability to set locale:

```
<?php
DateRangePicker::create(array(
    "name"=>"dateRange",
    "locale"=>"en-us",
));
?>
```

#### Set format date

We can set the display format of DateRangePicker

```
<?php
DateRangePicker::create(array(
    "name"=>"dateRange",
    "format"=>"MMM Do, YYYY", //Jul 3rd, 2017
));
?>
```

The full input of `format` can be found here:

|               |Token      |Output                         |
|---------------|-----------|-------------------------------|
|Month          |M          |1 2 ... 11 12|
|               |Mo         |1st 2nd ... 11th 12th|
|               |MM         |01 02 ... 11 12|
|               |MMM        |Jan Feb ... Nov Dec|
|               |MMMM       |January February ... November December|
|Quarter        |Q          |1 2 3 4|
|               |Qo         |1 2 3 4|
|Day of Month   |D          |1 2 ... 30 31|
|               |Do         |1 2 ... 30 31|
|               |DD         |01 02 ... 30 31|
|Day of Year    |DDD        |1 2 ... 364 365|
|               |DDDo       |1st 2nd ... 364th 365th|
|               |DDDD       |001 002 ... 364 365|
|Day of Week    |d          |0 1 ... 5 6|
|               |do         |0th 1st ... 5th 6th|
|               |dd         |Su Mo ... Fr Sa|
|               |ddd        |Sun Mon ... Fri Sat|
|               |dddd       |Sunday Monday ... Friday Saturday|
|Day of Week (Locale)   |e  |0 1 ... 5 6|
|Day of Week (ISO)      |E  |1 2 ... 6 7|
|Week of Year   |w          |1 2 ... 52 53|
|               |wo         |1st 2nd ... 52nd 53rd|
|               |ww         |01 02 ... 52 53|
|Week of Year (ISO)     |W  |1 2 ... 52 53|
|Week of Year   |w          |1 2 ... 52 53|
|               |wo         |1st 2nd ... 52nd 53rd|
|               |ww         |01 02 ... 52 53|
|Year           |YY         |70 71 ... 29 30|
|               |YYYY       |1970 1971 ... 2029 2030|
|               |Y          |1970 1971 ... 9999 +10000 +10001|
|Week Year      |gg         |70 71 ... 29 30|
|               |gggg       |1970 1971 ... 2029 2030|
|Week Year (ISO)|GG         |70 71 ... 29 30|
|               |GGGG       |1970 1971 ... 2029 2030|
|AM/PM          |A          |AM PM|
|               |a          |am pm|
|Hour           |H          |0 1 ... 22 23|
|               |HH         |00 01 ... 22 23|
|               |h          |1 2 ... 11 12|
|               |hh         |01 02 ... 11 12|
|               |k          |1 2 ... 23 24|
|               |kk         |	01 02 ... 23 24|
|Minute         |m          |0 1 ... 58 59|
|               |mm         |00 01 ... 58 59|
|Second         |s          |0 1 ... 58 59|
|               |ss         |00 01 ... 58 59|
|Fractional Second  |S      |0 1 ... 8 9|
|                   |SS     |00 01 ... 98 99|
|                   |SSS    |000 001 ... 998 999|
|Time Zone      |z or zz    |EST CST ... MST PST|
|               |Z          |-07:00 -06:00 ... +06:00 +07:00|
|               |ZZ         |-0700 -0600 ... +0600 +0700|
|Unix Timestamp |X          |1360013296|
|Unix Millisecond Timestamp |x  |1360013296123|

#### Set ranges

```
<?php
DateRangePicker::create(array(
    "name"=>"dateRange",
    "format"=>"MMM Do, YYYY", //Jul 3rd, 2017
    "ranges"=>array(
        "Today"=>DateRangePicker::today(),
        "Yesterday"=>DateRangePicker::yesterday(),
        "Last 7 days"=>DateRangePicker::last7days(),
        "Last 30 days"=>DateRangePicker::last30days(),
        "This month"=>DateRangePicker::thisMonth(),
        "Last month"=>DateRangePicker::lastMonth(),
    )
));
?>
```

Above are all of ranges that `DateRangePicker` supports. You can create custom function to return custom startDate and endDate.

#### Client Events

`DateRangePicker` supports below events

|name|parameters|description|
|---|---|---|
|`hide`|e={date}|Fired when the widget is hidden.|
|`show`||Fired when the widget is shown.|
|`change`|e={date,oldDate}|Fired when the date is changed.|
|`error`|e={date}|Fired when a selected date fails to pass validation.|
|`update`|e={change,viewDate}|Fired (in most cases) when the `viewDate` changes. E.g. Next and Previous buttons, selecting a year.|

```
<?php
DateRangePicker::create(array(
    ...
    "clientEvents"=>array(
        "change"=>"function(e){
            console.log(e.date);
            console.log(e.oldDate);
        }",
    )
));
?>
```


### DateTimePicker

`DateTimePicker` helps you to pick a single date and time.

```
<?php
DateTimePicker::create(array(
    "name"=>"dueDate",
))
?>
```

#### Set locale

```
<?php
DateTimePicker::create(array(
    "name"=>"dueDate",
    "locale"=>"it", //Italy
))
?>
```
#### Set format

Please refer to `format` settings of `DateRangePicker`.

```
<?php
DateTimePicker::create(array(
    "name"=>"dueDate",
    "format"=>"MM/DD/YYYY", //Italy
))
?>
```

#### Set icon

By default, `DateTimePicker` use the calendar icon on the right.To disable icon, you do:

```
<?php
DateTimePicker::create(array(
    "name"=>"dueDate",
    "icon"=>false
))
?>
```

If you want to change to another icon, you do:

```
<?php
DateTimePicker::create(array(
    "name"=>"dueDate",
    "icon"=>"glyphicon glyphicon-time"
))
?>
```

#### Set disabled dates

Sometime you will need to prevent selection on some specical date

```
<?php
DateTimePicker::create(array(
    "name"=>"dueDate",
    "disabledDates'=>array(
        "2017-12-12"
    )
))
?>
```

#### Set min date

The `DateTimePicker` will disable selection on those days before the min set date.

```
<?php
DateTimePicker::create(array(
    "name"=>"dueDate",
    "minDate"=>"2017-06-28"
))
?>
```

#### Set max date

The `DateTimePicker` will not allow user to pick those dates after set max date.

```
<?php
DateTimePicker::create(array(
    "name"=>"dueDate",
    "maxDate"=>"2017-06-28"
))
?>
```

#### Link two pickers

Manytimes, you need to get selection [from,to] date range. the `fromDate` will allow only dates that before the date set nu `to` date.

```
<?php
DateTimePicker::create(array(
    "name"=>"fromDate",
    "maxDate"=>"@toDate"
))
?>
DateTimePicker::create(array(
    "name"=>"toDate",
    "minDate"=>"@fromDate"
))
?>
```

#### Client events

`DateTimePicker` supports following events:

|name|description|
|---|---|---|
|`show`|Triggered when the picker is shown|
|`hide`|Triggered when the picker is hidden|
|`showCalendar`|Triggered when the calendar(s) are shown|
|`hideCalendar`|Triggered when the calendar(s) are hidden|
|`apply`|Triggered when the apply button is clicked, or when a predefined range is clicked|
|`cancel`|Triggered when the cancel button is clicked|


```
<?php
DateTimePicker::create(array(
    ...
    "clientEvents"=>array(
        "apply"=>"function(e,picker){
            console.log(picker);
        }",
    )
));
?>
```


#### Options

`DateTimePicker` still have many options to set, you may view the full list in [here](https://eonasdan.github.io/bootstrap-datetimepicker/Options/). If we need to add some more customization, we can add those to `options`.

```
<?php
DateTimePicker::create(array(
    "name"=>"dueDate",
    "options"=>array(
        "enabledDates'=>array('2017-4-22','2017-4-23','2017-4-25')
    )
))
?>
```

### Select2

`Select2` is a great UI control to replace the normal select box. It gives you a customizable select box with support for searching, tagging, remote data sets, infinite scrolling, and many other highly used options. [View examples of Select2](https://select2.github.io/examples.html).

To use `Select2` in KoolReport, you do:

```
<?php
Select2::create(array(
    'name'=>"my_select2",
    "placeholder"=>"Select customer",
    "dataStore"=>$this->dataStore("customers"),
    "dataBind"=>array(
        "text"=>"customerName",
        "value"=>"customerId",
    ),
));
?>
```

#### Use manual data inputs

If you do not want to use dataBinding, you can input select options manually.

```
<?php
Select2::create(array(
    'name'=>"my_select2",
    "placeholder"=>"Select customer",
    "data"=>array(
        "John Doe"=>"1",
        "Jane Doe"=>"2",
        "Whatever Doe"=>"3",
    )    

));
?>
```

#### Multiple selection in Select2

Select2 support multiple selection. View the [multiple selection example](https://select2.github.io/examples.html#multiple). To enable the multi-select feature of Select2 in KoolReport, you do:



```
<?php
Select2::create(array(
    'name'=>"my_select2",
    "multiple"=>true,
    "placeholder"=>"Select customers",
    "dataStore"=>$this->dataStore("customers"),
    "dataBind"=>array(
        "text"=>"customerName",
        "value"=>"customerId",
    ),
));
?>
```

#### Client events

`Select2` supports following events:

|name|description|
|---|---|
|`change`|Triggered whenever an option is selected or removed.|
|`change.select2`|Scoped version of `change`|
|`select2:closing`|Triggered before the dropdown is closed. This event can be prevented.|
|`select2:close`|Triggered whenever the dropdown is closed. select2:closing is fired before this and can be prevented.|
|`select2:opening`|	Triggered before the dropdown is opened. This event can be prevented.s|
|`select2:open`|Triggered whenever the dropdown is opened. select2:opening is fired before this and can be prevented.|
|`select2:selecting`|Triggered before a result is selected. This event can be prevented.s|
|`select2:select`|Triggered whenever a result is selected. select2:selecting is fired before this and can be prevented.|
|`select2:unselecting`|Triggered before a selection is removed. This event can be prevented.|
|`select2:unselect`|Triggered whenever a selection is removed. select2:unselecting is fired before this and can be prevented.|

```
<?php
Select2::create(array(
    ...
    "clientEvents"=>array(
        "change"=>"function(e){
            \\Do something
        }",
    )
));
?>
```

### BSelect

`BSelect` is new widget in Inputs control. The letter B stands for "Bootstrap".
You may find the original BSelect control [here](http://davidstutz.github.io/bootstrap-multiselect/).

To use BSelect, you do:

```
<?php
BSelect::create(array(
    'name'=>"my_select",
    "placeholder"=>"Select customer",
    "dataStore"=>$this->dataStore("customers"),
    "dataBind"=>array(
        "text"=>"customerName",
        "value"=>"customerId",
    ),
));
?>
```

#### Manual data input

The same with other controls, BSelect support manual data input

```
<?php
BSelect::create(array(
    'name'=>"my_select",
    "placeholder"=>"Select customer",
    "data"=>array(
        "John Doe"=>"1",
        "Jane Doe"=>"2",
        "Whatever Doe"=>"3",
    )    

));
?>
```

#### Multiselect in BSelect

To enable multi select feature in BSelect, you do:

```
<?php
BSelect::create(array(
    'name'=>"my_select",
    "multiple"=>true,
    "placeholder"=>"Select customer",
    "dataStore"=>$this->dataStore("customers"),
    "dataBind"=>array(
        "text"=>"customerName",
        "value"=>"customerId",
    ),
));
?>
```

#### Other options for BSelect

`BSelect` support all original settings, you may use the `"options"` to set other settings for BSelect

```
<?php
BSelect::create(array(
    ...
    "options"=>array(
        "dropUp"=>true,
        ...
    ), 
));
?>
```

Here are [full list of options for BSelect](http://davidstutz.github.io/bootstrap-multiselect/#configuration-options) that you can set.

#### Client events

`BSelect` supports below events:

|name|description|
|---|---|
|`onDropdownShow`|A callback called when the dropdown is shown.|
|`onDropdownHide`|A callback called when the dropdown is closed.s|
|`onDropdownShown`|A callback called after the dropdown has been shown.|
|`onDropdownHidden`|A callback called after the dropdown has been closed.|

```
<?php
BSelect::create(array(
    ...
    "clientEvents"=>array(
        "onDropdownShow"=>"function(){
            //Do something
        }",
    ), 
));
?>
```



### RangeSlider

`RangeSlider` is a nice control to set the range of numeric values or datetime.
Just have a look at [original range slider](https://refreshless.com/nouislider/).
To use the RangeSlider widget in KoolReport, you do:

```
RangeSlider::create(array(
    "name"=>"myRangeSlider",
    "handles"=>1,
    "length"=>"200px",
    "ranges"=>array(
        "min"=>0,
        "max"=>100,
    ),
    "step"=>10,
));
```

#### Properties

|name|type|default|description|
|---|---|---|---|
|name|string||Name of widget, this is required.|
|handles|number|1|The number of handles you want to have in slider|
|ranges|array||Ranges of the sliders|
|step|number||The step on your slider|
|rtl|bool|false|Set to `true` if you want right to left direction|
|vertical|bool|false|Set to `true` you make the slider vertical|
|connect|bool|true|By default, the handles are connected together|
|scale|number||Show the scale/ruler, and the number put into scale is the density|
|length|string||The length of range slider|
|format|array||Here you can insert format for number, it is associate array of `decimals`,`prefix` and `suffix`. You may see below example for more details|


#### Non-linear ranges

You may set the non-linear ranges base on percentage

```
RangeSlider::create(array(
    "name"=>"myRangeSlider",
    "handles"=>1,
    "length"=>"200px",
    "ranges"=>array(
        "min"=>0,
        "10%"=>500,
        "50%"=>4000,
        "max"=>10000,
    ),
    "step"=>10,
));
```

#### Showing scale

```
RangeSlider::create(array(
    "name"=>"myRangeSlider",
    "handles"=>1,
    "length"=>"200px",
    "ranges"=>array(
        "min"=>0,
        "max"=>100,
    ),
    "scale"=>3,
    "step"=>10,
));
```

#### Format number

```
RangeSlider::create(array(
    ...
    "format"=>array(
        "prefix"=>"$",
        "decimals"=>2,
    )
));
```

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.