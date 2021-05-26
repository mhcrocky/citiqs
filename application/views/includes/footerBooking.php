<!-- MODAL CHECKOUT -->
<!-- MODAL ADDITIONAL OPTIONS -->
<div class="modal fade" id="checkout-modal" tabindex="-1" role="dialog" aria-labelledby="checkout-modal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="w-100 modal-header text-right">
                <h5 class="modal-title text-left">Your Cart</h5>
                <p class="menu-list__price--discount ml-auto timer"></p>
                <button style="margin-left: 0px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php $total = 0; ?>
                <div class="menu-list">
                    <div id="checkout-list" class="w-100">
                        <?php 
                        
                        if(isset($bookings) && count($bookings) > 0): 
                    $total = isset($totalAmount) ? $totalAmount : 0.00;
                    foreach($bookings as $booking): 
                        $dt1 = new DateTime($booking['timefrom']);
                        $fromtime = $dt1->format('H:i');
                        $dt2 = new DateTime($booking['timeto']);
                        $totime = $dt2->format('H:i'); 
                         ?>

                        <div class="menu-list__item ticket_item ticket_<?php echo $booking['timeslotId']; ?>">
                            <div class="menu-list__name">
                                <b class="menu-list__title">Description</b>
                                <div>
                                    <p class="menu-list__ingredients descript_<?php echo $booking['timeslotId']; ?>">
                                    <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $booking['eventdate']; ?> &nbsp - &nbsp <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $fromtime . " - " .$totime; ?></p>
                                </div>
                            </div>
                            <div class="menu-list__left-col ml-auto">
                                <div class="menu-list__price mx-auto">
                                    <b class="menu-list__price--discount mx-auto"><?php echo $booking['price']; ?>€ (<?php echo $booking['reservationFee']; ?>€)</b>
                                </div>
                                <div class="quantity-section mx-auto mb-2">
                                    <button type="button" class="quantity-button"
                                        onclick="removeTicket(`<?php echo $booking['timeslotId']; ?>`, `<?php echo $booking['eventid']; ?>`, `<?php echo $booking['SpotId']; ?>`, `<?php echo $booking['price']; ?>`, `<?php echo $booking['reservationFee']; ?>`)">-</button>
                                    <input type="text" min="1"
                                        value="<?php echo $booking['quantity']; ?>" 
                                         placeholder="0" disabled class="quantity-input ticketQuantityValue_<?php echo $booking['timeslotId']; ?>"
                                         data-fromtime="<?php echo $booking['timefrom']; ?>" data-totime="<?php echo $booking['timeto']; ?>" data-numberofpersons="<?php echo $booking['numberofpersons']; ?>"
                                         >
                                    <button type="button" class="quantity-button"
                                        onclick="addTicket(`<?php echo $booking['timeslotId']; ?>`, `<?php echo $booking['eventid']; ?>`, `<?php echo $booking['SpotId']; ?>`, `<?php echo $booking['price']; ?>`, `<?php echo $booking['reservationFee']; ?>`)">+</button>
                                </div>
                                <b class="menu-list__type mx-auto">
                                    <button
                                        onclick="deleteTicket(`<?php echo $booking['timeslotId']; ?>`, `<?php echo $booking['price']; ?>`, `<?php echo $booking['reservationFee']; ?>`)"
                                        type="button" class="btn btn-danger bg-light color-secondary">
                                        <i class="fa fa-trash mr-2" aria-hidden="true"></i>
                                        Delete</button>
                                </b>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <!-- end menu list item -->
                        <?php endif; ?>
                    </div>
                    <div id="payForm" style="display: none;"  class="limiter">
                        <div style="background: #fff !important;" class="container-login100">
                            <div style="background: #fff !important;" class="wrap-login100">
                                <div style="background: #fff !important;">
                                    
                                </div>
                                <form class="login100-form validate-form"
                                    action="<?php echo base_url(); ?>booking_reservations/payment_proceed" method="POST">
                                    <div class="wrap-input100 validate-input m-b-26">
                                        <span class="label-input100">Full Name</span>
                                        <input class="input100" type="text" id="fullName" name="name"
                                            placeholder="Full Name" required>
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                                        <span class="label-input100">Email</span>
                                        <input class="input100" type="email" id="email" name="email"
                                            placeholder="Email Address" required>
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-18 wideField"
                                        data-validate="Address is required">
                                        <span class="label-input100">Address</span>
                                        <input class="field input100" type="text" id="autocomplete"
                                            onFocus="geolocate()" name="address" placeholder="Address" required>
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-18">
                                        <span class="label-input100">Gender</span>
                                        <select name="gender" class="field input100">
                                            <option value="male" selected>Male</option>
                                            <option value="female">Female</option>
                                            <option value="nogender">No Gender</option>
                                        </select>
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-18">
                                        <span class="label-input100">Age</span>
                                        <input class="input100" type="date" id="age" name="age" placeholder="Age"
                                            required>
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-18"
                                        data-validate="Phone Number is required">
                                        <span class="label-input100">Phone Number</span>
                                        <input class="input100" type="tel" name="mobileNumber"
                                            placeholder="Phone Number (Optional)">
                                        <span class="focus-input100"></span>
                                    </div>

                                    <input type="hidden" name="orderRandomKey" value="<?php echo isset($orderRandomKey) ? $orderRandomKey : ''; ?>">

                                        <button style="display: none;" id="pay" class="btn btn-danger btn-lg btn-block mt-2">
                                            PAY
                                        </button>
 
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="checkout-modal-sum">
                    <h4 class='mb-0 total'>TOTAL:
                        <span class='ml-2 color-secondary font-weight-bold totalBasket'>
                            <?php echo number_format($total, 2, '.', ''); ?>
                        </span>€
                    </h4>
                </div>
                <div>
                    <a href="javascript:;" onclick="payFormSubmit()" class="btn btn-secondary bg-secondary">Go to Pay</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<footer class="footer bg-light-gray mt-2">
    <div class="container text-center">
        <div class="row footer__row">
            <div class="col-12 col-md-6 text-center">
                &#169 TIQS <?php echo date('Y'); ?>. All rights reserved
                <br>
                Powered by <a style="font-size: 100%;" href="https://tiqs.com">tiqs.com<a>
            </div>
        </div>

    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<?php include_once FCPATH . 'application/views/includes/customJs.php'; ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/bookingReservations.js"></script>


<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->


</body>

</html>