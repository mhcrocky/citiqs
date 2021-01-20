<div style="text-align: center;" id="header-img" class="w-100" style="text-align:center">


    <div class="form-group has-feedback">
        <img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="250" height="auto" />
    </div>

</div>




<?php if($this->session->tempdata('tickets')):
        $tickets = $this->session->tempdata('tickets'); ?>
<div style="visibility: hidden;" class="limiter">
    <div class="container-login100">
        <div style="text-align: center;" class="wrap-login100">
            <div style="background: #fff !important;">
                <img style="width:100%" class="image-responsive"
                    src="<?php echo base_url() ?>assets/images/events/<?php echo $this->session->userdata("eventImage"); ?>">
            </div>
            <div class="login100-form-title">
                <span class="login100-form-title-1">
                    <?php if($this->session->has_userdata('event_date')): ?>
                    <h4 class="font-weight-bold"><?php echo $this->session->userdata('event_date'); ?></h4>
                    <?php endif; ?>
            </div>
            <?php foreach($tickets as $key => $ticket): ?>
            <?php if($key != 0): ?>
            <hr style="border: 1px solid #c7c3b9" class="w-100">
            <?php endif; ?>

            <p class="mb-3" style="text-align: right;padding: 10px;">
                <strong id="timer"></strong>
            </p>
            <p>
                <strong>Description: <?php echo $ticket['descript']; ?></strong>
            </p>
            <p>
                <strong>Quantity: <?php echo $ticket['quantity']; ?></strong>
            </p>
            <p>
                <strong>Amount: €<?php echo number_format($ticket['amount'], 2, '.', ''); ?></strong>
            </p>

            <?php endforeach; ?>

            <p style="text-align: right;padding: 10px;">
                <strong>Total: €<?php echo $this->session->tempdata('total'); ?></strong>
            </p>


            <div class="w-100 bottom-bar">
                <a style="height: 45px;font-size: 18px;" href="<?php echo base_url(); ?>events/pay" id="next"
                    class="btn btn-warning btn-block pt-5" type="submit">
                    <strong>NEXT</strong>

                </a>
            </div>

            <!--
                <div class="flex-sb-m w-full p-b-30">
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                        <label class="label-checkbox100" for="ckb1">
                            
                        </label>
                    </div>
                    <div>
                        <a href="#" class="txt1">
                            
                        </a>
                    </div>
                </div>
                -->


        </div>
    </div>
</div>

<?php endif; ?>