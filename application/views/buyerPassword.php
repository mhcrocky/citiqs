<!DOCTYPE html>
<html>
    <head>
        <title>TIQS | CREATE PASSWORD</title>
        
        <meta charset="UTF-8" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport' />
    
        <link rel="shortcut icon" href="https://tiqs.com/tiqsimg/tiqslogo.png" /><link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>tiqscss/tiqscss.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>tiqscss/tiqsballoontip.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        
        <style type="text/css">
            @import url("https://fast.fonts.net/lt/1.css?apiType=css&c=f98384f2-47d2-4642-aecf-2e7d78ccc4f4&fontids=692088");
            @font-face{
                font-family:"Century Gothic W01";
                src:url("<?php echo base_url(); ?>tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix");
                src:url("<?php echo base_url(); ?>tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix") format("eot"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/700cfd4c-3384-4654-abe1-aa1a6e8058e4.woff2") format("woff2"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/9908cdad-7524-4206-819e-4f345a666324.woff") format("woff"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/b710c26a-f1ae-4fb8-a9fe-570fd829cbf1.ttf") format("truetype");
            }
            img {
                border:0px;
            }
        </style>
    </head>
    <body>
        
        <div class="login-box">
            <div class="login-logo">
                <img src="<?php echo base_url(); ?>tiqsimg/tiqslogo.png" alt="tiqs" width="125" height="125" />
            </div>
            <div class="login-box-body">
                <div class="login-box-body">
                    <?php include_once FCPATH . 'application/views/includes/sessionMessages.php'; ?>
                    <p  style="font-family:'Century Gothic W01'; font-size:300%; text-align: center">Create your password</p>
                    <div class="row">
                        <div class="col-md-12" id="mydivs">
                            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                        </div>
                    </div>
            
                    <form action="<?php echo base_url(); ?>login/createBuyerPassword" method="post">
                        <input type="string" name="code" value="<?php echo $code; ?>" readonly hidden required />
                        <div class="form-group has-feedback">
                            <input type="email" class="form-control" placeholder="Email" name="email" required />
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="Password" name="password" required />
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="Confirm Password" name="cpassword" required />
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div style="text-align: center">
                                <input type="submit" class="myButtonOrange" value="Create" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip({'delay': { show: 50, hide: 30 }
                });
            })
        </script>
  </body>
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
