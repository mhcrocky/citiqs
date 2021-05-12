<!DOCTYPE html>
<html>
  <head>
      <link rel="shortcut icon" href="https://tiqs.com/tiqsimg/tiqslogo.png" />
        <meta charset="UTF-8">
        <title>tiqs | Register your code</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>tiqscss/tiqscss.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>tiqscss/tiqsballoontip.css" rel="stylesheet" type="text/css" />

      <link href="<?php echo base_url(); ?>assets/css/flags.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/css/flat/32/flags.css" rel="stylesheet" type="text/css" />

      <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.0.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/js/tooltipster.bundle.min.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="<?php #echo $this->baseUrl; ?>assets/cdn/js/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<!--      <script type="text/javascript">-->
<!--          var MTUserId='f98384f2-47d2-4642-aecf-2e7d78ccc4f4';-->
<!--          var MTFontIds = new Array();-->
<!---->
<!--          MTFontIds.push("692088"); // Century Gothic™ W01 Regular-->
<!--          (function() {-->
<!--              var mtTracking = document.createElement('script');-->
<!--              mtTracking.type='text/javascript';-->
<!--              mtTracking.async='true';-->
<!--              mtTracking.src='mtiFontTrackingCode.js';-->
<!---->
<!--              (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(mtTracking);-->
<!--          })();-->
<!--      </script>-->

    <style type="text/css">
        .social{
            margin-top: 5px;
            text-align: center;
            position: relative;
        }
        .social .or{
            position: relative;
            text-align: center;
            line-height: 15px;
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
            padding: 0 5px;
        }
        .social button{
            border:none;
            padding:20px;
            width:100px;
            font-size:25px;
            background-color:#fff;
            margin-left:10px;
            margin-right:10px;
            border-radius:100%;
        }
        .social .fa-instagram{
            color: transparent;
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
            background: -webkit-radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
            background-clip: text;
            -webkit-background-clip: text;
        }
        .social .fa{
            color: #ffffff;
            padding: 20px;
            font-size: 30px;
            width: 100%;
            text-align: center;
            text-decoration: none;
            border-radius: 50%;
        }
        .fa:hover {
            opacity: 0.7;
        }

        .fa-facebook {
            background: #012677;
            color: white;
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


        @font-face {
            font-family: 'caption-bold';
            src: url('<?php echo base_url(); ?>tiqscss/Fonts/caption-bold-webfont.woff2') format('woff2'),
            url('<?php echo base_url(); ?>tiqscss/Fonts/caption-bold-webfont.woff') format('woff');
            font-weight: normal;
            font-style: normal;
            font-family: 'caption-light';
            src: url('<?php echo base_url(); ?>tiqscss/Fonts/caption-light-webfont.woff2') format('woff2'),
            url('<?php echo base_url(); ?>tiqscss/Fonts/caption-light-webfont.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'caption-bold';
            src: url('<?php echo base_url(); ?>tiqscss/Fonts/caption-bold-webfont.woff2') format('woff2'),
            url('<?php echo base_url(); ?>tiqscss/Fonts/caption-bold-webfont.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }


        input[type="checkbox"] {
            zoom: 3;
            }

    </style>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({'delay': { show: 3000, hide: 1 }});
        })
    </script>


      <style>
          .login-box,
          .register-box {
              width: 360px;
              margin: auto;
          }
          @media (max-width: 768px) {
              .login-box,
              .register-box {
                  width: 90%;
                  /*margin-top: 20px;*/
              }
          }
          .login-box-body,
          .register-box-body {
              background: #fff;
              padding: 20px;
              border-top: 0;
              color: #666;
          }
          .login-box-body .form-control-feedback,
          .register-box-body .form-control-feedback {
              color: #777;
          }
          .login-box-msg,
          .register-box-msg {
              font-family:"Century Gothic";
              font-weight: bold;
              font-size: larger;
              margin: 0;
              text-align: center;
              /*padding: 0 20px 20px 20px;*/
          }

          .wrapper {
              padding: 5px;
              max-width: 960px;
              width: 100%;
              margin: 20px auto;
          }
          header {
              padding: 0 15px;
          }

          .columns {
              display: flex;
              flex-flow: row wrap;
              justify-content: center;
              margin: 0px 0;
          }

          .column {
              flex: 1;
              border: 1px solid gray;
              margin: 2px;
              padding: 10px;
          &:first-child { margin-left: 0; }
          &:last-child { margin-right: 0; }

          }

          footer {
              padding: 0 15px;
          }


          @media screen and (max-width: 980px) {
              .columns .column {
                  margin-bottom: 5px;
                  flex-basis: 40%;
          &:nth-last-child(2) {
               margin-right: 0;
           }
          &:last-child {
               flex-basis: 100%;
               margin: 0;
           }
          }
          }

          @media screen and (max-width: 680px) {
              .columns .column {
                  flex-basis: 100%;
                  margin: 0 0 5px 0;
              }
          }

          .row.no-gutters {
              margin-right: 0;
              margin-left: 0;
          }
          .row.no-gutters > [class^="col-"],
          .row.no-gutters > [class*=" col-"] {
              padding-right: -1px;
              padding-left: -1px;
          }

          .column.no-gutters {
              margin-right: 0;
              margin-left: 0;
          }
          .column.no-gutters > [class^="col-"],
          .column.no-gutters > [class*=" col-"] {
              padding-right: -1px;
              padding-left: -1px;
          }


      </style>

      <script>
          $(function () {
              $('[data-toggle="tooltip"]').tooltip({'delay': { show: 3000, hide: 1 }});
          })
      </script>

</head>
<body>
<div class="content">
    <!-- <body class="hold-transition login-page"> -->
    <div class="content">
        <div class="content">
            <div class="login-logo">
                <img border="0" src="<?php echo base_url(); ?>tiqsimg/tiqslogo.png" alt="tiqs" width="125" height="125" />
                <!-- <a href="#"><b>tiqs</b><br>flow</a>-->
            </div><!-- /.login-logo -->

            <p align="center"</p>
            <a href="<?php echo base_url() ?>switchlang/english"><span class="flag flag-gb"></span></a>
            <a href="<?php echo base_url() ?>switchlang/nl"><span class="flag flag-nl"></span></a>
            <a href="<?php echo base_url() ?>switchlang/it"><span class="flag flag-it"></span></a>
            <a href="<?php echo base_url() ?>switchlang/es"><span class="flag flag-es"></span></a>
            <a href="<?php echo base_url() ?>switchlang/de"><span class="flag flag-de"></span></a>
            <a href="<?php echo base_url() ?>switchlang/fr"><span class="flag flag-fr"></span></a>
            <p  style="font-family:'Century Gothic W01'; font-size:100%; text-align: center"><?php echo $this->language->line('Select your language');?></p>

            <!-- <p class="login-box-msg" style="font-weight: bold font-family:"Century Gothic" font-size: larger">Login</p> -->
            <p  style="font-family:'Century Gothic W01'; font-size:100%; color: #ff5722; text-align: center"><?php echo $this->language->line('Your personal tag-code');?><br></p>
            <div>
                <p  style="font-family:'Century Gothic W01'; font-size:300%; color: #000000; text-align: center"><?php $code;?><br></p>
            </div>
            <?php
            $this->load->helper('form');
            echo $this->session->flashdata('fail'); ?>
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
                <div id="mydivs1">
                    <div class="alert alert-danger alert-dismissable" id="mydivs">
                        <button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $error; ?>
                    </div>
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
            <?php } ?>
            <form action="<?php echo base_url(); ?>checkregister" method="post">
                <?php if (empty($code)) { ?>
                    <div class="login-box" >
                    <div class="form-group has-feedback">
                        <input type="code" class="form-control" placeholder="Code" name="code" data-toggle="tooltip"
                               data-placement="top" title="Enter the code on your sticker or tag" required/>
                        <span class="glyphicon glyphicon-qrcode form-control-feedback" data-toggle="tooltip"
                              data-placement="top" title="Tooltip on top"></span>
                    </div>
                    </div>
                    <?php
                }
                ?>

                    <div class="form-group has-feedback" style="font-family:'Century Gothic W01'; font-size:100%; color: rgba(0,0,0,0.35); margin:20px,20px,20px,200px; text-align: center">
                        <input type="checkbox" name="ismyphone" />
                        <label for="checkboxconsent"><?php echo $this->language->line('Check this box, when your code is attached to your mobile phone. (SMS will be send to your friends phone)');?></label>
                        <!--                    <span class="glyphicon glyphicon-envelope form-control-feedback" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></span>-->
                    </div>

                    <div>
                        <p style="font-family:'Century Gothic W01'; font-size:300%; color: #ff5722; margin:20px,20px,20px,200px; text-align: center"><span><?php echo $this->language->line('How it works..');?></span></p>
                    </div>
                    <p <br /></p>
                    <div>
                        <p style="font-family:'Century Gothic W01'; font-size:100%; color:#000000; margin:20px,20px,20px,200px; text-align: center"><?php echo $this->language->line('Your code is registered on your e-mail account. ');?><br> <br><?php echo $this->language->line('In your personal dashboard, the login info, is send to you, by separate mail - PLEASE CHECK YOUR SPAM - ');?><?php echo $this->language->line(' , you can add a picture of the item, and add your address. ');?><br>  <br /></p>
                    </div>
                    <p <br /></p>
                <div class="login-box" >
                    <div>
                        <p style="font-family:'Century Gothic W01'; font-size:100%; color:#000000; margin:20px,20px,20px,200px; text-align: center"><?php echo $this->language->line('Your mobile phone number for SMS when someone finds this registered item. Number formatted as country code and phone number 0099123456789');?><br>  <br /></p>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="tel" value="<?php $mobile;?>" class="form-control" placeholder="<?php echo $this->language->line('Your mobile number');?>"  name="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->language->line('Your mobile number is only used by tiqs we do not share any mobile number with 3rd parties!');?>" />
                        <span class="glyphicon glyphicon-phone form-control-feedback" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></span>
                    </div>
                    <p <br><br /></p>
                    <div>
                        <p style="font-family:'Century Gothic W01'; font-size:100%; color:#000000; margin:20px,20px,20px,200px; text-align: center"><?php echo $this->language->line('Your friends mobile number, when you lost your phone. Number formatted as country code and phone number 0099123456789');?><br>  <br /></p>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="tel" value="<?php $lfbuddymobile;?>"class="form-control" placeholder="<?php echo $this->language->line('Your friends mobile number');?>" name="lfbuddymobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->language->line('Your mobile number is only used by tiqs we do not share any mobile number with 3rd parties!');?>" />
                        <span class="glyphicon glyphicon-phone form-control-feedback" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></span>
                    </div>
                    <p <br><br /></p>
                    <div class="login-box">
                        <p style="font-family:'Century Gothic W01'; font-size:100%; color:#000000; margin:20px,20px,20px,200px; text-align: center"><?php echo $this->language->line('Your e-mail address for registration');?><br>  <br /></p>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="email" value="<?php $email;?>" class="form-control" placeholder="<?php echo $this->language->line('Your e-mail');?>" name="email" data-toggle="tooltip" data-placement="top" title="<?php echo $this->language->line('Your e-mail address is only used by tiqs we do not share any e-mail addresses with 3rd parties!');?>" required />
                        <span class="glyphicon glyphicon-envelope form-control-feedback" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" value="<?php $email;?>" class="form-control" placeholder=<?php echo $this->language->line("Repeat email for verification");?> name="emailverify"  required />
                        <span class="glyphicon glyphicon-envelope form-control-feedback" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></span>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <!--
                    <div class="col-xs-2">
                        <div class="checkbox icheck">
                           <label>
                            <input type="checkbox"> Remember Me
                          </label>
                        </div>
                    </div>
                    -->

                    <!-- <div class="col-xs-8"> -->
                    <!-- <input type="submit" class="btn btn-primary btn-block btn-flat" value="Sign In" /> -->
                    <div>
                        <p style="font-family:'Century Gothic W01'; font-size:100%; color: #ff5722; margin:20px,20px,20px,200px; text-align: center"><span><?php echo $this->language->line("Your consent");?></span></p>
                    </div>
                    <p <br /></p>
                <div>
                    <p style="font-family:'Century Gothic W01'; font-size:100%; color:#000000; margin:20px,20px,20px,200px; text-align: center"><?php echo $this->language->line("By clicking the \"Register\" button, ");?><?php echo $this->language->line("you agree to our Terms of use, explicit e-mail opt-in, Privacy policy and Disclaimer.");?><br /></p>
                </div>
                    <br>
                    <div style="text-align: center">
                        <input type="submit" class="myButtonOrange" value=<?php echo $this->language->line("Register");?> />
                    </div><br>
                </div>

<!--            <div class="social" center>-->
<!--                <div class="or"; style="font-family:'Century Gothic W01'; font-size:100%; color: #000000; text-align: center"><span><?//=$this->language->line("Or register via");?></span></div>-->
<!--                <a href="--><?//= base_url(); ?><!--checkinsta"><button class="instagram"><i class="fa fa-instagram"></i></button></a>-->
<!--                <a href="--><?//= base_url(); ?><!--checkfacebook"><button class="facebook"><img border="0" src="--><?php //echo base_url(); ?><!--tiqsimg/f_logo_RGB-Blue_250.png" alt="facebook" width="60" height="60" /></button></a>-->
<!---->
<!--                <button type="submit" class="facebook" formaction="--><?php //echo base_url(); ?><!--checkfacebook">-->
<!--                    <img border="0" src="--><?php //echo base_url(); ?><!--tiqsimg/f_logo_RGB-Blue_250.png" alt="facebook" width="60" height="60" />-->
<!--                </button>-->
<!--                <a href="--><?//= base_url(); ?><!--checkgoogle"><button class="google"><i class="fa fa-google-plus"></i></button></a>-->
<!--            </div>-->
            </form>
        </div><!-- /.login-box-body -->
        <div class="row" align="center" >
        <a href="https://lostandfound.tips" ><font size="4"  color="white"><?php echo $this->language->line("Back to menu");?></font></a><br>
        </div>
    </div><!-- /.login-box -->
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
