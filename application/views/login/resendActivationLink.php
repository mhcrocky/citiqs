<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="main-wrapper">
	<div class="col-half background-green height-100">
		<div class="flex-column align-start">
            <?php include_once FCPATH . 'application/views/includes/sessionMessages.php'; ?>
			<div style="text-align:left">
                <!-- <p class="login-box-msg" style="font-weight: bold font-family:"Century Gothic" font-size: larger">Login</p> -->
                <p  style="font-family:'caption-bold'; font-size:300%; text-align: left; color: white">BUYER ACTIVATE ACCOUNT LINK</p>
                <p style="color:white">
                    WITH YOUR E-MAIL ADDRESS KNOW BY TIQS, YOU CAN REQUEST A NEW BUYER ACTIVATE ACCOUNT LINK
                </p>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>

                <form action="<?php echo base_url(); ?>login/requestNewActivationLink" method="post">
                    <div class="form-group has-feedback">
                        <input
                            type="email"
                            class="form-control"
                            placeholder="Email"
                            name="login_email"
                            style="font-family: 'caption-light', caption-light ;border-radius: 50px"
                            required
                        />
                    </div>

                    <div>
                        <div style="text-align: left">
                            <input type="submit" class="button button-orange" value="GET A NEW ONE..." />
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-xs-8">
                    </div>
				</div>
            </div>
        </div><!-- /.login-box -->
	</div>

	<div class="col-half background-blue timeline-content">
		<div class="timeline-block background-orange">
			<div class="timeline-text">
				<div class="timeline-heading">
					<h2 style="font-weight:bold; font-family: caption-bold">LOGIN.</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">LOGIN INTO YOUR PERSONAL ACCOUNT.</p>
				<div class="flex-column align-space">
					<div style="text-align:center">
						<a href="login" class="button button-orange mb-25">LOGIN</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-orange-light">
			<div class="timeline-text">
				<div class='timeline-heading'>
					<h2 style="font-weight:bold; font-family: caption-bold">REGISTER AN OTHER ITEM.</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">USE THIS BUTTON TO REGISTER AN OTHER ITEM</p>
				<div class="flex-column align-space">
					<div style="text-align:center">
						<a href="check" class="button button-orange mb-25">REGISTER</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-blue">
			<div class="timeline-text">
				<div class="timeline-heading">
					<h2 style="font-weight:bold; font-family: caption-bold">QUESTIONS</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">YOU CAN ALWAYS CONTACT US WHEN HAVING A QUESTION ABOUT YOUR ORDER. PLEASE USE THE BUTTON BELOW</p>
				<!--<span class="cd-date">Feb 18</span>-->
				<div class="flex-column align-space">
					<div style="text-align:center">
						<a href="" target="_blank" class="button button-orange mb-25">CONTACT SALES</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
	</div>
	<!-- time-line -->
	<!-- end col half -->
</div>
