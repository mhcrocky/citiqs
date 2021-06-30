<!DOCTYPE html>
<html>
  <body>
    <div class="login-box" style="margin-top: 120px">
		<!--      <div class="login-logo">-->
		<!--          <img border="0" src="--><?php //echo base_url(); ?><!--assets/home/images/tiqslogonew.png" alt="tiqs" width="125" height="auto" />-->
		<!--      </div> -->
      <div class="login-box-body" style="margin-top: 120px">
        <?php $this->load->helper('form'); ?>
          <div class="login-box-body"style="margin-top: 120px">
              <p  style="font-family:campton-bold; font-size:300%; text-align: center">RESET PASSWORD</p>
              <?php $this->load->helper('form'); ?>
              <?php echo $this->session->flashdata('fail'); ?>
              <div class="row">
                  <div class="col-md-12" id="mydivs">
                      <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                  </div>
              </div>
        <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error');
        if($error)
        {
            ?>
            <div id="mydivs1">
                <div class="alert alert-danger alert-dismissable" id="mydivs">
                    <button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>
                </div>
            </div>

<!--            <script>-->
<!--                setTimeout(function() {-->
<!--                    $('#mydivs1').hide('fade');-->
<!--                }, 5000);-->
<!--            </script>-->

        <?php }

        $success = $this->session->flashdata('success');
        if($success)
        {
            ?>
            <div class="alert alert-success alert-dismissable" id="mydivs2">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $success; ?>
            </div>
<!--            <script>-->
<!--                setTimeout(function() {-->
<!--                    $('#mydivs2').hide('fade');-->
<!--                }, 5000);-->
<!--            </script>-->
        <?php } ?>
        <form action="<?php echo base_url(); ?>createPasswordUser" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" readonly required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <input type="hidden" name="activation_code"  value="<?php echo $activation_code; ?>" required />
          </div>
          <hr>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Confirm Password" name="cpassword" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
              <br>
              <div style="text-align: center">
                  <input type="submit" class="myButtonOrange" value="Reset" />
              </div>
          </div>
        </form>
<!--              <br>-->
<!--              <a href="--><?php //echo base_url() ?><!--login/forgotPassword" style="font-family:'Century Gothic' " >Forgot Password</a><br>-->
          </div><!-- /.login-box-body -->
      </div><!-- /.login-box -->

        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
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
