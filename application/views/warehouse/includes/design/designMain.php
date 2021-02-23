<div class="row">
    <div class="col-lg-6">
        <label for="defaultdesignid">Create your own design from default template(s)</label>
        <select style="border-radius: 50px" onchange="redirectToNewLocation(this.value)" class="form-control" id="defaultdesignid">
            <option  value="">Select default template</option>
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
            <select style="border-radius: 50px;" onchange="redirectToNewLocation(this.value)" class="form-control" id="designid">
                <option value="">Select custom template</option>
                <?php foreach ($allVendorDesigns as $vendorDesign) { ?>
                    <option
                        value="<?php echo 'viewdesign?designid=' . $vendorDesign['id']; ?>"
                        <?php if ($designId === intval($vendorDesign['id'])) echo 'selected'; ?>
                    >
                        <?php
                            echo $vendorDesign['templateName'];
                            if ($vendorDesign['active'] === '1') echo '&nbsp;(active)';
                        ?>
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
                        <input style="border-radius: 50px" type="text" class="form-control" name="templateName" value="<?php echo $designName; ?>" />
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
                    <select style="border-radius: 50px" id="device" class="form-control">
                        <?php foreach($devices as $device): ?>
                        <option
                            value="<?php echo $device['width']."x".$device['height']; ?>"><?php echo $device['device']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="views">
                        <button style="border-radius: 50px" onclick="return false" value="3">View 1 - Front</button>
                        <button style="border-radius: 50px" onclick="return false" value="1">View 2 - Laying</button>
                        <button style="border-radius: 50px" onclick="return false" value="2">View 3 - Side</button>
                    </div>
                </div>
            </div>
            <div style="height: 500px; width: 100%; overflow-y: scroll;">
                <?php
                    include_once FCPATH . 'application/views/warehouse/includes/design/selectTypeView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/closed.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/selectSpotView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/makeOrderNewView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/checkoutOrderView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/buyerDetailsView.php';
                    include_once FCPATH . 'application/views/warehouse/includes/design/payOrderView.php';
                ?>
                </div>
                <input type="submit" class="btn btn-primary mt-3" value="submit" />
            </form>
        <?php } ?>
    </div>
    <div class="col-lg-6">
        <?php if (!empty($design)) { ?>
            <div id="wrapper" style="position:fixed; top:3%">
                <div class="phone view_3" id="phone_1" style="margin:auto; width:80%;">
                    <iframe id="iframe" src="<?php echo $iframeSrc; ?>" width="420px" height="650px"></iframe>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
