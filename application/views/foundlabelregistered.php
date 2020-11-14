<!DOCTYPE html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<style type="text/css">
	input[type="checkbox"] {
		zoom: 3;
	}

	@media screen and (max-width: 680px) {
		.columns .column {
			flex-basis: 100%;
			margin: 0 0 5px 0;
		}
	}

	.selectWrapper {
		border-radius: 50px;
		overflow: hidden;
		background: #eec5a7;
		border: 0px solid #ffffff;
		padding: 5px;
		margin: 0px;
	}

	.selectBox {
		background: #eec5a7;
		width: 100%;
		height: 25px;
		border: 0px;
		outline: none;
		padding: 0px;
		margin: 0px;
	}
</style>

<script>

	function myFunction(str) {
		$(document).ready(function() {
			$.get("<?php echo base_url('index.php/ajax/users/'); ?>" + encodeURIComponent(str), function(data) {
				var result = JSON.parse(data);
				// var result1 = JSON.parse(data);
				// var myJSON = JSON.stringify(data);
				// document.write(result);
				// document.write(result1);
				// document.write(myJSON);
				// document.write(result.username);
				//$.each(result, function (i, item) {
				$('#myTable tbody').append('<tr><td>' + result.username + '</td><td>' + result.email + '</td></tr>');
				if (result.username == true) {
					document.getElementById("UnkownAddressText").style.display = "block";
					document.getElementById("name").style.display = "block";
					document.getElementById("address").style.display = "block";
					document.getElementById("addressa").style.display = "block";
					document.getElementById("zipcode").style.display = "block";
					document.getElementById("city").style.display = "block";
					document.getElementById("country").style.display = "block";
					document.getElementById("country1").style.display = "block";
				}
			});
		});
	}

	function myFunctionBrand(str) {
		$(document).ready(function() {
			$.get("<?php echo base_url('index.php/ajax/users/'); ?>" + encodeURIComponent(str), function(data) {
				var result = JSON.parse(data);
				// var result1 = JSON.parse(data);
				// var myJSON = JSON.stringify(data);
				// document.write(result);
				// document.write(result1);
				// document.write(myJSON);
				// document.write(result.username);
				//$.each(result, function (i, item) {
				$('#myTable tbody').append('<tr><td>' + result.username + '</td><td>' + result.email + '</td></tr>');
				if (result.username == true) {
					document.getElementById("brandUnkownAddressText").style.display = "block";
					document.getElementById("brandname").style.display = "block";
					document.getElementById("brandaddress").style.display = "block";
					document.getElementById("brandaddressa").style.display = "block";
					document.getElementById("brandzipcode").style.display = "block";
					document.getElementById("brandcity").style.display = "block";
					document.getElementById("brandcountry").style.display = "block";
					document.getElementById("brandcountry1").style.display = "block";
				}
			});
		});
	}

</script>
<style>
	form{
		margin:auto;
		padding-left: 5px;
		padding-right: 5px;
	}
	textarea, select, #submit{
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
	}

	.fileContainer {
		overflow: hidden;
		position: relative;
	}

	.fileContainer [type=file] {
		cursor: inherit;
		min-height: 100%;
		min-width: 100%;
		opacity: 0;
		position: absolute;
		right: 0;
		text-align: right;
		top: 0;
	}

	.fileContainer {
		height:45px;
		width:200px;
		border:0px solid #e25f2a;
		border-radius:50px;
		background-color:transparent;
		font-size:14px;

		color: #4e696a;
		background-color: white;
		/*padding-left: 21px;*/
		/*padding-right: 21px;*/
		padding-top: 12px;
		/*padding-bottom: 5px;*/
	}

	.fileContainer :hover {

		background-color: #1b7e5a;


	}

	.fileContainer [type=file] {
		cursor: pointer;
	}

	.file{
		width: 100px;
		height: 100px;
		text-align: center;
	}

	.main-wrapper .fileContainer:hover{
		text-decoration: none;
		color: #ffffff;
		background-color: rgb(78, 105, 106);
	}

</style>
<body>
<div class="main-wrapper">
	<div class="col-half background-blue height align-left">
		<div class="flex-column align-start width-650">
			<div align="left" >
