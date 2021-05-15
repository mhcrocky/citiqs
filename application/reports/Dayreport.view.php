<?php
	use \koolreport\widgets\koolphp\Card;
	use \koolreport\widgets\koolphp\Table;
	use \koolreport\datagrid\DataTables;
	use \koolreport\inputs\Bindable;
	use \koolreport\inputs\POSTBinding;
?>

<script src='https://code.jquery.com/jquery-1.12.3.js'></script>
<script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" charset="utf-8"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">


<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>

<script type="text/javascript" src="DataTables/datatables.min.js"></script>

<div class="main-wrapper background-apricot height" >
	<div class="background-apricot height" style="text-align: center; width: 100%">
		<div  style="width:90%; margin-left: 5%; "  >
			<div class="mb-35" style="margin-top: 30px; ">
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

			<div>
				<?php
				DataTables::create(array(
					"dataSource"=>$this->dataStore("dayreport_day")->sortKeysDesc("DateCreated"),
					"cssClass"=>array(
						"table"=>"dt-responsive table table-striped table-bordered"
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

						"amount"=>array(
							"label"=> "AMOUNT",
							"type"=>"number",
							"decimals"=>2,
							"prefix"=>"€ "
						 ),

						"servicefee"=>array(
							"label"=> "SERVICEFEE",
							"type"=>"number",
							"decimals"=>2,
							"prefix"=>"€ "
						 )

					 ),

					"options"=>array(
						"order"=>array(
							array(1,"desc") //Sort by second column asc
						),
						"searching"=>true,
						"colReorder"=>true,
						"pagingType"=>array("simple",),
						"language"=>array("paginate"=>array("first"=>'«',
							"previous"=>'‹',
							"next"=>'›',
							"last"=>'»'
						)),
//						"paging"=>array(
//							"pageSize"=>5,
//							"pageIndex"=>0,
//							"align"=>"left",
//						),
					),

				));
				?>
			</div>

<!--			<div class="mb-35" style="margin-top: 30px; ">-->
<!--				--><?php
//				\koolreport\amazing\ChartCard::create(array(
//					"title"=>"TODAY CATEGORY TOTALS",
//					"value"=>$this->dataStore("dayreport_day")->sum("total"),
//					"format"=>array(
//						"value"=>array(
//							"type"=>"number",
//							"decimals"=>2,              // Number of decimals to show
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ ",
//						)
//					),
//					"cssClass"=>array(
//						"icon"=>"fa fa-calendar"
//					),
//					"cssStyle"=> [
//						"card"=>"background-color:#138575",
//						"title"=>"font-weight:bold",
//						"value"=>"font-style:italic",
//						"icon"=>"font-size:24px;color:white"
//					],
//				));
//				?>
<!--			</div>-->
<!---->
<!--			<div>-->
<!--				<style>-->
<!--					.dataTables_paginate {-->
<!--						/*visibility: hidden;*/-->
<!--						justify-content: center !important;-->
<!--					}-->
<!--					.paginate_button page-item next {-->
<!--						/*visibility: hidden;*/-->
<!--						justify-content: center !important;-->
<!--						background-color: red;-->
<!--					}-->
<!--				</style>-->
<!--				--><?php
//				DataTables::create(array(
//					"dataSource"=>$this->dataStore("alldata_categoryday")->sort(array(
//						"productQuantity"=>"desc"
//					)),
//					"width"=>"600px",
//					"cssClass"=>array(
//						"table"=>"dt-responsive table table-striped table-bordered",
//					),
//					"columns"=>array(
//						"category"=>array(
//							"label"=> "CATEGORY",
//							"type"=>"text"
//						),
//
//
//						"orderAmount"=>array(
//							"label"=> "AMOUNT",
//							"type"=>"number",
//							"decimals"=>2,
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ "
//						),
//
//						"servicefee"=>array(
//							"label"=> "SERVICEFEE",
//							"type"=>"number",
//							"decimals"=>2,
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ "
//						),
//
//						"totalamount"=>array(
//							"label"=> "TOTAL",
//							"type"=>"number",
//							"decimals"=>2,
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ "
//						),
//
//
//					),
//
//					"options"=>array(
//						"order"=>array(
//							array(0,"asc") //Sort by second column asc
//						),
//						"searching"=>true,
//						"colReorder"=>true,
//						"pagingType"=>array("simple"),
//						"language"=>array("paginate"=>array("first"=>'«',
//							"previous"=>'‹',
//							"next"=>'›',
//							"last"=>'»'
//						)),
//						"paging"=>true,
//						"columnDefs"=>array(
//							array("width"=> "50px", "targets"=>"1" )
//						)
//					),
//
//
//				));
//				?>
<!--			</div>-->


