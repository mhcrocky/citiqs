<?php
include APPPATH . '/libraries/reservations_vendor/autoload.php';

use \koolreport\pivot\widgets\PivotTable;

?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class='report-content' style="padding-top: 5%;">
    <div class="text-center">
        <h1>RESERVATIONS</h1>
        <p class="lead">
            <!-- Summarize amount of sales and number of sales by three dimensions: customers, categories and products -->
        </p>
    </div>

    <form method="post">
        <div class="text-center" style="padding: 2%;">

            <div class="row ">
                <div class="col-sm-3">
                    <div class="form-group">
                        <b>Purchase Date From:</b>

                        <input value="<?php echo isset($_POST['from']) ? $_POST['from'] : ''; ?>" autocomplete="off" name="from" type="text"
                               id="datepicker">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <b>Purchase Date To:</b>

                        <input value="<?php echo isset($_POST['to']) ? $_POST['to'] : ''; ?>" autocomplete="off" name="to" type="text"
                               id="datepicker1">
                    </div>
                </div>
            </div>
           
                <div class="form-group text-center">
                    <button class="btn btn-primary">Submit</button>
                    <button type="submit" class="btn btn-primary" formaction="<?php echo base_url() ?>customer_panel/reservations_report/export?q=1">
                        Download Excel
                    </button>
                </div>
           
        </div>
    </form>
    <div>
        <?php
        $dataStore = $this->dataStore('salespot');

        PivotTable::create(
            array(
                "dataStore" => $dataStore,

                'headerMap' => array(
                    'eventdatecount - count' => 'Purchased At',
                    'eventdate' => 'Event Date',
                ),
                'hideSubtotalRow' => true,
                'showDataHeaders' => false,
                "rowDimension" => "row",
                'rowCollapseLevels' => array(0),
                'rowSort' => array(),
                'nameMap' => array(),
            )
        );
        ?>
    </div>
</div>

<script>
    $(function () {
        $("#datepicker, #datepicker1").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>