<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['site_lang']; ?>">

<head>
    <title>
        <?php echo $pageTitle ? $pageTitle : 'TIQS | SHOP'; ?>
    </title>

    <!--	<script data-ad-client="ca-pub-9508055469710582" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png" />
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/bootstrap3.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css"
        href="<?php echo $this->baseUrl; ?>assets/bower_components/font-awesome/css/font-awesome.min.css" />
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
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" type="text/css"
        href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/keyboard.css" />
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
    <style>
    <?php if(isset($design)) {
        $bgImage=$design['bgImage'];
        $design=$design['selectType'];
        echo "body{background-image: url('".$this->baseUrl . "assets/images/backGroundImages/". $bgImage."') !important;
background-size: cover;
    }

    ";
$design_ids=$design['id'];

    foreach($design_ids as $key=> $design_id) {
        echo '#'. $key . '{';
        echo array_keys($design_id)[0].':';
        echo array_values($design_id)[0].'!important } ';
    }

    $design_classes=$design['class'];

    foreach($design_classes as $key=> $design_class) {
        echo '.'. $key . '{';
        echo array_keys($design_class)[0].':';
        echo array_values($design_class)[0].'!important } ';
    }
    }

    ?>html,
    body {
        height: 100%;
    }

    .full-height {
        height: 100%;
    }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
    <!-- <script src="<?php echo $this->baseUrl; ?>assets/cdn/js/html5shiv.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> -->
    <script src="<?php echo $this->baseUrl; ?>assets/dist/js/tooltipster.bundle.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/vanilla-picker.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/cookies.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/alertify.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/createKeyBoard.js"></script>
    <?php include_once FCPATH . 'application/views/includes/customDesign.php'; ?>
</head>
