<!DOCTYPE html>
<html lang="<?php echo $_SESSION['site_lang']; ?>">

<head>
	<title><?php echo $pageTitle ? $pageTitle : 'TIQS | LOST AND FOUND'; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta charset="UTF-8" />
<!--	<script src="--><?php //echo $this->baseUrl; ?><!--assets/home/js/jquery.min.js"></script>-->
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/jspdf.min.js"></script>

	<link rel="shortcut icon" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/bower_components/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/main-style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/grid.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/tiqsballoontip.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/tiqscss.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/toastr3.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/clstylesheet.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/cbstylesheet.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/cookie.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/how-it-works.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/home-page.css" />
	<?php if(current_url() == base_url('booking_agenda/') || current_url() == base_url('booking_agenda/') || current_url() == base_url('booking_agenda/index') || current_url() == base_url('booking_agenda/index/')): ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/dist/css/AdminLTE.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/styleonboard.css"/>
	<?php endif; ?>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" integrity="sha256-PZLhE6wwMbg4AB3d35ZdBF9HD/dI/y4RazA3iRDurss=" crossorigin="anonymous" />
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
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

	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/hotel-page.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/timeline-page.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/registerbusiness.css">

	<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window, document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '944700975992089');
		fbq('track', 'PageView');
	</script>

</head>
<?php if ($this->view === 'map') {?>
<body onload="getLocation()">
<?php } else { ?>
<body>
<noscript>
	<img
		height="1"
		width="1"
		style="display:none"
		src="https://www.facebook.com/tr?id=944700975992089&ev=PageView&noscript=1"
		alt="facebook pixel"
	/>
</noscript>

<?php } ?>
<header class="header">
	<nav class="header-nav">
<!--		<a href="--><?php //echo base_url(); ?><!--thuishaven" class="nav-logo">-->
<!--			<img src="--><?php //echo base_url(); ?><!--assets/home/images/thuishaven.png" alt="">-->
<!--		</a>-->
		<div class="header-menu" id="header-menu" style="text-align:right">

			<a style="color: #E25F2A" href="<?php echo $this->baseUrl; ?>home#dhl-section" id='dhl-button'></a>
			<a style="color: #E25F2A" href="<?php echo $this->baseUrl; ?>found"></a>
			<a style="color: #E25F2A" href="https://tiqs.com/spot/pay424" ></a>
			<a style="color: #E25F2A" href="<?php echo $this->baseUrl; ?>check424"></a>
			<a style="color: #E25F2A" href="<?php echo $this->baseUrl; ?>info_check424"></a>
			<a style="color: #E25F2A" href="#" id='modal-button'>choose your language</a>

		</div>
		<div class="hamburger-menu" id="hamburger-menu">
			<div></div>
			<div></div>
			<div></div>
		</div>
	</nav>
</header>
<div id="top" >

</div>
