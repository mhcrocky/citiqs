<?php
	include APPPATH .'/libraries/reservations_vendor/autoload.php';
    use \koolreport\pivot\widgets\PivotTable;
    use \koolreport\widgets\koolphp\Table;
    use \koolreport\inputs\Select2;
    
?>
<!-- <link rel="shortcut icon" href="/spot/vendor/examples/assets/images/bar.png">
<title>Pivot Table By Yeas Months vs Customers Categories - KoolReport Examples &amp; Demonstration</title>

<link href="<?php echo base_url() ?>vendor/examples/assets/fontawesome/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>vendor/examples/assets/simpleline/simple-line-icons.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>vendor/examples/assets/css/tomorrow.css" rel="stylesheet">

<link href="<?php echo base_url() ?>vendor/examples/assets/theme/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>vendor/examples/assets/theme/css/main.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo base_url() ?>vendor/examples/assets/theme/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>vendor/examples/assets/theme/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>vendor/examples/assets/js/highlight.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>vendor/examples/assets/js/showdown.js"></script> -->
<?php
// $datequery="select eventdate
//     from tbl_bookandpay
//     where eventdate >= CURDATE() AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00')
//     group by eventdate
//     ORDER BY eventdate DESC
// ";
// $spolabelquery="select Spotlabel
//     from tbl_bookandpay
//     where eventdate >= CURDATE() AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00')
//     group by Spotlabel
//     ORDER BY eventdate DESC";
?>
<?php
$datefromcurrentquery="AND eventdate >= CURDATE() ";
$datequery="select eventdate
    from tbl_bookandpay
    where AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00') ".$datefromcurrentquery."
    group by eventdate
    ORDER BY eventdate asc
";
$spolabelquery="select Spotlabel
    from tbl_bookandpay
    where timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00') ".$datefromcurrentquery."
    group by Spotlabel
    ORDER BY eventdate asc";

//$getidquery="select id from tbl_bookandpay where timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00')";

function setqueryforbookandpay($columnname,$datefromcurrentquery){
    $query= "select ".$columnname." from tbl_bookandpay where $columnname !='' AND timeslot!=0 AND paid !=0 AND NOT(timefrom ='00:00:00' AND timeto ='00:00:00') ".$datefromcurrentquery." group by ".$columnname." order by ".$columnname." asc";
    return $query;
}
$allcolumnarray=    array(
        array("bookdatetime",           "Book datetime"),
        array("SpotId",                 "Spot ID"),
        array("email",                  "Email"),
        array("mobilephone",            "Mobile Phone"),
        array("reservationset",         "Reservation Set"),
        array("timefrom",               "Time From"),
        array("timeto",                 "Time To"),
        array("timeslot",               "Time Slot"),
        array("voucher",                "Voucher"),
        array("TransactionID",          "Transaction ID"),
        array("bookingsequenceId",      "Booking Sequence ID"),
    );
?>

