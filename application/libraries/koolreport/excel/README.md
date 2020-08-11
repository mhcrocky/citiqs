# Introduction

`Excel` package helps you to work with Excel. It can help to pull data from Excel file as well as push data to Excel file. Underline of `ExcelDataSource` is the open-source library called `phpoffice/PHPExcel` which helps us to read various Excel version.

# Installation

1. Unzip folder
2. Copy the `excel` folder to `koolreport\packages`

# Documentation

## Get data from Excel (version >= 1.0.0)

`ExcelDataSource` helps you to get data from your current Microsoft Excel file.

### Settings

|Name|type|default|description|
|----|---|---|---|
|class|string||	Must set to '\koolreport\datasources\ExcelDataSource'|
|filePath|string||The full file path to your Excel file.|
|charset|string|`"utf8"`|Charset of your Excel file|
|firstRowData|boolean|`false`|Whether the first row is data. Normally the first row contain the field name so default value of this property is false.|
|sheetName|string|null|Set a sheet name to load instead of all sheets. (version >= 2.1.0)|
|sheetIndex|number|null|Set a sheet index to load instead of all sheets. If both sheetName and sheetIndex are set, priority is given to sheetName first.  (version >= 2.1.0)|

### Example

```
class MyReport extends \koolreport\KoolReport
{
    public function settings()
    {
        return array(
            "dataSources"=>array(
                "sale_source"=>array(
                    "class"=>"\koolreport\excel\ExcelDataSource",
                    "filePath"=>"../data/my_file.xlsx",
                    "charset"=>"utf8",
                    "firstRowData"=>false,//Set true if first row is data and not the header,
                    "sheetName"=>"sheet1", // (version >= 2.1.0)
                    "sheetIndex"=>0, // (version >= 2.1.0)
                )
            )
        );
    }

    public function setup()
    {
        $this->src('sale_source')
        ->pipe(...)
    }
}

```

## Get data from huge xlsx, ods and csv files (version >= 7.0.0)

`BigSpreadsheetDataSource` helps you to get data from huge spreadsheet files of type xlsx, ods or csv.

### Settings

|Name|type|default|description|
|----|---|---|---|
|class|string||	Must set to '\koolreport\datasources\BigSpreadsheetDataSource'|
|filePath|string||The full file path to your spreadsheet file.|
|fileType|string||"xlsx", "ods" or "csv". Only needed if file extension is different from its type.|
|charset|string|`"utf8"`|Charset of your spreadsheet file|
|firstRowData|boolean|`false`|Whether the first row is data. Normally the first row contain the field name so default value of this property is false.|
|fieldSeparator|string|`,`|Used for setting a csv file's delimiter|
|sheetName|string|null|Set a sheet name to load instead of all sheets. Not applicable for csv files.|
|sheetIndex|number|null|Set a sheet index to load instead of all sheets. If both sheetName and sheetIndex are set, priority is given to sheetName first. Not applicable for csv files.|

### Example

```
class MyReport extends \koolreport\KoolReport
{
    public function settings()
    {
        return array(
            "dataSources"=>array(
                "sale_source"=>array(
                    "class"=>"\koolreport\excel\BigSpreadsheetDataSource",
                    "filePath"=>"../data/my_file.xlsx",
                    "firstRowData"=>false,//Set true if first row is data and not the header,
                    "sheetName"=>"sheet1",
                    "sheetIndex"=>0,
                )
            )
        );
    }

    public function setup()
    {
        $this->src('sale_source')
        ->pipe(...)
    }
}

```

## Export to Excel (version >= 1.0.0)

To use the export feature in report, you need to register the `ExcelExportable` in your report like below code

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\excel\ExcelExportable;
    ...
}
```

Then now you can export your report to excel like this:

```
<?php
$report = new MyReport;
$report->run()->exportToExcel()->toBrowser("myreport.xlsx");
```

### General exporting options

When exporting to excel, you could set a number of property for the excel file.

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(array(
    "properties" => array(
        "creator" => "",
        "title" => "",
        "description" => "",
        "subject" => "",
        "keywords" => "",
        "category" => "",
    )
))->toBrowser("myreport.xlsx");
```

