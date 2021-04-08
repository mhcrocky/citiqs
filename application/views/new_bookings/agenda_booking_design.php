<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
body {
    overflow-x: hidden;
}
</style>
<main class="w-100 container" style="margin-top:20px">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="popup-close_2" data-toggle="tab" href="#design">Design</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#iframeSettings">Iframe</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#popup" onclick="popupTab()">Popup</a>
        </li>
    </ul>
    <div class="tab-content">

        <div id="design" class="container tab-pane active" style="background: none;">
            <div class="row">
                <h3 class="col-lg-12" style="margin:15px 0px">Set booking view style</h3>
                <div class="col-lg-6">
                    <form method="post" id="<?php echo $id; ?>"
                        action="<?php echo base_url(); ?>agenda_booking/savedesign">
                        <?php 
                                include_once FCPATH . 'application/views/new_bookings/design/generalView.php';
                                include_once FCPATH . 'application/views/new_bookings/design/shortUrlView.php';
                                include_once FCPATH . 'application/views/new_bookings/design/spotsView.php';
                            ?>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary mt-3" value="submit" />
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div style="margin:auto; width:100%;">
                        <!--The Main Thing-->
                        <div id="wrapper">
                            <div class="phone view_3" id="phone_1">
                                <iframe src="#" id="frame_1"></iframe>
                            </div>
                        </div>

                        <!--Controls etc.-->

                    </div>
                </div>
            </div>
        </div>
        <div id="iframeSettings" class="container tab-pane" style="background: none;">
            <?php include_once FCPATH . 'application/views/new_bookings/design/iframeSettings.php'; ?>
        </div>
        <div id="popup" class="container tab-pane" style="background: none;">
            <div class="col-lg-12" style="margin:10px 0px; text-align:left">
                <h3 style="margin: 15px 0px 20px 0px">Popup</h3>
                <div class="form-group" style="margin-top:30px">
                    <label for="iframeId" onclick='copyToClipboard("popupContent")'
                        style="text-align:left; display:block">
                        Copy to clipboard:
                        <textarea class="form-control w-100 h-100" id="popupContent" readonly rows="4"
                            style="height:60px;width: 200px;">#</textarea>
                    </label>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label style="display:block;">
                    Background color:
                    <input data-jscolor="" id="button_background" class="form-control b-radius jscolor" name="button_background"
                        onchange="buttonStyle(this,'background-color')"
                        value="$('#iframe-popup-open').css('backgroundColor')" />
                </label>
            </div>
            <div class="form-group col-sm-12">
                <label style="display:block;">
                    Text color:
                    <input data-jscolor="" id="button_text" class="form-control b-radius jscolor" name="button_text"
                        onchange="buttonStyle(this,'color')" />
                </label>
            </div>
            <div class="form-group col-sm-12">
                <label style="display:block;">
                    Border color:
                    <input data-jscolor="" id="button_border" class="form-control b-radius jscolor" name="button_border"
                        onchange="buttonStyle(this,'border-color')" />
                </label>
            </div>
            <div class="form-group col-sm-12">
                <label style="display:block;">
                    Button Text:
                    <input type="text" id="button_text_content" class="form-control b-radius" name="button_text_content"
                        onchange="buttonText(this,'color')" />
                </label>
            </div>

            <div class="form-group col-sm-12">
                <label style="display:block;">
                    <button class="btn btn-primary" onclick="saveButtonStyle()">Save</button>
                </label>
            </div>


            <div id="root"></div>
        </div>
    </div>


</main>

<script>
var designGlobals = (function() {
    let globals = {
        'id': "<?php echo $id; ?>",
        'iframe': '<?php echo $iframeSrc; ?>',
        'iframeId': 'frame_1',
        'showClass': 'showFieldsets',
        'hideClass': 'hideFieldsets',
        'shortUrlView': 'shortUrlView',
        'spotsView': 'spotsView',
        'checkUrl': function(url) {
            if (url.includes('<?php echo $userShortUrl; ?>')) {

                return this['shortUrlView']
            }
            if (url.includes('spots')) {
                return this['spotsView']
            }
            if (url.includes('pay')) {
                return '';//this['payView']
            }
            if (url.includes('make_order?vendorid=') && !url.includes('&typeid=') && url.includes(
                    '&spotid=')) {
                return this['selectedSpotView']
            }
            if (url.includes('checkout_order?order=')) {
                return this['checkoutOrderView']
            }
            if (url.includes('buyer_details?order=')) {
                return this['buyerDetailsView']
            }
            if (url.includes('pay_order?order=')) {
                return this['payOrderView']
            }
            return false;
        }
    }
    return globals;
}());

$.get('<?php echo base_url(); ?>agenda_booking/iframeJson/demotiqs/?callback=?', function(data) {
    $('#popupContent').text(data);
    $('#root').html(data);
});
</script>