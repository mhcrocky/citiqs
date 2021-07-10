<div style="margin:10px 0px 0px 30px; font-size:16px">
    <!-- <div class="row">
        <p class="col-sm-2">Total orders:</p>
        <p class="col-sm-2" id="totalOrders" style="text-align:right;"></p>
    </div>
    <div class="row">
        <p class="col-sm-2">Unpaid:</p>
        <p class="col-sm-2" id="unpaidOrders" style="border-bottom: solid 2px #000; color:#ff3333; text-align:right;"></p>
    </div> -->
    <div class="row">
        <p class="col-sm-3">Income: <span id="paidOrders" style="font-weight: 900;"></span></p>
    </div>
</div>
<div class="table-responsive col-sm-12 pb-2" style="margin-top:20px">

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
                    <td style="text-align:center;">
                        <?php 
                            $amount = floatval($order['orderAmount']) + floatval($order['serviceFee']);
                            echo '&euro;&nbsp;' . number_format($amount, 2, ',', '.');
                        ?>
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
                    $totalOrders += floatval($order['orderAmount']) + floatval($order['serviceFee']);
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
    // document.getElementById('totalOrders').innerHTML = '<?php #echo number_format($totalOrders, 2, ',', '.'); ?>';
    // document.getElementById('unpaidOrders').innerHTML = '<?php #echo number_format($unpaidOrders, 2, ',', '.');?>';
    document.getElementById('paidOrders').innerHTML = '<?php echo '&euro;&nbsp;' . number_format((floatval($totalOrders) - floatval($unpaidOrders)), 2, ',', '.');?>';
</script>
