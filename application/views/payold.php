<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/pricing-style.css">
</head>
<body>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://tiqs.com/lostandfound/assets/home/styles/pricing-section.css">
</head>
<body>

<div class="main-wrapper main-wrapper-contact" align="center">
	<div class="col-half background-yankee height-100">
		<div class="flex-column align-start "><!-- width-650 -->
			<div align="left">
				<h2 class="heading mb-35">
					PAY YOUR SUBSCRIPTION</h2>
				<?php
				$this->load->helper('form');
				echo $this->session->flashdata('fail'); ?>
				<div class="row">
					<div class="col-md-12" id="mydivs">
						<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
					</div>
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
				<?php }
				$success = $this->session->flashdata('success');
				if($success){
					?>
					<div class="alert alert-success alert-dismissable" id="mydivs2">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $success; ?>
					</div>
				<?php } ?>
				<form action="<?php echo base_url(); ?>payregisterandpaysubscription" method="post">
					<div class="form-group has-feedback">
						<select class="form-control" id="subscriptionid" placeholder="Category" name="subscriptionid" value="" maxlength="128">
							<?php
							foreach ($subscriptions as $row)
							{
								if ($subscriptionid == $row['id'])
									echo '<option selected value="'.$row['id'].'">';
								else
									echo '<option value="'.$row['id'].'">';
								echo($row['description'].' - &euro;'.number_format($row['amount'], 2).'</option>');
							}
							?>
						</select>
					</div>
					<div class="form-group has-feedback">
						<input type="email" value="<?php $email;?>" class="form-control" placeholder="Email" name="email" data-toggle="tooltip" data-placement="top" title="Your e-mail address is only used by tiqs we do not share any e-mail addresses with 3rd parties!" required />
						<span class="glyphicon glyphicon-envelope form-control-feedback" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></span>
					</div>

					<div class="form-group has-feedback">
						<input type="email" value="<?php $email;?>" class="form-control" placeholder="Repeat email for verification" name="emailverify"  required />
						<span class="glyphicon glyphicon-envelope form-control-feedback" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></span>
					</div>

					<?php
					if ($subscriptionid == 3)
					{
						?>
						<div class="row">
							<div>
								<p style="font-family:'Century Gothic W01'; font-size:100%; color: #ff5722; text-align: center"><span>Payment option & Consent</span></p>
							</div>
							<p <br /></p>
							<div>
								<p style="font-family:'Century Gothic W01'; font-size:100%; color: #000000; text-align: center">By clicking the "PayPal" or "Visa" or "Mastercard" button or fill e-mail above with "facebook" button, you agree to our Terms of use, Privacy policy and Disclaimer<br /></p>
							</div>
							<br>
							<div style="text-align: center">
								<input name="paypal" type="image" src="<?php echo base_url(); ?>tiqsimg/paypal.png" alt="Paypal" />
								<input name="visamastercard" type="image" src="<?php echo base_url(); ?>tiqsimg/visamastercard.png" alt="Visa or Mastercard" />
							</div><br>
						</div>
						<?php
					}
					else
					{
						?>
							<div style="text-align: center">
								<input type="submit" class="myButtonOrange" value="Pay subscription"/>
							</div>
						<?php
					}
					?>

			</div>
	</div><!-- end col half-->

	<div class="col-half background-blue timeline-content">
		<div class="pricing-block background-orange-light">
			<div class="pricing-block-body">
				<div class="pricing-first" style="font-family: caption-bold">
					<h2 style="font-family: caption-bold">STARTER</h2>
					<h6 style="font-family: caption-light">PRICE PER YEAR</h6>
					<h1 style="font-family: caption-light">€ 9,95</h1>
					<p style="font-family: caption-light">STRAIGHT FORWARD ONE FEE PER YEAR EASY REGISTRATION</p>
				</div>
				<div class="pricing-second">
					<ul >
						<li>
							PER E-MAIL ACCOUNT
						</li>
						<li>
							UNLIMITED ITEMS
						</li>
						<li>
							NOTIFICATION ONLY BY E-MAIL
						</li>
						<li>
							RETURN FEE DISCOUNT 0%
						</li>
					</ul>
				</div>
			</div><!-- end pricing block body -->
			<div class="pricing-block-footer">
				<a data-brackets-id="2918" href="<?php echo base_url(); ?>/pay/1" class="button button-orange"><img src="pay.png" alt="">PAY</a>
			</div>
		</div><!-- end pricing block -->

		<div class="pricing-block background-orange">
			<div class="pricing-block-body">
				<div class="pricing-first" style="font-family: caption-bold">
					<h2 style="font-family: caption-bold">BASIC</h2>
					<h6 style="font-family: caption-light">PRICE PER MONTH</h6>
					<h1 style="font-family: caption-bold">€ 1,50</h1>
					<p style="font-family: caption-light">STRAIGHT FORWARD FEE PER MONTH EASY REGISTRATION OF UNLIMTED ITEMS</p>
				</div>
				<div class="pricing-second">
					<ul >
						<li>
							MOST CHOSEN OPTION
						</li>
						<li>
							PER E-MAIL ACCOUNT
						</li>
						<li>
							UNLIMITED ITEMS
						</li>
						<li>
							NOTIFICATION BY E-MAIL, SMS AND IM
						</li>
						<li>
							RETURN FEE DISCOUNT 10%
						</li>
					</ul>
				</div>
			</div><!-- end pricing block body -->
			<div class="pricing-block-footer">
				<a data-brackets-id="2918" href="<?php echo base_url(); ?>/pay/1" class="button button-orange"><img src="pay.png" alt="">PAY</a>
			</div>
		</div><!-- end pricing block -->

		<div class="pricing-block background-purple-light">
			<div class="pricing-block-body">
				<div class="pricing-first" style="font-family: caption-bold">
					<h2 style="font-family: caption-bold">EXTREME</h2>
					<h6 style="font-family: caption-light">PRICE PER 3 YEARS</h6>
					<h1 style="font-family: caption-light">€ 24,95</h1>
					<p style="font-family: caption-light">STRAIGHT FORWARD ONE FEE PER YEAR EASY REGISTRATION</p>
				</div>
				<div class="pricing-second">
					<ul >
						<li>
							PER E-MAIL ACCOUNT
						</li>
						<li>
							UNLIMITED ITEMS
						</li>
						<li>
							NOTIFICATION ONLY BY E-MAIL
						</li>
						<li>
							RETURN FEE DISCOUNT 5%
						</li>
					</ul>
				</div>
			</div><!-- end pricing block body -->
			<div class="pricing-block-footer">
				<a data-brackets-id="2918" href="<?php echo base_url(); ?>/pay/1" class="button button-orange"><img src="pay.png" alt="">PAY</a>
			</div>
		</div><!-- end pricing block -->
	</div>
	<!-- end pricing -->


