<div id="<?php echo $this->name; ?>" class="d3-waterfall" style="<?php echo ($this->width)?"width:$this->width;":""; ?><?php echo ($this->height)?"height:$this->height;":""; ?>"></div>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = new KoolReport.d3.Waterfall("<?php echo $this->name; ?>",<?php echo \koolreport\core\Utility::jsonEncode($settings); ?>);
    <?php echo $this->name; ?>.draw();
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