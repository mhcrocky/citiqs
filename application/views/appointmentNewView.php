<div class="main-wrapper theme-editor-wrapper">
    <div class="grid-wrapper">
        <div class="grid-list">
            <div class="grid-list-header row">
                <div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
                    <h2>Filter Options</h2>
                </div>
                <!--end col 4 -->
                <div class="col-lg-4 col-md-4 col-sm-12 date-picker-column">
                    <div>
                        <!--From:-->
                        <div class='date-picker-content'>
                            <input type="text" placeholder="Select from.." data-input class="flatpickr" /> <!-- input is mandatory -->
                        </div>
                    </div>
                    <div>
                        <!--To:-->
                        <div class='date-picker-content'>
                            <input type="text" placeholder="Select to.." data-input class="flatpickr-to" /> <!-- input is mandatory -->
                        </div>
                    </div>
                </div>
                <!--end date picker-->
                <div class="col-lg-4 col-md-4 col-sm-12 search-container">
                    <!--Search by name:-->
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0 button grid-button" type="submit">Search</button>
                    </form>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 search-container">
<!--                    <button class="button button-security my-2 my-sm-0 button grid-button" onclick="toogleElementClass('manageAppointment', 'display')">Add new</button>-->
					<button class="btn btn-outline-success my-2 my-sm-0 button grid-button" onclick="toogleElementClass('manageAppointment', 'display')">Add new</button>

				</div>


                <!--HIDDEN ADD EMPLOYEE FORM-->
                <div class="item-editor theme-editor" id='manageAppointment'>
                    <div class="theme-editor-header d-flex justify-content-between">
                        <div>
                            <img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
                        </div>
                        <div class="theme-editor-header-buttons">
                            <input type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('manageAppointmentForm')" value="Submit" />
                            <button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('manageAppointment', 'display')">Cancel</button>
                        </div>
                    </div>
                    <div class="edit-single-user-container">
                        <form class="form-inline" action="<?php echo $this->baseUrl . 'index.php/addNewAppointementSetup/'; ?>" id="manageAppointmentForm" method="post">
                            <input type="text" name="userId" required hidden readonly value="<?php echo $userId; ?>" />
                            <h3>Appointment details</h3>
                            <div>
                                <label for="date">Date</label>
                                <div class='date-picker-content'>
                                    <input type="text" id="date" name="date" placeholder="Select date" data-input class="flatpickr" />
                                </div>
                            </div>
                            <div>
                                <label for="timefrom">Repeat for next weeks</label>
                                <input type="number" name="repeat" class="form-control" required step="1" min="1" value="1" />                                
                            </div>
                            <div>
                                <label for="timefrom">From time:</label>
                                <input type="time" id="timefrom" name="timefrom" class="form-control" required>
                            </div>
                            <div>
                                <label for="timeto">To time:</label>
                                <input type="time" id="timeto" name="timeto" class="form-control" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end grid header -->
            <!-- SINGLE GIRD ITEM -->
            <?php #include_once FCPATH . 'application/views/includes/sessionMessages.php'?>
            <?php
            if(!empty($userAppointments))
            {
                foreach ($userAppointments as $appointment)
                {
            ?>
                <div class="grid-item">
                    <div class="item-header">
                        <?php if($appointment->date) { ?>
                        <p class="item-description"><?php $appointment->date; ?></p>
                        <?php } ?>
                        <p class="item-description"><?php $appointment->dayofweek; ?></p>
                        <p class="item-category"><?php $appointment->timefrom; ?></p>
                        <p class="item-category"><?php $appointment->timeto; ?></p>
                    </div><!-- end item header -->
                    <div class="grid-footer">
                        <div class="iconWrapper">
                            <span class="fa-stack fa-2x edit-icon btn-edit-item"  onclick="toogleElementClass('manageAppointment<?php echo $appointment->id; ?>', 'display')">
                                <i class="far fa-edit"></i>
                            </span>
                        </div>
                        <div title="Click to delete appointment" class="iconWrapper delete-icon-wrapper"
                            onclick="deleteObject(
                                this,
                                '<?php echo $this->baseUrl . 'ajax/deleteAppointment/' . $appointment->id; ?>'
                            )"
                        >
                            <span class="fa-stack fa-2x delete-icon">
                                <i class="fas fa-times"></i>
                            </span>
                        </div>
<!--                        <div class="iconWrapper">-->
<!--                            <span class="fa-stack fa-2x print-icon">-->
<!--                                <i class="fas fa-print"></i>-->
<!--                            </span>-->
<!--                        </div>-->
                    </div>
                    <div class="item-editor theme-editor" id='manageAppointment<?php echo $appointment->id; ?>'>
                        <div class="theme-editor-header d-flex justify-content-between">
                            <div>
                                <img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
                            </div>
                            <div class="theme-editor-header-buttons">
                                <input type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('manageAppointmentForm<?php echo $appointment->id; ?>');" value="Submit" />
                                <button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('manageAppointment<?php echo $appointment->id; ?>', 'display')">Cancel</button>
                            </div>
                        </div>
                        <div class="edit-single-user-container">
                            <form id="manageAppointmentForm<?php echo $appointment->id; ?>" class="form-inline" action="<?php echo $this->baseUrl . 'index.php/editOldAppointment/' . $appointment->id; ?>" method="post">
                                <input type="text" name="id" required hidden readonly value="<?php echo $appointment->id ?>" />
                                <input type="text" name="userId" required hidden readonly value="<?php echo $appointment->userId ?>" />
                                <h3>Appointment details</h3>
                                <div class='date-picker-content'>
                                    <label for="date<?php echo $appointment->id; ?>">Date</label>
                                    <input 
                                        type="text" 
                                        placeholder="Appointment date" 
                                        data-input class="flatpickr"
                                        id="date<?php echo $appointment->id; ?>"
                                        value="<?php echo $appointment->date; ?>"                                        
                                        name="date" 
                                        requried /> <!-- input is mandatory -->
                                </div>
                                <div>
                                    <label for="dayofweek<?php echo $appointment->id; ?>">Day of week</label>
                                    <input type="text" value="<?php echo $appointment->dayofweek?>" readonly disabled  class="form-control" />
                                </div>
                                <div>
                                    <label for="timefrom<?php echo $appointment->id; ?>">From time:</label>
                                    <input type="time" id="timefrom<?php echo $appointment->id; ?>" name="timefrom" value="<?php echo $appointment->timefrom; ?>" class="form-control" required />
                                </div>
                                <div>
                                    <label for="timeto<?php echo $appointment->id; ?>">To time:</label>
                                    <input type="time" id="timeto<?php echo $appointment->id; ?>" name="timeto" value="<?php echo $appointment->timeto; ?>" class="form-control" required />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END SINGLE GRID ITEM -->
                <!-- end grid item -->
            <?php
                }
            }
            ?>
        </div>
    <!-- end grid list -->
    </div>
<!-- end grid wrapper -->
</div>
