<!-- <div style="margin:10px 0px 0px 30px; font-size:16px">
    <div class="row">
        <p class="col-sm-2">Total:</p>
        <p class="col-sm-2" id="totalCategory" style="text-align:right;"></p>
    </div>
    <div class="row">
        <p class="col-sm-2">Unpaid:</p>
        <p class="col-sm-2" id="unpaidCategory" style="border-bottom: solid 2px #000; color:#ff3333; text-align:right;"></p>
    </div>
    <div class="row">
        <p class="col-sm-2">Income:</p>
        <p class="col-sm-2" id="paidCategory" style="text-align:right;"></p>
    </div>
</div> -->
<div class="table-responsive col-sm-12" style="margin-top:20px">
    <table id="reportesCategories" class="table table-hover table-striped display" style="width:100%">
        <thead>
            <tr>
                <th style="text-align:center">Category</th>
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
                foreach ($values as $category => $details) {
                    $paidCategory = 0;
                    $unpaidCategory = 0;
                    $totalCateory = 0;
                    $orders = [];
                    foreach($details as $data) {
                            if (!in_array($data['orderId'], $orders)) {
                                array_push($orders, $data['orderId']);
                            }
                            $money = floatval($data['productPrice']) * floatval($data['productQuantity']) ;
                            $totalCateory += $money;
                            $total += $money;
                            if ($data['orderPaidStatus'] === '1') {
                                $paidCategory += $money;
                            } else {
                                $unpaidCategory += $money;
                                $unpaid += $money;
                            }
                 
                    }
                ?>
                <tr>
                    <td style="text-align:center"><?php echo $category; ?></td>
                    <td style="text-align:center"><?php echo count($orders); ?></td>
                    <td style="text-align:center"><?php echo $paidCategory; ?> (<?php echo round(($paidCategory / $totalCateory * 100), 2); ?> %)</td>
                    <td style="text-align:center; color:#ff3333;"><?php echo $unpaidCategory; ?> (<?php echo round(($unpaidCategory / $totalCateory * 100), 2); ?> %)</td>
                    <td style="text-align:center"><?php echo $totalCateory; ?></td>
                </tr>
                <?php
                
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align:center">Category</th>
                <th style="text-align:center">In orders</th>
                <th style="text-align:center">Paid</th>
                <th style="text-align:center">Unpaid</th>
                <th style="text-align:center">Total</th>
            </tr>
        </tfoot>
    </table>
</div>
<script>
    // document.getElementById('totalCategory').innerHTML = '<?php #echo number_format($total, 2, ',', '.'); ?>';
    // document.getElementById('unpaidCategory').innerHTML = '<?php #echo number_format($unpaid, 2, ',', '.');?>';
    // document.getElementById('paidCategory').innerHTML = '<?php #echo number_format((floatval($total) - floatval($unpaid)), 2, ',', '.');?>';
</script>