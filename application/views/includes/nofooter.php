    <footer>
	</footer>
	<?php
        $this->load->view('includes/selectlanguage.php');
    ?>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/languageModal.js"></script>
    <?php include_once FCPATH . 'application/views/includes/jsGlobalVariables.php'; ?>
    <?php include_once FCPATH . 'application/views/includes/customJs.php'; ?>
    <?php include_once FCPATH . 'application/views/includes/alertifySessionMessage.php'; ?>
</body>
</html>
<?php
    if(isset($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
    if(isset($_SESSION['success'])) {
        unset($_SESSION['success']);
    }
    if(isset($_SESSION['message'])) {
        unset($_SESSION['message']);
    }
?>
