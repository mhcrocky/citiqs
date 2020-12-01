</div>
<!-- End Main Content -->
<footer>
    <div class="footer-area">
        <p>© Copyright 2018-<?php echo date("Y"); ?>. All right reserved.</p>
    </div>
</footer>
</div>

    <!-- bootstrap 4 js -->
    <script src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.slicknav.min.js"></script>
   

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>

    <!-- all line chart activation -->
    <script src="<?php echo base_url(); ?>assets/js/business_dashboard/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="<?php echo base_url(); ?>assets/js/business_dashboard/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="<?php echo base_url(); ?>assets/js/business_dashboard/plugins.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/business_dashboard/scripts.js"></script>

    <!-- custom users scripts -->
    <?php include_once FCPATH . 'application/views/includes/customJs.php'; ?>
    <?php include_once FCPATH . 'application/views/includes/alertifySessionMessage.php'; ?>
</html>
