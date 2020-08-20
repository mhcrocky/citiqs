<?php
	use \koolreport\datagrid\DataTables;
	use \koolreport\widgets\koolphp\Card;
	use \koolreport\amazing\Theme;
	use \koolreport\widgets\koolphp\Table;
?>

<div class="main-wrapper">
	<div class="col-half background-apricot height" style="text-align:left; font-size: smaller" >
		<div class="align-top width-650">
			<div class="report-content" >
				<?php
				\koolreport\amazing\DualChartCard::create(array(
					"title"=>"DAY TOTAL",

					"value"=>$this->dataStore("dayreport_day")->sum("total"),
					"format"=>array(
						"value"=>array(
							"type"=>"number",
							"decimals"=>2,              // Number of decimals to show
							"decimalPoint"=>",",        // Decimal point character
							"thousand_sep"=>".",  // Thousand separator
							"prefix"=>"€ ",
						)
					),
					"cssClass"=>array(
						"icon"=>"fa fa-euro"
					),
					"cssStyle"=> [
						"card"=>"background-color:#138575",
						"title"=>"font-weight:bold",
						"value"=>"font-style:italic",
						"icon"=>"font-size:24px;color:white"
					],
					"chart"=>array(
						"type"=>"area",
						"dataSource"=>$this->dataStore("dayreport_report")->sortKeysDesc("DateCreated"),
						"columns"=>array(
							"DateCreated",
							"amount"=>array(
								"label"=>"Amount",
								"type"=>"number",
								"decimals"=>2,              // Number of decimals to show
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€"
							)
						)
					),
						"secondChart"=>array(
							"dataSource"=>$this->dataStore("dayreport_report")->sortKeysDesc("DateCreated"),
						"columns"=>array(
							"DateCreated",
							"amount"=>array(
								"type"=>"number",
								"decimals"=>2,              // Number of decimals to show
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€"
							)
						)
					),

				));
				?>
			</div>
			<div class="report-content" style="margin-bottom: -30px; margin-top: 30px">
				<?php
				DataTables::create(array(
					"responsive"=>true,
					"dataSource"=>$this->dataStore("dayreport_day")->sortKeysDesc("DateCreated"),

					"themeBase"=>"bs4", // Optional option to work with Bootsrap 4
					"cssClass"=>array(
						"table"=>"table table-striped table-bordered"
					),
					'width' => '100%',
					"columns"=>array(
						"DateCreated"=>array(
							"label"=> "DAY",
							"type"=>"date"
						),
						"total"=>array(
							"label"=> "TOTAL",
							"type"=>"number",
							"decimals"=>2,
							"prefix"=>"€ "
						),

	//					"amount"=>array(
	//					   "type"=>"number",
	//						 "decimals"=>2
	//					 ),
	//					"servicefee"=>array(
	//					   "type"=>"number",
	//						 "decimals"=>2
	//					 )

					 ),

					"options"=>array(
						"order"=>array(
							array(0,"desc"), //Sort by first column desc
							array(1,"asc") //Sort by second column asc
						),
						"searching"=>true,
						"colReorder"=>true,
					),

				));
				?>
			</div>
		</div>


		<div class="align-top width-650" >
			<div class="report-content" >
				<?php
				\koolreport\amazing\DualChartCard::create(array(
					"title"=>"TOP LIST PRODUCTS FROM THIS WEEK TOTAL",
					"value"=>$this->dataStore('alldata_week')->sum('productlinetotal')+$this->dataStore('dayreport_week')->sum('servicefee'),
					"format"=>array(
						"value"=>array(
							"type"=>"number",
							"decimals"=>2,              // Number of decimals to show
							"decimalPoint"=>",",        // Decimal point character
							"thousand_sep"=>".",  // Thousand separator
							"prefix"=>"€ ",
						)
					),
					"cssClass"=>array(
						"card"=>"my-own-card-class",
						"tittle"=>"font-bold",
						"value"=>"big-font",
						"icon"=>"fa fa-dollar"
					),
					"cssStyle"=> [
						"card"=>"background-color:#04a7b8",
						"title"=>"font-weight:bold",
						"value"=>"font-style:italic",
						"icon"=>"font-size:24px;color:white"
					],

					"chart"=>array(
						"height"=>"300px",
						"dataSource"=>$this->dataStore("alldata_week")->sortKeys(),
						"columns"=>array(
							"createdAt",
							"productQuantity"=>array(
								"type"=>"number",
								"decimals"=>2,              // Number of decimals to show
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€",
							)
						)
					),
					"secondChart"=>array(
						"dataSource"=>$this->dataStore("alldata_week")->sortKeysDesc("orderAmount"),
						"columns"=>array(
							"createdAt",
							"productQuantity"=>array(
								"type"=>"number",
								"decimals"=>0,              // Number of decimals to show
								"decimalPoint"=>",",        // Decimal point character
								"thousandSeparator"=>".",  // Thousand separator
								"prefix"=>"€"
							)
						)
					),

				));
				?>
			</div>
			<div class="report-content" style="margin-bottom: -30px; margin-top: 30px">
				<?php
				Table::create(array(
					"responsive"=>true,
					"dataSource"=>$this->dataStore("alldata_week")->sort(array(
						"productQuantity"=>"desc"
					)),

					"themeBase"=>"bs4", // Optional option to work with Bootsrap 4
					"cssClass"=>array(
						"table"=>"table table-striped table-bordered"
					),
					'width' => '100%',
					"columns"=>array(
						"productName"=>array(
							"label"=> "PRODUCT",
							"type"=>"text"
						),
						"productQuantity"=>array(
							"label"=> "Qnt",
							"type"=>"number",
							"decimals"=>0,
							"prefix"=>""
						),

						"productlinetotal"=>array(
							"label"=> "AMOUNT",
							"type"=>"number",
							"decimals"=>2,
							"decimalPoint"=>",",        // Decimal point character
							"thousand_sep"=>".",  // Thousand separator
							"prefix"=>"€ "
						),


						//					"servicefee"=>array(
						//					   "type"=>"number",
						//						 "decimals"=>2
						//					 )

					),

					"options"=>array(
						"order"=>array(
							array(1,"desc") //Sort by second column asc
						),
						"searching"=>true,
						"colReorder"=>true,
					),
					"paging"=>array(
						"pageSize"=>5,
						"pageIndex"=>0,
					),


				));
				?>
			</div>
			<div class="report-content" style="margin-bottom: -30px; margin-top: 30px">
				<?php
				Table::create(array(
					"responsive"=>true,
					"dataSource"=>$this->dataStore("alldata_week")->sort(array(
						"productlinetotal"=>"desc"
					)),
					"paging"=>array(
						"pageSize"=>5,
						"pageIndex"=>0,
					),
					"themeBase"=>"bs4", // Optional option to work with Bootsrap 4
					"cssClass"=>array(
						"table"=>"table table-striped table-bordered"
					),
					'width' => '100%',
					"columns"=>array(
						"productName"=>array(
							"label"=> "PRODUCT",
							"type"=>"text"
						),
						"productQuantity"=>array(
							"label"=> "Qnt",
							"type"=>"number",
							"decimals"=>0,
							"prefix"=>""
						),

						"productlinetotal"=>array(
							"label"=> "AMOUNT",
							"type"=>"number",
							"decimals"=>2,
							"decimalPoint"=>",",        // Decimal point character
							"thousand_sep"=>".",  // Thousand separator
							"prefix"=>"€ "
						),


						//					"servicefee"=>array(
						//					   "type"=>"number",
						//						 "decimals"=>2
						//					 )

					),

					"options"=>array(
						"order"=>array(
							array(2,"desc") //Sort by second column asc
						),
						"searching"=>true,
						"colReorder"=>true,
					),


				));
				?>
			</div>
		</div>


	</div>

	<div class="col-half background-apricot height" style="text-align:left; font-size: smaller">
		<div class="align-top width-650" >
			<div class="report-content" >
				<?php
				\koolreport\amazing\DualChartCard::create(array(
					"title"=>"THIS WEEK TOTAL",

					"value"=>$this->dataStore("dayreport_week")->sum("total"),
					"format"=>array(
						"value"=>array(
							"type"=>"number",
							"decimals"=>2,              // Number of decimals to show
							"decimalPoint"=>",",        // Decimal point character
							"thousand_sep"=>".",  // Thousand separator
							"prefix"=>"€ ",
						)
					),
				    "cssClass"=>array(
						"card"=>"my-own-card-class",
						"tittle"=>"font-bold",
						"value"=>"big-font",
						"icon"=>"fa fa-dollar"
					),
					"cssStyle"=> [
						"card"=>"background-color:#04a7b8",
						"title"=>"font-weight:bold",
						"value"=>"font-style:italic",
						"icon"=>"font-size:24px;color:white"
					],

					"chart"=>array(
					"height"=>"300px",
						"dataSource"=>$this->dataStore("dayreport_week")->sortKeysDesc("DateCreated"),
						"columns"=>array(
							"DateCreated",
							"amount"=>array(
								"type"=>"number",
								"decimals"=>2,              // Number of decimals to show
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€",
							)
						)
					),
					"secondChart"=>array(
						"dataSource"=>$this->dataStore("dayreport_week")->sortKeysDesc("DateCreated"),
						"columns"=>array(
							"DateCreated",
							"amount"=>array(
								"type"=>"number",
								"decimals"=>2,              // Number of decimals to show
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€"
							)
						)
					),

				));
				?>
			</div>
			<div class="report-content" style="margin-bottom: -30px; margin-top: 30px">
				<?php
				DataTables::create(array(
					"responsive"=>true,
					"dataSource"=>$this->dataStore("dayreport_week")->sortKeysDesc("DateCreated"),

					"themeBase"=>"bs4", // Optional option to work with Bootsrap 4
					"cssClass"=>array(
						"table"=>"table table-striped table-bordered"
					),
					'width' => '100%',
					"columns"=>array(
						"DateCreated"=>array(
							"label"=> "DAY",
							"type"=>"date"
						),
						"total"=>array(
							"label"=> "TOTAL",
							"type"=>"number",
							"decimals"=>2,
							"prefix"=>"€ "
						),

						//					"amount"=>array(
						//					   "type"=>"number",
						//						 "decimals"=>2
						//					 ),
						//					"servicefee"=>array(
						//					   "type"=>"number",
						//						 "decimals"=>2
						//					 )

					),

					"options"=>array(
						"order"=>array(
							array(0,"desc"), //Sort by first column desc
							array(1,"asc") //Sort by second column asc
						),
						"searching"=>true,
						"colReorder"=>true,
					),

				));
				?>
			</div>
		</div>

		<div class="align-top width-650">
			<div class="report-content" >
				<?php
				\koolreport\amazing\DualChartCard::create(array(
					"title"=>"LAST WEEK",
					"value"=>$this->dataStore("dayreport_lastweek")->sum("total"),
					"format"=>array(
						"value"=>array(
							"type"=>"number",
							"decimals"=>2,              // Number of decimals to show
							"decimalPoint"=>",",        // Decimal point character
							"thousand_sep"=>".",  // Thousand separator
							"prefix"=>"€ ",
						)
					),
					"cssClass"=>array(
						"icon"=>"fa fa-euro"
					),
					"cssStyle"=> [
						"card"=>"background-color:#eb5d16",
						"title"=>"font-weight:bold",
						"value"=>"font-style:italic",
						"icon"=>"font-size:24px;color:white"
					],
					"chart"=>array(
						"type"=>"area",
						"dataSource"=>$this->dataStore("dayreport_lastweek")->sortKeysDesc("DateCreated"),
						"columns"=>array(
							"DateCreated",
							"amount"=>array(
								"label"=>"Amount",
								"type"=>"number",
								"decimals"=>2,              // Number of decimals to show
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€"
							)
						)
					),
					"secondChart"=>array(
						"dataSource"=>$this->dataStore("dayreport_lastweek")->sortKeysDesc("DateCreated"),
						"columns"=>array(
							"DateCreated",
							"amount"=>array(
								"type"=>"number",
								"decimals"=>2,              // Number of decimals to show
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€"
							)
						)
					),

				));
				?>
			</div>
			<div class="report-content" style="margin-bottom: -30px; margin-top: 30px">
				<?php
				Table::create(array(
					"responsive"=>true,
					"dataSource"=>$this->dataStore("dayreport_lastweek")->sortKeysDesc("DateCreated"),

					"themeBase"=>"bs4", // Optional option to work with Bootsrap 4
					"cssClass"=>array(
						"table"=>"table table-striped table-bordered"
					),
					'width' => '100%',
					"columns"=>array(
						"DateCreated"=>array(
							"label"=> "DAY",
							"type"=>"date"
						),
						"total"=>array(
							"label"=> "TOTAL",
							"type"=>"number",
							"decimals"=>2,
							"prefix"=>"€ "
						),

						//					"amount"=>array(
						//					   "type"=>"number",
						//						 "decimals"=>2
						//					 ),
						//					"servicefee"=>array(
						//					   "type"=>"number",
						//						 "decimals"=>2
						//					 )

					),

					"options"=>array(
						"order"=>array(
							array(0,"desc"), //Sort by first column desc
						),
						"searching"=>true,
						"colReorder"=>true,
					),

				));
				?>
			</div>
		</div>
	</div>

</div>

