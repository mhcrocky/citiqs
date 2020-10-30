<style type="text/css">
    .thumbnail-file{
        width: 100px;
        height: 100px;
    }
    .thumbnail-file img{
        width: 100%;
        height: 100%;
        min-height: 100%;
        min-width: 100%;
        object-fit: cover;
    }
    .file_form input[type="file"], .file_form button{
        position: absolute;
        z-index: -1;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-calendar-times-o"></i> Appointment
            <small>Setup</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-info" href="<?php echo base_url(); ?>addNewAppointment"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <?php
        $error = $this->session->flashdata('error');
        if ($error) {
            ?>
            <div id="mydivs1">
                <div class="alert alert-danger alert-dismissable" id="mydivs">
                    <button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>
                </div>
            </div>
        <?php
        }
        $success = $this->session->flashdata('success');
        if ($success) {
            ?>
            <div class="alert alert-success alert-dismissable" id="mydivs2">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $success; ?>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Appointments</h3>
                        <div class="box-tools">
                            <form action="" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th class="text-left">Day of the week</th>
                                <th class="text-left">From time (HH:MM)</th>
                                <th class="text-left">To time(HH:MM)</th>
                                <th class="text-left">Edit - Delete </th>
                            </tr>
                            <?php
                            if (!empty($userAppointments)) {
                                foreach ($userAppointments as $appointment) {
                                    ?>
                                    <tr>
                                        <td class="text-left">
        <?php $appointment->dayofweek; ?>
                                        </td>
                                        <td class="text-left">
        <?php $appointment->timefrom; ?>
                                        </td>
                                        <td class="text-left">
        <?php $appointment->timeto; ?>
                                        </td>
                                        <td class="text-left">
                                            <a class="btn btn-sm btn-info" href="<?php echo base_url() . 'editOldAppointment/' . $appointment->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-sm btn-warning deleteAppointment" href="#" data-appointmentid="<?php echo $appointment->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            }
                            ?>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