<!--			<div class="mb-35" style="margin-top: 30px; ">-->
<!---->
<!--				--><?php
//				\koolreport\amazing\ChartCard::create(array(
//					"title"=>"YESTERDAY CATEGORY TOTALS",
//					"value"=>$this->dataStore("dayreport_yesterday")->sum("total"),
//					"format"=>array(
//						"value"=>array(
//							"type"=>"number",
//							"decimals"=>2,              // Number of decimals to show
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ ",
//						)
//					),
//					"cssClass"=>array(
//						"icon"=>"fa fa-calendar"
//					),
//					"cssStyle"=> [
//						"card"=>"background-color:#138575",
//						"title"=>"font-weight:bold",
//						"value"=>"font-style:italic",
//						"icon"=>"font-size:24px;color:white"
//					],
//				));
//				?>
<!--			</div>-->
<!---->
<!--			<div>-->
<!---->
<!---->
<!--				--><?php
//				DataTables::create(array(
//					"dataSource"=>$this->dataStore("alldata_categoryyesterday")->sort(array(
//						"productQuantity"=>"desc"
//					)),
//					"width"=>"600px",
//					"cssClass"=>array(
//						"table"=>"dt-responsive table table-striped table-bordered",
//					),
//					"columns"=>array(
//
//						"createdAt"=>array(
//							"label"=> "DAY",
//							"type"=>"datetime",
//							"format"=>"Y-m-d H:i:s",
//							"displayFormat"=>"d-m-Y"
//						),
//
//						"category"=>array(
//							"label"=> "CATEGORY",
//							"type"=>"text"
//						),
//
//
//						"orderAmount"=>array(
//							"label"=> "AMOUNT",
//							"type"=>"number",
//							"decimals"=>2,
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ "
//						),
//
//						"servicefee"=>array(
//							"label"=> "SERVICEFEE",
//							"type"=>"number",
//							"decimals"=>2,
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ "
//						),
//
//						"totalamount"=>array(
//							"label"=> "TOTAL",
//							"type"=>"number",
//							"decimals"=>2,
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ "
//						),
//
//
//					),
//
//					"options"=>array(
//						"order"=>array(
//							array(0,"asc") //Sort by second column asc
//						),
//						"searching"=>true,
//						"colReorder"=>true,
//						"pagingType"=>array("simple"),
//						"language"=>array("paginate"=>array("first"=>'«',
//							"previous"=>'‹',
//							"next"=>'›',
//							"last"=>'»'
//						)),
//						"paging"=>true,
//						"columnDefs"=>array(
//							array("width"=> "50px", "targets"=>"1" )
//						)
//					),
//
//
//				));
//				?>
<!--			</div>trtff-->



