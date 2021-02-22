<div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable">
    <div class="table-responsive mb-2">
        <table class="table bg-white">
            <tr>
                <td><?php echo $event->eventname; ?></td>
                <td><?php echo $event->eventdescript; ?></td>
                <td><?php echo $event->eventVenue; ?></td>
                <td><?php echo $event->eventAddress; ?></td>
                <td><?php echo $event->eventCity; ?></td>
                <td><?php echo $event->eventZipcode; ?></td>
                <td><?php echo $event->eventCountry; ?></td>
                <td><?php echo $event->StartDate; ?></td>
                <td><?php echo $event->EndDate; ?></td>
                <td><?php echo $event->StartTime; ?></td>
                <td><?php echo $event->EndTime; ?></td>
                <td>
                    <a href="<?php echo base_url(); ?>events/shop/<?php echo $this->session->userdata('userShortUrl'); ?>"
                        class="btn btn-primary" style="background: #10b981;">Go to Shop</a>
                </td>
            </tr>
        </table>
    </div>
    <div class="w-100 mt-1 mb-4 text-right">
            <a href="<?php echo base_url(); ?>events/event/<?php echo $eventId; ?>" class="btn btn-primary mr-2"
                style="background: #10b981;">Go to Tickets</a>
        </div>
    <div class="float-right text-center pl-3">
        <input style="width: 330px;" class="date form-control-sm mb-2" type="text" name="datetimes"
            id="reportDateTime" />
        <input type="hidden" id="eventId" value="<?php echo $eventId; ?>">

    </div>
    <div class="w-100 mt-3 table-responsive">
        <table id="report" class="table table-striped table-bordered" cellspacing="0" width="100%">


        </table>


    </div>

</div>


    <!-- Modal -->
    <div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="refundModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div style="padding: 25px 10px;" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="refundModalLabel">Refund Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="padding: 0px; padding-top: 1rem;" class="modal-body">
                    <div class="w-100 table-responsive" id="productsRefund"></div>
                    <div style="flex-wrap: unset;" class="row pl-4 pr-1 pt-4">
                        <div class="col-md-4 pt-2 font-weight-bold">Free Amount:</div>
                        <div style="flex-wrap: unset" class="col-md-8 input-group">
                        <input type="hidden" id="amount_limit">
                        <input type="text" style="max-width: 22px;width: 22px;padding-left: 5px;padding-right: 0px;border-right: 0px;" class="form-control ml-auto" value="-€" disabled>
                            <input type="number" max="0" onchange="freeAmountValidate(this)" style="max-width: 53px;width: 53px;padding-left: 0px;padding-right: 5px;border-left: 0px;" class="form-control" id="freeamount" name="freeamount" value="0.00">
                        </div>
                    </div>
                    <div style="flex-wrap: unset;" class="row pl-4 pr-1 pt-4">
                        <div class="col-md-4 pt-2 font-weight-bold">Amount (€<span id="order_amount"></span>):</div>
                        <div class="col-md-8">
                            <input type="text" style="max-width: 75px;padding-left: 5px;padding-right: 5px;" class="form-control ml-auto" id="amount" value="0" disabled>
                        </div>
                    </div>

                    <div style="flex-wrap: unset;" class="row pl-4 pr-1 pt-4 pb-4">
                        <div class="col-md-4 pt-2 font-weight-bold">Description:</div>
                        <div class="col-md-8 input-group"><input type="text" class="form-control" id="description" disabled></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-refund">Refund</button>
                </div>
            </div>
        </div>
    </div>