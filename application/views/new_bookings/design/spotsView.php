<fieldset id="spotsView" class="hideFieldsets">
    <legend>Select spots view</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
        Card Background color:
            <input 
                data-jscolor=""
                class="form-control jscolor"
                name="selectShortUrl[id][card][background-color]"
                data-css-selector="id"
                data-css-selector-value="card"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['id']['card']['background-color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['id']['card']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
        Spot Data color:
            <input 
                data-jscolor=""
                class="form-control jscolor"
                name="selectShortUrl[class][spot-data][color]"
                data-css-selector="class"
                data-css-selector-value="spot-data"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['class']['spot-data']['color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['spot-data']['color']?>"
                data-value="1" opacity
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
        Spot Title color:
            <input 
                data-jscolor=""
                class="form-control jscolor"
                name="selectShortUrl[id][spot-title][color]"
                data-css-selector="id"
                data-css-selector-value="spot-title"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['id']['spot-title']['color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['id']['spot-title']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
        Choose Time color:
            <input 
                data-jscolor=""
                class="form-control jscolor"
                name="selectShortUrl[id][choose-time][color]"
                data-css-selector="id"
                data-css-selector-value="choose-time"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['id']['choose-time']['color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['id']['choose-time']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    
    

    
</fieldset>