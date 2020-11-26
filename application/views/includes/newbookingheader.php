<!DOCTYPE html>
<html lang="<?php echo $_SESSION['site_lang']; ?>">

<head>
	<title><?php echo $pageTitle ? $pageTitle : 'TIQS | LOST AND FOUND'; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/booking-form-styles.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/toastr3.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;600&amp;display=swap" rel="stylesheet">

</head>
<body>


	<div class="container booking-form">
		<div class="row">
			<div class="booking-form__header">
				<div id="date-active" class="booking-form__date-link">
					<p>Event Date</p>
				</div>
				<div id="spot-active" class="booking-form__person-link">
					<p>SPOT</p>
				</div>
				<div id="timeslot-active" class="booking-form__time-link">
					<p>Time Slot</p>
				</div>
				<div id="personal-active" class="booking-form__info-link">
					<p>Personal Info</p>
				</div>
			</div>
		</div>
		<!-- end booking for header -->