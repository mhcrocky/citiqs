<!DOCTYPE html>
<html lang="<?php echo $_SESSION['site_lang']; ?>">
<head>
    <title><?php echo $pageTitle ? $pageTitle : 'tiqs | lost and found'; ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="shortcut icon" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/bower_components/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/main-style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/how-it-works.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/home-page.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/grid.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/tiqsballoontip.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/tiqscss.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/clstylesheet.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/cbstylesheet.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/cookie.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

    <?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>
    <style>
	    #myModal {
            overflow: scroll;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/html5shiv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/dist/js/tooltipster.bundle.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/vanilla-picker.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/cookies.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha256-P93G0oq6PBPWTP1IR8Mz/0jHHUpaWL0aBJTKauisG7Q=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/alertify.js"></script> 
</head>
<?php if ($this->view === 'map') {?>
<body onload="getLocation()">
<?php } else { ?>
<body>
<?php } ?>
   <header class="header">
        <nav class="header-nav">
            <a href="https://tiqs.com" class="nav-logo">	
                <img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
                <div></div>
            </a>
<!--			--><?php
//			$this->load->model('user_model');
//			$userinfo = $this->user_model->getUserInfo($this->session->userId);
//			?><!-- <div style="color:orange">-->
<!--				 --><?php //echo $userinfo->name ?>
<!--			</div>-->
            <div class="header-menu text-orange" id="header-menu">
                <!-- only drop off point -->

                <?php if ($this->session->userdata('dropoffpoint') == 1) { ?>
                    <a href="<?php echo $this->baseUrl; ?>lostandfoundlist">LOST + FOUND</a>
					<a href="<?php echo $this->baseUrl; ?>profile">PROFILE/PACKAGE</a>
					<!-- <a href="--><?php //echo $this->baseUrl; ?><!--home#dhl-section" id='dhl-button'>DHL</a>-->
					<a href="<?php echo $this->baseUrl; ?>settingsmenu">SETTINGS</a>
					<a href="<?php echo $this->baseUrl; ?>logout">LOGOUT</a>
					<a href="<?php echo $this->baseUrl; ?>help">HELP</a>
                <?php } ?>
            </div>
            <div class="hamburger-menu" id="hamburger-menu">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </nav>
    </header>
