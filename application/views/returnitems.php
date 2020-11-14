<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

<style type="text/css">

    .container {
        width: 600px;
        margin: 10px auto;
    }
    .progressbar {
        counter-reset: step;
    }
    .progressbar li {
        list-style-type: none;
        width: 25%;
        float: left;
        font-size: 12px;
        position: relative;
        text-align: center;
        text-transform: uppercase;
        color: #7d7d7d;
    }
    .progressbar li:before {
        width: 30px;
        height: 30px;
        content: counter(step);
        counter-increment: step;
        line-height: 30px;
        border: 2px solid #7d7d7d;
        display: block;
        text-align: center;
        margin: 0 auto 10px auto;
        border-radius: 50%;
        background-color: white;
    }
    .progressbar li:after {
        width: 100%;
        height: 2px;
        content: '';
        position: absolute;
        background-color: #7d7d7d;
        top: 15px;
        left: -50%;
        z-index: -1;
    }
    .progressbar li:first-child:after {
        content: none;
    }
    .progressbar li.active {
        color: green;
    }
    .progressbar li.active:before {
        border-color: #55b776;
    }
    .progressbar li.active + li:after {
        background-color: #55b776;
    }
    .hide {
        display:none;
    }

</style>


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
            <i class="fa fa-tags"></i> Your bag-tags & stickers
            <small>Register here </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    &nbsp;
                </div>
            </div>
        </div>


        <?php
        $this->load->helper('form');
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
        <?php } ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Unique code</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>lostandfoundlist" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
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
                                <th class="text-left">Your tags</th>
                                <th class="text-left">Found</th>
                                <th>Code</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Created On</th>
                                <th>DHL tracking code</th>
                                <th class="text-left"> Edit - Delete </th>
                            </tr>
                            <?php
                            if (!empty($userRecords)) {
                                foreach ($userRecords as $record) {
                                    ?>
                                    <tr>
                                        <td class="text-left">
                <!--                            <div class="btn btn-sm --><?php //if ($record->lost) echo('btn-danger');    ?><!--"><img height="64" width="64" src="--><?php //if ($record->lost) echo(base_url() . 'tiqsimg/lostandfoundred-3.png'); else echo(base_url() . 'tiqsimg/lostandfoundgreen-3.png');    ?><!--"></div>-->
                <!--                            <a class="btn btn-sm --><?php //if ($record->lost) echo('btn-danger');    ?><!--" href="--><?php //echo base_url().'setlost/'.$record->id;    ?><!----><?php //if ($record->lost) echo('/0'); else echo('/1');    ?><!--" title="lost"><img height="64" width="64" src="--><?php //if ($record->lost) echo(base_url() . 'tiqsimg/lostandfoundred-3.png'); else echo(base_url() . 'tiqsimg/lostandfoundgreen-3.png');    ?><!--"></a>-->
                                            <!--                            -->
                                            <a class="btn btn-sm<?php if ($record->lost) echo('btn-danger'); ?>"
                                               href="<?php echo base_url() . 'setlostreturn/' . $record->id; ?><?php
                                               if ($record->lost)
                                                   echo('/0');
                                               else
                                                   echo('/1');
                                               ?>" title="lost">
                                                <img height="64" width="64"
                                                     src="<?php
                                                     if (!is_null($record->userclaimId))
                                                         echo(base_url() . 'tiqsimg/lostandfoundleftblue.png');
                                                     else
                                                     if ($record->lost)
                                                         echo(base_url() . 'tiqsimg/lostandfoundwhite.png');
                                                     else
                                                         echo(base_url() . 'tiqsimg/lostandfoundwhite.png');
                                                     ?>"></a>
                                        </td>
                                        <td class="text-left">
                                            <?php
                                            if (!empty($record->userfoundId)) {
                                                ?>
                                                <img height="64" width="64" src="<?php echo base_url(); ?>tiqsimg/lostandfoundgreen-3.png" title="Your item has been found by someone!">
                                                <?php
                                            } else {
                                                ?>
                                                &nbsp;
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $record->code ?></td>
                                        <!-- Image -->
                                        <td>
        <?php $this->load->helper("form"); ?>
                                            <form id="addUser_<?php echo $record->id; ?>" class="file_form" action="<?php echo base_url() ?>userLabelImageCreate" method="post" role="form" enctype='multipart/form-data' >
                                                <label class="thumbnail-file" for="file_<?php echo $record->id; ?>">
                                                    <?php if (!empty($record->image)) { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/LabelImages/<?php $record->userId ?>-<?php $record->code; ?>-<?php $record->image; ?>">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/default.jpg">
        <?php } ?>
                                                </label>
                                                <input type="file" name="imgfile" id="file_<?php echo $record->id; ?>"  accept="image/jpg, image/jpeg, image/png"/>
                                                <input type="hidden" value="<?php echo $record->id; ?>" name="id" id="id" />
                                                <button type="submit" name="labelimage" value="Submit" >Submit</button>
                                                <?php if (!empty($record->image)) { ?>
                                                    <a data-fancybox="gallery" href="<?php echo base_url(); ?>uploads/LabelImages/<?php $record->userId ?>-<?php $record->code; ?>-<?php $record->image; ?>" _target="blank"><img height="32" width="32" src="<?php echo base_url(); ?>tiqsimg/zoomIn.png" title="Zoom"></a>
        <?php } ?>
                                            </form>
                                        </td>
                                        <td><?php echo $record->descript ?></td>
                                        <td><?php echo $record->categoryname ?></td>
                                        <td><?php echo date("d-m-Y", strtotime($record->createdDtm)) ?></td>
                                        <td><?php echo $record->dhltrackingcode ?></td>
                                        <td class="text-left">
                                            <a class="btn btn-sm btn-info" href="<?php echo base_url() . 'editOldlabel/' . $record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-sm btn-warning deleteUser" href="#" data-userid="<?php echo $record->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                        </td>


                                    <tr style="border-style:hidden;">
                                        <td colspan="8">
                                            <div class="container">
                                                <ul class="progressbar">
                                                    <li <?php if ($record->payreturnfeestatus == 1) echo('class="active"'); ?> data-fancybox data-touch="false" href="#getItem">Make an appointment or send item by DHL to your home.</li>
                                                    <li id="uid<?php echo $record->id; ?>" <?php if (!empty($record->identification)) echo('class="active"'); ?> data-fancybox data-touch="false" href="#uploadidentification">Upload identification</li>
                                                    <li id="ibd<?php echo $record->id; ?>" <?php if (!empty($record->utilitybill)) echo('class="active"'); ?> data-fancybox data-touch="false" href="#uploadutilitybill">Upload utility bill</li>
                                                </ul>
                                            </div>
                                    </tr>

                                    <tr style="border-style:hidden;">
                                        <td colspan="8">
                                            <hr>
                                        </td>
                                    </tr>

                                    <!--                        -->

                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
					<?php echo $this->pagination->create_links(); ?>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>


<form id="getItem" action="" method="post" style="display: none;width:100%;max-width:400px;">
    <input type="radio" name="collectWay" value="dhl" checked="checked"> Send item by DHL to your home.<br>
    <input type="radio" name="collectWay" value="appointment"> Make an appointment to collect your item.<br>
    <p></p>
    <p class="mt-10 text-right">
        <input id="collectDHL" data-fancybox data-type="ajax" data-src="<?php echo base_url() . 'getDHLPrice/' . $record->userclaimId . '/' . $record->userfoundId; ?>" href="javascript:;" type="button" class="btn btn-primary" value="Submit" onclick="parent.jQuery.fancybox.getInstance().close();"/>
        <input id="collectAppointment" data-fancybox data-type="ajax" data-src="<?php echo base_url() . 'appointment/' . $record->userfoundId; ?>" href="javascript:;" type="button" class="btn btn-primary hide" value="Submit" onclick="parent.jQuery.fancybox.getInstance().close();"/>
    </p>
</form>


<form id="uploadidentification" action="<?php echo base_url() ?>uploadIdentification" method="POST" enctype="multipart/form-data" style="display: none;width:100%;max-width:400px;">
    <h2 class="mb-3">
        Upload identification
    </h2>
    <p>
        Please, upload your identification by clicking on the Choose File... button below.
    </p>
    <p>
        <input type="file" name="idfile" id="idfile" class="form-control" placeholder="Upload your identification" accept="image/jpg, image/jpeg, image/png, image/tiff, application/pdf" />
        <input type="hidden" value="" name="ilabelid" id="ilabelid" />
    </p>
    <p>
        After submitting your identification, you can continue with step 3: upload your utility bill.
    </p>
    <p class="mb-0 text-right">
        <input data-fancybox-close type="button" id="Submituploadidentification" class="btn btn-primary" value="Submit" />
    </p>
</form>

<form id="uploadutilitybill" action="<?php echo base_url() ?>uploadUtilitybill" method="POST" enctype="multipart/form-data" style="display: none;width:100%;max-width:400px;">
    <h2 class="mb-3">
        Upload utility bill
    </h2>
    <p>
        Please, upload your utility bill by clicking on the Choose File... button below.
    </p>
    <p>
        <input type="file" name="ubfile" id="ubfile" class="form-control" placeholder="Upload your utility bill" accept="image/jpg, image/jpeg, image/png, image/tiff, application/pdf" />
        <input type="hidden" value="" name="ublabelid" id="ublabelid" />
    </p>
    <p>
        After submitting your utility bill, wait and relax. After all three circles are green, we will inform you about the shipment of your item by e-mail.
    </p>

    <p class="mb-0 text-right">
        <input data-fancybox-close type="button" id="Submituploadutilitybill" class="btn btn-primary" value="Submit" />
    </p>
</form>

<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "userReturnitemslisting/" + value);
            jQuery("#searchList").submit();
        });
        $('input[type=file]').change(function () {
            var fileID = $(this).attr('id');
            if (document.getElementById(fileID).files.length == 0) {
                alert("no files selected");
            } else {
                $('#' + fileID).parent('form').submit();
            }
        });

        $('input[type=radio][name=collectWay]').change(function () {
            if (this.value == 'dhl') {
                $("#collectAppointment").addClass("hide");
                $("#collectDHL").removeClass("hide");
            } else if (this.value == 'appointment') {
                $("#collectDHL").addClass("hide");
                $("#collectAppointment").removeClass("hide");
            }
        });

        $('body').on('change', '#selectappointment', function() {
            $("#confirmAppointment").attr("data-src","<?php echo base_url().'selectAppointment/'; ?>" + this.value);
        });
    });

    $(function () {
        $('#Submituploadidentification').click(function () {
            alert('Please, don\'t close your browser, don\'t move away from this screen and don\'t touch anything. Identfication will start after your press OK and will take approximately 60 seconds.');
            $('#uploadidentification').submit();
            return false;
        });
    });

    $("[data-fancybox]").fancybox({
        beforeLoad: function (instance, slide) {
            // check if element had id filled in
            if ($(slide.opts.$orig).attr('id'))
            {   // label id is needed in submit
                $("#ilabelid").val($(slide.opts.$orig).attr('id').substring(3));
                $("#ublabelid").val($(slide.opts.$orig).attr('id').substring(3));
            }
        }
    });

    $(function () {
        $('#Submituploadutilitybill').click(function () {
            $('#uploadutilitybill').submit();
            return false;
        });
    });

</script>
<?php
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}
if (isset($_SESSION['message'])) {
    unset($_SESSION['message']);
}
?>
