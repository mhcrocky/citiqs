<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="assets/home/styles/main-style.css">
<style>
.ui-slider, .ui-slider .slider-range-inverse, .ui-slider .ui-slider-range {
  height: 14px;
  border-radius: 10px;
  border-width: 0;
}

#slider-container {
  width: 100%;
  height: 80px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  position: relative;
  top: 50%;
  margin: 0 auto;
  text-align: center;
  background: #FFF;
  border-radius: 5px;
  padding: 35px 40px 30px 40px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  margin-bottom:25px;
}

.ui-slider {
  background-color: #1ABC9C;
  background-image: -webkit-linear-gradient(left, #1ABC9C 0%, #F1C40F 50%, #E74C3C 100%);
  background-image: linear-gradient(to right,#1ABC9C 0%, #F1C40F 50%, #E74C3C 100%);
}
.ui-slider * {
  outline: none;
}
.ui-slider .slider-range-inverse {
  background: #CCC;
  position: absolute;
  right: 0;
}
.ui-slider .ui-slider-range {
  background: transparent;
}
.ui-slider .ui-slider-handle {
  width: 28px;
  height: 28px;
  cursor: pointer;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
  background: #FFF;
  top: -7px;
  border-radius: 50%;
  border-width: 0;
}
.ui-slider .ui-slider-handle:active {
  box-shadow: 0 3px 20px rgba(0, 0, 0, 0.5);
}
.ui-slider .ui-slider-handle .dot {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  position: absolute;
  top: 5px;
  left: 5px;
  background: transparent;
  overflow: hidden;
}
.ui-slider .ui-slider-handle .dot .handle-track {
  display: block;
  height: 18px;
  background-color: #1ABC9C;
  background-image: -webkit-linear-gradient(left, #1ABC9C 0%, #F1C40F 50%, #E74C3C 100%);
  background-image: linear-gradient(to right,#1ABC9C 0%, #F1C40F 50%, #E74C3C 100%);
  position: absolute;
  padding-right: 18px;
}
/* unvisited link */
a:link {
	color: white;
}

/* visited link */
a:visited {
	color: white;
}

/* mouse over link */
a:hover {
	color: white;
}

/* selected link */
a:active {
	color: white;
}
</style>

<style>


</style>




<main role="main" style="margin-bottom: -30px" align="center">
	<section style="background-color:#F3D0B5; margin-top: 70px" align="center" >
		<div style="background-color:#F3D0B5;" align="center">
<!--			<h1 style="font-family: campton-bold; margin-top: 30px;color:#27253b">--><?//=$this->language->Line("PLACES-A00002",'TIQS PICKUP & DELIVERY');?><!--</h1>-->
			<h1 style="font-family: campton-bold; padding: 10px 30px; color:#ffffff">PICK UP & DELIVERY</h1>
<!--			<p style="font-family: campton-light;color: #27253b; margin-bottom: 0px">--><?//=$this->language->Line("PLACES-0020",'One stop shop to find everything at your favorite place');?><!--</p>-->

			<div class="mb-35" align="center">
						<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslocation.png" alt="tiqs" width=250 height="auto" align="center" />
			</div>
			<div class="container" style="background-color: #F3D0B5; margin-top: 10px" align="center">

			<div  style="margin-bottom:20px" align="center" >

				<div style="text-align: center" align="center">
					<h3 style="font-family: campton-bold;text-align:center"><?=$this->language->Line("PLACES-0030",'Your location');?></h3>

					<div class="form-group">

						<input
								type="text"
								class="form-control"
								placeholder="<?=$this->language->Line("PLACES-0001",'ADDRESS');?>"
								id="addressId"
						/>
					</div>

					<div class="form-group">

						<!-- <label for="cityId">City:&nbsp;</label> -->
						<input
								type="text"
								class="form-control"
								placeholder="<?=$this->language->Line("PLACES-0005",'CITY');?>"
								id="cityId"
								autofocus
						/>
					</div>

					<div class="form-group">
						<!-- <label for="cityId">City:&nbsp;</label> -->
						<p><?=$this->language->Line("PLACES-0010",'ENTER RANGE');?></p>

					</div>

					<div class="form-group">
						<!-- <label for="addressId">Address:&nbsp;</label> -->

						<div id="js-slider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="slider-range-inverse" style="width: 51%;"></div><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" style="width: 49%;"></div><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 49%;"><span class="dot"><span class="handle-track" style="width: 1000px; left: -490px;"></span></span></span></span></div>
						<span style="padding: 20px" id="rangeValue">1 km</span>

						<input type="hidden" id="myRange" value="1">

					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-info" style="border-radius: 50px; background-color: #27253b ; border: none " value="<?=$this->language->Line("PLACES-0900",'SEARCH');?>" onclick="getLocation('cityId', 'addressId', 'places', 'myRange')">
					</div>

				</div>

			</div>
	</section>

	<div class="album py-5" style="background-color: #F3D0B5">

				<?php foreach ($directories as $directory): ?>
					<div
						class="col-md-4 places"
						style="background-color: #F3D0B5"
						data-lat="<?php echo $directory['lat']; ?>"
						data-lng="<?php echo $directory['lng']; ?>"
						>
						<div class="card mb-4 shadow-sm">
							<!-- <img src="--><?php //echo $directory['image']; ?><!--" class="bd-placeholder-img card-img-top" -->
							<?php if (!$directory['placeImage']) { ?>
								<img
									src="<?php echo 'assets/home/images/bizdir.png' ?>"
									class="bd-placeholder-img card-img-top"
									height="180" alt="<?php echo $directory['business_name']; ?>"
								/>
							<?php } else { ?>
								<img
									src="<?php echo base_url() . 'assets/images/placeImages/' . $directory['placeImage']; ?>"
									class="bd-placeholder-img card-img-top"
									height="180" alt="<?php echo $directory['business_name']; ?>"
								/>
							<?php } ?>
							<div class="card-body text-center" style="background-color: #003151">
								<img src="<?php echo 'assets/home/images/tiqslogowhite.png' ?>" style="margin-left:-50%; margin-top: -350px; height: 50px; width: auto"/>
								<p class="pb-2 font-weight-bold"
								   style="font-size: 24px;color: antiquewhite"><?php echo $directory['username']; ?></p>
								<p class="pb-2 font-weight-bold distance"
								   style="font-size: 24px;color: antiquewhite"></p>
								<span style="color: antiquewhite"><?php echo $directory['address']; ?></span>
								<div class="social-links align-items-center pt-3">
									<a class="contact-link" target="_blank; color: white; --text-color: white"
									   <?php if ($directory['email']) { ?>href="<?php echo "https://tiqs.com/alfred/make_order?vendorid=".$directory['id']; ?>"<?php } ?> >
										<i class="fa fa-qrcode fa-lg" style="color: white; --text-color: white"></i> <?=$this->language->line("BIZDIR",'ORDER HERE');?></a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
		</div>
	</div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script>
$('#myRange').mousemove(function(){
    $('#rangeValue').text($('#myRange').val());
});

(function () {
  // Helper function
  var update_handle_track_pos;

  update_handle_track_pos = function (slider, ui_handle_pos) {
    var handle_track_xoffset, slider_range_inverse_width;
    handle_track_xoffset = -(ui_handle_pos / 100 * slider.clientWidth);
    $(slider).find(".handle-track").css("left", handle_track_xoffset);
    slider_range_inverse_width = 100 - ui_handle_pos + "%";
    return $(slider).find(".slider-range-inverse").css("width", slider_range_inverse_width);
  };

  // Init slider
  $("#js-slider").slider({
    range: "min",
    max: 100,
    value: 1,
    create: function (event, ui) {
      var slider;
      slider = $(event.target);
	 

      // Append the slider handle with a center dot and it's own track
      slider.find('.ui-slider-handle').append('<span class="dot"><span class="handle-track"></span></span>');

      // Append the slider with an inverse range
      slider.prepend('<div class="slider-range-inverse"></div>');

      // Set initial dimensions
      slider.find(".handle-track").css("width", event.target.clientWidth);

      // Set initial position for tracks
      return update_handle_track_pos(event.target, $(this).slider("value"));
    },
    slide: function (event, ui) {
      // Update position of tracks
	  $('#rangeValue').text(ui.value+' km');
	  $('#myRange').val(ui.value);
      return update_handle_track_pos(event.target, ui.value);
    } });
	



}).call(this);


    </script>
