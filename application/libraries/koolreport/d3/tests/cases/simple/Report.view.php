<?php
use \koolreport\d3\ColumnChart;
use \koolreport\d3\BarChart;
use \koolreport\d3\PieChart;
use \koolreport\d3\DonutChart;

use \koolreport\d3\LineChart;
use \koolreport\d3\AreaChart;
use \koolreport\d3\GaugeChart;
use \koolreport\d3\ScatterChart;
use \koolreport\d3\FunnelChart;
use \koolreport\d3\SplineChart;
use \koolreport\d3\Waterfall;


$category_amount = array(
    array("category"=>"Books","sale"=>90,"cost"=>20000,"profit"=>12000),
    array("category"=>"Accessories","sale"=>43000,"cost"=>36000,"profit"=>7000),
    array("category"=>"Phones","sale"=>54000,"cost"=>39000,"profit"=>15000),
    array("category"=>"Movies","sale"=>23000,"cost"=>18000,"profit"=>5000),
    array("category"=>"Others","sale"=>12000,"cost"=>6000,"profit"=>6000),
);

$time_series = array(
    array("date"=>"2018-09-01","sale"=>32000,"cost"=>20000,"profit"=>12000),
    array("date"=>"2018-09-02","sale"=>43000,"cost"=>36000,"profit"=>7000),
    array("date"=>"2018-09-03","sale"=>54000,"cost"=>39000,"profit"=>15000),
    array("date"=>"2018-09-04","sale"=>23000,"cost"=>18000,"profit"=>5000),
    array("date"=>"2018-09-09","sale"=>12000,"cost"=>6000,"profit"=>6000),
);

$funnel = array(
    array("category"=>"Visit","amount"=>5000),
    array("category"=>"Download","amount"=>4000),
    array("category"=>"Initial Checkout","amount"=>2000),
    array("category"=>"Purchase","amount"=>1000),
);

$funnel_two = [
    ["label"=> 'Inquiries', "value"=> 5000 ],
    ["label"=> 'Applicants', "value"=> 2500 ],
    ["label"=> 'Admits', "value"=> 500 ],
    ["label"=> 'Deposits', "value"=> 200 ],
];


$waterfall = [
    ["name"=>"Product Revenue","amount"=>420000],
    ["name"=>"Services Revenue","amount"=>210000],
    ["name"=>"Fixed Costs","amount"=>-170000],
    ["name"=>"Variable Costs","amount"=>-140000]
];

