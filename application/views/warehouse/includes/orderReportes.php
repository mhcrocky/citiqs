<!-- <style>
    #reportesOrders_next{
        display:none
    }
</style> -->
<div style="margin:10px 0px 0px 30px; font-size:16px">
    <div class="row">
        <p class="col-sm-2">Total orders:</p>
        <p class="col-sm-2" id="total" style="text-align:right;"></p>
    </div>
    <div class="row">
        <p class="col-sm-2">Unpaid:</p>
        <p class="col-sm-2" id="unpaid" style="border-bottom: solid 2px #000; color:#ff3333; text-align:right;"></p>
    </div>
    <div class="row">
        <p class="col-sm-2">Income:</p>
        <p class="col-sm-2" id="paid" style="text-align:right;"></p>
    </div>
</div>
<div class="table-responsive col-sm-12" style="margin-top:20px">
    <table id="reportesOrders" class="table table-hover table-striped display" style="width:100%">
        <thead>
            <tr>
                <th style="text-align:center">Order ID</th>
                <th style="text-align:center">Buyer</th>
                <th style="text-align:center">Created at</th>
                <th style="text-align:center">Paid</th>
                <th style="text-align:center">Amount</th>
                <th style="text-align:center">Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalOrders = 0;
                $unpaidOrders = 0;
                foreach ($values as $orderAll) {
                    $popover = '';
                    foreach($orderAll as $data) {
                        $popover .= '<p>';
                        $popover .= 'Product: \'' . $data['productName'] . '\' ';
                        $popover .= 'Category: \'' . $data['category'] . '\' ';
                        $popover .= 'Quantity: \'' . $data['productQuantity'] . '\' ';
                        $popover .= '</p>';
                    }
                    $order = reset($orderAll);
                ?>
                <tr>
                    <td style="text-align:center"><?php echo $order['orderId']; ?></td>
                    <td style="text-align:center"><?php echo $order['buyerUserName']; ?></td>                    
                    <td style="text-align:center"><?php echo $order['createdAt']; ?></td>
                    <td style="text-align:center">
                        <?php echo $order['orderPaidStatus'] === '1' ? 'Paid' : 'Not paid'; ?>
                    </td>
                    <td style="text-align:center; color:<?php echo $order['orderPaidStatus'] === '1' ? '#009933' : '#ff3333'; ?>">
                        <?php echo $order['orderAmount']; ?>
                    </td>
                    <td style="text-align:center">
                        <a
                            href="#"
                            data-toggle="popover"
                            data-placement="left"
                            data-trigger="focus"
                            data-content="<?php echo $popover; ?>"
                            >
                            Products
                        </a>
                    </td>
                </tr>
                <?php
                    $totalOrders += floatval($order['orderAmount']);
                    if ($order['orderPaidStatus'] === '0') {
                        $unpaidOrders += floatval($order['orderAmount']);
                    }
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align:center">Order ID</th>
                <th style="text-align:center">Buyer</th>
                <th style="text-align:center">Created at</th>
                <th style="text-align:center">Paid</th>
                <th style="text-align:center">Amount</th>
                <th style="text-align:center">Details</th>
            </tr>
        </tfoot>
    </table>
</div>
<script>
    document.getElementById('total').innerHTML = '<?php echo number_format($totalOrders, 2, ',', '.'); ?>';
    document.getElementById('unpaid').innerHTML = '<?php echo number_format($unpaidOrders, 2, ',', '.');?>';
    document.getElementById('paid').innerHTML = '<?php echo number_format((floatval($totalOrders) - floatval($unpaidOrders)), 2, ',', '.');?>';

    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            html:true,
            animation: false,
            trigger: 'hover',
            delay: {
                "hide": 100
            }
        });
        $('.popover-dismiss').popover({
            trigger: 'focus'
        })
        $('#reportesOrders').DataTable({
            order: [[2, 'desc' ]],
            pagingType: "first_last_numbers",
            pageLength: 25,
            initComplete: function () {
                // Apply the search
                this.api().columns().every( function () {
                    var that = this;
    
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    });
                });
            }
        });
 
        $('#reportesOrders tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search: '+title+'" />' );
        });
    });
</script>