<div style="margin-top: 0" class="main-wrapper theme-editor-wrapper">
    <div style="background: none !important;" class="grid-wrapper">
        <div class="grid-list">
            <div class="grid-list-header row">
                <div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
                    <h2>Objects</h2>
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
                if(isset($objects)  && !empty($objects)) {
                    foreach ($objects as $object) {
                    ?>
                    <div class="grid-item">
                        <div class="item-header">
                            <p class="item-description"><?php echo $object['objectName']; ?></p>
                            <p class="item-category"><?php echo $object['startTime']; ?></p>
                            <p class="item-category"><?php echo $object['endTime']; ?></p>
                        </div><!-- end item header -->
                        <div>
                            <p style="text-align:center">
                                <a href="<?php echo base_url()?>settingsmenu/edit_floorplan/<?php echo $object['id']; ?>">Add floor plan</a>
                            </p>
                            <p style="text-align:center">
                                <a href="<?php echo base_url()?>settingsmenu/floor_plans/<?php echo $object['id']; ?>">Object floor plan(s)</a>
                            </p>
                        </div>
                        <div class="grid-footer">
                            <div class="iconWrapper">
                                <span class="fa-stack fa-2x edit-icon btn-edit-item"  onclick="toogleElementClass('manageObject<?php echo $object['id']; ?>', 'display')">
                                    <i class="far fa-edit"></i>
                                </span>
                            </div>
                        </div>
                        <div class="item-editor theme-editor" id='manageObject<?php echo $object['id']; ?>'>
                            <div class="theme-editor-header d-flex justify-content-between">
                                <div>
                                    <img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
                                </div>
                                <div class="theme-editor-header-buttons">
                                    <input type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('manageObjectForm<?php echo $object['id']; ?>');" value="Submit" />
                                    <button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('manageObject<?php echo $object['id']; ?>', 'display')">Cancel</button>
                                </div>
                            </div>
                            <div class="edit-single-user-container">
                                <form id="manageObjectForm<?php echo $object['id']; ?>" class="form-inline" action="<?php echo $this->baseUrl . 'settingsmenu/editSpotObject/' . $object['id']; ?>" method="post">
                                    <h3>Working time</h3>
                                    <div class="checkbox">
                                        <label class="checkbox-inline" style="margin-left:10px">
                                            <input type="checkbox" name="workingDays[monday]" value="1" <?php if (isset($object['workingDays']['monday'])) echo 'checked' ?> />
                                            Monday
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="workingDays[tuesday]" value="1" <?php if (isset($object['workingDays']['tuesday'])) echo 'checked' ?> />
                                            Tuesday
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="workingDays[wednesday]" value="1" <?php if (isset($object['workingDays']['wednesday'])) echo 'checked' ?> />
                                            Wednesday
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="workingDays[thursday]" value="1" <?php if (isset($object['workingDays']['thursday'])) echo 'checked' ?> />
                                            Thursday
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="workingDays[friday]" value="1" <?php if (isset($object['workingDays']['friday'])) echo 'checked' ?> />
                                            Friday
                                        </label>
                                        <label class="checkbox-inline">
                                        <input type="checkbox" name="workingDays[saturday]" value="1" <?php if (isset($object['workingDays']['saturday'])) echo 'checked' ?> />
                                            Saturday
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="workingDays[sunday]" value="1" <?php if (isset($object['workingDays']['sunday'])) echo 'checked' ?> />
                                            Sunday
                                        </label>
                                    </div>
                                    <div>
                                        <label for="startDate<?php echo $object['id']; ?>">From date:</label>
                                        <input type="date" id="startDate<?php echo $object['id']; ?>" name="startDate" value="<?php echo $object['startDate']; ?>" class="form-control" required />
                                    </div>
                                    <div>
                                        <label for="endDate<?php echo $object['id']; ?>">To date:</label>
                                        <input type="date" id="endDate<?php echo $object['id']; ?>" name="endDate" value="<?php echo $object['endDate']; ?>" class="form-control" required />
                                    </div>
                                    <div>
                                        <label for="startTime<?php echo $object['id']; ?>">From time:</label>
                                        <input type="time" id="startTime<?php echo $object['id']; ?>" name="startTime" value="<?php echo $object['startTime']; ?>" class="form-control" required />
                                    </div>
                                    <div>
                                        <label for="timeto<?php echo $object['id']; ?>">To time:</label>
                                        <input type="time" id="endTime<?php echo $object['id']; ?>" name="endTime" value="<?php echo $object['endTime']; ?>" class="form-control" required />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                } else {
                    echo '<p>No object(s). Please add spot <a href="' . base_url() .'address">object</a></p>';
                }

            ?>
        </div>
    <!-- end grid list -->
    </div>
<!-- end grid wrapper -->
</div>
<script>
    $(".flatpickr").flatpickr();
    $(".flatpickr-to").flatpickr();
</script>
<script src="<?php echo $this->baseUrl ?>assets/home/js/edit-grid-item.js" ></script>
<?php include_once FCPATH . 'application/views/includes/alertifySessionMessage.php'; ?>


