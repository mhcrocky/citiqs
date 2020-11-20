<textarea id="<?php echo $this->name; ?>" name="<?php echo $this->name; ?>" <?php
    foreach($this->attributes as $name=>$value)
    {
        echo " $name='$value' ";
    }
?>><?php echo $this->value; ?></textarea>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = $("#<?php echo $this->name; ?>");
    <?php
    foreach($this->clientEvents as $name=>$function)
    {
    ?>
        <?php echo $this->name; ?>.on('<?php echo $name ?>',<?php echo $function; ?>);
    <?php
    }
    ?>
    var name = <?php echo $this->name; ?>;
    name.reset = function() {
        name[0].value = name[0].defaultValue;
    };
    <?php $this->clientSideReady();?>
});
</script>