### Normal Excel exporting options (version >= 3.0.0)

Defines datastores for exporting:

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(array(
    "dataStores" => array(
        'salesReport' => array(
            "columns"=>array(
                0, 1, 2, 'column3', 'column4' //if not specifying, all columns are exported
            )
        )
    )
))->toBrowser("myreport.xlsx");
```

### Pivot excel exporting options 

Beside general options, when exporting a pivot data store you could set several options similar to when viewing a pivot table widget.

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(array(
    "dataStores" => array(
        'salesReport' => array(
            'rowDimension' => 'column',
            'columnDimension' => 'row',
            "measures"=>array(
                "dollar_sales - sum", 
            )
        )
    )
))->toBrowser("myreport.xlsx");
```

## Excel export template (version >= 6.0.0)

You could programmatically set up a template file for excel export similar to a report's view file.

```
<?php
//exportExcel.php
include "MyReport.php";
$report = new MyReport;
$report->run();
$report->exportToExcel('MyReportExcel')->toBrowser("MyReport.xls");
```

```
<?php
//MyReportExcel.view.php
<?php
    use \koolreport\excel\Table;
    use \koolreport\excel\PivotTable;
    use \koolreport\excel\BarChart;
    use \koolreport\excel\LineChart;
?>
<div sheet-name="<?php echo $sheetName; ?>">
    <div cell="A1">
        <?php echo $reportName; ?>
    </div>
    <div>
        <?php
        Table::create(array(
            "dataSource" => $this->dataStore('orders'),
        ));
        ?>
    </div>
    <div range="A25:H45">
        <?php
        LineChart::create(array(
            "dataSource" => $this->dataStore('salesQuarterProduct'),
        ));
        ?>
    </div>
    <div>
        <?php
        PivotTable::create(array(
            "dataSource" => 'salesPivot',
        ));
        ?>
    </div>
</div>
```

To use an excel export template file, pass its name (without the extension '.view.php') to the exportToExcel() method.

In the template file, have access to your report via $this as well as its parameters $this->params and datastore $this->datastore().

The template file consists of 2 level of div tags. Each first level div represents a separated excel worksheet.

```
<div sheet-name="sheet1">
</div>
```

Second level divs represents blocks of content in each worksheet. A block of content could be some text, a table, a chart, a pivot table. Each block of content could have its top-left cell set via the div's `cell` attribute or its range set via the div's `range` attribute. The range attribute would work for text and chart and for neither table nor pivot table.

 
```
<div sheet-name="sheet1">
    <div cell="A1" range="A1:E1">
        <?php echo $reportName; ?>
    </div>
</div>
```

In the excel package, we have table, pivot table and chart widgets which are similar to the same name widgets in other packages of KoolReport. 

When setting a datasource for a widget, you could use either a datastore name or a datastore object of the your report. 

```
<?php
//MyReportExcel.view.php
<?php
    use \koolreport\excel\Table;
    use \koolreport\excel\PivotTable;
?>
<div sheet-name="sheet1">
    <div>
        <?php
        Table::create(array(
            "dataSource" => $this->dataStore('orders'),
        ));
        ?>
    </div>
    <div>
        <?php
        PivotTable::create(array(
            "dataSource" => 'salesPivot',
        ));
        ?>
    </div>
</div>
```

With chart widget, there's another property called "excelDataSource" which could be set to be the name of a table widget in the template. In this case data for the chart would be drawn from the table widget instead of from a datastore.

```
<?php
//MyReportExcel.view.php
<?php
    use \koolreport\excel\Table;
    use \koolreport\excel\BarChart;
?>
<div sheet-name="<?php echo $sheetName; ?>">
    <div range="A25:H45">
        <?php
        Table::create(array(
            "name" => "customerSales",
            "dataSource" => $this->dataStore('sales'),
        ));
        ?>
    </div>
    <div range="A25:H45">
        <?php
        BarChart::create(array(
            'excelDataSource' => 'customerSales', 
        ));
        ?>
    </div>
</div>
```

### Excel style array

For some elements in the template file you could set their excel style. A style array can dictate some main excel styles: 

