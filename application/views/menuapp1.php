<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="https://tiqs.com/tiqsimg/tiqslogo.png" />
    <meta charset="UTF-8">
    <title>tiqs | Wordpress</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>tiqscss/tiqscss.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>tiqscss/tiqsballoontip.css" rel="stylesheet" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/iframeResizer.min.js"></script>


    <style>
        iframe {
            width: 1px;
            min-width: 100%;
            height: 100%;
            border: 0;
            /*overflow: scroll;*/
        }

        html,body { height:100%; }
    </style>
</head>
<body>
<iframe id="myIframe" src="https://lostandfound.tips"></iframe>
</body>

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

</html>