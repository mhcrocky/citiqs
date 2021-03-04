<fieldset id="selectedSpotView" class="hideFieldsets">
    <legend>Make order view</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Background color:
            <input

                class="form-control colorInput"
				style="border-radius: 50px"
				data-jscolor=""
                name="makeOrderNew[class][selectedSpotBackground][background-color]"
                data-css-selector="class"
                data-css-selector-value="selectedSpotBackground"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['selectedSpotBackground']['background-color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['selectedSpotBackground']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Products list border color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][bordersColor][border-color]"
                data-css-selector="class"
                data-css-selector-value="bordersColor"
                data-css-property="border-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['bordersColor']['border-color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['bordersColor']['border-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Category name background color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][categoryName][background-color]"
                data-css-selector="class"
                data-css-selector-value="categoryName"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['categoryName']['background-color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['categoryName']['background-color']?>"
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
                name="makeOrderNew[class][categoryName][color]"
                data-css-selector="class"
                data-css-selector-value="categoryName"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['categoryName']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['categoryName']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Menu items font color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][menuColor][color]"
                data-css-selector="class"
                data-css-selector-value="menuColor"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['menuColor']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['menuColor']['color']?>"
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
                name="makeOrderNew[class][productName][color]"
                data-css-selector="class"
                data-css-selector-value="productName"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['productName']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['productName']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Product description font color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][productDescription][color]"
                data-css-selector="class"
                data-css-selector-value="productDescription"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['productDescription']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['productDescription']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Product category font color (popup):
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][productCategory][color]"
                data-css-selector="class"
                data-css-selector-value="productCategory"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['productCategory']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['productCategory']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Remark label font color (popup):
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][remarkStyle][color]"
                data-css-selector="class"
                data-css-selector-value="remarkStyle"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['remarkStyle']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['remarkStyle']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Labels font color (popup):
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][labelsMain][color]"
                data-css-selector="class"
                data-css-selector-value="labelsMain"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['labelsMain']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['labelsMain']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Label items font color (popup):
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][labelItems][color]"
                data-css-selector="class"
                data-css-selector-value="labelItems"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['labelItems']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['labelItems']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Price, quantity, plus and minus background color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][priceQuantity][background-color]"
                data-css-selector="class"
                data-css-selector-value="priceQuantity"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['priceQuantity']['background-color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['priceQuantity']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Price, quantity, plus and minus font color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][priceQuantity][color]"
                data-css-selector="class"
                data-css-selector-value="priceQuantity"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['priceQuantity']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['priceQuantity']['color']?>"
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
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][footer][background-color]"
                data-css-selector="class"
                data-css-selector-value="footer"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['footer']['background-color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['footer']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Total button background color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][totalButton][background-color]"
                data-css-selector="class"
                data-css-selector-value="totalButton"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['totalButton']['background-color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['totalButton']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Total button font color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][totalButton][color]"
                data-css-selector="class"
                data-css-selector-value="totalButton"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['totalButton']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['totalButton']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Pay button background color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][payButton][background-color]"
                data-css-selector="class"
                data-css-selector-value="payButton"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['payButton']['background-color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['payButton']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Pay button font color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][payButton][color]"
                data-css-selector="class"
                data-css-selector-value="payButton"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['payButton']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['payButton']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Pay button width:
            <input
                type="text"
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[id][payButton][width]"
                data-css-selector="id"
                data-css-selector-value="payButton"
                data-css-property="width"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['id']['payButton']['width']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['id']['payButton']['width']?>"
                data-value="1"
                <?php } else { ?>
                value="100%"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Pay button border radius:
            <input
                type="text"
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[id][payButton][border-radius]"
                data-css-selector="id"
                data-css-selector-value="payButton"
                data-css-property="border-radius"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['id']['payButton']['border-radius']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['id']['payButton']['border-radius']?>"
                data-value="1"
                <?php } else { ?>
                value="0px"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Add product button font color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][addProductOnList][color]"
                data-css-selector="class"
                data-css-selector-value="addProductOnList"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['addProductOnList']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['addProductOnList']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Add product button background color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][addProductOnList][background-color]"
                data-css-selector="class"
                data-css-selector-value="addProductOnList"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['addProductOnList']['background-color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['addProductOnList']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Add product button font color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][addProductOnList][color]"
                data-css-selector="class"
                data-css-selector-value="addProductOnList"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['addProductOnList']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['addProductOnList']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Input field color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][inputFieldsMakeOrder][color]"
                data-css-selector="class"
                data-css-selector-value="inputFieldsMakeOrder"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['inputFieldsMakeOrder']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['inputFieldsMakeOrder']['color']?>"
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
                name="makeOrderNew[class][inputFieldsMakeOrder][border-color]"
                data-css-selector="class"
                data-css-selector-value="inputFieldsMakeOrder"
                data-css-property="border-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['inputFieldsMakeOrder']['border-color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['inputFieldsMakeOrder']['border-color']?>"
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
                name="makeOrderNew[class][inputFieldsMakeOrder][background-color]"
                data-css-selector="class"
                data-css-selector-value="inputFieldsMakeOrder"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['inputFieldsMakeOrder']['background-color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['inputFieldsMakeOrder']['background-color']?>"
                data-value="1"
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
                name="makeOrderNew[class][slick-arrow:before][color]"
                data-css-selector="class"
                data-css-selector-value="slick-arrow"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['slick-arrow:before']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['slick-arrow:before']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Arrows background color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][slick-prev][background]"
                data-css-selector="class"
                data-css-selector-value="slick-prev"
                data-css-property="background"
                onfocus="arrowStyle(this)"
                oninput="arrowStyle(this)"
                <?php if ( isset($design['makeOrderNew']['class']['slick-prev']['background']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['slick-prev']['background']?>"
                data-value="1"
                <?php } ?>
            />
            <input
                type="hidden"
                name="makeOrderNew[class][slick-next][background]"
                data-css-selector="class"
                data-css-selector-value="slick-next"
                data-css-property="background"
                id="slick_next"
                <?php if ( isset($design['makeOrderNew']['class']['slick-next']['background']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['slick-next']['background']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Arrows background color:
            <input
                type="text"
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][slick-prev][border-radius]"
                data-css-selector="class"
                data-css-selector-value="slick-prev"
                data-css-property="border-radius"
                onfocus="arrowStyle(this,true)"
                oninput="arrowStyle(this, true)"
                <?php if ( isset($design['makeOrderNew']['class']['slick-prev']['border-radius']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['slick-prev']['border-radius']?>"
                data-value="1"
                <?php } else { ?>
                    value="50%"
                <?php } ?>
            />
            <input
                type="hidden"
                name="makeOrderNew[class][slick-next][border-radius]"
                data-css-selector="class"
                data-css-selector-value="slick-next"
                data-css-property="border-radius"
                id="slick_next_border"
                <?php if ( isset($design['makeOrderNew']['class']['slick-next']['border-radius']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['slick-next']['border-radius']?>"
                data-value="1"
                <?php } else { ?>
                    value="50%"
                <?php } ?>
            />
        </label>
    </div>
    
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Info circle color:
            <input
                data-jscolor=""
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][infoCircle][color]"
                data-css-selector="class"
                data-css-selector-value="infoCircle"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['infoCircle']['color']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['infoCircle']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Add Product On List button border radius:
            <input
                type="text"
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][addProductOnList][border-radius]"
                data-css-selector="class"
                data-css-selector-value="addProductOnList"
                data-css-property="border-radius"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['addProductOnList']['border-radius']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['addProductOnList']['border-radius']?>"
                data-value="1"
                <?php } else { ?>
                value="0px"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Remark input border radius:
            <input
                type="text"
				style="border-radius: 50px"
                class="form-control"
                name="makeOrderNew[class][remarks][border-radius]"
                data-css-selector="class"
                data-css-selector-value="remarks"
                data-css-property="border-radius"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['makeOrderNew']['class']['remarks']['border-radius']) ) { ?>
                value = "<?php echo $design['makeOrderNew']['class']['remarks']['border-radius']?>"
                data-value="1"
                <?php } else { ?>
                value="0px"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
           Ingredients Image Color:
            <select id="ingredientsColor" style="border-radius: 50px" class="form-control" name="selValue">
                <option value="brightness(100%)" data-content="<i style='margin-right: 5px;color: #df5453;' class='fa fa-square'></i> Red" selected></option>
                <option value="brightness(10000%)" data-content="<i style='margin-right: 5px;color: #fff;'  class='fa fa-square'></i> White"></option>
                <option value="brightness(0%)" data-content="<i style='margin-right: 5px;color: #000;'  class='fa fa-square'></i> Black"></option>
                <option value="brightness(20%)" data-content="<i style='margin-right: 5px; color: #2d1111;'  class='fa fa-square'></i> Brown"></option>
                <option value="contrast(10%)" data-content="<i style='margin-right: 5px;color:#8a7c75;'  class='fa fa-square'></i> Gray"></option>
                <option value="hue-rotate(90deg)" data-content="<i style='margin-right: 5px;color:#159f01;'  class='fa fa-square'></i> Green"></option>
                <option value="hue-rotate(-0.25turn)" data-content="<i style='margin-right: 5px;color:#d64deb;'  class='fa fa-square'></i> Purple"></option>
                <option value="hue-rotate(3.142rad)" data-content="<i style='margin-right: 5px;color:#018ed6;'  class='fa fa-square'></i> Blue"></option>
                <option value="invert(70%)" data-content="<i style='margin-right: 5px;color: #548daa;'  class='fa fa-square'></i> Sky"></option>
            </select>

            <input type="hidden" class="form-control ingredients_img" name="makeOrderNew[class][ingredients][filter]"
                <?php if ( isset($design['makeOrderNew']['class']['ingredients']['filter']) ) { ?>
                value="<?php echo $design['makeOrderNew']['class']['ingredients']['filter']?>" data-value="1" <?php } else { ?>
                value="brightness(100%)" <?php } ?> />
            <input type="hidden" class="form-control ingredients_img" name="checkoutOrder[class][ingredients][filter]"
                <?php if ( isset($design['checkoutOrder']['class']['ingredients']['filter']) ) { ?>
                value="<?php echo $design['checkoutOrder']['class']['ingredients']['filter']?>" data-value="1" <?php } else { ?>
                value="brightness(100%)" <?php } ?> />

        </label>
    </div>  
</fieldset>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
$('#ingredientsColor').selectpicker();
$('#ingredientsColor').on('change', function() {
    let filter = $('#ingredientsColor option:selected').val();
    $("#iframe").contents().find("head").append('<style> .ingredients { filter:'+ filter +' !important;}</style>');
    $('.ingredients_img').val(filter);
});

function arrowStyle(el, border_radius=false){
    let color = $(el).val();
    if(border_radius){
        $('#slick_next_border').val(color);
        styleELements(el);
        styleELements(document.getElementById('slick_next_border'));
        return ;
    }
    $('#slick_next').val(color);
    styleELements(el);
    styleELements(document.getElementById('slick_next'));
}
</script>

<?php if ( isset($design['makeOrderNew']['class']['ingredients']['filter']) ) { ?>
<script>
var value = "<?php echo $design['makeOrderNew']['class']['ingredients']['filter']; ?>";
$('select[name=selValue]').val(value);
$('#ingredientsColor').selectpicker('refresh');
</script>
<?php } ?>