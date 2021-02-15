<!DOCTYPE html>
<html lang="<?php echo $_SESSION['site_lang']; ?>">

<head>
    <title><?php echo $pageTitle ? $pageTitle : 'TIQS | LOST AND FOUND'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/booking-form-styles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/toastr3.css">
    <?php include_once FCPATH . 'application/views/includes/customCss.php'; ?>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;600&amp;display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
    .day-agenda {
        background-color: #b3ffb3;
    }

    .day-agenda:hover {
        background-color: #4dff4d !important;
        color: #fff !important;
    }

    @media only screen and (max-width: 550px) {
        .container,.booking-form,#body {
            width: 100% !important;
            min-width: 100% !important;
            max-width:100% !important;
        }
    }

    <?php $CI=& get_instance();
    $CI->load->model('bookandpayagendabooking_model');
    $customer=$CI->session->userdata('customer')['id'];
    $design=$CI->bookandpayagendabooking_model->get_agenda_booking_design($customer);

    if(isset($design[0]['design'])) {
        $design=unserialize($design[0]['design'])['selectShortUrl'];

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

    ?>
    </style>

</head>

<body id="body">


    <div class="mx-auto booking-form">
        <div id="booking-form__header" class="row">
            <div class="booking-form__header">
                <div class="elem" id="agenda-active">
                    <a style="text-decoration:none;color:#fff;font-size:14px;"
                        href="<?php echo base_url(); ?>agenda_booking/spots/<?php echo $this->session->userdata('shortUrl'); ?>">Event
                        Date</a>
                </div>
                <div class="elem" id="spot-active">
                    <?php if($this->session->userdata('eventId')): ?>
                    <a style="text-decoration:none;color:#fff;font-size:14px;"
                        href="<?php echo base_url(); ?>agenda_booking/spots/<?php echo $this->session->userdata('eventDate'); ?>/<?php echo $this->session->userdata('eventId'); ?>">SPOT</a>
                    <?php else: ?>
                    <p>SPOT</p>
                    <?php endif; ?>
                </div>
                <div class="elem" id="timeslot-active">
                    <?php if($this->session->userdata('spotId')): ?>
                    <a style="text-decoration:none;color:#fff;font-size:14px;"
                        href="<?php echo base_url(); ?>agenda_booking/time_slots/<?php echo $this->session->userdata('spotId'); ?>">Time
                        Slot</a>
                    <?php else: ?>
                    <p>Time Slot</p>
                    <?php endif; ?>
                </div>
                <div class="elem" id="personal-active">
                    <?php if($this->session->userdata('timeslotId')): ?>
                    <a style="text-decoration:none;color:#fff;font-size:14px;"
                        href="<?php echo base_url(); ?>agenda_booking/pay">Personal Info</a>
                    <?php else: ?>
                    <p>Personal Info</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- end booking for header -->