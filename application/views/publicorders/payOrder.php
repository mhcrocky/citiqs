<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<main id="wrapper" class="payOrderBackgroundColor designBackgroundImage">
    <div id="content" class="payOrderBackgroundColor">
        <div class="container payOrderBackgroundColor" id="shopping-cart">
            <div class="container payOrderBackgroundColor" id="page-wrapper">
                <div class="row">
                    <?php
                        include_once FCPATH . 'application/views/publicorders/includes/pay/payMethods.php';
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
<script>    
    const payOrderGlobals = (function(){
        let globals = {
            'orderDataGetKey' : '<?php echo $orderDataGetKey; ?>',
            'orderRandomKey' : '<?php echo $orderRandomKey; ?>'
        }

        <?php if (in_array($voucherPayment, $paymentMethodsKey)) { ?>
            globals.vocuherClass = 'voucherClass'
        <?php } ?>
        Object.freeze(globals);
        return globals;
    }());
</script>
