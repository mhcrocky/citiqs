<!DOCTYPE html>

<html><head>

	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/home/images/tiqsiconlogonew.png" alt="">

	<meta charset="UTF-8">

	<title><?php echo $pageTitle; ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/main-style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/how-it-works.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/home-page.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/grid.css">-->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/main-style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/how-it-works.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/home-page.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/grid.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>tiqscss/tiqsballoontip.css"  type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/tiqscss.css"  type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>tiqscss/clstylesheet.css"  type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>tiqscss/cbstylesheet.css"  type="text/css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css"  type="text/css">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/cookie.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" integrity="sha256-PZLhE6wwMbg4AB3d35ZdBF9HD/dI/y4RazA3iRDurss=" crossorigin="anonymous" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>
	<script src="<?php echo base_url(); ?>assets/home/js/vanilla-picker.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/js/tooltipster.bundle.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/cdn/js/html5shiv.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha256-P93G0oq6PBPWTP1IR8Mz/0jHHUpaWL0aBJTKauisG7Q=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/alertify.js"></script> 
</head>

<?php if ($this->view === 'map') {?>
<body onload="getLocation()">
<?php } else { ?>
<body>
<?php } ?>

   <header class="header">

    <nav class="header-nav">

        <a href="https://tiqs.com" class="nav-logo">
	
            <img src="<?php echo base_url(); ?>assets/home/images/tiqslogonew.png" alt="">

        </a>

		<?php echo $this->session->name ?>

        <div class="header-menu text-orange" id="header-menu">

            <a href="<?php echo base_url(); ?>home">HOME</a>

			<!-- only drop off point -->


			<a href="<?php echo base_url(); ?>lostandfoundlist">LOST + FOUND</a>
            <a href="<?php echo base_url(); ?>userCalimedlisting">Claimed</a>
			<a href="<?php echo base_url(); ?>check">REGISTER ITEM</a>
			<a style="color: #E25F2A" href="<?php echo $this->baseUrl; ?>Whatislostisfound">FIND YOUR ITEM</a>
			<a href="<?php echo base_url(); ?>profile">PROFILE</a>


            <a href="#" id='modal-button'><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/world.png" title="LANGUAGE"/></a>

            <a href="<?php echo base_url(); ?>logout">LOGOUT</a>

<!--            <a href="--><?php //echo base_url(); ?><!--dashboard">dashboard</a>-->


        </div>

        <div class="hamburger-menu" id="hamburger-menu">

            <div></div>

            <div></div>

            <div></div>

        </div>

    </nav>

</header>

<!-- LANGUAGE VIEW -->
<?php
$this->load->view('includes/selectlanguage.php');
?>
<!-- LANGUAGE VIEW END -->

<script type="text/javascript">



    // modal script

    // Get the modal

    var modal = document.getElementById("myModal");



    // Get the button that opens the modal

    var btn = document.getElementById("modal-button");



    // Get the <span> element that closes the modal

    var span = document.getElementsByClassName("close")[0];



    // When the user clicks on the button, open the modal

    btn.onclick = function() {

        modal.style.display = "block";

    }



    // When the user clicks on <span> (x), close the modal

    span.onclick = function() {

        modal.style.display = "none";

    }



    // When the user clicks anywhere outside of the modal, close it

    window.onclick = function(event) {

        if (event.target == modal) {

            modal.style.display = "none";

        }

    }



    // scroll to DHL section



    $("#dhl-button").click(function() {

        $('html,body').animate({

                scrollTop: $("#dhl-section").offset().top},

            'slow');

    });



    $("#hit-button").click(function() {

        $('html,body').animate({

                scrollTop: $("#hit-section").offset().top},

            'slow');

    });
	
	  $('#hamburger-menu').click(function(){
        $('#header-menu').toggleClass('show');
    });



</script>



<!-- end header -->

