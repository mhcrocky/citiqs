<?php
use \koolreport\core\Utility;
?>
<div id="<?php echo $this->name; ?>" class="date-range-picker form-control">
    <input id="<?php echo $this->name; ?>_start" name="<?php echo $this->name; ?>[]" type="hidden" />
    <input id="<?php echo $this->name; ?>_end" name="<?php echo $this->name; ?>[]" type="hidden" />
    <div style="position:relative;">
        <i class="glyphicon glyphicon-calendar"></i>
        <span></span>
        <b class="caret"></b>   
    </div>
</div>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = new DateRangePicker('<?php echo $this->name; ?>',<?php echo Utility::jsonEncode($options);?>);
    <?php
    if($this->clientEvents)
    {
        foreach($this->clientEvents as $eventName=>$function)
        {
        ?>
            <?php echo $this->name; ?>.on("<?php echo $eventName; ?>",<?php echo $function; ?>);
        <?php
        }
    }
    ?>
    <?php $this->clientSideReady();?>
});
</script>