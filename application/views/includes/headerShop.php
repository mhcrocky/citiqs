<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['site_lang']; ?>">
<head>
    <title><?php echo !empty($pageTitle) ? $pageTitle : 'TIQS | SHOP'; ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php
        if (!empty($facebook)) {
            foreach($facebook as $key => $content) {
                ?>
                    <meta property="<?php echo $key; ?>" content="<?php echo $content; ?>" />
                <?php
            }
        }
    ?>
    <link rel="shortcut icon" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png" />

    <!-- Analytics -->
    <?php
        if (isset($vendor) && count($vendor) > 0) {
            include_once FCPATH . 'application/views/includes/analytics.php';
        }
    ?>

    <!-- CSS  -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/bootstrap/bootstrap.min.css">

    <!-- alertify css -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/alertify.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/alertify_default.min.css" />

    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/css/menu-style.css">

    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/css/iziToast.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>
    <style>
        input[type="text"]:disabled, input[type="number"]:disabled  {
            background-color: #fff;
            color: #000;
        }

        .h-div {
            display: none;
        }

        @media only screen and (max-width: 750px) {


            .single-item__grid {
                box-shadow: none !important;
                background: transparent !important;
                
            }

            .event-card {
                margin-right: 0px !important;
                margin-left: 0px !important;
            }

            .h-div {
                display: none;
            }
        }

        </style>

        <style>
        <?php
            $eventDescript = '';
            $eventTitle = '';

            if (isset($design)) {
                $shopdesign = isset($design['shop']) ? $design['shop'] : [];
                $eventTitle = isset($design['shop']['eventTitle']) ? $design['shop']['eventTitle'] : '';
                $eventDescript = isset($design['shop']['eventDescript']) ? $design['shop']['eventDescript'] : '';
                // echo "body{background-image: url('".$this->baseUrl . "assets/images/backGroundImages/". $bgImage."') !important; background-size: cover;}";

                $design_ids = isset($shopdesign['id']) ? $shopdesign['id'] : [];
                if (count($design_ids) > 0) {
                    foreach ($design_ids as $key=> $design_id) {
                        echo '#'. $key . '{';
                        echo array_keys($design_id)[0].':';
                        echo array_values($design_id)[0].'!important } ';
                    }
                }
                
                $design_classes = isset($shopdesign['class']) ? $shopdesign['class'] : [];
                if (count($design_classes) > 0) {
                    foreach ($design_classes as $key=> $design_class) {
                        $key = str_replace('---', '.', $key);
                        echo '.'. $key . '{';
                        echo array_keys($design_class)[0].':';
                        echo array_values($design_class)[0].'!important } ';
                    }
                }

                if(isset($shopdesign['background-image'])){
                    echo '.bg-image {background-image: url("'.base_url().'assets/images/events/'.$design['shop']['background-image'].'");';
                    echo 'height: 100%;';
                    echo 'background-position: center;';
                    echo 'background-repeat: no-repeat;';
                    echo 'background-size: cover; }';
                }
                
            }
        ?>
    </style>

    <!-- JS -->
    <script
        src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"
    ></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"
    ></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js" defer></script>
    <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/alertify.min.js" defer></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/alertify.js" defer></script>

    <?php include_once FCPATH . 'application/views/includes/jsGlobalVariables.php'; ?>
    
    
    <script>
        'use strict';
        function changeTextContent(){
            let eventDescript = '<?php echo $eventDescript; ?>';
            let eventTitle = '<?php echo $eventTitle; ?>';
            if(eventTitle != ''){
                $('#event-title').text(eventTitle);
            }
            if(eventDescript != ''){
                $('#event_text_descript').text(eventDescript);
            }
        } 


        <?php if(isset($expTime) && $expTime): ?>      
            'use strict';
            var globalTime = (function() {
                let globals = {
                    time: '<?php echo $expTime; ?>',
                }
                Object.freeze(globals);
                return globals;
            }());
        <?php endif; ?>

        var globalKey = (function() {
            let globals = {
                orderRandomKey: '<?php echo isset($orderRandomKey) ? $orderRandomKey : ''; ?>',
            }
            Object.freeze(globals);
            return globals;
        }());
    </script>
</head>

<body class="bg-image" id="body" style="display: block !important;">

    <!-- HEADER -->
    <header class="header">
        <nav class="navbar navbar-expand-lg container">
            <a class="navbar-brand"
                href="<?php echo current_url(); ?>">
                <img class="menu-icon" src="<?php echo base_url() . '' . $logoUrl; ?>" alt="" />
            </a>
            <button
                class="navbar-toggler py-2 px-3 px-md-4 bg-secondary"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            ></button>

            <div class="collapse navbar-collapse pl-md-4" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto d-none">
                    <li class="nav-item active pt-2 pt-md-0">
                        <a class="nav-link"
                            href="<?php echo current_url(); ?>">Home
                            <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
            <a
                href="#"
                class="btn btn-primary btn-lg bg-primary px-3 px-md-4 text-center header__checkout"
                data-toggle="modal"
                data-target="#checkout-modal"
            >
                <i class="fa fa-shopping-basket mr-md-3"></i>
                <span class='d-none d-lg-inline'>CHECKOUT</span> &nbsp €
                <b class="totalBasket"><?php echo (isset($totalAmount) &&  $totalAmount) ? $totalAmount : ''; ?></b>
            </a>
            <input type="hidden" id="totalBasketAmount" value="<?php echo (isset($totalAmount) &&  $totalAmount) ? $totalAmount : 0; ?>" />
        </nav>
    </header>
    <!-- END HEADER -->
