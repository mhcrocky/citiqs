<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<main class="main-content w-100 container" style="margin-top:20px; border-width: 0px">
    <ul class="nav nav-tabs" style="border-bottom: none" role="tablist">
        <li class="nav-item">
            <a style="border-radius: 50px" class="nav-link active" data-toggle="tab" href="#design">Design</a>
        </li>
        <li class="nav-item">
            <a style="border-radius: 50px" class="nav-link" data-toggle="tab" href="#iframeSettings">Iframe</a>
        </li>
		<li class="nav-item">
			<a style="border-radius: 50px" class="nav-link" data-toggle="tab" href="#analytics">Analytics</a>
		</li>
		<li class="nav-item">
			<a style="border-radius: 50px" class="nav-link" onclick="popupTab()" data-toggle="tab" href="#pop-up">Pop-up</a>
		</li>

	</ul>

    <div class="tab-content" style="border-radius: 50px; margin-left: -10px">
        <div id="design" class="container tab-pane active" style="background: none;">                    
            <?php include_once FCPATH . 'application/views/warehouse/includes/design/designMain.php'; ?>
        </div>        
        <div id="iframeSettings" class="container tab-pane" style="background: none;">
            <?php include_once FCPATH . 'application/views/warehouse/includes/design/iframeSettings.php'; ?>
        </div>
        <div id="analytics" class="container tab-pane" style="background: none;">
            <?php include_once FCPATH . 'application/views/warehouse/includes/design/analytics.php'; ?>
        </div>
		<div id="pop-up" class="container tab-pane" style="background: none;">
			<?php include_once FCPATH . 'application/views/warehouse/includes/design/popupView.php'; ?>
		</div>

    </div>
</main>
<script>
    var designGlobals = (function() {
        let globals = {
            'id' : "<?php echo $id; ?>",
            'iframe'  : '<?php echo $iframeSrc; ?>',
            'iframeId' : 'iframe',
            'showClass' : 'showFieldsets',
            'hideClass' : 'hideFieldsets',
            'selectTypeView' : 'selectTypeView',
            'closed' : 'closed',
            'selectSpotView' : 'selectSpotView',
            'selectedSpotView' : 'selectedSpotView',
            'checkoutOrderView' : 'checkoutOrderView',
            'buyerDetailsView' : 'buyerDetailsView',
            'payOrderView' : 'payOrderView',
            'iframeWidthDeviceId' : 'iframeWidthDevice',
            'iframeHeightDeviceId' : 'iframeHeightDevice',
            'phone' : document.getElementById('phone_1'),
            'designBackgroundImageClass' : 'designBackgroundImage',
            'checkUrl' : function (url) {
                            if (url.includes('make_order?vendorid=') && !url.includes('&typeid=') && !url.includes('&spotid=')) {
                                return this['selectTypeView']
                            }
                            if (url.includes('closed')) {
                                console.dir(url);
                                return this['closed']
                            }
                            if (url.includes('make_order?vendorid=') && url.includes('&typeid=') && !url.includes('&spotid=')) {
                                return this['selectSpotView']
                            }
                            if (url.includes('make_order?vendorid=') && !url.includes('&typeid=') && url.includes('&spotid=')) {
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
