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
            <div class="modal-body sc">

                <?php $total = 0; ?>
                <div class="menu-list sc">
                    <div id="checkout-list" class="w-100">
                        <?php 
                        $ticketFee = 0;
                        if(isset($tickets) && count($tickets) > 0): 

                    foreach($tickets as $ticket): 
                        $total = $total + floatval($ticket['amount']); 
                        $ticketFee = $ticketFee + floatval($ticket['ticketFee']);
                        ?>
                        <input type="hidden" id="quantity_<?php echo $ticket['id']; ?>" name="quantity[]" value="0">
                        <input type="hidden" name="id[]" value="<?php echo $ticket['id']; ?>">
                        <input type="hidden" name="descript[]" value="<?php echo $ticket['descript']; ?>">
                        <input type="hidden" name="price[]" value="<?php echo $ticket['price']; ?>">
                        <div class="menu-list__item ticket_item ticket_<?php echo $ticket['id']; ?>">
                            <div class="menu-list__name">
                                <b class="menu-list__title"><?php echo $ticket['descriptionTitle']; ?></b>
                                <div>
                                    <p class="menu-list__ingredients descript_<?php echo $ticket['id']; ?>">
                                    <?php echo $ticket['eventName'];?> - <?php echo $ticket['descript']; ?></p>
                                </div>
                            </div>
                            <div class="menu-list__left-col ml-auto">
                                <div class="menu-list__price mx-auto">
                                    <b class="menu-list__price--discount mx-auto ticket_price"><?php echo $ticket['price']; ?>€</b>
                                </div>
                                <div class="quantity-section mx-auto mb-2">
                                    <button type="button" class="quantity-button"
                                        onclick="removeTicket('<?php echo $ticket['id']; ?>','<?php echo $ticket['price']; ?>', '<?php echo $ticket['ticketFee']; ?>', 'totalBasket')">-</button>
                                    <input type="text" min="1"
                                        value="<?php echo $ticket['quantity']; ?>" placeholder="0"
                                        data-groupid="<?php echo $ticket['ticketGroupId']; ?>"
                                        onfocus="clearTotal(this, '<?php echo $ticket['price']; ?>', 'totalBasket')"
                                        onblur="ticketQuantity(this,'<?php echo $ticket['id']; ?>', '<?php echo $ticket['price']; ?>', '<?php echo $ticket['ticketFee']; ?>', 'totalBasket')"
                                        onchange="ticketQuantity(this,'<?php echo $ticket['id']; ?>', '<?php echo $ticket['price']; ?>', '<?php echo $ticket['ticketFee']; ?>', 'totalBasket')"
                                        oninput="absVal(this);" placeholder="0" disabled class="quantity-input ticketQuantityValue_<?php echo $ticket['id']; ?>">
                                    <button type="button" class="quantity-button"
                                        onclick="addTicket('<?php echo $ticket['id']; ?>', '50', '<?php echo $ticket['price']; ?>', '<?php echo $ticket['ticketFee']; ?>', 'totalBasket', '<?php echo $ticket['bundleMax']; ?>')">+</button>
                                </div>
                                <b class="menu-list__type mx-auto">
                                    <button
                                        onclick="deleteTicket('<?php echo $ticket['id']; ?>','<?php echo $ticket['price']; ?>', '<?php echo $ticket['ticketFee']; ?>')"
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
                    <div id="ticketFeeRow" <?php if(isset($ticketFee) && $ticketFee == 0) {?>style="display: none;"<?php } ?> class="menu-list__item">
                        <div class="menu-list__name mr-auto">
                            <div>
                                <p class="menu-list__ingredients font-weight-bold">TICKETFEE</p>
                            </div>
                        </div>
                        <div class="menu-list__price ml-auto">
                            <b id="ticketFeeAmount" class="menu-list__price--discount mx-auto ticket_price"><?php echo isset($ticketFee) ?  number_format($ticketFee, 2, '.', '') .'€' : '0.00€'; ?></b>
                            <input type="hidden" id="ticketFee" value="<?php echo isset($ticketFee) ? $ticketFee : 0; ?>">
                        </div>
                    </div>
                    <div id="payForm" style="display: none; margin-bottom: 350px;"  class="limiter sc">
                        <div style="background: #fff !important;" class="container-login100">
                            <div style="background: #fff !important;" class="wrap-login100">
                                <div style="background: #fff !important;">
                                    
                                </div>
                                <form class="login100-form validate-form"
                                    action="<?php echo base_url(); ?>events/payment_proceed" method="POST">
                                    <div class="wrap-input100 validate-input m-b-26">
                                        <span class="label-input100">Full Name</span>
                                        <input class="input100" type="text" id="fullName" name="name"
                                            placeholder="Full Name" required>
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                                        <span class="label-input100">Email</span>
                                        <input class="input100 emails" type="email" id="email" name="email"
                                            placeholder="Email Address" required>
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                                        <span class="label-input100">Repeat Email</span>
                                        <input class="input100 emails" type="email" id="repeatEmail" name="repeatEmail"
                                            placeholder="Retype Email Address" required>
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div id="emailMatchError" class="m-b-26 d-none">
                                        <span style="min-width: 10px;" class="label-input100"></span>
                                        <p class="input100 pt-3 pb-2 text-danger">Email and repeat email doesn't match!</p>
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-18 wideField d-none"
                                        data-validate="Address is required">
                                        <span class="label-input100">Address</span>
                                        <input class="field input100" type="text" id="address"
                                             name="address" placeholder="Address">
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-18 wideField d-none"
                                        data-validate="Zip Code is required">
                                        <span class="label-input100">Zip Code</span>
                                        <input class="field input100" type="text" id="zipcode"
                                             name="zipcode" placeholder="Zip Code">
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-18 wideField"
                                        data-validate="City is required">
                                        <span class="label-input100">City</span>
                                        <input class="field input100" type="text" id="city"
                                             name="city" placeholder="City" required>
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-18 wideField d-none"
                                        data-validate="Country is required">
                                        <span class="label-input100">Country</span>
                                        <input class="field input100" type="text" id="country"
                                             name="country" placeholder="Country">
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
                                    <div class="wrap-input100 validate-input m-b-18 d-none">
                                        <span class="label-input100">Age</span>
                                        <input class="input100" type="date" id="age" name="age" placeholder="Age">
                                        <span class="focus-input100"></span>
                                    </div>
                                    <div id="mobileNumber" class="wrap-input100 validate-input m-b-18 d-none"
                                        data-validate="Phone Number is required">
                                        <span class="label-input100">Phone Number</span>
                                        <input class="input100" type="tel" id="phoneNumber" name="mobileNumber"
                                            placeholder="Phone Number">
                                        <span class="focus-input100"></span>
                                    </div>
                                    <?php //var_dump($inputs);  ?>
                                    <?php if(isset($inputs) && !empty($inputs)): ?>

                                    <?php foreach($inputs as $input): 
                                            $input_name = $input['fieldName'];
                                        
                                    ?>
                                    
                                    <div id="<?php echo $input['fieldLabel']; ?>" class="wrap-input100 validate-input m-b-18">
                                        <span class="label-input100"><?php echo ucwords($input['fieldLabel']); ?></span>
                                        <input class="input100 additionalInfo" type="<?php echo $input['fieldType']; ?>" name="additionalInfo[<?php echo $input_name; ?>]"
                                            placeholder="<?php echo ucwords($input['fieldLabel']); ?>" 
                                            data-required="<?php echo $input['requiredField']; ?>"
                                            <?php if($input['requiredField'] == 1){ ?>
                                                required
                                            <?php } ?>
                                            >
                                        <span class="focus-input100"></span>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                    <input type="hidden" name="orderRandomKey" value="<?php echo isset($orderRandomKey) ? $orderRandomKey : ''; ?>">
                                    <?php if(isset($shopsettings->termsofuseFile) && $shopsettings->termsofuseFile != ''): ?>
                                    <div class="form-group mt-4">
                                        <div style="font-size: 14px" class="pretty p-icon p-smooth">
                                            <input type="checkbox" name="termsofuse" id="termsofuse" required/>
                                           <div class="state success-check">
                                                <i class="icon fa fa-check"></i>
                                                <label> I agree to these <a href="<?php echo base_url(); ?>events/shop/termsofuse?order=<?php echo isset($orderRandomKey) ? $orderRandomKey : ''; ?>" target="_blank">Terms and Conditions</a>.</label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="form-group mt-4">
                                        <div style="font-size: 14px" class="pretty p-icon p-smooth">
                                            <input type="checkbox" name="termsofuse" id="termsofuse" required/>
                                           <div class="state success-check">
                                                <i class="icon fa fa-check"></i>
                                                <label> I agree to these <a href="<?php echo base_url(); ?>legal" target="_blank">Terms and Conditions</a>.</label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                        <button type="submit" style="display: none;" id="pay" class="btn btn-danger btn-lg btn-block mt-2">
                                            PAY
                                        </button>
 
                                </form>
                            </div>
                        </div>
                    </div>
                    <div style="height: 100px" class="w-100">
                    </div>
                </div>
            </div>
            <div class="modal-footer checkout-modal-footer">
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
                &#169; TIQS <?php echo date('Y'); ?>. All rights reserved
                <br>
                Powered by <a style="font-size: 100%;" href="https://tiqs.com">tiqs.com</a>
            </div>
        </div>

    </div>
