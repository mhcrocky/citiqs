<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['site_lang']; ?>">
<head>
    <title>
        <?php echo $pageTitle ? $pageTitle : 'TIQS | ALFRED'; ?>
    </title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/bootstrap.min.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/bower_components/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/flatpickr.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/main-style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/how-it-works.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/home-page.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/grid.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/tiqsballoontip.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/tiqscss.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/clstylesheet.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/cbstylesheet.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/cookie.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/magnific-popup.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/alertify.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>alertify_default.min.css" />
    <?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>
    <style>
	    #myModal {
            overflow: scroll;
        }
    </style>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/jquery.min.js"></script> 
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/jquery-ui.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/popper.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/owl.carousel.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/html5shiv.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/flatpickr.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/respond.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/dist/js/tooltipster.bundle.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/vanilla-picker.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/cookies.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/alertify.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/alertify.js"></script>    
</head>
<body>
   <header class="header">
        <nav class="header-nav">
			<a href="<?php echo $this->baseUrl; ?>loggedin" class="nav-logo">
                <img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
                <div></div>
            </a>
            <div class="header-menu text-orange" id="header-menu">
                <a href="<?php echo $this->baseUrl; ?>warehouse"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/reports.png" title="REPORTS"/></a>
                <a href="<?php echo $this->baseUrl; ?>product_categories"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/category.png" title="CATEGORY"/></a>
                <a href="<?php echo $this->baseUrl; ?>product_types"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/types.png" title="TYPES"/></a>
                <a href="<?php echo $this->baseUrl; ?>products"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/products.png" title="PRODUCTS"/></a>
                <a href="<?php echo $this->baseUrl; ?>orders"><img width="40px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/qrorder.png" title="ORDERS"/></a>
                <a href="<?php echo $this->baseUrl; ?>printers"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/print.png" title="PRINTERS"/></a>
                <a href="<?php echo $this->baseUrl; ?>spots"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/spot.png" title="SPOTS"/></a>
                <a href="<?php echo $this->baseUrl; ?>visitors"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/person.png" title="VISITORS"/></a>
                <a href="<?php echo $this->baseUrl; ?>loggedin"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/back.png" title="BACK"/></a>
            </div>
            <div class="hamburger-menu" id="hamburger-menu">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </nav>
    </header>
