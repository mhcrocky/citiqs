</div>
<!-- End Main Content -->
<footer>
    <div class="footer-area">
        <p>© Copyright 2018-<?php echo date("Y"); ?>. All right reserved.</p>
    </div>
</footer>
</div>
<script>
$(document).ready(function() {
    $('ul').attr('style', 'padding-left: 0px !important');
    var current_url = "<?php echo base_url(uri_string()); ?>";
    $('li a').each(function(index, element) {
        if ($(element).attr("href") == current_url) {
            $(element).addClass("dash-active");
            $(element).closest("ul").addClass("dash-active").addClass("in");
            $('.dash-active.in').parent("li").closest("ul").addClass("dash-active").addClass("in");
        }

    });



 
});

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
    if (!$_SESSION['payNlServiceIdSet']) { 
        include_once FCPATH . 'application/views/includes/payNlRegistration.php';
    }
    include_once FCPATH . 'application/views/includes/selectlanguage.php'; 
?>
</html>
