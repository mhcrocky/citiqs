<main class="my-form">
    <div class="w-100 mt-5 p-3">
        <div class="row justify-content-center">
            <div class="input-group col-md-3 justify-content-center">
                <a style="width: 80%" href="<?php echo base_url(); ?>events/create">
                    <input type="button" value="Add Event"
                        style="background: #009933 !important;border-radius:0;height:45px;"
                        class="btn btn-success form-control mb-3 text-left">
                    <a style="background: #004d1a;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                        <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></a>
                </a>

            </div>
            <div class="input-group col-md-3 justify-content-center">
                <a style="width: 80%" href="javascript:;">
                    <input type="button" value="Set shop settings"
                        style="background: #10b981 !important;border-radius:0;height:45px;"
                        class="btn btn-primary form-control mb-3 text-left" data-toggle="modal"
                        data-target="#addShopSettings">
                    <a style="background: #0a6648;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                        data-toggle="modal" data-target="#addShopSettings">
                        <i style="color: #fff;font-size: 18px;" class="fa fa-cog"></i></a>

                </a>
            </div>
            <div class="input-group col-md-3 justify-content-center">

                <a style="width: 80%" href="<?php echo base_url(); ?>events/inputs">
                    <input type="button" value="Add custom field"
                        style="background: #10b96d !important;border-radius:0;height:45px;"
                        class="btn btn-primary form-control mb-3 text-left">
                </a>
                <a href="<?php echo base_url(); ?>events/inputs" style="background: #0a6635;padding-top: 14px;"
                    class="input-group-addon pl-2 pr-2 mb-3">
                    <i style="color: #fff;font-size: 18px;" class="fa fa-file-text-o"></i></a>
            </div>
            <div class="input-group col-md-3 justify-content-center">
                <a style="width: 80%" href="<?php echo base_url(); ?>events/shop/<?php echo $shortUrl; ?>" data-toggle="modal" data-target="#copyMainShopUrlModal">
                    <input type="button" value="Multiple shop metalinks"
                        style="background: #10b997 !important;border-radius:0;height:45px;"
                        class="btn btn-success form-control mb-3 text-left">
                    <a style="background: #0a6661;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3" data-toggle="modal" data-target="#copyMainShopUrlModal">
                        <i style="color: #fff;font-size: 18px;" class="fa fa-shopping-cart"></i></a>
                </a>
            </div>
        </div>
        <div style="padding-right: 0px;" class="col-md-3 ml-auto mb-3">
            <select id="selectTime" style="height: 40px !important;"
                class="form-control custom-select custom-select-sm form-control-sm">
                <option value="all">All</option>
                <option value="past">Past</option>
                <option value="today">Today</option>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="addaddShopSettingsLabel">
                    Shop Settings
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="overflow: auto !important;" class="modal-body">
                <form id="shopsettings" method="post" enctype="multipart/form-data" action="#">
                    <div class="form-group row">

                        <label for="labels" class="col-md-4 col-form-label text-md-left">
                            Labels
                        </label>
                        <div class="col-md-6">
                            <select id="labels" name="labels"
                                class="form-control custom-select custom-select-sm form-control-sm">
                                <option value="1" selected>Show</option>
                                <option value="0">Hide</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label for="showAddress" class="col-md-4 col-form-label text-md-left">
                            Address
                        </label>
                        <div class="col-md-6">
                            <select id="showAddress" name="showAddress"
                                class="form-control custom-select custom-select-sm form-control-sm">
                                <option value="1">Show</option>
                                <option value="0" selected>Hide</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="showZipcode" class="col-md-4 col-form-label text-md-left">
                            Zip Code
                        </label>
                        <div class="col-md-6">
                            <select id="showZipcode" name="showZipcode"
                                class="form-control custom-select custom-select-sm form-control-sm">
                                <option value="1">Show</option>
                                <option value="0" selected>Hide</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="showCountry" class="col-md-4 col-form-label text-md-left">
                            Country
                        </label>
                        <div class="col-md-6">
                            <select id="showCountry" name="showCountry"
                                class="form-control custom-select custom-select-sm form-control-sm">
                                <option value="1">Show</option>
                                <option value="0" selected>Hide</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="showMobileNumber" class="col-md-4 col-form-label text-md-left">
                            Mobile Number
                        </label>
                        <div class="col-md-6">
                            <select id="showMobileNumber" name="showMobileNumber"
                                class="form-control custom-select custom-select-sm form-control-sm">
                                <option value="1">Show</option>
                                <option value="0" selected>Hide</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="showAge" class="col-md-4 col-form-label text-md-left">
                            Age
                        </label>
                        <div class="col-md-6">
                            <select id="showAge" name="showAge"
                                class="form-control custom-select custom-select-sm form-control-sm">
                                <option value="1">Show</option>
                                <option value="0" selected>Hide</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label style="margin-bottom: auto;margin-top: auto;" for="googleAnalyticsCode"
                            class="col-md-4 col-form-label text-md-left">
                            Google Analytics Code
                        </label>
                        <div class="col-md-6">
                            <input type="text" id="googleAnalyticsCode" name="googleAnalyticsCode" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label style="margin-bottom: auto;margin-top: auto;" for="googleAdwordsConversionId"
                            class="col-md-4 col-form-label text-md-left">
                            Google Adwords Conversion Id
                        </label>
                        <div class="col-md-6">
                            <input type="text" id="googleAdwordsConversionId" name="googleAdwordsConversionId"
                                class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label style="margin-bottom: auto;margin-top: auto;" for="googleAdwordsConversionLabel"
                            class="col-md-4 col-form-label text-md-left">
                            Google Adwords Conversion Label
                        </label>
                        <div class="col-md-6">
                            <input type="text" id="googleAdwordsConversionLabel" name="googleAdwordsConversionLabel"
                                class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label style="margin-bottom: auto;margin-top: auto;" for="googleTagManagerCode"
                            class="col-md-4 col-form-label text-md-left">
                            Google Tag Manager Code
                        </label>
                        <div class="col-md-6">
                            <input type="text" id="googleTagManagerCode" name="googleTagManagerCode"
                                class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label style="margin-bottom: auto;margin-top: auto;" for="facebookPixelId"
                            class="col-md-4 col-form-label text-md-left">
                            Facebook Pixel Id
                        </label>
                        <div class="col-md-6">
                            <input type="text" id="facebookPixelId" name="facebookPixelId" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label style="margin-bottom: auto;margin-top: auto;" for="facebookPixelId"
                            class="col-md-4 col-form-label text-md-left">
                            Closed Shop Message
                        </label>
                        <div class="col-md-6">
                            <input type="text" id="closedShopMessage" name="closedShopMessage" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="margin-bottom: auto;margin-top: auto;" for="facebookPixelId"
                            class="col-md-4 col-form-label text-md-left">
                            Upload Terms of Use(PDF File)
                        </label>
                        <div class="col-md-6">
                            <input type="file" id="userfile" name="userfile"
                                class="custom-file-container__custom-file__custom-file-input" accept="pdf">
                        </div>
                    </div>

                </form>



            </div>
            <div class="modal-footer">
                <button type="button" id="closeShopSettingsModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="saveShopSettings()" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Refund Modal
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