```
<?php
    $styleArray = [
        'font' => [
            'name' => 'Calibri', //'Verdana', 'Arial'
            'size' => 30,
            'bold' => false,
            'italic' => FALSE,
            'underline' => 'none', //'double', 'doubleAccounting', 'single', 'singleAccounting'
            'strikethrough' => FALSE,
            'superscript' => false,
            'subscript' => false,
            'color' => [
                'rgb' => '000000',
                'argb' => 'FF000000',
            ]
        ],
        'alignment' => [
            'horizontal' => 'general',//left, right, center, centerContinuous, justify, fill, distributed
            'vertical' => 'bottom',//top, center, justify, distributed
            'textRotation' => 0,
            'wrapText' => false,
            'shrinkToFit' => false,
            'indent' => 0,
            'readOrder' => 0,
        ],
        'borders' => [
            'top' => [
                'borderStyle' => 'none', //dashDot, dashDotDot, dashed, dotted, double, hair, medium, mediumDashDot, mediumDashDotDot, mediumDashed, slantDashDot, thick, thin
                'color' => [
                    'rgb' => '808080',
                    'argb' => 'FF808080',
                ]
            ],
            //left, right, bottom, diagonal, allBorders, outline, inside, vertical, horizontal
        ],
        'fill' => [
            'fillType' => 'none', //'solid', 'linear', 'path', 'darkDown', 'darkGray', 'darkGrid', 'darkHorizontal', 'darkTrellis', 'darkUp', 'darkVertical', 'gray0625', 'gray125', 'lightDown', 'lightGray', 'lightGrid', 'lightHorizontal', 'lightTrellis', 'lightUp', 'lightVertical', 'mediumGray'
            'rotation' => 90,
            'color' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'startColor' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'endColor' => [
                'argb' => 'FFFFFF',
                'argb' => 'FFFFFFFF',
            ],
        ],
    ];
?>
```

## Export to huge xlsx, ods and csv files (version >= 7.0.0)

If you don't need chart or pivottable in your spreadsheet file, `BigSpreadsheetExportable` trait helps you to export huge data faster and uses much less memory than ExcelExportable or CSVExportable.

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\excel\BigSpreadsheetExportable;
    ...
}
```

Then now you can export your report to spreadsheet like this:

```
<?php
$report = new MyReport;
$report->run()
->exportToXLSX()
//->exportToODS()
//->exportToCSV()
->toBrowser("myreport.xlsx");
```

### Normal spreadsheeet exporting options

Defines datastores for exporting:

```
<?php
$report = new MyReport;
$report->run()
->exportToXLSX(
//->exportToODS(
//->exportToCSV(
    array(
        "dataStores" => array(
            'salesReport' => array(
                "columns"=>array(
                    0, 1, 2, 'column3', 'column4' //if not specifying, all columns are exported
                )
            )
        )
    )
)->toBrowser("myreport.xlsx");
```

### Pivot spreadsheet exporting options 

Unfortunately, BigSpreadsheetExportable doesn't support Pivot datastore export because streaming data to file doesn't allow for complex cell structure.

## Spreadsheet export template

You could programmatically set up a template file for spreadsheet export similar to a report's view file.

```
<?php
//exportSpreadsheet.php
include "MyReport.php";
$report = new MyReport;
$report->run();
$report
->exportToXLSX(
//->exportToODS(
    'MyReportSpreadsheet', ['useLocalTempFolder' => true]
)
->toBrowser("MyReport.xlsx");

$report->exportToCSV(array(
    'dataStores' => array(
        'orders' => array(
            'columns' => array('Customer', 'Total', 0, 1),
        ),
    ),
    'BOM' => false,
    'fieldDelimiter' => ';',
    'useLocalTempFolder' => true,
))
->toBrowser("MyReport.csv");
```

```
<?php
//MyReportSpreadsheet.view.php
<?php
    use \koolreport\excel\Text;
    use \koolreport\excel\Table;
?>
<div sheet-name="<?php echo $sheetName; ?>">
    <div>
        Report <?php echo $reportName; ?>
    </div>

    <div translation="2:4">
        Text::create([
            "text" => "Orders List of Sales"
        ]);
    </div>

    <div translation="3:5">
        <?php
        Table::create(array(
            "dataSource" => $this->dataStore('orders'),
        ));
        ?>
    </div>
