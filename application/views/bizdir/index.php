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
	body {
		background-color: #fbd19a;
	}

	.card-img-top{
		object-fit: cover;
	}



</style>

<main role="main" style="margin-bottom: -30px" align="center">
	<section style="background-color:#fbd19a; " align="center" >
		<div style="background-color:#fbd19a;" align="center">
			<h1 style="font-family: caption-bold; padding: 50px 10px 10px 10px; margin-top: 30px;color:#27253b"><?php echo $this->language->Line("PLACES-A00002",'TIQS PICKUP & DELIVERY');?></h1>
<!--			<h1 style="font-family: caption-bold; padding: 50px 10px 10px 10px; color:#ffffff">PICK UP & DELIVERY</h1>-->
			<p style="font-family: campton-light;color: #27253b; margin-bottom: 0px"><?php echo $this->language->Line("PLACES-0020",'One stop shop to find everything at your favorite place');?></p>

			<div class="mb-35" align="center">
						<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslocation.png" alt="tiqs" width=250 height="auto" align="center" />
			</div>
			<div class="container" style="background-color: #fbd19a; margin-top: 10px" align="center">

			<div  style="margin-bottom:20px" align="center" >

				<div style="text-align: center" align="center">
					<h3 style="color: #003152; font-family: caption-bold;text-align:center"><?php echo $this->language->Line("PLACES-A0030",'Order online near your location');?></h3>

					<div class="form-group">

						<input
								type="text"
								class="form-control"
								placeholder="<?php echo $this->language->Line("PLACES-A0001",'ADDRESS, CITY');?>"
								id="location"
						/>
					</div>

					<!--
					<div class="form-group">

						 <label for="cityId">City:&nbsp;</label> 
						<input
								type="text"
								class="form-control"
								placeholder="<?php echo $this->language->Line("PLACES-0005",'CITY');?>"
								id="cityId"
								autofocus
						/>
					</div>

					-->
					<div class="form-group">
						<!-- <label for="cityId">City:&nbsp;</label> -->
						<p><?php echo $this->language->Line("PLACES-0010",'ENTER RANGE');?></p>

					</div>

					<div class="form-group">
						<!-- <label for="addressId">Address:&nbsp;</label> -->

						<div id="js-slider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="slider-range-inverse" style="width: 51%;"></div><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" style="width: 49%;"></div><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 49%;"><span class="dot"><span class="handle-track" style="width: 1000px; left: -490px;"></span></span></span></span></div>
						<span style="padding: 20px" id="rangeValue">1 km</span>

						<input type="hidden" id="myRange" value="1">

					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-info" style="border-radius: 50px; background-color: #27253b ; border: none " value="<?php echo $this->language->Line("PLACES-0900",'SEARCH');?>" onclick="getPlaceByLocation('location', 'places', 'myRange')">
					</div>

				</div>

			</div>
	</section>

	<div id="places" class="album py-5" style="background-color: #fbd19a">

				
		</div>
	</div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
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

function getPlaceByUrl(location, range) {
console.log(location);

    let url = "Ajaxdorian/getPlaceByLocation";
    let post = {
        'location' : location,
        'range' : range
    }
    

    $.ajax({
        url: url,
        data: post,
        type: 'POST',
        success: function (response) {
            $("#places").empty();
            $("#places").append(response);
            $('#places .places').sort(function(a, b) {
                return $(a).data('distance') - $(b).data('distance');
            }).appendTo('#places');
            $(".places").removeClass("fade");
            
        },
        error: function (err) {
            console.dir(err);
        }
    });
}

</script>
<?php if($this->session->flashdata('location_data')): ?>
<script>
$(document).ready(function(){
  let location = '<?php echo $this->session->flashdata('location_data')->city; ?>';
  let range = '<?php $this->session->flashdata('location_data')->rangekm; ?>';
  getPlaceByUrl(location,range);
});

</script>
<?php endif; ?>
