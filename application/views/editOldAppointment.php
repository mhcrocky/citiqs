<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-calendar-times-o"></i> Appointment
            <small>Edit</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Appointment Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addAppointment" action="<?php echo base_url() . "editOldAppointment/" . $this->uri->segment(2, 0); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dayofweek">Day of the week</label>
                                        <select id="dayofweek" name="dayofweek" class="form-control">
                                            <option value="Monday"<?php getSelectedDropdownValue("Monday", $appointment_details->dayofweek); ?>>Monday</option>
                                            <option value="Tuesday"<?php getSelectedDropdownValue("Tuesday", $appointment_details->dayofweek); ?>>Tuesday</option>
                                            <option value="Wednesday"<?php getSelectedDropdownValue("Wednesday", $appointment_details->dayofweek); ?>>Wednesday</option>
                                            <option value="Thursday"<?php getSelectedDropdownValue("Thursday", $appointment_details->dayofweek); ?>>Thursday</option>
                                            <option value="Friday"<?php getSelectedDropdownValue("Friday", $appointment_details->dayofweek); ?>>Friday</option>
                                            <option value="Saturday"<?php getSelectedDropdownValue("Saturday", $appointment_details->dayofweek); ?>>Saturday</option>
                                            <option value="Sunday"<?php getSelectedDropdownValue("Sunday", $appointment_details->dayofweek); ?>>Sunday</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="timefrom">From time:</label>
                                        <input type="time" id="timefrom" name="timefrom" class="form-control" required value="<?php echo $appointment_details->timefrom; ?>"" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="timeto">To time:</label>
                                        <input type="time" id="timeto" name="timeto" class="form-control" require value="<?php echo $appointment_details->timeto; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="submit" class="btn btn-info" value="Submit" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                $error = $this->session->flashdata('error');
                if ($error) {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('error'); ?>                    
                    </div>
                <?php } ?>
                <?php
                $success = $this->session->flashdata('success');
                if ($success) {
                    ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>
