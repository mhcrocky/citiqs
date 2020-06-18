<!-- <div style="margin:10px 0px 0px 30px; font-size:16px">
    <div class="row">
        <p class="col-sm-2">Total:</p>
        <p class="col-sm-2" id="totalSpots" style="text-align:right;"></p>
    </div>
    <div class="row">
        <p class="col-sm-2">Unpaid:</p>
        <p class="col-sm-2" id="unpaidSpots" style="border-bottom: solid 2px #000; color:#ff3333; text-align:right;"></p>
    </div>
    <div class="row">
        <p class="col-sm-2">Income:</p>
        <p class="col-sm-2" id="paidSpots" style="text-align:right;"></p>
    </div>
</div> -->
<div class="table-responsive col-sm-12" style="margin-top:20px">
    <table id="reportesSpots" class="table table-hover table-striped display" style="width:100%">
        <thead>
            <tr>
                <th style="text-align:center">Spot</th>
                <th style="text-align:center">In orders</th>
                <th style="text-align:center">Paid</th>
                <th style="text-align:center">Unpaid</th>
                <th style="text-align:center">Total</th>                
            </tr>
        </thead>
        <tbody>
            <?php
                $total = 0;
                $unpaid = 0;
                foreach ($values as $spot => $details) {
                    $spotMin = $details[0];
                    $paidSpots = 0;
                    $unpaidSpots = 0;
                    $totalSpots = 0;
                    $orders = [];
                    foreach($details as $data) {
                            if (!in_array($data['orderId'], $orders)) {
                                array_push($orders, $data['orderId']);
                            }
                            $money = floatval($data['productPrice']) * floatval($data['productQuantity']) ;
                            $totalSpots += $money;
                            $total += $money;
                            if ($data['orderPaidStatus'] === '1') {
                                $paidSpots += $money;
                            } else {
                                $unpaidSpots += $money;
                                $unpaid += $money;
                            }
                 
                    }
                ?>
                <tr>
                    <td style="text-align:center"><?php echo $spotMin['spotName']; ?></td>
                    <td style="text-align:center"><?php echo count($orders); ?></td>
                    <td style="text-align:center"><?php echo $paidSpots; ?> (<?php echo round(($paidSpots / $totalSpots * 100), 2); ?> %)</td>
                    <td style="text-align:center; color:#ff3333;"><?php echo $unpaidSpots; ?> (<?php echo round(($unpaidSpots / $totalSpots * 100), 2); ?> %)</td>
                    <td style="text-align:center"><?php echo $totalSpots; ?></td>
                </tr>
                <?php
                
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align:center">Spot</th>
                <th style="text-align:center">In orders</th>
                <th style="text-align:center">Paid</th>
                <th style="text-align:center">Unpaid</th>
                <th style="text-align:center">Total</th>  
            </tr>
        </tfoot>
    </table>
</div>
<script>
    // document.getElementById('totalSpots').innerHTML = '<?php #echo number_format($total, 2, ',', '.'); ?>';
    // document.getElementById('unpaidSpots').innerHTML = '<?php #echo number_format($unpaid, 2, ',', '.');?>';
    // document.getElementById('paidSpots').innerHTML = '<?php #echo number_format((floatval($total) - floatval($unpaid)), 2, ',', '.');?>';
</script>