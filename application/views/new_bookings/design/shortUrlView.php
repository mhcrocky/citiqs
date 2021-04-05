<fieldset id="shortUrlView" class="hideFieldsets">
<legend>Select home view</legend>
    <div class="form-group col-sm-12">
        <label style="display:block;">
        Default View:
        <select class="form-control b-radius w-100" name="defaultView">
            <option value="tableView" <?php if ( isset($design['defaultView']) && $design['defaultView'] == 'tableView'  ) { ?> selected <?php } ?>>Rows</option>
            <option value="calendarView" <?php if ( (isset($design['defaultView']) && $design['defaultView'] == 'calendarView' ) || !isset($design['defaultView']) ) { ?>selected <?php } ?>>Calendar</option>
        </select>
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Calendar Header Background color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[class][cal-header][background-color]"
                data-css-selector="class"
                data-css-selector-value="cal-header"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['class']['cal-header']['background-color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['cal-header']['background-color']?>"
                data-value="1"
                <?php } else { ?>
                value="#4A4A4A" 
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Calendar Header color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[class][header][color]"
                data-css-selector="class"
                data-css-selector-value="header"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['class']['header']['color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['header']['color']?>"
                data-value="1"
                <?php } else { ?>
                value="#FFFFFF" 
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Calendar Arrows Header color:
            <input 
                data-jscolor=""
                name="selectShortUrl[class][arrow-header][border-color]"
                class="form-control b-radius jscolor w-100"
                data-css-selector="class"
                data-css-selector-value="arrow-header"
                data-css-property="border-color"
                onfocus="calHeaderArrows(this)"
                oninput="calHeaderArrows(this)"
                <?php if ( isset($design['selectShortUrl']['class']['arrow-header']['border-color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['arrow-header']['border-color']?>"
                data-value="1"
                <?php } else { ?>
                value="#a09fa0" 
                <?php } ?>
            />

            <input 
                type="hidden"
                id="header-arrow-right"
                data-css-selector="class"
                data-css-selector-value="arrow-header-right"
                data-css-property="border-color"
                name="selectShortUrl[class][arrow-header-right][border-color]"
                <?php if ( isset($design['selectShortUrl']['class']['arrow-header-right']['border-color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['arrow-header-right']['border-color']?>"
                data-value="1"
                <?php } else { ?>
                    value="transparent transparent transparent #a09fa0"
                <?php } ?>
            />

            <input 
                type="hidden"
                id="header-arrow-left"
                data-css-selector="class"
                data-css-selector-value="arrow-header-left"
                data-css-property="border-color"
                name="selectShortUrl[class][arrow-header-left][border-color]"
                <?php if ( isset($design['selectShortUrl']['class']['arrow-header-left']['border-color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['arrow-header-left']['border-color']?>"
                data-value="1"
                <?php } else { ?>
                    value="transparent #a09fa0 transparent transparent"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Calendar Background color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[class][bg-cal][background-color]"
                data-css-selector="class"
                data-css-selector-value="bg-cal"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['class']['bg-cal']['background-color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['bg-cal']['background-color']?>"
                data-value="1"
                <?php } else { ?>
                value="#4A4A4A" 
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Current Month Day color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[class][day-month][color]"
                data-css-selector="class"
                data-css-selector-value="day-month"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['class']['day-month']['color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['day-month']['color']?>"
                data-value="1"
                <?php } else { ?>
                value="#FFFFFF" 
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Today color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[class][today][color]"
                data-css-selector="class"
                data-css-selector-value="today"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['class']['today']['color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['today']['color']?>"
                data-value="1"
                <?php } else { ?>
                value="#9ccaeb" 
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Other Month Day color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[class][day-other][color]"
                data-css-selector="class"
                data-css-selector-value="day-other"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['class']['day-other']['color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['day-other']['color']?>"
                data-value="1"
                <?php } else { ?>
                value="rgba(255, 255, 255, .3)" 
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Week color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[class][day-name][color]"
                data-css-selector="class"
                data-css-selector-value="day-name"
                data-css-property="color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['class']['day-name']['color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['day-name']['color']?>"
                data-value="1"
                <?php } else { ?>
                value="rgba(255, 255, 255, .5)" 
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Calendar Event Background color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[class][details][background-color]"
                data-css-selector="class"
                data-css-selector-value="details"
                data-css-property="background-color"
                onfocus="calEventBackground(this)"
                oninput="calEventBackground(this)"
                <?php if ( isset($design['selectShortUrl']['class']['details']['background-color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['details']['background-color']?>"
                data-value="1"
                <?php } else { ?>
                    value="#A4A4A4"
                <?php } ?>
            />
            <input 
                type="hidden"
                id="event-arrow"
                name="selectShortUrl[class][arrow][border-color]"
                data-css-selector="class"
                data-css-selector-value="arrow"
                data-css-property="border-color"
                <?php if ( isset($design['selectShortUrl']['class']['arrow']['border-color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['arrow']['border-color']?>"
                data-value="1"
                <?php } else { ?>
                    value="transparent transparent #A4A4A4 transparent"
                <?php } ?>
            />
        </label>
    </div>

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Event font color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[class][spotLink][color]"
                data-css-selector="class"
                data-css-selector-value="spotLink"
                data-css-property="color"
                onfocus="eventFontColor(this)"
                oninput="eventFontColor(this)"
                <?php if ( isset($design['selectShortUrl']['class']['spotLink']['color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['spotLink']['color']?>"
                data-value="1"
                <?php } else { ?>
                    value="#FFFFFF"
                <?php } ?>
            />

            <input 
                type="hidden"
                id="empty-event"
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[class][empty][color]"
                data-css-selector="class"
                data-css-selector-value="empty"
                data-css-property="color"
                <?php if ( isset($design['selectShortUrl']['class']['event.empty']['empty']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['event.empty']['empty']?>"
                data-value="1"
                <?php } else { ?>
                    value="#FFFFFF"
                <?php } ?>
            />
        </label>
    </div>
    

    <div class="form-group col-sm-12">
        <label style="display:block;">
        Event's Square color:
            <input 
                data-jscolor=""
                class="form-control b-radius jscolor w-100"
                name="selectShortUrl[class][green][background-color]"
                data-css-selector="class"
                data-css-selector-value="green"
                data-css-property="background-color"
                onfocus="styleELements(this)"
                oninput="styleELements(this)"
                <?php if ( isset($design['selectShortUrl']['class']['green']['background-color']) ) { ?>
                value = "<?php echo $design['selectShortUrl']['class']['green']['background-color']?>"
                data-value="1"
                <?php } else { ?>
                    value="#99c66d"
                <?php } ?>
            />
        </label>
    </div>



    
    

    
</fieldset>

<script>

function calEventBackground(el) {
    let color = $(el).val();
    $('#event-arrow').val('transparent transparent '+color+' transparent');
    let arrow = document.getElementById('event-arrow');
    styleELements(el);
    styleELements(arrow); 
    return ;
}

function calHeaderArrows(el) {
    let color = $(el).val();
    $('#header-arrow-right').val('transparent transparent transparent '+color);
    $('#header-arrow-left').val('transparent '+color+' transparent transparent');
    let right_arrow = document.getElementById('header-arrow-right');
    let left_arrow = document.getElementById('header-arrow-left');
    styleELements(right_arrow);
    styleELements(left_arrow);
    return ;
}

function eventFontColor(el) {
    let color = $(el).val();
    $('#empty-event').val(color);
    let empty = document.getElementById('empty-event');
    styleELements(el);
    styleELements(empty);
    return ;
}

</script>