<main class="my-form">
    <div class="w-100 mt-5 p-3">
        <div class="input-group col-md-4">
            <a href="<?php echo base_url(); ?>events/create">
                <input type="button" value="Add Event" style="background: #009933 !important;border-radius:0;height:45px;"
                    class="btn btn-success form-control mb-3 text-left">
                <a style="background: #004d1a;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3 mr-2">
                    <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></a>
            </a>
            <input type="button" value="Set shop settings" style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left ml-2" data-toggle="modal" data-target="#addShopSettings">
                <a style="background: #0a6648;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3" data-toggle="modal" data-target="#addShopSettings">
                    <i style="color: #fff;font-size: 18px;" class="fa fa-cog"></i></a>
        </div>
        <div style="padding-right: 0px;" class="col-md-3 ml-auto mb-3">
            <select id="selectTime" style="height: 40px !important;"
                class="form-control custom-select custom-select-sm form-control-sm">
                <option value="all">All</option>
                <option value="past">Past</option>
                <option value="future" selected>Future</option>
                <option value="archived">Archived</option>
            </select>
        </div>
        <div class="w-100 mt-5 table-responsive">
            <table id="events" class="table table-striped table-bordered" style="width:100%;">

            </table>
        </div>


        <div class="w-100 mt-4 mb-3 mx-auto">
            <div class="col-md-12 mb-4">
                <main class="query-main" class="p-3" role="main">
                    <div id="query-builder"></div>
                    <div class="w-100 text-right p-3">
                        <button class="btn btn-primary parse-json">Run the query</button>
                    </div>
                </main>
            </div>

        </div>
        <div class="float-right mt-4 text-center pl-3">
            <input style="width: 330px;" class="date form-control-sm mb-2" type="text" name="datetimes" />
        </div>

        <div class="w-100 mt-3 table-responsive">
            <table id="report" class="table table-striped table-bordered" cellspacing="0" width="100%">


            </table>


        </div>
    </div>
</main>


<!-- Refund Modal -->
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
                        <input type="text"
                            style="max-width: 22px;width: 22px;padding-left: 5px;padding-right: 0px;border-right: 0px;"
                            class="form-control ml-auto" value="-€" disabled>
                        <input type="number" max="0" onchange="freeAmountValidate(this)"
                            style="max-width: 53px;width: 53px;padding-left: 0px;padding-right: 5px;border-left: 0px;"
                            class="form-control" id="freeamount" name="freeamount" value="0.00">
                    </div>
                </div>
                <div style="flex-wrap: unset;" class="row pl-4 pr-1 pt-4">
                    <div class="col-md-4 pt-2 font-weight-bold">Amount (€<span id="order_amount"></span>):</div>
                    <div class="col-md-8">
                        <input type="text" style="max-width: 75px;padding-left: 5px;padding-right: 5px;"
                            class="form-control ml-auto" id="amount" value="0" disabled>
                    </div>
                </div>

                <div style="flex-wrap: unset;" class="row pl-4 pr-1 pt-4 pb-4">
                    <div class="col-md-4 pt-2 font-weight-bold">Description:</div>
                    <div class="col-md-8 input-group"><input type="text" class="form-control" id="description" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-refund">Refund</button>
            </div>
        </div>
    </div>
</div>


<!-- Shop Settings Modal -->
<div class="modal fade" id="addShopSettings" tabindex="-1" role="dialog" aria-labelledby="addaddShopSettings"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="addaddShopSettingsLabel">
                Shop Settings
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="status" class="col-md-4 col-form-label text-md-left">
                    Address
                    </label>
                    <div class="col-md-6">
                        <select id="showAddress" name="showAddress" class="form-control custom-select custom-select-sm form-control-sm">
                            <option value="1">Show</option>
                            <option value="0" selected>Hide</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status" class="col-md-4 col-form-label text-md-left">
                    Zip Code
                    </label>
                    <div class="col-md-6">
                        <select id="showZipcode" name="showZipcode" class="form-control custom-select custom-select-sm form-control-sm">
                            <option value="1">Show</option>
                            <option value="0" selected>Hide</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status" class="col-md-4 col-form-label text-md-left">
                    Country
                    </label>
                    <div class="col-md-6">
                        <select id="showCountry" name="showCountry" class="form-control custom-select custom-select-sm form-control-sm">
                            <option value="1">Show</option>
                            <option value="0" selected>Hide</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status" class="col-md-4 col-form-label text-md-left">
                    Mobile Number
                    </label>
                    <div class="col-md-6">
                        <select id="showMobileNumber" name="showMobileNumber" class="form-control custom-select custom-select-sm form-control-sm">
                            <option value="1">Show</option>
                            <option value="0" selected>Hide</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeShopSettingsModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="saveShopSettings()" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
(function(){
    var shopsettings = '<?php echo json_encode($shopsettings); ?>';
    shopsettings = JSON.parse(shopsettings);
    if(typeof shopsettings === 'object' && shopsettings !== null){
        $('#showAddress').val(shopsettings.showAddress);
        $('#showCountry').val(shopsettings.showCountry);
        $('#showZipcode').val(shopsettings.showZipcode);
        $('#showMobileNumber').val(shopsettings.showMobileNumber);
    }
}())
</script>