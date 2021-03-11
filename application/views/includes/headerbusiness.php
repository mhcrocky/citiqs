<?php
$userShortUrl = $this->session->userdata('userShortUrl');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $pageTitle ? $pageTitle : 'TIQS'; ?></title>
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
            background: #efd1ba !important;
            }
            .main-menu,.sidebar-header {
                background:#496083 !important;
            }
            .footer-area {
                background: #cacaca !important;
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
                background: #ffffff;
            }
            .dash-active {
                background: rgba(0,0,0, .1) !important; 
            }

			.table {
			background-color: whitesmoke;
			}


        </style>
        <?php if($this->session->userdata('menuOptions')): ?>
        
        <style>
            [data-menuid] {
                display: none;
            }
            
            <?php $menuOptions = array_unique($this->session->userdata('menuOptions'));
                  foreach($menuOptions as $menuOption): ?>
            [data-menuid="<?php echo $menuOption; ?>"] {
                display: block !important;
            }
            <?php endforeach; ?>
        </style>
        
        <?php endif; ?>
        <!-- modernizr css -->
        <script src="<?php echo $this->baseUrl; ?>assets/js/business_dashboard/jquery-2.2.4.min.js"></script>
        <script src="<?php echo $this->baseUrl; ?>assets/js/popper.min.js"></script>
        <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
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
        <script src="<?php echo $this->baseUrl; ?>assets/bower_components/bootstrap-colorselector/bootstrap-colorselector.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script src="https://unpkg.com/vuejs-datepicker"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.umd.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
        <script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js" ></script>
        <script src="<?php echo $this->baseUrl; ?>assets/home/js/objectFloorPlans.js" ></script>
		<script src="<?php echo $this->baseUrl; ?>assets/home/js/languageModal.js"></script>
        <?php
            if (isset($js) AND is_array($js)) { // ???????????  MOVE TO FOOTER IF USER CUSTOM SCRIPTS ???????????????
                foreach ($js as $jsLink) { 
                ?>
                    <script src="<?php echo $jsLink ?>"></script>
                <?php
                }
            }
        ?>
        <style>/* Chart.js */
            @-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}
        </style>
        <style data-author="zingchart">
        </style>
    </head>
    <body id="body" style="background-color: #efd1ba">
        <div class="page-container">
            <!-- Sidebar -->
            <div class="sidebar-menu">
                <div class="main-menu ">
                    <div class="slimScrollDiv " style="position: relative; overflow:hidden; width: auto; height: 654px;">
                        <div class="menu-inner" style="width: auto; height: 654px; overflow-x: auto;">
                            <nav>
                                <div class="sidebar-header">
                                    <div class="profile">
                                        <div class="profile-name text-center">
                                            <img class="logo-img" src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogowhite.png" alt="logo">
                                        </div>                            
                                    </div>
                                </div>
                                <ul class="metismenu" id="menu">

									
									
									<li data-menuid="1"><a href="<?php echo $this->baseUrl;?>dashboard"><i class="ti-receipt"></i><span>Dashboard</span></a></li>
									

									<li data-menuid="2">
										<a href="javascript:void(0)" aria-expanded="true"><i class="ti-shopping-cart-full"></i><span>Marketing & Loyalty</span></a>
										<ul class="collapse">
											<li data-menuid="2.1"><a href="<?php echo $this->baseUrl; ?>marketing/targeting"><i class="ti-pencil-alt"></i><span>Targeting</span></a></li>
											<li data-menuid="2.2"><a href="<?php echo $this->baseUrl; ?>marketing/selection"><i class="ti-pencil-alt"></i> <span>Notification Messaging</span></a></li>
<!--											<li data-menuid="2.3"><a href="--><?php //echo $this->baseUrl; ?><!--dashboard"><i class="ti-user"></i> <span>RSVP Pre-register</span></a></li>-->
<!--											<li data-menuid="2.4"><a href="--><?php //echo $this->baseUrl; ?><!--dashboard"><i class="ti-pencil-alt"></i> <span>E-mail Campaigns</span></a></li>-->
<!--											<li data-menuid="2.5"><a href="--><?php //echo $this->baseUrl; ?><!--visitors"><i class="ti-user"></i> <span>Visitors</span></a></li>-->
											<li data-menuid="2.6"><a href="<?php echo $this->baseUrl; ?>voucher/index"><i class="ti-settings"></i> <span>Vouchers</span></a>