<!--			<div class="mb-35" style="margin-top: 30px; ">-->
<!---->
<!--				--><?php
//				\koolreport\amazing\DualChartCard::create(array(
//					"title"=>"TOP LIST PRODUCTS FROM THIS WEEK TOTAL",
//					"value"=>$this->dataStore('alldata_week')->sum('productlinetotal')+$this->dataStore('dayreport_week')->sum('servicefee'),
//					"format"=>array(
//						"value"=>array(
//							"type"=>"number",
//							"decimals"=>2,              // Number of decimals to show
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ ",
//						)
//					),
//					"cssClass"=>array(
//						"card"=>"my-own-card-class",
//						"tittle"=>"font-bold",
//						"value"=>"big-font",
//						"icon"=>"fa fa-dollar"
//					),
//					"cssStyle"=> [
//						"card"=>"background-color:#04a7b8",
//						"title"=>"font-weight:bold",
//						"value"=>"font-style:italic",
//						"icon"=>"font-size:24px;color:white"
//					],
//
//					"chart"=>array(
//						"height"=>"300px",
//						"dataSource"=>$this->dataStore("alldata_week")->sortKeys(),
//						"columns"=>array(
//							"createdAt",
//							"productQuantity"=>array(
//								"type"=>"number",
//								"decimals"=>2,              // Number of decimals to show
//								"decimalPoint"=>",",        // Decimal point character
//								"thousand_sep"=>".",  // Thousand separator
//								"prefix"=>"€",
//							)
//						)
//					),
//					"secondChart"=>array(
//						"dataSource"=>$this->dataStore("alldata_week")->sortKeysDesc("orderAmount"),
//						"columns"=>array(
//							"createdAt",
//							"productQuantity"=>array(
//								"type"=>"number",
//								"decimals"=>0,              // Number of decimals to show
//								"decimalPoint"=>",",        // Decimal point character
//								"thousandSeparator"=>".",  // Thousand separator
//								"prefix"=>"€"
//							)
//						)
//					),
//
//				));
//				?>
<!--			</div>-->
<!--			<div >-->
<!--				<style>-->
<!--					.dataTables_paginate {-->
<!--											 /*visibility: hidden;*/-->
<!--											 justify-content: center !important;-->
<!--										 }-->
<!--					.paginate_button page-item next {-->
<!--						/*visibility: hidden;*/-->
<!--						justify-content: center !important;-->
<!--						background-color: red;-->
<!--					}-->
<!--				</style>-->
<!--				--><?php
//				DataTables::create(array(
//					"dataSource"=>$this->dataStore("alldata_week")->sort(array(
//						"productQuantity"=>"desc"
//					)),
//					"width"=>"600px",
//					"cssClass"=>array(
//						"table"=>"dt-responsive table table-striped table-bordered",
//					),
//					"columns"=>array(
//						"productName"=>array(
//							"label"=> "PRODUCT",
//							"type"=>"text"
//						),
//						"productQuantity"=>array(
//							"label"=> "Qnt",
//							"type"=>"number",
//							"decimals"=>0,
//							"prefix"=>""
//						),
//
//						"totalamount"=>array(
//							"label"=> "AMOUNT",
//							"type"=>"number",
//							"decimals"=>2,
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ "
//						),
//
//						"productlinetotal"=>array(
//							"label"=> "AMOUNT",
//							"type"=>"number",
//							"decimals"=>2,
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ "
//						),
//
//						"servicefee"=>array(
//							"label"=> "SERVICEFEE",
//							"type"=>"number",
//							"decimals"=>2,
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ "
//						)
//
//					),
//
//					"options"=>array(
//						"order"=>array(
//							array(1,"desc") //Sort by second column asc
//						),
//						"searching"=>true,
//						"colReorder"=>true,
//						"pagingType"=>array("simple"),
//						"language"=>array("paginate"=>array("first"=>'«',
//							"previous"=>'‹',
//							"next"=>'›',
//							"last"=>'»'
//						)),
//						"paging"=>true,
//						"columnDefs"=>array(
//							array("width"=> "50px", "targets"=>"1" )
//						)
//					),
//
//
//				));
//				?>
<!--			</div>-->


