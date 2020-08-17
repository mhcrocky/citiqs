<?php
    require_once APPPATH . '/libraries/koolreport/core/autoload.php';

    use \koolreport\processes\Filter;
    use \koolreport\processes\ColumnMeta;
    use \koolreport\pivot\processes\Pivot;
    use \koolreport\processes\Group;
    use \koolreport\processes\Sort;
    use \koolreport\processes\Limit;
	use \koolreport\codeigniter\Friendship;

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
        }
    }



