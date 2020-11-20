<?php
	use \koolreport\excel\Table;
	use \koolreport\excel\PivotTable;
	use \koolreport\excel\BarChart;
	use \koolreport\excel\LineChart;

	$sheet1 = "ReservationsSheet - Reservations by Date";
?>
<meta charset="UTF-8">
<meta name="description" content="Free Web tutorials">
<meta name="keywords" content="Excel,HTML,CSS,XML,JavaScript">
<meta name="creator" content="John Doe">
<meta name="subject" content="subject1">
<meta name="title" content="title1">
<meta name="category" content="Tiqs Sales ">

<div sheet-name="<?php echo $sheet1; ?>">
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
	<div cell="A1" range="A1:H1" excelstyle='<?php echo json_encode($styleArray); ?>' >
        Tiqs Reservations Report
    </div>

    <div>
        <?php
        Table::create(array(
            "dataSource" => $this->dataStore('salespot'),
            "headersExcelStyle" => [
                'customerName' => [
                    'font' => [
                        'italic' => true,
                        'color' => [
                            'rgb' => '808080',
                        ]
                    ],
                ]
            ],
            "columnsExcelStyle" => [
                'customerName' => [
                    'font' => [
                        'italic' => true,
                        'color' => [
                            'rgb' => '808080',
                        ]
                    ],
                ]
            ],

        ));
        ?>
    </div>    
</div>