<!--												<ul class="collapse">-->
<!--													<li data-menuid="2.6.1">-->
<!--														<a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/settings">-->
<!--															<i class="ti-shopping-cart-full"></i>-->
<!--															<span>Add/design vouchers</span>-->
<!--														</a>-->
<!--													</li>-->
<!--													<li data-menuid="2.6.2">-->
<!--														<a href="--><?php //echo $this->baseUrl. 'booking_agenda/design'; ?><!--"-->
<!--														><i class="ti-clipboard"></i> <span>Voucher statistics</span>-->
<!--														</a>-->
<!--													</li>-->
<!--												</ul>-->
<!--											</li>-->
										</ul>
									</li>
									<li data-menuid="3">
										<a href="javascript:void(0)" aria-expanded="true"><i class="ti-shopping-cart-full"></i><span>Finance</span></a>
										<ul class="collapse">

                                            <li><a href="<?php echo $this->baseUrl; ?>payment_methods"><i class="ti-pencil-alt"></i><span>Payment methods</span></a></li>
											<li data-menuid="3.1"><a href="<?php echo $this->baseUrl; ?>clearing"><i class="ti-pencil-alt"></i> <span>Pay-out</span></a></li>
											<li data-menuid="3.2"><a href="<?php echo $this->baseUrl; ?>businessreports"><i class="ti-pencil-alt"></i> <span>Transactions</span></a></li>
											<li data-menuid="3.3"><a href="<?php echo $this->baseUrl; ?>invoices"><i class="ti-user"></i> <span>Invoices</span></a></li>
											<?php if (intval($_SESSION['userId']) === $this->tiqsMainId) { ?>
												<li><a href="<?php echo $this->baseUrl; ?>all_payment_methods"><i class="ti-pencil-alt"></i><span>All payment methods</span></a></li>
											<?php } ?>

<!--											<li><a href="--><?php //echo $this->baseUrl; ?><!--dashboard"><i class="ti-pencil-alt"></i> <span>Payment links</span></a></li>-->
<!--											<li>-->
<!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Settings</span></a>-->
<!--												<ul class="collapse">-->
<!--													<li>-->
<!--														<a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/settings">-->
<!--															<i class="ti-shopping-cart-full"></i>-->
<!--															<span>PSP keycode</span>-->
<!--														</a>-->
<!--													</li>-->
<!--													<li>-->
<!--														<a href="--><?php //echo $this->baseUrl. 'booking_agenda/design'; ?><!--"-->
<!--														><i class="ti-clipboard"></i> <span>Payment plan</span>-->
<!--														</a>-->
<!--													</li>-->
<!--												</ul>-->
<!--											</li>-->
										</ul>
									<li>

									<li data-menuid="4">
										<a href="javascript:void(0)" aria-expanded="true"><i class="ti-calendar"></i><span>Store & POS</span></a>
										<ul class="collapse">
										
											<li data-menuid="4.1"><a href="<?php echo $this->baseUrl; ?>orders"><i class="ti-stats-up"></i><span>Orders</span></a></li>
											<li data-menuid="4.2"><a href="<?php echo $this->baseUrl; ?>pos"><i class="ti-bar-chart"></i><span>POS</span></a></li>

											<li data-menuid="4.3">
												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-bag"></i><span>Products</span></a>
												<ul class="collapse">
													<li data-menuid="4.3.1"><a href="<?php echo $this->baseUrl; ?>product_categories"><i class="ti-layout-accordion-separated"></i> <span>Category</span></a></li>
													<li data-menuid="4.3.2"><a href="<?php echo $this->baseUrl; ?>product_types"><i class="ti-layers-alt"></i> <span>Product Types</span></a></li>
													<li data-menuid="4.3.3"><a href="<?php echo $this->baseUrl; ?>products"><i class="ti-bag"></i> <span>Products</span></a></li>
												</ul>
											</li>
											<li data-menuid="4.4">
												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-video-camera"></i><span>video</span></a>
												<ul class="collapse">
													<li data-menuid="4.4.1"><a href="<?php echo $this->baseUrl; ?>video"><i class="ti-video-camera"></i> <span>Manage</span></a></li>
												</ul>
											</li>

											<li data-menuid="4.5">
												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-ink-pen"></i><span>Printers & spots</span></a>
												<ul class="collapse">
													<li data-menuid="4.5.1"><a href="<?php echo $this->baseUrl; ?>printers"><i class="ti-printer"></i><span>Printers</span></a></li>
													<li data-menuid="4.5.2"><a href="<?php echo $this->baseUrl; ?>spots"><i class="ti-flag-alt"></i><span>Spots</span></a></li>
												</ul>
											</li>
											
											<li data-menuid="4.6">
												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-ink-pen"></i><span>Design</span></a>
												<ul class="collapse">
													<li data-menuid="4.6.1"><a href="<?php echo $this->baseUrl; ?>emaildesigner"><i class="ti-email"></i> <span>Email</span></a></li>
													<li data-menuid="4.6.2"><a href="<?php echo $this->baseUrl; ?>viewdesign"><i class="ti-shopping-cart"></i> <span>Store</span></a></li>
												</ul>
											</li>

											
										</ul>
									</li>
									<li data-menuid="5">
                                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-calendar"></i><span>Reservations</span></a>
                                        <ul class="collapse">
                                            <li data-menuid="5.1"><a href="<?php echo $this->baseUrl;?>customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Statistics</span></a></li>
                                            <li data-menuid="5.2"><a href="<?php echo $this->baseUrl;?>customer_panel/agenda"><i class="ti-agenda"></i> <span>Make your reservations</span></a></li>
