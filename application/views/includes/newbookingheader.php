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
    <script src="https://use.fontawesome.com/514f9129d7.js"></script>
    <style>
    .day-agenda {
        background-color: #b3ffb3;
    }

    .day-agenda:hover {
        background-color: #4dff4d !important;
        color: #fff !important;
    }

    @media only screen and (max-width: 550px) {

        .container,
        .booking-form,
        #body {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
        }
    }
    .btn-primary:hover {
        opacity: 0.8 !important;
    }
    .btn-primary {
        width: 130px !important;

    label:hover {
        color: #000 !important;
		background: #ffffff;
        cursor: pointer;
    }
    #booking-footer {
        padding: 0px !important;
    }

    #booking-info {
        border-radius: 10px;
    }

    .booking-info > span {
        font-weight: 50;
    }
    </style>

    <style>


    <?php if(isset($customDesign[0]['design'])) {
        $design=unserialize($customDesign[0]['design'])['selectShortUrl'];

        $design_ids=$design['id'];


        foreach($design_ids as $key=> $design_id) {
            echo '#'. $key . ' {';
            echo array_keys($design_id)[0].': ';
            echo array_values($design_id)[0].' !important } ';
        }

        $design_classes=$design['class'];

        foreach($design_classes as $key=> $design_class) {
            if($key == 'booking-info'){
                echo '.booking-info, .booking-info > span {';
            } else {
                echo '.'. $key . ' {';
            }
            echo array_keys($design_class)[0].': ';
            echo array_values($design_class)[0].' !important } ';
        }
    }

    ?>
    </style>
   
    <script>
    function customDesignLoad() {
        <?php 
        if(isset($customDesign[0]['design']) && isset(unserialize($customDesign[0]['design'])['headerTitle'])){
            $headerTitles = unserialize($customDesign[0]['design'])['headerTitle'];
            foreach($headerTitles as $key => $headerTitle){
                echo "$('.".$key."').text('" . $headerTitle . "');";
            }
        }

        if(isset($customDesign[0]['design']) && isset(unserialize($customDesign[0]['design'])['tableTitle'])){
            $tableTitles = unserialize($customDesign[0]['design'])['tableTitle'];
            foreach($tableTitles as $key => $tableTitle){
                echo "$('#".$key."').text('" . $tableTitle . "');";
            }
        }

        if(isset($customDesign[0]['design']) && isset(unserialize($customDesign[0]['design'])['chooseTitle'])){

            $chooseTitles = unserialize($customDesign[0]['design'])['chooseTitle'];
            foreach($chooseTitles as $key => $chooseTitle){
                echo "if(document.getElementById('".$key."') !== null){";
                echo "document.getElementById('".$key."').textContent = '". $chooseTitle."';";
                echo "}";
            }
        }
        if(isset($customDesign[0]['design']) && isset(unserialize($customDesign[0]['design'])['defaultView'])){
            $view = unserialize($customDesign[0]['design'])['defaultView'];
            echo "displayView('".$view."');";
        }
    ?>
    }
    </script>


</head>

<body id="body">


    <div class="mx-auto booking-form">
        <div id="booking-form__header" class="row">
            <div class="booking-form__header">
                <div class="elem" id="agenda-active">
                    <a class="agenda-active header-text event-text"
                        style="text-decoration:none;color:#fff;font-size:14px;"
                        href="<?php echo base_url(); ?>agenda_booking/<?php echo $shortUrl; ?>?order=<?php echo $orderRandomKey; ?>">Event
                        Date</a>
                </div>
                <div class="elem" id="spot-active">
                    <?php if(isset($eventId) && $eventId): ?>
                    <a class="spot-active header-text spot-text" style="text-decoration:none;color:#fff;font-size:14px;"
                        href="<?php echo base_url(); ?>agenda_booking/spots/<?php echo $eventDate; ?>/<?php echo $eventId; ?>?order=<?php echo $orderRandomKey; ?>">SPOT</a>
                    <?php else: ?>
                    <p class="spot-active header-text spot-text">SPOT</p>
                    <?php endif; ?>
                </div>
                <div class="elem" id="timeslot-active">
                    <?php if(isset($spotId) && $spotId): ?>
                    <a class="timeslot-active header-text timeslot-text"
                        style="text-decoration:none;color:#fff;font-size:14px;"
                        href="<?php echo base_url(); ?>agenda_booking/time_slots/<?php echo $spotId; ?>?order=<?php echo $orderRandomKey; ?>">Time
                        Slot</a>
                    <?php else: ?>
                    <p class="timeslot-active header-text timeslot-text">Time Slot</p>
                    <?php endif; ?>
                </div>
                <div class="elem" id="personal-active">
                    <?php if(isset($timeslot) && $timeslot): ?>
                    <a class="personal-active header-text personal-info-text"
                        style="text-decoration:none;color:#fff;font-size:14px;"
                        href="<?php echo base_url(); ?>agenda_booking/pay?order=<?php echo $orderRandomKey; ?>">Personal Info</a>
                    <?php else: ?>
                    <p class="personal-active header-text personal-info-text">Personal Info</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- end booking for header -->
