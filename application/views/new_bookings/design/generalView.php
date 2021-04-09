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
    <div id="views">
        <select id="device" class="form-control mb-3">
            <?php foreach($devices as $device): ?>
            <option
                value="<?php echo $device['width']."x".$device['height']; ?>"><?php echo $device['device']; ?></option>
            <?php endforeach; ?>
        </select>
        
            <button onclick="return false" value="3">View 1 - Front</button>
            <button onclick="return false" value="1">View 2 - Laying</button>
            <button onclick="return false" value="2">View 3 - Side</button>
        </div>
    </div>
</div>

<legend>Select general view</legend>
<div style="height: 500px; width: 100%; overflow-y: scroll;">
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Event Text:
			<input  type="text" class="form-control b-radius" name="headerTitle[event-text]"
				onfocus="styleELements(this)"
				onchange="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['headerTitle']['event-text']) ) { ?>
				value="<?php echo $design['headerTitle']['event-text']?>" data-value="1"
				<?php } else { ?> id="event-text"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			SPOT Text:
			<input  type="text" class="form-control b-radius" name="headerTitle[spot-text]"
				onfocus="styleELements(this)"
				onchange="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['headerTitle']['spot-text']) ) { ?>
				value="<?php echo $design['headerTitle']['spot-text']?>" data-value="1"
				<?php } else { ?> id="spot-text"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Timeslot Text:
			<input  type="text" class="form-control b-radius" name="headerTitle[timeslot-text]"
				onfocus="styleELements(this)"
				onchange="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['headerTitle']['timeslot-text']) ) { ?>
				value="<?php echo $design['headerTitle']['timeslot-text']?>" data-value="1"
				<?php } else { ?> id="timeslot-text"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Personal Info Text:
			<input  type="text" class="form-control b-radius" name="headerTitle[personal-info-text]"
				onfocus="styleELements(this)"
				onchange="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['headerTitle']['personal-info-text']) ) { ?>
				value="<?php echo $design['headerTitle']['personal-info-text']?>" data-value="1"
				<?php } else { ?> id="personal-info-text"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Choose Agenda Text:
			<input  type="text" class="form-control b-radius" name="chooseTitle[choose-agenda]"
				onfocus="styleELements(this)"
				onchange="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['chooseTitle']['choose-agenda']) ) { ?>
				value="<?php echo $design['chooseTitle']['choose-agenda']?>" data-value="1"
				<?php } else { ?> value="Choose a Agenda"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Choose SPOT Text:
			<input  type="text" class="form-control b-radius" name="chooseTitle[choose-spot]"
				onfocus="styleELements(this)"
				onchange="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['chooseTitle']['choose-spot']) ) { ?>
				value="<?php echo $design['chooseTitle']['choose-spot']?>" data-value="1"
				<?php } else { ?> value="Choose an available SPOT:"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Choose Timeslot Text:
			<input  type="text" class="form-control b-radius" name="chooseTitle[choose-timeslot]"
				onfocus="styleELements(this)"
				onchange="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['chooseTitle']['choose-timeslot']) ) { ?>
				value="<?php echo $design['chooseTitle']['choose-timeslot']?>" data-value="1"
				<?php } else { ?> value="Please Choose a Time Slot"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Body Background color:
			<input  data-jscolor="" class="form-control b-radius jscolor" name="selectShortUrl[id][body][background-color]"
				data-css-selector="id" data-css-selector-value="body" data-css-property="background-color"
				onfocus="styleELements(this)" oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['id']['body']['background-color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['id']['body']['background-color']?>" data-value="1"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Header Background color:
			<input  data-jscolor="" class="form-control b-radius jscolor" name="selectShortUrl[class][elem][background-color]"
				data-css-selector="class" data-css-selector-value="elem" data-css-property="background-color"
				 oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['class']['elem']['background-color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['class']['elem']['background-color']?>" data-value="1"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Header Text color:
			<input  data-jscolor="" class="form-control b-radius jscolor" name="selectShortUrl[class][header-text][color]"
				data-css-selector="class" data-css-selector-value="header-text" data-css-property="color"
				 oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['class']['header-text']['color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['class']['header-text']['color']?>" data-value="1"
				<?php } else {?> value="#FFFFFF"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Header Font Size:
			<input  type="text" class="form-control b-radius" name="selectShortUrl[class][header-text][font-size]"
				data-css-selector="class" data-css-selector-value="header-text" data-css-property="font-size"
				 oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['class']['header-text']['font-size']) ) { ?>
				value="<?php echo $design['selectShortUrl']['class']['header-text']['font-size']?>" data-value="1"
				<?php } else {?> value="14px"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Active Background color:
			<input  data-jscolor="" class="form-control b-radius jscolor"
				name="selectShortUrl[class][booking-active][background-color]" data-css-selector="class"
				data-css-selector-value="booking-active" data-css-property="background-color" onfocus="styleELements(this)"
				oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['class']['booking-active']['background-color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['class']['booking-active']['background-color']?>" data-value="1"
				<?php } ?> />
		</label>
	</div>
	<div class="col-sm-12 input-group">
		<label style="display:block;">
			Background color:
			<input data-jscolor="" class="form-control b-radius jscolor w-100"
				name="selectShortUrl[class][booking-form][background-color]" data-css-selector="class"
				data-css-selector-value="booking-form" data-css-property="background-color" onfocus="styleELements(this)"
				oninput="styleELements(this)"
				   style="width:100%"
				<?php if ( isset($design['selectShortUrl']['class']['booking-form']['background-color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['class']['booking-form']['background-color']?>" data-value="1"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Footer Background color:
			<input  data-jscolor="" class="form-control b-radius jscolor"
				name="selectShortUrl[id][booking-footer][background-color]" data-css-selector="id"
				data-css-selector-value="booking-footer" data-css-property="background-color" onfocus="styleELements(this)"
				oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['id']['booking-footer']['background-color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['id']['booking-footer']['background-color']?>" data-value="1"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Title color:
			<input  data-jscolor="" class="form-control b-radius jscolor" name="selectShortUrl[id][title][color]"
				data-css-selector="id" data-css-selector-value="title" data-css-property="color"
				onfocus="styleELements(this)" oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['id']['title']['color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['id']['title']['color']?>" data-value="1" <?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Title Border Bottom color:
			<input  data-jscolor="" class="form-control b-radius jscolor" name="selectShortUrl[id][title][border-bottom-color]"
				data-css-selector="id" data-css-selector-value="title" data-css-property="border-bottom-color"
				onfocus="styleELements(this)" oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['id']['title']['border-bottom-color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['id']['title']['border-bottom-color']?>" data-value="1"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Booking Title color:
			<input  data-jscolor="" class="form-control b-radius jscolor" name="selectShortUrl[id][footer-title][color]"
				data-css-selector="id" data-css-selector-value="footer-title" data-css-property="color"
				onfocus="styleELements(this)" oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['id']['footer-title']['color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['id']['footer-title']['color']?>" data-value="1" <?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Booking Info background color:
			<input  data-jscolor="" class="form-control b-radius jscolor" name="selectShortUrl[id][booking-info][background-color]"
				data-css-selector="id" data-css-selector-value="booking-info" data-css-property="background-color"
				onfocus="styleELements(this)" oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['id']['booking-info']['background-color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['id']['booking-info']['background-color']?>" data-value="1"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Booking Info border radius:
			<input type="text" class="form-control b-radius" name="selectShortUrl[id][booking-info][border-radius]"
				data-css-selector="id" data-css-selector-value="booking-info" data-css-property="border-radius"
				onfocus="styleELements(this)" oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['id']['booking-info']['border-radius']) ) { ?>
				value="<?php echo $design['selectShortUrl']['id']['booking-info']['border-radius']?>" data-value="1"
				<?php } else { ?> 
				value="10px"
				<?php } ?> 
				/>
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Booking Info color:
			<input  data-jscolor="" class="form-control b-radius jscolor" name="selectShortUrl[class][booking-info][color]"
				data-css-selector="class" data-css-selector-value="booking-info" data-css-property="color"
				onfocus="styleELements(this)" oninput="bookingInfoStyle(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['class']['booking-info']['color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['class']['booking-info']['color']?>" data-value="1"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			Go Back button color:
			<input  data-jscolor="" class="form-control b-radius jscolor" name="selectShortUrl[class][go-back-button][color]"
				data-css-selector="class" data-css-selector-value="go-back-button" data-css-property="color"
				onfocus="styleELements(this)" oninput="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['selectShortUrl']['class']['go-back-button']['color']) ) { ?>
				value="<?php echo $design['selectShortUrl']['class']['go-back-button']['color']?>" data-value="1"
				<?php } ?> />
		</label>
	</div>

	<?php 
	include_once FCPATH . 'application/views/new_bookings/design/shortUrlView.php';
	include_once FCPATH . 'application/views/new_bookings/design/spotsView.php';
	?>
</div>

<script>

$(document).ready(function() {
    $('#device').on('change', function() {
        let device = $("#device option:selected").val();
        let px = device.split('x');
        console.log(px);
        screen(px[0], px[1]);
    });

    if($('#event-text').length > 0){
        $('#event-text').val('Event Date');
    }

    if($('#spot-text').length > 0){
        $('#spot-text').val('SPOT');
    }

    if($('#timeslot-text').length > 0){
        $('#timeslot-text').val('Timeslot');
    }

    if($('#personal-info-text').length > 0){
        $('#personal-info-text').val('Personal Info');
        
    }
})

function screen(width, height) {
    $("#iframeWidth").val(width);
    $("#iframeHeight").val(height);
    updateIframe();
}

function bookingInfoStyle(el){
    var color = $(el).val();
	styleELements(el);
    $("#frame_1").contents().find(".booking-info span").attr('style', 'color: '+color+' !important;');
}
</script>
