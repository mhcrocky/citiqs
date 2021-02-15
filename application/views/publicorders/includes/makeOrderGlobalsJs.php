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
            'orderDataGetKey' : '<?php echo $orderDataGetKey; ?>',
            'logoImageId' : 'vendorLogo',
            'activeClass' : 'pos_categories__single-item--active', // POS
            'posMakeOrderId': 'posMakeOrderId',  // POS
            'posResponse': 'posResponse',  // POS            
            'spanQuantityIdPrefix' : 'orderQuantityValue_',
            'checkoutContinueButton' : 'checkoutContinue',
        }

        <?php if (!empty($returnCategorySlide)) { ?>
            globals['categorySlide'] = '<?php echo $returnCategorySlide; ?>';
        <?php } ?>
        <?php if (!empty($openCategory)) { ?>
            globals['openCategory'] = '<?php echo $openCategory; ?>';
        <?php } ?>
        <?php if (!empty($buyerRoleId)) { ?>
            globals['buyerRoleId'] = '<?php echo $buyerRoleId; ?>';
        <?php } ?>
        <?php if (!empty($salesagent)) { ?>
            globals['salesagent'] = '<?php echo $salesagent; ?>';
        <?php } ?>
        <?php if (!empty($buyershorturl)) { ?>
            globals['buyershorturl'] = '<?php echo $buyershorturl; ?>';
        <?php } ?>
        <?php if (!empty($vendor['oneSignalId'])) { ?>
            globals['oneSignalId'] = '<?php echo $vendor['oneSignalId']; ?>';
        <?php } else { ?>
            globals['oneSignalId'] = '';
        <?php } ?>
        <?php if (!empty($orderDataRandomKey)) { ?>
            globals['orderDataRandomKey'] = '<?php echo $orderDataRandomKey; ?>';
        <?php } else { ?>
            globals['orderDataRandomKey'] = '';
        <?php } ?>

        return globals;
    }());
</script>