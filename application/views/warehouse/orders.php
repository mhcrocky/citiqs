<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<main class="container" style="text-align:left; margin-bottom:20px">
    <h1>Order list</h1>
    <div class="row">
        <div class="table-responsive col-sm-12" style="margin-top:15px">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Order id</th>
                        <th>Products</th>
                        <th>Amount</th>
                        <th>Change status</th>
                        <th>Current status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id='orders'>
               
                </tbody>
            </table>
        </div>
    </div>
</main>
<script>
    var orderGlobals = (function(){
        let globals = {
            'orderStatuses' : JSON.parse('<?php echo json_encode($orderStatuses) ?>'),
            'orderFinished' : '<?php echo $orderFinished ?>',
            'tableId' : 'orders'
        }
        Object.freeze(globals);
        return globals;
    }());
</script>
