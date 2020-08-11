<?php use \koolreport\core\Utility;?>

<?php
if($this->icon)
{
?>
    <div class="input-group date" id="<?php echo $this->name; ?>" data-target-input="nearest">
        <input type="text" class="form-control datetimepicker-input" data-target="#<?php echo $this->name; ?>"/>
        <div class="input-group-append" data-target="#<?php echo $this->name; ?>" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="<?php echo $this->icon; ?>"></i></div>
        </div>
    </div>
<?php    
}
else
{
?>
    <input id='<?php echo $this->name; ?>' type='text' class="form-control" />
<?php    
}
?>
<input name='<?php echo $this->name; ?>' value="<?php echo $this->value; ?>" type='hidden'/>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = $('#<?php echo $this->name; ?>');
    let name = <?php echo $this->name; ?>;
    <?php echo $this->name; ?>.datetimepicker(<?php echo Utility::jsonEncode($settings); ?>);
    <?php echo $this->name; ?>.on("change.datetimepicker",function(e){
        $('input[name=<?php echo $this->name; ?>]').val(e.date.format('YYYY-MM-DD HH:mm:ss'));
        _linkedpicker.fire('<?php echo $this->name; ?>',e.date);
    });
    <?php
    if($this->clientEvents)
    {
        foreach($this->clientEvents as $eventName=>$function)
        {
        ?>
            <?php echo $this->name; ?>.on('<?php echo $eventName ?>.datetimepicker',<?php echo $function; ?>);
        <?php
        }
    }
    ?>

    <?php
        if($this->minDate && strpos($this->minDate,"@")===0)
        {
        ?>
            _linkedpicker.register('<?php echo str_replace('@','',$this->minDate); ?>',function(date){
                $('#<?php echo $this->name; ?>').datetimepicker('minDate',date);
            });
        <?php    
        }
    ?>

    <?php
        if($this->maxDate && strpos($this->maxDate,"@")===0)
        {
        ?>
            _linkedpicker.register('<?php echo str_replace('@','',$this->maxDate); ?>',function(date){
                $('#<?php echo $this->name; ?>').datetimepicker('maxDate',date);
            });
        <?php    
        }
    ?>
    _linkedpicker.fire('<?php echo $this->name; ?>',moment('<?php echo $this->value; ?>'));

    name.defaultValue = name.datetimepicker('viewDate');
    name.reset = function() {
        name.datetimepicker('date', name.defaultValue);
    };
    
    <?php $this->clientSideReady();?>
});
</script>