<fieldset id="closed" class="hideFieldsets">
    <legend>Object closed view</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Background color:
            <input
                data-jscolor=""
                class="form-control"
                name="closed[id][closedContainer][background-color]"
                data-css-selector="id"
                data-css-selector-value="closedContainer"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['closed']['id']['closedContainer']['background-color']) ) { ?>
                value = "<?php echo $design['closed']['id']['closedContainer']['background-color']?>"
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
                class="form-control"
                name="closed[id][closedContainerH1][background-color]"
                data-css-selector="id"
                data-css-selector-value="closedContainerH1"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['closed']['id']['closedContainerH1']['background-color']) ) { ?>
                value = "<?php echo $design['closed']['id']['closedContainerH1']['background-color']?>"
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
                class="form-control"
                name="closed[id][closedContainerH1][color]"
                data-css-selector="id"
                data-css-selector-value="closedContainerH1"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['closed']['id']['closedContainerH1']['color']) ) { ?>
                value = "<?php echo $design['closed']['id']['closedContainerH1']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
    <div class="form-group col-sm-12">
        <label style="display:block;">
            Font color:
            <input
                data-jscolor=""
                class="form-control"
                name="closed[class][closedContainerFontColor][color]"
                data-css-selector="class"
                data-css-selector-value="closedContainerFontColor"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['closed']['class']['closedContainerFontColor']['color']) ) { ?>
                value = "<?php echo $design['closed']['class']['closedContainerFontColor']['color']?>"
                data-value="1"
                <?php } ?>
            />
        </label>
    </div>
</fieldset>