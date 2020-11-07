<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<main class="container" style="margin-top:20px">
    <div class="row">
        <div class="col-lg-12" style="margin:10px 0px; text-align:left">
            <h2>Iframe Settings</h2>
            <div class="form-inline">
                <label for="iframeWidth" style="margin-right:30px">
                    Iframe width:&nbsp;&nbsp;
                    <input
                        type="number"
                        id="iframeWidth"
                        min="1"
                        step="1"
                        value="400"
                        placeholder="Set iframe width" class="form-control"
                        style="width:80px"
                        oninput="changeIframe('iframeWidth', 'iframeHeight', 'iframeId')"
                    />
                    px
                </label>
                <label for="iframeHeight">
                    Iframe height:&nbsp;&nbsp;
                    <input
                        type="number"
                        id="iframeHeight"
                        min="0"
                        step="1"
                        value="600"
                        placeholder="Set iframe height" class="form-control"
                        style="width:80px"
                        oninput="changeIframe('iframeWidth', 'iframeHeight', 'iframeId')"
                    />
                    px
                </label>
            </div>
            <div class="form-group">
                
            </div>
            
            <div class="form-group">
                <label for="iframeId" onclick='copyToClipboard("iframeId")' style="text-align:left; display:block">
                    Copy to clipboard:
                    <textarea
                        class="form-control"
                        id="iframeId"
                        readonly
                        rows="2"
                    ><?php
                            #$iframe  = htmlentities('<script src="' . base_url() . 'assets/js/iframeResizer.js"></script>');
                            $iframe = htmlentities('<iframe frameborder="0" style="width:400px; height:600px;" src="' . $iframeSrc . '"></iframe>');
                            #$iframe .= htmlentities('<script>iFrameResize({ scrolling: true, sizeHeight: true, sizeWidth: true, maxHeight:700, maxWidth:400, })</script>');
                            echo $iframe;
                    ?></textarea>
                </label>
            </div>
        </div>
        <h3 class="col-lg-12" style="margin:15px 0px">Set buyer view style</h3>
        <div class="col-lg-6">            
            <form method="post" id="<?php echo $id; ?>" onsubmit="return saveDesign(this)">
                <?php 
                    include_once FCPATH . 'application/views/warehouse/includes/design/selectTypeView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/closed.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/selectSpotView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/makeOrderNewView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/checkoutOrderView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/buyerDetailsView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/payOrderView.php';
                ?>
                <input type="submit" class="btn btn-primary" value="submit" />
            </form>
        </div>
        <div class="col-lg-6">
            <div style="margin:auto; width:80%;">
                <iframe id="iframe" src="<?php echo $iframeSrc; ?>" width="400px" height="650px" style="position:fixed"></iframe>
            </div>
        </div>
    </div>
</main>
<script>
    var designGlobals = (function() {
        let globals = {
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
            'checkUrl' : function (url) {
                            if (url.includes('make_order?vendorid=') && !url.includes('&typeId=') && !url.includes('&spotid=')) {
                                return this['selectTypeView']
                            }
                            if (url.includes('closed')) {
                                console.dir(url);
                                return this['closed']
                            }
                            if (url.includes('make_order?vendorid=') && url.includes('&typeId=') && !url.includes('&spotid=')) {
                                return this['selectSpotView']
                            }
                            if (url.includes('make_order?vendorid=') && !url.includes('&typeId=') && url.includes('&spotid=')) {
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
    console.dir(designGlobals);
</script>