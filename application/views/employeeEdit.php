<style>
    #generateCode{
        margin-top: 10px;
    } 
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Employee
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
                        <h3 class="box-title">Edit Employee Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addEmployee" action="<?php echo base_url() . "employeeEdit/" . $this->uri->segment(2, 0); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" required class="form-control required" value="<?php echo $emplyee[0]->username; ?>" id="username" name="username" maxlength="50">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" required class="form-control required" value="<?php echo $emplyee[0]->email; ?>" id="email" name="email" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">Unique Code</label>
                                        <input type="text" required class="form-control required" value="<?php echo $emplyee[0]->uniquenumber; ?>" id="code" name="code" maxlength="15">
                                        <input type="button" id="generateCode" class="btn btn-warning" value="Generate Code" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expirytime">Link expiry time (in hours)</label>
                                        <input type="number" min="1" required class="form-control required" value="<?php echo $emplyee[0]->expiration_time_value; ?>" id="expirytime" name="expirytime">
                                        <input type="radio" name="date" value="minutes"<?php if($emplyee[0]->expiration_time_type === "minutes"){echo" checked";}?>> Minutes<br>
                                        <input type="radio" name="date" value="hours"<?php if($emplyee[0]->expiration_time_type === "hours"){echo" checked";}?>> Hours<br>
                                        <input type="radio" name="date" value="days"<?php if($emplyee[0]->expiration_time_type === "days"){echo" checked";}?>> Days<br>
                                        <input type="radio" name="date" value="months"<?php if($emplyee[0]->expiration_time_type === "months"){echo" checked";}?>> Months<br>
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
<script>
    $("body").on("click", "#generateCode", function () {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'generateEmployeeCode'; ?>",
            success: function (response) {
                $("#code").val(response);
            },
            error: function () {
                alert("An error occure! Try again.");
            }
        });
    });
</script>