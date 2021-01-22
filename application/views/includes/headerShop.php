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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/menu-style.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
</head>

<body>

    <!-- HEADER -->
    <header class='header'>
        <nav class="navbar navbar-expand-lg container">
            <a class="navbar-brand" href="<?php echo base_url(); ?>events/shop/<?php echo $this->session->userdata('shortUrl'); ?>">
                <img src="<?php echo base_url(); ?>assets/home/images/logo1.png" alt="">
            </a>
            <button class="navbar-toggler py-2 px-3 px-md-4 bg-secondary" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"></button>

            <div class="collapse navbar-collapse pl-md-4" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active pt-2 pt-md-0">
                        <a class="nav-link" href="<?php echo base_url(); ?>events/shop/<?php echo $this->session->userdata('shortUrl'); ?>">Home <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
            <a style="display: none;" href="#" class="btn btn-primary btn-lg bg-primary px-3 px-md-4 text-center header__checkout"
                data-toggle="modal" data-target="#checkout-modal"><i class="fa fa-arrow-left mr-md-3"></i><span
                    class='d-none d-lg-inline'>BACK</span></a>
        </nav>
    </header>
    <!-- END HEADER -->