<fieldset id="spotsView" class="hideFieldsets">
    <legend>Select spots view</legend>
    <div class="form-group col-sm-12">
		<label style="display:block;">
			Event Text:
			<input  type="text" class="form-control b-radius" name="tableTitle[place]"
				onfocus="styleELements(this)"
				onchange="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['tableTitle']['place']) ) { ?>
				value="<?php echo $design['tableTitle']['place']?>" data-value="1"
				<?php } else { ?> value="<?php echo $this->language->tLine('Place'); ?>"
				<?php } ?> />
		</label>
	</div>
	<div class="form-group col-sm-12">
		<label style="display:block;">
			SPOT Text:
			<input  type="text" class="form-control b-radius" name="tableTitle[status]"
				onfocus="styleELements(this)"
				onchange="styleELements(this)"
					style="width:100%"
				<?php if ( isset($design['tableTitle']['status']) ) { ?>
				value="<?php echo $design['tableTitle']['status']?>" data-value="1"
				<?php } else { ?> value="<?php echo $this->language->tLine('Status'); ?>"
				<?php } ?> />
		</label>
	</div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
        Available Background color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[id][btn-available][background]"
                data-css-selector="id"
                data-css-selector-value="btn-available"
                data-css-property="background"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['id']['btn-available']['background']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['id']['btn-available']['background']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
        Sold Out Background color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[id][btn-soldout][background]"
                data-css-selector="id"
                data-css-selector-value="btn-soldout"
                data-css-property="background"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['id']['btn-soldout']['background']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['id']['btn-soldout']['background']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
        Card Background color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
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
                class="form-control b-radius jscolor w-100"
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
                class="form-control b-radius jscolor w-100"
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
                class="form-control b-radius jscolor w-100"
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