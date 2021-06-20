<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<audio id="myAudio">
	<source src="https://tiqs.com/alfred/assets/home/sound/deskbell.mp3" type="audio/mpeg">
	Your browser does not support the audio element.
</audio>
<style>
    #ordersList td, #ordersList th {
        text-align: center;
    }
</style>

<!--
<script>
/*
	setInterval(function(){

		location.reload();

	}, 90000);
*/
</script>
-->

<script>

	var x = document.getElementById("myAudio");

	function playAudio() {
		x.play();
	}

	function pauseAudio() {
		x.pause();
	}

	// $(document).ready( function () {
	// 	playAudio();
	// });

</script>

<main class="row" style="margin:0px 20px">

	<h1 style="margin:70px 0px 20px 0px">Order list</h1>
    <div class="col-sm-12" style="text-align:center">
        MINUTES ADDED: <span id="val"><?php echo $vendorData['busyTime']; ?></span>
        <a
            href="javascript:void(0)"
            type="button"
            onclick="saveBusyTime('slide', '<?php echo $vendorData['id']; ?>')"
            id="limitButton"
            disabled
            class="btn btn-success mb-25"
            stlye="background: #269900"
        >
            <?php if ( $vendorData['busyTime'] === '0') { ?>
                BUSY TIME IS NOT SET
            <?php } else { ?>
                TIME CONFIRMED
            <?php } ?>
        </a>
        <div style="margin-top:10px">
            <input
                style="background-color: #fbce97"
                id="slide"
                type="range"
                min="<?php echo $vendorData['minBusyTime']; ?>"
                max="<?php echo ($vendorData['maxBusyTime'] === '0') ? '100' : $vendorData['maxBusyTime']; ?>"
                value="<?php echo $vendorData['busyTime']; ?>"
                oninput="callDisplayValue(event)"
            />
        </div>

        
    
    </div>

    <div style="margin:20px 0px 20px 0px">
        <label for="orderStatus">Filter orders by printer:</label>
        <?php if (!empty($printers)) { ?>
        <select id="selectedPrinter" class="custom-select" onchange="destroyAndFetch()">
            <option value="">All</option>
            <?php foreach ($printers as $printer) { ?>
                <option value="<?php echo $printer['id']; ?>"><?php echo $printer['printer']; ?></option>
            <?php } ?>
        </select>
        <?php } ?>
    </div>
    <div style="margin:20px 0px 20px 0px">
        <label for="orderStatus">Filter orders by status:</label>
        <select id="orderStatus" class="custom-select" onchange="destroyAndFetch()">
            <option value="">All (incl finished)</option>
            <?php foreach ($orderStatuses as $status) { ?>
                <option value="<?php echo $status; ?>"><?php echo ucfirst($status); ?></option>
            <?php } ?>
        </select>
    </div>
    <div style="margin:20px 0px 20px 10px">
        <button type="button" class="btn btn-primary" onclick="destroyAndFetch()">Reload page</button>
    </div>
    <div class="col-sm-12 grid-header-heading">
        <p>
            Legend:&nbsp;
            <?php foreach($typeColors as $type => $color) { ?>
                <?php echo $type; ?>&nbsp;&nbsp;<span style="display:inline-block; width:20px; height: 12px; background-color:<?php echo $color; ?>"></span>&nbsp;&nbsp;
            <?php } ?>
            rejected&nbsp;&nbsp;<span style="display:inline-block; width:20px; height: 12px; background-color:<?php echo $rejectedColor; ?>"></span>
        </p>
    </div>
    <div class="table-responsive col-sm-12" style="margin-top:20px">
        <table id="ordersList" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Products</th>
                    <th>Amount</th>
                    <th>Spot name</th>
                    <th>Order status</th>
                    <th>Created</th>
                    <th>Buyer</th>
                    <th>Buyer Email</th>
                    <th>Buyer Mobile</th>
                    <th>Send Buyer Sms</th>
                    <th>Buyer ID</th>
                    <th>Count sent messages</th>
                    <th>Spot type</th>
                    <th>Remarks</th>
                    <th>Payment type</th>
                    <th>Confirm</th>
                    <th>Print status</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th>Order ID</th>
                    <th>Products</th>
                    <th>Amount</th>
                    <th>Spot name</th>
                    <th>Order status</th>
                    <th>Updated</th>
                    <th>Buyer</th>
                    <th>Buyer Email</th>
                    <th>Buyer Mobile</th>
                    <th>Send Buyer Sms</th>
                    <th>Buyer ID</th>
                    <th>Count sent messages</th>
                    <th>Spot type</th>
                    <th>Remarks</th>
                    <th>Payment type</th>
                    <th>Confirm</th>
                    <th>Print status</th>
                </tr>
            </tfoot>
        </table>
    </div>
</main>

<div class="modal" id="checkOrderModalId">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Confirm or reject order</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body"></div>
            <!-- Modal footer -->
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<script>
    var orderGlobals = (function(){
        let getRemarks = '<?php echo $vendorData['requireRemarks']; ?>' === '1' ? true : false;
        let globals = {
            'orderStatuses' : JSON.parse('<?php echo json_encode($orderStatuses) ?>'),
            'tableId' : 'orders',
            'vendorName' : '<?php echo $vendor; ?>',
            'getRemarks' : getRemarks,
            'typeColors' :  JSON.parse('<?php echo json_encode($typeColors) ?>'),
            'localTypeId' : '<?php echo $localTypeId; ?>',
            'deliveryTypeId' : '<?php echo $deliveryTypeId; ?>',
            'pickupTypeId' : '<?php echo $pickupTypeId; ?>',
            'checkOrderModalId' : 'checkOrderModalId',
            'orderConfirmWaiting' : '<?php echo $orderConfirmWaiting; ?>',
            'orderConfirmTrue' : '<?php echo $orderConfirmTrue; ?>',
            'orderConfirmFalse' : '<?php echo $orderConfirmFalse; ?>',
            'rejectedColor' : '<?php echo $rejectedColor; ?>',
            'prePaid' : '<?php echo $prePaid; ?>',
            'postPaid' : '<?php echo $postPaid; ?>',
            'userId' : '<?php echo $userId; ?>',
        }
        Object.freeze(globals);
        return globals;
    }());
</script>
