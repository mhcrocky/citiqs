# Introduction

A pivot table is a data summarization tool necessary in pretty much any data analytical program. It can count, total or average data based on multi dimensional groups to provide insight from raw data. Basically, a pivot table has two parts, one is multi-dimensional labels or headers, the other is aggregated or summarized data for such labels. Here is an example:

![Pivot table](https://www.koolreport.com/assets/images/editor/c1/image59226badb037b.jpg)

The above example is a two dimensional (column and row) pivot table which is visualized by the columns' and rows' label/header and the summarized data (total sum in this case) of them. Each dimension can consist of multiple fields (Year and Month in column, Customer and Product in row) so you could drill down (like expanding) or roll up (like collapsing) the labels and their summarized data.

# Installation

1. Download and unzip the zipped file.
2. Copy the folder `pivot` into `koolreport/packages` folder

# Usage

Our Pivot package contains a Pivot process for creating up a pivot table's structure. Then you could use a PivotTable or PivotMatrix widget to visualize it or extract a normal tabular data structure with PivotExtract process.

To set up a Pivot process, you would have to specify at least one dimension of label fields and a list of data fields (e.g dollar_sales) with aggregation methods (sum, count or average). In theory, a pivot could have multiple dimensions. In practice, users often set up one or two dimensions for easier viewing. The pivot process would aggregate data and save the result to a dataStore:

```
<?php
use \koolreport\pivot\processes\Pivot;

class CustomersCategoriesProducts extends koolreport\KoolReport
{
    function setup()
    {
        $node = $this->src('sales')
        ->query("SELECT customerName, productLine, orderYear, orderMonth, dollar_sales
        FROM customer_product_dollarsales")
        ->pipe(new Pivot(array(
        "dimensions" => array(
            "column" => "orderYear, orderMonth",
            "row" => "customerName, productLine"
        ),
        "aggregates"=>array(
            "sum" => "dollar_sales",
            "count" => "dollar_sales"
        )
        )))
        ->pipe($this->dataStore('salesReport'));  
    }
}
```

If you only want to use a part of the pivot data, there's a process called PivotExtract allowing you to extract a data table and save it to a datastore:

```
<?php
use \koolreport\pivot\processes\Pivot;
use \koolreport\pivot\processes\PivotExtract;

class CustomersCategoriesProducts extends koolreport\KoolReport
{
  function setup()
  {
    $node = $this->src('sales')
    ->query("SELECT customerName, productLine, orderYear, orderMonth, dollar_sales
    FROM customer_product_dollarsales")
    ->pipe(new Pivot(array(
        "dimensions" => array(
            "column" => "orderYear, orderMonth",
            "row" => "customerName, productLine"
        ),
        "aggregates"=>array(
            "sum" => "dollar_sales",
            "count" => "dollar_sales"
        )
    )))
    ->pipe(new PivotExtract(array(
        "row" => array(
            "parent" => array(
                "customerName" => "AV Stores, Co."
            ),
            "sort" => array(
                'dollar_sales - sum' => 'desc',
            ),
        ),
        "column" => array(
            "parent" => array(
                "orderYear" => "2004"
            ),
            "sort" => array(
                'orderMonth' => function($a, $b) {
                    return (int)$a < (int)$b;
                },
            ),
        ),
        "measures"=>array(
            "dollar_sales - sum", 
            "dollar_sales - count", 
        ),
    )))
    ->pipe($this->dataStore('salesTable'));  
  }
}
```

In the report view, you can use a PivotTable or a PivotMatrix widgets to visualize the labels and the summarized data in the dataStore. While the PivotTable widget is a simple table for just viewing the data, the PivotMarix one is a interactive widget where you can drag and drop fields, sort by data fields or label fields, has paging and scrolling for viewing a lot of data in a fixed size widget.

```
<?php
use \koolreport\pivot\widgets\PivotTable;
PivotTable::create(array(
    "dataStore"=>$this->dataStore('salesReport')
));

use \koolreport\pivot\widgets\PivotMatrix;
PivotMatrix::create(array(
    "dataStore"=>$this->dataStore('salesReport')
));
```

For the simplest configuration you only need to tell which pivot dataStore to be displayed, the widgets would use a default setup to show it. For finer tuning the widgets have detailed options for you to customize.

# Documentation

## Pivot process

### Dimensions

Even though a pivot process can handle more than two dimension, a PivotTable or PivotMatrix widget can only show at most two dimensions at once. By default, the two dimensions to be display are "row" and "column" but you could change them according to your setup. For example, when setting up a Pivot process:

```
<?php
class CustomersCategoriesProducts extends koolreport\KoolReport
{
    function setup()
    {
        ...
        ->pipe(new Pivot(array(
            "dimensions" => array(
                "row" => "orderYear, orderMonth",
                "column" => "customerName, productLine"
            ),
            "aggregates"=>array(
                "sum" => "dollar_sales",
            )
        )))
        ...
    }
}
```

Then when setting up a PivotTable or PivotMatrix widget:

```
<?php
PivotTable::create(array(
    "dataStore"=>$this->dataStore('salesReport'),
    'rowDimension'=>'row',
    'columnDimension'=>'column',
));

PivotMatrix::create(array(
    "dataStore"=>$this->dataStore('salesReport'),
    'rowDimension'=>'row',
    'columnDimension'=>'column',
));
```

### Aggregates

The Pivot process supports the following aggregating operators: sum, count, avt, min, max (version >= 1.0.0) and sum percent, count percent (version >= 4.1.0). When setting a Pivot process, you could add multiple fields for each operator like this:

```
<?php
class CustomersCategoriesProducts extends koolreport\KoolReport
{
    function setup()
    {
        ...
        ->pipe(new Pivot(array(
        ...
        "aggregates"=>array(
            "sum" => "dollar_sales",
            "sum percent" => "dollar_sales",
            "count" => "dollar_sales, order_id",
            "count percent" => "order_id",
        )
        )))
        ...
    }
}
```


## PivotExtract

A PivotExtract process could be used after a Pivot process to extract a data table.

```
<?php
class CustomersCategoriesProducts extends koolreport\KoolReport
{
    function setup()
    {
        ...
        ->pipe(new Pivot(array(
            ...
        )))
        ->pipe(new PivotExtract(array(
            "row" => array(
                "dimension" => "row",
                "parent" => array(
                    "customerName" => "AV Stores, Co."
                ),
                "sort" => array(
                    'dollar_sales - sum' => 'desc',
                ),
            ),
            "column" => array(
                "dimension" => "column",
                "parent" => array(
                    "orderYear" => "2004"
                ),
                "sort" => array(
                    'orderMonth' => function($a, $b) {
                        return (int)$a < (int)$b;
                    },
                ),
            ),
        )))
        ...
    }
}
```

### Dimension

Define the row and column dimensions when extracting after a Pivot process. By default, the row extract dimension is "row" and the column one is "column".

### Parent

Define the row and column parents of the extracted data table. For example, the above example will extract the table with rows including children of the customer "AV STores, Co." and columns including children of the year "2004".

### Sort

Define the sorting order of rows and columns of the extracted data table.

### Measures

Define the extracted measures of the data table.

## PivotTable and PivotMatrix widgets

### Templates

 A new template named Bun is added to both PivotTable and PivotMatrix since version 5.0.0. It is similar to Excel's PivotTable format which help reduce horizontal space when expanding  multiple row fields.

```
<?php
PivotTable::create(array(
    ...
    'template' => 'PivotTable-Bun',
    ...
));

PivotMatrix::create(array(
    ...
    'template' => 'PivotMatrix-Bun',
    ...
));
```

### Measures

By default, a pivot table/matrix widget shows all summarized data available in a dataStore. If you only want to show some of them, you could specify those in the measures property:

```
<?php
PivotTable::create(array(
    "dataStore"=>$this->dataStore('salesReport'),
    'measures'=>array(
        'dollar_sales - sum'
        'order_id - count'
    ),
));

PivotMatrix::create(array(
    "dataStore"=>$this->dataStore('salesReport'),
    'measures'=>array(
        'dollar_sales - sum'
        'order_id - count'
    ),
));
```
An aggregated field's name is formatted as '<field> - <operator>'.

### Sort

A pivot table/matrix could be sorted simultaneously in each of its dimension (e.g column and row). In each dimensional sort, you could specify either label fields or a summarized data field. Sorting order is either ascending, descending or a custom function comparing two values.

```
<?php
PivotTable::create(array(
  ...
    'rowSort' => array(
        'orderMonth' => function($a, $b) {
            return (int)$a < (int)$b;
        }, 
        'orderDay' => 'asc'
    ),
    'columnSort' => array(
        'dollar_sales - sum' => 'desc',
        'orderYear' => function($a, $b) {
            return (int)$a < (int)$b;
        }, 
    ),
  ...
));

PivotMatrix::create(array(
    ...
    'rowSort' => array(
        'orderMonth' => function($a, $b) {
            return (int)$a < (int)$b;
        }, 
        'orderDay' => 'asc'
    ),
    'columnSort' => array(
        'dollar_sales - sum' => 'desc',
        'orderYear' => function($a, $b) {
            return (int)$a < (int)$b;
        }, 
    ),
    ...
));
```

### Map

Mapping allows you an option to change displaying the data in dataStore. There are header map for headers/labels and data map for summarized data. The map could be either an array or a custom function with a value and its belonging field arguments.

#### headerMap and dataMap

```
<?php
PivotTable::create(array(
    ...
    'headerMap' => array(
        'dollar_sales - sum' => 'Sales (in USD)',
        'dollar_sales - count' => 'Number of Sales',
    ),
    'headerMap' => function($v, $f) {
        if ($v === 'dollar_sales - sum')
            $v = 'Sales (in USD)';
        if ($v === 'dollar_sales - count')
            $v = 'Number of Sales';
        if ($f === 'orderYear')
            $v = 'Year ' . $v;
        return $v;
    },
    'dataMap' => function($v, $f) {return $v;},
    ...
));
```

#### map (version >= 5.0.0)

These map options include a second parameter containing various information about the mapped fields, headers and data cells.

```
<?php
PivotMatrix::create(array(
    ...
    'map' => array(
        'rowField' => function($rowField, $fieldInfo) {
            return $rowField;
        },
        'columnField' => function($colField, $fieldInfo) {
            return $colField;
        },
        'dataField' => function($dataField, $fieldInfo) {
            $v = $dataField;
            if ($v === 'dollar_sales - sum')
                $v = 'Sales (in USD)';
            else if ($v === 'dollar_sales - count')
                $v = 'Number of Sales';
            return $v;
        },
        'waitingField' => function($waitingField, $fieldInfo) {
            return $waitingField;
        },
        'rowHeader' => function($rowHeader, $headerInfo) {
            $v = $rowHeader;
            if (isset($headerInfo['childOrder']))
                $v = $headerInfo['childOrder'] . ". " . $v;
            return $v;
        },
        'columnHeader' => function($colHeader, $headerInfo) {
            $v = $colHeader;
            if ($headerInfo['fieldName'] === 'orderYear')
                $v = 'Year-' . $v;
            else if ($headerInfo['fieldName'] === 'orderQuarter')
                $v = 'Quarter-' . $v;

            if (isset($headerInfo['childOrder']))
                $v = $headerInfo['childOrder'] . ". " . $v;
            return $v;
        },
        'dataHeader' => function($dataField, $fieldInfo) {
            $v = $dataField;
            return $v;
        },
        'dataCell' => function($value, $cellInfo) {
            $rfOrder = $cellInfo['row']['fieldOrder'];
            $cfOrder = $cellInfo['column']['fieldOrder'];
            $df = $cellInfo['fieldName'];
            $dfOrder = $cellInfo['fieldOrder'];
            return "$rfOrder:$cfOrder:$df. $value";
            
            return $cellInfo['formattedValue'];
        },
    ),
    ...
));
```
Example values of the information parameters:

```
    $fieldInfo = ["fieldOrder => 0];
    $headerInfo = [
        "childOrder"=> "2",
        "numChildren"=> 1,
        "numLeaf"=> 1,
        "fieldName"=> "customerName",
        "fieldOrder"=> 0
    ];
    $cellInfo = [
        "row"=> {
            "customerName"=> {
                "childOrder"=> "5",
                "numChildren"=> 1,
                "numLeaf"=> 1
            },
            "productLine"=> {
                "total"=> true,
                "numChildren"=> 1,
                "numLeaf"=> 1,
                "level"=> 2
            },
            "productName"=> {
                "total"=> true
            },
            "hasTotal"=> true,
            "fieldOrder"=> 0
        },
        "column"=> {
            "orderYear"=> {
                "childOrder"=> "4",
                "total"=> true,
                "numChildren"=> 2,
                "numLeaf"=> 2,
                "level"=> 4
            },
            "orderQuarter"=> {
                "total"=> true
            },
            "orderMonth"=> {
                "total"=> true
            },
            "orderDay"=> {
                "total"=> true
            },
            "hasTotal"=> true,
            "fieldOrder"=> -1
        },
        "fieldName"=> "dollar_sales - sum",
        "fieldOrder"=> 0,
        "formattedValue"=> "$82,223"
    ];
```

#### cssClass (version >= 6.0.0)

This property is similar to `map` but instead of mapping content, it adds css classes to PivotTable's and PivotMatrix's elements.

```
<?php
PivotMatrix::create(array(
    ...
    'cssClass' => array(
        'waitingField' => function($waitingField, $fieldInfo) {
            return 'wf-' . $waitingField;
        },
        'dataField' => function($dataField, $fieldInfo) {
            return 'df-' . $dataField;
        },
        'columnField' => function($columnField, $fieldInfo) {
            return 'cf-' . $columnField;
        },
        'rowField' => function($rowField, $fieldInfo) {
            return 'rf-' . $rowField;
        },
        'dataHeader' => function($dataField, $fieldInfo) {
            return 'dh-' . $dataField;
        },
        'columnHeader' => function($header, $headerInfo) {
            return 'ch-' . $header;
        },
        'rowHeader' => function($header, $headerInfo) {
            return 'rh-' . $header;
        },
        'dataCell' => function($value, $cellInfo) {
            return 'dc-' . $value;
        },
    ),
    ...
));
```

### Collapse level

If you have a large pivot table and don't want it to fully expand at initial loading you could set up its initial collapse levels for each dimension.

```
<?php
PivotTable::create(array(
    ...
    'rowCollapseLevels' => array(0),
    'columnCollapseLevels' => array(0, 1, 2),
    ...
));
```

### Total name

This property helps you change the label of the "total" rows and columns. By default it's "Total".

```
<?php
PivotTable::create(array(
    ...
    'totalName' => 'All',
    ...
));
```

### Hide total/subtotal column/row (version >=4.2.0)

These properties allows you to hide the grand total/sub total columns/rows:

```
<?php
PivotTable::create(array(
    ...
    'hideTotalRow' => true,
    'hideTotalColumn' => true,
    'hideSubtotalRow' => true,
    'hideSubtotalColumn' => true,
    ...
));
```

### Show data field headers (version >= 5.0.0)

By default, data field headers are turned off. Now you could show them above the data zone part for clearer information.

```
<?php
PivotTable::create(array(
    ...
    'showDataHeaders' => true,
    ...
));
```

### Width

This property let us defined the width css of the pivot table widget. Default value is 'auto'.

```
<?php
PivotTable::create(array(
    ...
        'width' => '100%',
    ...
));
```

### height

This property let us defined the width css of the pivot table widget. Default value is 'auto'.

```
<?php
PivotTable::create(array(
    ...
        'height' => '500px',
    ...
));
```

## PivotMatrix exclusive properties

The following properties only apply for the PivotMatrix widget

### paging

```
<?php
PivotMatrix::create(array(
  ...
    'paging' => array(
        'size' => 5,
        'maxDisplayedPages' => 5,
        'sizeSelect' => array(5, 10, 20, 50, 100)
    )
  ...
));
```

#### paging : size

Set the page size for a PivotMatrix widget. Type is integer, default value is 10 rows.

#### paging : maxDisplayedPages

Set the maximum number of displayed pages in the paging area. Type is integer,default values is 5 displayed pages.

#### paging : sizeSelect

Set the page size select options for the paging. Type is array of integer, default values is array(5, 10, 20, 50, 100).

### columnWidth

Set the column width of the data table. Default value is '70px'.

# Working examples

[Click here to view pivot examples](https://www.koolreport.com/examples/#pivot).

Enjoy!

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.