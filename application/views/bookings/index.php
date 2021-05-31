<div class="main-wrapper">
    <div class="col-half background-blue height-100">
        <?php
        //TIQS TO DO DO BETTER

        if(!empty($agenda))
        {
            foreach ($agenda as $day)
            {
                $date = $day->ReservationDateTime;
                $unixTimestamp = strtotime($date);
                $dayOfWeek = date("N", $unixTimestamp);
                $dayOfWeekWords = date("l", $unixTimestamp);
                ?>

                <div class="timeline-block background-<?php echo $day->Background?>" height-25 >

                    <div class="row" style="font-size: large; color:white; display: inline-flex;">

                        <div style="margin-right: 10px;" class="col-md-4 column-left">

                            
                                <p>
                                    <img src="<?php echo $this->baseUrl; ?>assets/home/images/<?php echo $dayOfWeek?>.png" alt="tiqs" width="150" height="auto" />
                                </p>
                                
                                <a href="<?php echo $this->baseUrl; ?>booking_agenda/spots/<?php echo date("Ymd", strtotime($day->ReservationDateTime)).'/'.$day->id . '?order=' . $orderRandomKey;  ?>" target="_self" class="button button-<?php echo $day->Background?> mb-25" style="font-family: caption-light;font-size: small;margin-left:20px;">
                                    <?= $this->language->Line("BOOKING-001A","BOEK");?>
                                </a>
                        </div>
                        

                        <div class="column-center text-left">
                            <div>
                                <p>
                                    <img src="<?php echo base_url() . $logoUrl; ?>" alt="tiqs" width="150" height="auto" />
                                </p>
                            </div>
                            <div style="padding-left: 12px">
                                <p style="text-align=left; font-family: caption-light;font-size: x-large" >
                                    <?php echo $day->ReservationDescription?>
                                </p>
                                <p>
                                    <?= $this->language->Line(date("l", strtotime($date)), date("l", strtotime($date)));?>
                                </p>

                            </div>
                            <p style="font-family: caption-bold; padding-left: 12px" >
                                <?php echo date("d.m.Y", strtotime($day->ReservationDateTime)) ?>
                            </p>
                        </div>

                       

                    </div>

                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div id="time" class="col-half  background-yankee timeline-content" >
        <form id="checkItem" action="<?php echo $this->baseUrl; ?>booking_agenda/resendReservation?order=<?php echo $orderRandomKey; ?>" method="post" enctype="multipart/form-data"  >
            <div class="login-box background-yankee mt-50 " style="margin-left: 30px; margin-right: 30px">
                <h2 style="font-family: caption-bold"><?php echo $this->language->Line("AGENDA-BOOKING-0001", "EMAIL NOT RECEIVED, SEND IT AGAIN"); ?></h2>
                <div class="form-group has-feedback">
                    <input type="text" id="eventdate" name="eventdate" class="form-control rounded" style="font-family:'caption-light'; border-radius: 50px !important;background: #fff !important;" placeholder="dd/mm/yyyy" required/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <!--			<div class="form-group has-feedback">-->
                <!--				<input type="text" id="reservationid" name="reservationid" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="reservation id" />-->
                <!--				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>-->
                <!--			</div>-->

                <div class="form-group has-feedback">
                    <input type="email" id="email" name="email" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="email" required/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <!--			<div class="form-group has-feedback">-->
                <!--				<input type="text" id="mobile" name="mobile" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="mobile" />-->
                <!--				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>-->
                <!--			</div>-->

                <!--			<div class="form-group has-feedback">-->
                <!--				<input type="text" id="orderid" name="orderid" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="pay orderid" />-->
                <!--				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>-->
                <!--			</div>-->

                <div class="pricing-block-footer" style="height: 200px" >
                    <button data-brackets-id="2918" type="submit" class="button button-orange">RESEND RESERVATION</button>
                </div>
            </div><!-- end pricing block -->
        </form>
    </div>
</div>
</div>

