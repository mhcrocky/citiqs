<?php 
$idealPaymentFee = $idealPayment;
$bancontactPaymentFee = $bancontactPayment;
$creditCardPaymentFee = $creditCardPayment;
$voucherPaymentFee = $voucher;
$myBankPaymentFee = $myBank;
$payconiqPaymentFee = $payconiqPayment;
$giroPaymentFee = $giroPayment;
$pinMachinePaymentFee = $pinMachine;
?>
<div id="selectPayment" class="container-fluid selectPayment pr-5 pl-5 mx-auto mb-5">
    <h1 style="color: #F1921A !important; font-size: 24px;" class="white text-center yellow">Select Payment</h1>
    <div class="row mx-auto">

        <div class="col-md-8 col-sm-12 serviceBox blue mx-auto">
        <?php if(in_array('ideal payment', $activePayments)): ?>
            <div class="half-col  mb-4">
                <img class="img-w-150" src="<?php echo base_url(); ?>assets/home/imgs/extra/ideal.png" alt="iDEAL">
                <p style="paymentFee bg-primary"><?php echo $idealPaymentFee; ?></p>
                <h3 class="title">
                <a id="iDeal" data-paymentFee="<?php echo $idealPaymentFee; ?>" class="text-primary" href="#iDeal" onclick="paymentMethodRedirect(this)">iDEAL</a></h3>
            </div>
        <?php endif; ?>
        
        <?php if(in_array('bancontact payment', $activePayments)): ?>
            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url(); ?>assets/home/imgs/extra/bancontact.png"
                    alt="bancontact">
                <p style="paymentFee bg-primary"><?php echo $bancontactPaymentFee; ?></p>
                <h3 class="title"><a id="bancontact" class="text-primary pay_method" data-paymentFee="<?php echo $bancontactPaymentFee; ?>"
                        href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $bancontactPaymentType; ?>" onclick="paymentMethodRedirect(this);return false;">Bancontact</a></h3>
            </div>
        <?php endif; ?>

        <?php if(in_array('credit card payment', $activePayments)): ?>
            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url(); ?>assets/home/imgs/extra/creditcard.png"
                    alt="Creditcard">
                <p style="paymentFee bg-primary"><?php echo $creditCardPaymentFee; ?></p>
                <h3 class="title">
                <a data-paymentFee="<?php echo $creditCardPaymentFee; ?>" class="text-primary pay_method" href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $creditCardPaymentType; ?>" onclick="paymentMethodRedirect(this);return false;">Credit Card</a></h3>
            </div>
        <?php endif; ?>
        

            <div class="half-col  mb-4">
                <img class="img-w-150" src="<?php echo base_url() . 'assets/images/waiter.png'; ?>"
                    alt="Pay at waiter" />
                <p style="paymentFee bg-primary">&nbsp</p>
                <h3 class="title"><a id="payAtWaiter" class="text-primary" href="#">Pay at waiter</a></h3>
            </div>


        <?php if(in_array('voucher', $activePayments)): ?>
            <div class="half-col  mb-4">
                <img class="img-w-89" src="<?php echo base_url() . 'assets/home/images/voucher.png'; ?>" alt="voucher">
                <p style="paymentFee bg-primary"><?php echo $voucherPaymentFee; ?></p>
                <h3 class="title"><a id="voucher" data-paymentFee="<?php echo $voucherPaymentFee; ?>" class="text-primary" href="#">gebruik Voucher</a></h3>
            </div>
        <?php endif; ?>

        <?php if(in_array('my bank', $activePayments)): ?>
            <div class="half-col  mb-4">
                <img class="img-w-150" style="max-width: 110px;" src="https://static.pay.nl/payment_profiles/100x100/1588.png"
                    alt="My Bank" />
                <p style="paymentFee bg-primary"><?php echo $myBankPaymentFee; ?></p>
                <h3 class="title"><a id="mybank" data-paymentFee="<?php echo $myBankPaymentFee ?>" class="text-primary pay_method" href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $myBankPaymentType; ?>" onclick="paymentMethodRedirect(this);return false;">My Bank</a></h3>
            </div>
        <?php endif; ?>

        <?php if(in_array('payconiq payment', $activePayments)): ?>
            <div class="half-col  mb-4">
                <img class="img-w-89" style="max-width: 85px;" src="https://tiqs.com/alfred/assets/home/imgs/extra/payconiq.png"
                    alt="Payconiq" />
                <p style="paymentFee bg-primary"><?php echo $payconiqPaymentFee; ?></p>
                <h3 class="title"><a id="payconiq" data-paymentFee="<?php echo $payconiqPaymentFee ?>" class="text-primary pay_method" href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $payconiqPaymentType; ?>" onclick="paymentMethodRedirect(this);return false;">Payconiq</a></h3>
            </div>
        <?php endif; ?>

        <?php if(in_array('giro payment', $activePayments)): ?>
            <div class="half-col  mb-4">
                <img class="img-w-150" style="max-width: 100px;" src="<?php echo base_url(); ?>assets/home/imgs/extra/giropay(1).png"
                    alt="Giropay" />
                <p style="paymentFee bg-primary"><?php echo $giroPaymentFee; ?></p>
                <h3 class="title"><a id="giropay" data-paymentFee="<?php echo $giroPaymentFee; ?>" class="text-primary pay_method" href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $giroPaymentType; ?>" onclick="paymentMethodRedirect(this);return false;">Giropay</a></h3>
            </div>
        <?php endif; ?>

        <?php if(in_array('pin machine', $activePayments)): ?>
            <div class="half-col  mb-4">
                <img class="img-w-150" style="max-width: 100px;"  src="<?php echo base_url(); ?>assets/home/images/pinmachine.png"
                    alt="Pin machine" />
                <p style="paymentFee bg-primary"><?php echo $pinMachinePaymentFee; ?></p>
                <h3 class="title"><a id="pinmachine" data-paymentFee="<?php echo $pinMachinePaymentFee ?>" class="text-primary pay_method" href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $pinMachinePaymentType; ?>" onclick="paymentMethodRedirect(this);return false;">Pin machine</a></h3>
            </div>
        <?php endif; ?>
            <div class="half-col  mb-4">
                
            </div>

        </div>




    </div>
