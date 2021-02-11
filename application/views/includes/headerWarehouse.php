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
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/jquery-ui.min.css" />
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
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/alertify_default.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/keyboard.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/virtual-keyboard/1.30.2/css/keyboard-basic.min.css" integrity="sha512-2bVDVxlsH8oY3RrNeI1uJOAXWmjfEwQ9/dfJ/XM4dG5w8R3W3vSTQccpkzJWndrRo2HNXkiM4tjikPCp111sQg==" crossorigin="anonymous" />
    
    <?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>
    <style>
	    #myModal {
            overflow: scroll;
        }     
        #myModal a {
            color: #352104;
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
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/createKeyBoard.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/virtual-keyboard/1.30.2/js/jquery.keyboard.min.js" integrity="sha512-xESyr+sfDsQTzCsSU5GVQyi5SUL/hJmqs3CVUd97QegEM5EnENVaJoX2kS2XeZxNDMsMrUZg38PHqP2M5AM2zg==" crossorigin="anonymous"></script>
</head>
<body>
    <header class="header">
        <nav class="header-nav">
			<a href="<?php echo $this->baseUrl; ?>loggedin" class="nav-logo">
                <img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
                <div><?php echo $_SESSION['userId']." ".$_SESSION['name'];
					// var_dump($_SESSION);

					?></div>
            </a>
            <div class="header-menu text-orange" id="header-menu">
				<?php
                $switchfinance = 1;

				if ($_SESSION['userId'] === '1162' ){
					$switchfinance = 0;
				}
				?>

				<?php
				if($_SESSION['userId'] === '5655' ){
					$switchfinance = 0;
				}
				?>

				<?php
				if($switchfinance === 1 ){
				?>
				<a href="<?php echo $this->baseUrl; ?>businessreport"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/vatdashboardnew.png" title="FINANCIAL"/></a>
<!--				<a href="--><?php //echo $this->baseUrl; ?><!--dayreport"><img width="30px" height="30px" src="--><?php //echo $this->baseUrl; ?><!--assets/home/images/dashboardnew.png" title="DASHBOARD"/></a>-->
				<?php
				}
				?>


<!--				<a href="--><?php //echo $this->baseUrl; ?><!--warehouse"><img width="30px" height="30px" src="--><?php //echo $this->baseUrl; ?><!--assets/home/images/reports.png" title="REPORTS"/></a>-->
                <a href="<?php echo $this->baseUrl; ?>product_categories"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/category.png" title="CATEGORY"/></a>
                <a href="<?php echo $this->baseUrl; ?>product_types"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/types.png" title="TYPES"/></a>
                <a href="<?php echo $this->baseUrl; ?>products"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/products.png" title="PRODUCTS"/></a>
                <a href="<?php echo $this->baseUrl; ?>orders"><img width="40px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/qrorder.png" title="ORDERS"/></a>
                <a href="<?php echo $this->baseUrl; ?>printers"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/print.png" title="PRINTERS"/></a>
                <a href="<?php echo $this->baseUrl; ?>spots"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/spot.png" title="SPOTS"/></a>
                <a href="<?php echo $this->baseUrl; ?>visitors"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/person.png" title="VISITORS"/></a>
                <?php if ($_SESSION['activatePos'] === '1') { ?>
                    <a href="<?php echo $this->baseUrl; ?>pos">POS</a>
                <?php } ?>
                <a href="<?php echo $this->baseUrl; ?>loggedin"><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/back.png" title="BACK"/></a>
            </div>
            <div class="hamburger-menu" id="hamburger-menu">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </nav>
    </header>
