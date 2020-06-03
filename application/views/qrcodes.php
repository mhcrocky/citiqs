<!DOCTYPE html>
<html>
    <head>
    <title>Tiqs | Qr codes</title>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="https://tiqs.com/tiqsimg/tiqslogo.png" />
    <link href="<?php echo $url; ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url; ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url; ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url; ?>tiqscss/tiqscss.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
        @import url("https://fast.fonts.net/lt/1.css?apiType=css&c=f98384f2-47d2-4642-aecf-2e7d78ccc4f4&fontids=692088");
        @font-face{
            font-family:"Century Gothic W01";
            src:url("<?php echo $url; ?>tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix");
            src:url("<?php echo $url; ?>tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix") format("eot"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/700cfd4c-3384-4654-abe1-aa1a6e8058e4.woff2") format("woff2"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/9908cdad-7524-4206-819e-4f345a666324.woff") format("woff"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/b710c26a-f1ae-4fb8-a9fe-570fd829cbf1.ttf") format("truetype");
        }
    </style>
    </head>
    <body>
        <div class="main-wrapper">
            <div class="form-group" style="margin-left:15px">
                <label for="qrCode">Select label template</label>
                <select class="form-control"  id="qrCode" onchange="changeIframeSrc(this)">
                    <option value="">Select</option>
                    <?php foreach ($codes as $code) { ?>
                    <option value="<?php echo $code; ?>"><?php echo $code; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="container">
                <?php if (isset($iframeUrl) && filter_var($iframeUrl, FILTER_VALIDATE_URL)) { ?>
                    <iframe id="qrCodeFrame" src="<?php echo $iframeUrl; ?>" style="margin-top: 50px; height: 700px"></iframe>
                <?php } ?>
            </div>
        </div>
    <script src="<?php echo $url; ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo $url; ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        var url = "<?php echo $url; ?>";
        function changeIframeSrc(element) {
            let newSrc = url + 'index.php/generateqrcode/pdf/' + element.value;
            document.getElementById('qrCodeFrame').setAttribute('src', newSrc);
        }
    </script>
    </body>
</html>
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