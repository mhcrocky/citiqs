<div class="col-12 step step-4 active">
    <form id="checkItem" class="w-100" action="<?php echo $this->baseUrl; ?>agenda_booking/pay" method="post">
        <div class="form-group w-100">
            <label class="form-check-label" for="11"><strong>Name</strong></label>
            <input class="form-control" type="text" id="username" name="username" placeholder="Your Name" required>
        </div>
        <div class="form-group w-100">
            <label class="form-check-label" for="11"><strong>Email</strong></label>
            <input class="form-control" id="email" name="email" placeholder="Your Email" required>
        </div>
        <div class="form-group w-100">
            <label class="form-check-label" for="11"><strong>Phone Number</strong></label>
            <input class="form-control" name="mobile" id="mobile" type="tel" placeholder="Your Phone Number" required>
        </div>
        <!-- end booking form inputs -->
        <div id="booking-footer" class="booking-form__result w-100">
            <h4 id="footer-title" class="mb-3">Booking info </h4>
			<div id="booking-info" class="w-100 row bg-white p-2 pt-4">
			<table class="w-100">

            <tr style="width:50%">
			    <th class="booking-info">
			        <strong class="event-text">Date</strong>
			    </th>
				<th class="booking-info">
				    <strong class="spot-text">Place</strong>
			    </th>
			</tr>
			<tr style="width:50%">
			    <td class="booking-info">
				    <span id="selected-date">
                        <?php 
						    $shorturl = $this->session->userdata('shortUrl');
						    if(base_url("agenda_booking/$shorturl") != current_url()):
							    echo date("d-m-Y", strtotime($this->session->userdata('eventDate')));
						    endif;
					    ?>
                    </span>
			    </td>
				<td class="booking-info">
				    <span id="spot"><?php echo $this->session->userdata('spotDescript'); ?></span>
			    </td>
			</tr>

			<tr style="width:50%;">
			    <th class="booking-info pt-4">
			        <strong class="timeslot-text">Time</strong>
			    </th>
				<th class="booking-info  pt-4">
				    <strong>Price</strong>
			    </th>
			</tr>
			<tr style="width:50%">
			    <td class="booking-info">
					<span id="selected-time">
					    <?php echo (!is_numeric($this->session->userdata('timeslot'))) ? $this->session->userdata('timeslot') : ''; ?>
					</span>
			    </td>
				<td class="booking-info">
				    <span id="price">
                        <?php echo $this->session->userdata('timeslotPrice'); ?>€ 
						<?php if($reservationFee != 0.00){ ?>
						(Fee <?php echo $reservationFee; ?>€)
						<?php } ?>
                    </span>
				    
			    </td>
			</tr>
			</table>





          
					
        </div>
		</div>
		<div class="w-100 text-right">
		    <button data-brackets-id="2918" type="submit" class="btn-primary btn mt-3" id="button-submit">BOOK NOW</button>
		</div>
        <div class="w-100 go-back-wrapper">
            <a class="go-back-button" href="javascript:history.back()">Go Back</a>
        </div>
    </form>
</div>
<script>
$('input').on('change', function() {
    let info = $('#username').val() + ', ' + $('#email').val() + ', ' + $('#mobile').val();
    $('#personal-info').text(info);
});
</script>