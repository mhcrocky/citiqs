<fieldset id="checkoutOrderView" class="hideFieldsets">
    <legend>Checkout form view</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Background color:
            <input
                data-jscolor=""
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][checkoutOrderBody][background-color]"
                data-css-selector="class"
                data-css-selector-value="checkoutOrderBody"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['checkoutOrderBody']['background-color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['checkoutOrderBody']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Headline background color:
            <input
                data-jscolor=""
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[id][headlineYourOrder][background-color]"
                data-css-selector="id"
                data-css-selector-value="headlineYourOrder"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['id']['headlineYourOrder']['background-color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['id']['headlineYourOrder']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Headline font color:
            <input
                data-jscolor=""
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[id][headlineYourOrder][color]"
                data-css-selector="id"
                data-css-selector-value="headlineYourOrder"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['id']['headlineYourOrder']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['id']['headlineYourOrder']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Headline border radius:
            <input
                type="text"
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[id][headlineYourOrder][border-radius]"
                data-css-selector="id"
                data-css-selector-value="headlineYourOrder"
                data-css-property="border-radius"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['id']['headlineYourOrder']['border-radius']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['id']['headlineYourOrder']['border-radius']?>"
                data-value="1"
                <?php } else { ?>
                value="0px"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Quantity and price background color:
            <input
                data-jscolor=""
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][markedButtons][background-color]"
                data-css-selector="class"
                data-css-selector-value="markedButtons"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['markedButtons']['background-color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['markedButtons']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Quantity and price font color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][markedButtons][color]"
                data-css-selector="class"
                data-css-selector-value="markedButtons"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['markedButtons']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['markedButtons']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Product name font color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][productName][color]"
                data-css-selector="class"
                data-css-selector-value="productName"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['productName']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['productName']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Category name font color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][categoryName][color]"
                data-css-selector="class"
                data-css-selector-value="categoryName"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['categoryName']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['categoryName']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Trash icon color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][trashIcon][color]"
                data-css-selector="class"
                data-css-selector-value="trashIcon"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['trashIcon']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['trashIcon']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Edit icon color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][editIcon][color]"
                data-css-selector="class"
                data-css-selector-value="editIcon"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['editIcon']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['editIcon']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Plus and minus background color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][plusAndMinus][background-color]"
                data-css-selector="class"
                data-css-selector-value="plusAndMinus"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['plusAndMinus']['background-color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['plusAndMinus']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Plus and minus font color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][plusAndMinusColor][color]"
                data-css-selector="class"
                data-css-selector-value="plusAndMinusColor"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['plusAndMinusColor']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['plusAndMinusColor']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Fee,total and tip background color:
            <input
                data-jscolor=""
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][feeTotalTip][color]"
                data-css-selector="class"
                data-css-selector-value="feeTotalTip"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['feeTotalTip']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['feeTotalTip']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Border color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][borderColor][border-color]"
                data-css-selector="class"
                data-css-selector-value="borderColor"
                data-css-property="border-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['borderColor']['border-color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['borderColor']['border-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div> 
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Labels font color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][labelColorCheckout][color]"
                data-css-selector="class"
                data-css-selector-value="labelColorCheckout"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['labelColorCheckout']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['labelColorCheckout']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Input field font color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][inputFieldCheckout][color]"
                data-css-selector="class"
                data-css-selector-value="inputFieldCheckout"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['inputFieldCheckout']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['inputFieldCheckout']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div> 
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Input field border color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][inputFieldCheckout][border-color]"
                data-css-selector="class"
                data-css-selector-value="inputFieldCheckout"
                data-css-property="border-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['inputFieldCheckout']['border-color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['inputFieldCheckout']['border-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Input field background color:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][inputFieldCheckout][background-color]"
                data-css-selector="class"
                data-css-selector-value="inputFieldCheckout"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['inputFieldCheckout']['background-color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['inputFieldCheckout']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Delivery/pikup time headline:
            <input
                data-jscolor=""
style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[id][deliveryPeriodAndTime][color]"
                data-css-selector="id"
                data-css-selector-value="deliveryPeriodAndTime"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['id']['deliveryPeriodAndTime']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['id']['deliveryPeriodAndTime']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Remarks input border radius:
            <input
                type="text"
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[id][notesInput][border-radius]"
                data-css-selector="id"
                data-css-selector-value="notesInput"
                data-css-property="border-radius"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['id']['notesInput']['border-radius']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['id']['notesInput']['border-radius']; ?>"
                data-value="1"
                <?php } else { ?>
                value="0px"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Back button background color:
            <input
                data-jscolor=""
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[id][checkoutBack][background-color]"
                data-css-selector="id"
                data-css-selector-value="checkoutBack"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['id']['checkoutBack']['background-color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['id']['checkoutBack']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Back button font color:
            <input
                data-jscolor=""
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[id][checkoutBack][color]"
                data-css-selector="id"
                data-css-selector-value="checkoutBack"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['id']['checkoutBack']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['id']['checkoutBack']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Back button border radius:
            <input
                type="text"
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[id][checkoutBack][border-radius]"
                data-css-selector="id"
                data-css-selector-value="checkoutBack"
                data-css-property="border-radius"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['id']['checkoutBack']['border-radius']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['id']['checkoutBack']['border-radius']; ?>"
                data-value="1"
                <?php } else { ?>
                value="0px"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Continue button background color:
            <input
                data-jscolor=""
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[id][checkoutContinue][background-color]"
                data-css-selector="id"
                data-css-selector-value="checkoutContinue"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['id']['checkoutContinue']['background-color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['id']['checkoutContinue']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Continue button font color:
            <input
                data-jscolor=""
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[id][checkoutContinue][color]"
                data-css-selector="id"
                data-css-selector-value="checkoutContinue"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['id']['checkoutContinue']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['id']['checkoutContinue']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Continue button border radius:
            <input
                type="text"
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[id][checkoutContinue][border-radius]"
                data-css-selector="id"
                data-css-selector-value="checkoutContinue"
                data-css-property="border-radius"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['id']['checkoutContinue']['border-radius']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['id']['checkoutContinue']['border-radius']?>"
                data-value="1"
                <?php } else { ?>
                value="0px"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Arrows color:
            <input
                data-jscolor=""
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][arrowStyle][color]"
                data-css-selector="class"
                data-css-selector-value="arrowStyle"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['arrowStyle']['color']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['arrowStyle']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Arrows size:
            <input
                type="text"
                style="border-radius: 50px"
                class="form-control"
                name="checkoutOrder[class][arrowStyle][font-size]"
                data-css-selector="class"
                data-css-selector-value="arrowStyle"
                data-css-property="font-size"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['checkoutOrder']['class']['arrowStyle']['font-size']) ) { ?>
                value = "<?php echo $design['checkoutOrder']['class']['arrowStyle']['font-size']?>"
                data-value="1"
                <?php } else { ?>
                    value="14px"
                <?php } ?>
            />
        </label>
    </div>
</fieldset>