<!--                                            <li data-menuid="5.3"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/reservations_report"><i class="ti-write"></i> <span>Reservations Report</span></a></li>-->
<!--                                            <li data-menuid="5.4"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/report"><i class="ti-clipboard"></i> <span>Report</span></a></li>-->
<!--                                            <li data-menuid="5.5"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/pivot"><i class="ti-bar-chart"></i> <span>Export</span></a></li>-->
                                            <li data-menuid="5.6">
                                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Settings</span></a>
                                                <ul class="collapse">
                                                    <li data-menuid="5.6.1">
                                                        <a href="<?php echo $this->baseUrl; ?>customer_panel/settings">
                                                            <i class="ti-shopping-cart-full"></i> 
                                                            <span>Terms and conditions</span>
                                                        </a>
                                                    </li>
                                                    <li data-menuid="5.6.2">
                                                        <a href="<?php echo $this->baseUrl. 'agenda_booking/design'; ?>"
                                                            ><i class="ti-clipboard"></i> <span>Design Agenda reservations</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

									<li data-menuid="6">
										<a href="javascript:void(0)" aria-expanded="true"><i class="ti-ticket"></i><span>e-ticketing</span></a>
										<ul class="collapse">
											<li data-menuid="6.1"><a href="<?php echo $this->baseUrl;?>events/create"><i class="ti-agenda"></i> <span>Create your event</span></a></li>
											<li data-menuid="6.2"><a href="<?php echo $this->baseUrl;?>events"><i class="ti-ticket"></i> <span>Your Events</span></a></li>
                                            <li data-menuid="6.3"><a href="<?php echo $this->baseUrl;?>events/emaildesigner"><i class="ti-email"></i> <span>Email Designer</span></a></li>
											<li data-menuid="6.4"><a href="<?php echo $this->baseUrl;?>events/viewdesign"><i class="ti-ticket"></i> <span></span>Shop settings</a></li>
