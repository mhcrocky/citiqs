</div>
<!-- End Main Content -->



<!-- Copy Agenda Booking Url Modal -->
<div class="modal fade" id="copyAgendaBookingUrlModal" tabindex="-1" role="dialog" aria-labelledby="copyAgendaBookingUrlModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="overflow: auto !important;" class="modal-body">
                <div style="flex-wrap: unset;-ms-flex-wrap: unset;" class="d-flex row text-center align-items-center">
                    <div class="col-md-9 text-center"><?php echo base_url(); ?>agenda_booking/<?php echo $this->session->userdata('userShortUrl'); ?></div>
                    <div class="col-md-3 text-left">
                        <button class="btn btn-clear text-primary" onclick="copyToClipboard('<?php echo base_url(); ?>agenda_booking/<?php echo $this->session->userdata('userShortUrl'); ?>')">Copy URL</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Copy Booking Agenda Url Modal -->
<div class="modal fade" id="copyBookingAgendaUrlModal" tabindex="-1" role="dialog" aria-labelledby="copyBookingAgendaUrlModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="overflow: auto !important;" class="modal-body">
                <div style="flex-wrap: unset;-ms-flex-wrap: unset;" class="d-flex row text-center align-items-center">
                    <div class="col-md-9 text-center"><?php echo base_url(); ?>booking_agenda/<?php echo $this->session->userdata('userShortUrl'); ?></div>
                    <div class="col-md-3 text-left">
                        <button class="btn btn-clear text-primary" onclick="copyToClipboard('<?php echo base_url(); ?>booking_agenda/<?php echo $this->session->userdata('userShortUrl'); ?>')">Copy URL</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<footer>
    <div class="footer-area">
        <p>© Copyright 2018-<?php echo date("Y"); ?>. All right reserved.</p>
    </div>
</footer>
</div>
<script> introJs().start() </script>
<script>
(function() {
    $('ul').attr('style', 'padding-left: 0px !important');
    var current_url = "<?php echo base_url(uri_string()); ?>";
    var events_url = "<?php echo base_url(); ?>events";
    
    $('li a').each(function(index, element) {
        if ($(element).attr("href") == current_url) {
            $(element).addClass("dash-active");
            $(element).closest("ul").addClass("dash-active").addClass("in");
            $('.dash-active.in').parent("li").closest("ul").addClass("dash-active").addClass("in");
            return ;
        }

    });

    if($('.dash-active').length == 0){
        if(current_url.includes(events_url)){
            $("a[href='"+events_url+"']").addClass("dash-active");
            $("a[href='"+events_url+"']").closest("ul").addClass("dash-active").addClass("in");
            $('.dash-active.in').parent("li").closest("ul").addClass("dash-active").addClass("in");
            return ;
        }
    }

}());

window.copyToClipboard = function(copyText) {
    var textarea = document.createElement('textarea');
    textarea.textContent = copyText;
    document.body.appendChild(textarea);
    var selection = document.getSelection();
    var range = document.createRange();
    range.selectNode(textarea);
    selection.removeAllRanges();
    selection.addRange(range);
    console.log('copy success', document.execCommand('copy'));
    selection.removeAllRanges();
    document.body.removeChild(textarea);

}
</script>
<!-- bootstrap 4 js -->
<script src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.slicknav.min.js"></script>
<?php include_once FCPATH . 'application/views/includes/customJs.php'; ?>


<!-- all line chart activation -->
<script src="<?php echo base_url(); ?>assets/js/business_dashboard/line-chart.js"></script>
<!-- all pie chart -->
<script src="<?php echo base_url(); ?>assets/js/business_dashboard/pie-chart.js"></script>
<!-- others plugins -->
<script src="<?php echo base_url(); ?>assets/js/business_dashboard/plugins.js"></script>
<script src="<?php echo base_url(); ?>assets/js/business_dashboard/scripts.js"></script>


<?php
    include_once FCPATH . 'application/views/includes/customJs.php';
    include_once FCPATH . 'application/views/includes/alertifySessionMessage.php'; 
    if (isset($_SESSION['payNlServiceIdSet']) && !$_SESSION['payNlServiceIdSet']) {
        include_once FCPATH . 'application/views/includes/payNlRegistration.php';
    }
    include_once FCPATH . 'application/views/includes/selectlanguage.php'; 
?>
</html>
