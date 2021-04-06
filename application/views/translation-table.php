<!DOCTYPE html>
<html><head>
<!--    <link rel="shortcut icon" href="https://tiqs.com/lostandfound/assets/home/images/tiqsiconlogonew.png" alt="">-->
<!--    <meta charset="UTF-8">-->
<!--    <title>tiqs | Home</title>-->
<!---->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->

<!--    <link rel="stylesheet" href="assets/styles/styles.css">-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/translation-table-style.css">
<!--    <link rel="stylesheet" href="assets/styles/main-style.css">-->
<!--    <link rel="stylesheet" href="assets/styles/how-it-works.css">-->
<!--	-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<!--    -->
<!--    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>-->
</head>
<style>
tr td {
	padding: 15px;
	padding-left: 0px;
}
</style>
<body>

<!-- end header -->

<!-- translation table -->
<section class='section-4'>
	<div class="col-xs-12">
		<form action="<?php echo base_url() . "translate"; ?>" method="POST" id="translationsForm">
			<div class="input-group">
				<label style="Padding: 10px;" >SELECT LANGUAGE </label>
				<select name="language" id="language">
					<option value="" selected disabled hidden>Choose here</option>
					<?php
					
					foreach ($results as $result) {
						if (set_value("language") != null && set_value("language") == $result->language) {
							$selected = ' selected="selected"';
						} else {
							$selected = "";
						}
						?>
						<option value="<?php echo $result->language; ?>" <?php echo $selected; ?>><?php echo $result->language; ?></option>
					<?php } ?>
				</select>
			</div>
		</form>
	</div>

	<div class="w-100 p-2">
	    <table id="translation" style="margin-top: 35px !important;width: 100% !important;" class="table-striped pt-5 w-100">

	</table>
	</div>

	<?php if (isset($translations)) { ?>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
<!--						<h3 class="box-title">Serach for text or translation</h3>-->
<!--						<div class="box-tools">-->
<!--							<form action="" method="POST" id="searchList">-->
<!--								<div class="input-group">-->
<!--									<input type="text" name="searchText" value="" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>-->
<!--									<div class="input-group-btn">-->
<!--										<button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>-->
<!--									</div>-->
<!--								</div>-->
<!--							</form>-->
<!--						</div>-->
					</div><!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tr>
								<th class="text-left">TEXT</th>
								<th class="text-left">ID</th>
								<th class="text-left">TRANSLATION</th>
<!--								<th class="text-left">Edit translation</th>-->
							</tr>
							<?php
							foreach ($translations as $translation) {
								?>
								<tr class='translate-row'>
									<td  width="20%" style="word-wrap:break-word;">
										<?php echo strip_tags("$translation->key"); ?>
									</td>
									<td  width="20px" style="word-wrap:break-word;">
										<?php echo $translation->langID; ?>
									</td>
									<td class='translation-edit-field' >
										<textarea class='edit-translation disabled' rows="4" cols="100" id="<?php echo $translation->id;?>" type="text" form="translationsForm" ><?php echo strip_tags("$translation->text"); ?></textarea>
										<a type="button" data-id="<?php echo $translation->id;?>" class="btn button-green submit-translate" value="Save" />Save</a>
										<a type="button" data-id="<?php echo $translation->id;?>" class="btn button-orange delete-translate" value="Delete" />Delete</a>
									</td>
								</tr>
							<?php }
							?>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	<?php } ?>
	</div>

<!--	<table id="translation-table" width="100%">-->
<!--        <thead>-->
<!--            <tr>-->
<!--                <th>Text</th>-->
<!--                <th>Translation</th>-->
<!--            </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!--        	<tr class='translate-row'>-->
<!--            	<td>Hotels</td>-->
<!--            	<td class='translation-edit-field'>-->
<!--					<input type="text" value='Hotels' placeholder='Hotels' class='edit-translation disabled'>-->
<!--					<input type="hidden" id="id" value="5232">-->
<!--					<button id="" type="button" class="btn btn-primary submit-translate" value="Save">Save</button>-->
<!--            	</td>-->
<!--            </tr>-->
<!--            <tr class='translate-row'>-->
<!--            	<td>Rooms</td>-->
<!--            	<td class='translation-edit-field'>-->
<!--					<input type="text" value='Rooms' placeholder='Rooms' class='edit-translation disabled'>-->
<!--					<input type="hidden" id="id" value="5232">-->
<!--					<a class="btn btn-sm btn-info" data-fancybox data-type="ajax" data-src="--><?php //echo base_url() . 'translate/getTranslation/' . $translation->id; ?><!--" href="javascript:;" title="Edit">-->
<!--						<i class="fa fa-pencil"></i>-->
<!--					</a>-->
<!--					<input type="button" id="buttonsave" class="btn btn-primary submit-translate" value="Save">Save</input>-->
<!--            	</td>-->
<!--            </tr>-->
<!--        </tbody>-->
<!--    </table>-->

</section><!-- end faq section -->

<script>
const baseUrl = '<?php echo base_url(); ?>';
	$("#language").change(function () {
		// if (confirm('Are you sure you want to load list of translations for the selected language?')) {
			//$("#translationsForm").submit();
			$("#translation").DataTable().ajax.reload();
		// }
	});
	
	$('.submit-translate').click(function(){
		$('.translation-edit-field').removeClass('active-translate');
		var id = this.dataset.id;
		var correctedTranslation = $("#" + id).val();
		if (correctedTranslation === "") {
			alert("Please make sure the corrected text is not empty!");
		} else {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url()?>translate/editTranslation/" + id,
				data: {
					correctedTranslation: correctedTranslation
				},
				success: function (response) {
					$("#text_" + id).text(correctedTranslation);
					// alert(response);
				},
				error: function (response) {
					alert(response);
				}
			});
		}
		console.log('saved translate');
	});
	
	$('.edit-translation').click(function(){
		$('.translation-edit-field').removeClass('active-translate');
		$(this).parent().addClass('active-translate')
	});


	$('.delete-translate').click(function(){
		$('.translation-edit-field').removeClass('active-translate');
		var id = this.dataset.id;
		var correctedTranslation = $("#" + id).val();
		if (correctedTranslation === "") {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url()?>translate/deleteTranslation/" + id,
				data: {
					correctedTranslation: correctedTranslation
				},
				success: function (response) {
					$("#text_" + id).text("deleted");
					window.location.reload();
					// alert(response);
				},
				error: function (response) {
					alert(response);
				}
			});


		} else {

			alert("Text needs to be empty." );

		}
		console.log('saved translate');
	});



</script>

</body></html>
