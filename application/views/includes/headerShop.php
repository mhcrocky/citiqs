<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['site_lang']; ?>">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png" />
    <title><?php echo $pageTitle ? $pageTitle : 'TIQS | SHOP'; ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/bootstrap/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/css/menu-style.css">

    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/css/iziToast.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
    input[type="text"]:disabled, input[type="number"]:disabled  {
        background-color: #fff;
        color: #000;
    }

    <?php
    $eventDescript = '';
    $eventTitle = '';
     if(isset($design)) {
        $bgImage=$design['bgImage'];
        $shopdesign=$design['shop'];
        $eventTitle = isset($design['shop']['eventTitle']) ? $design['shop']['eventTitle'] : '';
        $eventDescript = isset($design['shop']['eventDescript']) ? $design['shop']['eventDescript'] : '';
        echo "body{background-image: url('".$this->baseUrl . "assets/images/backGroundImages/". $bgImage."') !important;
            background-size: cover;}";
        
        $design_ids=$shopdesign['id'];
        foreach($design_ids as $key=> $design_id) {
            echo '#'. $key . '{';
                echo array_keys($design_id)[0].':';
                echo array_values($design_id)[0].'!important } ';
            }
            
            $design_classes=$shopdesign['class'];
            
            foreach($design_classes as $key=> $design_class) {
                $key = str_replace('---', '.', $key);
                echo '.'. $key . '{';
                    echo array_keys($design_class)[0].':';
                    echo array_values($design_class)[0].'!important } ';
                }
                
            }

    ?>
    </style>
    <script> 
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

    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>
    <?php include_once FCPATH . 'application/views/includes/jsGlobalVariables.php'; ?>
    <?php if($this->session->tempdata('exp_time')): ?>
    <script>
    'use strict';
    var globalTime = (function() {
        let globals = {
            time: '<?php echo $this->session->tempdata('exp_time'); ?>',
        }
        Object.freeze(globals);
        return globals;
    }());
    </script>
    <?php endif; ?>

</head>

<body id="body">

    <!-- HEADER -->
    <header class="header">
        <nav class="navbar navbar-expand-lg container">
            <a class="navbar-brand"
                href="<?php echo $this->baseUrl; ?>events/shop/<?php echo $this->session->userdata('shortUrl'); ?>">
                <img class="menu-icon" src="<?php echo base_url(); ?>assets/home/images/logo1.png" alt="">
            </a>
            <button class="navbar-toggler py-2 px-3 px-md-4 bg-secondary" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"></button>

            <div class="collapse navbar-collapse pl-md-4" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active pt-2 pt-md-0">
                        <a class="nav-link"
                            href="<?php echo $this->baseUrl; ?>events/shop/<?php echo $this->session->userdata('shortUrl'); ?>">Home
                            <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
            <a href="#" class="btn btn-primary btn-lg bg-primary px-3 px-md-4 text-center header__checkout"
                data-toggle="modal" data-target="#checkout-modal"><i class="fa fa-shopping-basket mr-md-3"></i><span
                    class='d-none d-lg-inline'>CHECKOUT</span> &nbsp €<b
                    class="totalBasket"><?php echo $this->session->userdata('total'); ?></b></a>

        </nav>
    </header>
    <!-- END HEADER -->