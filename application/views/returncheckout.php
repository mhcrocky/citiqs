
<!--example iframe-->

<!--<script src="https://tiqs.com/js/iframeResizer.min.js"></script> //?? waarvoor zou je dit doen???-->
<!--<iframe src="https://tiqs.com/location/xxxxx" width="100%" scrolling="yes" frameborder="0"></iframe>-->
<!--<script>iFrameResize({autoResize:true, sizeHeight:true}</script>-->


<!DOCTYPE html>
<html><head>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/home/images/tiqsiconlogonew.png" alt="">
	<meta charset="UTF-8">
	<title>tiqs | Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/main-style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/how-it-works.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/home-page.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/grid.css">-->


	<link rel="stylesheet" href="assets/home/styles/main-style.css">
	<link rel="stylesheet" href="assets/home/styles/how-it-works.css">
	<link rel="stylesheet" href="assets/home/styles/home-page.css">
	<link rel="stylesheet" href="assets/home/styles/grid.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
	<link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="assets/home/js/vanilla-picker.js"></script>

</head>
<body>

<div class="main-wrapper">
	<div class="grid-wrapper">
		<div class="grid-list">
			<?php
			if(!empty($userRecords))
			{
				foreach($userRecords as $record)
				{
					?>

					<div class="grid-item">
						<div class="item-header">
							<p class="item-date"><?php echo $record->createdDtm?></p>
							<p class="item-code"><?php echo $record->code?></p>
							<div class='grid-image'>
								<?php if (!empty($record->image)) { ?>
									<img src="<?php echo base_url(); ?>uploads/LabelImages/<?php $record->userId ?>-<?php $record->code; ?>-<?php $record->image; ?>">
								<?php } else { ?>
									<img src="<?php echo base_url(); ?>uploads/default.jpg">
								<?php } ?>
							</div>
							<p class='item-description'><?php echo $this->language->line($record->descript,$record->descript) ?></p>
							<p class='item-category'><?php echo $this->language->line($record->categoryname,$record->categoryname)  ?></p>
						</div>
						<div class="grid-footer">
							<a href="<?php echo base_url().'claim/'.$record->code; ?>" >
								<button class='grid-button button'>Claim</button>
							</a>
						</div>
					</div><!-- end grid item -->
					<?PHP
				}
			}
			?>
		</div><!-- end grid list -->
	</div><!-- end grid wrapper -->

</div><!-- end main wrapper -->


</body>


</html>


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
