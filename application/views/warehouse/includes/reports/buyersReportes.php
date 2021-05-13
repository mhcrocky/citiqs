<div style="margin:10px 0px 0px 30px; font-size:16px">
    <!-- 
        <div class="row">
            <p class="col-sm-2">Total:</p>
            <p class="col-sm-2" id="totalBuyers" style="text-align:right;"></p>
        </div>
        <div class="row">
            <p class="col-sm-2">Unpaid:</p>
            <p class="col-sm-2" id="unpaidBuyers" style="border-bottom: solid 2px #000; color:#ff3333; text-align:right;"></p>
        </div>
     -->
    <div class="row">
        <p class="col-sm-3">Income: <span id="paidBuyers" style="font-weight: 900;"></span></p>
    </div>
</div>
<div class="table-responsive col-sm-12 pb-2" style="margin-top:20px">
    <!-- <div class="w-100 mb-3">
        <div class="col-md-3 ml-auto" style="padding-right: 0px !important;">
            <select id="selectBuyers" class="form-control" onchange="visibleDatatableCol('reportesBuyers','selectBuyers', 4, 5)" style="padding-top: 0px !important;padding-bottom: 0px !important;">
                <option value="">All types</option>
                <option value="4" selected>Paid</option>
                <option value="5">Unpaid</option>
            </select>
        </div>
    </div> -->
    <table id="reportesBuyers" class="table table-hover table-striped display" style="width:100%">
        <thead>
            <tr>
                <th style="text-align:center">Buyer</th>
                <th style="text-align:center">Email</th>
                <th style="text-align:center">Mobile</th>
                <th style="text-align:center">Number of orders</th>
                <th style="text-align:center">Paid</th>
                <!-- <th style="text-align:center">Unpaid</th> -->
                <th style="text-align:center">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $total = 0;
                $unpaid = 0;
                foreach ($values as $buyer => $details) {
                    $buyerMin = $details[0];
                    $paidBuyers = 0;
                    $unpaidBuyers = 0;
                    $totalBuyers = 0;
                    $orders = [];
                    foreach($details as $data) {
                            if (!in_array($data['orderId'], $orders)) {
                                array_push($orders, $data['orderId']);
                            }
                            $money = floatval($data['productPrice']) * floatval($data['productQuantity']) ;
                            $totalBuyers += $money;
                            $total += $money;
                            if ($data['orderPaidStatus'] === '1') {
                                $paidBuyers += $money;
                            } else {
                                $unpaidBuyers += $money;
                                $unpaid += $money;
                            }
                 
                    }
                ?>
                <tr>
                    <td style="text-align:center"><?php echo $buyerMin['buyerUserName']; ?></td>
                    <td style="text-align:center"><?php echo $buyerMin['buyerEmail']; ?></td>
                    <td style="text-align:center"><?php echo $buyerMin['buyerMobile']; ?></td>
                    <td style="text-align:center"><?php echo count($orders); ?></td>
                    <td style="text-align:center"><?php echo '&euro;&nbsp;' . number_format($paidBuyers, 2, ',', '.'); ?></td>
                    <!-- <td style="text-align:center; color:#ff3333;"><?php #echo $unpaidBuyers; ?> (<?php #echo round(($unpaidBuyers / (($totalBuyers != 0) ? $totalBuyers * 100 : 1)), 2); ?> %)</td> -->
                    <td style="text-align:center"><?php echo $totalBuyers; ?></td>
                </tr>
                <?php
                
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align:center">Buyer</th>
                <th style="text-align:center">Email</th>
                <th style="text-align:center">Mobile</th>
                <th style="text-align:center">Number of orders</th>
                <th style="text-align:center">Paid</th>
                <!-- <th style="text-align:center">Unpaid</th> -->
                <th style="text-align:center">Total</th>
            </tr>
        </tfoot>
    </table>
</div>
<script>
    // document.getElementById('totalBuyers').innerHTML = '<?php #echo number_format($total, 2, ',', '.'); ?>';
    // document.getElementById('unpaidBuyers').innerHTML = '<?php #echo number_format($unpaid, 2, ',', '.');?>';
    document.getElementById('paidBuyers').innerHTML = '<?php echo '&euro;&nbsp;' . number_format((floatval($total) - floatval($unpaid)), 2, ',', '.');?>';
</script>