<!--											<li data-menuid="6.5">-->
<!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Settings</span></a>-->
<!--												<ul class="collapse">-->
<!--													-->
<!--													<li data-menuid="6.5.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Your Events</span></a></li>-->
<!---->
<!--													<li data-menuid="6.5.2"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>RSVP/Guest lists</a></li>-->
<!--													<li data-menuid="6.5.3"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>3rd party</a></li>-->
<!--													<li data-menuid="6.5.4"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Discount codes</a></li>-->
<!--													<li data-menuid="6.5.5"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/reservations_report"><i class="ti-write"></i> <span>Secure ticket box</span></a></li>-->
<!--													<li data-menuid="6.5.6"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/report"><i class="ti-clipboard"></i> <span>Create barcodes</span></a></li>-->
<!--												-->
<!--												</ul>-->
<!--											</li>-->
<!--											<li data-menuid="6.6">-->
<!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Statistics</span></a>-->
<!--												<ul class="collapse">-->
<!--													<li data-menuid="6.6.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Event main Statistics</span></a></li>-->
<!--													<li data-menuid="6.6.2"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Detail sales statistics</a></li>-->
<!--													<li data-menuid="6.6.3"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Detail event reports</a></li>-->
<!--													<li data-menuid="6.6.4"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Detail buyer reports</a></li>-->
<!--													<li data-menuid="6.6.5"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Grand partner insights</a></li>-->
<!--													<li data-menuid="6.6.6"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/reservations_report"><i class="ti-write"></i> <span>Reservations Report</span></a></li>-->
<!--													<li data-menuid="6.6.7"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/report"><i class="ti-clipboard"></i> <span>Report</span></a></li>-->
<!--													<li data-menuid="6.6.8"><a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/pivot"><i class="ti-bar-chart"></i> <span>Export</span></a></li>-->
<!--												</ul>-->
<!--											</li>-->
<!---->
<!---->
<!---->
<!--											<li data-menuid="6.7">-->
<!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>POS</span></a>-->
<!--												<ul class="collapse">-->
<!--													<li data-menuid="6.7.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>POS entrance settings</a></li>-->
<!--												</ul>-->
<!--											</li>-->
<!--											<li data-menuid="6.8">-->
<!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Entrance</span></a>-->
<!--												<ul class="collapse">-->
<!--													-->
<!--													<li data-menuid="6.8.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Scanning results</a></li>-->
<!--													<li data-menuid="6.8.2"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Scanning details</a></li>-->
<!--													-->
<!--												</ul>-->
<!--											</li>-->
<!--											<li data-menuid="6.9">-->
<!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Scanners</span></a>-->
<!--												<ul class="collapse">-->
<!--													-->
<!--													<li data-menuid="6.9.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Scanner settings</span></a></li>-->
<!--													-->
<!--												</ul>-->
<!--											</li>-->
<!---->
<!--											<li data-menuid="6.10">-->
<!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Event fans</span></a>-->
<!--												<ul class="collapse">-->
<!--													<li data-menuid="6.10.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/agenda"><i class="ti-agenda"></i> <span>Rewards</span></a></li>-->
<!--													<li data-menuid="6.10.2"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Requests</span></a></li>-->
<!--													<li data-menuid="6.10.3"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Teams</a></li>-->
<!--													<li data-menuid="6.10.4"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Statistics</a></li>-->
<!--													<li data-menuid="6.10.5"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Assigned to events</a></li>-->
<!--													<li data-menuid="6.10.6"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>invite by mail template</a></li>-->
<!--													<li data-menuid="6.10.7"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>invite from fan-base</a></li>-->
<!--												</ul>-->
<!--											<li data-menuid="6.11">-->
<!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Event proppers</span></a>-->
<!--												<ul class="collapse">-->
<!--													<li data-menuid="6.11.1"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/agenda"><i class="ti-agenda"></i> <span>Rewards</span></a></li>-->
<!--													-->
<!--													<li data-menuid="6.11.2"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span>Requests</span></a></li>-->
<!--													<li data-menuid="6.11.3"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Teams</a></li>-->
<!--													<li data-menuid="6.11.4"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Statistics</a></li>-->
<!--													<li data-menuid="6.11.5"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>Assigned to events</a></li>-->
<!--													<li data-menuid="6.11.6"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>invite by mail template</a></li>-->
<!--													<li data-menuid="6.11.7"><a href="--><?php //echo $this->baseUrl;?><!--customer_panel/booking_tickets"><i class="ti-ticket"></i> <span></span>invite from fan-base</a></li>-->
<!--													-->
<!--													-->
<!--												</ul>-->
<!--                                            </li>-->
<!--											<li data-menuid="6.12">-->
<!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Settings</span></a>-->
<!--												<ul class="collapse">-->
<!--													<li data-menuid="6.12.1">-->
<!--														<a href="--><?php //echo $this->baseUrl; ?><!--customer_panel/settings">-->
<!--															<i class="ti-shopping-cart-full"></i>-->
<!--															<span>Terms and conditions</span>-->
<!--														</a>-->
<!--													</li>-->
<!--													<li data-menuid="6.12.2">-->
<!--														<a href="--><?php //echo $this->baseUrl. 'agenda_booking/design'; ?><!--"-->
<!--														><i class="ti-clipboard"></i> <span>Design Agenda reservations</span>-->
<!--														</a>-->
<!--													</li>-->
<!--												</ul>-->
											</li>
										</ul>
									</li>
									<li data-menuid="7">
                                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-bookmark-alt"></i><span>Floorplan</span></a>
                                        <ul class="collapse">
                                            <li data-menuid="7.1"><a href="<?php echo $this->baseUrl;?>settingsmenu"><i class="ti-settings"></i> <span>Make your floorplans</span></a></li>
                                        </ul>
                                    </li>
									<li data-menuid="8">
										<a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i><span>Lost & Found</span></a>
										<ul class="collapse">
										</ul>
									</li>
									<li data-menuid="9">
										<a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i><span>Users</span></a>
										<ul class="collapse">
											<li data-menuid="9.1"><a href="<?php echo $this->baseUrl;?>employee"><i class="ti-user"></i> <span>Employee's</span></a></li>
										</ul>
									</li>
									<li data-menuid="10">
                                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-stamp"></i><span>Your Profile</span></a>
                                        <ul class="collapse">
										    <li data-menuid="10.1"><a href="<?php echo $this->baseUrl; ?>address"><i class="ti-location-pin"></i> <span>Address</span></a></li>
                                            <li data-menuid="10.2"><a href="<?php echo $this->baseUrl; ?>changepassword"><i class="ti-flickr"></i> <span>Change Password</span></a></li>
                                            <li data-menuid="10.3"><a href="<?php echo $this->baseUrl; ?>paymentsettings"><i class="ti-receipt"></i> <span>Payment Settings</span></a></li>
                                            <li data-menuid="10.4"><a href="<?php echo $this->baseUrl; ?>shopsettings"><i class="ti-shopping-cart"></i> <span>Shop Settings</span></a></li>
                                            <li data-menuid="10.5"><a href="<?php echo $this->baseUrl; ?>logo"><i class="ti-image"></i> <span>Logo</span></a></li>
                                            <li data-menuid="10.6"><a href="<?php echo $this->baseUrl; ?>termsofuse"><i class="ti-align-justify"></i> <span>Terms of Use</span></a></li>
                                            <li data-menuid="10.7"><a href="<?php echo $this->baseUrl; ?>openandclose"><i class="ti-time"></i> <span>Open and Close</span></a></li>
                                            <li data-menuid="10.8"><a href="<?php echo $this->baseUrl; ?>userapi"><i class="ti-location-pin"></i> <span>Api</span></a></li>
                                            <li><a href="<?php echo $this->baseUrl; ?>paynl_merchant"><i class="ti-location-pin"></i> <span>Paynl</span></a></li>
                                        </ul>
                                    </li>
