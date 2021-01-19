<div style="text-align: center;" id="header-img" class="w-100" style="text-align:center">


    <div class="form-group has-feedback">
        <img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="250" height="auto" />
    </div>

</div>
<?php if($this->session->tempdata('tickets')):
        $tickets = $this->session->tempdata('tickets'); ?>
<div style="visibility: hidden;" class="form">
    <div class="w-100 p-2 text-right">
        <p class="h5 font-weight-bold" id="timer"></p>
        <br>
    </div>
    <?php if($this->session->has_userdata('event_date')): ?>
    <h4 class="font-weight-bold"><?php echo $this->session->userdata('event_date'); ?></h4>
    <?php endif; ?>
    <div style="border: 1px solid #c7c3b9" class="w-100">
        <?php foreach($tickets as $key => $ticket): ?>
        <?php if($key != 0): ?>
        <hr style="border: 1px solid #c7c3b9" class="w-100">
        <?php endif; ?>
        <label>Description: <?php echo $ticket['descript']; ?></label>
        <label>Quantity: <?php echo $ticket['quantity']; ?></label>
        <label>Amount: €<?php echo number_format($ticket['amount'], 2, '.', ''); ?></label>
        <?php endforeach; ?>
    </div>
    <div class="w-100 p-2 text-right">
        <br>
        <p class="h5 font-weight-bold">
            <strong>Total: €<?php echo $this->session->tempdata('total'); ?></strong>
        </p>
    </div>
</div>
<div class="w-100 bottom-bar">
    <a href="<?php echo base_url(); ?>events/pay" id="next" class="btn btn-success btn-block pt-5"
        type="submit">NEXT</a>
</div>
<?php endif; ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script>
var countDownDate = moment("<?php echo $this->session->tempdata('exp_time'); ?>");


var x = setInterval(function() {

    var now = moment();

    var distance = countDownDate - now;

    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("timer").innerHTML =
        "Expiration time: " + addZero(minutes) + ":" + addZero(seconds) + "";
    $('.form').css('visibility', 'visible');

    if (distance < 0) {
        clearInterval(x);
        document.getElementById("timer").innerHTML = "EXPIRED";
    }
}, 1000);

function addZero(num) {
    let i = parseInt(num);
    if (i < 10) {
        num = "0" + num;
        return num;
    }
    return num;
}
</script>