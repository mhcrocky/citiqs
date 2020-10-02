<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
    #ordersList td, #ordersList th {
        text-align: center;
    }
</style>
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
                style="background-color: #fff"
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
            <?php foreach ($ordersStatuses as $status) { ?>
                <option value="<?php echo $status; ?>"><?php echo ucfirst($status); ?></option>
            <?php } ?>
        </select>
    </div>
    <div style="margin:20px 0px 20px 10px">
        <button type="button" class="btn btn-primary" onclick="destroyAndFetch()">Reload page</button>
    </div>
    <div class="table-responsive col-sm-12" style="margin-top:20px">
        <table id="ordersList" class="display table table-hover table-striped" style="width:100%">
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
                    <th>Service type</th>
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
                    <th>Service type</th>
                </tr>
            </tfoot>
        </table>
    </div>
</main>
<script>
    var orderGlobals = (function(){
        let getRemarks = '<?php echo $vendorData['requireRemarks']; ?>' === '1' ? true : false;
        let globals = {
            'orderStatuses' : JSON.parse('<?php echo json_encode($orderStatuses) ?>'),
            'tableId' : 'orders',
            'vendorName' : '<?php echo $vendor; ?>',
            'getRemarks' : getRemarks,
        }
        Object.freeze(globals);
        return globals;
    }());
</script>
