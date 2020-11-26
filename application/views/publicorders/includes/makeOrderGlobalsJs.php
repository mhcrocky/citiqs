<script>
    'use_strict';
    var makeOrderGlobals = (function(){
        let globals = {
            'checkoutModal' : 'checkout-modal',
            'modalCheckoutList' : 'modal__checkout__list',
            'checkProduct' : 'checkProduct',
            'checkAddons' : 'checkAddons',
            'shoppingCartList' : 'shopping-cart__list',
            'orderedProducts' : 'orderedProducts',
            'spotId' : '<?php echo $spotId; ?>',
            'vendorId': '<?php echo $vendor['vendorId']; ?>',
            'orderDataRandomKey' : '<?php echo $orderDataRandomKey; ?>',
            'orderDataGetKey' : '<?php echo $orderDataGetKey; ?>',
            'logoImageId' : 'vendorLogo',
            'activeClass' : 'pos_categories__single-item--active', // POS
            'posMakeOrderId': 'posMakeOrderId',  // POS
            'spanQuantityIdPrefix' : 'orderQuantityValue_',
            'checkoutContinueButton' : 'checkoutContinue'
        }

        <?php if (!empty($returnCategorySlide)) { ?>
            globals['categorySlide'] = '<?php echo $returnCategorySlide; ?>';
        <?php } ?>
        <?php if (!empty($openCategory)) { ?>
            globals['openCategory'] = '<?php echo $openCategory; ?>';
        <?php } ?>

        Object.freeze(globals);
        return globals;
    }());
</script>