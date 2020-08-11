# Introduction

One of the most important features in a reporting tools or framework is the ability to export report to other formats such as PDF. The exported file can be pushed to download from browser, attached to email or simply stored for later used.

For longtime, exporting HTML To PDF is quite difficult due to several reason. First, PDF is still behind browser in term of CSS supporting which makes modern version of CSS does not work in PDF like it does in browser. The same happens to HTML. Second, modern chart and graphs uses Javascript to render. Google Charts suite is a big example. That hinders the ability to include those beautiful charts into PDF.

This Export package solved those problems and more.


# Features

1. Exporting your HTML report to PDF and common image formats (JPG, PNG, BMP ..)
2. Fine-pixel printing report with different sizes: A3, A4, A5, Letter, Legal, Tabloid
3. PDF paging supported with customized repeated header and footer text in each page. The page number and total number of page are supported as well.
4. In-page Javascript supported. This means you can include any kind of modern charts such as Morris, D3, Sparkline. You name it, we support it!
5. Exported file can be save to local drive or can be pushed to browser for user to download.

# What can I do with this package?

1. Well, you can export your report and store for later usage.
2. You can export to PDF and attach it to email and send to key persons every week.
3. You can let user download your report in PDF or their preferred image file.
4. You can create invoice in familiar HTML, export it to PDF then send to your customer. That's professional!
5. There will be much more! We will update this list.

# Installation

