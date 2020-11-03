<fieldset id="selectTypeView" class="hideFieldsets">
    <legend>Select type view</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Background color:
            <input
                type="color"
                class="form-control"
                name="selectType[id][selectTypeBody][background-color]"
                data-css-selector="id"
                data-css-selector-value="selectTypeBody"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectType']['id']['selectTypeBody']['background-color']) ) { ?>
                value = "<?php echo $design['selectType']['id']['selectTypeBody']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <labe style="display:block;"l>
            Headline backgorund color:
            <input
                type="color"
                class="form-control"
                name="selectType[id][selectTypeH1][background-color]"
                data-css-selector="id"
                data-css-selector-value="selectTypeH1"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectType']['id']['selectTypeH1']['background-color']) ) { ?>
                value = "<?php echo $design['selectType']['id']['selectTypeH1']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Headline font color:
            <input
                type="color"
                class="form-control"
                name="selectType[id][selectTypeH1][color]"
                data-css-selector="id"
                data-css-selector-value="selectTypeH1"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectType']['id']['selectTypeH1']['color']) ) { ?>
                value = "<?php echo $design['selectType']['id']['selectTypeH1']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Types background color:
            <input
                type="color"
                class="form-control"
                name="selectType[class][selectTypeLabels][background-color]"
                data-css-selector="class"
                data-css-selector-value="selectTypeLabels"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectType']['class']['selectTypeLabels']['background-color']) ) { ?>
                value = "<?php echo $design['selectType']['class']['selectTypeLabels']['background-color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
</fieldset>