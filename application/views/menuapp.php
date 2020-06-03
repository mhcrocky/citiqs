<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/iframeResizer.min.js"></script>
<title>tiqs | FIND LOCATION</title>


<link href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="tiqscss/tiqsballoontip.css" rel="stylesheet" type="text/css" />
<link href="assets/css/flags.css" rel="stylesheet" type="text/css" />
<link href="assets/css/flat/32/flags.css" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="assets/home/styles/main-style.css">
<link rel="stylesheet" href="assets/home/styles/home-page.css">
<!--    <link rel="stylesheet" href="assets/styles/styles.css">-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
<script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>

<style>
    iframe {
        width: 1px;
        min-width: 100%;
        height: 100%;
        border: 2px;
        /*overflow: scroll;*/
    }
</style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

        <!-- Content  -->
        <iframe id="myIframe" src="https://lostandfound.tips/tiqs-app-install" style="height: 1200px"></iframe>

            </div>
        </div>
    </section>
</div>

<script>
    // iFrameResize({ log: true }, '#myIframe')
    iFrameResize({
        log                     : false,                  // Enable console logging
        heightCalculationMethod : 'max', // 'bodyScroll',
        enablePublicMethods     : true,                  // Enable methods within iframe hosted page
        resizedCallback         : function(messageData){ // Callback fn when resize is received
            $('p#callback').html(
                '<b>Frame ID:</b> '    + messageData.iframe.id +
                ' <b>Height:</b> '     + messageData.height +
                ' <b>Width:</b> '      + messageData.width +
                ' <b>Event type:</b> ' + messageData.type
            );
        },
        messageCallback         : function(messageData){ // Callback fn when message is received
            $('p#callback').html(
                '<b>Frame ID:</b> '    + messageData.iframe.id +
                ' <b>Message:</b> '    + messageData.message
            );
            alert(messageData.message);
        },
        closedCallback         : function(id){ // Callback fn when iFrame is closed
            $('p#callback').html(
                '<b>IFrame (</b>'    + id +
                '<b>) removed from page.</b>'
            );
        }
    });
</script>


<?php
if(isset($_SESSION['error'])){
    unset($_SESSION['error']);
}
if(isset($_SESSION['success'])){
    unset($_SESSION['success']);
}
if(isset($_SESSION['message'])){
    unset($_SESSION['message']);
}
?>