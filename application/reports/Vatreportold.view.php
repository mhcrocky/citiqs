<?php
	use \koolreport\widgets\koolphp\Card;
	use \koolreport\widgets\koolphp\Table;
	use \koolreport\datagrid\DataTables;
	use \koolreport\inputs\Bindable;
	use \koolreport\inputs\POSTBinding;
	use \koolreport\inputs\DateRangePicker;
	use \koolreport\inputs\DateTimePicker;


?>

<script src='https://code.jquery.com/jquery-1.12.3.js'></script>
<script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" charset="utf-8"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">


<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>

<script type="text/javascript" src="DataTables/datatables.min.js"></script>

<div class="main-wrapper">
	<div class="col-half background-apricot height" style="text-align:left; font-size: smaller" >
		<div class="align-top width-650" style="margin-bottom: 30px">
			<div class="report-content" style="margin-top: 30px">
				<form id="selectdate" method="post" >
					<div class="mb-35" >
						<?php
						$dateRange= DateRangePicker::create(array(
								"format"=>"D/M/YYYY HH:mm",
								"name"=>"dateRange",
								"options"=>array(
										"showWeekNumbers"=>true,
										"timePicker" =>true,
										"timePicker24Hour" => true
								)
						))
						?>
					</div>
					<div class="form-group text-center">
						<button class="btn btn-success" style="border-radius: 50px; background-color: #72b19f"><i class="glyphicon glyphicon-refresh"></i> LOAD</button>
					</div>
					<button type="submit" formaction="<?php echo base_url() . 'Report_table/export/' . $_SESSION['userId']; ?>" class="btn btn-primary">Download EXCEL</button>
				</form>

				<div class="report-content" style="margin-top: 30px">
					<?php
					\koolreport\amazing\ChartCard::create(array(
						"title"=>"CATEGORY TOTALS",
						"value"=>$this->dataStore("VATcategory")->sum("totalamount"),
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
							"icon"=>"fa fa-calendar"
						),
						"cssStyle"=> [
							"card"=>"background-color:#72b19f",
							"title"=>"font-weight:bold",
							"value"=>"font-style:italic",
							"icon"=>"font-size:24px;color:white"
						],
					));
					?>
				</div>
			</div>
				<div class="report-content" style=" margin-left: -10px; margin-top: 30px">
					<?php
					DataTables::create(array(
						"dataSource"=>$this->dataStore("VATcategory")->sort(array(
							"productQuantity"=>"desc"
						)),
						"responsive"=>true,
						"showFooter"=>"bottom",
						"width"=>"600px",
						"cssClass"=>array(
							"table"=>"dt-responsive table table-striped table-bordered",
						),
						"columns"=>array(

		//					"createdAt"=>array(
		//						"label"=> "DAY",
		//						"type"=>"datetime",
		//						"format"=>"Y-m-d H:i:s",
		//						"displayFormat"=>"d-m-Y"
		//					),

							"category"=>array(
								"label"=> "CATEGORY",
								"type"=>"text"
							),

							"totalamount"=>array(
								"label"=> "AMOUNT",
								"type"=>"number",
								"decimals"=>2,
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€ ",
								"footer"=>"sum"

							),

							"totalvatamount"=>array(
								"label"=> "EXVAT",
								"type"=>"number",
								"decimals"=>2,
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€ ",
								"footer"=>"sum"
							),

							"VATAndAmount"=>array(
								"label"=> "VAT",
								"type"=>"number",
								"decimals"=>2,
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€ ",
								"footer"=>"sum"
							),


						),

						"options"=>array(
							"order"=>array(
								array(0,"asc") //Sort by second column asc
							),
							"searching"=>true,
							"colReorder"=>true,
							"pagingType"=>array("simple"),
							"language"=>array("paginate"=>array("first"=>'«',
								"previous"=>'‹',
								"next"=>'›',
								"last"=>'»'
							)),
							"paging"=>true,
							"columnDefs"=>array(
								array("width"=> "50px", "targets"=>"1" )
							)
						),


					));
					?>
				</div>
		</div>
		<!--		</form>-->

				<div class="align-top width-650" style="margin-bottom: 30px; ">
					<div class="mb-35" style="margin-top: 30px; margin-left: -10px;">
						<?php
						\koolreport\amazing\ChartCard::create(array(
								"title"=>"VAT PER PERCENTAGE",
								"value"=>$this->dataStore("VATcategorypervatcode")->sum("VAT"),
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
										"icon"=>"fa fa-calendar"
								),
								"cssStyle"=> [
										"card"=>"background-color:#72b19f",
										"title"=>"font-weight:bold",
										"value"=>"font-style:italic",
										"icon"=>"font-size:24px;color:white"
								],
						));
						?>
					</div>
					<div class="report-content" style=" margin-left: -10px;">
						<?php
						DataTables::create(array(
							"dataSource"=>$this->dataStore("VATcategorypervatcode"),
							 "responsive"=>true,
							"showFooter"=>"bottom",
							"width"=>"600px",
							"cssClass"=>array(
								"table"=>"dt-responsive table table-striped table-bordered",
							),
							"columns"=>array(

								//					"createdAt"=>array(
								//						"label"=> "DAY",
								//						"type"=>"datetime",
								//						"format"=>"Y-m-d H:i:s",
								//						"displayFormat"=>"d-m-Y"
								//					),
								"productVat"=>array(
									"label"=> "VAT percentage",
									"type"=>"number",
									"decimals"=>0,
									"prefix"=>"% "
								),

								"AMOUNT"=>array(
									"label"=> "INCL",
									"type"=>"number",
									"decimals"=>2,
									"decimalPoint"=>",",        // Decimal point character
									"thousand_sep"=>".",  // Thousand separator
									"prefix"=>"€ ",
									"footer"=>"sum"
								),

								"EXVAT"=>array(
									"label"=> "EXCL",
									"type"=>"number",
									"decimals"=>2,
									"decimalPoint"=>",",        // Decimal point character
									"thousand_sep"=>".",  // Thousand separator
									"prefix"=>"€ ",
									"footer"=>"sum"

								),

								"VAT"=>array(
									"label"=> "V.A.T",
									"type"=>"number",
									"decimals"=>2,
									"decimalPoint"=>",",        // Decimal point character
									"thousand_sep"=>".",  // Thousand separator
									"prefix"=>"€ ",
									"footer"=>"sum"
								),

//								"totalamount"=>array(
//									"label"=> "TOTAL",
//									"type"=>"number",
//									"decimals"=>2,
//									"decimalPoint"=>",",        // Decimal point character
//									"thousand_sep"=>".",  // Thousand separator
//									"prefix"=>"€ ",
//									"footer"=>"sum"
//								),


							),

							"options"=>array(
								"order"=>array(
									array(0,"asc") //Sort by second column asc
								),
								"searching"=>true,
								"colReorder"=>true,
								"pagingType"=>array("simple"),
								"language"=>array("paginate"=>array("first"=>'«',
									"previous"=>'‹',
									"next"=>'›',
									"last"=>'»'
								)),
								"paging"=>true,
								"columnDefs"=>array(
									array("width"=> "50px", "targets"=>"1" )
								)
							),


						));
						?>
					</div>
				</div>

			<div class="align-top width-650">
				<div class="mb-35" style="margin-top: 30px; margin-left: -10px;">
					<?php
					\koolreport\amazing\ChartCard::create(array(
							"title"=>"AMOUNTS PER PAYMENT TYPE",
							"value"=>$this->dataStore("Paymentpertype")->sum("orderTotalAmount"),
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
									"icon"=>"fa fa-calendar"
							),
							"cssStyle"=> [
									"card"=>"background-color:#72b19f",
									"title"=>"font-weight:bold",
									"value"=>"font-style:italic",
									"icon"=>"font-size:24px;color:white"
							],
					));
					?>
				</div>
				<div class="report-content" style=" margin-left: -10px; ">
					<?php
					DataTables::create(array(
						"dataSource"=>$this->dataStore("Paymentpertype"),
						"showFooter"=>"bottom",
							"responsive"=>true,
						"width"=>"600px",
						"cssClass"=>array(
							"table"=>"dt-responsive table table-striped table-bordered",
						),
						"columns"=>array(

							//					"createdAt"=>array(
							//						"label"=> "DAY",
							//						"type"=>"datetime",
							//						"format"=>"Y-m-d H:i:s",
							//						"displayFormat"=>"d-m-Y"
							//					),

//														tbl_shop_orders.paymentType AS paymentType,
//							SUM(tbl_shop_orders.amount) AS orderTotalAmount,
//						 	SUM(tbl_shop_orders.serviceFee) AS serviceFeeTotalAmount
//
							"paymentType"=>array(
								"label"=> "PAYMENT TYPE",
								"type"=>"text"
							),

							"paymentcounttype"=>array(
									"label"=> "PAYMENT TYPE #",
									"type"=>"number"
							),

							"orderTotalAmount"=>array(
								"label"=> "AMOUNT",
								"type"=>"number",
								"decimals"=>2,
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€ ",
								"footer"=>"sum"
							),

							"serviceFeeTotalAmount"=>array(
								"label"=> "SERVICE FEE",
								"type"=>"number",
								"decimals"=>2,
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€ ",
								"footer"=>"sum"

							),

//							"VAT"=>array(
//								"label"=> "V.A.T",
//								"type"=>"number",
//								"decimals"=>2,
//								"decimalPoint"=>",",        // Decimal point character
//								"thousand_sep"=>".",  // Thousand separator
//								"prefix"=>"€ ",
//								"footer"=>"sum"
//							),

//								"ORDERID"=>array(
//									"label"=> "ORDERID",
//									"type"=>"number",
//									"decimals"=>0,
//									"decimalPoint"=>",",        // Decimal point character
//									"thousand_sep"=>""  // Thousand separator
//									"prefix"=>"",
//									"footer"=>""
//								),


						),

						"options"=>array(
							"order"=>array(
								array(0,"asc") //Sort by second column asc
							),
							"searching"=>true,
							"colReorder"=>true,
							"pagingType"=>array("simple"),
							"language"=>array("paginate"=>array("first"=>'«',
								"previous"=>'‹',
								"next"=>'›',
								"last"=>'»'
							)),
							"paging"=>true,
							"columnDefs"=>array(
								array("width"=> "50px", "targets"=>"1" )
							)
						),


					));
					?>
				</div>
			</div>