</div>
```

To use a spreadsheet export template file, pass its name (without the extension '.view.php') to the exportToXLSX(), exportToODS() or exportToCSV() method.

In the template file, have access to your report via $this as well as its parameters $this->params and datastore $this->datastore().

The template file consists of 2 level of div tags. Each first level div represents a separated worksheet (applicable for xlsx and ods files only).

```
<div sheet-name="sheet1">
</div>
```

Second level divs represents blocks of content in each worksheet. A block of content could be some text or a table. Each block of content could have its top-left cell set via the div's `translation` attribute. This attribute translates content by {number of columns}:{number of rows}.

 
```
<div sheet-name="sheet1">
    <div translation="2:4">
        Report <?php echo $reportName; ?>
    </div>
</div>
```

Unlike excel export, for big spreadsheet export we can only use the Table and Text widgets. It's because big spreadsheet utilizes streaming data to file to reduce memory footprint when exporting millions of data rows. This type of streaming rows doesn't allow for chart or pivot table formats.

When setting a datasource for a Table, you could use either a datastore name or a datastore object of the your report. 

```
<?php
//MyReportExcel.view.php
<?php
    use \koolreport\excel\Table;
?>
<div sheet-name="sheet1">
    <div>
        <?php
        Table::create(array(
            "dataSource" => $this->dataStore('orders'),
        ));
        ?>
    </div>
</div>
```

### Spreadsheet style array

For some elements in the template file you could set their spreadsheet style. A style array can dictate some main spreadsheet styles: 

```
<?php
    $spreadsheetStyleArray = [
        'font' => [
            'bold' => false,
            'italic' => true,
            'underline' => false,
            'strikethrough' => true,
            'name' => 'Arial',
            'size' => '14',
            'color' => '808080',
        ],
        'border' => [
            // 'color' => '000000',
            'width' => 'thick', //'thin', 'medium', 'thick'
            // 'style' => 'solid', //'none', 'solid', 'dashed', 'dotted', 'double'.
            'top' => [
                'color' => '000000',
                'width' => 'medium', //'thin', 'medium', 'thick'
                'style' => 'solid', //'none', 'solid', 'dashed', 'dotted', 'double'.
            ],
            'right' => [],
            'bottom' => [],
            'left' => [],
        ],
        'backgroundColor' => '00ff00',
        'wrapText' => true,
    ];;


?>
```

## Text widget (version >= 6.0.0)

Using an Excel's Text widget for exporting text content together with some properties. This widget works in both Excel and spreadsheet template files.

```
<div>
    <?php
    \koolreport\excel\Text::create([
        "text" => "Orders",
        "excelStyle" => $styleArray,//used in ExcelExportable's template
        "spreadsheetStyle" => $spreadsheetStyleArray // used in ExcelExportable's template
    ]);
    ?>    
</div>
```

### `Text` 
A string to define the displayed text value. This widget works in both Excel and spreadsheet template files.

### `excelStyle` 
A style array to define style of the text cell when using ExcelExportable

### `spreadsheetStyle` (version >= 7.0.0)
A style array to define style of the text cell when using BigSpreadsheetExportable


## Table widget (version >= 6.0.0)

Using an Excel's Table widget for exporting a table using a datasource and other properties. This widget works in both Excel and spreadsheet template files.

```
<div>
    <?php
    \koolreport\excel\Table::create(array(
        "dataSource" => 'orders',
        //"dataSource" => $this->dataStore('orders'),
        
        "filtering" => function($row, $index) { 
            if (stripos($row['customerName'], "Baane Mini Imports") !== false)
                return false;
            return true;
        },
        //"filtering" => ['age','between',45,65],

        "sorting" => ['dollar_sales' => function($a, $b) {
            return $a >= $b;
        }],
        //"sorting" => ['dollar_sales' => 'desc'],

        "paging" => [5, 2],

        "showHeader" => false, //default: true

        "showBottomHeader" => true, //default: false

        "showFooter" => true, //default: false

        "map" => [
            "header" => function($colName) { return $colName; },
            "bottomHeader" => function($colName) { return $colName; },
            "cell" => function($colName, $value, $row) { return $value; },
            "footer" => function($colName, $footerValue) { return $footerValue; },
        ],

        "excelStyle" => [ //used in ExcelExportable's template
            "header" => function($colName) { 
                return $styleArray; 
            },
            "bottomHeader" => function($colName) { return []; },
            "cell" => function($colName, $value, $row) { 
                return $styleArray; 
            },
            "footer" => function($colName, $footerValue) { return []; },
        ],

        "spreadsheetStyle" => [ //used in BigSpreadsheetExportable's template
            "header" => function($colName) { 
                return $styleArray; 
            },
            "bottomHeader" => function($colName) { return []; },
            "cell" => function($colName, $value, $row) { 
                return $styleArray; 
            },
            "footer" => function($colName, $footerValue) { return []; },
        ]
    ));
    ?>
