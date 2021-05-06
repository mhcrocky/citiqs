<div class="row">
    <div class="col-lg-6">
        <div style="margin-top:20px">
            <input type="button" id="triggerButton" class="btn btn-primary" onclick="triggerIdClick('backGroundImage')"
                value="Upload background image" />
            <input type="file" id="backGroundImage" onchange="uploadViewBgImage(this)" hidden />
            <input type="button" id="removeBgImageButton" class="btn btn-danger"
                onclick="removeBgImage(this, 'bgImage', 'removeImage')" value="Remove background image"
                <?php if (empty($design['bgImage'])) { ?> style="display:none" <?php } ?> />
        </div>


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
                <?php if(count($devices) > 0): ?>
                    <?php foreach($devices as $device): ?>
                    <option value="<?php echo $device['width']."x".$device['height']; ?>">
                        <?php echo $device['device']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
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
                    include_once FCPATH . 'application/views/events/includes/design/shopView.php';
                    include_once FCPATH . 'application/views/events/includes/design/ticketsView.php';
                ?>
        </div>
        <input type="submit" class="btn btn-primary mt-3" value="submit" />
        </form>

    </div>
    <div class="col-lg-6">

        <div id="wrapper" style="position:fixed; top:3%">
            <div class="phone view_3" id="phone_1" style="margin:auto; width:80%;">
                <iframe id="iframe" src="<?php echo $iframeSrc; ?>" width="420px" height="650px"></iframe>
            </div>
        </div>

    </div>
</div>