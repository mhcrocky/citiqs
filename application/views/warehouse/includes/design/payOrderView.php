<fieldset id="payOrderView" class="hideFieldsets">
    <legend>Pay order view</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Header background color:
            <input
                type="color"
                class="form-control"
                name="payOrder[id][payHeader][background-color]"
                data-css-selector="id"
                data-css-selector-value="payHeader"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['id']['payHeader']['background-color']) ) { ?>
                value = "<?php echo $design['payOrder']['id']['payHeader']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>


    <div class="form-group col-sm-12">
        <label style="display:block;">
            Choose pament method background color:
            <input
                type="color"
                class="form-control"
                name="payOrder[id][choosePaymentMethod][background-color]"
                data-css-selector="id"
                data-css-selector-value="choosePaymentMethod"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['id']['choosePaymentMethod']['background-color']) ) { ?>
                value = "<?php echo $design['payOrder']['id']['choosePaymentMethod']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Choose payment method font color:
            <input
                type="color"
                class="form-control"
                name="payOrder[id][choosePaymentMethod][color]"
                data-css-selector="id"
                data-css-selector-value="choosePaymentMethod"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['id']['choosePaymentMethod']['color']) ) { ?>
                value = "<?php echo $design['payOrder']['id']['choosePaymentMethod']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Payment methods background color:
            <input
                type="color"
                class="form-control"
                name="payOrder[id][paymentContainer][background-color]"
                data-css-selector="id"
                data-css-selector-value="paymentContainer"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['id']['paymentContainer']['background-color']) ) { ?>
                value = "<?php echo $design['payOrder']['id']['paymentContainer']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Footer background color:
            <input
                type="color"
                class="form-control"
                name="payOrder[id][payFooter][background-color]"
                data-css-selector="id"
                data-css-selector-value="payFooter"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['id']['payFooter']['background-color']) ) { ?>
                value = "<?php echo $design['payOrder']['id']['payFooter']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Footer font color:
            <input
                type="color"
                class="form-control"
                name="payOrder[id][backLink][color]"
                data-css-selector="id"
                data-css-selector-value="backLink"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['id']['backLink']['color']) ) { ?>
                value = "<?php echo $design['payOrder']['id']['backLink']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
</fieldset>
