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
            <a class="nav-link" id='iframe-popup-open' data-toggle="tab" href="#iframeSettings">Iframe</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#popup">Iframe Popup</a>
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
                            <input type="submit" class="btn btn-primary" value="submit" />
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
                <h3 style="margin: 15px 0px 20px 0px">Iframe Popup</h3>
                <div class="form-group" style="margin-top:30px">
                    <label for="iframeId" onclick='copyToClipboard("iframePopup")' style="text-align:left; display:block">
                        Copy to clipboard:
                        <textarea class="form-control w-100" id="iframeId" readonly rows="4"
                            style="height:60px;width: 200px;"><?php
                    #$iframe  = htmlentities('<script src="' . base_url() . 'assets/js/iframeResizer.js"></script>');
                    $iframe = htmlentities('<iframe frameborder="0" style="height:600px;width:100%;" scrolling="no" height="100%" width="100%" src="'.base_url().'agenda_booking/iframe/'.$userShortUrl.'"></iframe>');
                    #$iframe .= htmlentities('<script>iFrameResize({ scrolling: true, sizeHeight: true, sizeWidth: true, maxHeight:700, maxWidth:400, })</script>');
                    echo $iframe;
            ?></textarea>
                    </label>
                </div>
            </div>

            <iframe id="iframePopup" src="<?php echo base_url(); ?>agenda_booking/iframe/<?php echo $userShortUrl; ?>" frameborder="0"
                style="height:600px;width:100%;" scrolling="no" height="100%" width="100%"></iframe>
        </div>
    </div>
    <div class="iframe-popup hide" id="iframe-popup">
        <div class='iframe-popup__close' id='popup-close'></div>
        <div class="iframe-popup__content">

            <iframe src="<?php echo $iframeSrc; ?>" frameborder="0" style="height:100%;width:100%;" overflow-x='hidden'
                height="100%" width="100%" id='iframe-wrapper'></iframe>
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
            if (url.includes('make_order?vendorid=') && url.includes('&typeid=') && !url.includes(
                    '&spotid=')) {
                return this['selectSpotView']
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
</script>