<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $pageTitle ? $pageTitle : 'TIQS | LOST AND FOUND'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl;?>assets/css/business_dashboard/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/main-style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/font-awesome-4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/metisMenu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/slicknav.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/main-style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/grid.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/tiqscss.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/clstylesheet.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/cbstylesheet.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/tiqsballoontip.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/magnific-popup.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/alertify.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/alertify_default.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/keyboard.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/business_dashboard/typography.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/business_dashboard/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/business_dashboard/styles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/business_dashboard/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.css"/>

    <?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>
    <?php include_once FCPATH . 'application/views/includes/jsGlobalVariables.php'; ?>

    
    <style>
	    #myModal {
            overflow: scroll;
        }     
        #myModal a {
            color: #352104;
        }
        .logo-img {
            height: 55px;
            
        }
        .header-area {
            background: #d5612f !important;
        }
        .page-title-area {
            background: #efd1ba !important;
        }
        .main-content {
           background: #f3d0b1 !important;
        }
        .main-menu,.sidebar-header {
            background:#496083 !important;
        }
        .footer-area {
            background: #efd1ba !important; 
        }
        .card, .card-title {
            font-size: medium !important;
        }
        .toast-message { 
            font-size: 15px; 
        }
        .btnBack {
            font-size : 12px !important;
        }
        #menu li a:hover {
            text-decoration: none;
        }
        #report_length label .form-control{
            width: 65px;
        }

    </style>
    <!-- modernizr css -->
    <script src="<?php echo $this->baseUrl; ?>assets/js/business_dashboard/jquery-2.2.4.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/js/modernizr-2.8.3.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/flatpickr.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/alertify.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/alertify.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/keyboard.js"></script> 
    <script src="<?php echo $this->baseUrl; ?>assets/dist/js/tooltipster.bundle.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/vanilla-picker.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/cookies.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/html5shiv.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/products.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/products.js"></script> 


<style type="text/css">/* Chart.js */
@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style><style type="text/css" data-author="zingchart">
</style>
</head>
<body id="body">
<div class="page-container">

<!-- Sidebar --> 

<div class="sidebar-menu">
    <div class="main-menu ">
        <div class="slimScrollDiv " style="position: relative; overflow:hidden; width: auto; height: 654px;">
        <div class="menu-inner" style="width: auto; height: 654px; overflow-x: auto;">
            <nav>
                <ul class="metismenu" id="menu">
                <div class="sidebar-header">
                    <div class="profile">
                        <div class="profile-name text-center"><img class="logo-img" src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png"></div>
					    
				    </div>
			    </div>
                <!--<li><img class="logo-img" src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png"></li>
                <hr>-->
                    <li><a href="<?php echo $this->baseUrl;?>Businessreport"><i class="ti-receipt"></i> <span>Business Report</span></a></li>
                    <li><a href="<?php echo $this->baseUrl; ?>product_categories"><i class="ti-layout-accordion-separated"></i> <span>Category</span></a></li>
                    <li><a href="<?php echo $this->baseUrl; ?>product_types"><i class="ti-layers-alt"></i> <span>Types</span></a></li>
                    <li><a href="<?php echo $this->baseUrl; ?>products"><i class="ti-bag"></i> <span>Products</span></a></li>
                    <li><a href="<?php echo $this->baseUrl; ?>orders"><i class="ti-stats-up"></i> <span>Orders</span></a></li> 
                    <li><a href="<?php echo $this->baseUrl; ?>printers"><i class="ti-printer"></i> <span>Printers</span></a></li>
                    <li><a href="<?php echo $this->baseUrl; ?>spots"><i class="ti-flag-alt"></i> <span>Spots</span></a></li>
                    <li><a href="<?php echo $this->baseUrl; ?>visitors"><i class="ti-user"></i> <span>Visitors</span></a></li>
                    <li><a href="<?php echo $this->baseUrl; ?>logout"><i class="ti-shift-left"></i> <span>Logout</span></a></li>
                </ul>
            </nav>
        </div><div class="slimScrollBar" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 440.037px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div></div>
    </div>
</div>

<!-- End Sidebar -->


<!-- Main Content -->

<div class="main-content" style="min-height: 286px;background: #efd1ba;">


<!-- Main Header -->

            <div class="header-top">
				<div class="header-area">
					<div class="row align-items-center">
						<!-- nav and search button -->
						<div class="col-md-6 col-sm-8 clearfix">
							<div class="nav-btn pull-left">
								<span></span>
								<span></span>
								<span></span>
							</div>
							<div class="search-box pull-left">
								<form action="#">
									<input style="background: white;font-size:14px !important;font-family: inherit !important;" type="text" name="search" placeholder="Search..." required="">
									<i class="ti-search"></i>
								</form>
							</div>
						</div>
						<!-- profile info & task notification -->
						
					</div>
				</div>
				<!-- header area end -->
				<!-- page title area start -->
				<div class="page-title-area" style="background: #efd1ba !important;">
					<div class="row align-items-center">
						<div class="col-sm-12">
							<div class="breadcrumbs-area clearfix">
								<h4 class="page-title pull-left">Dashboard</h4>
								<ul class="breadcrumbs pull-left">
									<li><a href="<?php echo base_url(); ?>dashboard">Dashboard</a></li>
									<li><span><?php $title = ($pageTitle == 'Dashboard') ? 'Home' : $pageTitle; echo $title; ?></span></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
            </div>
            <script>
	$("#dhl-button").click(function() {
		$('html,body').animate(
			{scrollTop: $("#dhl-section").offset().top},
			'slow'
		);
	});

	$("#who-button").click(function() {
		$('html,body').animate(
			{scrollTop: $("#who-section").offset().top},
			'slow'
		);
	});

	$("#how-button").click(function() {
		$('html,body').animate(
			{scrollTop: $("#how-section").offset().top},
			'slow'
		);
	});

	$("#packages-button").click(function() {
		$('html,body').animate(
			{scrollTop: $("#packages-section").offset().top},
			'slow'
		);
	});

	$("#hit-button").click(function() {
		$('html,body').animate(
			{scrollTop: $("#hit-section").offset().top},
			'slow'
		);
	});
</script>

