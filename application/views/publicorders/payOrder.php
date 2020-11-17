<div id="wrapper" class="payOrderBackgroundColor">
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
</div>



<script>
    var payOrderGlobals = (function(){
        let globals = {
            'orderDataGetKey' : '<?php echo $orderDataGetKey; ?>'
        }
        Object.freeze(globals);
        return globals;
    }());
</script>
