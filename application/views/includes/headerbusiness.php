<?php
$CI =& get_instance();
$CI->load->model('user_modelpublic');
$userShortUrl = $CI->user_modelpublic->getUserInfoById($this->session->userdata('userId'))->usershorturl;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $pageTitle ? $pageTitle : 'TIQS | LOST AND FOUND'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl;?>assets/css/business_dashboard/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl;?>assets/css/css/customer_style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/main-style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/font-awesome-4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
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
    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/bower_components/bootstrap-colorselector/bootstrap-colorselector.min.css"/>
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/css/business_dashboard/typography.css">
    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/css/business_dashboard/default-css.css">
    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/css/business_dashboard/styles.css">
    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/css/business_dashboard/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.css"/>
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
            color: #fff !important;
            background: #354794;
        }
        .collapse li a:hover {
            text-decoration: none;
            background: #354794;
        }
        #report_length label .form-control{
            width: 65px;
        }
        #body {
            background: #f3d0b1;
        }

    </style>
    <!-- modernizr css -->
    <script src="<?php echo $this->baseUrl; ?>assets/js/business_dashboard/jquery-2.2.4.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/js/popper.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"  type="text/javascript"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/js/modernizr-2.8.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/alertify.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/alertify.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/createKeyBoard.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/dist/js/tooltipster.bundle.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/vanilla-picker.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/cookies.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/html5shiv.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/utility.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/employeenew.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/bower_components/bootstrap-colorselector/bootstrap-colorselector.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vuejs-datepicker"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <?php
        if (isset($js) AND is_array($js)) { // ???????????  MOVE TO FOOTER IF USER CUSTOM SCRIPTS ???????????????
            foreach ($js as $jsLink) { 
            ?>
                <script src="<?php echo $jsLink ?>"></script>
            <?php
            }
        }
    ?> 


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
                        <div class="profile-name text-center"><img class="logo-img" src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogowhite.png"></div>
					    
				    </div>
                </div>
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-share"></i><span>GO TO</span></a>
                        <ul class="collapse">
                            <li><a href="<?php echo $this->baseUrl . 'make_order?vendorid=' . $this->session->userdata('userId'); ?>"><i class="ti-shopping-cart-full"></i> <span>Shop</span></a></li>
                            <li><a href="<?php echo $this->baseUrl . 'check424/' . $this->session->userdata('userId'); ?>"><i class="ti-book"></i> <span>Booking</span></a></li>
                            <li><a href="<?php echo $this->baseUrl. 'agenda_booking/' . $userShortUrl; ?>"><i class="ti-agenda"></i> <span>Agenda Booking</span></a></li>
                            <li><a href="<?php echo $this->baseUrl. 'booking_agenda/' . $userShortUrl; ?>"><i class="ti-clipboard"></i> <span>Booking Agenda</span></a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo $this->baseUrl; ?>orders"><i class="ti-stats-up"></i> <span>Orders</span></a></li>
                    <li><a href="<?php echo $this->baseUrl; ?>pos"><i class="ti-bar-chart"></i> <span>POS</span></a></li>
                    <li><a href="<?php echo $this->baseUrl;?>dashboard"><i class="ti-receipt"></i> <span>Business Report</span></a></li>
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-calendar"></i><span>Reservations</span></a>
                        <ul class="collapse">
                            <li><a href="<?php echo $this->baseUrl;?>customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Bookings & Tickets</span></a></li>
                            <li><a href="<?php echo $this->baseUrl;?>customer_panel/agenda"><i class="ti-agenda"></i> <span>Agenda Dates</span></a></li>
                            <li><a href="<?php echo $this->baseUrl; ?>customer_panel/reservations_report"><i class="ti-write"></i> <span>Reservations Report</span></a></li>
                            <li><a href="<?php echo $this->baseUrl; ?>customer_panel/report"><i class="ti-clipboard"></i> <span>Report</span></a></li>
                            <li><a href="<?php echo $this->baseUrl; ?>customer_panel/pivot"><i class="ti-bar-chart"></i> <span>Pivot</span></a></li>
                            <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Settings</span></a>
                        <ul class="collapse">
                            <li><a href="<?php echo $this->baseUrl; ?>customer_panel/settings"><i class="ti-shopping-cart-full"></i> <span>General</span></a></li>
                            <li><a href="<?php echo $this->baseUrl. 'booking_agenda/design'; ?>"><i class="ti-clipboard"></i> <span>Booking Agenda</span></a></li>
                        </ul>
                    </li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-stamp"></i><span>Profile</span></a>
                        <ul class="collapse">
                            <li><a href="#"><i class="ti-location-pin"></i> <span>Address</span></a></li>
                            <li><a href="#"><i class="ti-receipt"></i> <span>Payment Settings</span></a></li>
                            <li><a href="#"><i class="ti-shopping-cart"></i> <span>Shop Settings</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-shopping-cart-full"></i><span>Marketing</span></a>
                        <ul class="collapse">
                            <li><a href="<?php echo $this->baseUrl; ?>visitors"><i class="ti-user"></i> <span>Visitors</span></a></li>
                            <li><a href="<?php echo $this->baseUrl; ?>marketing/selection"><i class="ti-pencil-alt"></i> <span>Messaging</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-bag"></i><span>Products</span></a>
                        <ul class="collapse">
                            <li><a href="<?php echo $this->baseUrl; ?>product_categories"><i class="ti-layout-accordion-separated"></i> <span>Category</span></a></li>
                            <li><a href="<?php echo $this->baseUrl; ?>product_types"><i class="ti-layers-alt"></i> <span>Product Types</span></a></li>
                            <li><a href="<?php echo $this->baseUrl; ?>products"><i class="ti-bag"></i> <span>Products</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-ink-pen"></i><span>Design</span></a>
                        <ul class="collapse">
                            <li><a href="<?php echo $this->baseUrl; ?>emaildesigner"><i class="ti-email"></i> <span>Email</span></a></li>
                            <li><a href="<?php echo $this->baseUrl; ?>viewdesign"><i class="ti-shopping-cart"></i> <span>Store</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i><span>Settings</span></a>
                        <ul class="collapse">
                            <li><a href="<?php echo $this->baseUrl; ?>employee"><i class="ti-user"></i> <span>Employee</span></a></li>
                            <li><a href="<?php echo $this->baseUrl; ?>profile"><i class="ti-stamp"></i> <span>Profile</span></a></li>
                            <li><a href="<?php echo $this->baseUrl; ?>printers"><i class="ti-printer"></i> <span>Printers</span></a></li>
                            <li><a href="<?php echo $this->baseUrl; ?>spots"><i class="ti-flag-alt"></i> <span>Spots</span></a></li>
                            <li><a href="<?php echo $this->baseUrl; ?>visma/config"><i class="ti-credit-card"></i> <span>Visma Accounting</span></a></li>
                            <li><a href="http://localhost/tiqsbox/index.php/Admin"><i class="ti-package"></i> <span>Tiqsbox</span></a></li>
                        </ul>
                    </li>
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
						<div id="collapse-item" class="col-md-12 col-sm-12 clearfix">
							<div class="nav-btn pull-left">
								<span></span>
								<span></span>
								<span></span>
							</div>
                            <div id="user-title" class="pull-left">
								<p style="weight: 100; font-size: 100%;padding-top:10px;color: #000;"><?php echo $this->session->userdata('userId');?> <?php echo $this->session->userdata('name');?></p>
							</div>
							<div id="search-box" class="search-box pull-right">
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

    var myInterval = setInterval(function () {
        let header = $(".header-area").width();
        let collapse = 45;
        let title = $("#user-title").width();
        let search_box = header - (collapse+title);
        if(search_box < 240){
            $("#search-box").css('width',search_box);
            $("#search-box input").css('width',search_box);
        }
        clearInterval(myInterval);
     }, 1);
    $( window ).resize(function() {
        let header = $(".header-area").width();
        let collapse = 45;
        let title = $("#user-title").width();
        let search_box = header - (collapse+title);
        console.log(search_box);
        if(search_box < 240){
            $("#search-box").css('width',search_box);
            $("#search-box input").css('width',search_box);
        }

    });
</script>