<!--									<li>-->
<!--										<a href="javascript:void(0)" aria-expanded="true"><i class="ti-calendar"></i><span>Online integration</span></a>-->
<!--										<ul class="collapse">-->
<!--											<li>-->
<!--												<a href="javascript:void(0)" aria-expanded="true"><i class="ti-bag"></i><span>iframes</span></a>-->
<!--												<ul class="collapse">-->
<!--													<li><a href="--><?php //echo $this->baseUrl; ?><!--viewdesign"><i class="ti-shopping-cart"></i> <span>Store</span></a></li>-->
<!--													<li><a href="--><?php //echo $this->baseUrl; ?><!--viewdesign"><i class="ti-shopping-cart"></i> <span>Agenda</span></a></li>-->
<!--													<li><a href="--><?php //echo $this->baseUrl; ?><!--viewdesign"><i class="ti-shopping-cart"></i> <span>Reservations</span></a></li>-->
<!--													<li><a href="--><?php //echo $this->baseUrl; ?><!--viewdesign"><i class="ti-shopping-cart"></i> <span>ticketshop</span></a></li>-->
<!--												</ul>-->
<!--											</li>-->
<!--										</ul>-->
<!--									</li>-->

                                    <li data-menuid="11">
                                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i><span>Connect</span></a>
                                        <ul class="collapse">
											<li data-menuid="11.1"><a href="<?php echo $this->baseUrl; ?>visma/config"><i class="ti-credit-card"></i> <span>Visma Accounting</span></a></li>
                                            <li data-menuid="11.2"><a href="http://localhost/tiqsbox/index.php/Admin"><i class="ti-package"></i> <span>Tiqsbox</span></a></li>
                                        </ul>
                                    </li>
									<li data-menuid="12">
										<a href="javascript:void(0)" aria-expanded="true"><i class="ti-share"></i><span>Your links</span></a>
										<ul class="collapse">
											<li data-menuid="12.1">
												<a href="<?php echo $this->baseUrl . 'make_order?vendorid=' . $this->session->userdata('userId'); ?>" target="_blank">
													<i class="ti-shopping-cart-full"></i> <span>Store</span>
												</a>
											</li>
											<li data-menuid="12.2">
												<a href="<?php echo $this->baseUrl . 'check424/' . $this->session->userdata('userId'); ?>" target="_blank">
													<i class="ti-book"></i>
													<span>Registration</span>
												</a>
											</li>
											<li data-menuid="12.3"><a href="<?php echo $this->baseUrl. 'agenda_booking/' . $userShortUrl; ?>" target="_blank"><i class="ti-agenda"></i> <span>Agenda reservations</span></a></li>
											<li data-menuid="12.4"><a href="<?php echo $this->baseUrl. 'booking_agenda/' . $userShortUrl; ?>" target="_blank"><i class="ti-clipboard"></i> <span>Reservation Agenda</span></a></li>
										</ul>
                                    </li>
                                    <li data-menuid="13">
                                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i><span>Templates</span></a>
                                        <ul class="collapse">
                                            <li data-menuid="13.1"><a href="<?php echo $this->baseUrl; ?>list_template"><i class="ti-credit-card"></i> <span>Templates</span></a></li>
											<li data-menuid="13.1"><a href="<?php echo $this->baseUrl; ?>add_template"><i class="ti-credit-card"></i> <span>Add template</span></a></li>                                            
                                        </ul>
                                    </li>
                                    <li><a href="<?php echo $this->baseUrl; ?>logout"><i class="ti-shift-left"></i> <span>Logout</span></a></li>
									<li><a href="<?php echo $this->baseUrl; ?>legal"><i class="ti-bookmark-alt"></i> <span>Legal</span></a></li>
								</ul>
                            </nav>
                        </div>
                        <div
                            class="slimScrollBar"
                            style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 440.037px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"
                        >
                        </div>
                    </div>
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
                                    <p style="font-weight: 100; font-size: 100%;padding-top:10px;color: #000;">
                                        <?php echo $this->session->userdata('userId');?> <?php echo $this->session->userdata('name');?>
										<a href="https://tiqs.com/alfred/loggedin">
											<image src="<?php echo $this->baseUrl; ?>assets/home/images/manualicon.png" style="width:28px; margin-left: 30px" >
										</a>

									</p>

                                </div>

								<div id="user-title" class="pull-left">
									<p style="font-weight: 100; font-size: 100%;padding-top:10px;color: #000;">
