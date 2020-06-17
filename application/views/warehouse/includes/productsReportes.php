<div style="margin:10px 0px 0px 30px; font-size:16px">
    <div class="row">
        <p class="col-sm-2">Total:</p>
        <p class="col-sm-2" id="totalProducts" style="text-align:right;"></p>
    </div>
    <div class="row">
        <p class="col-sm-2">Unpaid:</p>
        <p class="col-sm-2" id="unpaidProducts" style="border-bottom: solid 2px #000; color:#ff3333; text-align:right;"></p>
    </div>
    <div class="row">
        <p class="col-sm-2">Income:</p>
        <p class="col-sm-2" id="paidProducts" style="text-align:right;"></p>
    </div>
</div>
<div class="table-responsive col-sm-12" style="margin-top:20px">
    <table id="reportesProducts" class="table table-hover table-striped display" style="width:100%">
        <thead>
            <tr>
                <th style="text-align:center">Product</th>
                <th style="text-align:center">Number of orders</th>
                <th style="text-align:center">Quantity</th>
                <th style="text-align:center">Paid</th>
                <th style="text-align:center">Unpaid</th>
                <th style="text-align:center">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $total = 0;
                $unpaid = 0;
                foreach ($values as $buyer => $details) {
                    $productMin = $details[count($details) - 1];
                    $paidProducts = 0;
                    $unpaidProducts = 0;
                    $totalProducts = 0;
                    $orders = [];
                    $quantity = 0;
                    foreach($details as $data) {
                            if (!in_array($data['orderId'], $orders)) {
                                array_push($orders, $data['orderId']);
                            }
                            $money = floatval($data['productPrice']) * floatval($data['productQuantity']) ;
                            $totalProducts += $money;
                            $total += $money;
                            $quantity += $data['productQuantity'];
                            if ($data['orderPaidStatus'] === '1') {
                                $paidProducts += $money;
                            } else {
                                $unpaidProducts += $money;
                                $unpaid += $money;
                            }
                 
                    }
                ?>
                <tr>
                    <td style="text-align:center"><?php echo $productMin['productName']; ?></td>
                    <td style="text-align:center"><?php echo count($orders); ?></td>
                    <td style="text-align:center"><?php echo $quantity ?></td>
                    <td style="text-align:center"><?php echo $paidProducts; ?> (<?php echo round(($paidProducts / $totalProducts * 100), 2); ?> %)</td>
                    <td style="text-align:center; color:#ff3333;"><?php echo $unpaidProducts; ?> (<?php echo round(($unpaidProducts / $totalProducts * 100), 2); ?> %)</td>
                    <td style="text-align:center"><?php echo $totalProducts; ?></td>
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
    document.getElementById('totalProducts').innerHTML = '<?php echo number_format($total, 2, ',', '.'); ?>';
    document.getElementById('unpaidProducts').innerHTML = '<?php echo number_format($unpaid, 2, ',', '.');?>';
    document.getElementById('paidProducts').innerHTML = '<?php echo number_format((floatval($total) - floatval($unpaid)), 2, ',', '.');?>';

    $(document).ready(function() {
        $('#reportesProducts').DataTable({
            order: [[0, 'asc' ]],
            pagingType: "first_last_numbers",
            pageLength: 10,
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

        $('#reportesProducts tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search: '+title+'" />' );
        });
    });
</script>