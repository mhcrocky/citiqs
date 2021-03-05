<fieldset id="payOrderView" class="hideFieldsets">
    <legend>Pay order view</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Page background color:
            <input
                data-jscolor=""
                style="border-radius: 50px;"
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
                style="border-radius: 50px;"
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
                style="border-radius: 50px;"
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
                style="border-radius: 50px;"
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
                style="border-radius: 50px;"
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
            Payment methods on hover background color:
            <input
                data-jscolor=""
                style="border-radius: 50px;"
                class="form-control"
                name="paymentContainer[hover]"
                onfocus="hoverStyle(this)"
                oninput="hoverStyle(this)"
                <?php if ( isset($design['paymentContainer']['hover']) ) { ?>
                value = "<?php echo $design['paymentContainer']['hover']?>"
                data-value="1"
                <?php } else { ?>
                value="#f1f1f1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Payment methods on hover font color:
            <input
                data-jscolor=""
                style="border-radius: 50px;"
                class="form-control"
                name="paymentContainer[color]"
                onfocus="hoverStyle(this, true)"
                oninput="hoverStyle(this, true)"
                <?php if ( isset($design['paymentContainer']['color']) ) { ?>
                value = "<?php echo $design['paymentContainer']['color']?>"
                data-value="1"
                <?php } else { ?>
                value="0px"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Payment methods on hover border radius:
            <input
                type="text"
                style="border-radius: 50px;"
                class="form-control"
                name="paymentContainer[border-radius]"
                onfocus="hoverStyle(this, false, true)"
                oninput="hoverStyle(this, false, true)"
                <?php if ( isset($design['paymentContainer']['border-radius']) ) { ?>
                value = "<?php echo $design['paymentContainer']['border-radius']?>"
                data-value="1"
                <?php } else { ?>
                value="0px"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Payment methods font color:
            <input
                data-jscolor=""
                style="border-radius: 50px;"
                class="form-control"
                name="payOrder[class][paymentMethodText][color]"
                data-css-selector="class"
                data-css-selector-value="paymentMethodText"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['paymentMethodText']['color']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['paymentMethodText']['color']?>"
                data-value="1"
                <?php } else { ?>
                value="#727780"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Payment methods font size:
            <input
                type="text"
                style="border-radius: 50px;"
                class="form-control"
                name="payOrder[class][paymentMethodText][font-size]"
                data-css-selector="class"
                data-css-selector-value="paymentMethodText"
                data-css-property="font-size"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['class']['paymentMethodText']['font-size']) ) { ?>
                value = "<?php echo $design['payOrder']['class']['paymentMethodText']['font-size']?>"
                data-value="1"
                <?php } else { ?>
                value="14px"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Voucher respone background color:
            <input
                data-jscolor=""
                style="border-radius: 50px;"
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
                style="border-radius: 50px;"
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
                style="border-radius: 50px;"
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
                style="border-radius: 50px;"
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
            Pre paid, post paid voucher popup background color:
            <input
                data-jscolor=""
                style="border-radius: 50px;"
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
            Pre paid, post paid voucher popup button background color:
            <input
                data-jscolor=""
                style="border-radius: 50px;"
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
            Pre paid, post paid voucher popup button font color:
            <input
                data-jscolor=""
                style="border-radius: 50px;"
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
                style="border-radius: 50px;"
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
                style="border-radius: 50px;"
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
                style="border-radius: 50px;"
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
                style="border-radius: 50px;"
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

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Back button background color:
            <input
                data-jscolor=""
                style="border-radius: 50px;"
                class="form-control"
                name="payOrder[id][backLink][background-color]"
                data-css-selector="id"
                data-css-selector-value="backLink"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['id']['backLink']['background-color']) ) { ?>
                value = "<?php echo $design['payOrder']['id']['backLink']['background-color']?>"
                data-value="1"
                <?php } else { ?>
                    value="rgba(255,255,255, 0)"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Back button color:
            <input
                data-jscolor=""
                style="border-radius: 50px;"
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
            Back button border radius:
            <input
                type="tex"
                style="border-radius: 50px;"
                class="form-control"
                name="payOrder[id][backLink][border-radius]"
                data-css-selector="id"
                data-css-selector-value="backLink"
                data-css-property="border-radius"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['payOrder']['id']['backLink']['border-radius']) ) { ?>
                value = "<?php echo $design['payOrder']['id']['backLink']['border-radius']?>"
                data-value="1"
                <?php } else { ?>
                    value="5px"
                <?php } ?>
            />
        </label>
    </div>

</fieldset>
<script>
function hoverStyle(el, text_color=false, radius=false){
    if(text_color){
       var color = $(el).val();
       $("#iframe").contents().find("head").append('<style>#area-container .payment-container a.paymentMethod:hover { color: '+color+' !important;}</style>');
       return ;
    }
    if(radius){
       var border_radius = $(el).val();
       $("#iframe").contents().find("head").append('<style>#area-container .payment-container a.paymentMethod:hover { border-radius: '+border_radius+' !important;}</style>');
       return ;
    }
    var color = $(el).val();
    $("#iframe").contents().find("head").append('<style>#area-container .payment-container a.paymentMethod:hover { background: '+color+' !important;}</style>');
}
</script>
