<div class="row" id="controls">
    <div class="col-md-6">
        <div>
            <input type="hidden" id="iframeURL" value="<?php echo $iframeSrc; ?>" />
        </div>
        <div>
            <!-- <label for="iframeWidth">Width:</label> -->
            <input type="hidden" class="form-control" id="iframeWidth" placeholder="400" value="400" />
        </div>
        <div>
            <!-- <label for="iframeHeight">Height:</label> -->
            <input type="hidden" class="form-control" id="iframeHeight" placeholder="650" value="650" />
        </div>
        <!--Idea by /u/aerosole-->
        <div>
            <input style="display: none;" type="checkbox" id="iframePerspective" checked="true" />
        </div>
    </div>
    <div class="col-md-6">
        <div id="views">
            <button value="3">View 1 - Front</button>
            <button value="1">View 2 - Laying</button>
            <button value="2">View 3 - Side</button>
        </div>
    </div>
</div>

<legend>Select general view</legend>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Body Background color:
        <input type="color" data-jscolor="" class="form-control" name="selectShortUrl[id][body][background-color]"
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
        <input type="color" data-jscolor="" class="form-control" name="selectShortUrl[class][elem][background-color]"
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
        <input type="color" data-jscolor="" class="form-control" name="selectShortUrl[class][booking-active][background-color]"
            data-css-selector="class" data-css-selector-value="booking-active" data-css-property="background-color"
            onfocus="styleELements(this)" oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['class']['booking-active']['background-color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['class']['booking-active']['background-color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Background color:
        <input type="color" data-jscolor="" class="form-control"
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
        <input type="color" data-jscolor="" class="form-control"
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
        <input type="color" data-jscolor="" class="form-control"
            name="selectShortUrl[id][title][color]" data-css-selector="id"
            data-css-selector-value="title" data-css-property="color" onfocus="styleELements(this)"
            oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['id']['title']['color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['id']['title']['color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
    Title Border Bottom color:
        <input type="color" data-jscolor="" class="form-control"
            name="selectShortUrl[id][title][border-bottom-color]" data-css-selector="id"
            data-css-selector-value="title" data-css-property="border-bottom-color" onfocus="styleELements(this)"
            oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['id']['title']['border-bottom-color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['id']['title']['border-bottom-color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Booking Title color:
        <input type="color" data-jscolor="" class="form-control"
            name="selectShortUrl[id][footer-title][color]" data-css-selector="id"
            data-css-selector-value="footer-title" data-css-property="color" onfocus="styleELements(this)"
            oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['id']['footer-title']['color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['id']['footer-title']['color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Booking Info color:
        <input type="color" data-jscolor="" class="form-control"
            name="selectShortUrl[class][booking-info][color]" data-css-selector="class"
            data-css-selector-value="booking-info" data-css-property="color" onfocus="styleELements(this)"
            oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['class']['booking-info']['color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['class']['booking-info']['color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>
<div class="form-group col-sm-12">
    <label style="display:block;">
        Go Back button color:
        <input type="color" data-jscolor="" class="form-control"
            name="selectShortUrl[class][go-back-button][color]" data-css-selector="class"
            data-css-selector-value="go-back-button" data-css-property="color" onfocus="styleELements(this)"
            oninput="styleELements(this)"
            <?php if ( isset($design['selectShortUrl']['class']['go-back-button']['color']) ) { ?>
            value="<?php echo $design['selectShortUrl']['class']['go-back-button']['color']?>" data-value="1"
            <?php } ?> />
    </label>
</div>