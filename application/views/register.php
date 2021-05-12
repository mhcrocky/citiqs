<!DOCTYPE html>
<html>
<head>
      <link rel="shortcut icon" href="https://tiqs.com/tiqsimg/tiqslogo.png" />
    <meta charset="UTF-8">
    <title>tiqs | Register</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>tiqscss/tiqscss.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>tiqscss/tiqsballoontip.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
    <!-- <script type="text/javascript" src="assets/dist/js/tooltipster.bundle.min.js"></script> -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php #echo $this->baseUrl; ?>assets/cdn/js/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<!--    <script type="text/javascript">-->
<!--        var MTUserId='f98384f2-47d2-4642-aecf-2e7d78ccc4f4';-->
<!--        var MTFontIds = new Array();-->
<!---->
<!--        MTFontIds.push("692088"); // Century Gothic™ W01 Regular-->
<!--        (function() {-->
<!--            var mtTracking = document.createElement('script');-->
<!--            mtTracking.type='text/javascript';-->
<!--            mtTracking.async='true';-->
<!--            mtTracking.src='mtiFontTrackingCode.js';-->
<!--            (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(mtTracking);-->
<!--        })();-->
<!--    </script>-->
    <style type="text/css">
        .social{
            margin-top: 15px;
            text-align: center;
            position: relative;
        }
        .social .or{
            position: relative;
            text-align: center;
            line-height: 45px;
        }
        .social .or::after{
            content: '';
            width: 100%;
            height: 1px;
            background: #ccc;
            top: 50%;
            left: 0;
            transform: translate(0, -50%);
            position: absolute;
        }
        .social .or span{
            position: relative;
            z-index: 5;
            background: #fff;
            padding: 0 15px;
        }
        .social button{
            border:none;
            padding:15px;
            width:50px;
            font-size:25px;
            background-color:#fff;
            margin-left:10px;
            margin-right:10px;
            border-radius:50%;
        }
        .social .fa-instagram{
            color: transparent;
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
            background: -webkit-radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
            background-clip: text;
            -webkit-background-clip: text;
        }
        .social .facebook{
            color:#012677;
        }
        .social .google{
            color:#D50F25;
        }
        .social p{
            font-size:12px;
        }
        .social p.dont{
            padding-top:165px;
            font-size:13px;
        }
        @import url("https://fast.fonts.net/lt/1.css?apiType=css&c=f98384f2-47d2-4642-aecf-2e7d78ccc4f4&fontids=692088");
        @font-face{
            font-family:"Century Gothic W01";
            src:url("<?php echo base_url(); ?>tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix");
            src:url("<?php echo base_url(); ?>tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix") format("eot"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/700cfd4c-3384-4654-abe1-aa1a6e8058e4.woff2") format("woff2"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/9908cdad-7524-4206-819e-4f345a666324.woff") format("woff"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/b710c26a-f1ae-4fb8-a9fe-570fd829cbf1.ttf") format("truetype");
        }
    </style>


      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Didact+Gothic:300,400,600,700,300italic,400italic,600italic">
      <script>
          $(function () {
              $('[data-toggle="tooltip"]').tooltip({'delay': { show: 50, hide: 30 }
              });
          })
      </script>

  </head>
  <body>
  <div class="container">
    <!-- <body class="hold-transition login-page"> -->
    <div class="login-box">
        <div class="login-logo">
            <img border="0" src="<?php echo base_url(); ?>tiqsimg/tiqslogo.png" alt="tiqs" width="125" height="125" />
            <!-- <a href="#"><b>tiqs</b><br>flow</a>-->
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <p  style="font-family:'Century Gothic W01'; font-size:300%; text-align: center">Register</p>
            <?php $this->load->helper('form'); ?>
            <?php echo $this->session->flashdata('fail'); ?>
            <div class="row">
                <div class="col-md-12" id="mydivs">
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                </div>
<!--                <script>-->
<!--                    setTimeout(function() {-->
<!--                        $('#mydivs').hide('fade');-->
<!--                    }, 5000);-->
<!--                </script>-->
            </div>
            <?php
            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if($error){
                ?>
                <div class="alert alert-danger alert-dismissable" id="mydivs1">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>
                </div>
<!--                <script>-->
<!--                    setTimeout(function() {-->
<!--                        $('#mydivs1').hide('fade');-->
<!--                    }, 5000);-->
<!--                </script>-->
            <?php }
            $success = $this->session->flashdata('success');
            if($success){
                ?>
                <div class="alert alert-success alert-dismissable" id="mydivs2">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $success; ?>
                </div>
<!--                <script>-->
<!--                    setTimeout(function() {-->
<!--                        $('#mydivs2').hide('fade');-->
<!--                    }, 5000);-->
<!--                </script>-->
            <?php }
            $uname=$this->session->userdata('name');
            $email=$this->session->userdata('email');
            $source=$this->session->userdata('source');
            if($source!=''){
                if($source=='insta'){
                    $fullname=$this->session->userdata('full_name');}
                else {$fullname=$uname;}
                ?>
                <div class="alert alert-success alert-dismissable" id="mydivs2">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo "Hi ".$fullname.", Please fill this form to be part of Tiqs"; ?>
                </div>
                <?php
            }
            ?>
            <form action="<?php echo base_url(); ?>login/register" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Full name" value="<?php if($uname!=''){ echo $uname;}?>" name="name"  required />
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" value="<?php if($email!=''){ echo $email;}?>" name="email" required />
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="tel" class="form-control" placeholder="Mobile" name="mobile" required />
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password" required />
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="cpassword" required />
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <!--                <div class="login-box-body">-->
                <!--                    <p  style="font-family:'Century Gothic W01'; font-size:300%; text-align: center">I use flow by tiqs ...</p>-->
                <!---->
                <!--                    <ul>-->
                <!--                        <li>-->
                <!--                            <input type="radio" id="b-option" name="selector" value="2" />-->
                <!--                            <label for="b-option" data-toggle="tooltip" data-placement="bottom" title="Click/select this when you use tiqs at your event or in your restaurant and/or bar. You can immediately collect e-mail addresses to engage with your visitors. A proven way in customer retention." >for my Events, Restaurant, Bar, Beachclub</label>-->
                <!---->
                <!--                            <div class="check"><div class="inside"></div></div>-->
                <!--                        </li>-->
                <!---->
                <!--                        <li>-->
                <!--                            <input type="radio" id="a-option" name="selector" value="1" />-->
                <!--                            <label for="a-option" data-toggle="tooltip" data-placement="bottom" title="Click/select this when you use tiqs at your shop or store. You collect immediately e-mail addresses to engage with your visitors. A proven way for customer retention." >for my shop or store,</label>-->
                <!---->
                <!--                            <div class="check"><div class="inside"></div></div>-->
                <!--                        </li>-->
                <!---->
                <!---->
                <!--                        <li>-->
                <!--                            <input type="radio" id="c-option" name="selector" value="2">-->
                <!--                            <label for="c-option" data-toggle="tooltip" data-placement="bottom" title="Click/select this when you use tiqs at your Hotel, B&B or Vacation Rental. You can immediately collect e-mail addresses to engage with your visitors. A proven way in customer retention." >for my Hotel, B&B or Vacation Rental,</label>-->
                <!--                            <div class="check"><div class="inside"></div></div>-->
                <!--                        </li>-->
                <!---->
                <!--                        <li>-->
                <!--                            <input type="radio" id="d-option" name="selector" value="3">-->
                <!--                            <label for="d-option" data-toggle="tooltip" data-placement="bottom" title="Click/select to become a Wolf-Pack member of the flowteam. Earn continuously money with tiqs." >as tiqs Ambassador (Wolf-Pack).</label>-->
                <!--                            <div class="check"><div class="inside"></div></div>-->
                <!--                        </li>-->
                <!---->
                <!--                    </ul>-->
                <!--                <br>-->
                <!---->
                <!--            </div>-->

                <div>
                    <p style="font-family:'Century Gothic W01'; font-size:100%; color: #ff5722; margin:20px,20px,20px,200px; text-align: center"><span>Your consent</span></p>
                </div>
                <p <br /></p>
                <div>
                    <p style="font-family:'Century Gothic W01'; font-size:100%; color:#000000; margin:20px,20px,20px,200px; text-align: center">By clicking the "Sign me up" button, you agree to our Terms of use, explicit e-mail opt-in, Privacy policy and Disclaimer.<br /></p>
                </div>
                <br>

                <div class="row">
                    <div class="col-xs-8"></div><!-- /.col -->
                    <div style="text-align: center">
                        <input type="submit" class="myButtonOrange" value="Sign me up..." />
                    </div>
                    <br>
                    <div class="col-xs-8">
                        <a href="<?php echo base_url() ?>" style="font-family:Century Gothic W01" >Back to login</a><br>
                    </div>
                </div><!-- /.login-box-body -->
            </form>
<!--            <div class="social">-->
<!--                <div class="or"><span>Or sign up with</span></div>-->
<!--                <a href="--><?//= base_url(); ?><!--login/insta"><button class="instagram"><i class="fa fa-instagram"></i></button></a>-->
<!--                <a href="--><?//= base_url(); ?><!--login/facebook"><button class="facebook"><i class="fa fa-facebook"></i></button></a>-->
<!--                <a href="--><?//= base_url(); ?><!--login/google"><button class="google"><i class="fa fa-google-plus"></i></button></a>-->
<!--            </div>-->
        </div><!-- /.login-box -->
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
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
