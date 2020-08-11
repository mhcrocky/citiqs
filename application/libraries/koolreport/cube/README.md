# Introduction

The `Cube` package helps to process your data into cross-tab table. For example, we have this data.

|Country   |Product   |Sale     |
|----------|----------|---------|
|U.S       |iPhone    |48,000   |
|Canada    |Samsung   |36,000   |
|U.S       |Samsung   |44,000   |
|Canada    |iPhone    |12,000   |

The Cube process can turn above table data into this summarized table:

|Country   |iPhone    |Samsung  |Total    |
|----------|----------|---------|---------|
|U.S       |48,000    |44,000   |92,000   |
|Canada    |12,000    |36,000   |48,000   |

The summarized data can then be used to draw charts and graphs.

In version >= 2.0.0 of the package, we added the extended `Supercube` process allowing for multiple label columns and multiple aggregated operators in one process.

# Installation

1. Download and unzip the zipped file.
2. Copy the folder `cube` into `koolreport/packages` folder
3. Reference to the Cube process by the classname`\koolreport\cube\processes\Cube`
4. Reference to the SuperCube process by the classname`\koolreport\cube\processes\SuperCube`

# Usage

When using the `Cube` process, you could define the row, column fields and an aggregated one (i.e "sum", "count", etc). For example, in below code, we turn `country` data into *row*, `product` to *column* and we sum the *sale*. 

```
<?php
use \koolreport\cube\processses\Cube;
class MyReport extends \koolreport\KoolReport
{
    ...
    public function setup()
    {
        $this->src('sales')
        ->query("SELECT country,product,sale from tblPurchases")
        ->pipe(new Cube(array(
            "row"=>"country",
            "column"=>"product",
            "sum"=>"sale"
        )))
        ->pipe($this->dataStore('sales'));
    }
}
```

If you only specify `column`, for example:

```
...
->pipe(new Cube(array(
    "column"=>"product",
    "sum"=>"sale"
)))
...
```

the resulted table will have multiple summarized columns and one summarized row like this:

|Label     |iPhone    |Samsung   |Total    |
|----------|----------|----------|---------|
|Total     |60,000    |80,000    |140,000  |

If you only specify `row`, for example:

```
...
->pipe(new Cube(array(
    "row"=>"country",
    "sum"=>"sale"
)))
...
```

the resulted table will have multiple summarized rows and one summarized column like this:

|Country   |Total     |
|----------|----------|
|U.S       |92,000    |
|Canada    |48,000    |

With the `SuperCube` process, you could specify multiple fields for `rows`, multiple fields for `columns` and multiple fields for each operators. For example:

```
<?php
use \koolreport\cube\processses\Cube;
class MyReport extends \koolreport\KoolReport
{
    ...
    public function setup()
    {
        $this->src("sales")
        ->query("SELECT country,product,sale from tblPurchases")
        ->pipe(new SuperCube(array(
            "rows" => "productCategory, productName",
            "columns" => "orderYear, orderMonth",
            "sum" => "dollar_sales, tax_amount",
            "sum percent" => "dollar_sales, tax_amount",
            "count" => "dollar_sales, order_id",
            "count percent" => "dollar_sales, order_id",
            "avg" => "dollar_sales",
        )))
        ->pipe($this->dataStore("sales"));
    }
}
```

The resulted table will look like this:

|Product Category   |Product Name    |orderYear - 2014 \| dollar_sales - sum |  orderMonth - 12 \| order_id - count  |...|
|----------|----------|---------|---------|---------|
|Car       |Citroen-15CV    |580,000   |28   |...  |
|Car    |Ford Falcon    |730,000   |45   |...  |
|Truck    |Ford F-150    |480,000   |32   |...  |

# Documentation

## Row

The "row" property specifies a field whose distinct values are used as the label column for the summarized table. In the above examples, `Country` is such a field.

## Column

The "column" property specifies a field whose distinct values are used used as columns' name for the summarized table. In the above examples, `Product` is such a field.

## Rows (version >= 2.0.0)

If you specify multiple fields for `rows` property, the resulted table will have multiple label columns ordered by labels from left to right. For example:

```
    ->pipe(new Cube(array(
        "rows" => "productCategory, productName",
        ...
    )))
```

|Product Category   |Product Name    |...|
|----------|----------|---|
|Car       |Citroen-15CV    |...|
|Car    |Ford Falcon    |...|
|Truck    |Ford F-150    |...|

## Columns (version >= 2.0.0)

If you specify multiple fiels for `columns` property, the resulted table will have multiple data columns like this:

```
    ->pipe(new Cube(array(
        "columns" => "orderYear, orderMonth",
        ...
    )))
```

|...|orderYear - 2014 \| dollar_sales - sum | orderYear - 2015 \| dollar_sales - sum |orderMonth - 12 \| dollar_sales - sum  |orderMonth - 12 \| dollar_sales - sum| ...|
|----------|----------|---|----|-------|--------|
|... |580,000   |680,000 | 28   | 32 | ...  |
|...    |730,000   |850,000  | 45   | 52 |...  |

## Aggregated operator

The Cube and SuperCube processes accept several aggregated operator including "sum", "count", "min", "max", "avg" (version >= 1.0.0) and "count percent", "sum percent" (version >= 2.0.0). Each operator can specify exactly one field (`Cube` process) or multiple fields (`SuperCube` process) whose values are aggregated according to the operator into the data of the summarized table. 

## Summarized table format

The summarized table of the `Cube` process includes rows of distinct values of the "row"/"rows" fields (if defined) and columns whose names are in the format of "<column field value>" or "{{all}}". Beside those columns there are label columns which are the "row"/"rows" fields and ordered by labels from left to right. Here's an example:

|Country   |iPhone    |Samsung  |{{all}}    |
|----------|----------|---------|---------|
|U.S       |48,000    |44,000   |92,000   |
|Canada    |12,000    |36,000   |48,000   |

The summarized table of the `SuperCube` process includes rows of distinct values of the "row"/"rows" fields (if defined) and columns whose names are in the format of "<column field> - <column field value>| <aggregated field> - <aggregated operator>" or "<column field> - {{all}} | <aggregated field> - <aggregated operator>". Beside those columns there are label columns which are the "row"/"rows" fields and ordered by labels from left to right. Here's an example:

|Product Category   |Product Name    |orderYear - 2014 \| dollar_sales - sum |orderYear - {{all}} \| dollar_sales - sum |  orderMonth - 12 \| order_id - count  |orderMonth - {{all}} \| order_id - count  |...|
|----------|----------|---------|---------|---------|---------|---------|
|Car       |Citroen-15CV    |580,000   |1,560,000 |28  |69   |...  |
|Car    |Ford Falcon    |730,000   |1320,000   |45  |82   |...  |
|Truck    |Ford F-150    |480,000   |1730,000   |32  |98   |...  |


# Working examples

[Click here to view cube and supercube examples](https://www.koolreport.com/examples/#cube).

Enjoy!

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.