<!--										--><?php //echo $this->session->userdata('userId');?><!-- --><?php //echo $this->session->userdata('name');?>
											<a style="color: #E25F2A; margin-left: 20px" href="#" data-toggle="modal" data-target="#myModal" id='modal-button'> <img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/world.png" title="LANGUAGE"/></a>
<!--										<a href="https://tiqs.com/alfred/loggedin">-->
<!--											<image src="--><?php //echo $this->baseUrl; ?><!--assets/home/images/manualicon.png" style="width:28px; margin-left: 30px" >-->
<!--										</a>-->
									</p>
								</div>
                                <div id="search-box" class="search-box pull-right">
                                    <!-- <input
                                        style="background: white;font-size:14px !important;font-family: inherit !important;"
                                        type="text"
                                        name="search" placeholder="Search..."
                                        required=""
                                    />
                                    <i class="ti-search"></i> -->
                                    <?php if (isset($_SESSION['masterAccounts']) && count($_SESSION['masterAccounts']) > 1) { ?>
                                        <form action="<?php echo base_url() . 'login/switchAccount'; ?>" method="post">
                                            <div class="form-group">
<!--                                                <label for="masterAccountId">--><?php //echo $this->language->tLine('Change account'); ?><!--</label>-->
                                                <select
                                                    class="form-control"
                                                    id="masterAccountId"
                                                    name="masterAccountId"
                                                    required
                                                    onchange="submitSwitchAccountForm(this)"
													style="border-radius: 50px;margin-top: 7px"
                                                >
                                                    <option value=""><?php echo $this->language->tLine('Select'); ?></option>
                                                    <?php foreach ($_SESSION['masterAccounts'] as $masterAccount) { ?>
                                                        <option
                                                            value="<?php echo $masterAccount['id']; ?>"
                                                            <?php if ($masterAccount['id'] === $_SESSION['userId'] ) echo 'selected';
                                                            ?>
                                                        >
                                                            <?php
                                                                echo $masterAccount['username'];
                                                                if ($masterAccount['id'] === $_SESSION['masterAccountId'] ) echo '&nbsp;(' . $this->language->tLine('MASTER ACCOUNT') . ')';
                                                            ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </form>
                                    <?php } ?>
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
                                        <li>
                                            <span><?php $title = ($pageTitle == 'Dashboard') ? 'Home' : $pageTitle; echo $title; ?></span>
                                        </li>
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
        if(search_box < 240){
            $("#search-box").css('width',search_box);
            $("#search-box input").css('width',search_box);
        }

    });
</script>
