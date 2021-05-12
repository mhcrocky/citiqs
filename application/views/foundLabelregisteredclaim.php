<!DOCTYPE html>
<html>
  <head>
      <link rel="shortcut icon" href="https://tiqs.com/tiqsimg/tiqslogo.png" />
        <meta charset="UTF-8">
        <title>tiqs | Item Claim </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>tiqscss/tiqscss.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>tiqscss/tiqsballoontip.css" rel="stylesheet" type="text/css" />

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
<!---->
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

      </style>
</head>
<body>
<div class="content">
    <!-- <body class="hold-transition login-page"> -->
    <div class="login-box">
        <div class="login-logo">
            <img border="0" src="<?php echo base_url(); ?>tiqsimg/lostandfoundleftblue.png" alt="tiqs" width="125" height="125" />
            <!-- <a href="#"><b>tiqs</b><br>flow</a>-->
        </div><!-- /.login-logo -->

        <div class="login-box-body">
            <!-- <p class="login-box-msg" style="font-weight: bold font-family:"Century Gothic" font-size: larger">Login</p> -->
            <p  style="font-family:'Century Gothic W01'; font-size:300%; text-align: center">Item claimed successfully</p>
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
            <br>
            <div class="social">
                <div class="or"><span>Successfully registered your claimed item!</span></div>
                <a href="<?php echo base_url() ?>login/index">
                    <input type="button" class="myButtonLightOrange" value="Go to homepage" />
                </a>
            </div>
        </div><!-- /.login-box-body -->
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