</div>

<?php if(in_array('ideal payment', $activePayments)): ?>
<div id="iDeal" class="container-fluid iDeal hidden mx-auto">
    <h1 style="color: #F1921A !important;" class="white text-center yellow">Select Payment</h1>
    <div class="row mx-auto">
        <div class="col-md-8 col-sm-12 serviceBox blue mb-4 mx-auto">
        
            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/1" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/abn_amro.png') ?>"
                        alt="ABN AMRO">

                    <h3 class="title">ABN AMRO</h3>
                </a>
            </div>

            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/8" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/asn_bank.png') ?>"
                        alt="ASN Bank">
                    <h3 class="title">ASN Bank</h3>
                </a>
            </div>


            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/5080" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/bunq.png') ?>" alt="Bunq">
                    <h3 class="title">Bunq</h3>
                </a>
            </div>

            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/5082" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/handelsbanken.png') ?>"
                        alt="Handelsbanken">
                    <h3 class="title">Handelsbanken</h3>
                </a>
            </div>

            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/4" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/ing.png') ?>" alt="ING">
                    <h3 class="title">ING</h3>
                </a>
            </div>

            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/12" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/knab(1).png') ?>" alt="Knab">
                    <h3 class="title">Knab</h3>
                </a>
            </div>

            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/5081" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/moneyou.png') ?>" alt="Moneyou">
                    <h3 class="title">Moneyou</h3>
                </a>
            </div>

            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/2" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/rabobank.png') ?>"
                        alt="Rabobank">
                    <h3 class="title">Rabobank</h3>
                </a>
            </div>

            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/9" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/regiobank.png') ?>"
                        alt="RegioBank">
                    <h3 class="title">RegioBank</h3>
                </a>
            </div>

            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/5" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/sns_bank.png') ?>"
                        alt="SNS Bank">
                    <h3 class="title">SNS Bank</h3>
                </a>
            </div>


            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/10" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/triodos_bank.png') ?>"
                        alt="Triodos Bank">
                    <h3 class="title">Triodos Bank</h3>
                </a>
            </div>

            <div class="half-col mb-4">
                <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/11" class="pay_method">
                    <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/van_lanschot.png') ?>"
                        alt="van Lanschot">
                    <h3 class="title">van Lanschot</h3>
                </a>
            </div>
        </div>

        <div class="w-100 text-center font-weight-bold mb-5 p-3">
            <h3 style="font-size: 20px;" class="title">
                <a class="text-primary" id="backPayment" data-paymentFee="<?php echo $idealPaymentFee; ?>" href="#selectPayment" onclick="backToPaymentMethods(this)">Back to payment methods</a>
            </h3>
        </div>

    </div>
