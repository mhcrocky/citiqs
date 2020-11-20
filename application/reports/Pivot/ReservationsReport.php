<?php
include APPPATH .'/libraries/reservations_vendor/autoload.php';
use \koolreport\pivot\processes\Pivot;
use \koolreport\processes\ColumnMeta;

class ReservationsReport extends \koolreport\KoolReport
{
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\codeigniter\Friendship;

    function settings()
    {
        return array(
            'dataSources' => array(
                "spot" => array(
                    'host' => HOSTNAME,
                    'username' => USERNAME,
                    'password' => PASSWORD,
                    'dbname' => DATABASE,

                    // 'host'		=>	"localhost",
                    // "username"	=>	"root",
                    // "password"	=>	"",
                    // "dbname"	=>	"spot",

                    "charset" => "utf8",
                    "class" => "\koolreport\datasources\MySQLDataSource",

                )
            ),
        );
    }

    protected function defaultParamValues()
    {
        return array(
            "from" => '',
            "to" => '',
        );
    }

    protected function bindParamsToInputs()
    {
        return array(
            "from",
            "to",
        );
    }

    function setup()
    {
        $purchasedFrom = (isset($this->params['from']) && $this->params['from'] != '') ? $this->params['from'] : date('Y-m-d 00:00:00');
        $purchasedTo = (isset($this->params['to']) && $this->params['to'] != '') ? $this->params['to'] : date('Y-m-d 23:59:59');

        $sqlQuery = "SELECT
	DATE(tbl_bookandpay.bookdatetime) AS bookdatetime,
	DAYNAME(DATE(tbl_bookandpay.bookdatetime)) AS bookdatetimeday,
	tbl_bookandpay.eventdate,	
	COUNT(tbl_bookandpay.eventdate) AS eventdatecount,
	DAYNAME(tbl_bookandpay.eventdate) AS eventdateday,
	DAYOFYEAR(tbl_bookandpay.eventdate) - DAYOFYEAR(DATE(tbl_bookandpay.bookdatetime)) AS daysinbetween
FROM
	tbl_bookandpay
WHERE 
    (tbl_bookandpay.bookdatetime BETWEEN '$purchasedFrom' AND '$purchasedTo')
GROUP BY
	DATE(tbl_bookandpay.eventdate)
ORDER BY
	DATE(tbl_bookandpay.bookdatetime)";

        if (isset($_GET['q']) && $_GET['q'] = 1) {
            $this->src("spot")
                ->query($sqlQuery)
                ->pipe($this->dataStore("salespot"));
        } else {
            $this->src("spot")
                ->query($sqlQuery)
                ->pipe(new Pivot(array(
                    'dimensions' => array(
                        'row' => 'bookdatetime, bookdatetimeday, eventdate, eventdatecount, eventdateday, daysinbetween'
                    ),
                    'aggregates' => array(
                        'sum' => array("eventdatecount"),
//                        'count' => 'eventdatecount'
                    )
                )))
                ->pipe($this->dataStore("salespot"));
        }
    }
}