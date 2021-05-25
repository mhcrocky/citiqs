<div id="spots" class="w-100">
<section>
<div class="container">
        <div class="row row-menu">

    </div>
    </div>
</section>
<?php 
    $last = $this->uri->total_segments();
    $agenda_id = $this->uri->segment($last);
    if($spots){
        $spots_exist = false;
        $rows = array();
        $keys = array_keys($spots);
        for($i=0; $i< count($spots); $i++){
            
            if($agenda_id == $spots[$keys[$i]]['data']->agenda_id){
                $spots_exist = true;
                $rows[$keys[$i]] = $spots[$keys[$i]];
                                
            }
        }
                        
        $spots = $rows;
            
    }
    if($spots_exist):
        foreach($spots as $key=>$spot):
            $spotId = $spot['data']->id;
            $timeslots = $spot['timeslots'];
            $checkout_reservations_id = [];
            
            if(count($checkout_reservations) > 0){
                $checkout_reservations_id = array_values(array_keys($checkout_reservations));
            }
            
            if(count($timeslots) == 0){ continue;}
?>
<section>
    <div class="container">
        <div class="row row-menu">
            <div class="col-12 col-md-4">
                <h2 class="color-primary mb-5"><?php echo $spot['data']->descript; ?></h2>
                <ul class="items-gallery">
                    <li>
                    <?php if($spot['data']->image == ''): ?>
                        <img src="<?php echo base_url(); ?>assets/home/images/logo1.png"
                            alt="<?php echo $spot['data']->descript; ?>">
                    <?php else: ?>
                        <img src="<?php echo base_url(); ?>assets/home/images/<?php echo $spot['data']->image; ?>"
                            alt="<?php echo $spot['data']->descript; ?>">
                    <?php endif; ?>
                    </li>
                </ul>
            </div>
            <!-- end col -->
            <input type="hidden" class="current_time" name="current_time">
            <div class="col-12 col-md-8 pl-md-5">
                <h4 class="font-weight-bold mt-4 mt-md-3 mb-2 mb-md-4">Time Slots</h4>

                
                <div class="menu-list">
                    <?php 
                    foreach($timeslots as $key => $timeslot):
                        if($timeslot->multiple_timeslots == 1):
                            $fromtime = explode(':',$timeslot->fromtime);
                            $totime = explode(':', $timeslot->totime);
                            $duration = explode(':', $timeslot->duration);
                            $overflow = explode(':', $timeslot->overflow);
                    
                            $time_diff = ($totime[0]*60 - $fromtime[0]*60) + ($totime[1] - $fromtime[1]);
                            $time_duration = ($duration[0]*60 + $overflow[0]*60) + ($duration[1] + $overflow[1]);
                            $time_div = intval($time_diff/$time_duration);
                            $start_time = '';
                            $end_time = '';
                            for($i=0; $i < $time_div; $i++):
                            
                            if($i == 0){
                    
                                $start_time = booking_reservations::explode_time($timeslot->fromtime);
                                $end_time = $start_time + booking_reservations::explode_time($timeslot->duration);
                            } else {
                                $start_time = $end_time + booking_reservations::explode_time($timeslot->overflow);
                                $end_time = $start_time + booking_reservations::explode_time($timeslot->duration);
                            }

                              
                         ?>
                   
                    <div class="menu-list__item">
                        <div class="menu-list__name">
                            <b class="menu-list__title">Description</b>
                            <div>
                                <p class="menu-list__ingredients descript_<?php echo $timeslot->id; ?>">
                                <?php 
                                    $fromtime = booking_reservations::second_to_hhmm($start_time);
                                    $totime = booking_reservations::second_to_hhmm($end_time);
                                    echo $fromtime . ' - ' . $totime;
                                ?>
                                </p>
                            </div>
                        </div>

                        <div class="menu-list__right-col menu-list_right-col ml-auto ">
                            <div class="menu-list__price">
                                <b class="menu-list__price--discount"><?php echo number_format($timeslot->price, 2, '.', '');?>€ (<?php echo number_format($timeslot->reservationFee, 2, '.', '');?>€)</b>
                            </div>
                            <b class="menu-list__type">quantity</b>
                            <div class="quantity-section">
                                <button type="button" class="quantity-button"
                                    onclick="removeTicket(`<?php echo  $timeslot->id . '_' . $i; ?>`, '<?php echo $agenda_id; ?>', '<?php echo $spotId; ?>', '<?php echo $timeslot->price; ?>', '<?php echo $timeslot->reservationFee; ?>')">-</button>
                                <input type="number" min="1" onkeyup="absVal(this);" placeholder="0"
                                    <?php if(in_array($timeslot->id . '_' . $i,$checkout_reservations_id)){?>
                                        value="<?php echo $checkout_reservations[$timeslot->id . '_' . $i]['quantity']; ?>"
                                    <?php } else { ?> value="0" <?php } ?>
                                    class="quantity-input ticketQuantityValue_<?php echo  $timeslot->id . '_' . $i; ?>"
                                    data-fromtime="<?php echo $fromtime; ?>" data-totime="<?php echo $totime; ?>" data-numberofpersons="<?php echo $spot['data']->numberofpersons; ?>"
                                     disabled>
                                <button type="button" class="quantity-button"
                                    
                                onclick="addTicket(`<?php echo  $timeslot->id . '_' . $i; ?>`, '<?php echo $agenda_id; ?>', '<?php echo $spotId; ?>', '<?php echo $timeslot->price; ?>', '<?php echo $timeslot->reservationFee; ?>')"
                                    >+</button>
                            </div>
                            <b class="menu-list__price--discount excluding_fee text-dark mt-2">Excluding fee
                                €<?php echo number_format($timeslot->reservationFee, 2, ',', ''); ?> and min pay fee
                                €0,50</b>
                        </div>




                    </div>

                    <?php endfor; ?>
                    <?php else: ?>


                        <div class="menu-list__item">
                        <div class="menu-list__name">
                            <b class="menu-list__title">Description</b>
                            <div>
                                <p class="menu-list__ingredients descript_<?php echo $timeslot->id; ?>">
                                <?php 
                                        $dt1 = new DateTime($timeslot->fromtime);
                                        $fromtime = $dt1->format('H:i');
                                        $dt2 = new DateTime($timeslot->totime);
                                        $totime = $dt2->format('H:i'); 
                                    echo $fromtime . ' - ' . $totime;
                                ?>
                                </p>
                            </div>
                        </div>

                        <div class="menu-list__right-col menu-list_right-col ml-auto ">
                            <div class="menu-list__price">
                                <b class="menu-list__price--discount"><?php echo number_format($timeslot->price, 2, '.', '');?>€ (<?php echo number_format($timeslot->reservationFee, 2, '.', '');?>€)</b>
                            </div>
                            <b class="menu-list__type">quantity</b>
                            <div class="quantity-section">
                                <button type="button" class="quantity-button"
                                    onclick="removeTicket('<?php echo $timeslot->id; ?>', '<?php echo $agenda_id; ?>', '<?php echo $spotId; ?>', '<?php echo $timeslot->price; ?>', '<?php echo $timeslot->reservationFee; ?>')">-</button>
                                <input type="number" min="1" onkeyup="absVal(this);" placeholder="0" 
                                    <?php if(in_array($timeslot->id, $checkout_reservations_id)){?>
                                        value="<?php echo $checkout_reservations[$timeslot->id]['quantity']; ?>"
                                    <?php } else { ?> value="0" <?php } ?>
                                    class="quantity-input ticketQuantityValue_<?php echo $timeslot->id; ?>"
                                    data-fromtime="<?php echo $timeslot->fromtime; ?>" data-totime="<?php echo $timeslot->totime; ?>" data-numberofpersons="<?php echo $spot['data']->numberofpersons; ?>"
                                     disabled>
                                <button type="button" class="quantity-button"
                                    
                                    onclick="addTicket('<?php echo $timeslot->id; ?>', '<?php echo $agenda_id; ?>', '<?php echo $spotId; ?>', '<?php echo $timeslot->price; ?>', '<?php echo $timeslot->reservationFee; ?>')"
                                    >+</button>
                            </div>
                            <b class="menu-list__price--discount excluding_fee text-dark mt-2">Excluding fee
                                €<?php echo number_format($timeslot->reservationFee, 2, ',', ''); ?> and min pay fee
                                €0,50</b>
                        </div>




                    </div>

                    <?php endif; ?>
                    
                    <!-- end menu list item -->
                    <?php endforeach; ?>

                </div>
                
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->


    </div>
</section>
<?php endforeach; ?>
<?php endif; ?>

</div>