<fieldset id="payOrderView" class="hideFieldsets">
    <legend>Pay order view</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Page background color:
            <input
                data-jscolor=""
                class="form-control"
                name="payOrder[class][payOrderBackgroundColor][background-color]"
                data-css-selector="class"
                data-css-selector-value="payOrderBackgroundColor"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['payOrderBackgroundColor']['background-color']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['payOrderBackgroundColor']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>    
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Header background color:
            <input
                data-jscolor=""
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
                data-jscolor=""
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
                data-jscolor=""
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
                data-jscolor=""
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
            Voucher respone background color:
            <input
                data-jscolor=""
                class="form-control"
                name="payOrder[class][voucher][background-color]"
                data-css-selector="class"
                data-css-selector-value="voucher"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['voucher']['background-color']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['voucher']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Voucher respone font color:
            <input
                data-jscolor=""
                class="form-control"
                name="payOrder[class][voucher][color]"
                data-css-selector="class"
                data-css-selector-value="voucher"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['voucher']['color']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['voucher']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Footer background color:
            <input
                data-jscolor=""
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
                data-jscolor=""
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
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Pre paid, post paid vocuher popup background color:
            <input
                data-jscolor=""
                class="form-control"
                name="payOrder[class][modalPayOrder][background-color]"
                data-css-selector="class"
                data-css-selector-value="modalPayOrder"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['modalPayOrder']['background-color']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['modalPayOrder']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Pre paid, post paid vocuher popup button background color:
            <input
                data-jscolor=""
                class="form-control"
                name="payOrder[class][modalPayOrderButton][background-color]"
                data-css-selector="class"
                data-css-selector-value="modalPayOrderButton"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['modalPayOrderButton']['background-color']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['modalPayOrderButton']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Pre paid, post paid vocuher popup button font color:
            <input
                data-jscolor=""
                class="form-control"
                name="payOrder[class][modalPayOrderButton][color]"
                data-css-selector="class"
                data-css-selector-value="modalPayOrderButton"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['modalPayOrderButton']['color']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['modalPayOrderButton']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Input fields label font color:
            <input
                data-jscolor=""
                class="form-control"
                name="payOrder[class][payOrderInputFieldsLabel][color]"
                data-css-selector="class"
                data-css-selector-value="payOrderInputFieldsLabel"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['payOrderInputFieldsLabel']['color']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['payOrderInputFieldsLabel']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Input fields background color:
            <input
                data-jscolor=""
                class="form-control"
                name="payOrder[class][payOrderInputFields][background-color]"
                data-css-selector="class"
                data-css-selector-value="payOrderInputFields"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['payOrderInputFields']['background-color']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['payOrderInputFields']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Input fields font color:
            <input
                data-jscolor=""
                class="form-control"
                name="payOrder[class][payOrderInputFields][color]"
                data-css-selector="class"
                data-css-selector-value="payOrderInputFields"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['payOrderInputFields']['color']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['payOrderInputFields']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Input fields border color:
            <input
                data-jscolor=""
                class="form-control"
                name="payOrder[class][payOrderInputFields][border-color]"
                data-css-selector="class"
                data-css-selector-value="payOrderInputFields"
                data-css-property="border-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['payOrderInputFields']['border-color']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['payOrderInputFields']['border-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
</fieldset>
