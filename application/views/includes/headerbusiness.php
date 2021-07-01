<?php
    if (!defined('BASEPATH')) exit('No direct script access allowed');
    $userShortUrl = $this->session->userdata('userShortUrl');
?>
<!DOCTYPE html>
<html lang="<?php echo ($_SESSION['site_lang'] === 'english') ? 'en' : $_SESSION['site_lang']; ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $pageTitle ? $pageTitle : 'TIQS'; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png">
        <!-- <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl;?>assets/css/business_dashboard/bootstrap.min.css"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl;?>assets/css/css/customer_style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/main-style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/font-awesome-4.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/themify-icons.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/metisMenu.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/owl.carousel.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/css/slicknav.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/main-style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/grid.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/tiqscss.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/clstylesheet.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/cbstylesheet.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>tiqscss/tiqsballoontip.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/magnific-popup.min.css" >
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


		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.4.0/introjs-rtl.css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.4.0/introjs-rtl.min.css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.4.0/introjs-rtl.min.css.map"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.4.0/introjs.css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.4.0/introjs.min.css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.4.0/introjs.min.css.map"/>




        <?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>
        <?php include_once FCPATH . 'application/views/includes/jsGlobalVariables.php'; ?>
        <?php
            if (isset($css) AND is_array($css)) { // ???????????  MOVE TO FOOTER IF USER CUSTOM SCRIPTS ???????????????
                foreach ($css as $cssLink) { 
                ?>
                    <link href="<?php echo $cssLink ?>" rel="stylesheet" />
                <?php
                }
            }
        ?>

        
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

            #collapse-item, #navItems, #navRowElement {
                -ms-flex-wrap: unset !important;
                flex-wrap: unset !important;
            }

            @media only screen and (max-width: 600px) {
                #img-world {
                    margin-top: 10px !important;
                }
                #userNameAndId {
                    display: none !important;
                }
            }

            .modal-backdrop {
                z-index: 99 !important;
            }

            @media only screen and (min-width: 600px) {
                #manualImg {
                    margin-left: 0px !important;
                    min-width: 25px !important;
                    max-width: 25px !important;
                    width: 25px !important;
                }

                #img-world {
                    margin-top: 10px !important;
                    min-width: 25px !important;
                    max-width: 25px !important;
                    width: 25px !important;
                }
            }

            
        </style>
        <?php if (!isset($_SESSION['masterAccounts'])) { ?>
            <style>
                @media only screen and (min-width: 600px) {
                    #navRowElement {
                        width: 550px;
                    }
                }
            </style>
        <?php } ?>


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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
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
        <!--
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
        <script src="https://unpkg.com/vuejs-datepicker"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue-search-select@2.9.3/dist/VueSearchSelect.umd.min.js"></script>
        -->
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
        <script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js" ></script>
        <script src="<?php echo $this->baseUrl; ?>assets/home/js/objectFloorPlans.js" ></script>
		<script src="<?php echo $this->baseUrl; ?>assets/home/js/languageModal.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.4.0/intro.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.4.0/intro.js"></script>
        <?php
            if (isset($js) AND is_array($js)) { // ???????????  MOVE TO FOOTER IF USER CUSTOM SCRIPTS ???????????????
                foreach ($js as $jsLink) { 
                ?>
                    <?php if($jsLink == base_url() . 'assets/home/js/templates.js'): ?>
                        <script defer src="<?php echo $jsLink ?>"></script>
                    <?php else: ?>
                    <script src="<?php echo $jsLink ?>"></script>
                    <?php endif; ?>
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
                                        <a href="<?php echo $this->baseUrl;?>loggedin">
                                            <div class="profile-name text-center">
                                                <img class="logo-img" src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogowhite.png" alt="logo">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php
                                    if (isset($_SESSION['buyerId'])) {
                                        require_once FCPATH . 'application' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'buyerSidebar.php';
                                    } else {
                                        require_once FCPATH . 'application' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'vendorSidebar.php';
                                    }
                                ?>
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
                        <div id="navItems" class="row align-items-center">
                            <!-- nav and search button -->
                            <div style="flex-wrap: nowrap !important" id="collapse-item" class="row w-100">
                                <div class="nav-btn col-md-1 col-sm-1" style="width:50px;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div class="col-md-10 user-title" id="navElement">
                                    <div id="navRowElement" class="row">
                                        <p
                                            id="userNameAndId"
                                            style="font-weight: 100; font-size: 100%; padding-top:10px; color: #000;"
                                            class="col-md-4 col-sm-4"
                                        >
                                            <?php
                                                if (($this->session->userdata('userId'))) {
                                                    echo $this->session->userdata('userId') . '&nbsp;' . $this->session->userdata('name');
                                                } else {
                                                    echo $this->session->userdata('buyerId') . '&nbsp;' . $this->session->userdata('name');
                                                }
                                            ?>
                                        </p>
                                        <?php if ($this->session->userdata('userId')) { ?>
                                            <p
                                                style="font-weight: 100; font-size: 100%; padding-top:10px; color: #000;"
                                                class="col-md-1 navElements"
                                            >
                                                <a href="https://tiqs.com/alfred/loggedinmanuals">
                                                    <img id="manualImg" src="<?php echo $this->baseUrl; ?>assets/home/images/manualicon.png" style="width:28px; margin-left: 30px; min-width: 25px !important;" alt="" />
                                                </a>                                        
                                            </p>
                                        <?php } ?>
                                        <p
                                            class="col-md-1 navElements"
                                            style="color: #E25F2A; margin-left: 20px"
                                            data-toggle="modal"
                                            data-target="#myModal"
                                            id='modal-button'
                                        >
                                            <img
                                                width="30"
                                                height="30"
                                                id="img-world"
                                                src="<?php echo $this->baseUrl; ?>assets/home/images/world.png" title="LANGUAGE"
                                                style="margin-top:14px;min-width: 25px !important;"
                                            />
                                        </p>
                                        <?php if (isset($_SESSION['masterAccounts']) && count($_SESSION['masterAccounts']) > 1) { ?>
                                            <div
                                                id="search-box"
                                                class="search-box col-md-5 navElements"
                                            >
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
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- profile info & task notification -->
                            
                        </div>
                    </div>
                    <!-- header area end -->
                    <!-- page title area start -->
                    <?php if (($this->session->userdata('userId'))) { ?>
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
                    <?php } ?>
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
        let title = $(".user-title").width();
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
        let title = $(".user-title").width();
        let search_box = header - (collapse+title);
        if(search_box < 240){
            $("#search-box").css('width',search_box);
            $("#search-box input").css('width',search_box);
        }

    });
</script>
