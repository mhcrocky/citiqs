<?php
    require_once APPPATH . '/libraries/koolreport/core/autoload.php';

    use \koolreport\processes\Filter;
    use \koolreport\processes\ColumnMeta;
    use \koolreport\pivot\processes\Pivot;
    use \koolreport\processes\Group;
    use \koolreport\processes\Sort;
    use \koolreport\processes\Limit;

    class Visitors extends \koolreport\KoolReport
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
                        DATE_FORMAT(tbl_shop_visitor_reservations.created, "%Y %m %d") AS dateCreated,
                        DATE_FORMAT(tbl_shop_visitor_reservations.created, "%H %i %s") AS timeCreated,
                        CONCAT(tbl_shop_visitors.firstName, " ", tbl_shop_visitors.lastName) AS visitorName,
                        tbl_shop_visitors.email AS visitorEmail,
                        tbl_shop_visitors.mobile AS visitorMobile,
                        IF (tbl_shop_visitor_reservations.checkStatus = "1", "IN", "OUT") AS visitorStatus
                    FROM
                        `tbl_shop_visitors`
                    INNER JOIN
                        tbl_shop_visitor_reservations ON tbl_shop_visitors.id = tbl_shop_visitor_reservations.visitorId
                    WHERE tbl_shop_visitors.vendorId = :vendorId;
                ')
                ->params([
                    ":vendorId" => $this->params["vendorId"]
                ])
                ->pipe(new Group([
                    'by' => 'timeCreated'
                ]))
                ->pipe(new Sort([
                    'timeCreated' => 'desc'
                ]))
                ->pipe(new Pivot([
                    'dimensions' => [
                        'row' => 'dateCreated, timeCreated, visitorName, visitorEmail, visitorMobile, visitorStatus'
                    ],
                ]))
                ->pipe($this->dataStore('visitors_report'))
                ;
        }
    }
    // function setup()
    // {
    //     $node = $this->src('dollarsales');
    //     $node->pipe(new Filter(array(
    //         array('customerName', '<', 'Am'),
    //         array('orderYear', '>', 2003)
    //     )))
    //     ->pipe(new ColumnMeta(array(
    //         "dollar_sales"=>array(
    //             'type' => 'number',
    //             "prefix" => "$",
    //         ),
    //     )))
    //     ->pipe(new ColumnMeta(array(
    //         'dollar_sales'=>array(
    //             'type' => 'number',
    //             'prefix' => '$',
    //             'decimals'=>2,
    //         ),
    //     )))
    //     ->pipe(new Pivot(array(
    //         'dimensions'=>array(
    //             'row'=>'customerName, productLine, productName'
    //         ),
    //         'aggregates'=>array(
    //             'sum'=>'dollar_sales',
    //             'count'=>'dollar_sales'
    //         )
    //     )))
    //     ->pipe($this->dataStore('sales'));  
    // }