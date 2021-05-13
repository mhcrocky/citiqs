<div style="margin:10px 0px 0px 30px; font-size:16px">
    <!-- 
        <div class="row">
            <p class="col-sm-2">Total:</p>
            <p class="col-sm-2" id="totalProducts" style="text-align:right;"></p>
        </div>
        <div class="row">
            <p class="col-sm-2">Unpaid:</p>
            <p class="col-sm-2" id="unpaidProducts" style="border-bottom: solid 2px #000; color:#ff3333; text-align:right;"></p>
        </div>
    -->
    <div class="row">
        <p class="col-sm-3">Income: <span id="paidProducts" style="font-weight: 900;"></span></p>
    </div>
</div>
<div class="table-responsive col-sm-12 pb-2" style="margin-top:20px">
    <!-- <div class="w-100 mb-3">
        <div class="col-md-3 ml-auto" style="padding-right: 0px !important;">
            <select id="selectProducts" class="form-control" onchange="visibleDatatableCol('reportesProducts','selectProducts', 3, 4)" style="padding-top: 0px !important;padding-bottom: 0px !important;">
                <option value="">All types</option>
                <option value="3" selected>Paid</option>
                <option value="4">Unpaid</option>
            </select>
        </div>
    </div> -->
    <table id="reportesProducts" class="table table-hover table-striped display" style="width:100%">
        <thead>
            <tr>
                <th style="text-align:center">Product</th>
                <th style="text-align:center">Number of orders</th>
                <th style="text-align:center">Quantity</th>
                <th style="text-align:center">Paid</th>
                <!-- <th style="text-align:center">Unpaid</th> -->
                <th style="text-align:center">Total with VAT</th>
                <th style="text-align:center">VAT</th>
                <th style="text-align:center">Net amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // $total = 0;
                // $unpaid = 0;
                foreach ($values as $buyer => $details) {
                    $productMin = $details[count($details) - 1];
                    $paidProducts = 0;
                    $unpaidProducts = 0;
                    $totalProducts = 0;
                    $orders = [];
                    $quantity = 0;
                    $vat = 0;
                    $netAmount = 0;
                    foreach($details as $data) {
                            if (!in_array($data['orderId'], $orders)) {
                                array_push($orders, $data['orderId']);
                            }
                            $money = floatval($data['productPrice']) * floatval($data['productQuantity']) ;
                            $totalProducts += $money;
                            // $total += $money;
                            $singleVat = $money - $money * 100 / (100 + floatval($data['productVat']));
                            $vat += $singleVat;
                            $netAmount += ($money - $singleVat);
                            $quantity += $data['productQuantity'];
                            if ($data['orderPaidStatus'] === '1') {
                                $paidProducts += $money;
                            } else {
                                $unpaidProducts += $money;
                                // $unpaid += $money;
                            }
                 
                    }
                ?>
                <tr>
                    <td style="text-align:center"><?php echo $productMin['productName']; ?></td>
                    <td style="text-align:center"><?php echo count($orders); ?></td>
                    <td style="text-align:center"><?php echo $quantity ?></td>
                    <td style="text-align:center">
                        <?php echo '&euro;&nbsp;' . number_format($paidProducts, 2, ',', '.'); ?>
                    </td>
                    <!-- <td style="text-align:center; color:#ff3333;">
                        <?php
                            // if ($unpaidProducts) {
                            //     echo $unpaidProducts . '&nbsp(' . round(($unpaidProducts / (($totalProducts != 0) ? $totalProducts * 100 : 1)), 2)  . '&nbsp;%)';
                            // } else {
                            //     echo '0.00';
                            // }
                        ?>
                    </td> -->
                    <td style="text-align:center"><?php echo number_format($totalProducts, 2, ',', '.'); ?></td>
                    <td style="text-align:center"><?php echo number_format($vat, 2, ',', '.'); ?></td>
                    <td style="text-align:center"><?php echo number_format($netAmount, 2, ',', '.'); ?></td>
                </tr>
                <?php
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align:center">Product</th>
                <th style="text-align:center">Number of orders</th>
                <th style="text-align:center">Quantity</th>
                <th style="text-align:center">Paid</th>
                <th style="text-align:center">Unpaid</th>
                <th style="text-align:center">Total</th>
            </tr>
        </tfoot>
    </table>
</div>
<script>
    // document.getElementById('totalProducts').innerHTML = '<?php #echo number_format($total, 2, ',', '.'); ?>';
    // document.getElementById('unpaidProducts').innerHTML = '<?php #echo number_format($unpaid, 2, ',', '.');?>';
    document.getElementById('paidProducts').innerHTML = '<?php echo '&euro;&nbsp;' . number_format((floatval($total) - floatval($unpaid)), 2, ',', '.');?>';
</script>