</div>

<!-- end main wrapper -->




</body>
</html>




<script>
	$(document).ready(function(){

		if($(document).width() <= 768){
			var pricing_details_button = $('.pricing-details-button');
			$('.pricing-details-list').hide();
			$( document ).width();
			$(pricing_details_button).click(function(){
				$(this).parents('.pricing-component-body').find('.pricing-details-list').toggle('300');

			})
		}
	})
</script>
</body>
</html>


<!---->
<!---->
<!---->
<!--<!DOCTYPE html>-->
<!--<html>-->
<!--  <head>-->
<!--      <link rel="shortcut icon" href="https://tiqs.com/tiqsimg/tiqslogo.png" />-->
<!--        <meta charset="UTF-8">-->
<!--        <title>tiqs | Pay your subscription</title>-->
<!--        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>-->
<!--        <link href="--><?php //echo base_url(); ?><!--assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->
<!--        <link href="--><?php //echo base_url(); ?><!--assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
<!--        <link href="--><?php //echo base_url(); ?><!--assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />-->
<!--      <link href="--><?php //echo base_url(); ?><!--tiqscss/tiqscss.css" rel="stylesheet" type="text/css" />-->
<!--      <link href="--><?php //echo base_url(); ?><!--tiqscss/tiqsballoontip.css" rel="stylesheet" type="text/css" />-->
<!---->
<!--      <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.0.min.js"></script>-->
<!--        <script type="text/javascript" src="--><?php //echo base_url(); ?><!--assets/dist/js/tooltipster.bundle.min.js"></script>-->
<!--        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->-->
<!--        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->-->
<!--        <!--[if lt IE 9]>-->
<!--            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>-->
<!--            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
<!--        <![endif]-->-->
<!---->
<!--        <!-- Google Font -->-->
<!--        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->
<!---->
<!--<!--      <script type="text/javascript">-->-->
<!--<!--          var MTUserId='f98384f2-47d2-4642-aecf-2e7d78ccc4f4';-->-->
<!--<!--          var MTFontIds = new Array();-->-->
<!--<!---->-->
<!--<!--          MTFontIds.push("692088"); // Century Gothic™ W01 Regular-->-->
<!--<!--          (function() {-->-->
<!--<!--              var mtTracking = document.createElement('script');-->-->
<!--<!--              mtTracking.type='text/javascript';-->-->
<!--<!--              mtTracking.async='true';-->-->
<!--<!--              mtTracking.src='mtiFontTrackingCode.js';-->-->
<!--<!---->-->
<!--<!--              (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(mtTracking);-->-->
<!--<!--          })();-->-->
<!--<!--      </script>-->-->
<!---->
<!--    <style type="text/css">-->
<!--        .social{-->
<!--            margin-top: 5px;-->
<!--            text-align: center;-->
<!--            position: relative;-->
<!--        }-->
<!--        .social .or{-->
<!--            position: relative;-->
<!--            text-align: center;-->
<!--            line-height: 15px;-->
<!--        }-->
<!--        .social .or::after{-->
<!--            content: '';-->
<!--            width: 100%;-->
<!--            height: 1px;-->
<!--            background: #ccc;-->
<!--            top: 50%;-->
<!--            left: 0;-->
<!--            transform: translate(0, -50%);-->
<!--            position: absolute;-->
<!--        }-->
<!--        .social .or span{-->
<!--            position: relative;-->
<!--            z-index: 5;-->
<!--            background: #fff;-->
<!--            padding: 0 5px;-->
<!--        }-->
<!--        .social button{-->
<!--            border:none;-->
<!--            padding:20px;-->
<!--            width:100px;-->
<!--            font-size:25px;-->
<!--            background-color:#fff;-->
<!--            margin-left:10px;-->
<!--            margin-right:10px;-->
<!--            border-radius:100%;-->
<!--        }-->
<!--        .social .fa-instagram{-->
<!--            color: transparent;-->
<!--            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);-->
<!--            background: -webkit-radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);-->
<!--            background-clip: text;-->
<!--            -webkit-background-clip: text;-->
<!--        }-->
<!--        .social .fa{-->
<!--            color: #ffffff;-->
<!--            padding: 20px;-->
<!--            font-size: 30px;-->
<!--            width: 100%;-->
<!--            text-align: center;-->
<!--            text-decoration: none;-->
<!--            border-radius: 50%;-->
<!--        }-->
<!--        .fa:hover {-->
<!--            opacity: 0.7;-->
<!--        }-->
<!---->
<!--        .fa-facebook {-->
<!--            background: #012677;-->
<!--            color: white;-->
<!--        }-->
<!---->
<!---->
<!--        .social .google{-->
<!--            color:#D50F25;-->
<!--        }-->
<!--        .social p{-->
<!--            font-size:12px;-->
<!--        }-->
<!--        .social p.dont{-->
<!--            padding-top:165px;-->
<!--            font-size:13px;-->
<!--        }-->
<!--        @import url("https://fast.fonts.net/lt/1.css?apiType=css&c=f98384f2-47d2-4642-aecf-2e7d78ccc4f4&fontids=692088");-->
<!--        @font-face{-->
<!--            font-family:"Century Gothic W01";-->
<!--            src:url("--><?php //echo base_url(); ?>/*tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix");*/
/*            src:url("*/<?php //echo base_url(); ?>/*tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix") format("eot"),url("*/<?php //echo base_url(); ?>/*tiqscss/Fonts/692088/700cfd4c-3384-4654-abe1-aa1a6e8058e4.woff2") format("woff2"),url("*/<?php //echo base_url(); ?>/*tiqscss/Fonts/692088/9908cdad-7524-4206-819e-4f345a666324.woff") format("woff"),url("*/<?php //echo base_url(); ?>/*tiqscss/Fonts/692088/b710c26a-f1ae-4fb8-a9fe-570fd829cbf1.ttf") format("truetype");*/
/*        }*/
/*    </style>*/
/*    <script>*/
/*        $(function () {*/
/*            $('[data-toggle="tooltip"]').tooltip({'delay': { show: 3000, hide: 1 }});*/
/*        })*/
/*    </script>*/
/*</head>*/
/*<body>*/
/*<div class="content">*/
/*    <!-- <body class="hold-transition login-page"> -->*/
/*    <div class="login-box">*/
/**/
/*        <div class="content">*/
/*            <div class="login-logo">*/
/*                <img border="0" src="*/<?php //echo base_url(); ?><!--tiqsimg/tiqslogo.png" alt="tiqs" width="125" height="125" />-->
<!--                <!-- <a href="#"><b>tiqs</b><br>flow</a>-->-->
<!--            </div><!-- /.login-logo -->-->
<!---->
<!--            <!-- <p class="login-box-msg" style="font-weight: bold font-family:"Century Gothic" font-size: larger">Login</p> -->-->
<!--            <p  style="font-family:'Century Gothic W01'; font-size:100%; color: #ff5722; text-align: center">Pay your subscription<br></p>-->
<!---->
<!--            --><?php
//            $this->load->helper('form');
//            echo $this->session->flashdata('fail'); ?>
<!--            <div class="row">-->
<!--                <div class="col-md-12" id="mydivs">-->
<!--                    --><?php //echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
<!--                </div>-->
<!--<!--                <script>-->-->
<!--<!--                    setTimeout(function() {-->-->
<!--<!--                        $('#mydivs').hide('fade');-->-->
<!--<!--                    }, 5000);-->-->
<!--<!--                </script>-->-->
<!--            </div>-->
<!--            --><?php
//            $this->load->helper('form');
//            $error = $this->session->flashdata('error');
//            if($error){
//                ?>
<!--                <div id="mydivs1">-->
<!--                    <div class="alert alert-danger alert-dismissable" id="mydivs">-->
<!--                        <button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
<!--                        --><?php //echo $error; ?>
<!--                    </div>-->
<!--                </div>-->
<!--<!--                <script>-->-->
<!--<!--                    setTimeout(function() {-->-->
<!--<!--                        $('#mydivs1').hide('fade');-->-->
<!--<!--                    }, 5000);-->-->
<!--<!--                </script>-->-->
<!--            --><?php //}
//            $success = $this->session->flashdata('success');
//            if($success){
//                ?>
<!--                <div class="alert alert-success alert-dismissable" id="mydivs2">-->
<!--                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
<!--                    --><?php //echo $success; ?>
<!--                </div>-->
<!--<!--                <script>-->-->
<!--<!--                    setTimeout(function() {-->-->
<!--<!--                        $('#mydivs2').hide('fade');-->-->
<!--<!--                    }, 5000);-->-->
<!--<!--                </script>-->-->
<!--            --><?php //} ?>
<!--            <form action="--><?php //echo base_url(); ?><!--payregisterandpaysubscription" method="post">-->
<!---->
<!--                <div class="form-group has-feedback">-->
<!--                    <select class="form-control" id="subscriptionid" placeholder="Category" name="subscriptionid" value="" maxlength="128">-->
<!--                        --><?php
//                        foreach ($subscriptions as $row)
//                        {
//                            if ($subscriptionid == $row['id'])
//                                echo '<option selected value="'.$row['id'].'">';
//                            else
//                                echo '<option value="'.$row['id'].'">';
//                            echo($row['description'].' - &euro;'.number_format($row['amount'], 2).'</option>');
//                        }
//                        ?>
<!--                    </select>-->
<!--                </div>-->
<!---->
<!--                <div class="form-group has-feedback">-->
<!--                    <input type="email" value="--><?//=$email;?><!--" class="form-control" placeholder="Email" name="email" data-toggle="tooltip" data-placement="top" title="Your e-mail address is only used by tiqs we do not share any e-mail addresses with 3rd parties!" required />-->
<!--                    <span class="glyphicon glyphicon-envelope form-control-feedback" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></span>-->
<!--                </div>-->
<!---->
<!--                <div class="form-group has-feedback">-->
<!--                    <input type="email" value="--><?//=$email;?><!--" class="form-control" placeholder="Repeat email for verification" name="emailverify"  required />-->
<!--                    <span class="glyphicon glyphicon-envelope form-control-feedback" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></span>-->
<!--                </div>-->
<!---->
<!--                --><?php //if ($this->user_model->getaddressexist($this->security->xss_clean($this->input->post('email')))) { ?>
<!--                    <div class="form-group has-feedback" style="padding: 10px" >-->
<!--                        <input type="code" class="form-control" placeholder="--><?//=$this->language->line("PAY-100",'Register your address');?><!--" name="code" data-toggle="tooltip"-->
<!--                               data-placement="top" style="font-family:'caption-light'; border-radius: 50px;" title="--><?//=$this->language->line("PAY-110",'Register your address');?><!--" required/>-->
<!---->
<!--                    </div>-->
<!---->
<!--                    --><?php
//                }
//                ?>
<!---->
<!--                <div>-->
<!--                    <p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">-->
<!--                        --><?//=$this->language->line("PAY-115",'Your address, where the');?><!-- lost + found  --><?//=$this->language->line("PAY-120",'will be returned to.');?>
<!--                        <br>-->
<!--                        <br />-->
<!--                    </p>-->
<!--                </div>-->
<!---->
<!--                <div class="login-box" align="center" >-->
<!---->
<!--                    <div class="form-group has-feedback">-->
<!--                        <input type="text" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder=--><?//=$this->language->line("PAY-130","Address");?><!-- name="address" required />-->
<!--                    </div>-->
<!---->
<!--                    <div class="form-group has-feedback">-->
<!--                        <input type="text" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="--><?//=$this->language->line("PAY-140","Additional address line");?><!--" name="addressa"  />-->
<!--                    </div>-->
<!---->
<!--                    <div class="form-group has-feedback">-->
<!--                        <input type="text" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder=--><?//=$this->language->line("PAY-150","Zipcode");?><!-- name="zipcode" required />-->
<!--                    </div>-->
<!---->
<!--                    <div class="form-group has-feedback">-->
<!--                        <input type="text" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder=--><?//=$this->language->line("PAY-160","City");?><!-- name="city" required />-->
<!--                    </div>-->
<!---->
<!--                    <div class="selectWrapper">-->
<!--                        <select class="selectBox" name="country" style="font-family:'caption-light';" required />-->
<!--                        <option value="">--><?//=$this->language->line("PAY-170","Select your country");?><!--</option>-->
<!--                        <option value="AF">Afghanistan</option>-->
<!--                        <option value="AX">Åland Islands</option>-->
<!--                        <option value="AL">Albania</option>-->
<!--                        <option value="DZ">Algeria</option>-->
<!--                        <option value="AS">American Samoa</option>-->
<!--                        <option value="AD">Andorra</option>-->
<!--                        <option value="AO">Angola</option>-->
<!--                        <option value="AI">Anguilla</option>-->
<!--                        <option value="AQ">Antarctica</option>-->
<!--                        <option value="AG">Antigua and Barbuda</option>-->
<!--                        <option value="AR">Argentina</option>-->
<!--                        <option value="AM">Armenia</option>-->
<!--                        <option value="AW">Aruba</option>-->
<!--                        <option value="AU">Australia</option>-->
<!--                        <option value="AT">Austria</option>-->
<!--                        <option value="AZ">Azerbaijan</option>-->
<!--                        <option value="BS">Bahamas</option>-->
<!--                        <option value="BH">Bahrain</option>-->
<!--                        <option value="BD">Bangladesh</option>-->
<!--                        <option value="BB">Barbados</option>-->
<!--                        <option value="BY">Belarus</option>-->
<!--                        <option value="BE">Belgium</option>-->
<!--                        <option value="BZ">Belize</option>-->
<!--                        <option value="BJ">Benin</option>-->
<!--                        <option value="BM">Bermuda</option>-->
<!--                        <option value="BT">Bhutan</option>-->
<!--                        <option value="BO">Bolivia, Plurinational State of</option>-->
<!--                        <option value="BQ">Bonaire, Sint Eustatius and Saba</option>-->
<!--                        <option value="BA">Bosnia and Herzegovina</option>-->
<!--                        <option value="BW">Botswana</option>-->
<!--                        <option value="BV">Bouvet Island</option>-->
<!--                        <option value="BR">Brazil</option>-->
<!--                        <option value="IO">British Indian Ocean Territory</option>-->
<!--                        <option value="BN">Brunei Darussalam</option>-->
<!--                        <option value="BG">Bulgaria</option>-->
<!--                        <option value="BF">Burkina Faso</option>-->
<!--                        <option value="BI">Burundi</option>-->
<!--                        <option value="KH">Cambodia</option>-->
<!--                        <option value="CM">Cameroon</option>-->
<!--                        <option value="CA">Canada</option>-->
<!--                        <option value="CV">Cape Verde</option>-->
<!--                        <option value="KY">Cayman Islands</option>-->
<!--                        <option value="CF">Central African Republic</option>-->
<!--                        <option value="TD">Chad</option>-->
<!--                        <option value="CL">Chile</option>-->
<!--                        <option value="CN">China</option>-->
<!--                        <option value="CX">Christmas Island</option>-->
<!--                        <option value="CC">Cocos (Keeling) Islands</option>-->
<!--                        <option value="CO">Colombia</option>-->
<!--                        <option value="KM">Comoros</option>-->
<!--                        <option value="CG">Congo</option>-->
<!--                        <option value="CD">Congo, the Democratic Republic of the</option>-->
<!--                        <option value="CK">Cook Islands</option>-->
<!--                        <option value="CR">Costa Rica</option>-->
<!--                        <option value="CI">Côte d'Ivoire</option>-->
<!--                        <option value="HR">Croatia</option>-->
<!--                        <option value="CU">Cuba</option>-->
<!--                        <option value="CW">Curaçao</option>-->
<!--                        <option value="CY">Cyprus</option>-->
<!--                        <option value="CZ">Czech Republic</option>-->
<!--                        <option value="DK">Denmark</option>-->
<!--                        <option value="DJ">Djibouti</option>-->
<!--                        <option value="DM">Dominica</option>-->
<!--                        <option value="DO">Dominican Republic</option>-->
<!--                        <option value="EC">Ecuador</option>-->
<!--                        <option value="EG">Egypt</option>-->
<!--                        <option value="SV">El Salvador</option>-->
<!--                        <option value="GQ">Equatorial Guinea</option>-->
<!--                        <option value="ER">Eritrea</option>-->
<!--                        <option value="EE">Estonia</option>-->
<!--                        <option value="ET">Ethiopia</option>-->
<!--                        <option value="FK">Falkland Islands (Malvinas)</option>-->
<!--                        <option value="FO">Faroe Islands</option>-->
<!--                        <option value="FJ">Fiji</option>-->
<!--                        <option value="FI">Finland</option>-->
<!--                        <option value="FR">France</option>-->
<!--                        <option value="GF">French Guiana</option>-->
<!--                        <option value="PF">French Polynesia</option>-->
<!--                        <option value="TF">French Southern Territories</option>-->
<!--                        <option value="GA">Gabon</option>-->
<!--                        <option value="GM">Gambia</option>-->
<!--                        <option value="GE">Georgia</option>-->
<!--                        <option value="DE">Germany</option>-->
<!--                        <option value="GH">Ghana</option>-->
<!--                        <option value="GI">Gibraltar</option>-->
<!--                        <option value="GR">Greece</option>-->
<!--                        <option value="GL">Greenland</option>-->
<!--                        <option value="GD">Grenada</option>-->
<!--                        <option value="GP">Guadeloupe</option>-->
<!--                        <option value="GU">Guam</option>-->
<!--                        <option value="GT">Guatemala</option>-->
<!--                        <option value="GG">Guernsey</option>-->
<!--                        <option value="GN">Guinea</option>-->
<!--                        <option value="GW">Guinea-Bissau</option>-->
<!--                        <option value="GY">Guyana</option>-->
<!--                        <option value="HT">Haiti</option>-->
<!--                        <option value="HM">Heard Island and McDonald Islands</option>-->
<!--                        <option value="VA">Holy See (Vatican City State)</option>-->
<!--                        <option value="HN">Honduras</option>-->
<!--                        <option value="HK">Hong Kong</option>-->
<!--                        <option value="HU">Hungary</option>-->
<!--                        <option value="IS">Iceland</option>-->
<!--                        <option value="IN">India</option>-->
<!--                        <option value="ID">Indonesia</option>-->
<!--                        <option value="IR">Iran, Islamic Republic of</option>-->
<!--                        <option value="IQ">Iraq</option>-->
<!--                        <option value="IE">Ireland</option>-->
<!--                        <option value="IM">Isle of Man</option>-->
<!--                        <option value="IL">Israel</option>-->
<!--                        <option value="IT">Italy</option>-->
<!--                        <option value="JM">Jamaica</option>-->
<!--                        <option value="JP">Japan</option>-->
<!--                        <option value="JE">Jersey</option>-->
<!--                        <option value="JO">Jordan</option>-->
<!--                        <option value="KZ">Kazakhstan</option>-->
<!--                        <option value="KE">Kenya</option>-->
<!--                        <option value="KI">Kiribati</option>-->
<!--                        <option value="KP">Korea, Democratic People's Republic of</option>-->
<!--                        <option value="KR">Korea, Republic of</option>-->
<!--                        <option value="KW">Kuwait</option>-->
<!--                        <option value="KG">Kyrgyzstan</option>-->
<!--                        <option value="LA">Lao People's Democratic Republic</option>-->
<!--                        <option value="LV">Latvia</option>-->
<!--                        <option value="LB">Lebanon</option>-->
<!--                        <option value="LS">Lesotho</option>-->
<!--                        <option value="LR">Liberia</option>-->
<!--                        <option value="LY">Libya</option>-->
<!--                        <option value="LI">Liechtenstein</option>-->
<!--                        <option value="LT">Lithuania</option>-->
<!--                        <option value="LU">Luxembourg</option>-->
<!--                        <option value="MO">Macao</option>-->
<!--                        <option value="MK">Macedonia, the former Yugoslav Republic of</option>-->
<!--                        <option value="MG">Madagascar</option>-->
<!--                        <option value="MW">Malawi</option>-->
<!--                        <option value="MY">Malaysia</option>-->
<!--                        <option value="MV">Maldives</option>-->
<!--                        <option value="ML">Mali</option>-->
<!--                        <option value="MT">Malta</option>-->
<!--                        <option value="MH">Marshall Islands</option>-->
<!--                        <option value="MQ">Martinique</option>-->
<!--                        <option value="MR">Mauritania</option>-->
<!--                        <option value="MU">Mauritius</option>-->
<!--                        <option value="YT">Mayotte</option>-->
<!--                        <option value="MX">Mexico</option>-->
<!--                        <option value="FM">Micronesia, Federated States of</option>-->
<!--                        <option value="MD">Moldova, Republic of</option>-->
<!--                        <option value="MC">Monaco</option>-->
<!--                        <option value="MN">Mongolia</option>-->
<!--                        <option value="ME">Montenegro</option>-->
<!--                        <option value="MS">Montserrat</option>-->
<!--                        <option value="MA">Morocco</option>-->
<!--                        <option value="MZ">Mozambique</option>-->
<!--                        <option value="MM">Myanmar</option>-->
<!--                        <option value="NA">Namibia</option>-->
<!--                        <option value="NR">Nauru</option>-->
<!--                        <option value="NP">Nepal</option>-->
<!--                        <option value="NL">Netherlands</option>-->
<!--                        <option value="NC">New Caledonia</option>-->
<!--                        <option value="NZ">New Zealand</option>-->
<!--                        <option value="NI">Nicaragua</option>-->
<!--                        <option value="NE">Niger</option>-->
<!--                        <option value="NG">Nigeria</option>-->
<!--                        <option value="NU">Niue</option>-->
<!--                        <option value="NF">Norfolk Island</option>-->
<!--                        <option value="MP">Northern Mariana Islands</option>-->
<!--                        <option value="NO">Norway</option>-->
<!--                        <option value="OM">Oman</option>-->
<!--                        <option value="PK">Pakistan</option>-->
<!--                        <option value="PW">Palau</option>-->
<!--                        <option value="PS">Palestinian Territory, Occupied</option>-->
<!--                        <option value="PA">Panama</option>-->
<!--                        <option value="PG">Papua New Guinea</option>-->
<!--                        <option value="PY">Paraguay</option>-->
<!--                        <option value="PE">Peru</option>-->
<!--                        <option value="PH">Philippines</option>-->
<!--                        <option value="PN">Pitcairn</option>-->
<!--                        <option value="PL">Poland</option>-->
<!--                        <option value="PT">Portugal</option>-->
<!--                        <option value="PR">Puerto Rico</option>-->
<!--                        <option value="QA">Qatar</option>-->
<!--                        <option value="RE">Réunion</option>-->
<!--                        <option value="RO">Romania</option>-->
<!--                        <option value="RU">Russian Federation</option>-->
<!--                        <option value="RW">Rwanda</option>-->
<!--                        <option value="BL">Saint Barthélemy</option>-->
<!--                        <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>-->
<!--                        <option value="KN">Saint Kitts and Nevis</option>-->
<!--                        <option value="LC">Saint Lucia</option>-->
<!--                        <option value="MF">Saint Martin (French part)</option>-->
<!--                        <option value="PM">Saint Pierre and Miquelon</option>-->
<!--                        <option value="VC">Saint Vincent and the Grenadines</option>-->
<!--                        <option value="WS">Samoa</option>-->
<!--                        <option value="SM">San Marino</option>-->
<!--                        <option value="ST">Sao Tome and Principe</option>-->
<!--                        <option value="SA">Saudi Arabia</option>-->
<!--                        <option value="SN">Senegal</option>-->
<!--                        <option value="RS">Serbia</option>-->
<!--                        <option value="SC">Seychelles</option>-->
<!--                        <option value="SL">Sierra Leone</option>-->
<!--                        <option value="SG">Singapore</option>-->
<!--                        <option value="SX">Sint Maarten (Dutch part)</option>-->
<!--                        <option value="SK">Slovakia</option>-->
<!--                        <option value="SI">Slovenia</option>-->
<!--                        <option value="SB">Solomon Islands</option>-->
<!--                        <option value="SO">Somalia</option>-->
<!--                        <option value="ZA">South Africa</option>-->
<!--                        <option value="GS">South Georgia and the South Sandwich Islands</option>-->
<!--                        <option value="SS">South Sudan</option>-->
<!--                        <option value="ES">Spain</option>-->
<!--                        <option value="LK">Sri Lanka</option>-->
<!--                        <option value="SD">Sudan</option>-->
<!--                        <option value="SR">Suriname</option>-->
<!--                        <option value="SJ">Svalbard and Jan Mayen</option>-->
<!--                        <option value="SZ">Swaziland</option>-->
<!--                        <option value="SE">Sweden</option>-->
<!--                        <option value="CH">Switzerland</option>-->
<!--                        <option value="SY">Syrian Arab Republic</option>-->
<!--                        <option value="TW">Taiwan, Province of China</option>-->
<!--                        <option value="TJ">Tajikistan</option>-->
<!--                        <option value="TZ">Tanzania, United Republic of</option>-->
<!--                        <option value="TH">Thailand</option>-->
<!--                        <option value="TL">Timor-Leste</option>-->
<!--                        <option value="TG">Togo</option>-->
<!--                        <option value="TK">Tokelau</option>-->
<!--                        <option value="TO">Tonga</option>-->
<!--                        <option value="TT">Trinidad and Tobago</option>-->
<!--                        <option value="TN">Tunisia</option>-->
<!--                        <option value="TR">Turkey</option>-->
<!--                        <option value="TM">Turkmenistan</option>-->
<!--                        <option value="TC">Turks and Caicos Islands</option>-->
<!--                        <option value="TV">Tuvalu</option>-->
<!--                        <option value="UG">Uganda</option>-->
<!--                        <option value="UA">Ukraine</option>-->
<!--                        <option value="AE">United Arab Emirates</option>-->
<!--                        <option value="GB">United Kingdom</option>-->
<!--                        <option value="US">United States</option>-->
<!--                        <option value="UM">United States Minor Outlying Islands</option>-->
<!--                        <option value="UY">Uruguay</option>-->
<!--                        <option value="UZ">Uzbekistan</option>-->
<!--                        <option value="VU">Vanuatu</option>-->
<!--                        <option value="VE">Venezuela, Bolivarian Republic of</option>-->
<!--                        <option value="VN">Viet Nam</option>-->
<!--                        <option value="VG">Virgin Islands, British</option>-->
<!--                        <option value="VI">Virgin Islands, U.S.</option>-->
<!--                        <option value="WF">Wallis and Futuna</option>-->
<!--                        <option value="EH">Western Sahara</option>-->
<!--                        <option value="YE">Yemen</option>-->
<!--                        <option value="ZM">Zambia</option>-->
<!--                        <option value="ZW">Zimbabwe</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!---->
<!--                </div class="login-box" >-->
<!---->
<!--                --><?php
//                if ($subscriptionid == 3)
//                {
//                ?>
<!--                    <div class="row">-->
<!--                        <div>-->
<!--                            <p style="font-family:'Century Gothic W01'; font-size:100%; color: #ff5722; text-align: center"><span>Payment option & Consent</span></p>-->
<!--                        </div>-->
<!--                        <p <br /></p>-->
<!--                        <div>-->
<!--                            <p style="font-family:'Century Gothic W01'; font-size:100%; color: #000000; text-align: center">By clicking the "PayPal" or "Visa" or "Mastercard" button or fill e-mail above with "facebook" button, you agree to our Terms of use, Privacy policy and Disclaimer<br /></p>-->
<!--                        </div>-->
<!--                        <br>-->
<!--                        <div style="text-align: center">-->
<!--                            <input name="paypal" type="image" src="--><?php //echo base_url(); ?><!--tiqsimg/paypal.png" alt="Paypal" />-->
<!--                            <input name="visamastercard" type="image" src="--><?php //echo base_url(); ?><!--tiqsimg/visamastercard.png" alt="Visa or Mastercard" />-->
<!--                        </div><br>-->
<!--                    </div>-->
<!--                --><?php
//                }
//                else
//                {
//                ?>
<!---->
<!--                <div class="row">-->
<!--                    <!---->
<!--                    <div class="col-xs-2">-->
<!--                        <div class="checkbox icheck">-->
<!--                           <label>-->
<!--                            <input type="checkbox"> Remember Me-->
<!--                          </label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    -->-->
<!---->
<!--                    <!-- <div class="col-xs-8"> -->-->
<!--                    <!-- <input type="submit" class="btn btn-primary btn-block btn-flat" value="Sign In" /> -->-->
<!--                    <div>-->
<!--                        <p style="font-family:'Century Gothic W01'; font-size:100%; color: #ff5722; text-align: center">-->
<!--                            <span>Your consent</span></p>-->
<!--                    </div>-->
<!--                    <p <br/></p>-->
<!--                    <div>-->
<!--                        <p style="font-family:'Century Gothic W01'; font-size:100%; color: #000000; text-align: center">-->
<!--                            By clicking the "Pay subscription" button or fill e-mail above with "facebook" button,-->
<!--                            you agree to our Terms of use, Privacy policy and Disclaimer<br/></p>-->
<!--                    </div>-->
<!--                    <br>-->
<!--                    <div style="text-align: center">-->
<!--                        <input type="submit" class="myButtonOrange" value="Pay subscription"/>-->
<!--                    </div>-->
<!--                    <br>-->
<!--                </div>-->
<!--                --><?php
//                }
//                ?>
<!---->
<!--<!--            <div class="social" center>-->-->
<!--<!--                <div class="or"; style="font-family:'Century Gothic W01'; font-size:100%; color: #000000; text-align: center"><span>Or fill e-mail above with</span></div>-->-->
<!--<!--                <a href="-->--><?////= base_url(); ?><!--<!--checkinsta"><button class="instagram"><i class="fa fa-instagram"></i></button></a>-->-->
<!--<!--                <a href="-->--><?////= base_url(); ?><!--<!--payfacebook"><button class="facebook"><img border="0" src="-->--><?php ////echo base_url(); ?><!--<!--tiqsimg/f_logo_RGB-Blue_250.png" alt="facebook" width="60" height="60" /></button></a>-->-->
<!--<!---->-->
<!--<!--                <button type="submit" class="facebook" formaction="-->--><?php ////echo base_url(); ?><!--<!--payfacebook">-->-->
<!--<!--                    <img border="0" src="-->--><?php ////echo base_url(); ?><!--<!--tiqsimg/f_logo_RGB-Blue_250.png" alt="facebook" width="60" height="60" />-->-->
<!--<!--                </button>-->-->
<!--<!---->-->
<!--<!--                <a href="-->--><?//////= base_url(); ?><!--<!--checkgoogle"><button class="google"><i class="fa fa-google-plus"></i></button></a>-->-->
<!--<!--            </div>-->-->
<!---->
<!--            </form>-->
<!--        </div><!-- /.login-box-body -->-->
<!--    </div><!-- /.login-box -->-->
<!--</div>-->
<!--<script src="--><?php //echo base_url(); ?><!--assets/bower_components/jquery/dist/jquery.min.js"></script>-->
<!--<script src="--><?php //echo base_url(); ?><!--assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
<!--</body>-->
<!--</html>-->
<?php
//    if(isset($_SESSION['error'])){
//        unset($_SESSION['error']);
//    }
//    if(isset($_SESSION['success'])){
//        unset($_SESSION['success']);
//    }
//    if(isset($_SESSION['message'])){
//        unset($_SESSION['message']);
//    }
//?>
