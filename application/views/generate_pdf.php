<!DOCTYPE html>
<html>
<head>


</head>


<body style="opacity: 0">
    <div id="HTMLtoPDF">
	    <?php echo $mailtemplate; ?>
    </div>


    <script src="<?php echo base_url(); ?>assets/js/html2pdf/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/html2pdf/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/html2pdf/kendo.all.min.js"></script>
	<script>
	(function() {
		ExportPdf();
		
	}());

	function ExportPdf(params) {
		kendo.drawing
		.drawDOM('#HTMLtoPDF', {
			paperSize: "A4",
			margin: {top: "1cm", bottom: "1cm", right: "1cm", left: "1cm"},
			scale: 0.8,
			height: 500
		})
		.then(function(group){
			kendo.drawing.pdf.saveAs(group, "Reservation.pdf");
		});
	}
	</script>

</body>
</html>