?>
<html>
    <head>
        <title>Test D3 Chart</title>
    </head>
    <body>
        <h1>Test D3 Chart</h1>
        <div id="test"></div>

        <?php
        SplineChart::create(array(
            "dataSource"=>array(
                array("date"=>"2018-09-01 22:10:00","temp"=>17.9),
                array("date"=>"2018-09-02 22:11:00","temp"=>18.1),
                array("date"=>"2018-09-04 22:12:00","temp"=>18.3),
                array("date"=>"2018-09-05 22:13:00","temp"=>17.8),
                array("date"=>"2018-09-09 22:14:00","temp"=>18.0),
            ),
            "columns"=>array(
                "date"=>array(
                    "type"=>"datetime",
                    "xFormat"=>"%Y-%m-%d %H:%I:%S",
                    "xDisplayFormat"=>"%d.%m.%Y %H:%I:%S"
                ),
                "temp"=>array(
                    "label"=>"R30P_S3",
                    "type"=>"number",
                    "decimals"=>1,
                    "suffix"=>"°C" 
                ),
            )
        ));
        ?>


        <?php
        Waterfall::create([
            "dataSource"=>[
                ["name"=>"Product Revenue","amount"=>420000],
                ["name"=>"Services Revenue","amount"=>210000],
                ["name"=>"Fixed Costs","amount"=>-170000],
                ["name"=>"Variable Costs","amount"=>-140000],
                ["name"=>"Extra Costs","amount"=>-400000]
            ],
            "title"=>"Step by step",
            "columns"=>[
                "name",
                "amount"=>[
                    "format"=>"function(d){
                        return `\${Math.round(d / 1000)}k`;
                    }"
                ]
            ],
            "yAxis"=>[
                "prefix"=>"$",
            ],
            "summary"=>[
                "Intermediate"=>2,
                "Final"=>"end"
            ],
            "colors"=>["#7FFF00","#FA8072","#20B2AA","#FF1493"],
        ]);
        ?>


        <?php
        SplineChart::create([
            "dataSource"=>$category_amount,
        ]);
        ?>

        <?php
        FunnelChart::create([
            "dataSource"=>$funnel,
            "width"=>480,
            "columns"=>[
                "category",
                "amount"
            ],
            "colorScheme"=>[
                "#3366CC",
                "#DC3912",
                "#FF9900",
                "#109618",
                "#990099",
                "#3B3EAC",
                "#0099C6",
                "#DD4477",
            ]
        ])
        ?>

        <?php
        ScatterChart::create([
            "dataSource"=>array(
                array("sentosa_x","sentosa"),
                array(55,29),
                array(33,43),
                array(72,65),
                array(37,37),
                array(52,68),
            ),
            "series"=>[
                ["sentosa_x","sentosa"=>["label"=>"SANTOSA"]]
            ],
            "yAxis"=>[
                "label"=>"Sentosa",
                "prefix"=>"$"
            ],
            "xAxis"=>[
                "label"=>"Sentosa X",
                "prefix"=>"$"
            ]

        ]);
        ?>

        <?php
        GaugeChart::create(array(
            "values"=>array(
                "Data"=>40,
                "Data 2"=>50
            ),
            "min"=>20,
            "label"=>[
                "use"=>"value",
                "prefix"=>"$"
            ],
            "tooltip"=>[
                "use"=>"ratio"
            ]
        ));
        ?>


        <?php
        AreaChart::create(array(
            "dataSource"=>$category_amount,
            "columns"=>array(
                "sale","cost","profit",
            ),
        ));
        ?>



        <label>Timeseries</label>
        <?php
        LineChart::create([
            "dataSource"=>$time_series,
            "columns"=>[
                "date"=>[
                    "type"=>"datetime",
                    "xFormat"=>"%Y-%m-%d",
                    "xDisplayFormat"=>"%b %d, %Y"
                ],"sale"
            ],
        ])
        ?>

        <label>Multiple X</label>
        <?php
        LineChart::create(array(
            "dataSource"=>$category_amount,
            "columns"=>array(
                "sale"=>[
                    "x"=>true,
                ],
                "cost",
                "profit",
            ),
            "xAxis"=>[
                "prefix"=>"$"
            ]
        ));
        ?>

        <?php
        LineChart::create(array(
            "dataSource"=>$category_amount,
            "columns"=>array(
                "category","sale","cost","profit",
            ),
        ));
        ?>


        <label>ColorScheme</label>
        <?php
        ColumnChart::create([
            "dataSource"=>$category_amount,
            "colorScheme"=>[
                "#3366CC",
                "#DC3912",
                "#FF9900",
                "#109618",
                "#990099",
                "#3B3EAC",
                "#0099C6",
                "#DD4477",
            ]
        ])
        ?>

        <?php
        ColumnChart::create(array(
            "dataStore"=>array(
                array("name"=>"Tuan","age"=>35,"salary"=>45),
                array("name"=>"Dong","age"=>20,"salary"=>50)
            ),
            "columns"=>array(
                "name"=>array(
                    "label"=>"Name",
                ),
                "age"=>array(
                    "label"=>"Age",
                ),
                "salary"=>array(
                    "label"=>"Salary",
                    "axis"=>"y2",
                ),
            ),
            "dualAxis"=>true,
            "yTick"=>[
                "prefix"=>"$",
                "decimals"=>2
            ],
            "y2Tick"=>[
                "prefix"=>"$",
                "decimals"=>2
            ]
        ));
        ?>

        <?php
        DonutChart::create(array(
            "dataStore"=>$category_amount,
            "title"=>"Cost of Good Sold",
            "columns"=>array(
                "category",
                "cost"
            ),
            "label"=>array(
                "use"=>"ratio",
            ),
            "tooltip"=>array(
                "use"=>"value",
                "prefix"=>"$"
            )
        ));
        ?>
    </body>
</html>