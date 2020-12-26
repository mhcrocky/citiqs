<div class="row" id="controls">
    <div class="col-md-6">
        <div>
            <input type="hidden" id="iframeURL" value="<?php echo $iframeSrc; ?>" />
        </div>
        <div>
            <input type="hidden" id="iframeWidth" value="414" />
        </div>
        <div>
            <input type="hidden" id="iframeHeight" value="896" />
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

<legend>Select general view</legend>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Body Background color:
        <input  data-jscolor="" class="form-control jscolor" name="selectShortUrl[id][body][background-color]"
            data-css-selector="id" data-css-selector-value="body" data-css-property="background-color"
            onfocus="styleELements(this)" oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['id']['body']['background-color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['id']['body']['background-color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Header Background color:
        <input  data-jscolor="" class="form-control jscolor" name="selectShortUrl[class][elem][background-color]"
            data-css-selector="class" data-css-selector-value="elem" data-css-property="background-color"
            onfocus="styleELements(this)" oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['class']['elem']['background-color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['class']['elem']['background-color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Active Background color:
        <input  data-jscolor="" class="form-control jscolor"
            name="selectShortUrl[class][booking-active][background-color]" data-css-selector="class"
            data-css-selector-value="booking-active" data-css-property="background-color" onfocus="styleELements(this)"
            oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['class']['booking-active']['background-color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['class']['booking-active']['background-color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="col-sm-12 input-group">
    <label style="display:block;">
        Background color:
        <input data-jscolor="" class="form-control jscolor"
            name="selectShortUrl[class][booking-form][background-color]" data-css-selector="class"
            data-css-selector-value="booking-form" data-css-property="background-color" onfocus="styleELements(this)"
            oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['class']['booking-form']['background-color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['class']['booking-form']['background-color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Footer Background color:
        <input  data-jscolor="" class="form-control jscolor"
            name="selectShortUrl[id][booking-footer][background-color]" data-css-selector="id"
            data-css-selector-value="booking-footer" data-css-property="background-color" onfocus="styleELements(this)"
            oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['id']['booking-footer']['background-color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['id']['booking-footer']['background-color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Title color:
        <input  data-jscolor="" class="form-control jscolor" name="selectShortUrl[id][title][color]"
            data-css-selector="id" data-css-selector-value="title" data-css-property="color"
            onfocus="styleELements(this)" oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['id']['title']['color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['id']['title']['color']?>" data-value="1" <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Title Border Bottom color:
        <input  data-jscolor="" class="form-control jscolor" name="selectShortUrl[id][title][border-bottom-color]"
            data-css-selector="id" data-css-selector-value="title" data-css-property="border-bottom-color"
            onfocus="styleELements(this)" oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['id']['title']['border-bottom-color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['id']['title']['border-bottom-color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Booking Title color:
        <input  data-jscolor="" class="form-control jscolor" name="selectShortUrl[id][footer-title][color]"
            data-css-selector="id" data-css-selector-value="footer-title" data-css-property="color"
            onfocus="styleELements(this)" oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['id']['footer-title']['color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['id']['footer-title']['color']?>" data-value="1" <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Booking Info color:
        <input  data-jscolor="" class="form-control jscolor" name="selectShortUrl[class][booking-info][color]"
            data-css-selector="class" data-css-selector-value="booking-info" data-css-property="color"
            onfocus="styleELements(this)" oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['class']['booking-info']['color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['class']['booking-info']['color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Go Back button color:
        <input  data-jscolor="" class="form-control jscolor" name="selectShortUrl[class][go-back-button][color]"
            data-css-selector="class" data-css-selector-value="go-back-button" data-css-property="color"
            onfocus="styleELements(this)" oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['class']['go-back-button']['color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['class']['go-back-button']['color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>

<script>

$(document).ready(function() {
    $('#device').on('change', function() {
        let device = $("#device option:selected").val();
        let px = device.split('x');
        console.log(px);
        screen(px[0], px[1]);
    });
})

function screen(width, height) {
    $("#iframeWidth").val(width);
    $("#iframeHeight").val(height);
    updateIframe();
}
</script>