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
            <i class="fa fa-language"></i>Employees
            <small>List of employees</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-info" href="<?php echo base_url(); ?>addNewEmployee"><i class="fa fa-plus"></i> Add New</a>
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
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Serach for employee</h3>
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
                                    <th class="text-left">Employee username</th>
                                    <th class="text-left">Employee email</th>
                                    <th class="text-left">Employee number</th>
                                    <th class="text-left">Edit - Delete employee</th>
                                </tr>
                                <?php
                                foreach ($employees as $employee) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php $employee->username; ?>
                                        </td>
                                        <td>
                                            <?php $employee->email; ?>
                                        </td>
                                        <td>
                                            <?php $employee->uniquenumber; ?>
                                        </td>
                                        <td class="text-left">
                                            <a class="btn btn-sm btn-info" href="<?php echo base_url() . 'employeeEdit/' . $employee->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-sm btn-warning deleteEmployee" href="#" data-employee="<?php echo $employee->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                            <?php 
                                            if( $employee->expiration_time >= time()){ ?>
                                                <a class="btn btn-sm btn-success emailEmployee" href="#" data-employee="<?php echo $employee->id; ?>" title="Send Email"><i class="fa fa-envelope"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php }
                                ?>                      
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </div>
    </section>
</div>
<script>

    jQuery(document).on("click", ".deleteEmployee", function () {
        var employeeid = $(this).data("employee"),
                hitURL = "<?php base_url() . "deleteEmployee"; ?>",
                currentRow = $(this);
        var confirmation = confirm("Are you sure to delete this employee?");
        if (confirmation) {
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: hitURL,
                data: {employeeid: employeeid}
            }).done(function (data) {
                currentRow.parents('tr').remove();
                if (data.status == true) {
                    alert("Employee successfully deleted");
                } else if (data.status == false) {
                    alert("Employee deletion failed");
                } else {
                    alert("Access denied..!");
                }
            });
        }
    });

    jQuery(document).on("click", ".emailEmployee", function () {
        var employeeid = $(this).data("employee"),
                hitURL = "<?php base_url() . "emailEmployee"; ?>";
        var confirmation = confirm("Are you sure to send email with link to this employee?");
        if (confirmation) {
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: hitURL,
                data: {employeeid: employeeid}
            }).done(function (data) {
                if (data.status == true) {
                    alert("Email successfully sent to employee");
                } else if (data.status == false) {
                    alert("Email failed to be sent to employee");
                } else {
                    alert("Access denied..!");
                }
            });
        }
    });
</script>
