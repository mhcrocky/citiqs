<!DOCTYPE html>
<html lang="<?php echo $_SESSION['site_lang']; ?>">
	<head>
		<title><?php echo $pageTitle ? $pageTitle : 'TIQS | LOST AND FOUND'; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<meta charset="UTF-8" />
		<script src="<?php echo $this->baseUrl; ?>assets/home/js/jspdf.min.js"></script>

		<link rel="shortcut icon" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/bower_components/font-awesome/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/main-style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/grid.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/tiqsballoontip.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/tiqscss.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/clstylesheet.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/cbstylesheet.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/cookie.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/how-it-works.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/home-page.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/dist/css/AdminLTE.css" />




		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" integrity="sha256-PZLhE6wwMbg4AB3d35ZdBF9HD/dI/y4RazA3iRDurss=" crossorigin="anonymous" />
		<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
		<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/alertify.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>alertify_default.min.css" />
		<?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
		<script src="<?php echo $this->baseUrl; ?>assets/cdn/js/html5shiv.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha256-P93G0oq6PBPWTP1IR8Mz/0jHHUpaWL0aBJTKauisG7Q=" crossorigin="anonymous"></script>
		<script src="<?php echo $this->baseUrl; ?>assets/dist/js/tooltipster.bundle.min.js"></script>
		<script src="<?php echo $this->baseUrl; ?>assets/home/js/vanilla-picker.js"></script>
		<script src="<?php echo $this->baseUrl; ?>assets/home/js/cookies.js"></script>
		<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>


		<script src="<?php echo $this->baseUrl; ?>assets/home/js/alertify.js"></script>
		<script src="<?php echo $this->baseUrl; ?>assets/home/js/scriptonboard.js"></script>

		<!-- <script src="<?php #echo $this->baseUrl; ?>assets/home/js/luxon.js"></script> -->
		<script src="<?php echo $this->baseUrl; ?>assets/cdn/js/alertify.min.js"></script>
		<script src="<?php echo $this->baseUrl; ?>assets/home/js/alertify.js"></script>


		<style>
			.bd-placeholder-img {
				font-size: 1.125rem;
				text-anchor: middle;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
			}

			@media (min-width: 768px) {
				.bd-placeholder-img-lg {
					font-size: 3.5rem;
				}
			}



		</style>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/bizdirstyle.css" />
		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
			  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<!-- Favicons -->
		<link rel="icon" href="<?php echo base_url() ?>assets/images/favicon.png" type="image/png">

		<!-- Fontawesome -->
		<link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">

		<!-- Google Font -->
		<link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
	</head>

	<?php if ($this->view === 'map') {?>
	<body onload="getLocation()">
	<?php } else { ?>
	<body>


	<?php } ?>

	<header class="header">
		<nav class="header-nav" style="background-color: #0d173b">
			<a href="<?php echo base_url(); ?>start" class="nav-logo">
				<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="">
			</a>
			<div class="header-menu" id="header-menu" align="right" style="background: #0d173b">
<!--				<a style="color: #FFFFFF; background: #0d173b" href="--><?php //echo $this->baseUrl; ?><!--home#dhl-section" id='dhl-button'></a>-->
<!--				<a style="color: #FFFFFF; background: #0d173b" href="--><?php //echo $this->baseUrl; ?><!--found"></a>-->
<!--				<a style="color: #FFFFFF; background: #0d173b" href="--><?php //echo $this->baseUrl; ?><!--check424"></a>-->
				<a style="color: #FFFFFF; background: #0d173b" href="#" id='modal-button'>SELECT LANGUAGE </a>
				<a style="color: #FFFFFF; background: #0d173b" href="<?php echo $this->baseUrl; ?>registerbusiness"><?php echo $this->language->Line("BIZDIR-MENU001","REGISTER YOUR BUSINESS");?></a>
				<a style="color: #FFFFFF; background: #0d173b" href="<?php echo $this->baseUrl; ?>login">LOGIN</a>
			</div>
			<div class="hamburger-menu" id="hamburger-menu">
				<div></div>
				<div></div>
				<div></div>
			</div>
		</nav>
	</header>
	<div id="top" >
		<!--	<a  ></a>-->
		.
	</div>