1. Download the export package and unzip it.
2. Copy the folder `export` into folder `koolreport/packages`
3. Download PhantomJS execution file for operating system you are using:
    * Window: [phantomjs-2.1.1-windows.zip](https://www.koolreport.com/assets/download/phantomjs-2.1.1-windows.zip)
    * Linux: [phantomjs-2.1.1-linux.zip](https://www.koolreport.com/assets/download/phantomjs-2.1.1-linux.zip)
    * MacOs: [phantomjs-2.1.1-macosx.zip](https://www.koolreport.com/assets/download/phantomjs-2.1.1-macosx.zip)
4. Unzip and put the execution file into the `koolreport/packages/export/bin` folder

All done! Enjoy exporting your report with KoolReport now.

# Documentation

To enable Export feature in KoolReport, you do:

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\export\Exportable;
    ...
}
```

Now your MyReport has ability to export, in the run file(`index.php`), you do:

```
...
$report->run()->export()->pdf(array(
    "format"=>"A4",
    "orientation"=>"portrait"
))->toBrowser("myfile.pdf");
```

## Export a view

Sometime, you have a view for browser's display and another view for exporting. The separation make things simpler. Assume that you create a view called `AnotherViewForPDF.view.php`, you can do:

```
$report->run();
$report->export('AnotherViewForPDF')->...
```

## Export to PDF

We have several settings for PDF exporting which are

|name        |type         |default      |description                          |
|------------|-------------|-------------|-------------------------------------|
|margin |string/array|"0px"|The margin of the page, accepting unit in `px`,`cm` and `in`. The margin can be an `array` contains separated settings for `top`,`left`,`right`,`bottom`|
|width  |string|             |Width of the page                          |
|height |string|             |Height of the page|
|header|array||The header of PDF page, it is array containing `height` and `contents` parameters, for example `"header"=>array("height"=>"30px","contents"=>"this is header")`|
|footer|array||The footer of PDF page, it is array containing `height` and `contents` parameters, for example `"footer"=>array("height"=>"30px","contents"=>"this is footer")`|
|format |string|"A4" |The paper format, accepting "A3","A4","A5","Letter","Legal","Tabloid"|
|orientation|string|"portrait"|The orientation of the page, it always goes with the `format` property|
|dpi|number|72|Set the dpi for image or PDF|
|zoom|number|1|This is the page zoom factor, the default in linux is `0.5` and other OS is `1.0`|

### Example

Set landscape A4 with 1 inch margin for PDF file

```
$report->export()->pdf(array(
    "format"=>"A4",
    "orientation"=>"landscape",
    "margin"=>"1in",
))->toBrowser("myfile.pdf");
```

Set custom __width__ and __height__ for PDF

```
$report->export()->pdf(array(
    "width"=>"1024px",
    "height"=>"768px",
    "margin"=>"50px",
))->toBrowser("myfile.pdf");
```

Set custom __margin__ components:

```
$report->export()->pdf(array(
    "format"=>"A4",
    "orientation"=>"landscape",
    "margin"=>array(
        "top"=>"0.5in",
        "bottom"=>"0.5in",
        "left"=>"1in"
        "right"=>"1in"
    ),
))->toBrowser("myfile.pdf");
```

### Set paper margin on the view

Alternatively to setting margin through the `pdf()` function, you can set the margin of page on the view by setting `margin` css style in the `<body>` tag:

__Example:__ Set `1cm` margin for page

```
<html>
    <body style="margin:1cm">
    ...
    </body>
</html>
```

__Example:__ Set value for each margin component

```
<html>
    <body style="margin: 10px 20px 10px 20px">
    ...
    </body>
</html>
```

or you can do:

```
<html>
    <body style="margin-top:10px;margin-right:20px;margin-bottom:10px;margin-left:20px;">
    ...
    </body>
</html>
```


### Header and footer of the page

You may set the header and footer on top of __each PDF page__ using the `<div class='page-header'></div>` and `<div class='page-footer'></div>` tag inside the `<body>` of view.



```
<html>
    <body style="margin: 1in">
        <div class='page-header' style='height:30px'>
            <span>Header</span>
        </div>

        ...
        ...

        <div class='page-footer' style='height:30px'>
            <span>Footer</span>
        </div>
    </body>
</html>
```

If you want to set show the page number and also the total number of pages, you do:

```
<html>
    <body style="margin: 1in">
        <div class='page-header' style='height:30px'>
            <span>Page {pageNum}/{numPages}</span>
        </div>

        ...
        ...

        <div class='page-footer' style='height:30px'>
            <span>Page {pageNum}/{numPages}</span>
        </div>
    </body>
</html>
```

If you want to make the header and footer show on the right of page, do this:

```
<html>
    <body style="margin: 1in">
        <div class='page-header'>
            <div style="text-align:right">Header</div>
        </div>

        <div class='page-footer'>
            <div style="text-align:right">Header</div>
        </div>
    </body>
</html>
```

To show the header and footer at the center, it is easy as:


```
<html>
    <body style="margin: 1in">
        <div class='page-header'>
            <div style="text-align:center">Header</div>
        </div>

        <div class='page-footer'>
            <div style="text-align:center">Header</div>
        </div>
    </body>
</html>
```

Easy, isn't it?


## Save file vs push file to browser

After exporting, you have two options to do with the file. First, you can save the file to local drive and can use it later for example attaching file to email. Second, you can push to file to browser for user to download.

To save file, you do:

```
$report->export()->pdf()->saveAs("../storage/myreport.pdf"); // State the path of file
```

To push file to browser, you do:

```
$report->export()->pdf()->toBrowser("myreport.pdf"); // Input the filename
```

## Export to image

```
$report->export()->jpg(array(
    "width"=>"1024px",
    "height"=>"768px",
))->saveAs("../storage/myreport.jpg");
```

You can set the __width__ and __height__ in `cm` and `in`. Above example demonstrate exporting to `.jpg` file, other file types work in the same way. Here is the full list of supported image files:

|method|description|
|---|---|
|jpg($params)|Export to `.jpg` file|
|gif($params)|Export to `.gif` file|
|bmp($params)|Export to `.bmp` file|
|ppm($params)|Export to `.ppm` file|
|png($params)|Export to `.png` file|

## Make PDF Open On Browser

Instead of pushing file to browser for you to download, you may make PDF or or exported images to open on browser

```
$report->export()->pdf()->toBrowser("myreport.pdf",true);
```

By adding `true` to the second parameter of `toBrowser()` function, you will force browser to open the file.

## Generate Base64 string

You may generate base64 string:

```
$report->export()->pdf()->toBase64();
```

## Extra settings

There are some extra settings for exporting that you may need to aware of.

```
$report->export()
->settings(array(
    "useLocalTempFolder"=>true,
    "phantomjs"=>"/path/to/phantomjs",
    "resourceWaiting"=>2000,
))
->pdf(array(
    "format"=>"A4",
    "orientation"=>"portrait"
))
->toBrowser("report.pdf");
```

In rare case you receive `Exception: Could not save content to temporary folder`, probably your server does not support writing files to temporary folder `/tmp` for example. In this case, you may set `"useLocalTempFolder"=>true`. This settings will tell Export package to create a local temp located at `packages/export/tmp`.

In some case, your server required `phantomjs` to be installed rather than used directly from `bin` folder. After installing `phantomjs`, you may use the `"phantomjs"=>"/path/to/phantomjs"` to let Export package know how to call PhantomJS executed file.

The `resourceWaiting` is the milliseconds that export package will wait if there is any left resource to load before it decides to end loading and start exporting to PDF and others. By default, the resourceWating is 1000 milliseconds ( or 1 seconds) but you should set your own value to suit your server. Please choose the optimal value. If value is too low, it will cause page not fully loaded. If the value is too high, it will take longer time overall to generate PDF.

## Full example

In this example, we would like to summarize sale of Sakila Rental by month and display resulted in column chart and in a detail table.

`index.php`

```
<?php
require "SakilaRental.php";
$report = new SakilaRental;
$report->run();
$report->export()->pdf()->toBrowser("sakila.pdf");
```

`SakilaRental.php`

```
<?php
require_once "../../koolreport/autoload.php";

use \koolreport\KoolReport;
use \koolreport\processes\TimeBucket;
use \koolreport\processes\Group;

class SakilaRental extends KoolReport
{
    use \koolreport\export\Exportable;
    
    public function settings()
    {
        return array(
            "dataSources"=>array(
                "sakila_rental"=>array(
                    "class"=>'\koolreport\datasources\CSVDataSource',
                    'filePath'=>dirname(__FILE__)."\sakila_rental.csv",
                )
            )
        );
    }   
    protected function setup()
    {
        $this->src('sakila_rental')
        ->pipe(new TimeBucket(array(
            "payment_date"=>"month"
        )))
        ->pipe(new Group(array(
            "by"=>"payment_date",
            "sum"=>"amount"
        )))
        ->pipe($this->dataStore('sale_by_month'));
    } 
}

```

`SakilaRental.view.php`

```
<?php 
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\ColumnChart;
?>
<!DOCTYPE html>
<html>
    <body style="margin:1in">
        <header>
            <span style="float:right">{pageNum}/{numPages}</span>
        </header>
        <footer>
            <span style="float:right">{pageNum}/{numPages}</span>
        </footer>

            <div class="text-center">
                <h1>Cash In Report</h1>
                <h4>This report show the cash-in report per month</h4>
            </div>
            <hr/>

            <?php
            ColumnChart::create(array(
                "dataStore"=>$this->dataStore('sale_by_month'),  
                "columns"=>array(
                    "payment_date"=>array(
                        "label"=>"Month",
                        "type"=>"datetime",
                        "format"=>"Y-n",
                        "displayFormat"=>"F, Y",
                    ),
                    "amount"=>array(
                        "label"=>"Amount",
                        "type"=>"number",
                        "prefix"=>"$",
                    )
                ),
                "width"=>"100%",
                "height"=>"400px",
            ));
            ?>
            <div class="page-break"></div>
            <?php
            Table::create(array(
                "dataStore"=>$this->dataStore('sale_by_month'),
                "columns"=>array(
                    "payment_date"=>array(
                        "label"=>"Month",
                        "type"=>"datetime",
                        "format"=>"Y-n",
                        "displayFormat"=>"F, Y",
                    ),
                    "amount"=>array(
                        "label"=>"Amount",
                        "type"=>"number",
                        "prefix"=>"$",
                                )
                ),
                "cssClass"=>array(
                    "table"=>"table table-hover table-bordered"
                )
            ));
            ?>
            
    </body>
</html>
```

[You may view the exported result here](https://www.koolreport.com)



# Credit

We thank the PhantomJS's team for creating an awesome software. For those who have not known what PhantomJS is, it is a headless WebKit scriptable with a JavaScript API. It has fast and native support for various web standards: DOM handling, CSS selector, JSON, Canvas, and SVG. Visit their [website](http://phantomjs.org/).

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.