<?php
	use \koolreport\datagrid\DataTables;
	use \koolreport\widgets\koolphp\Card;
	use \koolreport\amazing\Theme;
?>

<div class="main-wrapper-nh">
	<div class="col-half background-apricot height-100" style="text-align:left; font-size: smaller">
<div class="text-center" style="margin-bottom: -30px; margin-top: -50px">
	</div>
		<div class="report-content" >
		<?php
		\koolreport\amazing\DualChartCard::create(array(
			"title"=>"TOTAL INCOME",

			"value"=>$this->dataStore("dayreport_report")->sum("total"),
			"prefix" => "€ ",
			"cssClass"=>array(
				"icon"=>"fa fa-euro"
			),
			"cssStyle"=> [
				"card"=>"background-color:Blue",
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
						"type"=>"number",
						"decimals"=>2,              // Number of decimals to show
						"decimalPoint"=>".",        // Decimal point character
						"thounsandSeparator"=>",",  // Thousand separator
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
						"decimalPoint"=>".",        // Decimal point character
						"thounsandSeparator"=>",",  // Thousand separator
						"prefix"=>"€"
					)
				)
			),

		));
		?>
		</div>
		<div class="report-content" style="margin-bottom: -30px; margin-top: -50px">
			<?php
			DataTables::create(array(
				"responsive"=>true,
				"dataSource"=>$this->dataStore("dayreport_report")->sortKeysDesc("DateCreated"),

				"themeBase"=>"bs4", // Optional option to work with Bootsrap 4
				"cssClass"=>array(
					"table"=>"table table-striped table-bordered"
				),
				'width' => '100%',
				"columns"=>array(
					"DateCreated"=>array(
						"label"=> "Date-day",
						"type"=>"date"
					),
					"total"=>array(
						"label"=> "Total",
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
</div>
