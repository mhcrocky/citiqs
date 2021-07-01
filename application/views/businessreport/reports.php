
    <div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable">
        <?php if ($reportPrinters || $emailFinanceReporets === '1') { ?>
        <div class="float-right text-center pl-3">
            <button
                class="btn btn-primary"
                data-timepicker-id="reportDateTime"
                data-report="<?php echo $xReport; ?>"
                onclick="sendReportPrintRequest(this)">Print x-report</button>
            <button
                class="btn btn-primary"
                data-timepicker-id="reportDateTime"
                data-report="<?php echo $zReport; ?>"
                onclick="sendReportPrintRequest(this)">Print z-reportes</button>
        </div>
        <?php } ?>
        <div class="float-right text-center pl-3">
            <input style="width: 330px;" class="date form-control-sm mb-2" type="text" name="datetimes"
                id="reportDateTime" />
            <select style="width: 264px;font-size: 14px;"
                class="custom-select custom-select-sm form-control form-control-sm  mb-1 " id="serviceType">
                <option value="">Choose Service Type</option>
                <?php foreach ($service_types as $service_type): ?>
                <option id="<?php echo $service_type['id']; ?>" value="<?php echo $service_type['type']; ?>">
                    <?php echo ucfirst($service_type['type']); ?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    <div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable">
        <div class="w-100 mt-3 mb-3 mx-auto">
            <div class="col-md-12 mb-4">
                <main class="query-main" class="p-3" role="main">
                    <div id="query-builder"></div>
                    <div class="w-100 text-right p-3">
                        <button class="btn btn-primary parse-json">Run the query</button>
                    </div>
                </main>
            </div>

        </div>

        <div class="w-100 mt-3 table-responsive">
            <table id="report" class="table table-striped table-bordered" cellspacing="0" width="100%">

                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align:center">Total:</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            <div id="tbl_data">

            </div>

        </div>
        <table
            style="display: none;"
            id="total-percentage"
            class="table table-striped table-bordered mt-3"
            cellspacing="0"
            width="100%"
        >
        </table>
        <table
            id="total_categories"
            class="table table-striped table-bordered mt-3"
            cellspacing="0"
            width="100%"
        >
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
                        <div class="col-md-4 pt-2 font-weight-bold">Amount (€<span id="order_amount"></span>):</div>
                        <div class="col-md-8">
                            <input type="text" style="max-width: 75px;padding-left: 5px;padding-right: 5px;" class="form-control ml-auto" id="amount" value="0" disabled>
                        </div>
                    </div>
                    <div style="flex-wrap: unset;" class="row pl-4 pr-1 pt-4">
                        <div class="col-md-4 pt-2 font-weight-bold">Free Amount:</div>
                        <div style="flex-wrap: unset" class="col-md-8 input-group">
                            <input type="hidden" id="amount_limit">
                            <input type="text" style="max-width: 22px;width: 22px;padding-left: 5px;padding-right: 0px;border-right: 0px;" class="form-control ml-auto" value="€" disabled>
                            <input type="number" max="0" onchange="freeAmountValidate(this)" style="max-width: 53px;width: 53px;padding-left: 0px;padding-right: 5px;border-left: 0px;" class="form-control" id="freeamount" name="freeamount" value="0.00">
                        </div>
                    </div>
                    <div style="flex-wrap: unset;" class="row pl-4 pr-1 pt-4 pb-4">
                        <div class="col-md-4 pt-2 font-weight-bold">Description:</div>
                        <div class="col-md-8 input-group"><input type="text" class="form-control" id="description" disabled></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-warning btn-refund"
                        onclick="refundMoney('refundOrderId', 'total_amount', 'amount', 'freeamount', 'description')"
                    >Refund</button>
                </div>
            </div>
        </div>
    </div>