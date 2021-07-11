<main class="my-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card p-4">

                    <div class="card-body">


                    
                    
                        <div class="row justify-content-between">


                            <!-- Events Select Box -->
                            <div class="col-md-9">
                                <select id="events" name="events" onchange="getEventStats()"
                                        style="background-color: #f4f3f3 !important; border-radius: 0px !important; height:41px !important;font-weight: 510;"
                                        class="form-control w-100 mb-5" required>
                                    <?php if(is_array($events) && count($events) > 0): ?>
                                        <?php foreach($events as $event): ?>
                                            <option class="font-weight-bold" value="<?php echo $event['id']; ?>"><?php echo date('d/m/Y', strtotime($event['StartDate'])); ?> - <?php echo $event['eventname']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <!-- End Events Select Box -->
                        
                            <!-- First Column -->
                            <div class="col-md-6 p-right mb-5">


                                <h1 class="h5 font-weight-bold">Revenue</h1>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between b-top b-bottom">

                                    <div class="text-left">
                                    Total tickets sold
                                    </div>

                                    <div id="tickets-sold" class="font-weight-bold">
                                    <?php echo isset($event_stats['tickets_sold']) ? $event_stats['tickets_sold'] : 0; ?>
                                    </div>

                                </div>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    <div class="text-left">
                                    Total orders
                                    </div>

                                    <div id="totalOrders" class="font-weight-bold">
                                    <?php echo isset($event_stats['totalOrders']) ? $event_stats['totalOrders'] : 0; ?>
                                    </div>

                                </div>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    &nbsp

                                </div>


                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    <div class="text-left">
                                    Online recette
                                    </div>

                                    <div class="font-weight-bold">
                                    € <span id="totalAmount"><?php echo isset($event_stats['totalAmount']) ? number_format($event_stats['totalAmount'], 2) : '0.00'; ?></span>
                                    </div>

                                </div>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    <div class="text-left">
                                    Including set ticket fee
                                    </div>

                                    <div class="font-weight-bold">
                                    € 0.00
                                    </div>

                                </div>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    <div class="text-left">
                                    Tiqs Service Plus
                                    </div>

                                    <div class="font-weight-bold">
                                    € 0.00
                                    </div>

                                </div>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    <div class="text-left">
                                    SMS payment
                                    </div>

                                    <div class="font-weight-bold">
                                    € 0.00
                                    </div>

                                </div>


                                <!-- Bottom stats -->
                                <hr class="hr-200">


                                <div style="flex-wrap: unset;" class="d-flex justify-content-between b-top">

                                    <div class="text-left">
                                    Total received
                                    </div>

                                    <div class="font-weight-bold">
                                    € <span id="totalReceived"><?php echo isset($event_stats['totalAmount']) ? number_format($event_stats['totalAmount'], 2) : '0.00'; ?></span>
                                    </div>

                                </div>




                            </div>
                            <!-- End First Column -->
                        


                            <!-- Second Column -->
                            <div class="col-md-6 p-left">
                            
                                <h1 class="h5 font-weight-bold">Costs</h1>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between b-top b-bottom">

                                    <div class="text-left">
                                    Ticket fee
                                    </div>

                                    <div id="tickets-sold" class="font-weight-bold">
                                    € <span id="totalTicketFee"><?php echo isset($event_stats['totalTicketFee']) ? number_format($event_stats['totalTicketFee'], 2) : '0.00'; ?></span>
                                    </div>

                                </div>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    <div class="text-left">
                                    Payment engine fee
                                    </div>

                                    <div class="font-weight-bold">
                                    € <span id="paymentEngineFee"><?php echo isset($event_stats['paymentEngineFee']) ? number_format($event_stats['paymentEngineFee'], 2) : '0.00'; ?></span>
                                    </div>

                                </div>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    <div class="text-left">
                                    SMS fee
                                    </div>

                                    <div class="font-weight-bold">
                                    € 0.00
                                    </div>

                                </div>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    <div class="text-left">
                                    Tiqs Service Plus
                                    </div>

                                    <div class="font-weight-bold">
                                    € 0.00
                                    </div>

                                </div>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    <div class="text-left">
                                    Refunds
                                    </div>

                                    <div class="font-weight-bold">
                                    € 0.00
                                    </div>

                                </div>


                                <!-- Bottom stats -->
                                <hr class="hr-200">


                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    <div class="text-left">
                                    Total payout
                                    </div>

                                    <div class="font-weight-bold">
                                    € <span class="totalPayout">
                                        <?php 

                                            $totalAmount = isset($event_stats['totalAmount']) ? floatval($event_stats['totalAmount']) : 0;
                                            $totalTicketFee = isset($event_stats['totalTicketFee']) ? floatval($event_stats['totalTicketFee']) : 0;
                                            $paymentEngineFee = isset($event_stats['paymentEngineFee']) ? floatval($event_stats['paymentEngineFee']) : 0;
                                            $totalPayoutFloat = $totalAmount - $totalTicketFee - $paymentEngineFee;
                                            $totalPayout = number_format($totalPayoutFloat, 2);

                                            echo $totalPayout;

                                        ?>

                                    </span>
                                    <input type="hidden" id="totalPayout" class="totalPayout" value="<?php echo $totalPayout; ?>">
                                    
                                   </div>

                                </div>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px b-bottom">

                                    <div class="text-left">
                                    Promoter paid
                                    </div>

                                    <div class="font-weight-bold">
                                    € <span class="promoterPaid"><?php echo isset($event_stats['promoterPaid']) ? number_format($event_stats['promoterPaid'], 2) : '0.00'; ?></span>
                                   
                                    </div>

                                </div>

                                <div style="flex-wrap: unset;" class="d-flex justify-content-between pt-10px">

                                    <div class="text-left">
                                    Remaining
                                    </div>

                                    <div class="font-weight-bold">
                                    € <span id="remaining">
                                        <?php
                                            $promoterPaid = isset($event_stats['promoterPaid']) ? floatval($event_stats['promoterPaid']) : 0;
                                            $remaining = floatval($totalPayoutFloat) - $promoterPaid;
                                            echo number_format($remaining, 2)
                                       ?>
                                      </span>
                                    </div>

                                </div>



                            </div>
                            <!-- End Second Column -->
                            
                            
                        
                        </div>




                    </div>

                </div>
            </div>
        </div>
    </div>



