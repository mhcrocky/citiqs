<?php 
if ( isset($design['shop']['eventDescript']) ) {
    $textareaContent = $design['shop']['eventDescript'];
    } else {
        $textareaContent = "";
 } ?>
<fieldset id="shopView" class="hideFieldsets">
    <legend>Logo Color</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Logo Color:
            <select id="logoColor" style="border-radius: 50px" class="form-control" name="selValue">
                <option value="brightness(100%)" data-content="<i style='margin-right: 5px;color: #eb5d15;' class='fa fa-square'></i> Orange" selected></option>
                <option value="brightness(10000%)" data-content="<i style='margin-right: 5px;color: #fff;'  class='fa fa-square'></i> White"></option>
                <option value="brightness(0%)" data-content="<i style='margin-right: 5px;color: #000;'  class='fa fa-square'></i> Black"></option>
                <option value="brightness(290%)" data-content="<i style='margin-right: 5px; color: #ffff3d;'  class='fa fa-square'></i> Yellow"></option>
                <option value="contrast(10)" data-content="<i style='margin-right: 5px;color:#ff0000;'  class='fa fa-square'></i> Red"></option>
                <option value="contrast(10%)" data-content="<i style='margin-right: 5px;color:#8a7c75;'  class='fa fa-square'></i> Gray"></option>
                <option value="hue-rotate(90deg)" data-content="<i style='margin-right: 5px;color:#159f01;'  class='fa fa-square'></i> Green"></option>
                <option value="hue-rotate(-0.25turn)" data-content="<i style='margin-right: 5px;color:#d64deb;'  class='fa fa-square'></i> Purple"></option>
                <option value="hue-rotate(3.142rad)" data-content="<i style='margin-right: 5px;color:#018ed6;'  class='fa fa-square'></i> Blue"></option>
                <option value="invert(70%)" data-content="<i style='margin-right: 5px;color: #548daa;'  class='fa fa-square'></i> Sky"></option>
            </select>

            <input type="hidden" id="img-logo" class="form-control colorInput" name="shop[class][menu-icon][filter]"
                <?php if ( isset($design['shop']['class']['menu-icon']['filter']) ) { ?>
                value="<?php echo $design['shop']['class']['menu-icon']['filter']?>" data-value="1" <?php } else { ?>
                value="brightness(100%)" <?php } ?> />

        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Title Text Content:
            <input type="text" id="eventTitle" class="form-control" name="shop[eventTitle]"
                <?php if ( isset($design['shop']['eventTitle']) ) { ?>
                value="<?php echo $design['shop']['eventTitle']?>" data-value="1" <?php } else { ?> value="Our Events"
                <?php } ?> />

        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Subtitle Text Content:
            <textarea rows="3" id="eventDescript" class="form-control"><?php echo $textareaContent; ?></textarea>
        </label>
    </div>

    <input type="hidden" id="eventText" class="form-control colorInput" name="shop[eventDescript]"
        value="<?php echo $textareaContent; ?>" />



        <?php if($eventId): ?>
        <div class="form-group row mt-3">
            <label for="image" class="col-md-4 col-form-label text-md-left text-dark">Upload Background
                Image</label>
            <div class="col-md-8">


                <label class="file">
                    <input type="file" class="border-50" name="backgroundfile" id="background-file"
                        onchange="imageUpload(this)" aria-label="File browser">
                    <span style="width: 220px !important" class="file-custom" id="img-background"
                        data-content="Choose image ..."></span>
                </label>
                <div style="padding-left: 0;" class="col-sm-6">
                    <?php if($event->backgroundImage == ''): ?>
                    <img src="<?php echo base_url(); ?>assets/images/img-preview.png" id="background-preview"
                        class="img-thumbnail">
                    <?php else: ?>
                    <img src="<?php echo base_url(); ?>assets/images/events/<?php echo $event->backgroundImage; ?>"
                        id="background-preview" class="img-thumbnail">
                    <?php endif; ?>
                </div>


            </div>
        </div>

        <?php endif; ?>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Body background color:
            <input class="form-control colorInput" name="shop[id][body][background-color]" data-jscolor=""
                data-css-selector="id" data-css-selector-value="body" data-css-property="background-color"
                style="border-radius: 50px" onfocus="styleELements(this)" oninput="styleELements(this)"
                <?php if ( isset($design['shop']['id']['body']['background-color']) ) { ?>
                value="<?php echo $design['shop']['id']['body']['background-color']?>" data-value="1" <?php } ?> />
        </label>
    </div>
    <div class="form-group row mt-3">
            <label for="image" class="col-md-4 col-form-label text-md-left text-dark">
            Body background image:</label>
            <div class="col-md-8">


                <label class="file">
                    <input type="file" class="border-50" name="backgroundimage" id="background-image"
                        onchange="backgroundImageUpload(this)" aria-label="File browser">
                    <span style="width: 220px !important" class="file-custom" id="background-img"
                        data-content="Choose image ..."></span>
                </label>
                <div style="padding-left: 0;" class="col-sm-6">
                <?php if ( !isset($design['shop']['background-image']) ) : ?>
                    <img src="<?php echo base_url(); ?>assets/images/img-preview.png" id="background-img-preview"
                        class="img-thumbnail">
                    <?php else: ?>
                    <img src="<?php echo base_url(); ?>assets/images/events/<?php echo $design['shop']['background-image']; ?>"
                        id="background-img-preview" class="img-thumbnail">
                    <button type="button" class="btn btn-danger mt-2" onclick="confirmDelete()">Delete Image</button>
                    <input type="hidden" name="shop[background-image]" value="<?php echo $design['shop']['background-image']; ?>">
                    <input type="hidden" name="img_delete" id="img_delete" value="0">
                    <?php endif; ?>
                </div>


            </div>
        </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Header menu background color:
            <input class="form-control colorInput" name="shop[class][header][background-color]" data-jscolor=""
                data-css-selector="class" data-css-selector-value="header" data-css-property="background-color"
                style="border-radius: 50px" onfocus="styleELements(this)" oninput="styleELements(this)"
                <?php if ( isset($design['shop']['class']['header']['background-color']) ) { ?>
                value="<?php echo $design['shop']['class']['header']['background-color']; ?>" data-value="1" 
                <?php } elseif( isset($defaultDesign['shop']['class']['header']['background-color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['header']['background-color']; ?>" data-value="1" 
                <?php } ?> 
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Footer menu background color:
            <input class="form-control colorInput" name="shop[class][footer][background-color]" data-jscolor=""
                data-css-selector="class" data-css-selector-value="footer" data-css-property="background-color"
                style="border-radius: 50px" onfocus="styleELements(this)" oninput="styleELements(this)"
                <?php if ( isset($design['shop']['class']['footer']['background-color']) ) { ?>
                value="<?php echo $design['shop']['class']['footer']['background-color']; ?>" data-value="1" 
                <?php } elseif( isset($defaultDesign['shop']['class']['footer']['background-color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['footer']['background-color']; ?>" data-value="1" 
                <?php } else { ?> 
                value="rgba(244,242,245,1)"
                <?php } ?> 
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Navbar button background color:
            <input class="form-control colorInput" name="shop[class][navbar-toggler][background-color]"
                data-jscolor="" data-css-selector="class" data-css-selector-value="navbar-toggler"
                data-css-property="background-color" style="border-radius: 50px" onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['shop']['class']['navbar-toggler']['background-color']) ) { ?>
                value="<?php echo $design['shop']['class']['navbar-toggler']['background-color']; ?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['class']['navbar-toggler']['background-color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['navbar-toggler']['background-color']; ?>" data-value="1" 
                <?php } else{ ?> value="#ea2251" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Go to shop button background color:
            <input class="form-control colorInput" name="shop[class][show-info][background]"
                data-jscolor="" data-css-selector="class" data-css-selector-value="show-info"
                data-css-property="background" style="border-radius: 50px" onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['shop']['class']['show-info']['background']) ) { ?>
                value="<?php echo $design['shop']['class']['show-info']['background']?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['class']['show-info']['background']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['show-info']['background']; ?>" data-value="1" 
                <?php } else{ ?> value="#17a2b8" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Go to shop button font color:
            <input class="form-control colorInput" name="shop[class][show-info][color]"
                data-jscolor="" data-css-selector="class" data-css-selector-value="show-info"
                data-css-property="color" style="border-radius: 50px" onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['shop']['class']['show-info']['color']) ) { ?>
                value="<?php echo $design['shop']['class']['show-info']['color']?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['class']['show-info']['color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['show-info']['color']; ?>" data-value="1" 
                <?php } else{ ?> value="#fff" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Checkout button background color:
            <input class="form-control colorInput" name="shop[class][header__checkout][background-color]"
                data-jscolor="" data-css-selector="class" data-css-selector-value="header__checkout"
                data-css-property="background-color" style="border-radius: 50px" onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['shop']['class']['header__checkout']['background-color']) ) { ?>
                value="<?php echo $design['shop']['class']['header__checkout']['background-color']; ?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['class']['header__checkout']['background-color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['header__checkout']['background-color']; ?>" data-value="1" 
                <?php } else{ ?> value="#7855c4" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Checkout button on hover background color:
            <input data-jscolor="" class="form-control colorInput" name="shop[header__checkout][hover]"
             style="border-radius: 50px" onfocus="checkoutHoverStyle(this)"
                oninput="checkoutHoverStyle(this)"
                <?php if ( isset($design['shop']['header__checkout']['hover']) ) { ?>
                value="<?php echo $design['shop']['header__checkout']['hover']; ?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['header__checkout']['hover']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['header__checkout']['hover']; ?>" data-value="1" 
                <?php } else{ ?> value="#7855c4" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Quantity buttons background color:
            <input data-jscolor="" class="form-control" name="shop[class][quantity-button][background-color]"
                data-css-selector="class" data-css-selector-value="quantity-button" data-css-property="background-color"
                onfocus="styleELements(this)" oninput="styleELements(this)" style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['quantity-button']['background-color']) ) { ?>
                value="<?php echo $design['shop']['class']['quantity-button']['background-color']; ?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['class']['quantity-button']['background-color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['quantity-button']['background-color']; ?>" data-value="1" 
                <?php } else { ?> value="#ea2251" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Event cards background color:
            <input data-jscolor="" class="form-control" name="shop[class][single-item---bg-white][background-color]"
                data-css-selector="class" data-css-selector-value="single-item.bg-white"
                data-css-property="background-color" onfocus="styleELements(this)" oninput="styleELements(this)"
                style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['single-item---bg-white']['background-color']) ) { ?>
                value="<?php echo $design['shop']['class']['single-item---bg-white']['background-color']; ?>"
                <?php } elseif( isset($defaultDesign['shop']['class']['single-item---bg-white']['background-color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['single-item---bg-white']['background-color']; ?>"
                data-value="1" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Active event card background color:
            <input data-jscolor="" class="form-control" name="shop[class][single-item---bg-light][background-color]"
                data-css-selector="class" data-css-selector-value="single-item.bg-light"
                data-css-property="background-color" onfocus="styleELements(this)" oninput="styleELements(this)"
                style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['single-item---bg-light']['background-color']) ) { ?>
                value="<?php echo $design['shop']['class']['single-item---bg-light']['background-color']; ?>"
                <?php } elseif( isset($defaultDesign['shop']['class']['single-item---bg-light']['background-color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['single-item---bg-light']['background-color']; ?>"
                data-value="1" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Title text color:
            <input data-jscolor="" class="form-control" name="shop[class][event-title][color]" data-css-selector="class"
                data-css-selector-value="event-title" data-css-property="color" onfocus="styleELements(this)"
                oninput="styleELements(this)" style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['event-title']['color']) ) { ?>
                value="<?php echo $design['shop']['class']['event-title']['color']; ?>" data-value="1" 
                <?php } elseif( isset($defaultDesign['shop']['class']['event-title']['color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['event-title']['color']; ?>" data-value="1" 
                <?php } else { ?>
                value="#212529" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Subtitle text color:
            <input data-jscolor="" class="form-control" name="shop[id][event_text_descript][color]"
                data-css-selector="id" data-css-selector-value="event_text_descript" data-css-property="color"
                onfocus="styleELements(this)" oninput="styleELements(this)" style="border-radius: 50px"
                <?php if ( isset($design['shop']['id']['event_text_descript']['color']) ) { ?>
                value="<?php echo $design['shop']['id']['event_text_descript']['color']; ?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['id']['event_text_descript']['color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['id']['event_text_descript']['color']; ?>" data-value="1" 
                <?php } else { ?> value="#6c7581" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Selected event text color:
            <input data-jscolor="" class="form-control" name="shop[id][selected_event_text][color]"
                data-css-selector="id" data-css-selector-value="selected_event_text" data-css-property="color"
                onfocus="styleELements(this)" oninput="styleELements(this)" style="border-radius: 50px"
                <?php if ( isset($design['shop']['id']['selected_event_text']['color']) ) { ?>
                value="<?php echo $design['shop']['id']['selected_event_text']['color']?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['id']['selected_event_text']['color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['id']['selected_event_text']['color']; ?>" data-value="1" 
                <?php } else { ?> value="#7855c4" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Selected event font size:
            <input type="text" class="form-control" name="shop[class][selected_event_text][font-size]"
                data-css-selector="class" data-css-selector-value="selected_event_text" data-css-property="font-size"
                onfocus="styleELements(this)" oninput="styleELements(this)" style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['selected_event_text']['font-size']) ) { ?>
                value="<?php echo $design['shop']['class']['selected_event_text']['font-size']; ?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['class']['selected_event_text']['font-size']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['selected_event_text']['font-size']; ?>" data-value="1" 
                <?php } else { ?> value="40px" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Ticket price text color:
            <input data-jscolor="" class="form-control" name="shop[class][ticket_price][color]"
                data-css-selector="class" data-css-selector-value="ticket_price" data-css-property="color"
                onfocus="styleELements(this)" oninput="styleELements(this)" style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['ticket_price']['color']) ) { ?>
                value="<?php echo $design['shop']['class']['ticket_price']['color']; ?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['class']['ticket_price']['color']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['ticket_price']['color']; ?>" data-value="1" 
                <?php } else { ?> value="#7855c4" <?php } ?> />
        </label>
    </div>


    <div class="form-group col-sm-12">
        <label style="display:block;">
            Title font size:
            <input type="text" class="form-control" name="shop[class][event-title][font-size]" data-css-selector="class"
                data-css-selector-value="event-title" data-css-property="font-size" onfocus="styleELements(this)"
                oninput="styleELements(this)" style="border-radius: 50px"
                <?php if ( isset($design['shop']['class']['event-title']['font-size']) ) { ?>
                value="<?php echo $design['shop']['class']['event-title']['font-size'];  ?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['class']['event-title']['font-size']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['class']['event-title']['font-size']; ?>" data-value="1" 
                <?php } else { ?> value="40px" <?php } ?> />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
            Subtitle font size:
            <input type="text" class="form-control" name="shop[id][event_text_descript][font-size]"
                data-css-selector="id" data-css-selector-value="event_text_descript" data-css-property="font-size"
                onfocus="styleELements(this)" oninput="styleELements(this)" style="border-radius: 50px"
                <?php if ( isset($design['shop']['id']['event_text_descript']['font-size']) ) { ?>
                value="<?php echo $design['shop']['id']['event_text_descript']['font-size']?>" data-value="1"
                <?php } elseif( isset($defaultDesign['shop']['id']['event_text_descript']['font-size']) ) { ?> 
                value="<?php echo $defaultDesign['shop']['id']['event_text_descript']['font-size']; ?>" data-value="1" 
                <?php } else { ?> value="18px" <?php } ?> />
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
$('#logoColor').selectpicker();
$('textarea#eventDescript').on('input', function() {
    let eventDescript = $(this).val();
    $("#iframe").contents().find("#event_text_descript").text(eventDescript);
    $('#eventText').val(eventDescript);
});

$('#logoColor').on('change', function() {
    let filter = $('#logoColor option:selected').val();
    $("#iframe").contents().find("head").append('<style> .menu-icon { filter:'+ filter +' !important;}</style>');
    $('#img-logo').val(filter);
});

$('#eventTitle').on('input', function() {
    let eventTitle = $(this).val();
    $("#iframe").contents().find("#event-title").text(eventTitle);
});

function checkoutHoverStyle(el){
    var color = $(el).val();
    $("#iframe").contents().find("head").append('<style> .header__checkout:hover { background: '+color+' !important;}</style>');
}
</script>

<?php if ( isset($design['shop']['class']['menu-icon']['filter']) ) { ?>
<script>
var value = "<?php echo $design['shop']['class']['menu-icon']['filter']; ?>";
$('select[name=selValue]').val(value);
$('#logoColor').selectpicker('refresh');
</script>
<?php } ?>
