
<div class="col-12 step step-4 active">
    <form id="checkItem" class="w-100" action="<?php echo $this->baseUrl; ?>agenda_booking/pay?order=<?php echo $orderRandomKey; ?>" method="post">
        <div class="form-group w-100">
            <label class="form-check-label" for="11"><strong><?php echo $this->language->tLine('Name'); ?></strong></label>
            <input class="form-control" type="text" id="username" name="username" placeholder="" required>
        </div>
        <div class="form-group w-100">
            <label class="form-check-label" for="11"><strong><?php echo $this->language->tLine('Email'); ?></strong></label>
            <input class="form-control" id="email" name="email" placeholder="" required>
        </div>
        <div class="form-group w-100">
            <label class="form-check-label" for="11"><strong><?php echo $this->language->tLine('Phone'); ?></strong></label>
            <input class="form-control" name="mobile" id="mobile" type="tel" placeholder="" minlength="10" required>
        </div>
        <!-- end booking form inputs -->
        <div id="booking-footer" class="booking-form__result w-100">
            <h4 id="footer-title" class="mb-3"><?php echo $this->language->tLine('Reservation Info'); ?> </h4>
			<div id="booking-info" class="w-100 row bg-white p-2 pt-4">
			<table class="w-100 text-left">

            <tr class="text-left" style="width:50%">
			    <th class="booking-info">
			        <strong class="event-text">Datum</strong>
			    </th>
				<th class="booking-info">
				    <strong class="spot-text">Plaats</strong>
			    </th>
			</tr>
			<tr class="text-left" style="width:50%">
			    <td class="booking-info text-left">
				    <span id="selected-date">
                        <?php echo date("d-m-Y", strtotime($eventDate)); ?>
                    </span>
			    </td>
				<td class="booking-info text-left">
				    <span id="spot"><?php echo $spotDescript; ?></span>
			    </td>
			</tr>

			<tr class="text-left" style="width:50%;">
			    <th class="booking-info pt-4">
			        <strong class="timeslot-text">Tijd</strong>
			    </th>
				<th class="booking-info  pt-4">
				    <strong><?php echo $this->language->tLine('Price'); ?></strong>
			    </th>
			</tr>
			<tr class="text-left" style="width:50%">
			    <td class="booking-info text-left">
					<span id="selected-time">
					    <?php echo $timeslot; ?>
					</span>
			    </td>
				<td class="booking-info text-left">
				    <span id="price">
                        <?php echo $timeslotPrice; ?>€ 
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
		    <button data-brackets-id="2918" type="submit" class="btn-primary btn mt-3" id="button-submit">reserveer nu</button>
		</div>
        <div class="w-100 go-back-wrapper">
            <a class="go-back-button" href="javascript:history.back()"><?php echo $this->language->tLine('Go Back'); ?></a>
        </div>
    </form>
</div>
<script>
$('input').on('change', function() {
    let info = $('#username').val() + ', ' + $('#email').val() + ', ' + $('#mobile').val();
    $('#personal-info').text(info);
});
</script>