</div>
```

### `filtering` 
Filtering data with either an array in the form of [field, operator, value1, ...] or a function returning true or false on a row. Inherit from a DataStore's filter method.

### `sorting` 
Sorting data with an array in the form of [[field1, direction1], ...] where direction is either "asc" or "desc" or a comparing function. Inherit from a DataStore's sort method.

### `paging` 
Paging data with an array in the form of [page size, page number]. Inherit from a DataStore's paging method.

### `showHeader`
A boolean value to either show or hide the table's header. Default value is true.

### `showBottomHeader`
A boolean value to either show or hide the table's bottom header. Default value is false.

### `showFooter`
A boolean value to either show or hide the table's footer which shows each column's footerText and/or aggregate method like "sum", "count", etc. The footer properties should be defined in the datastore's columns' metadata. Default value is false.

```
 ->pipe(new ColumnMeta(array(
    "amount"=>array(
        "name"=>"sale_amount"
        "footer"=>"sum",
        "footerText"=>"Total: @value",
    ),
 )))
```

### `map`
An array of functions returning string value to map the table's headers, bottom headers, footers and cells values

```
    "map" => [
        "header" => function($colName) { return $colName; },
        "bottomHeader" => function($colName) { return $colName; },
        "cell" => function($colName, $value, $row) { return $value; },
        "footer" => function($colName, $footerValue) { return $footerValue; },
    ],
```

### `excelStyle`

An array of functions returning excel style array to set the excel style of the table's headers, bottom headers, footers and cells when using ExcelExportable

```
    "excelStyle" => [
        "header" => function($colName) { 
            ...
            return $styleArray; 
        },
        "bottomHeader" => function($colName) { 
            ...
            return $styleArray; 
        },
        "cell" => function($colName, $value, $row) { 
            ...
            return $styleArray; 
        },
        "footer" => function($colName, $footerValue) { 
            ...
            return $styleArray;  
        },
    ]
```

### `spreadsheetStyle` (version >= 7.0.0)

An array of functions returning style array to set the style of the table's headers, bottom headers, footers and cells when using BigSpreadsheetExportable

```
    "spreadsheetStyle" => [
        "header" => function($colName) { 
            ...
            return $styleArray; 
        },
        "bottomHeader" => function($colName) { 
            ...
            return $styleArray; 
        },
        "cell" => function($colName, $value, $row) { 
            ...
            return $styleArray; 
        },
        "footer" => function($colName, $footerValue) { 
            ...
            return $styleArray;  
        },
    ]
```

## Chart widget (version >= 6.0.0)

Using an Excel's Chart widget for displaying a chart with several properties. This widget only works in Excel template and not in spreadsheet template.

### `dataSource`

Either a datastore name or a datastore to act as a chart's data

### `excelDataSource`

An excel table name to act as a chart's data

### `title`

A string to be set as a chart's title

### `xAxisTitle`

A string to be set as a chart's X axis title

### `yAxisTitle`

A string to be set as a chart's Y axis title

### `stacked`

A boolean indicating whether a chart's bars, columns should be stacked or not. Default value is false

### `direction`

An enum string ('horizontal' or 'vertical') indicating a chart's X, Y axes. Default value is 'vertical'

```
<div>
    <?php
    \koolreport\excel\Table::create(array(
        "name" => "TableOrders",
        "dataSource" => 'Orders',
    ));
