<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['site_lang']; ?>">
<head>
    <title>
        <?php echo $pageTitle ? $pageTitle : 'TIQS | SHOP'; ?>
    </title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" integrity="sha256-PZLhE6wwMbg4AB3d35ZdBF9HD/dI/y4RazA3iRDurss=" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>
    <style>
	    #myModal {
            overflow: scroll;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/dist/js/tooltipster.bundle.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/vanilla-picker.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/cookies.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha256-P93G0oq6PBPWTP1IR8Mz/0jHHUpaWL0aBJTKauisG7Q=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/alertify.js"></script>    
</head>
<body>
   <header class="header">
        <nav class="header-nav">
			<a href="<?php echo $this->baseUrl; ?>lostandfoundlist" class="nav-logo">
                <img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
                <div></div>
            </a>
            <div class="header-menu text-orange" id="header-menu">
                <a href="<?php echo $this->baseUrl; ?>warehouse">WAREHOUSE</a>
                <a href="<?php echo $this->baseUrl; ?>product_categories">PRODUCT CATEGORIES</a>
                <a href="<?php echo $this->baseUrl; ?>product_types">PRODUCT TYPES</a>
                <a href="<?php echo $this->baseUrl; ?>products">PRODUCTS</a>
                <a href="<?php echo $this->baseUrl; ?>orders">ORDERS</a>
                <a href="<?php echo $this->baseUrl; ?>printers">PRINTERS</a>
                <a href="<?php echo $this->baseUrl; ?>spots">SPOTS</a>
                <a href="<?php echo $this->baseUrl; ?>visitors">VISITORS</a>
                <a href="<?php echo $this->baseUrl; ?>loggedin">BACK</a>
            </div>
            <div class="hamburger-menu" id="hamburger-menu">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </nav>
    </header>
