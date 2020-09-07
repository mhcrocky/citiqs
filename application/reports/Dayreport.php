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
	use \koolreport\inputs\Bindable;
	use \koolreport\inputs\POSTBinding;

    class Dayreport extends \koolreport\KoolReport
    {
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
				"dateRange"=>array('2017-07-01','2017-07-31'),
			);
		}

		protected function bindParamsToInputs()
		{
			return array(
				"dateRange"=>"dateRangeInput",
			);
		}

        public function setup()
        {
            $this
                ->src('alfred')
                ->query('
						SELECT
							SUM( tbl_shop_orders.serviceFee ) as servicefee,
							DATE( tbl_shop_orders.created ) as DateCreated,
							SUM( tbl_shop_orders.amount ) as amount,
							SUM( tbl_shop_orders.amount + tbl_shop_orders.serviceFee ) AS total,
							tbl_shop_spots.spotName,
							tbl_user.username,
							tbl_user.first_name,
							tbl_user.id 
						FROM
							tbl_shop_orders
							INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
							INNER JOIN tbl_shop_printers ON tbl_shop_spots.printerId = tbl_shop_printers.id
							INNER JOIN tbl_user ON tbl_shop_printers.userId = tbl_user.id 
						WHERE
							tbl_user.id = :vendorId
							AND tbl_shop_orders.paid = \'1\' 
						GROUP BY
							DATE( tbl_shop_orders.created ) 

                ')
                ->params([
                    ":vendorId" => $this->params["vendorId"]
                ])
                ->pipe($this->dataStore('dayreport_report'))
                ;

            ///
			///
			///

			$this
				->src('alfred')
				->query('
						SELECT
							SUM( tbl_shop_orders.serviceFee ) as servicefee,
							DATE( tbl_shop_orders.created ) as DateCreated,
							SUM( tbl_shop_orders.amount ) as amount,
							SUM( tbl_shop_orders.amount + tbl_shop_orders.serviceFee ) AS total,
							tbl_shop_spots.spotName,
							tbl_user.username,
							tbl_user.first_name,
							tbl_user.id 
						FROM
							tbl_shop_orders
							INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
							INNER JOIN tbl_shop_printers ON tbl_shop_spots.printerId = tbl_shop_printers.id
							INNER JOIN tbl_user ON tbl_shop_printers.userId = tbl_user.id 
						WHERE
							tbl_user.id = :vendorId
							AND tbl_shop_orders.paid = \'1\' 
							AND DATE(tbl_shop_orders.created) = CURRENT_DATE -1
						GROUP BY
							DATE( tbl_shop_orders.created ) 

                ')
				->params([
					":vendorId" => $this->params["vendorId"]
				])
				->pipe($this->dataStore('dayreport_yesterday'))
			;

			$this
				->src('alfred')
				->query('
						SELECT
							SUM( tbl_shop_orders.serviceFee ) as servicefee,
							DATE( tbl_shop_orders.created ) as DateCreated,
							SUM( tbl_shop_orders.amount ) as amount,
							SUM( tbl_shop_orders.amount + tbl_shop_orders.serviceFee ) AS total,
							tbl_shop_spots.spotName,
							tbl_user.username,
							tbl_user.first_name,
							tbl_user.id 
						FROM
							tbl_shop_orders
							INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
							INNER JOIN tbl_shop_printers ON tbl_shop_spots.printerId = tbl_shop_printers.id
							INNER JOIN tbl_user ON tbl_shop_printers.userId = tbl_user.id 
						WHERE
							tbl_user.id = :vendorId
							AND tbl_shop_orders.paid = \'1\' 
							AND DATE(tbl_shop_orders.created) = CURRENT_DATE() 
						GROUP BY
							DATE( tbl_shop_orders.created ) 

                ')
				->params([
					":vendorId" => $this->params["vendorId"]
				])
				->pipe($this->dataStore('dayreport_day'))
			;

			$this
				->src('alfred')
				->query('
						SELECT
							SUM( tbl_shop_orders.serviceFee ) as servicefee,
							DATE( tbl_shop_orders.created ) as DateCreated,
							SUM( tbl_shop_orders.amount ) as amount,
							SUM( tbl_shop_orders.amount + tbl_shop_orders.serviceFee ) AS total,
							tbl_shop_spots.spotName,
							tbl_user.username,
							tbl_user.first_name,
							tbl_user.id 
						FROM
							tbl_shop_orders
							INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
							INNER JOIN tbl_shop_printers ON tbl_shop_spots.printerId = tbl_shop_printers.id
							INNER JOIN tbl_user ON tbl_shop_printers.userId = tbl_user.id 
						WHERE
							tbl_user.id = :vendorId
							AND tbl_shop_orders.paid = \'1\' 
							AND WEEK(tbl_shop_orders.created,1) = WEEK(CURRENT_DATE(),1) 
						GROUP BY
							DATE( tbl_shop_orders.created ) 

                ')
				->params([
					":vendorId" => $this->params["vendorId"]
				])
				->pipe($this->dataStore('dayreport_week'))
			;

			// last week
			//

			$this
				->src('alfred')
				->query('
						SELECT
							SUM( tbl_shop_orders.serviceFee ) as servicefee,
							DATE( tbl_shop_orders.created ) as DateCreated,
							SUM( tbl_shop_orders.amount ) as amount,
							SUM( tbl_shop_orders.amount + tbl_shop_orders.serviceFee ) AS total,
							tbl_shop_spots.spotName,
							tbl_user.username,
							tbl_user.first_name,
							tbl_user.id 
						FROM
							tbl_shop_orders
							INNER JOIN tbl_shop_spots ON tbl_shop_orders.spotId = tbl_shop_spots.id
							INNER JOIN tbl_shop_printers ON tbl_shop_spots.printerId = tbl_shop_printers.id
							INNER JOIN tbl_user ON tbl_shop_printers.userId = tbl_user.id 
						WHERE
							tbl_user.id = :vendorId
							AND tbl_shop_orders.paid = \'1\' 
							AND WEEK(tbl_shop_orders.created,1) = WEEK(NOW(),1) - 1
						GROUP BY
							DATE( tbl_shop_orders.created ) 

                ')
				->params([
					":vendorId" => $this->params["vendorId"]
				])
				->pipe($this->dataStore('dayreport_lastweek'))
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
							buyer.email AS buyerEmail, 
							buyer.username AS buyerUserName, 
							vendor.username AS vendorUserName, 
							tbl_shop_order_extended.quantity AS productQuantity, 
							tbl_shop_products_extended.`name` AS productName, 
							tbl_shop_products_extended.price AS productPrice, 
							tbl_shop_products_extended.vatpercentage AS productVat, 
							tbl_shop_spots.spotName AS spotName
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
							tbl_shop_orders.paid = \'1\'
							AND DATE(tbl_shop_orders.created) = CURRENT_DATE() 
						ORDER BY
							tbl_shop_orders.created ASC	

                ')
				->params([
					":vendorId" => $this->params["vendorId"]
				])
				->pipe($this->dataStore('alldata_day'))
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
							buyer.email AS buyerEmail, 
							buyer.username AS buyerUserName, 
							vendor.username AS vendorUserName, 
							tbl_shop_order_extended.quantity AS productQuantity, 
							tbl_shop_products_extended.`name` AS productName, 
							tbl_shop_products_extended.price AS productPrice, 
							tbl_shop_products_extended.vatpercentage AS productVat, 
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
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
							tbl_shop_orders.paid = \'1\'
							AND WEEK(tbl_shop_orders.created,1) = WEEK(NOW(),1) 
						ORDER BY
							tbl_shop_orders.created ASC	

                ')
				->params([
					":vendorId" => $this->params["vendorId"]
				])
				->pipe(new CalculatedColumn(array(
					"totalamount"=>"{productlinetotal}+{servicefee}",
					"totalamount_by_func"=>function($row){
						return $row["productlinetotal"]+$row["servicefee"];
					}
				)))
				->pipe(new Group(array(
					"by"=>array("productName"),
					"sum"=>array("productQuantity","productlinetotal", "servicefee","totalamount")
				)))
				->pipe(new Sort(array(
					"productQuantity"=>"desc",
				)))
				->pipe($this->dataStore('alldata_week'))
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
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
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
							tbl_shop_orders.paid = \'1\'
							AND WEEK(tbl_shop_orders.created,1) = WEEK(NOW(),1) 
						ORDER BY
							tbl_shop_orders.created ASC	

                ')
			->params([
				":vendorId" => $this->params["vendorId"]
			])
			->pipe(new CalculatedColumn(array(
				"totalamount"=>"{productlinetotal}+{servicefee}",
				"totalamount_by_func"=>function($row){
					return $row["productlinetotal"]+$row["servicefee"];
				}
			)))
			->pipe(new Group(array(
				"by"=>array("orderId","buyerId"),
				"sum"=>array("productlinetotal", "servicefee","totalamount")
			)))
			->pipe($this->dataStore('alldata_bybuyer'))
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
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
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
							tbl_shop_orders.paid = \'1\'
							AND DATE(tbl_shop_orders.created) = CURRENT_DATE
							GROUP BY
							orderId
						ORDER BY
							tbl_shop_categories.category ASC	

                ')
				->params([
					":vendorId" => $this->params["vendorId"]
				])
				->pipe(new CalculatedColumn(array(
					"totalamount"=>"{orderAmount}+{servicefee}",
					"totalamount_by_func"=>function($row){
						return $row["productlinetotal"]+$row["servicefee"];
					}
				)))
				->pipe(new Group(array(
					"by"=>array("category"),
					"sum"=>array("orderAmount", "servicefee","totalamount")
				)))

				->pipe($this->dataStore('alldata_categoryday'))
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
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
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
							tbl_shop_orders.paid = \'1\'
							AND WEEK(tbl_shop_orders.created,1) = WEEK(NOW(),1)
						ORDER BY
							tbl_shop_orders.created ASC	

                ')
				->params([
					":vendorId" => $this->params["vendorId"]
				])
				->pipe(new CalculatedColumn(array(
					"totalamount"=>"{productlinetotal}+{servicefee}",
					"totalamount_by_func"=>function($row){
						return $row["productlinetotal"]+$row["servicefee"];
					}
				)))
				->pipe(new Group(array(
					"by"=>array("orderId","buyerId"),
					"sum"=>array("productlinetotal", "servicefee","totalamount")
				)))
				->pipe($this->dataStore('alldata_bybuyer'))
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
							tbl_shop_spots.spotName AS spotName,
							tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
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
							tbl_shop_orders.paid = \'1\'
							AND DATE(tbl_shop_orders.created) = CURRENT_DATE -1
							GROUP BY
							orderId
						ORDER BY
							tbl_shop_categories.category ASC	

                ')
				->params([
					":vendorId" => $this->params["vendorId"]
				])
				->pipe(new CalculatedColumn(array(
					"totalamount"=>"{orderAmount}+{servicefee}",
					"totalamount_by_func"=>function($row){
						return $row["productlinetotal"]+$row["servicefee"];
					}
				)))
				->pipe(new Group(array(
					"by"=>array("category"),
					"sum"=>array("orderAmount", "servicefee","totalamount")
				)))

				->pipe($this->dataStore('alldata_categoryyesterday'))
			;


		}
    }