</div>

<div range="A2:H2">
    \koolreport\excel\LineChart::create([
        "dataSource" => $this->dataStore('Orders'),
        "dataSource" => "Orders",
        "excelDataSource" => "TableOrders",
        'title' => 'Sales Orders',
        'xAxisTitle' => 'Orders List',
        'yAxisTitle' => 'Sales($)',
        'stacked' => true, //default: true
        'direction' => 'horizontal', //default: 'vertical'
    ]);
    ?>    
</div>
```

## PivotTable widget (version >= 6.0.0)

Using an Excel's PivotTable widget for exporting a pivot table with several properties. This Excel package's PivotTable shares most of the properties with Pivot package's PivotTable widget including: "dataSource", "rowDimension", "columnDimension", "measure", "rowSort", "columnSort", "hideSubTotalRows", "hideSubTotalColumns", "hideTotalRow", "hideTotalColumn", "hideGrandTotalRow", "hideGrandTotalColumn", "showDataHeaders", "map". One difference between Excel's PivotTable and Pivot's one is that the former replace the later's "cssClass" map with "excelStyle" map. This widget only works in Excel template and not in spreadsheet template.

### `excelStyle`

An array of functions returning excel style array for a PivotTable's dataFields zone, column headers, row headers and data cells.

```
<div range="A2:H2">
    <?php
    \koolreport\excel\PivotTable::create(array(
        "dataSource" => 'salesPivot',
        "rowDimension" => "row",
        "columnDimension" => "column",
        "measures"=>array(
            ...
        ),
        'rowSort' => array(
            ...
        ),
        'columnSort' => array(
            ...
        ),
        'hideTotalRow' => true,
        'hideTotalColumn' => true,
        'hideSubTotalRows' => true,
        'hideSubTotalColumns' => true,
        'showDataHeaders' => true,
        'map' => array(
            'rowField' => function($rowField, $fieldInfo) {
                return $rowField;
            },
            'columnField' => function($colField, $fieldInfo) {
                return $colField;
            },
            'dataField' => function($dataField, $fieldInfo) {
                $v = $dataField;
            },
            'waitingField' => function($waitingField, $fieldInfo) {
                return $waitingField;
            },
            'rowHeader' => function($rowHeader, $headerInfo) {
                $v = $rowHeader;
                return $v;
            },
            'columnHeader' => function($colHeader, $headerInfo) {
                $v = $colHeader;
                return $v;
            },
            'dataCell' => function($value, $cellInfo) {
                return $value;
            },
        ),
        'excelStyle' => array(
            "dataFields" => function($dataFields) {
                ...
                return $styleArray;
            },
            'columnHeader' => function($header, $headerInfo) {
                ...
                return $styleArray;
            },
            'rowHeader' => function($header, $headerInfo) {
                ...
                return $styleArray;
            },
            'dataCell' => function($value, $cellInfo) {                    
                ...
                return $styleArray;
            },
        )
    ));
    ?>    
</div>
```


## Export to CSV (version >= 3.0.0)

CSVExportable trait allows you to export datastores to CSV files. Alternatively, you could use BigSpreadsheetExportable trait which also has exportToCSV method and optimizes for huge export files.

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\excel\CSVExportable;
    // use \koolreport\excel\BigSpreadsheetExportable;
    ...
}
```

### CSV exporting options

`'fieldDelimiter'` or `'fieldSeparator'` option defines a string used to separate columns in the exported CSV file. Default value is a comma.
`'columns'` option is an array defining a list of columns in the exported CSV file. Values could be either column indexes, column keys or column labels. if not specified, all columns are exported. `"BOM"` parameter takes boolean value, default is `false`, BOM determine whether exported CSV will use UTF8 Bit Order Mark (BOM).

```
<?php
$report = new MyReport;
$report->run()->exportToCSV('salesReport', array(
    'delimiter' => ';',
    "columns"=>array(
        0, 1, 2, 'column3', 'column4'
    )
    "BOM"=>false,
))->toBrowser("myreport.csv");
```

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.
