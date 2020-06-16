<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<main class="row" style="margin:50px 0px 20px 0px">
    <div class="container">
        <h1>Order list</h1>
        <div>
            <label class="radio-inline">
                <input
                    type="radio"
                    name="toogleShow"
                    checked
                    value="notFinished"
                    data-hide="finished"
                    onclick="toggleFinished(this, 'hideRow')"
                    />
                    Hide finished
            </label>
            <label class="radio-inline">
                <input
                    type="radio"
                    name="toogleShow"
                    value="finished"
                    data-hide="notFinished"
                    onclick="toggleFinished(this, 'hideRow')"
                    />
                    Show finished
            </label>
        </div>
        <div class="table-responsive col-sm-12">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Order id</th>
                        <th>Products</th>
                        <th>Amount</th>
                        <th>Change status</th>
                        <th>Current status</th>
                        <th>Buyer</th>
                        <th>Buyer mobile</th>
                        <th>Buyer email</th>
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
