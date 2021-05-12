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

	<link rel="shortcut icon" href="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/bower_components/font-awesome/css/font-awesome.min.css" />
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
	<?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>
	<style>
		#myModal {
			overflow: scroll;
		}
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
	<script src="<?php echo $this->baseUrl; ?>assets/cdn/js/html5shiv.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/dist/js/tooltipster.bundle.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/vanilla-picker.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/cookies.js"></script>
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

        <div class="header-menu text-orange" id="header-menu">

            <a href="<?php echo base_url(); ?>home">HOME</a>
			<a href="<?php echo base_url(); ?>translate">TRANSLATION</a>
			<a href="<?php echo base_url(); ?>profile">PROFILE</a>
			<a href="<?php echo base_url(); ?>Whatislostisfound">LOCATIONS</a>
            <a href="#" id='modal-button'><img width="30px" height="30px" src="<?php echo $this->baseUrl; ?>assets/home/images/world.png" title="LANGUAGE"/></a>
            <a href="<?php echo base_url(); ?>logout">LOGOUT</a>

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