<div class="w-100 mt-3 table-responsive p-4">
    <table id="eventClearings" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>

</main>


<input type="hidden" id="eventId" value="<?php echo isset($events[0]) ? $events[0]['id'] : '0'; ?>" >




<script>

function getEventStats(){
    let data = {
        'eventId': $('#events option:selected').val()
    };

    $('#eventId').val(data.eventId);

    $.post('<?php echo base_url(); ?>events/get_clearing_stats', data, function(response){
        let data = JSON.parse(response);
        let ticketsSold = (typeof data.tickets_sold !== 'undefined') ? data.tickets_sold : '0';
        let totalAmount = (typeof data.totalAmount !== 'undefined') ? number_format(data.totalAmount, 2) : '0.00';
        let totalTicketFee = (typeof data.totalTicketFee !== 'undefined') ? number_format(data.totalTicketFee, 2) : '0.00';
        let paymentEngineFee = (typeof data.paymentEngineFee !== 'undefined') ? number_format(data.paymentEngineFee, 2) : '0.00';
        let promoterPaid = (typeof data.promoterPaid !== 'undefined') ? number_format(data.promoterPaid, 2) : '0.00';
        let totalOrders = (typeof data.totalOrders !== 'undefined') ? data.totalOrders : '0';
        let totalPayout = parseFloat(totalAmount.replaceAll(',', '')) - (parseFloat(totalTicketFee.replaceAll(',', '')) + parseFloat(paymentEngineFee.replaceAll(',', '')));
        totalPayout = number_format(totalPayout, 2);

        

        $('#tickets-sold').text(ticketsSold);
        $('#totalAmount').text(totalAmount);
        $('#totalTicketFee').text(totalTicketFee);
        $('#paymentEngineFee').text(paymentEngineFee);
        $('.promoterPaid').text(promoterPaid);
        $('#totalOrders').text(totalOrders);
        $('#totalReceived').text(totalAmount);
        $('.totalPayout').text(totalPayout);
        $('#totalPayout').val(totalPayout);

        let total = $('#totalPayout').val().replaceAll(',', '');

        let remaining = parseFloat(total) - parseFloat(data.promoterPaid);
        remaining = number_format(remaining, 2);

        $('#remaining').text(remaining);

        $("#eventClearings").DataTable().ajax.reload();

    });
}

function number_format (number, decimals, dec_point = '.', thousands_sep = ',') {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
</script>