<!--				Claime your reward-->
				<div class="width-650">
					<!--        HERE THE UPLOAD ID SCREEN-->
					<h2 style="color:#ffffff; margin-bottom: 30px"  class="heading"><?php echo $this->language->line("PHOTO-101010",'GET YOUR REWARD');?></h2>
					<div >
						<p id="UnkownAddressText" style="font-family:'caption-light'; font-size:100%; color:#ffffff;  text-align: left">
							<?php echo $this->language->line("PHOTO-15550",'WE APPRECIATE YOUR EFFORT!')?>
							<?php echo $this->language->line("PHOTO-15560",'
                                <br/><br/>AS YOU HAVE REGISTERED THE ITEM AT TIQS LOST + FOUND, WE WOULD LIKE TO REWARD YOUR EFFORTS.
                                <br/> YOU RECIEVE FROM US A FREE PACKAGE OF TIQS-TAGS STICKERS TO USE FOR YOURSELF OR AS A GIVE AWAY TO YOUR FRIENDS OR RELATIVES.
                                BESIDES THE RECEIPT OF THIS FREE PACKAGE ON THE GIVEN PERSONAL ADDRESS, YOU ALSO GET 3 MONTHS OF FREE SMS NOTIFICATIONS!   
                                WE REALLY APPRECIATE YOUR EFFORT AND LOVE TO BRING THE LOST ITEM BACK TO THE RIGHTFUL OWNER. 
                                ');?>
							<br/><br/>
							<?php echo $this->language->line("PHOTO-25560",'
                                <br/><br/>READ IN THE FREQUENTLY ASKED QUESTIONS MORE ABOUT THE LOST + FOUND PROCEDURE
                                ');?>
						</p>
					</div>
					<div>
						<a style="color:#ffffff" class='how-we-works-link' href="<?php echo base_url(); ?>howitworksbusiness"><?php echo $this->language->line('Home-002','MORE INFO HOW IT WORKS');?></a>
					</div>
					<div align="center" >
						<a href="<?php echo base_url(); ?>check" class="button button-orange mb-35"><?php echo $this->language->line("PHOTO-10280",'GET YOUR REWARD');?></a>

					</div>
					<p style="color:#ffffff" class="text-content mb-50"><?php echo $this->language->line("ITEMFOUND-1110",'lost by you, <br> returned by us');?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-half " align="left">
		<div class="background-yellow height-75">
			<div class="width-650">
				<!--        HERE THE UPLOAD ID SCREEN-->
				<h2 style="color:#ffffff; margin-bottom: 30px"  class="heading"><?php echo $this->language->line("PHOTO-101010",'GET YOUR REWARD');?></h2>
				<div >
					<p id="UnkownAddressText" style="font-family:'caption-light'; font-size:100%; color:#ffffff;  text-align: left">
						<?php echo $this->language->line("PHOTO-15550",'WE APPRECIATE YOUR EFFORT!')?>
						<?php echo $this->language->line("PHOTO-15560",'
                                <br/><br/>AS YOU HAVE REGISTERED THE ITEM AT TIQS LOST + FOUND, WE WOULD LIKE TO REWARD YOUR EFFORTS.
                                <br/> YOU RECIEVE FROM US A FREE PACKAGE OF TIQS-TAGS STICKERS TO USE FOR YOURSELF OR AS A GIVE AWAY TO YOUR FRIENDS OR RELATIVES.
                                BESIDES THE RECEIPT OF THIS FREE PACKAGE ON THE GIVEN PERSONAL ADDRESS, YOU ALSO GET 3 MONTHS OF FREE SMS NOTIFICATIONS!   
                                WE REALLY APPRECIATE YOUR EFFORT AND LOVE TO BRING THE LOST ITEM BACK TO THE RIGHTFUL OWNER. 
                                ');?>
						<br/><br/>
						<?php echo $this->language->line("PHOTO-25560",'
                                <br/><br/>READ IN THE FREQUENTLY ASKED QUESTIONS MORE ABOUT THE LOST + FOUND PROCEDURE
                                ');?>
					</p>
				</div>
				<div>
					<a style="color:#ffffff" class='how-we-works-link' href="<?php echo base_url(); ?>howitworksbusiness"><?php echo $this->language->line('Home-002','MORE INFO HOW IT WORKS');?></a>
				</div>
				<div align="center" >
					<a href="<?php echo base_url(); ?>check" class="button button-orange mb-35"><?php echo $this->language->line("PHOTO-10280",'GET YOUR REWARD');?></a>

				</div>
				<p style="color:#ffffff" class="text-content mb-50"><?php echo $this->language->line("ITEMFOUND-1110",'lost by you, <br> returned by us');?></p>
			</div>
		</div>
		<div class="background-apricot height-50">
			<div class="width-650">
				<!--        HERE THE UTILITY BILL PROOF OF CONCEPT SCREEN-->
				<h2 class="heading mb-35"><?php echo $this->language->line("ITEMFOUND-1111",'UPLOAD UTILITY BILL');?></h2>
			</div>
		</div>
	</div><!-- end col half -->
</div>
</body>

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

