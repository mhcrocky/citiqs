<fieldset id="shopView" class="hideFieldsets">
    <legend>Shop view</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Header menu background color:
            <input
                class="form-control colorInput"
                name="shop[class][header][background-color]"
                data-jscolor=""
                data-css-selector="class"
                data-css-selector-value="header"
                data-css-property="background-color"
				style="border-radius: 50px"
				onfocus="styleELements(this)"
                oninput="styleELements(this)"

                <?php if ( isset($design['shop']['class']['header']['background-color']) ) { ?>
                value = "<?php echo $design['shop']['class']['header']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Menu icon color:
            <input
                type="text"
                class="form-control colorInput"
                name="shop[class][menu-icon][filter]"
                data-css-selector="class"
                data-css-selector-value="menu-icon"
                data-css-property="filter"
				style="border-radius: 50px"
				onfocus="styleELements(this)"
                oninput="styleELements(this)"
                

                <?php if ( isset($design['shop']['class']['menu-icon']['filter']) ) { ?>
                value = "<?php echo $design['shop']['class']['menu-icon']['filter']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Background color:
            <input
                class="form-control colorInput"
                name="shop[id][body][background-color]"
                data-jscolor=""
                data-css-selector="id"
                data-css-selector-value="body"
                data-css-property="background-color"
				style="border-radius: 50px"
				onfocus="styleELements(this)"
                oninput="styleELements(this)"

                <?php if ( isset($design['shop']['id']['body']['background-color']) ) { ?>
                value = "<?php echo $design['shop']['id']['body']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Checkout button background color:
            <input
                class="form-control colorInput"
                name="shop[class][header__checkout][background-color]"
                data-jscolor=""
                data-css-selector="class"
                data-css-selector-value="header__checkout"
                data-css-property="background-color"
				style="border-radius: 50px"
				onfocus="styleELements(this)"
                oninput="styleELements(this)"

                <?php if ( isset($design['shop']['class']['header__checkout']['background-color']) ) { ?>
                value = "<?php echo $design['shop']['class']['header__checkout']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Quantity buttons background color:
            <input
                data-jscolor=""
                class="form-control"
                name="shop[class][quantity-button][background-color]"
                data-css-selector="class"
                data-css-selector-value="quantity-button"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
				style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['quantity-button']['background-color']) ) { ?>
                value = "<?php echo $design['shop']['class']['quantity-button']['background-color']?>"
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
                name="shop[class][footer][background-color]"
                data-css-selector="class"
                data-css-selector-value="footer"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
				style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['footer']['background-color']) ) { ?>
                value = "<?php echo $design['shop']['class']['footer']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Event cards background color:
            <input
                data-jscolor=""
                class="form-control"
                name="shop[class][single-item---bg-white][background-color]"
                data-css-selector="class"
                data-css-selector-value="single-item.bg-white"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
				style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['single-item---bg-white']['background-color']) ) { ?>
                value = "<?php echo $design['shop']['class']['single-item---bg-white']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Active event card background color:
            <input
                data-jscolor=""
                class="form-control"
                name="shop[class][single-item---bg-light][background-color]"
                data-css-selector="class"
                data-css-selector-value="single-item.bg-light"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
				style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['single-item---bg-light']['background-color']) ) { ?>
                value = "<?php echo $design['shop']['class']['single-item---bg-light']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Title font size:
            <input
                type="text"
                class="form-control"
                name="shop[class][text-size][font-size]"
                data-css-selector="class"
                data-css-selector-value="text-size"
                data-css-property="font-size"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
				style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['text-size']['font-size']) ) { ?>

                    value = "<?php echo $design['shop']['class']['text-size']['font-size']?>"

                    data-value="1"
                <?php } else { ?>
                    value = "24px"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Border-radius:
            <input
                type="text"
                class="form-control"
                name="shop[class][card-img-top][border-top-right-radius]"
                data-css-selector="class"
                data-css-selector-value="card-img-top"
                data-css-property="border-top-right-radius"
                onfocus="borderRadius(this)"
                oninput="borderRadius(this)"
				style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['card-img-top']['border-top-right-radius']) ) { ?>

                    value = "<?php echo $design['shop']['class']['card-img-top']['border-top-right-radius']; ?>"

                    data-value="1"
                <?php } ?>
            />
            <input
                type="hidden"
                id="border-top-left-radius"
                name="shop[class][card-img-top-2][border-top-left-radius]"
                data-css-selector="class"
                data-css-selector-value="card-img-top-2"
                data-css-property="border-top-left-radius"
                onchange="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['shop']['class']['card-img-top-2']['border-top-left-radius']) ) { ?>

                    value = "<?php echo $design['shop']['class']['card-img-top-2']['border-top-left-radius']; ?>"

                    data-value="1"
                <?php } ?>
            />
            <input
                type="hidden"
                id="border-bottom-right-radius"
                name="shop[class][card-b][border-bottom-right-radius]"
                data-css-selector="class"
                data-css-selector-value="card-b"
                data-css-property="border-bottom-right-radius"
                onchange="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['shop']['class']['card-b']['border-bottom-right-radius']) ) { ?>

                    value = "<?php echo $design['shop']['class']['card-b']['border-bottom-right-radius']; ?>"

                    data-value="1"
                <?php } ?>
            />
            <input
                type="hidden"
                id="border-bottom-left-radius"
                name="shop[class][card-body-2][border-bottom-left-radius]"
                data-css-selector="class"
                data-css-selector-value="card-body-2"
                data-css-property="border-bottom-left-radius"
                onchange="styleELements(this)"
                onkeyup="styleELements(this)"
                <?php if ( isset($design['shop']['class']['card-body-2']['border-bottom-left-radius']) ) { ?>

                    value = "<?php echo $design['shop']['class']['card-body-2']['border-bottom-left-radius']; ?>"

                    data-value="1"
                <?php } ?>
            />
        </label>
    </div>


    <div class="form-group col-sm-12">
        <label style="display:block;">
            Card margin-bottom:
            <input
                type="text"
                class="form-control"
                name="shop[class][places][margin-bottom]"
                data-css-selector="class"
                data-css-selector-value="places"
                data-css-property="margin-bottom"
                onchange="styleELements(this)"
                onkeyup="styleELements(this)"
                style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['places']['margin-bottom']) ) { ?>

                    value = "<?php echo $design['shop']['class']['places']['margin-bottom']; ?>"

                    data-value="1"
                <?php } else {?>
                    value = "10px"
                <?php } ?>
            />
        </label>
    </div>


    <!--
        Add new css property to element h1 in application/views/publicorders/shop.php view.
        View has h1 tag. Add attribute id with his value. In this case attribute value is shopH1.
        This is part of code from application/views/publicorders/shop.php view:
            <h1 style="text-align:center" id  =  "shopH1"     ><?php #echo $vendor['vendorName'] ?></h1>

        <div class="form-group col-sm-12">
            <label style="display:block;">
                Headline font size:
                <input
                    type="text"
                    class="form-control"
                    onfocus="styleELements(this)"
                    oninput="styleELements(this)"

                    THIS PART OF THE CODE MAKES CHANGES IN IFRAME OF SELECTED VIEW
                    1. Define css selector name by adding value to data-css-selector attribute
                    data-css-selector = "id" => CSS SELECTOR NAME, IT CAN BE id FOR ONE ELEMENT OR class FOR MORE ELEMENTS (SEE TAG BELOVE FOR CLASS EXAMPLE)
                    
                    2. Define css selector name value by adding value to data-css-selector value
                    data-css-selector-value="shopH1" => CSS SELECTOR VALUE. 

                    3. Define css property that needs to be changes by adding value to data-css-selector value
                    data-css-property="font-size" => CHANGES FONT SIZE OF ELEMENT THAT HAS id="shopH1". PROPERTY VALUE IS INPUT FIELD VALUE

                    
                    THIS GOES TO DB
                    4. SAVE ALL VALUES IN THE tbl_shop_vendors TABLE 
                    shop      => name of the view on which changes refers
                    id              => attribute name
                    shopH1    => attribte value
                    font-size       => css property

                    name="shop[id][shopH1][font-size]"
                    <?php #if ( isset($design['shop']['id']['shopH1']['font-size']) ) { ?>
                    value = "<?php #echo $design['shop']['id']['shopH1']['font-size']?>"
                    data-value="1"
                    <?php #} ?>
                />
            </label>
        </div>
    -->

</fieldset>