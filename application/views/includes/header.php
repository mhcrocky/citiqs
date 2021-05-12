<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="https://tiqs.com/tiqsimg/tiqslogo.png" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $pageTitle; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.4 -->
        <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- FontAwesome 4.3.0 -->
        <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons 2.0.0 -->
        <link href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
             folder instead of downloading all of them to reduce the load. -->
        <link href="<?php echo base_url(); ?>assets/dist/css/skins/skin-black.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo base_url(); ?>assets/css/flags.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/flat/48/flags.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/cookie.css" />
        <style>
            .error{
                color: #ff5722;
                font-weight: normal;
            }
        </style>
        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript">
            var baseURL = "<?php echo base_url(); ?>";
        </script>

        <style type="text/css">
            @import url("https://fast.fonts.net/lt/1.css?apiType=css&c=f98384f2-47d2-4642-aecf-2e7d78ccc4f4&fontids=692088");
            @font-face{
                font-family:"Century Gothic W01";
                src:url("<?php echo base_url(); ?>tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix");
                src:url("<?php echo base_url(); ?>tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix") format("eot"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/700cfd4c-3384-4654-abe1-aa1a6e8058e4.woff2") format("woff2"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/9908cdad-7524-4206-819e-4f345a666324.woff") format("woff"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/b710c26a-f1ae-4fb8-a9fe-570fd829cbf1.ttf") format("truetype");
            }
        </style>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="<?php #echo $this->baseUrl; ?>assets/cdn/js/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    </head>
    <?php if ($this->view === 'map') {?>
    <body onload="getLocation()" class="hold-transition skin-black sidebar-mini">
    <?php } else { ?>
    <body class="hold-transition skin-black sidebar-mini">
    <?php } ?>
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo base_url(); ?>home" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>tiqs</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>tiqs</b> lost & found </span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <a href="<?php echo base_url() ?>switchlang/english"><span class="flag flag-gb"></span></a>
                    <a href="<?php echo base_url() ?>switchlang/nl"><span class="flag flag-nl"></span></a>
                    <a href="<?php echo base_url() ?>switchlang/it"><span class="flag flag-it"></span></a>
                    <a href="<?php echo base_url() ?>switchlang/es"><span class="flag flag-es"></span></a>
                    <a href="<?php echo base_url() ?>switchlang/de"><span class="flag flag-de"></span></a>
                    <a href="<?php echo base_url() ?>switchlang/fr"><span class="flag flag-fr"></span></a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!--              <li class="dropdown tasks-menu">-->
                            <!--                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">-->
                            <!--                  <i class="fa fa-history"></i>-->
                            <!--                </a>-->
                            <!--                <ul class="dropdown-menu">-->
                            <!--                  <li class="header"> Last Login : <i class="fa fa-clock-o"></i> --><?//= empty($last_login) ? "First Time Login" : $last_login; ?><!--</li>-->
                            <!--                </ul>-->
                            <!--              </li>-->
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs"><?php echo $name; ?></span>
                                </a>


                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">

                                        <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php echo $name; ?>
                                            <small><?php echo $role_text; ?></small>
                                        </p>


                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo base_url(); ?>profile" class="btn btn-default btn-flat"><i class="fa fa-user-circle"></i> Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header"></li>
                        </li>
<!--                        --><?php
//                        if ($this->session->userdata('role') != 4) {
//                            ?>
<!--                            <li>-->
<!--                                <a href="--><?php //echo base_url(); ?><!--lostandfoundlist">-->
<!--                                    <i class="fa fa-tags"></i>-->
<!--                                    <span>Your bag-tags & stickers</span>-->
<!--                                </a>-->
<!--                            </li>    -->
<!--                        --><?php
//                        }
//                        if ($this->session->userdata('dropoffpoint') == 0 && $this->session->userdata('role') != 4) {
//                            ?>
<!--                            <li>-->
<!--                                <a href="--><?php //echo base_url(); ?><!--userReturnitemslisting">-->
<!--                                    <i class="fa fa-tags"></i>-->
<!--                                    <span>Found + claimed items</span>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            --><?php
//                        }
//                        if ($this->session->userdata('dropoffpoint') == 1) {
//                            ?>
<!--                            <li>-->
<!--                                <a href="--><?php //echo base_url(); ?><!--menuapp">-->
<!--                                    <i class="fa fa-mobile-phone"></i>-->
<!--                                    <span>Install apps</span>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            --><?php
//                        }
//                        if ($this->session->userdata('dropoffpoint') == 1) {
//                            ?>
<!--                            <li>-->
<!--                                <a href="--><?php //echo base_url(); ?><!--menuorder">-->
<!--                                    <i class="fa fa-shopping-basket"></i>-->
<!--                                    <span>order Lost + found bags</span>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            --><?php
//                        }
//                        if ($this->session->userdata('dropoffpoint') == 1) {
//                            ?>
<!--                            <li>-->
<!--                                <a href="--><?php //echo base_url(); ?><!--appointmentSetup">-->
<!--                                    <i class="fa fa-calendar-times-o"></i>-->
<!--                                    <span>appointment setup</span>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            --><?php
//                        }
//                        if ($this->session->userdata('dropoffpoint') == 1) {
//                            ?>
<!--                            <li>-->
<!--                                <a href="--><?php //echo base_url(); ?><!--employee">-->
<!--                                    <i class="fa fa-users"></i>-->
<!--                                    <span>Employees list</span>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            --><?php
//                        }
//                        if ($this->session->userdata('dropoffpoint') == 1) {
//                            ?>
<!--                            <li>-->
<!--                                <a href="--><?php //echo base_url(); ?><!--lostandfoundgridsettings">-->
<!--                                    <i class="fa fa-users"></i>-->
<!--                                    <span>lost and found settings</span>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            --><?php
//                        }
                        if ($this->session->userdata('role') == 4) {
                            ?>
                            <li>
                                <a href="<?php echo base_url(); ?>translate">
                                    <i class="fa fa-language"></i>
                                    <span>Translation setup</span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            <a href="<?php echo base_url(); ?>profile">
                                <i class="fa fa-user-circle"></i>
                                <span>Profile</span>
                            </a>
                        </li>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
