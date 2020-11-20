<?php use \koolreport\core\Utility;?>

<?php
if($this->icon)
{
?>
    <div id='<?php echo $this->name; ?>' class='input-group date'>
        <input type='text' class="form-control" />
            <span class="input-group-addon">
                <span class="<?php echo $this->icon; ?>"></span>
            </span>
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
    name.datetimepicker(<?php echo Utility::jsonEncode($settings); ?>)
    .on('dp.change',function(e){
        $('input[name=<?php echo $this->name; ?>]').val(e.date.format('YYYY-MM-DD HH:mm:ss'));
        _linkedpicker.fire('<?php echo $this->name; ?>',e.date);
    });

    <?php
    if($this->clientEvents)
    {
        foreach($this->clientEvents as $eventName=>$function)
        {
        ?>
        $('#<?php echo $this->name; ?>').on('dp.<?php echo $eventName ?>',<?php echo $function; ?>);
        <?php
        }
    }
    ?>

    <?php
        if($this->minDate && strpos($this->minDate,"@")===0)
        {
        ?>
            _linkedpicker.register('<?php echo str_replace('@','',$this->minDate); ?>',function(date){
                $('#<?php echo $this->name; ?>').data("DateTimePicker").minDate(date);
            });
        <?php    
        }
    ?>

    <?php
        if($this->maxDate && strpos($this->maxDate,"@")===0)
        {
        ?>
            _linkedpicker.register('<?php echo str_replace('@','',$this->maxDate); ?>',function(date){
                $('#<?php echo $this->name; ?>').data("DateTimePicker").maxDate(date);
            });
        <?php    
        }
    ?>
    _linkedpicker.fire('<?php echo $this->name; ?>',moment('<?php echo $this->value; ?>'));

    name.defaultValue = name.data("DateTimePicker").viewDate();
    name.reset = function() {
        name.data("DateTimePicker").date(name.defaultValue);
    };
    
    <?php $this->clientSideReady();?>
});
</script>