<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<main class="main-content w-100 container" style="margin-top:20px">    
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#design">Design</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#iframeSettings">Iframe</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="design" class="container tab-pane active" style="background: none;">                    
            <div class="row"> 
                <div class="col-lg-6">
                    <label for="defaultdesignid">Create your own design from default template(s)</label>
                    <select onchange="redirectToNewLocation(this.value)" class="form-control" id="defaultdesignid">
                        <option value="">Select default template</option>
                        <?php foreach ($allDefaultDesigns as $defaultDesign) { ?>
                            <option
                                value="<?php echo 'viewdesign?defaultdesignid=' . $defaultDesign['id']; ?>"
                                <?php if ($defaultDesignId === intval($defaultDesign['id'])) echo 'selected'; ?>
                            >
                                <?php echo $defaultDesign['templateName']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <?php if (!empty($allVendorDesigns)) { ?>
                        <label for="designid">Custom templates</label>
                        <select onchange="redirectToNewLocation(this.value)" class="form-control" id="designid">
                            <option value="">Select custom template</option>
                            <?php foreach ($allVendorDesigns as $vendorDesign) { ?>
                                <option
                                    value="<?php echo 'viewdesign?designid=' . $vendorDesign['id']; ?>"
                                    <?php if ($designId === intval($vendorDesign['id'])) echo 'selected'; ?>
                                >
                                    <?php echo $vendorDesign['templateName']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                    <?php if (!empty($design)) { ?>
                        <div style="margin-top:20px">
                            <input
                                type="button"
                                id="triggerButton"
                                class="btn btn-primary"
                                onclick="triggerIdClick('backGroundImage')" value="Upload background image"
                            />
                            <input type="file" id="backGroundImage" onchange="uploadViewBgImage(this)" hidden />
                            
                            <input
                                type="button"
                                id="removeBgImageButton"
                                class="btn btn-danger"
                                onclick="removeBgImage(this, 'bgImage', 'removeImage')" value="Remove background image"
                                <?php if (empty($design['bgImage'])) { ?>
                                    style="display:none"
                                <?php } ?>
                            />
                            
                        </div>
                        <form
                            method="post"
                            onsubmit="return saveDesign(this)"
                            <?php if (!empty($designId)) { ?>
                                id = <?php echo $designId; ?>
                            <?php } ?>
                            style="margin-top:20px"
                        >
                            <input type="number" name="vendorId" required hidden readonly value="<?php echo $vendorId; ?>" />
                            <input
                                type="text"
                                id="bgImage"
                                name="bgImage"
                                hidden
                                <?php if (!empty($design['bgImage'])) { ?>
                                    value = "<?php echo $design['bgImage']; ?>"
                                    data-value="1"
                                <?php } ?>
                            />                            
                            <input
                                type="text"
                                id="removeImage"
                                name="removeImage"
                                hidden readonly
                                value = "0"
                                <?php if (!empty($design['bgImage'])) { ?>
                                    value = "<?php echo $design['bgImage']; ?>"
                                <?php } else { ?>
                                    value = "0"
                                <?php } ?>
                            />
                            <div class="form-group col-sm-12">
                                <label style="display:block;">
                                    Selected design name:
                                    <input type="text" class="form-control" name="templateName" value="<?php echo $designName; ?>" />
                                </label>
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="radio-inline">
                                    <input
                                        type="radio"
                                        name="active"
                                        value="1"
                                        <?php if ($designActive === '1') echo 'checked' ?>
                                    >
                                    Active
                                </label>
                                <label class="radio-inline">
                                    <input
                                        type="radio"
                                        name="active"
                                        value="0"
                                        <?php if ($designActive === '0') echo 'checked' ?>
                                    >
                                    Not active
                                </label>
                            </div>
                            <div class="row" id="controls">
                            <div class="col-md-6">
                                <div>
                                    <input type="number" id="iframeWidthDevice" value="414" hidden readonly required />
                                </div>
                                <div>
                                    <input type="number" id="iframeHeightDevice" value="896" hidden readonly required />
                                </div>
                                <div>
                                    <input style="display: none;" type="checkbox" id="iframePerspective" checked="true" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <select id="device" class="form-control">
                                    <?php foreach($devices as $device): ?>
                                    <option
                                        value="<?php echo $device['width']."x".$device['height']; ?>"><?php echo $device['device']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="views">
                                    <button onclick="return false" value="3">View 1 - Front</button>
                                    <button onclick="return false" value="1">View 2 - Laying</button>
                                    <button onclick="return false" value="2">View 3 - Side</button>
                                </div>
                            </div>
                        </div>
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
                    <?php } ?>
                </div>
                <div class="col-lg-6">
                    <?php if (!empty($design)) { ?>
                        <div id="wrapper" style="position:fixed; top:3%">
                            <div class="phone view_1" id="phone_1" style="margin:auto; width:80%;">
                                <iframe id="iframe" src="<?php echo $iframeSrc; ?>" width="420px" height="650px"></iframe>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>        
        <div id="iframeSettings" class="container tab-pane" style="background: none;">            
            <?php include_once FCPATH . 'application/views/warehouse/includes/design/iframeSettings.php'; ?>
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