<div class='report-content' style="padding-top: 5%;">
	<div class="text-center">
		<h1>RESERVATIONS</h1>
		<p class="lead">
			<!-- Summarize amount of sales and number of sales by three dimensions: customers, categories and products -->
		</p>
		<?php /*
		<div class="row">
            <form class="form-inline">
                <div class="form-group">
                    <label for="datefrom">Date From:</label>
                    <input class="form-control " type="date" name="datefrom" id="datefrom" value="<?php echo isset($_GET['datefrom'])?$_GET['datefrom']:''?>" required>
                </div>
                <div class="form-group">
                    <label for="dateto">Date To:</label>
                    <input class="form-control " type="date" name="dateto" id="dateto" value="<?php echo isset($_GET['dateto'])?$_GET['dateto']:''?>" >
                </div>
                <button class="form-control" type="submit" class="btn btn-primary btn-sm">Go</button>
            </form>
        </div>
        */ ?>
	</div>
	<form method="post">
        <div class="text-center" style="padding: 2%;">
            <div class="row ">

                <div class="col-sm-3">
                    <div class="form-group">
                        <b>Select Name:</b>
                        <?php
                        Select2::create(array(
                            "name"=>"names",
                            "dataStore"=>$this->src("spot")->query(setqueryforbookandpay("name",$datefromcurrentquery)),
                            "defaultOption"=>array("--"=>""),
                            "dataBind"=>"name",
                            "attributes"=>array(
                                "class"=>"form-control",
                            )
                        ));
                        ?>
                    </div>
                </div>
                <!-- foreach -->
                <?php
                foreach ($allcolumnarray as $valkey) {
                ?>
                <div class="col-sm-3">
                    <div class="form-group">
                        <b>Select <?php echo $valkey[1] ?>:</b>
                        <?php
                        Select2::create(array(
                            "multiple"      =>  false,
                            "name"          =>  $valkey[0],
                            "dataSource"    =>  $this->src("spot")->query(setqueryforbookandpay($valkey[0],$datefromcurrentquery)),
                            "defaultOption" =>  array("--"=>""),
                            "attributes"    =>  array(
                                "class"     =>  "form-control"
                            )
                        ));
                        ?>
                    </div>
                </div>
                <?php } ?>
                <div class="col-sm-3">
                    <div class="form-group">
                        <b>Select date:</b>
                        <?php
                        Select2::create(array(
                            "multiple"      =>  true,
                            "name"          =>  "eventdates",
                            "dataSource"    =>  $this->src("spot")->query(setqueryforbookandpay("eventdate",$datefromcurrentquery)),
                            //"defaultOption" =>  array("--"=>""),
                            "attributes"    =>  array(
                                "class"     =>  "form-control"
                            )
                        ));
                        ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <b>Select Spot Label:</b>
                        <?php
                        Select2::create(array(
                            "multiple"      =>  true,
                            "name"          =>  "Spotlabels",
                            "dataSource"    =>  $this->src("spot")->query($spolabelquery)
                                ->params(
                                    $this->params["Spotlabels"]!=array()?
                                        array(":Spotlabels"=>$this->params["Spotlabels"]):array()
                                ),
                            "attributes"=>array(
                                "class"=>"form-control"
                            )
                        ));
                        ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <b>Group By:</b>
                        <?php
                        Select2::create(array(
                            "name"=>"group_by",
                            "dataStore"=>[['id' => 'Email']],
                            "defaultOption"=>array("Time slot"=>""),
                            "dataBind"=>"id",
                            "attributes"=>array(
                                "class"=>"form-control",
                            )
                        ));
                        ?>
                    </div>
                </div>
                
            </div>
            
                <div class="form-group text-center">
                    <button class="btn btn-primary">Submit</button>
                    <button type="submit" class="btn btn-primary" formaction="<?php echo base_url()?>customer_panel/pivot_export?q=1">Download Excel</button>
                    <button type="button" onClick="printData()" class="btn btn-primary" >Print</button>
                </div>
            
        </div>
    </form>
	<div>
		<?php
        $dataStore = $this->dataStore('salespot');
        //var_dump($dataStore);

			PivotTable::create(
				array(
					"dataStore"=>$dataStore,

					'headerMap' => array(
						'eventdate'				=>	'Event date ',
						'price - sum'			=>	'Total Price',
						'numberofpersons - sum'	=>	'Total Persons',
						'Spotlabel'				=>	'Spotlabel',
						'EventTime'				=>	'Event Time',
						'name'					=>	'Customer Name',
						'numberofpersons'		=>	'Persons',
						// 'orderQuarter - sum'	=>	'Order Quarter'
					),
					'hideSubtotalRow'		=>	true,
					// 'hideSubtotalColumn'	=>	true,
					'showDataHeaders'		=>	true,
					"rowDimension"		=>	"row",
					'rowCollapseLevels' => array(0),
					// 'columnCollapseLevels' => array(0),
					// "columnDimension"	=>	"column",
					// "measures"=>array(
					// 	"dollar_sales - sum", 
					// 	'dollar_sales - count',
					// ),
					'rowSort' => array(
						// 'dollar_sales - count' => 'desc',
					),
					// 'columnSort' => array(
					// 	'orderMonth' => function($a, $b) {
					// 		return (int)$a < (int)$b;
					// 	},
					// ),
					// 'rowCollapseLevels' => array(0),
					// 'columnCollapseLevels' => array(0),
					// 'width' => '100%',
					'nameMap' => array(
						// 'customerName - sum'	=>	'Customer Name',
						// 'productName - sum'		=>	'Product Name',
						// 'productLine - sum'		=>	'Product Line',
						// 'orderDate - sum'		=>	'Order Date',
						// 'orderDay - sum'		=>	'Order Day',
						// 'orderMonth - sum'		=>	'Order Month',
						// 'orderYear - sum'		=>	'Order Year',
						// 'orderQuarter - sum'	=>	'Order Quarter'
					// 		'dollar_sales - sum' => 'Sales (in USD)',
					// 		'dollar_sales - count' => 'Number of Sales',
					// 		'1' => 'January',
					// 		'2' => 'February',
					// 		'3' => 'March',
					// 		'4' => 'April',
					// 		'5' => 'May',
					// 		'6' => 'June',
					// 		'7' => 'July',
					// 		'8' => 'August',
					// 		'9' => 'September',
					// 		'10' => 'October',
					// 		'11' => 'November',
					// 		'12' => 'December',
					),
				)
			);
	?>
<div id="load"></div>
<div class="fade" id="table">
    <?php 
Table::create(array(
    "dataSource"=>$dataStore,
));
?>
</div>
	</div>
</div>   

<script>
$(document).ready(function(){
    $("#load").hide();
    $("#table").hide();
    console.log($("form").serializeArray());  
});

function printData()
{
    var tabletoPrint = '';
    var formData = $("form").serializeArray();
    $.ajax({
        type: 'POST',
        url: '<?php echo current_url();?>?q=2',
        data: formData,
        success: function(data){
            $('#load').html($(data).find('#table').html());
            $('#load .table').css({'border': '1px solid black', 'border-collapse': 'collapse', 'padding': '1px'});
            $('#load .table tr').css('border', '1px solid black');
            $('#load .table tr td').css('border', '1px solid black');
            $('#load .table tr th').css({'border': '1px solid black','padding': '5px','font-size': '15px', 'background': '#A9A9A9'});
            $('#load .table tr td:first-child').css('background', '#D8D8D8');
        },
        async:false
    });
    
    var tabletoPrint = $('#load').html();
    newWin = window.open("");
    newWin.document.write(tabletoPrint);
    newWin.print();
    newWin.close();
    $("#load").empty();
 

}
</script>