</div>
<?php endif; ?>

<div class="limiter hidden creditCard mt-5">
    <div class="container-login100">
        <div style="background: #fff !important;" class="wrap-login100">
            <div class="w-100 card-wrapper mt-5 items-align-center"></div>
            <form class="login100-form validate-form" action="#" method="POST">
                <div class="wrap-input100 validate-input m-b-26">
                    <span class="label-input100">Card number</span>
                    <input class="input100" placeholder="Card number" type="tel" name="number">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-18" data-validate="Address is required">
                    <span class="label-input100">Nameholder</span>
                    <input class="input100" placeholder="Full name" type="text" name="name">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-18" data-validate="Phone Number is required">
                    <span class="label-input100">Expiry Date</span>
                    <input class="input100" placeholder="MM/YY" type="tel" name="expiry">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-18" data-validate="Phone Number is required">
                    <span class="label-input100">CVC</span>
                    <input class="input100" placeholder="CVC" type="number" name="cvc">
                    <span class="focus-input100"></span>
                </div>

                <!--
                <div class="flex-sb-m w-full p-b-30">
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                        <label class="label-checkbox100" for="ckb1">
                            
                        </label>
                    </div>
                    <div>
                        <a href="#" class="txt1">
                            
                        </a>
                    </div>
                </div>
                -->

                <div style="width: 100%;" class="w-100 mr-right text-right mt-5">
                    <button id="pay" class="btn btn-danger btn-lg btn-block mt-2">
                        PAY
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="w-100 text-center font-weight-bold mb-5 p-3">
        <h3 style="font-size: 20px;" class="title">
            <a class="text-primary" id="backPaymentCC" href="#selectPayment">Back to payment method</a>
        </h3>
    </div>
</div>


<script>
(function(){
    if(window.location !== window.parent.location ){
        $('.pay_method').attr('target', '_blank');
    }
    $('#body').show();
    $('.header__checkout').prop('disabled', true);
}());

function paymentMethodRedirect(el){
    var amount = $('.totalBasket').text();
    var paymentFee = $(el).attr('data-paymentFee');
    paymentFee = paymentFee.replace( /^\D+/g, '');
    paymentFee = $.isNumeric(paymentFee) ? paymentFee : 0;
    paymentFee = parseFloat(paymentFee);

    var total = parseFloat(amount) + paymentFee;
    $('.totalBasket').text(total.toFixed(2));

    setTimeout(() => {
        var url = $(el).attr('href');
        window.location.href = url;
    }, 1500);
    
}

function backToPaymentMethods(el){
    var amount = $('.totalBasket').text();
    var paymentFee = $(el).attr('data-paymentFee');
    paymentFee = parseFloat(paymentFee);

    var total = parseFloat(amount) - paymentFee;
    $('.totalBasket').text(total.toFixed(2));
    
}


$("#iDeal").on("click", function() {
    $(".iDeal").removeClass("hidden");
    $(".selectPayment").addClass("hidden");
});
$("#backPayment").on("click", function() {
    $(".iDeal").addClass("hidden");
    $(".selectPayment").removeClass("hidden");
});

$("#creditCard").on("click", function() {
    $(".creditCard").removeClass("hidden");
    $(".selectPayment").addClass("hidden");
});
$("#backPaymentCC").on("click", function() {
    $(".creditCard").addClass("hidden");
    $(".selectPayment").removeClass("hidden");
});


</script>