<fieldset id="ticketsView" class="hideFieldsets">
    <legend>Tickets view</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Header Background color:
            <input
                class="form-control colorInput"
                name="selectType[id][header-img][background-color]"
                data-jscolor=""
                data-css-selector="id"
                data-css-selector-value="header-img"
                data-css-property="background-color"
				style="border-radius: 50px"
				onfocus="styleELements(this)"
                oninput="styleELements(this)"

                <?php if ( isset($design['selectType']['id']['header-img']['background-color']) ) { ?>
                value = "<?php echo $design['selectType']['id']['header-img']['background-color']?>"
                data-value="1"
                <?php } else {?>
                    value = "rgba(255,24,24,1)"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;"l>
            Tickets Background Color:
            <input
                data-jscolor=""
                class="form-control"
                name="selectType[class][shop__item-list][background-color]"
                data-css-selector="class"
                data-css-selector-value="shop__item-list"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
				style="border-radius: 50px"
				<?php if ( isset($design['selectType']['class']['shop__item-list']['background-color']) ) { ?>
                value = "<?php echo $design['selectType']['class']['shop__item-list']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;"l>
            Tickets Text Color:
            <input
                data-jscolor=""
                class="form-control"
                name="selectType[class][shop__item-list][color]"
                data-css-selector="class"
                data-css-selector-value="shop__item-list"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
				style="border-radius: 50px"
				<?php if ( isset($design['selectType']['class']['shop__item-list']['color']) ) { ?>
                value = "<?php echo $design['selectType']['class']['shop__item-list']['color']?>"
                data-value="1"
                <?php } else {?>
                    value = "rgba(0,0,0,1)"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Items Background Color:
            <input
                data-jscolor=""
                class="form-control"
                name="selectType[class][items][background-color]"
                data-css-selector="class"
                data-css-selector-value="items"
                data-css-property="background-color"
				style="border-radius: 50px"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectType']['class']['items']['background-color']) ) { ?>
                value = "<?php echo $design['selectType']['class']['items']['background-color']?>"
                data-value="1"
                <?php } else {?>
                    value = "rgba(255,101,11,1)"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Items Text Color:
            <input
                data-jscolor=""
                class="form-control"
                name="selectType[class][items][color]"
                data-css-selector="class"
                data-css-selector-value="items"
                data-css-property="color"
				style="border-radius: 50px"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectType']['class']['items']['color']) ) { ?>
                value = "<?php echo $design['selectType']['class']['items']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Bottom Background Color:
            <input
                data-jscolor=""
                class="form-control"
                name="selectType[class][bottom-bar][background-color]"
                data-css-selector="class"
                data-css-selector-value="bottom-bar"
                data-css-property="background-color"
				style="border-radius: 50px"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectType']['class']['bottom-bar']['background-color']) ) { ?>
                value = "<?php echo $design['selectType']['class']['bottom-bar']['background-color']?>"
                data-value="1"
                <?php } else {?>
                    value = "rgba(255,175,175,1)"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Bottom Button Background Color:
            <input
                data-jscolor=""
                class="form-control"
                name="selectType[class][button-secondary][background-color]"
                data-css-selector="class"
                data-css-selector-value="button-secondary"
                data-css-property="background-color"
				style="border-radius: 50px"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectType']['class']['button-secondary']['background-color']) ) { ?>
                value = "<?php echo $design['selectType']['class']['button-secondary']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Bottom Button Text Color:
            <input
                data-jscolor=""
                class="form-control"
                name="selectType[class][button-secondary][color]"
                data-css-selector="class"
                data-css-selector-value="button-secondary"
                data-css-property="color"
				style="border-radius: 50px"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectType']['class']['button-secondary']['color']) ) { ?>
                value = "<?php echo $design['selectType']['class']['button-secondary']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>


    <!--
        Add new css property to element h1 in application/views/publicorders/selectType.php view.
        View has h1 tag. Add attribute id with his value. In this case attribute value is selectTypeH1.
        This is part of code from application/views/publicorders/selectType.php view:
            <h1 style="text-align:center" id  =  "selectTypeH1"     ><?php #echo $vendor['vendorName'] ?></h1>

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
                    data-css-selector-value="selectTypeH1" => CSS SELECTOR VALUE. 

                    3. Define css property that needs to be changes by adding value to data-css-selector value
                    data-css-property="font-size" => CHANGES FONT SIZE OF ELEMENT THAT HAS id="selectTypeH1". PROPERTY VALUE IS INPUT FIELD VALUE

                    
                    THIS GOES TO DB
                    4. SAVE ALL VALUES IN THE tbl_shop_vendors TABLE 
                    selectType      => name of the view on which changes refers
                    id              => attribute name
                    selectTypeH1    => attribte value
                    font-size       => css property

                    name="selectType[id][selectTypeH1][font-size]"
                    <?php #if ( isset($design['selectType']['id']['selectTypeH1']['font-size']) ) { ?>
                    value = "<?php #echo $design['selectType']['id']['selectTypeH1']['font-size']?>"
                    data-value="1"
                    <?php #} ?>
                />
            </label>
        </div>
    -->

</fieldset>