</footer>
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"
></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/utility.js"></script>
<!-- <script src="<?php #echo $this->baseUrl; ?>assets/home/js/ajax.js"></script> -->
<script src="<?php echo $this->baseUrl; ?>assets/js/iziToast.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/eventShop.js"></script>

<?php include_once FCPATH . 'application/views/includes/customJs.php'; ?>
<?php include_once FCPATH . 'application/views/includes/alertifySessionMessage.php'; ?>

<?php
    // we need this check because footer is used on pay page where $shopsettings is not set
    if (!empty($shopsettings)) {
        ?>
        <script>
            (function(){
                var shopsettings = '<?php echo json_encode($shopsettings); ?>';
                shopsettings = JSON.parse(shopsettings);
                if(typeof shopsettings === 'object' && shopsettings !== null){
                    if(shopsettings.showAddress == "1") { $('#address').closest('div').removeClass('d-none'); $('#address').prop('required', true); }
                    if(shopsettings.showCountry == "1") { $('#country').closest('div').removeClass('d-none'); $('#country').prop('required', true); }
                    if(shopsettings.showZipcode == "1") { $('#zipcode').closest('div').removeClass('d-none'); $('#zipcode').prop('required', true); }
                    if(shopsettings.showMobileNumber == "1") { $('#phoneNumber').closest('div').removeClass('d-none'); $('#phoneNumber').prop('required', true); }
                    if(shopsettings.showAge == "1") { $('#age').closest('div').removeClass('d-none'); $('#age').prop('required', true); }
                    if(shopsettings.labels == "0") { $('.label-input100').hide(); $('.login100-form').attr('style','padding: 10px 1px 1px 0px !important;'); }
                }
                $('.additionalInfo').prop('required', false);
                
            }());
        </script>
        <?php
    }
?>

<script>
$(document).ready(function() {
    var errorMessages = '<?php echo isset($errorMessages) ? json_encode($errorMessages) : ''; ?>';
    errorMessages = (errorMessages == '') ? '' : JSON.parse(errorMessages);

    if (errorMessages != '') {
        for (let index in errorMessages) {

            iziToast.error({
               title: errorMessages[index ],
               message: '',
               position: 'topRight'
            }); 
        }
    }


});
</script>

</body>

</html>