-->

<!-- Copy Main Shop Url Modal -->
<div class="modal fade" id="copyMainShopUrlModal" tabindex="-1" role="dialog" aria-labelledby="copyMainShopUrlModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="overflow: auto !important;" class="modal-body">
                <div style="flex-wrap: unset;-ms-flex-wrap: unset;" class="d-flex row text-center align-items-center">
                    <div class="col-md-9 text-center"><?php echo $fullBaseUrl; ?>events/shop/<?php echo $shortUrl; ?></div>
                    <div class="col-md-3 text-left">
                        <button class="btn btn-clear text-primary" onclick="textToClipboard('<?php echo $fullBaseUrl; ?>events/shop/<?php echo $shortUrl; ?>')">Copy URL</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Copy Shop Url Modal -->
<div class="modal fade" id="copyShopUrlModal" tabindex="-1" role="dialog" aria-labelledby="copyShopUrlModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="overflow: auto !important;" class="modal-body">
                <div style="flex-wrap: unset;-ms-flex-wrap: unset;" class="d-flex row text-center align-items-center">
                    <div class="col-md-9 text-center shopUrlText"><?php echo $fullBaseUrl; ?></div>
                    <input type="text" class="d-none" id="shopUrl">
                    <div class="col-md-3 text-left">
                        <button class="btn btn-clear text-primary" onclick="copyShopUrl()">Copy URL</button>
                    </div>
                </div>

                <?php if(count($tags) > 0): ?>
                <div id="tag_url" style="flex-wrap: unset;-ms-flex-wrap: unset;" class="row text-center align-items-center mt-3">

                    <div class="col-md-9 text-center"><span class="shopUrlText"><?php echo $fullBaseUrl; ?></span>?tag=
                        <select style="width: auto; padding-right: 25px;" id="tagUrl" name="tag"
                            class="form-control custom-select custom-select-sm form-control-sm">
                            <?php foreach($tags as $tag): ?>
                            <option value="<?php echo $tag['id']; ?>"><?php echo $tag['tag']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 text-left">
                        <button class="btn btn-clear text-primary" onclick="copyShopUrlWithTag()">Copy URL</button>

                    </div>

                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<script>
const fullBaseUrl = '<?php echo $fullBaseUrl; ?>';
(function() {
    document.querySelector('.query-main').style.borderRadius = "0px";
    var shopsettings = '<?php echo json_encode($shopsettings); ?>';
    shopsettings = JSON.parse(shopsettings);
    if (typeof shopsettings === 'object' && shopsettings !== null) {
        $('#labels').val(shopsettings.labels);
        $('#showAddress').val(shopsettings.showAddress);
        $('#showCountry').val(shopsettings.showCountry);
        $('#showZipcode').val(shopsettings.showZipcode);
        $('#showMobileNumber').val(shopsettings.showMobileNumber);
        $('#showAge').val(shopsettings.showAge);
        $('#googleAnalyticsCode').val(shopsettings.googleAnalyticsCode);
        $('#googleAdwordsConversionId').val(shopsettings.googleAdwordsConversionId);
        $('#googleAdwordsConversionLabel').val(shopsettings.googleAdwordsConversionLabel);
        $('#googleTagManagerCode').val(shopsettings.googleTagManagerCode);
        $('#facebookPixelId').val(shopsettings.facebookPixelId);
        $('#closedShopMessage').val(shopsettings.closedShopMessage);
    }
}())
</script>

<?php if(isset($cookieEventId)): ?>
<script>
function addStyle(styles) {

    var css = document.createElement('style');
    css.type = 'text/css';

    if (css.styleSheet)
        css.styleSheet.cssText = styles;
    else
        css.appendChild(document.createTextNode(styles));


    document.getElementsByTagName("head")[0].appendChild(css);
}

const cookieEventId = '<?php echo $cookieEventId; ?>';
var styles = '.eventRow' + cookieEventId + ' { outline: 1px solid red }';
window.onload = function() {
    addStyle(styles)
};
</script>
<?php endif; ?>
