<div class="main-wrapper-nh">
	<div class="col-half width-650 background-blue height-100" style="margin-top: 30px">
		<div class="flex-column align-start">
			<div style="text-align:center">
				<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff;">
				<h2 class="heading"> <?php echo $this->language->tline('REGISTER AS AMBASADOR');?></h2>
				<?php include_once APPPATH . 'views/includes/sessionMessages.php' ?>
				<form method="post" onsubmit="return registerAmbasador(this)">
                <div>
						<p
                            style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center"
                        >
                            <?php echo $this->language->tline('Email');?>
						</p>
					</div>					
					<div class="form-group has-feedback">
						<input
							type="email"
							name="email"
							value="<?php echo $email ?>"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->tline('Your email');?>"
							data-form-check="1"
							data-error-message='Email is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div>
						<p
                            style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center"
                        >
                            <?php echo $this->language->tline('First name');?>
						</p>
					</div>
					<div class="form-group has-feedback">
						<input
							type="text"
							name="firstName"
							value="<?php echo $firstName ?>"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->tline('First name');?>"
							data-form-check="1"
							data-error-message='First name is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
                    <div>
						<p
                            style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center"
                        >
                            <?php echo $this->language->tline('Last name');?>
						</p>
					</div>
					<div class="form-group has-feedback">
						<input
							type="text"
							name="lastName"
							value="<?php echo $lastName ?>"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->tline('Last name');?>"
							data-form-check="1"
							data-error-message='Last name is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
                    <div class="form-group align-center mb-35 mt-50" >
                        <p>
                            <input
                                type="submit"
                                id="capsubmit"
                                class="button button-orange"
                                value="<?php echo $this->language->tline('Register');?>"
                                style="border: none"
                            />
                        </p>
                    </div>
				</form>
				<div class="row" style="text-align:center; padding:0px ">
					<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="125" height="45" />
				</div>
			</div>
		</div>
	</div>
	<div class="col background-blue" style="margin-left: 0px ;margin-right: 0px; padding: 0px; width: 100%; margin-top: 50px">
		<ul class="nav nav-tabs" style="border-bottom: none;background-color: #131e3a; margin-top: 10px;margin-bottom: 10px " role="tablist">
			<li class="nav-item">
				<!-- <a style="color: #efd1ba; border-radius: 50px; margin-left:10px" class="nav-link active" data-toggle="tab" href="#manual"> <i class="ti-pencil-alt"> </i> HOW TO REGISTER</a> -->
			</li>
		</ul>

		<div class="tab-content no-border" style="height: 90%; width: 100%">
			<div id="manual" class="tab-pane active" style="background: none; height: 100%;margin-left: 0px ;margin-right: 0px; width:100%">
				<embed src="<?php echo base_url(); ?>/assets/home/documents/NL-manual.pdf" height=100% width="100%">
			</div>
		</div>
	</div>
</div>
