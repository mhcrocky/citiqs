<div id="<?php echo $this->name; ?>"></div>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = new KoolReport.d3.C3Chart(<?php echo \koolreport\core\Utility::jsonEncode($settings); ?>);
    <?php
    foreach ($this->clientEvents as $event=>$function) {
    ?>
        <?php echo $this->name; ?>.registerEvent("<?php echo $event; ?>",<?php echo $function; ?>);
    <?php
    }
    ?>
    <?php $this->clientSideReady(); ?>
});
</script>