<!--			<div>-->
<!--				--><?php
//				\koolreport\amazing\DualChartCard::create(array(
//					"title"=>"TURN OVER PER DAY",
//
//					"value"=>$this->dataStore("dayreport_week")->sum("total"),
//					"format"=>array(
//						"value"=>array(
//							"type"=>"number",
//							"decimals"=>2,              // Number of decimals to show
//							"decimalPoint"=>",",        // Decimal point character
//							"thousand_sep"=>".",  // Thousand separator
//							"prefix"=>"€ ",
//						)
//					),
//				    "cssClass"=>array(
//						"card"=>"my-own-card-class",
//						"tittle"=>"font-bold",
//						"value"=>"big-font",
//						"icon"=>"fa fa-dollar"
//					),
//					"cssStyle"=> [
//						"card"=>"background-color:#04a7b8",
//						"title"=>"font-weight:bold",
//						"value"=>"font-style:italic",
//						"icon"=>"font-size:24px;color:white"
//					],
//
//					"chart"=>array(
//					"height"=>"300px",
//						"dataSource"=>$this->dataStore("dayreport_week")->sortKeysDesc("DateCreated"),
//						"columns"=>array(
//							"DateCreated",
//							"amount"=>array(
//								"type"=>"number",
//								"decimals"=>2,              // Number of decimals to show
//								"decimalPoint"=>",",        // Decimal point character
//								"thousand_sep"=>".",  // Thousand separator
//								"prefix"=>"€",
//							)
//						)
//					),
//					"secondChart"=>array(
//						"dataSource"=>$this->dataStore("dayreport_week")->sortKeysDesc("DateCreated"),
//						"columns"=>array(
//							"DateCreated",
//							"amount"=>array(
//								"type"=>"number",
//								"decimals"=>2,              // Number of decimals to show
//								"decimalPoint"=>",",        // Decimal point character
//								"thousand_sep"=>".",  // Thousand separator
//								"prefix"=>"€"
//							)
//						)
//					),
//
//				));
//				?>
<!--			</div>-->
<!---->
<!--			<div>-->
<!--				--><?php
//				DataTables::create(array(
//					"responsive"=>true,
//					"dataSource"=>$this->dataStore("dayreport_week")->sortKeysDesc("DateCreated"),
//
//					"themeBase"=>"bs4", // Optional option to work with Bootsrap 4
//					"cssClass"=>array(
//						"table"=>"table table-striped table-bordered"
//					),
//					'width' => '100%',
//					"columns"=>array(
//						"DateCreated"=>array(
//							"label"=> "DAY",
//							"type"=>"date"
//						),
//						"total"=>array(
//							"label"=> "TOTAL",
//							"type"=>"number",
//							"decimals"=>2,
//							"prefix"=>"€ "
//						),
//
//						//					"amount"=>array(
//						//					   "type"=>"number",
//						//						 "decimals"=>2
//						//					 ),
//						//					"servicefee"=>array(
//						//					   "type"=>"number",
//						//						 "decimals"=>2
//						//					 )
//
//					),
//
//					"options"=>array(
//						"order"=>array(
//							array(0,"desc"), //Sort by first column desc
//							array(1,"asc") //Sort by second column asc
//						),
//						"searching"=>true,
//						"colReorder"=>true,
//					),
//
//				));
//				?>
<!--			</div>-->

			<div class="mb-35" style="margin-top: 30px; ">
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

			<div>
				<?php
				DataTables::create(array(
					"dataSource"=>$this->dataStore("dayreport_lastweek")->sortKeysDesc("DateCreated"),

					"themeBase"=>"bs4", // Optional option to work with Bootsrap 4
					"cssClass"=>array(
						"table"=>"dt-responsive table table-striped table-bordered"
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
							array(0,"desc") //Sort by second column asc
						),
						"searching"=>true,
						"colReorder"=>true,
						"pagingType"=>array("simple",),
						"language"=>array("paginate"=>array("first"=>'«',
							"previous"=>'‹',
							"next"=>'›',
							"last"=>'»'
						)),
						"paging"=>array(
							"pageSize"=>5,
							"pageIndex"=>0,
							"align"=>"left",

						),
					),

				));
				?>
			</div>


