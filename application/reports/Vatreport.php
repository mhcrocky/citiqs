<?php
    require_once APPPATH . '/libraries/koolreport/core/autoload.php';

    use \koolreport\processes\Filter;
    use \koolreport\processes\ColumnMeta;
	use \koolreport\processes\CalculatedColumn;
    use \koolreport\pivot\processes\Pivot;
    use \koolreport\processes\Group;
    use \koolreport\processes\Sort;
    use \koolreport\processes\Limit;
	use \koolreport\codeigniter\Friendship;

    class Vatreport extends \koolreport\KoolReport
    {
		use \koolreport\inputs\Bindable;
		use \koolreport\inputs\POSTBinding;
		use \koolreport\export\Exportable;
		use \koolreport\excel\ExcelExportable;
		use \koolreport\excel\BigSpreadsheetExportable;
		use \koolreport\codeigniter\Friendship;

		protected function settings()
        {
            return array(
                'dataSources' => [
                    'alfred' => [
                        'connectionString' => 'mysql:host=' . HOSTNAME . ';dbname=' . DATABASE,
                        'username' => USERNAME,
                        'password' => PASSWORD,
                        'charset' => 'utf8'
                    ]
                ]
            );
        }

		protected function defaultParamValues()
		{
			return array(
				"dateRange"=>array(date("Y-m-d"),date("Y-m-d")),
				"dateRangeVAT"=>array(date("Y-m-d"),date("Y-m-d")),
				"dateRangeEmails"=>array(date("Y-m-d"),date("Y-m-d")),
			);
		}

		protected function bindParamsToInputs()
		{
			return array(
				"dateRange"=>"dateRange",
				"dateRangeVAT"=>"dateRangeVAT",
				"dateRangeEmails"=>"dateRangeEmails",
			);
		}

        public function setup()
        {

        	// local

			$this
				->src('alfred')
				->query('
						SELECT
							tbl_shop_orders.id AS orderId, 
							tbl_shop_orders.amount AS orderAmount, 
							tbl_shop_orders.paid AS orderPaidStatus, 
							tbl_shop_orders.created AS createdAt, 
							tbl_shop_categories.category AS category, 
							tbl_shop_orders.serviceTypeId AS service,
							buyer.id AS buyerId, 
							buyer.email AS buyerEmail, 
							buyer.username AS buyerUserName, 
							vendor.username AS vendorUserName, 
							tbl_shop_order_extended.quantity AS productQuantity, 
							tbl_shop_products_extended.`name` AS productName, 
							tbl_shop_products_extended.price AS productPrice, 
							tbl_shop_products_extended.vatpercentage AS productVat, 
							tbl_shop_products_extended.deliveryPrice AS deliveryproductPrice, 
							tbl_shop_products_extended.deliveryVatpercentage AS deliveryproductVat, 
							tbl_shop_products_extended.pickupPrice AS pickupproductPrice, 
							tbl_shop_products_extended.pickupVatpercentage AS pickupproductVat, 
							
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
							((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
							
							tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS deliveryproductlinetotal,
							((tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.deliveryVatpercentage+100) AS deliveryEXVAT,
							
							tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS pickupproductlinetotal,
							((tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.pickupVatpercentage+100) AS pickupEXVAT,
							tbl_shop_orders.serviceFee AS servicefee
						FROM
						   `tbl_shop_orders` 
						   INNER JOIN
							  `tbl_shop_order_extended` 
							  ON `tbl_shop_orders`.`id` = `tbl_shop_order_extended`.`orderId` 
						   INNER JOIN
							  `tbl_shop_products_extended` 
							  ON `tbl_shop_order_extended`.`productsExtendedId` = `tbl_shop_products_extended`.`id` 
						   INNER JOIN
							  `tbl_shop_products` 
							  ON `tbl_shop_products_extended`.`productId` = `tbl_shop_products`.`id` 
						   INNER JOIN
							  `tbl_shop_categories` 
							  ON `tbl_shop_products`.`categoryId` = `tbl_shop_categories`.`id` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 2
							  )
							  vendor 
							  ON `vendor`.`id` = `tbl_shop_categories`.`userId` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 6 
									OR roleid = 2
							  )
							  buyer 
							  ON `buyer`.`id` = `tbl_shop_orders`.`buyerId` 
						   INNER JOIN
							  `tbl_shop_spots` 
							  ON `tbl_shop_orders`.`spotId` = `tbl_shop_spots`.`id` 
						WHERE
							vendor.id = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND 
							tbl_shop_orders.created >= :start AND 
							tbl_shop_orders.created <= :end AND 
							tbl_shop_orders.serviceTypeId = \'1\'
						ORDER BY
							tbl_shop_categories.category ASC	

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

				->pipe(new CalculatedColumn(array(
					"totalamount"=>function($row){
						return ($row["productPrice"] * $row["productQuantity"]);
					}
				)))

				->pipe(new CalculatedColumn(array(
					"totalvatamount"=>function($row){
						return ($row["productPrice"] * $row["productQuantity"])/(100 + $row["productVat"] )*100  ;
					}
				)))

				->pipe(new CalculatedColumn(array(
					"VATAndAmount"=>function($row){
						return $row["totalamount"] - $row["totalvatamount"]  ;
					}
				)))

				->pipe(new Group(array(
					"by"=>array("category"),
					"sum"=>array("VATAndAmount", "servicefee", "totalamount", "totalvatamount" )
				)))

				->pipe($this->dataStore('VATcategorylocal'))
			;

			//-----------------------------------------------------------------------------------------------------

			// delivery

			$this
				->src('alfred')
				->query('
						SELECT
							tbl_shop_orders.id AS orderId, 
							tbl_shop_orders.amount AS orderAmount, 
							tbl_shop_orders.paid AS orderPaidStatus, 
							tbl_shop_orders.created AS createdAt, 
							tbl_shop_categories.category AS category, 
							tbl_shop_orders.serviceTypeId AS service,
							buyer.id AS buyerId, 
							buyer.email AS buyerEmail, 
							buyer.username AS buyerUserName, 
							vendor.username AS vendorUserName, 
							tbl_shop_order_extended.quantity AS productQuantity, 
							tbl_shop_products_extended.`name` AS productName, 
							tbl_shop_products_extended.price AS productPrice, 
							tbl_shop_products_extended.vatpercentage AS productVat, 
							tbl_shop_products_extended.deliveryPrice AS deliveryproductPrice, 
							tbl_shop_products_extended.deliveryVatpercentage AS deliveryproductVat, 
							tbl_shop_products_extended.pickupPrice AS pickupproductPrice, 
							tbl_shop_products_extended.pickupVatpercentage AS pickupproductVat, 
							
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
							((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
							
							tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS deliveryproductlinetotal,
							((tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.deliveryVatpercentage+100) AS deliveryEXVAT,
							
							tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS pickupproductlinetotal,
							((tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.pickupVatpercentage+100) AS pickupEXVAT,
							tbl_shop_orders.serviceFee AS servicefee
						FROM
						   `tbl_shop_orders` 
						   INNER JOIN
							  `tbl_shop_order_extended` 
							  ON `tbl_shop_orders`.`id` = `tbl_shop_order_extended`.`orderId` 
						   INNER JOIN
							  `tbl_shop_products_extended` 
							  ON `tbl_shop_order_extended`.`productsExtendedId` = `tbl_shop_products_extended`.`id` 
						   INNER JOIN
							  `tbl_shop_products` 
							  ON `tbl_shop_products_extended`.`productId` = `tbl_shop_products`.`id` 
						   INNER JOIN
							  `tbl_shop_categories` 
							  ON `tbl_shop_products`.`categoryId` = `tbl_shop_categories`.`id` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 2
							  )
							  vendor 
							  ON `vendor`.`id` = `tbl_shop_categories`.`userId` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 6 
									OR roleid = 2
							  )
							  buyer 
							  ON `buyer`.`id` = `tbl_shop_orders`.`buyerId` 
						   INNER JOIN
							  `tbl_shop_spots` 
							  ON `tbl_shop_orders`.`spotId` = `tbl_shop_spots`.`id` 
						WHERE
							vendor.id = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND 
							tbl_shop_orders.created >= :start AND 
							tbl_shop_orders.created <= :end AND 
							tbl_shop_orders.serviceTypeId = \'2\'
						ORDER BY
							tbl_shop_categories.category ASC	

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

				->pipe(new CalculatedColumn(array(
					"totalamount"=>function($row){
						return (
							$row["deliveryproductPrice"] * $row["productQuantity"]);

					}
				)))

				->pipe(new CalculatedColumn(array(
					"totalvatamount"=>function($row){
						return ($row["deliveryproductPrice"] * $row["productQuantity"])/(100 + $row["deliveryproductVat"] )*100  ;
					}
				)))

				->pipe(new CalculatedColumn(array(
					"VATAndAmount"=>function($row){
						return $row["totalamount"] - $row["totalvatamount"]  ;
					}
				)))

				->pipe(new Group(array(
					"by"=>array("category"),
					"sum"=>array("VATAndAmount", "servicefee", "totalamount", "totalvatamount" )
				)))

				->pipe($this->dataStore('VATcategorydelivery'))
			;

			//-----------------------------------------------------------------------------------------------------

			// pickup

			$this
				->src('alfred')
				->query('
						SELECT
							tbl_shop_orders.id AS orderId, 
							tbl_shop_orders.amount AS orderAmount, 
							tbl_shop_orders.paid AS orderPaidStatus, 
							tbl_shop_orders.created AS createdAt, 
							tbl_shop_categories.category AS category, 
							buyer.id AS buyerId, 
							buyer.email AS buyerEmail, 
							buyer.username AS buyerUserName, 
							vendor.username AS vendorUserName, 
							tbl_shop_order_extended.quantity AS productQuantity, 
							tbl_shop_products_extended.`name` AS productName, 
							tbl_shop_products_extended.price AS productPrice, 
							tbl_shop_products_extended.vatpercentage AS productVat, 
							tbl_shop_products_extended.deliveryPrice AS deliveryproductPrice, 
							tbl_shop_products_extended.deliveryVatpercentage AS deliveryproductVat, 
							tbl_shop_products_extended.pickupPrice AS pickupproductPrice, 
							tbl_shop_products_extended.pickupVatpercentage AS pickupproductVat, 
							
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
							((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
							
							tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS deliveryproductlinetotal,
							((tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.deliveryVatpercentage+100) AS deliveryEXVAT,
							
							tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS pickupproductlinetotal,
							((tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.pickupVatpercentage+100) AS pickupEXVAT,
							tbl_shop_orders.serviceFee AS servicefee
						FROM
						   `tbl_shop_orders` 
						   INNER JOIN
							  `tbl_shop_order_extended` 
							  ON `tbl_shop_orders`.`id` = `tbl_shop_order_extended`.`orderId` 
						   INNER JOIN
							  `tbl_shop_products_extended` 
							  ON `tbl_shop_order_extended`.`productsExtendedId` = `tbl_shop_products_extended`.`id` 
						   INNER JOIN
							  `tbl_shop_products` 
							  ON `tbl_shop_products_extended`.`productId` = `tbl_shop_products`.`id` 
						   INNER JOIN
							  `tbl_shop_categories` 
							  ON `tbl_shop_products`.`categoryId` = `tbl_shop_categories`.`id` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 2
							  )
							  vendor 
							  ON `vendor`.`id` = `tbl_shop_categories`.`userId` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 6 
									OR roleid = 2
							  )
							  buyer 
							  ON `buyer`.`id` = `tbl_shop_orders`.`buyerId` 
						   INNER JOIN
							  `tbl_shop_spots` 
							  ON `tbl_shop_orders`.`spotId` = `tbl_shop_spots`.`id` 
						WHERE
							vendor.id = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND 
							tbl_shop_orders.created >= :start AND 
							tbl_shop_orders.created <= :end
						ORDER BY
							tbl_shop_categories.category ASC	

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

				->pipe(new CalculatedColumn(array(
					"totalamount"=>function($row){
						return ($row["pickupproductPrice"] * $row["productQuantity"]);
					}
				)))

				->pipe(new CalculatedColumn(array(
					"totalvatamount"=>function($row){
						return ($row["pickupproductPrice"] * $row["productQuantity"])/(100 + $row["pickupproductVat"] )*100  ;
					}
				)))

				->pipe(new CalculatedColumn(array(
					"VATAndAmount"=>function($row){
						return $row["totalamount"] - $row["totalvatamount"]  ;
					}
				)))

				->pipe(new Group(array(
					"by"=>array("category"),
					"sum"=>array("VATAndAmount", "servicefee", "totalamount", "totalvatamount" )
				)))

				->pipe($this->dataStore('VATcategorypickup'))
			;

			//-------------------------------------------------end ----------------------------------------------------

			$this
				->src('alfred')
				->query('
						SELECT
							tbl_shop_products_extended.vatpercentage AS productVat,
                            tbl_shop_products_extended.`name` AS productName,
                            tbl_shop_products_extended.price,
                            tbl_shop_order_extended.quantity,

							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity
							AS AMOUNT,
							((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100)
							AS EXVAT,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity
							-
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.vatpercentage+100)
                            AS VAT

							

                		FROM
							tbl_shop_orders
							INNER JOIN
								tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
							INNER JOIN
								tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
							INNER JOIN
                            	tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
							INNER JOIN

                            	tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
							INNER JOIN
							(
                                SELECT
                                *
                                FROM
                                tbl_user
                                WHERE
                                roleid = 2
                            ) AS vendor
							ON
								vendor.id = tbl_shop_categories.userId
							INNER JOIN
							(
                                SELECT
                                *
                                FROM
                                tbl_user
                                WHERE
                                roleid = 6 OR
                                roleid = 2
                            ) AS buyer
							ON
								buyer.id = tbl_shop_orders.buyerId
							INNER JOIN
							tbl_shop_spots
							ON
								tbl_shop_orders.spotId = tbl_shop_spots.id
						WHERE
							vendor.id = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND
							tbl_shop_orders.created >= :start AND
							tbl_shop_orders.created <= :end

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

				->pipe(new Group(array(
					"by"=>array("productVat"),
					"sum"=>array("AMOUNT", "VAT", "EXVAT")
				)))

				->pipe($this->dataStore('localVATcategorypervatcode'))
			;

			//-----------------------------------------------------------------------------------------------------

			$this
				->src('alfred')
				->query('
						SELECT
							tbl_shop_products_extended.vatpercentage AS productVat,
                            tbl_shop_products_extended.`name` AS productName,
                            tbl_shop_products_extended.price,
                            tbl_shop_order_extended.quantity,
							tbl_shop_products_extended.deliveryVatpercentage AS deliveryproductVat,

							tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity
							AS deliveryAMOUNT,
							((tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.deliveryVatpercentage+100)
							AS deliveryEXVAT,
							tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity
							-
							tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.deliveryVatpercentage+100)
                            AS deliveryVAT

                		FROM
							tbl_shop_orders
							INNER JOIN
								tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
							INNER JOIN
								tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
							INNER JOIN
                            	tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
							INNER JOIN

                            	tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
							INNER JOIN
							(
                                SELECT
                                *
                                FROM
                                tbl_user
                                WHERE
                                roleid = 2
                            ) AS vendor
							ON
								vendor.id = tbl_shop_categories.userId
							INNER JOIN
							(
                                SELECT
                                *
                                FROM
                                tbl_user
                                WHERE
                                roleid = 6 OR
                                roleid = 2
                            ) AS buyer
							ON
								buyer.id = tbl_shop_orders.buyerId
							INNER JOIN
							tbl_shop_spots
							ON
								tbl_shop_orders.spotId = tbl_shop_spots.id
						WHERE
							vendor.id = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND
							tbl_shop_orders.created >= :start AND
							tbl_shop_orders.created <= :end

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

				->pipe(new Group(array(
					"by"=>array("productVat"),
					"sum"=>array("deliveryAMOUNT", "deliveryVAT", "deliveryEXVAT")
				)))

				->pipe($this->dataStore('deliveryVATcategorypervatcode'))
			;

//			//-----------------------------------------------------------------------------------------------------

			$this
				->src('alfred')
				->query('
						SELECT
							tbl_shop_products_extended.vatpercentage AS productVat,
                            tbl_shop_products_extended.`name` AS productName,
                            tbl_shop_products_extended.price,
                            tbl_shop_order_extended.quantity,
							tbl_shop_products_extended.pickupVatpercentage AS pickupproductVat,
							
							tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity
							AS pickupAMOUNT,
							((tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.pickupVatpercentage+100)
							AS pickupEXVAT,
							tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity
							-
							tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.pickupVatpercentage+100)
                            AS pickupVAT

                		FROM
							tbl_shop_orders
							INNER JOIN
								tbl_shop_order_extended ON tbl_shop_orders.id = tbl_shop_order_extended.orderId
							INNER JOIN
								tbl_shop_products_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
							INNER JOIN
                            	tbl_shop_products ON  tbl_shop_products_extended.productId = tbl_shop_products.id
							INNER JOIN

                            	tbl_shop_categories ON  tbl_shop_products.categoryId = tbl_shop_categories.id
							INNER JOIN
							(
                                SELECT
                                *
                                FROM
                                tbl_user
                                WHERE
                                roleid = 2
                            ) AS vendor
							ON
								vendor.id = tbl_shop_categories.userId
							INNER JOIN
							(
                                SELECT
                                *
                                FROM
                                tbl_user
                                WHERE
                                roleid = 6 OR
                                roleid = 2
                            ) AS buyer
							ON
								buyer.id = tbl_shop_orders.buyerId
							INNER JOIN
							tbl_shop_spots
							ON
								tbl_shop_orders.spotId = tbl_shop_spots.id
						WHERE
							vendor.id = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND
							tbl_shop_orders.created >= :start AND
							tbl_shop_orders.created <= :end

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

				->pipe(new Group(array(
					"by"=>array("productVat"),
					"sum"=>array("pickupAMOUNT", "pickupVAT", "pickupEXVAT")
				)))

				->pipe($this->dataStore('pickupVATcategorypervatcode'))
			;

//			//-----------------------------------------------------------------------------------------------------
//



			$this // Payment types
				->src('alfred')
				->query('
						SELECT
							tbl_shop_orders.paymentType AS paymentType,
							tbl_shop_orders.paymentType AS paymentcounttype,
							tbl_shop_orders.amount AS orderTotalAmount,
						 	tbl_shop_orders.serviceFee AS serviceFeeTotalAmount
						FROM
							tbl_shop_orders
						INNER JOIN
							tbl_shop_spots ON tbl_shop_spots.id = tbl_shop_orders.spotId
						INNER JOIN
							tbl_shop_printers ON tbl_shop_spots.printerId = tbl_shop_printers.id
						WHERE
							tbl_shop_printers.userId  = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND
							tbl_shop_orders.created >= :start AND 
							tbl_shop_orders.created <= :end

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

				->pipe(new Group(array(
					"by"=>array("paymentType"),
					"sum"=>array("orderTotalAmount", "serviceFeeTotalAmount"),
					"count"=>array("paymentcounttype")
				)))

				->pipe($this->dataStore('Paymentpertype'))
			;

			$this // Payment types
			->src('alfred')
				->query('
						SELECT
						 	tbl_shop_vendors.serviceFeeTax AS serviceTax,
							tbl_shop_orders.id AS orderId,
							tbl_shop_orders.serviceFee AS orderServicefeeAmount, 
							FORMAT((tbl_shop_orders.serviceFee / (100 + tbl_shop_vendors.serviceFeeTax) * 100),2) AS orderServicefeeEXVAT,
							FORMAT((tbl_shop_orders.serviceFee - tbl_shop_orders.serviceFee / (100 + tbl_shop_vendors.serviceFeeTax) * 100),2) AS orderServicefeeVAT
						FROM
							tbl_shop_orders
						INNER JOIN
							tbl_shop_spots ON tbl_shop_spots.id = tbl_shop_orders.spotId
						INNER JOIN
							tbl_shop_printers ON tbl_shop_spots.printerId = tbl_shop_printers.id
						INNER JOIN
							tbl_shop_vendors ON tbl_shop_vendors.vendorId = tbl_shop_printers.userId
						WHERE
							tbl_shop_printers.userId  = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND
							tbl_shop_orders.created >= :start AND 
							tbl_shop_orders.created <= :end

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

				->pipe(new Group(array(
					"by"=>array("serviceTax"),
					"sum"=>array("orderServicefeeAmount", "orderServicefeeVAT"),
					)))

				->pipe($this->dataStore('ServiceFEEVAT'))
			;

			$this
				->src('alfred')
				->query('
						SELECT
							tbl_shop_orders.id AS orderId, 
							tbl_shop_orders.amount AS orderAmount, 
							tbl_shop_orders.paid AS orderPaidStatus, 
							tbl_shop_orders.created AS createdAt, 
							tbl_shop_categories.category AS category, 
							buyer.id AS buyerId, 
							buyer.email AS buyerEmail, 
							buyer.username AS buyerUserName, 
							vendor.username AS vendorUserName, 
							tbl_shop_order_extended.quantity AS productQuantity, 
							tbl_shop_products_extended.`name` AS productName, 
							tbl_shop_products_extended.price AS productPrice, 
							tbl_shop_products_extended.vatpercentage AS productVat, 
							tbl_shop_products_extended.deliveryPrice AS deliveryproductPrice, 
							tbl_shop_products_extended.deliveryVatpercentage AS deliveryproductVat, 
							tbl_shop_products_extended.pickupPrice AS pickupproductPrice, 
							tbl_shop_products_extended.pickupVatpercentage AS pickupproductVat, 
							
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
							((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
							
							tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS deliveryproductlinetotal,
							((tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.deliveryVatpercentage+100) AS deliveryEXVAT,
							
							tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS pickupproductlinetotal,
							((tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.pickupVatpercentage+100) AS pickupEXVAT,
							tbl_shop_orders.serviceFee AS servicefee
						FROM
							tbl_shop_orders
							INNER JOIN
							tbl_shop_order_extended
							ON
								tbl_shop_orders.id = tbl_shop_order_extended.orderId
							INNER JOIN
							tbl_shop_products_extended
							ON
								tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
							INNER JOIN
							tbl_shop_products
							ON
								tbl_shop_products_extended.productId = tbl_shop_products.id
							INNER JOIN
							tbl_shop_categories
							ON
								tbl_shop_products.categoryId = tbl_shop_categories.id
							INNER JOIN
							(
								SELECT
									*
								FROM
									tbl_user
								WHERE
									roleid = 2
							) AS vendor
							ON
								vendor.id = tbl_shop_categories.userId
							INNER JOIN
							(
								SELECT
									*
								FROM
									tbl_user
								WHERE
									roleid = 6 OR
									roleid = 2
							) AS buyer
							ON
								buyer.id = tbl_shop_orders.buyerId
							INNER JOIN
							tbl_shop_spots
							ON
								tbl_shop_orders.spotId = tbl_shop_spots.id
						WHERE
							vendor.id = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND
							tbl_shop_orders.created >= :start AND
							tbl_shop_orders.created <= :end
						GROUP BY
							orderId

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])
				->pipe(new CalculatedColumn(array(
					"totalamount"=>"{orderAmount}+{servicefee}",
					"totalamount_by_func"=>function($row){
						return $row["productlinetotal"]+$row["servicefee"];
					}
				)))
				->pipe(new Group(array(
					"by"=>array("buyerEmail"),
					"sum"=>array("orderAmount", "servicefee","totalamount")
				)))

				->pipe($this->dataStore('alldata_Orders'))
			;

			$this
				->src('alfred')
				->query('
						SELECT				
								buyer.id AS buyerId,
								buyer.email AS buyerEmail,
								buyer.username AS buyerUserName,
								buyer.mobile AS buyerMobile
							FROM
								tbl_shop_orders
								INNER JOIN
								tbl_shop_order_extended
								ON
									tbl_shop_orders.id = tbl_shop_order_extended.orderId
								INNER JOIN
								tbl_shop_products_extended
								ON
									tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
								INNER JOIN
								tbl_shop_products
								ON
									tbl_shop_products_extended.productId = tbl_shop_products.id
								INNER JOIN
								tbl_shop_categories
								ON
									tbl_shop_products.categoryId = tbl_shop_categories.id
								INNER JOIN
							(
								SELECT
								*
								FROM
										tbl_user
									WHERE
										roleid = 2
								) AS vendor
								ON
									vendor.id = tbl_shop_categories.userId
								INNER JOIN
								(
									SELECT
									*
									FROM
										tbl_user
									WHERE
										roleid = 6 OR
										roleid = 2
								) AS buyer
								ON
									buyer.id = tbl_shop_orders.buyerId
								INNER JOIN
								tbl_shop_spots
								ON
									tbl_shop_orders.spotId = tbl_shop_spots.id
							WHERE
								vendor.id = :vendorId AND
								tbl_shop_orders.paid = \'1\' AND
								tbl_shop_orders.created >= :startemails AND
								tbl_shop_orders.created <= :endemails
						GROUP BY
							orderId

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":startemails"=>$this->params["dateRangeEmails"][0],
					":endemails"=>$this->params["dateRangeEmails"][1]
				])

				->pipe(new Group(array(
					"by"=>array("buyerEmail"),
				)))

				->pipe($this->dataStore('alldata_Emails'))
			;

			$this
				->src('alfred')
				->query('
						SELECT
							tbl_shop_orders.id AS orderId, 
							tbl_shop_orders.amount AS orderAmount, 
							tbl_shop_orders.paid AS orderPaidStatus, 
							tbl_shop_orders.created AS createdAt, 
							tbl_shop_categories.category AS category, 
							buyer.id AS buyerId, 
							buyer.email AS buyerEmail, 
							buyer.username AS buyerUserName, 
							vendor.username AS vendorUserName, 
							tbl_shop_order_extended.quantity AS productQuantity, 
							tbl_shop_products_extended.`name` AS productName, 
							tbl_shop_products_extended.price AS productPrice, 
							tbl_shop_products_extended.vatpercentage AS productVat, 
							tbl_shop_products_extended.deliveryPrice AS deliveryproductPrice, 
							tbl_shop_products_extended.deliveryVatpercentage AS deliveryproductVat, 
							tbl_shop_products_extended.pickupPrice AS pickupproductPrice, 
							tbl_shop_products_extended.pickupVatpercentage AS pickupproductVat, 
							
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
							((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
							
							tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS deliveryproductlinetotal,
							((tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.deliveryVatpercentage+100) AS deliveryEXVAT,
							
							tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS pickupproductlinetotal,
							((tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.pickupVatpercentage+100) AS pickupEXVAT,
							tbl_shop_orders.serviceFee AS servicefee
						FROM
						   `tbl_shop_orders` 
						   INNER JOIN
							  `tbl_shop_order_extended` 
							  ON `tbl_shop_orders`.`id` = `tbl_shop_order_extended`.`orderId` 
						   INNER JOIN
							  `tbl_shop_products_extended` 
							  ON `tbl_shop_order_extended`.`productsExtendedId` = `tbl_shop_products_extended`.`id` 
						   INNER JOIN
							  `tbl_shop_products` 
							  ON `tbl_shop_products_extended`.`productId` = `tbl_shop_products`.`id` 
						   INNER JOIN
							  `tbl_shop_categories` 
							  ON `tbl_shop_products`.`categoryId` = `tbl_shop_categories`.`id` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 2
							  )
							  vendor 
							  ON `vendor`.`id` = `tbl_shop_categories`.`userId` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 6 
									OR roleid = 2
							  )
							  buyer 
							  ON `buyer`.`id` = `tbl_shop_orders`.`buyerId` 
						   INNER JOIN
							  `tbl_shop_spots` 
							  ON `tbl_shop_orders`.`spotId` = `tbl_shop_spots`.`id` 
						WHERE
							vendor.id = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND 
							tbl_shop_orders.created >= :start AND 
							tbl_shop_orders.created <= :end
						ORDER BY
							tbl_shop_categories.category ASC	
                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

				->pipe(new CalculatedColumn(array(
					"totalamount"=>"{productPrice}*{productQuantity}+{deliveryproductPrice}*{productQuantity}+{pickupproductPrice}*{productQuantity}"
				)))

				->pipe(new CalculatedColumn(array(
					"deliverytotalamount"=>"{deliveryproductPrice}*{productQuantity}"
				)))

				->pipe(new CalculatedColumn(array(
					"pickuptotalamount"=>"{pickupproductPrice}*{productQuantity}"
				)))

				->pipe(new CalculatedColumn(array(
					"totalvatamount"=>function($row){
						return ($row["productPrice"] * $row["productQuantity"])/(100 + $row["productVat"] )  ;
					}
				)))

				->pipe(new CalculatedColumn(array(
					"VATAndAmount"=>function($row){
						return $row["totalamount"] - $row["totalvatamount"]  ;
					}
				)))

				->pipe(new Group(array(
					"by"=>array("spotName"),
					"sum"=>array("orderAmount", "servicefee","totalamount")
				)))

				->pipe($this->dataStore('alldata_spot'))
			;


			$this
				->src('alfred')
				->query('
						SELECT
							tbl_shop_orders.id AS orderId, 
							tbl_shop_orders.amount AS orderAmount, 
							tbl_shop_orders.paid AS orderPaidStatus, 
							tbl_shop_orders.created AS createdAt, 
							tbl_shop_categories.category AS category, 
							buyer.id AS buyerId, 
							buyer.email AS buyerEmail, 
							buyer.username AS buyerUserName, 
							vendor.username AS vendorUserName, 
							tbl_shop_order_extended.quantity AS productQuantity, 
							tbl_shop_products_extended.`name` AS productName, 
							tbl_shop_products_extended.price AS productPrice, 
							tbl_shop_products_extended.vatpercentage AS productVat, 
							tbl_shop_products_extended.deliveryPrice AS deliveryproductPrice, 
							tbl_shop_products_extended.deliveryVatpercentage AS deliveryproductVat, 
							tbl_shop_products_extended.pickupPrice AS pickupproductPrice, 
							tbl_shop_products_extended.pickupVatpercentage AS pickupproductVat, 
							
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
							((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
							
							tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity AS deliveryproductlinetotal,
							((tbl_shop_products_extended.deliveryPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.deliveryVatpercentage+100) AS deliveryEXVAT,
							
							tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity AS pickupproductlinetotal,
							((tbl_shop_products_extended.pickupPrice * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.pickupVatpercentage+100) AS pickupEXVAT,
							tbl_shop_orders.serviceFee AS servicefee
						FROM
						   `tbl_shop_orders` 
						   INNER JOIN
							  `tbl_shop_order_extended` 
							  ON `tbl_shop_orders`.`id` = `tbl_shop_order_extended`.`orderId` 
						   INNER JOIN
							  `tbl_shop_products_extended` 
							  ON `tbl_shop_order_extended`.`productsExtendedId` = `tbl_shop_products_extended`.`id` 
						   INNER JOIN
							  `tbl_shop_products` 
							  ON `tbl_shop_products_extended`.`productId` = `tbl_shop_products`.`id` 
						   INNER JOIN
							  `tbl_shop_categories` 
							  ON `tbl_shop_products`.`categoryId` = `tbl_shop_categories`.`id` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 2
							  )
							  vendor 
							  ON `vendor`.`id` = `tbl_shop_categories`.`userId` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 6 
									OR roleid = 2
							  )
							  buyer 
							  ON `buyer`.`id` = `tbl_shop_orders`.`buyerId` 
						   INNER JOIN
							  `tbl_shop_spots` 
							  ON `tbl_shop_orders`.`spotId` = `tbl_shop_spots`.`id` 
						WHERE
							vendor.id = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND 
							tbl_shop_orders.created >= :start AND 
							tbl_shop_orders.created <= :end
						ORDER BY
							tbl_shop_categories.category ASC	
                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

				->pipe(new CalculatedColumn(array(
					"totalamount"=>"{productPrice}*{productQuantity}"
				)))

				->pipe(new CalculatedColumn(array(
					"totalvatamount"=>function($row){
						return ($row["productPrice"] * $row["productQuantity"])/(100 + $row["productVat"] )  ;
					}
				)))

				->pipe(new CalculatedColumn(array(
					"VATAndAmount"=>function($row){
						return $row["totalamount"] - $row["totalvatamount"]  ;
					}
				)))

				->pipe(new Group(array(
					"by"=>array("productName"),
					"count"=>array("productNameAantal"),
					"sum"=>array("totalamount")

				)))

				->pipe($this->dataStore('alldata_orders'))
			;

			$this
				->src('alfred')
				->query('
						SELECT
							tbl_shop_orders.id AS orderId, 
							tbl_shop_orders.amount AS orderAmount, 
							tbl_shop_orders.waiterTip AS waiterTip, 
							tbl_shop_orders.paid AS orderPaidStatus, 
							tbl_shop_orders.created AS createdAt, 
							tbl_shop_categories.category AS category, 
							buyer.id AS buyerId, 
							buyer.email AS buyerEmail, 
							buyer.username AS buyerUserName, 
							vendor.username AS vendorUserName, 
							tbl_shop_order_extended.quantity AS productQuantity, 
							tbl_shop_products_extended.`name` AS productName, 
							tbl_shop_products_extended.price AS productPrice, 
							tbl_shop_products_extended.vatpercentage AS productVat, 
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
							((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
							tbl_shop_orders.serviceFee AS servicefee
						FROM
						   `tbl_shop_orders` 
						   INNER JOIN
							  `tbl_shop_order_extended` 
							  ON `tbl_shop_orders`.`id` = `tbl_shop_order_extended`.`orderId` 
						   INNER JOIN
							  `tbl_shop_products_extended` 
							  ON `tbl_shop_order_extended`.`productsExtendedId` = `tbl_shop_products_extended`.`id` 
						   INNER JOIN
							  `tbl_shop_products` 
							  ON `tbl_shop_products_extended`.`productId` = `tbl_shop_products`.`id` 
						   INNER JOIN
							  `tbl_shop_categories` 
							  ON `tbl_shop_products`.`categoryId` = `tbl_shop_categories`.`id` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 2
							  )
							  vendor 
							  ON `vendor`.`id` = `tbl_shop_categories`.`userId` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 6 
									OR roleid = 2
							  )
							  buyer 
							  ON `buyer`.`id` = `tbl_shop_orders`.`buyerId` 
						   INNER JOIN
							  `tbl_shop_spots` 
							  ON `tbl_shop_orders`.`spotId` = `tbl_shop_spots`.`id` 
						WHERE
							vendor.id = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND 
							tbl_shop_orders.created >= :start AND 
							tbl_shop_orders.created <= :end AND 
							tbl_shop_orders.waiterTip != 0
						ORDER BY
							tbl_shop_orders.id ASC	

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

//				->pipe(new CalculatedColumn(array(
//					"totalamount"=>"{productPrice}*{productQuantity}"
//				)))
//
//				->pipe(new CalculatedColumn(array(
//					"totalvatamount"=>function($row){
//						return ($row["productPrice"] * $row["productQuantity"])/(100 + $row["productVat"] )  ;
//					}
//				)))
//
//				->pipe(new CalculatedColumn(array(
//					"VATAndAmount"=>function($row){
//						return $row["totalamount"] - $row["totalvatamount"]  ;
//					}
//				)))

				->pipe(new Group(array(
					"by"=>array("orderId")
				)))

				->pipe($this->dataStore('alldata_waiter'))
			;


			$this
				->src('alfred')
				->query('
						SELECT
							tbl_shop_orders.id AS orderId, 
							tbl_shop_orders.amount AS orderAmount, 
							tbl_shop_orders.waiterTip AS waiterTip, 
							tbl_shop_orders.paid AS orderPaidStatus, 
							tbl_shop_orders.created AS createdAt, 
							tbl_shop_orders.paymentType AS paymentType, 
							tbl_shop_categories.category AS category, 
							buyer.id AS buyerId, 
							buyer.email AS buyerEmail, 
							buyer.username AS buyerUserName, 
							vendor.username AS vendorUserName, 
							tbl_shop_order_extended.quantity AS productQuantity, 
							tbl_shop_products_extended.`name` AS productName, 
							tbl_shop_products_extended.price AS productPrice, 
							tbl_shop_products_extended.vatpercentage AS productVat, 
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
							((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
							tbl_shop_orders.serviceFee AS servicefee
						FROM
						   `tbl_shop_orders` 
						   INNER JOIN
							  `tbl_shop_order_extended` 
							  ON `tbl_shop_orders`.`id` = `tbl_shop_order_extended`.`orderId` 
						   INNER JOIN
							  `tbl_shop_products_extended` 
							  ON `tbl_shop_order_extended`.`productsExtendedId` = `tbl_shop_products_extended`.`id` 
						   INNER JOIN
							  `tbl_shop_products` 
							  ON `tbl_shop_products_extended`.`productId` = `tbl_shop_products`.`id` 
						   INNER JOIN
							  `tbl_shop_categories` 
							  ON `tbl_shop_products`.`categoryId` = `tbl_shop_categories`.`id` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 2
							  )
							  vendor 
							  ON `vendor`.`id` = `tbl_shop_categories`.`userId` 
						   INNER JOIN
							  (
								 SELECT *
								 FROM
									tbl_user 
								 WHERE
									roleid = 6 
									OR roleid = 2
							  )
							  buyer 
							  ON `buyer`.`id` = `tbl_shop_orders`.`buyerId` 
						   INNER JOIN
							  `tbl_shop_spots` 
							  ON `tbl_shop_orders`.`spotId` = `tbl_shop_spots`.`id` 
						WHERE
							vendor.id = :vendorId AND
							tbl_shop_orders.paid = \'1\' AND 
							tbl_shop_orders.created >= :start AND 
							tbl_shop_orders.created <= :end
						ORDER BY
							tbl_shop_orders.id ASC	

                ')
				->params([
					":vendorId" => $this->params["vendorId"],
					":start"=>$this->params["dateRange"][0],
					":end"=>$this->params["dateRange"][1]
				])

//				->pipe(new CalculatedColumn(array(
//					"totalamount"=>"{productPrice}*{productQuantity}"
//				)))
//
//				->pipe(new CalculatedColumn(array(
//					"totalvatamount"=>function($row){
//						return ($row["productPrice"] * $row["productQuantity"])/(100 + $row["productVat"] )  ;
//					}
//				)))
//
//				->pipe(new CalculatedColumn(array(
//					"VATAndAmount"=>function($row){
//						return $row["totalamount"] - $row["totalvatamount"]  ;
//					}
//				)))

				->pipe(new Group(array(
					"by"=>array("orderId")
				)))

				->pipe($this->dataStore('alldata_orderlines'))
			;

		}



    }

