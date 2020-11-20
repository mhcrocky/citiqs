<?php
include APPPATH .'/libraries/reservations_vendor/autoload.php';
// use \koolreport\codeigniter\Friendship;
use \koolreport\pivot\processes\Pivot;
use \koolreport\pivot\processes\PivotExtract;
use \koolreport\processes\Filter;
use \koolreport\processes\ColumnMeta;
use \koolreport\widgets\koolphp\Table;


class PivotReport extends \koolreport\KoolReport
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
            "eventdates" => array(),
            "Spotlabels" => array(),
            "ids" => '',
            "names" => '',
            "customer" => '',
            "eventid" => '',
            "reservationId" => '',
            "bookdatetime" => '',
            "SpotId" => '',
            "price" => '',
            "numberofpersons" => '',
            "email" => '',
            "mobilephone" => '',
            "reservationset" => '',
            "reservationtime" => '',
            "timefrom" => '',
            "timeto" => '',
            "paid" => '',
            "timeslot" => '',
            "voucher" => '',
            "TransactionID" => '',
            "bookingsequenceId" => '',
            "bookingsequenceamount" => '',
            "numberin" => '',
            "mailsend" => '',

        );
    }

    protected function bindParamsToInputs()
    {
        return array(
            "eventdates",
            "Spotlabels",
            "ids",
            "names",
            "customer",
            "eventid",
            "reservationId",
            "bookdatetime",
            "SpotId",
            "price",
            "numberofpersons",
            "email",
            "mobilephone",
            "reservationset",
            "reservationtime",
            "timefrom",
            "timeto",
            "paid",
            "timeslot",
            "voucher",
            "TransactionID",
            "bookingsequenceId",
            "bookingsequenceamount",
            "numberin",
            "mailsend",
            "group_by",

        );
    }

    function setup()
    {

        $query_params = array();
        if ($this->params["eventdates"] != array()) {
            $queryeventdate = implode(",", array_map(function ($string) {
                return '"' . $string . '"';
            }, $this->params["eventdates"]));
        }
        if ($this->params["Spotlabels"] != array()) {
            $querySpotlabels = implode(",", array_map(function ($string) {
                return '"' . $string . '"';
            }, $this->params["Spotlabels"]));

        }
        //Now you can access database that you configured in codeigniter
        if (isset($_GET['q']) && ($_GET['q'] == 1 || $_GET['q'] == 2)) {
            if($_GET['q'] == 2){
                $selectq = "id, customer, eventid, eventdate, Spotlabel, numberofpersons, name, email, mobilephone, timefrom, timeto";
            } else {
                $selectq = " eventdate,Spotlabel, numberofpersons,price, CONCAT(`timefrom`, '-', `timeto`) as EventTime,
			timefrom, timeto,name,customer,eventid,reservationId,bookdatetime,SpotId,price,numberofpersons,email,mobilephone,reservationset,reservationtime,paid,timeslot,voucher,TransactionID,bookingsequenceId,bookingsequenceamount,numberin,mailsend ";
            }
            
        } else {
            $selectq = " eventdate,CONCAT(`timefrom`, '-', `timeto`) as EventTime, name, email, Spotlabel, eventdate,bookdatetime, numberofpersons, name,price ";
        }

        if (isset($_GET['q']) && $_GET['q'] = 1) {
            $groupSqlQuery = "SELECT email FROM tbl_bookandpay WHERE 1=1 AND eventdate >= CURDATE() AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00')";
            $groupSqlQuery_2 = "SELECT email FROM `tbl_bookandpay` WHERE 1=1 AND eventdate >= CURDATE() AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00') GROUP BY eventdate,email Having COUNT(*) <> 1 ORDER BY email ASC";
            if (isset($queryeventdate)) {
                $groupSqlQuery .= " AND eventdate in ($queryeventdate)";
            }
            if (isset($querySpotlabels)) {
                $groupSqlQuery .= " AND Spotlabel in ($querySpotlabels)";
            }
            if ($this->params["ids"] != "") {
                $groupSqlQuery .= " AND id = '" . $this->params["ids"] . "'";
            }
            if ($this->params["names"] != "") {
                $groupSqlQuery .= " AND name = '" . $this->params["names"] . "'";
            }
            if ($this->params["customer"] != "") {
                $groupSqlQuery .= " AND customer = '" . $this->params["customer"] . "'";
            }
            if ($this->params["eventid"] != "") {
                $groupSqlQuery .= " AND eventid = '" . $this->params["eventid"] . "'";
            }
            if ($this->params["reservationId"] != "") {
                $groupSqlQuery .= " AND reservationId = '" . $this->params["reservationId"] . "'";
            }
            if ($this->params["bookdatetime"] != "") {
                $groupSqlQuery .= " AND bookdatetime = '" . $this->params["bookdatetime"] . "'";
            }
            if ($this->params["SpotId"] != "") {
                $groupSqlQuery .= " AND SpotId = '" . $this->params["SpotId"] . "'";
            }
            if ($this->params["price"] != "") {
                $groupSqlQuery .= " AND price = '" . $this->params["price"] . "'";
            }
            if ($this->params["numberofpersons"] != "") {
                $groupSqlQuery .= " AND numberofpersons = '" . $this->params["numberofpersons"] . "'";
            }
            if ($this->params["email"] != "") {
                $groupSqlQuery .= " AND email = '" . $this->params["email"] . "'";
            }
            if ($this->params["mobilephone"] != "") {
                $groupSqlQuery .= " AND mobilephone = '" . $this->params["mobilephone"] . "'";
            }
            if ($this->params["reservationset"] != "") {
                $groupSqlQuery .= " AND reservationset = '" . $this->params["reservationset"] . "'";
            }
            if ($this->params["reservationtime"] != "") {
                $groupSqlQuery .= " AND reservationtime = '" . $this->params["reservationtime"] . "'";
            }
            if ($this->params["timefrom"] != "") {
                $groupSqlQuery .= " AND timefrom <= '" . $this->params["timefrom"] . "'";
            }
            if ($this->params["timeto"] != "") {
                $groupSqlQuery .= " AND timeto >= '" . $this->params["timeto"] . "'";
            }
            if ($this->params["paid"] != "") {
                $groupSqlQuery .= " AND paid <= '" . $this->params["paid"] . "'";
            }
            if ($this->params["timeslot"] != "") {
                $groupSqlQuery .= " AND timeslot = '" . $this->params["timeslot"] . "'";
            }
            if ($this->params["voucher"] != "") {
                $groupSqlQuery .= " AND voucher = '" . $this->params["voucher"] . "'";
            }
            if ($this->params["TransactionID"] != "") {
                $groupSqlQuery .= " AND TransactionID = '" . $this->params["TransactionID"] . "'";
            }
            if ($this->params["bookingsequenceId"] != "") {
                $groupSqlQuery .= " AND bookingsequenceId = '" . $this->params["bookingsequenceId"] . "'";
            }
            if ($this->params["bookingsequenceamount"] != "") {
                $groupSqlQuery .= " AND bookingsequenceamount = '" . $this->params["bookingsequenceamount"] . "'";
            }
            if ($this->params["numberin"] != "") {
                $groupSqlQuery .= " AND numberin = '" . $this->params["numberin"] . "'";
            }
            if ($this->params["mailsend"] != "") {
                $groupSqlQuery .= " AND mailsend = '" . $this->params["mailsend"] . "'";
            }
            $groupSqlQuery .= " GROUP BY email HAVING COUNT(email) > 1";

            $sqlQuery = "SELECT $selectq FROM tbl_bookandpay WHERE 1=1 AND eventdate >= CURDATE() AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00')";

            if (isset($queryeventdate)) {
                $sqlQuery .= " AND eventdate in ($queryeventdate)";
            }
            if (isset($querySpotlabels)) {
                $sqlQuery .= " AND Spotlabel in ($querySpotlabels)";
            }
            if ($this->params["ids"] != "") {
                $sqlQuery .= " AND id = '" . $this->params["ids"] . "'";
            }
            if ($this->params["names"] != "") {
                $sqlQuery .= " AND name = '" . $this->params["names"] . "'";
            }
            if ($this->params["customer"] != "") {
                $sqlQuery .= " AND customer = '" . $this->params["customer"] . "'";
            }
            if ($this->params["eventid"] != "") {
                $sqlQuery .= " AND eventid = '" . $this->params["eventid"] . "'";
            }
            if ($this->params["reservationId"] != "") {
                $sqlQuery .= " AND reservationId = '" . $this->params["reservationId"] . "'";
            }
            if ($this->params["bookdatetime"] != "") {
                $sqlQuery .= " AND bookdatetime = '" . $this->params["bookdatetime"] . "'";
            }
            if ($this->params["SpotId"] != "") {
                $sqlQuery .= " AND SpotId = '" . $this->params["SpotId"] . "'";
            }
            if ($this->params["price"] != "") {
                $sqlQuery .= " AND price = '" . $this->params["price"] . "'";
            }
            if ($this->params["numberofpersons"] != "") {
                $sqlQuery .= " AND numberofpersons = '" . $this->params["numberofpersons"] . "'";
            }
            if ($this->params["email"] != "") {
                $sqlQuery .= " AND email = '" . $this->params["email"] . "'";
            }
            if ($this->params["mobilephone"] != "") {
                $sqlQuery .= " AND mobilephone = '" . $this->params["mobilephone"] . "'";
            }
            if ($this->params["reservationset"] != "") {
                $sqlQuery .= " AND reservationset = '" . $this->params["reservationset"] . "'";
            }
            if ($this->params["reservationtime"] != "") {
                $sqlQuery .= " AND reservationtime = '" . $this->params["reservationtime"] . "'";
            }
            if ($this->params["timefrom"] != "") {
                $sqlQuery .= " AND timefrom <= '" . $this->params["timefrom"] . "'";
            }
            if ($this->params["timeto"] != "") {
                $sqlQuery .= " AND timeto >= '" . $this->params["timeto"] . "'";
            }
            if ($this->params["paid"] != "") {
                $sqlQuery .= " AND paid <= '" . $this->params["paid"] . "'";
            }
            if ($this->params["timeslot"] != "") {
                $sqlQuery .= " AND timeslot = '" . $this->params["timeslot"] . "'";
            }
            if ($this->params["voucher"] != "") {
                $sqlQuery .= " AND voucher = '" . $this->params["voucher"] . "'";
            }
            if ($this->params["TransactionID"] != "") {
                $sqlQuery .= " AND TransactionID = '" . $this->params["TransactionID"] . "'";
            }
            if ($this->params["bookingsequenceId"] != "") {
                $sqlQuery .= " AND bookingsequenceId = '" . $this->params["bookingsequenceId"] . "'";
            }
            if ($this->params["bookingsequenceamount"] != "") {
                $sqlQuery .= " AND bookingsequenceamount = '" . $this->params["bookingsequenceamount"] . "'";
            }
            if ($this->params["numberin"] != "") {
                $sqlQuery .= " AND numberin = '" . $this->params["numberin"] . "'";
            }
            if ($this->params["mailsend"] != "") {
                $sqlQuery .= " AND mailsend = '" . $this->params["mailsend"] . "'";
            }
            if($_GET['q'] = 2){
                $sqlQuery .= " AND email IN (" . $groupSqlQuery_2 . ") ORDER BY email,eventdate,timefrom";
                $sqlQuery .= " ASC";
            } else {
            $sqlQuery .= " AND email IN (" . $groupSqlQuery . ") ORDER BY eventdate";
            if (isset($this->params["group_by"]) && $this->params["group_by"] != "" && $this->params['group_by'] == 'Email') {
                $sqlQuery .= ",email";
            }
            $sqlQuery .= " ASC";
        }
            $this->src("spot")
                ->query($sqlQuery)
                ->pipe($this->dataStore("salespot"));
        } else {
            $sqlQuery = "SELECT $selectq FROM tbl_bookandpay WHERE 1=1 AND eventdate >= CURDATE() AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00')";

            if (isset($queryeventdate)) {
                $sqlQuery .= " AND eventdate in ($queryeventdate)";
            }
            if (isset($querySpotlabels)) {
                $sqlQuery .= " AND Spotlabel in ($querySpotlabels)";
            }
            if ($this->params["ids"] != "") {
                $sqlQuery .= " AND id = '" . $this->params["ids"] . "'";
            }
            if ($this->params["names"] != "") {
                $sqlQuery .= " AND name = '" . $this->params["names"] . "'";
            }
            if ($this->params["customer"] != "") {
                $sqlQuery .= " AND customer = '" . $this->params["customer"] . "'";
            }
            if ($this->params["eventid"] != "") {
                $sqlQuery .= " AND eventid = '" . $this->params["eventid"] . "'";
            }
            if ($this->params["reservationId"] != "") {
                $sqlQuery .= " AND reservationId = '" . $this->params["reservationId"] . "'";
            }
            if ($this->params["bookdatetime"] != "") {
                $sqlQuery .= " AND bookdatetime = '" . $this->params["bookdatetime"] . "'";
            }
            if ($this->params["SpotId"] != "") {
                $sqlQuery .= " AND SpotId = '" . $this->params["SpotId"] . "'";
            }
            if ($this->params["price"] != "") {
                $sqlQuery .= " AND price = '" . $this->params["price"] . "'";
            }
            if ($this->params["numberofpersons"] != "") {
                $sqlQuery .= " AND numberofpersons = '" . $this->params["numberofpersons"] . "'";
            }
            if ($this->params["email"] != "") {
                $sqlQuery .= " AND email = '" . $this->params["email"] . "'";
            }
            if ($this->params["mobilephone"] != "") {
                $sqlQuery .= " AND mobilephone = '" . $this->params["mobilephone"] . "'";
            }
            if ($this->params["reservationset"] != "") {
                $sqlQuery .= " AND reservationset = '" . $this->params["reservationset"] . "'";
            }
            if ($this->params["reservationtime"] != "") {
                $sqlQuery .= " AND reservationtime = '" . $this->params["reservationtime"] . "'";
            }
            if ($this->params["timefrom"] != "") {
                $sqlQuery .= " AND timefrom <= '" . $this->params["timefrom"] . "'";
            }
            if ($this->params["timeto"] != "") {
                $sqlQuery .= " AND timeto >= '" . $this->params["timeto"] . "'";
            }
            if ($this->params["paid"] != "") {
                $sqlQuery .= " AND paid <= '" . $this->params["paid"] . "'";
            }
            if ($this->params["timeslot"] != "") {
                $sqlQuery .= " AND timeslot = '" . $this->params["timeslot"] . "'";
            }
            if ($this->params["voucher"] != "") {
                $sqlQuery .= " AND voucher = '" . $this->params["voucher"] . "'";
            }
            if ($this->params["TransactionID"] != "") {
                $sqlQuery .= " AND TransactionID = '" . $this->params["TransactionID"] . "'";
            }
            if ($this->params["bookingsequenceId"] != "") {
                $sqlQuery .= " AND bookingsequenceId = '" . $this->params["bookingsequenceId"] . "'";
            }
            if ($this->params["bookingsequenceamount"] != "") {
                $sqlQuery .= " AND bookingsequenceamount = '" . $this->params["bookingsequenceamount"] . "'";
            }
            if ($this->params["numberin"] != "") {
                $sqlQuery .= " AND numberin = '" . $this->params["numberin"] . "'";
            }
            if ($this->params["mailsend"] != "") {
                $sqlQuery .= " AND mailsend = '" . $this->params["mailsend"] . "'";
            }
            $sqlQuery .= " ORDER BY eventdate";
            if (isset($this->params["group_by"]) && $this->params["group_by"] != "" && $this->params['group_by'] == 'Email') {
                $sqlQuery .= ",email";
            }
            $sqlQuery .= " ASC";

            $this->src("spot")
                ->query($sqlQuery)
                ->pipe(new ColumnMeta(array(
                    "price" => array(
                        'type' => 'number',
                        "prefix" => "€ ",
                    ),
                )))
                ->pipe(new Pivot(array(
                    'dimensions' => array(
                        'row' => 'eventdate, name, Spotlabel, numberofpersons'
                    ),
                    'aggregates' => array(
                        'sum' => array("numberofpersons"),//'price',
                        // 'count'=>'price'
                    )
                )))
                ->pipe($this->dataStore("salespot"));
        }

    }
}