<!--			<div class="report-content" >-->
<!--					--><?php
//					\koolreport\amazing\DualChartCard::create(array(
//						"title"=>"AVG SPENDING PER ORDER THIS WEEK",
//						"value"=>$this->dataStore('alldata_bybuyer')->SUM('totalamount')/$this->dataStore('alldata_bybuyer')->COUNT(),
//						"format"=>array(
//							"value"=>array(
//								"type"=>"number",
//								"decimals"=>2,              // Number of decimals to show
//								"decimalPoint"=>",",        // Decimal point character
//								"thousand_sep"=>".",  // Thousand separator
//								"prefix"=>"€ ",
//							)
//						),
//						"cssClass"=>array(
//							"card"=>"my-own-card-class",
//							"tittle"=>"font-bold",
//							"value"=>"big-font",
//							"icon"=>"fa fa-euro"
//						),
//						"cssStyle"=> [
//							"card"=>"background-color:#04a7b8",
//							"title"=>"font-weight:bold",
//							"value"=>"font-style:italic",
//							"icon"=>"font-size:24px;color:white"
//						],
//
//						"chart"=>array(
//							"height"=>"300px",
//							"dataSource"=>$this->dataStore('alldata_bybuyer'),
//							"columns"=>array(
//								"createdAt",
//								"productQuantity"=>array(
//									"type"=>"number",
//									"decimals"=>2,              // Number of decimals to show
//									"decimalPoint"=>",",        // Decimal point character
//									"thousand_sep"=>".",  // Thousand separator
//									"prefix"=>"€",
//								)
//							)
//						),
//						"secondChart"=>array(
//							"dataSource"=>$this->dataStore('alldata_bybuyer'),
//							"columns"=>array(
//								"createdAt",
//								"productQuantity"=>array(
//									"type"=>"number",
//									"decimals"=>0,              // Number of decimals to show
//									"decimalPoint"=>",",        // Decimal point character
//									"thousandSeparator"=>".",  // Thousand separator
//									"prefix"=>"€"
//								)
//							)
//						),
//
//					));
//					?>
<!--				</div>-->
<!---->
<!--				<div class="report-content" style="margin-top: 30px ">-->
<!--					--><?php
//					\koolreport\amazing\DualChartCard::create(array(
//						"title"=>"NUMBER OF ORDERS THIS WEEK ",
//						"value"=>$this->dataStore('alldata_bybuyer')->count(),
//						"format"=>array(
//							"value"=>array(
//								"type"=>"number",
//								"decimals"=>0,              // Number of decimals to show
//								"decimalPoint"=>",",        // Decimal point character
//								"thousand_sep"=>".",  // Thousand separator
//								"prefix"=>"",
//							)
//						),
//						"cssClass"=>array(
//							"card"=>"my-own-card-class",
//							"tittle"=>"font-bold",
//							"value"=>"big-font",
//							"icon"=>"fa fa-euro"
//						),
//						"cssStyle"=> [
//							"card"=>"background-color:#04a678",
//							"title"=>"font-weight:bold",
//							"value"=>"font-style:italic",
//							"icon"=>"font-size:24px;color:white"
//						],
//
//						"chart"=>array(
//							"height"=>"300px",
//							"dataSource"=>$this->dataStore('alldata_bybuyer'),
//							"columns"=>array(
//								"createdAt",
//								"totalamount"=>array(
//									"type"=>"number",
//									"decimals"=>2,              // Number of decimals to show
//									"decimalPoint"=>",",        // Decimal point character
//									"thousand_sep"=>".",  // Thousand separator
//									"prefix"=>"€",
//								)
//							)
//						),
//						"secondChart"=>array(
//							"dataSource"=>$this->dataStore('alldata_bybuyer'),
//							"columns"=>array(
//								"createdAt",
//								"productQuantity"=>array(
//									"type"=>"number",
//									"decimals"=>0,              // Number of decimals to show
//									"decimalPoint"=>",",        // Decimal point character
//									"thousandSeparator"=>".",  // Thousand separator
//									"prefix"=>"€"
//								)
//							)
//						),
//
//					));
//					?>
<!--				</div>-->
<!---->
<!---->
<!---->
<!--				<div class="report-content" style="margin-left: 10px; margin-right:60px; margin-top: 30px; ">-->
<!--					--><?php
//					DataTables::create(array(
//						"dataSource"=>$this->dataStore("alldata_bybuyer")->sort(array(
//							"productlinetotal"=>"desc"
//						)),
//
//						"cssClass"=>array(
//							"table"=>"dt-responsive table table-striped table-bordered",
//						),
//						'width' => '100%',
//						"columns"=>array(
//
//							"createdAt"=>array(
//								"label"=> "DATE",
//								"type"=>"date",
//							),
//
//							"buyerEmail"=>array(
//								"label"=> "BUYER E-MAIL",
//								"type"=>"text"
//							),
//
//							"buyerUserName"=>array(
//							   "type"=>"text"
//							 ),
//
//							"totalamount"=>array(
//								"label"=> "AMOUNT",
//								"type"=>"number",
//								"decimals"=>2,
//								"decimalPoint"=>",",        // Decimal point character
//								"thousand_sep"=>".",  // Thousand separator
//								"prefix"=>"€ "
//							),
//
//
//
//						),
//
//						"options"=>array(
//							"order"=>array(
//								array(3,"desc") //Sort by second column asc
//								),
//								"searching"=>true,
//								"colReorder"=>true,
//								"pagingType"=>array("simple",),
//								"language"=>array("paginate"=>array("first"=>'«',
//										"previous"=>'‹',
//										"next"=>'›',
//										"last"=>'»'
//										)),
//								"paging"=>array(
//								"pageSize"=>5,
//								"pageIndex"=>0,
//								"align"=>"left",
//								"columnDefs"=>array(
//									array("width"=> "50px", "targets"=>"0" ),
//									array("width"=> "50px", "targets"=>"1" )
//								)
//
//							),
//						),
//					));
//					?>
<!--				</div>-->
<!--			</div>-->
		</div>
	</div>
</div>


