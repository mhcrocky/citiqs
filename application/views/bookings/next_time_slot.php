<div class="main-wrapper" style="text-align:center">

	<div class="col-half  background-orange-light timeline-content">
			<div class="background-orange-light">
			<div style="text-align: left">
                    <a href="javascript:history.back()"><i class="fa fa-arrow-circle-left" style="font-size:48px; color:white"></i></a>
            </div>
				<div class="pricing-block-body">
					<div class="pricing-first" style="font-family: caption-bold">
						<h2 style="font-family: caption-bold">
						<h2 style="font-family: caption-bold; text-transform: uppercase;">
						    <?php echo ($this->language->Line("NEXT_TIME_SLOT-0001", "YOUR SUMMARY OF THE RESERVATION")) ? $this->language->Line("NEXT_TIME_SLOT-0001", "YOUR SUMMARY OF THE RESERVATION") : 'YOUR SUMMARY OF THE RESERVATION'; ?>
						</h2>
                            <?php foreach($reservations as $key=>$reservation): ?>
                                <div style="display: flex; justify-content: center; align-items: baseline; width: 60%; margin: auto">
                                    <div style="width: 50%;">
                                        <p style="font-family: caption-light;font-size: small">
                                            <?php echo $reservation->Spotlabel . ' ' . date('H:i', strtotime($reservation->timefrom)) . ' - ' . date('H:i', strtotime($reservation->timeto)); ?>
                                        </p>
                                    </div>
                                    <div style="width: 20%;">
                                        <a style="margin-left: 10px;" href="<?php echo $this->baseUrl; ?>booking_agenda/delete_reservation/<?php echo $reservation->id; ?>?order=<?php echo $orderRandomKey; ?>" class="delete-time-slot">
										    <?php echo ($this->language->Line("NEXT_TIME_SLOT-0006", "Cancel")) ? $this->language->Line("NEXT_TIME_SLOT-0006", "Cancel") : "Cancel"; ?>
										</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
						
						<?php if(count($bookings) < $maxBooking): ?>
                            <h4 style="font-family: caption-bold; text-transform: uppercase;">
							    <?php echo ($this->language->Line("NEXT_TIME_SLOT-0004", "WANT TO MAKE AN ADDITIONAL RESERVATION? CLICK HERE.")) ? $this->language->Line("NEXT_TIME_SLOT-0004", "WANT TO MAKE AN ADDITIONAL RESERVATION? CLICK HERE.") : "WANT TO MAKE AN ADDITIONAL RESERVATION? CLICK HERE."; ?>
							</h4>
 
                            <div class="mb-35">
                                <a href="<?php echo $this->baseUrl; ?>booking_agenda/time_slots/<?php echo $reservation->SpotId; ?>?order=<?php echo $orderRandomKey; ?>" type="button" class="button button-orange">
								    <?php echo ($this->language->Line("NEXT_TIME_SLOT-0005", "EXTRA TIME")) ? $this->language->Line("NEXT_TIME_SLOT-0005", "EXTRA TIME") : "EXTRA TIME"; ?>
								</a>
                            </div>
                        <?php endif; ?>
						<a href="<?php echo $this->baseUrl; ?>booking_agenda/pay?order=<?php echo $orderRandomKey; ?>" type="button" class="button button-orange">
							    <?php echo ($this->language->Line("NEXT_TIME_SLOT-0003", "PAY")) ? $this->language->Line("NEXT_TIME_SLOT-0003", "PAY") : "PAY"; ?>
							</a>
						<?php /*
						$i = count($allTimeSlots) - 1;
						
						if($i >= 0 && $allTimeSlots[$i]->price != 0): ?>
						<div class="pricing-block-footer" style="height: 200px" >
							<div>
								<h2 style="font-family: caption-bold; text-transform: uppercase;">
								    <?php echo ($this->language->Line("NEXT_TIME_SLOT-0002", "GO TO PAYMENT")) ? $this->language->Line("NEXT_TIME_SLOT-0002", "GO TO PAYMENT") : "GO TO PAYMENT"; ?>
								</h2>
							</div>

							<a href="<?php echo $this->baseUrl; ?>booking_agenda/pay?order=<?php echo $orderRandomKey; ?>" type="button" class="button button-orange">
							    <?php echo ($this->language->Line("NEXT_TIME_SLOT-0003", "PAY")) ? $this->language->Line("NEXT_TIME_SLOT-0003", "PAY") : "PAY"; ?>
							</a>

						</div>
                        <?php if(AVAILABLE_TO_BOOK_EXTRA_TIME): ?>
                            <h2 style="font-family: caption-bold; text-transform: uppercase;">
							    <?php echo ($this->language->Line("NEXT_TIME_SLOT-0004", "WANT TO MAKE AN ADDITIONAL RESERVATION? CLICK HERE.")) ? $this->language->Line("NEXT_TIME_SLOT-0004", "WANT TO MAKE AN ADDITIONAL RESERVATION? CLICK HERE.") : "WANT TO MAKE AN ADDITIONAL RESERVATION? CLICK HERE."; ?>
							</h2>
                            <div>
                                <img src="<?php echo $this->baseUrl . $logoUrl; ?>" alt="tiqs" width="250" height="auto" />
                            </div>
                            <div class="mb-35">
                                <a href="<?php echo $this->baseUrl; ?>booking_agenda/time_slots/<?php echo $reservation->SpotId; ?>?order=<?php echo $orderRandomKey; ?>" type="button" class="button button-orange">
								    <?php echo ($this->language->Line("NEXT_TIME_SLOT-0005", "EXTRA TIME")) ? $this->language->Line("NEXT_TIME_SLOT-0005", "EXTRA TIME") : "EXTRA TIME"; ?>
								</a>
                            </div>
                        <?php endif; ?>
						<div>
							<img src="<?php echo $this->baseUrl; ?>assets/home/images/paymentcheckout.png" alt="tiqs" width="150" height="auto" />
						</div>
						<?php else: ?>
							<a href="<?php echo $this->baseUrl; ?>booking_agenda/pay?order=<?php echo $orderRandomKey; ?>" type="button" class="button button-orange">
							    <?php echo ($this->language->Line("NEXT_TIME_SLOT-0003", "NEXT")) ? $this->language->Line("NEXT_TIME_SLOT-0003", "NEXT") : "NEXT"; ?>
							</a>
						<?php endif; */ ?>
					</div>
				</div><!-- end pricing block body -->
			</div><!-- end pricing block -->
	</div>
	<div class="col-half  background-orange timeline-content">
	</div>
</div>
<script>
	$(document).ready(function(){
		if($(document).width() <= 768){
			var pricing_details_button = $('.pricing-details-button');
			$('.pricing-details-list').hide();
			$( document ).width();
			$(pricing_details_button).click(function(){
				$(this).parents('.pricing-component-body').find('.pricing-details-list').toggle('300');
			})
		}
	})
</script>
