<script type="text/javascript" src="--><?php //echo base_url(); ?><!--assets/js/iframeResizer.min.js"></script>
<div class="main-wrapper" align="center">
    <div class="col-half" align="left">
        <div class=" background-yankee height-50">
            <div class="width-650">
                <h2 style="color:#ffffff" class="heading"><?php echo $this->language->line("PRINTQR-1000",'PRINT YOUR OWN TIQS-TAG STICKERS');?></h2>
                <a style="color:#ffffff" class='how-we-works-link' href="<?php echo base_url(); ?>howitworksconsumer"><?php echo $this->language->line("PRINTQR-1100",'HOW IT WORKS');?></a>
                <p style="color:#ffffff" class="text-content mb-50"><?php echo $this->language->line("PRINTQR-1110",'LOST BY YOU, <br> RETURNED BY US');?></p>
            </div>
        </div>
        <div class=" background-yellow height-50">
            <div class="width-650">
                <h2 class="heading mb-35"><?php echo $this->language->line("PRINTQR-1111",'LOGIN.');?></h2>
                <form action="<?php echo base_url(); ?>loginMe" method="post" class='homepage-form'>
                    <p>
                        <?php echo $this->language->line("PRINTQR-1112",'Use your e-mail to login');?>
                    </p>
                    <div  align="center" >
                        <input type="email" class="form-control" placeholder="<?php echo $this->language->line("PRINTQR-1113",'Your e-mail');?>" name="email"  required />
                    </div>
					<div align="center" style="margin-top: 10px">

                    <p>
                        <?php echo $this->language->line("PRINTQR-1114",'Password');?>
                    </p>
					</div>
                    <div >
                        <input type="password" class="form-control"placeholder="<?php echo $this->language->line("PRINTQR-1115",'Your Password');?>" name="password"  required />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <br>
                    <div style="text-align: center; ">
                        <input type="submit" class="button button-apricot" value="<?php echo $this->language->line("PRINTQR-1116",'LOGIN');?>" style="border: none"/>
                    </div>
                </form>
            </div>
		</div>
    </div><!-- end col half -->
	<div class="col-half background-orange height-100 align-center">
		<?php if (isset($iframeUrl) && filter_var($iframeUrl, FILTER_VALIDATE_URL)) { ?>
			<iframe align="center" src="<?php echo $iframeUrl; ?>" style="width: 660px; height:  760px; padding: 10px" frameborder="0" ></iframe>
		<?php } ?>
	</div>
</div>
