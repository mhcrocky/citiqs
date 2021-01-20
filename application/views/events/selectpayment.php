<div style="text-align: center;" id="header-img" class="w-100" style="text-align:center">


    <div class="form-group has-feedback">
        <img class="img-w-150" src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs"
            width="250" height="auto" />
    </div>

</div>


<div id="selectPayment" class="container-fluid selectPayment pr-5 pl-5 mx-auto">
    <h1 style="color: #F1921A !important;" class="white text-center yellow">Select Payment</h1>
    <div class="row mx-auto">

        <div class="col-md-8 col-sm-12 serviceBox blue mx-auto">
            <div class="half-col  mb-4">
                <img class="img-w-150" src="<?php echo base_url(); ?>assets/home/imgs/extra/ideal.png" alt="iDEAL">
                <h3 class="title"><a id="iDeal" href="#iDeal">iDEAL</a></h3>
            </div>
            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url(); ?>assets/home/imgs/extra/bancontact.png"
                    alt="bancontact">
                <h3 class="title">Bancontact</h3>
            </div>
            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url(); ?>assets/home/imgs/extra/creditcard.png"
                    alt="Creditcard">
                <h3 class="title">Credit Card</h3>
            </div>
            <div class="half-col  mb-4">
                <img class="img-w-150" src="<?php echo base_url() . 'assets/images/waiter.png'; ?>"
                    alt="Pay at waiter" />
                <h3 class="title">Pay at waiter</h3>
            </div>
            <div class="half-col  mb-4">
                <img class="img-w-89" src="<?php echo base_url() . 'assets/home/images/voucher.png'; ?>" alt="voucher">
                <h3 class="title">gebruik Voucher</h3>
            </div>
            <div class="half-col  mb-4">
                
            </div>

        </div>




    </div>
</div>
<div id="iDeal" class="container-fluid iDeal hidden mx-auto">
    <h1 style="color: #F1921A !important;" class="white text-center">Select Payment</h1>
    <div class="row mx-auto">
        <div class="col-md-8 col-sm-12 serviceBox blue mb-4 mx-auto">
            <div class="half-col mb-4">

                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/abn_amro.png') ?>" alt="ABN AMRO">

                <h3 class="title">ABN AMRO</h3>
            </div>

            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/asn_bank.png') ?>" alt="ASN Bank">
                <h3 class="title">ASN Bank</h3>
            </div>


            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/bunq.png') ?>" alt="Bunq">
                <h3 class="title">Bunq</h3>
            </div>

            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/handelsbanken.png') ?>"
                    alt="Handelsbanken">
                <h3 class="title">Handelsbanken</h3>
            </div>

            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/ing.png') ?>" alt="ING">
                <h3 class="title">ING</h3>
            </div>

            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/knab(1).png') ?>" alt="Knab">
                <h3 class="title">Knab</h3>
            </div>

            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/moneyou.png') ?>" alt="Moneyou">
                <h3 class="title">Moneyou</h3>
            </div>

            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/rabobank.png') ?>" alt="Rabobank">
                <h3 class="title">Rabobank</h3>
            </div>

            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/regiobank.png') ?>" alt="RegioBank">
                <h3 class="title">RegioBank</h3>
            </div>

            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/sns_bank.png') ?>" alt="SNS Bank">
                <h3 class="title">SNS Bank</h3>
            </div>


            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/triodos_bank.png') ?>"
                    alt="Triodos Bank">
                <h3 class="title">Triodos Bank</h3>
            </div>

            <div class="half-col mb-4">
                <img class="img-w-150" src="<?php echo base_url('assets/imgs/extra/van_lanschot.png') ?>"
                    alt="van Lanschot">
                <h3 class="title">van Lanschot</h3>
            </div>
        </div>

        <div class="w-100 text-center font-weight-bold mb-5 p-3">
            <h3 class="title">
                <a class="text-primary" id="backPayment" href="#selectPayment">Back to payment method</a>
            </h3>
        </div>

    </div>
</div>

<script>
$("#iDeal").on("click", function() {
    $(".iDeal").removeClass("hidden");
    $(".selectPayment").addClass("hidden");
});
$("#backPayment").on("click", function() {
    $(".iDeal").addClass("hidden");
    $(".selectPayment").removeClass("hidden");
});
</script>