<!-- 				->pipe(new Group(array(
					"by"=>array("spotName"),
					"sum"=>array("orderAmount", "servicefee","totalamount")
				)))-->
		<div class="align-top width-650" style="margin-bottom: 30px">
			<div class="mb-35" style="margin-top: 30px; margin-left: -10px;">
				<?php
				\koolreport\amazing\ChartCard::create(array(
						"title"=>"AMOUNTS PER SPOT TYPE",
						"value"=>$this->dataStore("alldata_spot")->sum("totalamount"),
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
								"icon"=>"fa fa-calendar"
						),
						"cssStyle"=> [
								"card"=>"background-color:#72b19f",
								"title"=>"font-weight:bold",
								"value"=>"font-style:italic",
								"icon"=>"font-size:24px;color:white"
						],
				));
				?>
			</div>

			<div class="report-content" style=" margin-left: -10px; ">
				<?php
				DataTables::create(array(
						"dataSource"=>$this->dataStore("alldata_spot"),
						"showFooter"=>"bottom",
						"responsive"=>true,
						"width"=>"600px",
						"cssClass"=>array(
								"table"=>"dt-responsive table table-striped table-bordered",
						),
						"columns"=>array(

								"spotName"=>array(
										"label"=> "SPOT",
										"type"=>"text"
								),

								"totalamount"=>array(
										"label"=> "AMOUNT INCL",
										"type"=>"number",
										"decimals"=>2,
										"decimalPoint"=>",",        // Decimal point character
										"thousand_sep"=>".",  // Thousand separator
										"prefix"=>"€ ",
										"footer"=>"sum"
								),
						),

						"options"=>array(
								"order"=>array(
										array(0,"asc") //Sort by second column asc
								),
								"searching"=>true,
								"colReorder"=>true,
								"pagingType"=>array("simple"),
								"language"=>array("paginate"=>array("first"=>'«',
										"previous"=>'‹',
										"next"=>'›',
										"last"=>'»'
								)),
								"paging"=>true,
								"columnDefs"=>array(
										array("width"=> "50px", "targets"=>"1" )
								)
						),


				));
				?>
			</div>
		</div>

			<div class="align-top width-650" style="margin-bottom: 30px">
				<div class="mb-35" style=" margin-left: -10px;">
					<?php
					\koolreport\amazing\ChartCard::create(array(
							"title"=>"TOTAL SERVICE FEE",
							"value"=>$this->dataStore("ServiceFEEVAT")->sum("orderServicefeeAmount"),
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
									"icon"=>"fa fa-calendar"
							),
							"cssStyle"=> [
									"card"=>"background-color:#72b19f",
									"title"=>"font-weight:bold",
									"value"=>"font-style:italic",
									"icon"=>"font-size:24px;color:white"
							],
					));
					?>
				</div>
				<div class="report-content" style=" margin-left: -10px; ">
					<?php
					DataTables::create(array(
							"dataSource"=>$this->dataStore("ServiceFEEVAT"),
							"showFooter"=>"bottom",
							"responsive"=>true,
							"width"=>"600px",
							"cssClass"=>array(
									"table"=>"dt-responsive table table-striped table-bordered",
							),
							"columns"=>array(

									"serviceTax"=>array(
											"label"=> "VAT PERCENTAGE",
											"type"=>"number",
											"decimals"=>0,
											"decimalPoint"=>",",        // Decimal point character
											"thousand_sep"=>".",  // Thousand separator
											"prefix"=>"% "
									),

									"orderServicefeeAmount"=>array(
											"label"=> "SERVICE FEE INCL",
											"type"=>"number",
											"decimals"=>2,
											"decimalPoint"=>",",        // Decimal point character
											"thousand_sep"=>".",  // Thousand separator
											"prefix"=>"€ ",
											"footer"=>"sum"
									),

									"orderServicefeeVAT"=>array(
											"label"=> "VAT AMOUNT",
											"type"=>"number",
											"decimals"=>2,
											"decimalPoint"=>",",        // Decimal point character
											"thousand_sep"=>".",  // Thousand separator
											"prefix"=>"€ ",
											"footer"=>"sum"
									),

							),

							"options"=>array(
									"order"=>array(
											array(0,"asc") //Sort by second column asc
									),
									"searching"=>true,
									"colReorder"=>true,
									"pagingType"=>array("simple"),
									"language"=>array("paginate"=>array("first"=>'«',
											"previous"=>'‹',
											"next"=>'›',
											"last"=>'»'
									)),
									"paging"=>true,
									"columnDefs"=>array(
											array("width"=> "50px", "targets"=>"1" )
									)
							),
					));
					?>
				</div>
			</div>

	</div>

	<div class="col-half background-apricot height-100" style="text-align:left; font-size: smaller" >
	<div class="align-top width-650" style="margin-bottom: 30px; margin-top: 30px">
				<div class="report-content" style=" margin-left: -10px; ">
					<form id="selectdateemails" method="post" >
						<div class="mb-35" >
							<?php
							$dateRange= DateRangePicker::create(array(
									"format"=>"D/M/YYYY",
									"name"=>"dateRangeEmails"
							))
							?>
						</div>
						<div class="form-group text-center">
							<button class="btn btn-success" style="border-radius: 50px; background-color: #72b19f"><i class="glyphicon glyphicon-refresh"></i> LOAD</button>
						</div>
						<div class="form-group text-left">
							<button type="submit" formaction="<?php echo base_url() . 'Report_table/exportemails1/' . $_SESSION['userId']; ?>" class="btn btn-primary">Download EXCEL</button>
						</div>
					</form>
					<?php
					DataTables::create(array(
							"dataSource"=>$this->dataStore("alldata_Emails"),
							"showFooter"=>"bottom",
							"responsive"=>true,
							"width"=>"600px",
							"cssClass"=>array(
									"table"=>"dt-responsive table table-striped table-bordered",
							),
							"columns"=>array(

									"buyerEmail"=>array(
											"label"=> "EMAIL",
											"type"=>"text"
									),

									"buyerUserName"=>array(
											"label"=> "NAME",
											"type"=>"text"
									),

									"buyerMobile"=>array(
											"label"=> "MOBILE",
											"type"=>"text",
									),

//									"serviceFeeTotalAmount"=>array(
//											"label"=> "SERVICE FEE",
//											"type"=>"number",
//											"decimals"=>2,
//											"decimalPoint"=>",",        // Decimal point character
//											"thousand_sep"=>".",  // Thousand separator
//											"prefix"=>"€ ",
//											"footer"=>"sum"
//
//									),

//							"VAT"=>array(
//								"label"=> "V.A.T",
//								"type"=>"number",
//								"decimals"=>2,
//								"decimalPoint"=>",",        // Decimal point character
//								"thousand_sep"=>".",  // Thousand separator
//								"prefix"=>"€ ",
//								"footer"=>"sum"
//							),

//								"ORDERID"=>array(
//									"label"=> "ORDERID",
//									"type"=>"number",
//									"decimals"=>0,
//									"decimalPoint"=>",",        // Decimal point character
//									"thousand_sep"=>""  // Thousand separator
//									"prefix"=>"",
//									"footer"=>""
//								),


							),

							"options"=>array(
									"order"=>array(
											array(0,"asc") //Sort by second column asc
									),
									"searching"=>true,
									"colReorder"=>true,
									"pagingType"=>array("simple"),
									"language"=>array("paginate"=>array("first"=>'«',
											"previous"=>'‹',
											"next"=>'›',
											"last"=>'»'
									)),
									"paging"=>true,
									"columnDefs"=>array(
											array("width"=> "50px", "targets"=>"1" )
									)
							),
					));
					?>
				</div>
			</div>

		<div class="align-top width-650" style="margin-bottom: 30px; margin-top: 30px">
			<div class="align-top width-650" style="margin-bottom: 30px">
				<div class="mb-35" style=" margin-left: -10px;">
					<?php
					\koolreport\amazing\ChartCard::create(array(
							"title"=>"PER PRODUCT",
							"value"=>$this->dataStore("alldata_orders")->sum("totalamount"),
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
									"icon"=>"fa fa-calendar"
							),
							"cssStyle"=> [
									"card"=>"background-color:#72b19f",
									"title"=>"font-weight:bold",
									"value"=>"font-style:italic",
									"icon"=>"font-size:24px;color:white"
							],
					));
					?>
				</div>
		<?php
		DataTables::create(array(
				"dataSource"=>$this->dataStore("alldata_orders"),
				"showFooter"=>"bottom",
				"responsive"=>true,
				"width"=>"600px",
				"cssClass"=>array(
						"table"=>"dt-responsive table table-striped table-bordered",
				),
				"columns"=>array(


						// orderAmount", "servicefee","totalamount

						"productName"=>array(
								"label"=> "PRODUCT",
								"type"=>"text"

						),

						"productNameAantal"=>array(
								"label"=> "AANTAL",
								"type"=>"number",

						),

						"productPrice"=>array(
								"label"=> "PRIJS",
								"type"=>"number",
								"decimals"=>2,
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€ "
						),

						"totalamount"=>array(
								"label"=> "TOTAL",
								"type"=>"number",
								"decimals"=>2,
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"€ ",
								"footer"=>"sum"

						),

							"productVat"=>array(
								"label"=> "V.A.T",
								"type"=>"number",
								"decimals"=>2,
								"decimalPoint"=>",",        // Decimal point character
								"thousand_sep"=>".",  // Thousand separator
								"prefix"=>"% ",
								"footer"=>"sum"
							),

//								"ORDERID"=>array(
//									"label"=> "ORDERID",
//									"type"=>"number",
//									"decimals"=>0,
//									"decimalPoint"=>",",        // Decimal point character
//									"thousand_sep"=>""  // Thousand separator
//									"prefix"=>"",
//									"footer"=>""
//								),


				),

				"options"=>array(
						"order"=>array(
								array(0,"asc") //Sort by second column asc
						),
						"searching"=>true,
						"colReorder"=>true,
						"pagingType"=>array("simple"),
						"language"=>array("paginate"=>array("first"=>'«',
								"previous"=>'‹',
								"next"=>'›',
								"last"=>'»'
						)),
						"paging"=>true,
						"columnDefs"=>array(
								array("width"=> "50px", "targets"=>"1" )
						)
				),
		));
		?>
	</div>

			<div class="align-top width-650" style="margin-bottom: 30px; margin-top: 30px">
				<div class="align-top width-650" style="margin-bottom: 30px">
					<div class="mb-35" style=" margin-left: -10px;">
						<?php
						\koolreport\amazing\ChartCard::create(array(
								"title"=>"WAITER TIP PER ORDER",
								"value"=>$this->dataStore("alldata_waiter")->sum("waiterTip"),
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
										"icon"=>"fa fa-calendar"
								),
								"cssStyle"=> [
										"card"=>"background-color:#72b19f",
										"title"=>"font-weight:bold",
										"value"=>"font-style:italic",
										"icon"=>"font-size:24px;color:white"
								],
						));
						?>
					</div>
					<?php
					DataTables::create(array(
							"dataSource"=>$this->dataStore("alldata_waiter"),
							"showFooter"=>"bottom",
							"responsive"=>true,
							"width"=>"600px",
							"cssClass"=>array(
									"table"=>"dt-responsive table table-striped table-bordered",
							),
							"columns"=>array(


								// orderAmount", "servicefee","totalamount

									"orderId"=>array(
											"label"=> "ORDER",
											"type"=>"text"

									),

									"waiterTip"=>array(
											"label"=> "TIP",
											"type"=>"number",
											"decimals"=>2,
											"decimalPoint"=>",",        // Decimal point character
											"thousand_sep"=>".",  // Thousand separator
											"prefix"=>"€ ",
											"footer"=>"sum"
									),

							),

							"options"=>array(
									"order"=>array(
											array(0,"asc") //Sort by second column asc
									),
									"searching"=>true,
									"colReorder"=>true,
									"pagingType"=>array("simple"),
									"language"=>array("paginate"=>array("first"=>'«',
											"previous"=>'‹',
											"next"=>'›',
											"last"=>'»'
									)),
									"paging"=>true,
									"columnDefs"=>array(
											array("width"=> "50px", "targets"=>"1" )
									)
							),
					));
					?>
				</div>
</div>
</div>
</div>

</div>

