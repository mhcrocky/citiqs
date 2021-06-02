<div style="margin-top:0;" class="main-wrapper theme-editor-wrapper">

    
    <?php

        // if ($object['startDate'] && $object['endDate'] && $object['startTime'] && $object['endTime'] && $object['workingDays'] ) {
        // $workingTime  = 'This object is open from ' . $object['startDate'] . ' to ' . $object['endDate'] . ', ';
        // $workingTime .= 'from ' . $object['startTime'] . ' to ' . $object['endTime'] . ' ';
        // if ($object['workingDays']) {
        //     $workingDays = array_keys($object['workingDays']);
        //     $workingTime .= 'on ' . implode(', ', $workingDays);
        // }
        // $workingTime .= '.';
    ?>
    <div style="background: none !important;" class="grid-wrapper">
        <div class="grid-list">
            <div class="grid-list-header row">
                <div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
                    <h2><?php echo $object['busineess_type'] . ' "' . $object['objectName'] . '" '; ?>floor plan(s)</h2>
                </div>
                <!--end col 4 -->
                <div class="col-lg-4 col-md-4 col-sm-12 date-picker-column">
                    <div>
                        <!--From:-->
                        <!-- <div class='date-picker-content'>
                            <input type="text" placeholder="Select from.." data-input class="flatpickr" />
                        </div> -->
                    </div>
                    <div>
                        <!--To:-->
                        <!-- <div class='date-picker-content'>
                            <input type="text" placeholder="Select to.." data-input class="flatpickr-to" />
                        </div> -->
                    </div>
                </div>
                <!--end date picker-->
                <div class="col-lg-4 col-md-4 col-sm-12 search-container">
                    <!--Search by name:-->
                    <!-- <form class="form-inline">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0 button grid-button" type="submit">Search</button>
                    </form> -->
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 search-container">
					<!-- <button class="btn btn-outline-success my-2 my-sm-0 button grid-button" onclick="toogleElementClass('manageAppointment', 'display')">Add new</button> -->
				</div>
            </div>
            <!-- end grid header -->
            <!-- SINGLE GIRD ITEM -->
            <?php
                
                if (!empty($floorPlans)) {                        
                    foreach ($floorPlans as $floorPlanId => $floorPlanAll) {
                        $floorPlan = $floorPlans[$floorPlanId][0];
                        $floorPlan['workingDays'] = unserialize($floorPlan['workingDays']);
                        if ($floorPlan['workingDays']) {
                            $floorPlan['workingDays'] = array_keys($floorPlan['workingDays']);
                        }
                        $times = $floorPlans[$floorPlanId];
                ?>
                    <!-- basic floorplan data -->
                    <div class="grid-item">
                        <h3><?php echo $floorPlan['floor_name']; ?></h3>
                        <div>
                            <img src="<?php echo base_url() . 'uploads/floorPlans/' . $floorPlan['file_name']; ?>" class="img-responsive center-block" />
                            <br/>
                            <p style="text-align:center">
                                <a href="<?php echo base_url()?>settingsmenu/edit_floorplan/<?php echo $object['id'] . '/' . $floorPlan['id']; ?>">Draw floor plan</a>
                            </p>
                            <p style="text-align:center">
                                <a href="<?php echo base_url()?>settingsmenu/show_floorplan/<?php echo $object['id'] . '/' . $floorPlan['id']; ?>">Spot settings</a>
                            </p>
                        </div>
                        <div class="grid-footer">
                            <div class="iconWrapper">
                                <span class="fa-stack fa-2x edit-icon btn-edit-item"  onclick="toogleAllElementClasses('manageObject<?php echo $floorPlan['id']; ?>', 'display')">
                                    <i class="far fa-edit"></i>
                                </span>
                            </div>
                        </div>
                        <div class="item-editor theme-editor" id='manageObject<?php echo $floorPlan['id']; ?>'>
                            <div class="theme-editor-header d-flex justify-content-between">
                                <div>
                                    <img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
                                </div>
                                <div class="theme-editor-header-buttons" style="padding:10px">
                                    <input type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('manageObjectForm<?php echo $floorPlan['id']; ?>');" value="Submit" />
                                    <button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('manageObject<?php echo $floorPlan['id']; ?>', 'display')">Cancel</button>
                                </div>
                            </div>
                            <div class="edit-single-user-container">
                                <h3>"<?php echo $floorPlan['floor_name']; ?>" floorplan</h3>
                                <div style="text-align:left; padding:10px"><?php echo $workingTime; ?></div>
                                <form id="manageObjectForm<?php echo $floorPlan['id']; ?>" class="form-inline" action="<?php echo $this->baseUrl . 'index.php/settingsmenu/addObjectTimeSlots/' .  $object['id'] . '/' .$floorPlan['id']; ?>" method="post">
                                    <fieldset>
                                        <legend>Floorplan working time</legend>
                                        <div class="checkbox">
                                            <?php foreach ($workingDays as $day) { ?>
                                                <label class="checkbox-inline" style="margin-left:10px">
                                                    <input
                                                        type="checkbox"
                                                        name="floorplan[workingDays][<?php echo $day ?>]"
                                                        value="1"
                                                        <?php
                                                            if ($floorPlan['workingDays'] && in_array($day, $floorPlan['workingDays'])) echo 'checked';
                                                        ?>
                                                        />
                                                    <?php echo $day ?>
                                                </label>
                                            <?php } ?>
                                            
                                        </div>
                                        <div>
                                            <label for="startDate<?php echo $floorPlan['id']; ?>">From date:</label>
                                            <input 
                                                type="date" 
                                                id="startDate<?php echo $floorPlan['id']; ?>"
                                                name="floorplan[startDate]" 
                                                value="<?php echo ($floorPlan['startDate']) ? $floorPlan['startDate'] : $object['startDate']; ?>"
                                                min="<?php echo $object['startDate']; ?>"
                                                max="<?php echo $object['endDate']; ?>" 
                                                class="form-control" 
                                                required 
                                                />
                                        </div>
                                        <div>
                                            <label for="endDate<?php echo $floorPlan['id']; ?>">To date:</label>
                                            <input 
                                                type="date"
                                                id="endDate<?php echo $floorPlan['id']; ?>"
                                                name="floorplan[endDate]"
                                                value="<?php echo ($floorPlan['endDate']) ? $floorPlan['endDate'] : $object['endDate']; ?>"
                                                min="<?php echo $object['startDate']; ?>"
                                                max="<?php echo $object['endDate']; ?>"
                                                class="form-control"
                                                required
                                                />
                                        </div>
                                        <div>
                                            <label for="startTime<?php echo $floorPlan['id']; ?>">From time:</label>
                                            <input
                                                type="time"
                                                id="startTime<?php echo $floorPlan['id']; ?>"
                                                name="floorplan[startTime]"
                                                value="<?php echo ($floorPlan['startTime']) ? $floorPlan['startTime'] : $object['startTime']; ?>"
                                                class="form-control"
                                                required
                                                />
                                        </div>
                                        <div>
                                            <label for="timeto<?php echo $floorPlan['id']; ?>">To time:</label>
                                            <input
                                                type="time"
                                                id="endTime<?php echo $floorPlan['id']; ?>"
                                                name="floorplan[endTime]"
                                                value="<?php echo ($floorPlan['endTime']) ? $floorPlan['endTime'] : $object['endTime']; ?>"
                                                class="form-control"
                                                required
                                                />
                                        </div>
                                    </fieldset>

                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                }
                            
            ?>
        </div>
    <!-- end grid list -->
    </div>
<!-- end grid wrapper -->
</div>
<?php include_once FCPATH . 'application/views/includes/alertifySessionMessage.php'; ?>